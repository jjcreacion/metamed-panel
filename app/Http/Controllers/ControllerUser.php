<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserFirebase;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Illuminate\Support\Collection;
use DataTables;

class ControllerUser extends Controller
{
    public $firebase;
    public $db;
    public $auth;

    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount('../key/firebase.json');
        $this->db = $this->firebase->createDatabase();
        $this->auth = $this->firebase->createAuth();
    }

    public function index(){
        $users = $this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        return view('dash.index', ['usersfb' => $users]);
    }
    
    public function mostrardatos($id){
        return view('userdata.index', ['id' => $id]);
    }

    public function destroy(Request $request){
        
        try {
            $user = $this->auth->getUserByEmail($request->email);
           try {
                $this->auth->deleteUser($user->uid);
                echo true;
            }catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                echo $e->getMessage();
            }
        }catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            echo $e->getMessage();
        }
    }

    public function getuser(Request $request){
        
        try {
            $user = $this->auth->getUser($request->id);
            echo json_encode($user);
        }catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            echo $e->getMessage();
        }
    }

    public function allusers(){ 
       
        $data = [
            'uid' => '9uywhy33',
            'email' => 'jjcreacion@gmail.com',
            'date' => '12-09',
        ];

        echo json_encode($data);

/* 
        //echo json_encode($data);
        //return datatables()->collection($data)->toJson();
        try { 
            $users = $this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
            foreach ($users as $user ){
                $data[]->uid = "1";
                $data[]->email = $user->email;
                $data[]->date = $user->metadata->createdAt->date;  
            }*/
            /*$data->uid = $users->uid;
            $data->email = $users->uid;
            $data->date = $users->metadata->createdAt->date;
            
           // echo json_encode($data);
            return datatables()->collection($data)->toJson();

        }catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            echo $e->getMessage();
        } 
        return datatables()->collection($data)->toJson();*/
       
    }

    public function update(Request $request){
        
        if($request->password!='1234567890'){
            $updatedUser = $this->auth->changeUserPassword($request->id, $request->password);
        }
        
        try {
            $this->auth->changeUserEmail($request->id, $request->email);
            echo true;
        }catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            echo $e->getMessage();
        }
    }
}
