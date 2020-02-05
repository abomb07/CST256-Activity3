<?php
namespace App\Services\Business;

use \PDO;
use Illuminate\Support\Facades\Log;
use App\Models\UserModel;
use App\Services\Data\SecurityDAO;

class SecurityService
{
    //REFACTOR: This should be renamed to authenticate
    public function login(UserModel $user)
    {
        Log::info("Entering SecurityService.login()");
              
        //BEST PRATICE : Externalize your application configuration
        //Get credentials for accessing your database
        //REFACTOR: The Initialization code is repeated in all the business methods
        $servername = config("database.connections.mysql.host");
        $port = config("database.connections.mysql.port");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        $dbname = config("database.connections.mysql.database");
        
        //BEST PRATICE: Do not create Database Connection is a DAO
        // so you can support : Atomic Database Transaction
        //Create Connection
        $db = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //Create a Security Service  DAO with this connection and try to find the password in User/
        $service = new SecurityDAO($db);
        $flag = $service->findByUser($user);
        
        // In PDO you close the database connection by setting the PDO object to null
        $db = null;
        
        //return the finder result
        Log::info("Exit SecurityService.login() with ". $flag);
        return $flag;

    }
}

