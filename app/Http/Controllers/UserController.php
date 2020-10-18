<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\TestingMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('pages.registration');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('pages.login');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		 $request->validate([
			'name'  =>'required|min:5|max:10',
			'email' => 'required|min:5|max:100|email|unique:users',
			'password' => 'required|min:8|max:10',
			'c_password' =>'required|same:password',
		]);

		try {
			User::create(array_merge(
				$request->except('_token', 'password','c_password'),
				[
					'password' => bcrypt($request->password)
				]
			));

                  /* for create url so that we can send mail with veryfication link */
			$verURL = \URL::temporarySignedRoute(
			    'verifyEmail', now()->addMinutes(5), ['email' => $request->email]
			);
			Mail::to($request->email)->send(new TestingMail($verURL));
			return redirect()->back()->with('success', 'Your verification link sent your mail.');
		} catch (\Exception $e) {

			return redirect()->back()->with('danger', $e->getMessage());
		}

	}
	public function login(Request $request)
	{

		$verified = User::whereEmail($request->email)->where('email_verified_at', '!=', NULL)->first();
		$credentials = $request->except(['_token']);
		if($verified){
			if (auth()->attempt($credentials)) {
				return redirect()->route('users.dashboard');
			}else{
				return redirect()->back()->with('danger',"Sorry Your mail or password Doesn't Find");
			}
		}else{
			return redirect()->back()->with('danger',"Your account Doesn't verified!");
		}
	}
	 public function logout()
	{
        Session::flush();
        Auth::logout();
        return redirect()->route('users.create');
    }

	public function adminDashboard(){

		return view('admin.dashboard');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		try {
			$user = User::find($id);
			$user->update($request->except('_token','roles'));
			$user->syncRoles($request->roles);
			return redirect()->back()->with('success','User update successfully!');

		} catch (Exception $e) {
			return redirect()->back()->with('danger',$e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		$user->delete();
		return redirect()->back()->with('danger','User delete successfully');
	}

	public function passwordView()
	{
		return view('pages.forgetPassword');
	}

	public function sendVerification(Request $request)
	{
		$ceckEmail = User::whereEmail($request->email)->first();

		if($ceckEmail){

			$verURL = \URL::temporarySignedRoute(
			    'verifyLoginEmail', now()->addMinutes(5), ['email' => $request->email]
		);
		Mail::to($request->email)->send(new TestingMail($verURL));

			return redirect()->back()->with('success', 'Your Reset password link has been sent your mail.');

		}else{
			return redirect()->back()->with('danger', 'Sorry Your Email not found.');
		}
	}
	public function changepassView()
	{
		return view('pages.changePass');

	}
	public function updatePass(Request $request)
	{
		$request->validate([
			'email'      => 'required|email',
			'password'   => 'required|min:8|max:10',
			'c_password' =>'required|same:password'
		]);
		$checkEmail      = User::whereEmail($request->email)->first();
		$checkPassVerify = User::whereEmail($request->email)->where('password_change_verify_at', '!=', NULL)->first();
		$encyprtPassword = bcrypt($request->password);
		if($checkEmail){
			if($checkPassVerify){
				 DB::update('update users set password = ? where email = ?',[$encyprtPassword,$request->email]);
	            return redirect()->back()->with('success','password change successfully!');
			}else{
			    return redirect()->back()->with('danger','Sorry Your password link not verified');
			}

		}else{
			return redirect()->back()->with('danger','Sorry Your Email not Found');
		}


	}
	public function usersIndex()
	{
		$users = User::paginate(50);
		$roles = Role::all();
		return view('admin.users.index',compact('users', 'roles'));

	}
	public function usersCreate(Request $request)
	{

		$mytime = Carbon::now();
	    $currentDate = $mytime->toDateTimeString();
	    

		try {
			$user = User::create(array_merge(
				$request->except('_token','password', 'roles'),
				[
					'password'          => bcrypt($request->password),
					'email_verified_at' => $currentDate
			    ]
			));

			if($request->roles){
		   		$user->assignRole($request->roles);
		    }
		   return redirect()->back()->with('success','User Added successfully!');

		} catch (Exception $e) {
			  return redirect()->back()->with('danger','Something Went Wrong!');
		}

	}
	public function github()
	{
		//send the user to github
		return Socialite::driver('github')->redirect();


	}
	public function githubRedirect()
	{
		try {
			// get back form github
			$socialUser = Socialite::driver('github')->user();
			$user = User::where('email',$socialUser->getEmail())->first();
			if($user){
				Auth::login($user,true);
				return redirect('BasicRecap/admin/users/dashboard');
			}else{
				$user = User::create([
					'name' => $socialUser->getNickname(),
					'email' => $socialUser->getEmail(),
					'password' => Hash:: make(Str::random(24))
				]);
				Auth::login($user,true);
				return redirect('BasicRecap/admin/users/dashboard');
			}

		}catch (\Exception $e) {
			dd($e);
			return redirect('BasicRecap/admin/users/create');
		}

	}
	public function facebook()
	{
		// We send user to facebook
		return Socialite::driver('facebook')->redirect();

	}
	public function facebookRedirect()
	{
		try {
			// get back form facebook
			$socialUser = Socialite::driver('facebook')->user();
			$user = User::whereEmail($socialUser->getEmail())->first();
			$name = $socialUser->getName();
			$nickName = $socialUser->getNickname();

			if($name){

			}else{

				$name = $nickName;
			}

			if($user){
				Auth::login($user,true);
				return redirect('BasicRecap/admin/users/dashboard');
			}else{
				$user = User::create([
					'name' =>$name,
					'email' => $socialUser->getEmail(),
					'password' => Hash:: make(Str::random(24))
				]);
				Auth::login($user,true);
				return redirect('BasicRecap/admin/users/dashboard');
			}

		}catch (\Exception $e) {
			dd($e);
			return redirect('BasicRecap/admin/users/create');
		}


	}
	public function google()
	{
		// We send user to facebook
		return Socialite::driver('google')->redirect();

	}
	public function googleRedirect()
	{
		try {
			// get back form facebook
			$socialUser = Socialite::driver('google')->user();
			$user = User::whereEmail($socialUser->getEmail())->first();
			$name = $socialUser->getName();
			$nickName = $socialUser->getNickname();

			if($name){

			}else{

				$name = $nickName;
			}

			if($user){
				Auth::login($user,true);
				return redirect('BasicRecap/admin/users/dashboard');
			}else{
				$user = User::create([
					'name' =>$name,
					'email' => $socialUser->getEmail(),
					'password' => Hash:: make(Str::random(24))
				]);
				Auth::login($user,true);
				return redirect('BasicRecap/admin/users/dashboard');
			}

		}catch (\Exception $e) {
			dd($e);
			return redirect('BasicRecap/admin/users/create');
		}

	}


}
