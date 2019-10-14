<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    public function test(){
        $email='saidibrahim73@hotmail.com';
        $oldtoken=DB::table('password_resets')->where('email',$email)->value('token');
        if($oldtoken){
           return $oldtoken;
        }
    }
    public function sendEmail(Request $request){

        if(!$this->isValideEmail($request->email)){
            return $this->failedRequestReset();
        }
        $this->send($request->email);
       return $this->SuccessRequestReset();

    }
    public function isValideEmail($email){
        $user=User::where('email',$email)->first();
        if(!$user){
            return false;
        }
        return true;
    }
    public function failedRequestReset(){
        return Response()->json(['error'=>'email invalide !!']);
    }
    public function SuccessRequestReset(){
        return Response()->json(['data'=>'l email est envoyé avec succé']);
    }
    public function send($email){
        $token=$this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
        //return $token;
    }
    public function createToken($email){
        $oldtoken=DB::table('password_resets')->where('email',$email)->value('token');
        if($oldtoken){
            return $oldtoken;
        }
    $token=str_random(20);
    $this->saveToken($email,$token);
    return $token ;
}
public function saveToken($email,$token){

    DB::table('password_resets')->insert([
        'email'=>$email,
        'token'=>$token,
        'created_at'=>Carbon::now()
    ]);
}
public function changePassword(Request $request){
($this->validToken($request))? $this->editPassword($request) : $this->tokenNotFound();
}
public function validToken($request){
$user=DB::table('password_resets')->where(['email'=>$request->email,'token'=>$request->token])->get();
if(!$user){
    return false;
}
return true;
}
public function tokenNotFound(){
    return Response()->json(['error'=>'token invalide !!']);
}
public function editPassword($request){
    $user=User::where('email',$request->email)->get();
$user->update([
    'password'=>bcrypt($request->password),
    'updated_at'=>Carbon::now()
]);
$this->deleteRowToken($request);
return Response()->json(['error'=>'votre modification a été effectuer avec succé']);
}
public function deleteRowToken($request){
    $row=DB::table('password_resets')->where(['email'=>$request->email,'token'=>$request->token])->get();
    $row->delete();
}
}
