<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserFirebase;

use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Illuminate\Support\Collection;

class ControllerUser extends Controller
{
    public $firebase;
    public $db;

    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount('../key/firebase.json');
        $this->db = $this->firebase->createDatabase();
    }

    public function index(){
        //$database = app('firebase.database');
        //$usef = new ;
        //$user = UserFirebase::getUsers();
        //return $user; 

        $auth = $this->firebase->createAuth();
        $users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
       // $usersfb = collect($users);
        return view('dash.index', ['usersfb' => $users]);
    }
}
