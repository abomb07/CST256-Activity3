<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Services\Business\SecurityService;
use App\Models\UserModel;
class Login2Controller extends Controller
{
    
    //BEST PRACTICE name your method properly and cledarly (index() 
    // is bad for a controller form (NAME YOUR METHOD RIGHT!!!) 
    public function dologin2(Request $request)
    {
        //GEt posted Form data
        $username = $request->input('username');
        $password = $request->input('password');
        
        //Save posted Form Data to User Object Model
        $user = new UserModel(-1, $username, $password);
        
        //Call Security Service
        //BEST PRACTICE pass course grained not fine grained parameters
        $service = new SecurityService();
        $status = $service->login($user);
        
        //Render a failed or success response View and pass the User Model to it
        if($status)
        {
            $data =['model' => $user];
            return View('loginPassed2')->with($data);
        }else{
            return View('loginFailed2');
        }
    }
    
}
