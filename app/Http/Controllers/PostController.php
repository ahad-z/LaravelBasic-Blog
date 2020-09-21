<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$posts = Post::all();
    	$categories = Category::all();
        return view('pages.posts.index',compact('categories','$posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    		'title' => 'required',
    		'cat_id'=> 'required',
    		'descripton' => 'required',
    	]);

    	$postData = ['user_id' => auth()->id()];
        $dom = new \DomDocument();

        $dom->loadHtml($request->descripton, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
           $data = $img->getAttribute('src');
           list($type, $data) = explode(';', $data);
           list(, $data)      = explode(',', $data);
           $data = base64_decode($data);

           // data:image/png;
           // data:image/png
           // image/png
           $nameOfImage = time() . '.' . mime2ext(str_replace(';', '', str_replace('data:', '', $type)));
           \Storage::disk('public_path')->put('upload/' . $nameOfImage, $data);
           if ($k === 0) {
           		$postData['files'] = $nameOfImage;
           }
           $img->removeAttribute('src');
           $img->setAttribute('src', $nameOfImage);
        }
        $postData['descripton'] = $dom->saveHTML();
    	try {
    		Post::create(array_merge( $request->except('_token', 'files'), $postData ));
    		return redirect()->back()->with('success','Post submitted successfully ,Wait for approval');
    	} catch (Exception $e) {
    		return redirect()->back()->with('danger',$e->getMessage());
    	}
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::find($id);
        $posts->delete();
        return redirect()->back()->with('success', 'post Delete successfully');
    }

   public function adminSeePost()
   {
   		$posts = Post::paginate(2);
   		return view('admin.posts.index', compact('posts'));
   }
   public function postStatus($id,$status)
   {
   		$post = Post::find($id);
   		$post->status = $status;
   		$post->save();
   		return ['status' => true];
   }
   public function adminSearchPost(Request $request)
   {
		if($request->get('searchContent') !== ''){
			$posts  = Post::where('title', 'LIKE', '%' . $request->get('searchContent') . '%')->get();
		}else{
			$posts = Post::get();
		}

	   	$html = '';
	   	foreach ($posts as $key => $post) {
	   		$isChecked =  $post->status ? 'checked' : '';

	   		$html .= '<tr>
					<th scope="row">'. ($key) .'</th>
					<td>'. $post->title .'</td>
					<td>
						<img style="height:100px;width: 100px;" class="card-img-top rounded-circle" src="'. asset('upload/' . $post->files) .'" alt="Card image cap">
						'. strip_tags($post->descripton) .'
					</td>
					<td>'. $post->title .'</td>
					<td>'. $post->created_at->diffForHumans() .'</td>
					<td>
						<input '. $isChecked .' class="postStatus" type="checkbox" data-toggle="toggle" data-on="Approve" data-off="UnApprove" data-id="' . $post->id . '">
					</td>
					<td>
						<form action="'. route('posts.destroy', $post->id) .'" method="post">
							<input type="hidden" name="_token" value="'. csrf_token() .'">
							<input type="hidden" name="_method" value="DELETE">
                            <button onclick="return confirm(`Are u sure!`)" type="submit" class="btn btn-danger btn-sm">Delete</button>
                         </form>
					</td>
				</tr>';

	   	}
	   return response()->json($html);
   }
   public function searchUsers (Request $request)
   	{
   		if($request->get('searchContent') !== ''){
   		    $users = User::where('name', 'like', '%' . $request->searchContent . '%' )->get();
   		}else{
   			$users = User::get();
   		}

   		$html = '';
   		$modals = '';
   		foreach ($users as $key => $user) {
   			$editUser_id = '#edituser_'.$user->id;
   			$html .= '<tr>
						<td> ' . ($key) .'</td>
						<td> ' . $user->name .'</td>
						<td> ' . $user->email .'</td>
						<td> ' . ucfirst($user->type) .'</td>
						<td>
							<div class="btn-group">
							   <a href="#" class="btn btn-info btn-sm" data-target="'.$editUser_id.'" data-toggle="modal">Edit</a>
							   <form action="'. route('users.destroy', $user->id) .'" method="post">
							   		<input type="hidden" name="_token" value="'. csrf_token() .'">
								    <input type="hidden" name="_method" value="DELETE">
                                    <button onclick="return confirm(`Are u sure!`)" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
							</div>
						</td>
					</tr>';
			$modals .= '
				<div class="modal fade" id="edituser_'. $user->id .'">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Update Users</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>
								</button>
							</div>
							<div class="modal-body">
								<form class="form-group" method="POST" action="' . route('users.update', $user->id) .'">
									<input type="hidden" name="_method" value="PUT">
									<input type="hidden" name="_token" value="'. csrf_token() .'">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" class="form-control" name="name" required="" value="' . $user->name .'">
									</div>
									<div class="form-group">
										<label for="email">Email</label>
										<input type="email" class="form-control" name="email" required="" value="' . $user->email .'">
									</div>
									<div class="form-group">
										<label for="category_id">User Type</label>
										<select class="form-control" name="type">
											<option value="user"'. ($user->type == 'user'  ? 'selected'  : '') .'>User</option>
											<option value="admin"'. ($user->type == 'admin' ? 'selected' : '') .'>Admin</option>
										</select>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Update</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			';
   		}
   		if(count($users) === 0 ){
   			return response(false);
   		}
      	return response()->json([$html, $modals]);
   	}
}
