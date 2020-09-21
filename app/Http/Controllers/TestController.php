<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;
use App\User;
use App\Post;
use App\Mail\MyDemoMail;

class TestController extends Controller
{
     public function myDemoMail()
    {
    	$users = User::all();
    	$file = 'pdf/sample.pdf';
    	$post = Post::where('id','3')->first();
    	$myEmail = 'ahadcseuits@gmail.com';
    	Mail::to($myEmail)
    	->cc('mha@gmail.com')
    	->bcc('lolo@gmail.com','lll@gmail.com')
    	->send(new MyDemoMail($users, 'upload/' . $post->files));
    	dd("Mail Send Successfully");
    }
}
