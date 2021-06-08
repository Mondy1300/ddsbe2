<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response; 
use Illuminate\Http\Request; 
use App\Models\User;
use App\Models\UserJob;
use App\Traits\ApiResponser;
use DB;

Class UserController extends Controller {
 private $request;
 use ApiResponser;

 public function __construct(Request $request){
 $this->request = $request;


 }

 public function getUsers(){
    $users = DB::connection('mysql')->select('Select * from tbluser');
    return $this->successResponse($users);
 }

 public function index(){

    $users = User::all();


    return $this->successResponse($users); 
 }

 public function add(Request $request){
    $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20',
        'gender' => 'required|in:Male,Female',
        'jobid' => 'required|numeric|min:1|not_in:0',
    ];

    $this->validate($request, $rules);

    $userjob = UserJob::findOrFail($request->jobid);
    $user = User::create($request->all());

    return $this->successResponse($user, Response::HTTP_CREATED);
}

public function show($id){

    $user = User::findOrFail($id);
    return $this->successResponse($user);

    /*$user = User::where('userid', $id)->first();
    if ($user){
        return $this->successResponse($user);
    }
    {
    return $this->errorResponse('User ID Does Not Exist', Response::HTTP_NOT_FOUND);
    }*/
}

public function update(Request $request, $id){
    $rules = [
        'username' => 'max:20',
        'password' => 'max:20',
        'gender' => 'in:Male,Female', 
        'jobid' => 'required|numeric|min:1|not_in:0',
    ];

    $this->validate($request, $rules);

    $user = User::findOrFail($id);
    //$user = User::where('userid', $id)->first();
    $userjob = UserJob::findOrFail($request->jobid);

        if ($user){
            $user->fill($request->all());

    // if no changes happen
        if ($user->isClean()) {
             return $this->errorResponse('At least one value must change', 
            Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $user->save();
    return $this->successResponse($user);
    } 
}

public function delete($id){
    $user = User::findOrFail($id);
    $user->delete();
    return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
    
    //$user = User::where('userid', $id)->first();
    /*if ($user){
        $user->delete(); 
        return $this->successResponse($user);
    }
    {
       return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
    }*/
}




}
?>
 