<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show new user form
    public function create(){
        return view('users.register');
    }


    // create user form
    public function store(Request $request){
            $formField= $request->validate([
                'name' => ['required', 'min:3'],
                "email" => ['required', Rule::unique('users', 'email')],
                'password'=>'required |confirmed| min:6',
            ]);

            $formField['password'] = bcrypt($formField['password']);    

            $user  = User::create($formField);

            auth()->login($user);
            session()->flash('message','User created and Logged in successfully');
            return redirect()->to('/');
    }


    //logout user
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

         session()->flash('message','User created and Logged out successfully');
            return redirect()->to('/');
    
    }

    //login user form
    public function login(){
        return view('users.login');
         
    }

    // authenticate user for login
    public function authenticate(Request $request){
             $formField= $request->validate([
            
                "email" => ['required', ],
                'password'=>'required',
            ]);

            if(auth()->attempt($formField)){
                 session()->flash('message','User  Logged in successfully');
                return redirect()->to('/');
            }
            return back()->withErrors(['email'=> 'Invalid Credentials'])->onlyInput('email');
    }

  
}
