<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Category;
use App\Comment;
use App\Post;
use DB;

class PageController extends Controller
{
    public function index(Request $request){
    	if($request->cat_id){
			$posts = Post::where('cat_id', $request->cat_id)->paginate(5);
    	}elseif($request->created_at){
    		$posts = Post::where('created_at', $request->created_at)->paginate(5);
    	}else{
			$posts = Post::where('status','1')->paginate(5);
    	}
    	$categories = Category::all();
    	return view('home', compact('posts','categories'));
    }
         /* to check Valid Email or not!*/
    public function verifyEmail(Request $request)
    {
    	if (! $request->hasValidSignature()) {
	        abort(401);
	    }
	    auth()->login(User::whereEmail($request->email)->first());
	    $update = User::whereEmail($request->email)->first();
	    $mytime = Carbon::now();
        $currentDate =  $mytime->toDateTimeString();
	    DB::update('update users set email_verified_at = ? where email = ?',[$currentDate,$update->email]);
	    return redirect()->route('users.dashboard');
    }
    /* To Change password*/

   public function verifyLoginEmail(Request $request)
    {
    	if (! $request->hasValidSignature()) {
	        abort(401);
	    }
	    $user = User::whereEmail($request->email)->first();
	    $user->password_change_verify_at = now();
	    $user->save();

	   return redirect()->route('users.changepassView');
    }
    public function searchPost(Request $request)
    {
    	if ($request->get('searchContent') != '') {
    		$posts = Post::where('title', 'like', '%'. $request->get('searchContent') . '%')->get();
    	}else{
    		$posts = Post::get();
    	}

    	$html = '';
    	foreach ($posts as $post) {
    		$html .= '<div class="card mb-4">
	                 <img class="card-img-top" src="'. asset('upload/' . $post->files) .'" alt="Card image cap">
					<div class="card-body">
						<h2 class="card-title">'. $post->title .'</h2>
						<p class="card-text">'. \Str::limit(strip_tags($post->descripton), 1000) .'</p>
						<a href="#" class="btn btn-primary">Read More &rarr;</a>
					</div>
					<div class="card-footer text-muted">
						Posted on '. $post->created_at->diffForHumans() .' | '. $post->created_at->format('F d, Y') . '  by
						<a href="#"></a>
						<small>Category</small>
					</div>
    		</div>';
    	}

    	return response()->json($html);
    }
}
