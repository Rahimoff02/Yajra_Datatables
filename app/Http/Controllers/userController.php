<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\userRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class userController extends Controller
{
    public function register(userRequest $post){
 
        $con = new User();

        $yoxla = User::where('email','=',$post->email)->orwhere('password','=',$post->password)->count();

        if($yoxla==0)
        {
        $con->foto = 'https://media.istockphoto.com/vectors/default-image-icon-vector-missing-picture-page-for-website-design-or-vector-id1357365823?k=20&m=1357365823&s=612x612&w=0&h=ZH0MQpeUoSHM3G2AWzc8KkGYRg4uP_kuu0Za8GFxdFc=';
        $con->name = $post->name;
        $con->surname = $post->surname;
        $con->email = $post->email;
        $con->phone = $post->phone;
        
        $con->blok=0;
                
        $con->password = Hash::make($post->password);

        $con->save();

        return back()->with('message','Welcome to our website :) ');
        }
        return back()->with('message','This user is already exist.');

    }

    public function login(userRequest $post){

        $this->validate($post,[

            'email'=>'email|required',
            'password'=>'required'
        ]);

        if(!Auth::attempt(['email'=>$post->email,'password'=>$post->password,'blok'=>0])){

            return back()->with('message','Your email or password is wrong.Try again...');
        }

        return redirect('/');
    }

    public function logout(){

        auth()->logout();

        return redirect()->route('login');
    }
   
}
