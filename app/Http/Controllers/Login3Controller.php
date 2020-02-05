<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

use App\Models;
use App\Services\Business\SecurityService;
use App\Models\UserModel;
use App\Services\Utility\DatabaseException;
class Login3Controller extends Controller
{
    
    //BEST PRACTICE name your method properly and cledarly (index() 
    // is bad for a controller form (NAME YOUR METHOD RIGHT!!!) 
    public function index(Request $request)
    {
        try{
            
            $this->validateForm($request);
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
        
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    private function validateForm(Request $request){
        //BEST PRATICE: centralize your rule so you have a consistent architecture
        //and even resuse your rules
        //BAD PRATICES: not using a defined data validation Framework, putting rules
        //all over your coe, doing only on CLient side and database 
        //SEt up data validation for login form
        $rules = ['username'=> 'Required |Between:4,10 | Alpha',
                    'password' => 'Required | Between:4,10'];
        
        // RUn Data Validation Rules
        $this->validate($request, $rules);
    }
    
}
