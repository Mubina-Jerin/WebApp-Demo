<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\User;
use App\AppUser;
use DB;
use Illuminate\Support\Facades\Session;
//use App\Http\Controllers\Session;
//use App\Http\HomeController;
/**
* 
*/
class HomeController extends Controller
{
	
	function index(){

		// $query = array('user_name' =>'' ,'user_type'=>'customer', "role_id"=>'1' );
		// $query_role=array('role_name'=> 'customer','feature_id'=>'1');
		// $query_feature=array('id'=>'1','feature_name'=>'create_plant_order');
		//  $insertion1=DB::table('feature')->insert($query_feature);
  //       $insertion=DB::table('role')->insert($query_role);
  //        $insertion2=DB::table('user')->insert($query);
    $insertion2=null;
          if($insertion2)
          	{$msg="Inserted Successfully";
            }
            else{
            	 $msg= "I am here from Controller";
            }

                   
         return view('landing', ['user' => $msg]);
		
	}

  function signup(){
    
    return view('signUP',['error'=>""]);
  }

   function login(){
    $error="";
    return view ('login',['error'=>$error]);
   }

  function doLogin(Request $request){

    if(Session::get('Login_id')){
  
      if(Session::get('pass')){
        $login=['id'=>Session::get('t_id'),
        'loginID'=>Session::get('Login_id'),
        'password'=>Session::get('pass'),
        'user_id'=>Session::get('user_id')];
        //var_dump($loginQuery);
        //exit();
        $a=DB::select('select user_type from user where id = ?', [$login['user_id']])[0]->user_type;
    
       // var_dump($a);//exit();
        if($a=="customer"){
          $singleQuery=DB::select('select * from customer where user_id = ?', [$login['user_id']]);
          Session::put('id', $singleQuery[0]->id);
         // var_dump($singleQuery);
          return view('customer.userProfile', ['user' =>  $singleQuery,'loginID'=> $login['loginID']]);
        }
        else if ($a=="provider"){
        
            $singleQuery=DB::select('select * from provider where user_id = ?', [$login['user_id']]);
            $singleQuery1=DB::select('select * from nursery where user_id = ?', [$login['user_id']]);
            //var_dump($singleQuery);
            // var_dump($singleQuery);
           // exit();
           Session::put('id',  $singleQuery[0]->id);
           if($singleQuery1){
            Session::put('nursery_id',  $singleQuery1[0]->id);
           }
           else{
            Session::put('nursery_id', null);
           }
           //return view('provider.providerProfile');
           
          return view('provider.providerProfile', ['user' =>  $singleQuery,'loginID'=> $login['loginID']]);
        }
        //$this->showUserProfile($loginQuery);
      }
    }
    else{
  
      $loginQuery=DB::select('select * from login where loginID= ? and password=?',[$request->loginID,$request->pwd]);
      
      if ($loginQuery){
        //exit();
        Session::put('t_id', $loginQuery[0]->loginID);
        Session::put('user_id', $loginQuery[0]->user_id);
        Session::put('Login_id', $loginQuery[0]->loginID);
        Session::put('pass', $loginQuery[0]->password);
        var_dump(Session::get('user_id'));
       // exit();
        $login=['id'=>Session::get('t_id'),
        'loginID'=>Session::get('Login_id'),
        'password'=>Session::get('pass'),
        'user_id'=>Session::get('user_id')];

        $a=DB::select('select user_type from user where id = ?', [$login['user_id']])[0]->user_type;
    
        //var_dump($a);//exit();
        if($a=="customer"){
          $singleQuery=DB::select('select * from customer where user_id = ?', [$login['user_id']]);
          Session::put('id', $singleQuery[0]->id);
          //var_dump($singleQuery);
          return view('customer.userProfile', ['user' =>  $singleQuery,'loginID'=> $login['loginID']]);
        }
        else if ($a=="provider"){
        
            $singleQuery=DB::select('select * from provider where user_id = ?', [$login['user_id']]);
            $singleQuery1=DB::select('select * from nursery where user_id = ?', [$login['user_id']]);
            var_dump($singleQuery);
            // var_dump($singleQuery);
           // exit();
           Session::put('id',  $singleQuery[0]->id);
           if($singleQuery1){
            Session::put('nursery_id',  $singleQuery1[0]->id);
           }
           else{
            Session::put('nursery_id', null);
           }
           //return view('provider.providerProfile');
           //exit();
          return view('provider.providerProfile', ['user' =>  $singleQuery,'loginID'=> $login['loginID']]);
        }
      // $this->showUserProfile($loginQuery);
      }
      else{
        $error="Password or User Name doest match";
        return view ('login',['error'=>$error]);
      }
    }
              
   
  
   

    //var_dump($loginQuery);
  }

   function logout() {
        Session::flush();
        return view('landing');
    }
  function reg(Request $request){
    

    $loginQuery=DB::select('select * from login where loginID= ?',[$request->phoneNumber]);
    if($loginQuery){
      return view('signUP',['error'=>"ব্যবহারকারীর ফোন নম্বর ইতিমধ্যে বিদ্যমান"]);
    }
    else{
      // $userObject = new AppUser;

    //$userObject->userName=$request->userName;
    $userType="customer";
    $userArray = array('user_name' => $request->phoneNumber,'user_type'=> 'customer', 'role_id'=>'1');
  // $userObject->userType= "customer"; $request->userType;

   // if($userType=="customer"){
   //  //$userObject->role_id=1;

   //  array_merge($userArray, array('role_id'=>'1'));
   // // var_dump($userArray);
   // }
   //  else if($request->userType=="admin"){
   //  //$userObject->role_id=2;
   //    array_merge($userArray, array('role_id'=>'2'));
   //  }
   //    else{
   //     // $userObject->role_id=3;
   //      // DB::table('role')->insert(array('role_name'=> 'customer','feature_id'=>'1'));
   //       array_merge($userArray, array('role_id'=>'3'));
   //    }
      //var_dump($userArray);
      //exit();
        DB::table('user')->insert($userArray);
        $pdo = DB::connection()->getPdo();
         $last_id=$pdo->lastInsertId();
                     
        $singleQuery=DB::select('select * from user where id = ?', [$last_id]);
        $nameArray=explode(' ',$request->userName);
        if(sizeof($nameArray)==2){
          $firstName=$nameArray[0];
          $lastName=$nameArray[1];
        }
        else{
          $firstName=$nameArray[0];
          $lastName=null;
        }
       
        $customerArray=array('user_id'=>$last_id,'first_name'=>$firstName,'last_name'=>$lastName, 'address'=>$request->address,'phone_number'=>$request->phoneNumber,'bloger_id'=>null); 

        $result=DB::table('customer')->insert($customerArray);
        $last_id1=$pdo->lastInsertId();
        $singleQueryNew=DB::select('select * from customer where id = ?', [$last_id1]);
         
         if($result){
             $uniqueToken=$request->phoneNumber;
             $resultLogin=DB::table('login')->insert(array('loginID'=>$uniqueToken,'password'=>$request->pwd,'user_id'=>$last_id));
         }
             
            // var_dump($singleQuery);
             //exit();
         if($resultLogin){
          //var_dump($singleQuery);
          //exit();
          return view('customer.userProfile', ['user' => $singleQueryNew,'loginID'=> $uniqueToken]);
          //return redirect()->route('customer.userProfile')->with([$singleQuery,$uniqueToken]);
         // $this->showUserProfile($singleQuery,$uniqueToken);
                 
           }
    
   //$userObject->save();

    
 //return view('landing');
  var_dump($request->all());
    }
   
  }

  function showUserProfile($login){
  //  var_dump($login['user_id']);
    
   // exit();
   


  }
 
  
}

?>