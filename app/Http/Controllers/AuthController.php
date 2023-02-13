<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    function loginView()
    {
        return view("auth.login");
    }

    function registerView()
    {
        return view("auth.register");
    }

    function finishLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',   // required and email format validation
            'password' => 'required', // required and number field validation

        ]); // create the validations
        if ($validator->fails())   //check all validations are fine, if not then redirect and show error messages
        {

            return back()->withInput()->withErrors($validator);
            // validation failed redirect back to form

        } else {
            //validations are passed try login using laravel auth attemp
            if (\Auth::attempt($request->only(["email", "password"]))) {
                return redirect("dashboard")->with('success', 'Login Successful');
            } else {
                return back()->withErrors( "Invalid credentials"); // auth fail redirect with error
            }
        }
    }

    function finishRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',   // required and email format validation
            'password' => 'required|min:6', // required and number field validation
            'confirm_password' => 'required|same:password',

        ]); // create the validations
        if ($validator->fails())
        {
            return back()->withInput()->withErrors($validator);
        } 
        else
        {
            $User = new User;
            $User->name = $request->name;
            $User->email = $request->email;
            $User->password = bcrypt($request->password);
            if(User::count() < 1)
            {
                $User->isAdmin = 1;
                $User->isOwner = 1;
            }
            else
            {
                $User->isAdmin = 0;
                $User->isOwner = 0;
            }
            $User->save();

            return redirect("login")->with('success', 'You have successfully registered, Login to access your dashboard');
        }
    }


    function logout()
    {
        \Auth::logout();
        return redirect("login")->with('success', 'Logout successfully');;
    }

    function navigateToDashboard()
    {
        $articles = Article::All();
        return view('dashboard', ['articles' => $articles]);
    }
}
