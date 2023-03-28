<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

require '../vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class UserFirebase extends Model
{
    use HasFactory;
    public $firebase;
    public $db;

    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount('./key/firebase.json');
        $this->db = $this->firebase->createDatabase();
    }

    public static function getUsers(){
        $auth = $this->firebase->createAuth();
        $users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        return $users;
    }
}
