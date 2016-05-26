<?php
namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller 
{
	public function getDashboard()
	{
		$posts = Post::orderBy('created_at', 'desc')->get();
		return view('dashboard', ['posts' => $posts]);
	}
	public function postCreatePost(Request $request) 
	{
		$this->validate($request, [
			'body' => 'required|max:1000'
			]);
		$post = new Post();
		$post->body = $request['body'];
		$message = "There was an error";
		if($request->user()->posts()->save($post)) {
			$message = 'Post Successfully created';
		}
		return redirect()->route('dashboard')->with(['message' => $message]);
	}

	public function getDeletePost($post_id) 
	{
		//$post = Post::find($post_id)->first();
		$post = Post::where('id', $post_id)->first();

		if (Auth::user() != $post->user) {
			return redirect()->back();
		}
		$post->delete();
		return redirect()->route('dashboard')->with(['message' => 'Successfully Deleted']);
	}

	public function postEditPost(Request $request) 
	{
		$this->validate($request, [
			'body' => 'required'
			]);

		$post = Post::find($request['postId']);
		$post->body = $request['body'];
		$post->update();
		//return response()->json(['message' => 'Post Edited'], 200);
		return response()->json(['new_body' => $post->body], 200);
	}
}
