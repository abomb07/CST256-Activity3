<?php
namespace App\Services\Data;

use \PDO;
use PDOException;
use Illuminate\Support\Facades\Log;
use App\Models\UserModel;
use App\Services\Utility\DatabaseException;

//BAD PRACTICE: This class should be a User DAO
class SecurityDAO
{
    private $db = NULL;
    
    //BEST PRACTICE Do not create Database Connection in a Data Service
    public function __construct($db){
        $this->db = $db;
    }
    
    public function findByUser(UserModel $user){
        
        
        Log::info("Entering SecurityDAO::findByUser()");
        
        try
        {
            //Select username and password and see if this row exits
            $name = $user->getUsername();
            $pw = $user->getPassword();
            $stmt = $this->db->prepare("SELECT ID, USERNAME, PASSWORD FROM USERS 
                                        WHERE USERNAME = :username AND PASSWORD = :password");
            
            $stmt->bindParam(':username', $name);
            $stmt->bindParam(':password', $pw);
            $stmt->execute();
            
            //see if user exits and return true if found else return flase if not found
            //BAD PRATICEL this is a business rules in our DAO
            if($stmt->rowCount() == 1){
                Log::info("Exit SecurityDAO.findByUser with true");
                return true;
            }else{
                Log::info("Exit SecurityDAO.findByUser with false");
                return false;
            }
        }catch(PDOException $e)
        {
            
            //BEST PRATICE: Catch a;; the exception (do not swallow exception)
            //log the exception, do not throw away the technology exception, and throw a custom exception
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
}

