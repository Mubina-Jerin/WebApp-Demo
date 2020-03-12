<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\User;
use App\AppUser;
use DB;
use Illuminate\Support\Facades\Session;
//use App\Http\HomeController;
/**
* 
*/
class ProviderController extends Controller
{
	
	function index(){

      
    $singleQuery=DB::select('select * from provider');           
    return view('provider.providerLanding',['provider'=>$singleQuery,'error'=>""]);
		
  }
 

  function providerSignup(Request $request){
     
    $loginQuery=DB::select('select * from login where loginID= ?',[$request->phoneNumber]);
    if($loginQuery){
      $singleQuery=DB::select('select * from provider');           
      return view('provider.providerLanding',['provider'=>$singleQuery,'error'=>"ব্যবহারকারীর ফোন নম্বর ইতিমধ্যে বিদ্যমান"]);
        }
    else{
      $userType="provider";
      $userArray = array('user_name' => $request->phoneNumber,'user_type'=> 'provider', 'role_id'=>'1');
      DB::table('user')->insert($userArray);
      $pdo = DB::connection()->getPdo();
      $last_id=$pdo->lastInsertId();
      //var_dump($last_id);
      if($request->is_broker=="true"){
        $val1=true;
        $val2=false;
      }
        else{
        $val1=false;
        $val2=true;
        }
        $nameArray=explode(' ',$request->userName);
        $cnt=sizeof($nameArray);
        $i=0;
          if(sizeof($nameArray)>0){
            $firstName="";
            foreach($nameArray as $row){
              $firstName=$firstName." ".$row;
              if($i==$cnt-1){
              break;
              }
              $i++;
            }           
            $lastName=$nameArray[$cnt-1];
          }
          else{
            $firstName=$nameArray[0];
            $lastName=null;
          }
      $providerArray=array('user_id'=>$last_id,'first_name'=>$firstName,'last_name'=>$lastName, 'address'=>$request->address,'phone_number'=>$request->phoneNumber,'is_broker'=>$val1,'is_sourcer'=>$val2,'bloger_id'=>null); 

      $result=DB::table('provider')->insert($providerArray);
      $last_id1=$pdo->lastInsertId();
      
      $singleQuery=DB::select('select * from provider where id = ?', [$last_id1]);
      //var_dump($singleQuery);
      //exit();
      if($result){
               $uniqueToken=$request->phoneNumber;
               $resultLogin=DB::table('login')->insert(array('loginID'=>$uniqueToken,'password'=>$request->pwd,'user_id'=>$last_id));
           }

       if($resultLogin){
            //var_dump($singleQuery);
            //exit();
           
            Session::put('id', $last_id1);
            Session::put('nursery_id', null);
            return view('provider.providerProfile', ['user' => $singleQuery,'loginID'=> $uniqueToken]);
            //return redirect()->route('customer.userProfile')->with([$singleQuery,$uniqueToken]);
           // $this->showUserProfile($singleQuery,$uniqueToken);
                   
             }


    }
         }

   function nurseryCreate(Request $request){
    $provider_id=Session::get('user_id');
    $nurseryArray=array('nursery_name' => $request->nursery_name,'description'=>$request->nursery_desc,'user_id'=>$provider_id);
    
      $result=DB::table('nursery')->insert($nurseryArray);
      $pdo = DB::connection()->getPdo();      
       $last_id=$pdo->lastInsertId();
       Session::put('nursery_id',$last_id);
       $id=Session::get('nursery_id');
        if($id!=null){
        $singleQuery=DB::select('select * from nursery where id = ?', [$id]);
        //var_dump($singleQuery);
        return view('provider.nurseryPage', ['nursery'=>$singleQuery, 'plant'=>null]);
        }
        else{
          $singleQuery=DB::select('select * from provider where user_id = ?', [Session::get('user_id')]);
          return view('provider.providerProfile', ['user' => $singleQuery,'loginID'=> Session::get('Login_id')]);
          }
        //$this->nurseryLanding();
      //return view('provider.nurseryPage', ['nursery_id'=>$last_id]);
   }

   function nurseryLanding(){
     //var_dump("sdsdsd");
     //exit();
     $user_id=Session::get('user_id');
     $nurserQuery=DB::select('select * from nursery where user_id = ?', [$user_id]);
    $id=Session::get('nursery_id');
    //var_dump($id);
    //exit();
    if($id!=null){
     
     // exit();
      $singleQuery=DB::select('select * from nursery where id = ?', [$id]);
      $plants=DB::select('select * from plant_info');
      //var_dump($singleQuery);
      return view('provider.nurseryPage', ['nursery'=>$singleQuery,'plant'=>$plants]);
      }
      else if($nurserQuery){
        return view('provider.nurseryPage', ['nursery'=>$nurserQuery[0],'plant'=>null]);
      }
      else{
        
        $singleQuery=DB::select('select * from provider where user_id = ?', [Session::get('user_id')]);
        return view('provider.providerProfile', ['user' => $singleQuery,'loginID'=> Session::get('Login_id')]);
      // $nursery="No nursery Found";
       // return view('provider.nurseryPage', ['nursery'=>$nursery]);
      }
   }

   function addPlant(Request $request){

    $plantArray=array('plant_name'=>$request->plant_name,
    'plant_type'=>$request->plant_type,
    'preferred_season'=>$request->preferred_season,
    'plant_info'=>$request->plant_info,
    'resource_id'=>null);
      $result=DB::table('plant_info')->insert($plantArray);
      $pdo = DB::connection()->getPdo();      
       $plantId=$pdo->lastInsertId();
    $cultArray=array('plant_id'=>$plantId,
    'cultivation_tips'=>$request->cultivation_tips,
    'month_to_start'=>$request->month_to_start,
    'month_to_harvest'=>$request->month_to_end,
    'preferred_soil'=>null,
    'humadity_needed'=>null,
    'steps_of_cultivation'=>null,
      );
      $result=DB::table('cultivation')->insert($cultArray);
      $pdo = DB::connection()->getPdo();      
       $cultivationId=$pdo->lastInsertId();
       $plantQuery=DB::select('select * from plant_info');
              
       $singleQuery=DB::select('select * from nursery where id = ?', [Session::get('nursery_id')]);
      //var_dump($singleQuery);
      return view('provider.nurseryPage', ['nursery'=>$singleQuery,'plant'=>$plantQuery]);
       }

    function addMaterial(Request $request){

    
   }

   function nurseryAddToCatelog(Request $request){
    
     $catelog=array ('nursery_id'=>$request->nursery_id
    ,'plant_id'=>$request->plant_id
    , 'material_id'=>null);
     $result=DB::table('nursery_catalog')->insert($catelog);
     //$pdo = DB::connection()->getPdo();      
     //$plantId=$pdo->lastInsertId();

     return response()->json(['success'=>'Form is successfully submitted!']);

   }
   

   function editDetails(Request $request,$id){
    $last_id1=$request->session->get('id');
         
    $singleQuery=DB::select('select * from provider where id = ?', [$last_id1]);

    return view('provider.providerProfile', ['user' => $singleQuery,'loginID'=> $uniqueToken]);
  }

  function OrderPage(Request $request){
     return view('order.orderLanding',['plant'=>plants,]);

  }
  function createOrder(Request $request){
    


  }







}

?>