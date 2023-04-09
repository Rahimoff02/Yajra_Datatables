<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\userRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class profileController extends Controller
{
    public function update(userRequest $post){
        
        $con = User::find(Auth::id());

        if(Hash::check($post->password, $con->password)){

            $yox = User::where('email','=',$post->email)->where('id','!=',$post->id)->where('id','!=',Auth::id())->orwhere('phone','=',$post->phone)->where('id','!=',Auth::id())->where('id','!=',$post->id)->count();
 
            if($yox==0){
            
            if(empty($post->newpass) or strlen($post->newpass)>3){
                
                if($post->newpass==$post->parol_t){
                    
                    $yoxla=User::where('id','!=',$post->id)->count();
        
                    if($yoxla==0){
                    
                        $post->validate([
                        'foto' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:4096',
                        ]);
                    }
                    
                    if($post->file('foto')){
                        
                        $file = time().'.'.$post->foto->extension();
                        $post->foto->storeAs('public/uploads/image/',$file);
                        $con->foto = 'storage/uploads/image/'.$file;
                    }
                    else{
                        $con->foto = $con->foto;
                    }

                    if($post->newpass>4){
                        $con->password = Hash::make($post->newpass);
                    }
                    else{
                        $con->name = $post->name;
                        $con->surname = $post->surname;
                        $con->email = $post->email;
                        $con->phone = $post->phone;
                    }
                    
                    $con->save();
                    
                    return back()->with('message','Your profile updated.');
                }
                return back()->with('message','Yeni şifrə və Təkrar şifrə eyni deyil');
              }        
            return back()->with("message','New password can't be under 4 .");
           }
           return back()->with("message','This phone or email is taken.");
        }
        return back()->with('message','Recent password is wrong.');
    }
}
