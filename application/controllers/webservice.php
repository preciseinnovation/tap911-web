<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planner extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		date_default_timezone_set("Africa/Johannesburg");
        parent::__construct();

     }
	public function index()
	{
		
	 
		$data['time']=date("h:i A");
		$this->load->view('home',$data);
	}
	function Get_routes(){
		date_default_timezone_set("Africa/Johannesburg");
        $token_data=$this->check_token();
        $token=$token_data['token'];
        $token_type=$token_data['type'];
        $from_lat=$this->input->post('from_lat');
        $from_lng=$this->input->post('from_lng');
        $to_lat=$this->input->post('to_lat');
        $to_lng=$this->input->post('to_lng');
        $modes=$this->input->post('modes');
        $time=str_replace('+00:00', 'Z',  date("c",strtotime('7:13')) );
        
	    $modes=$this->input->post('modes');
       	$modes=json_decode($modes,true);
        if(in_array("1", $modes)){
        	$modes_array=array();
        	($modes[0]=="1") ?  array_push($modes_array,"Rail"): '';
        	($modes[1]=="1") ?  array_push($modes_array,"ShareTaxi") :'' ;
        	($modes[2]=="1") ?  array_push($modes_array,"Bus") :'' ;
        	//$modes_array = array("Bus","Rail","LightRail","Subway","ShareTaxi");
        }else{
        	$modes_array = array("Bus","Rail","ShareTaxi");
             }
          // $time=str_replace('+00:00', 'Z',  date("c",strtotime('6:37')) );
        
	    $request =json_encode(array(
	        'geometry'=> array(
	          'type'=>'Multipoint',
	          'coordinates'=>array(
	              array($from_lng, $from_lat),
	              array($to_lng, $to_lat)
	            ),
	          ),
	        'profile'=> "FewestTransfers",
	        "timeType" => "DepartAfter",
	        "time" =>$time,
	        "maxItineraries" => 3,
	        "only"=>array(
	            'modes'=>$modes_array 
	          )
	    ));
      
        $ch = curl_init(); 
      	curl_setopt($ch, CURLOPT_URL, "https://platform.whereismytransport.com/api/journeys");
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  "POST");
      	curl_setopt($ch, CURLOPT_POSTFIELDS,     $request);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $headr[] = 'Content-length: '.strlen($request);
 	    $headr[] = 'Content-type: application/json';
 	    $headr[] = 'Authorization: '.$token_type.' '.$token;
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

      	$checkLogin = trim(curl_exec($ch),"\"");
      	curl_close($ch);
      	//print_r($checkLogin);
      	$all_data=json_decode($checkLogin,true);
     if(isset($all_data['itineraries'])){
      	$itineration=$all_data['itineraries'];
      	$return_data=array();
      	$return_data['travel_path']=array();
      	$final_cost=0;
		 $return_data['map_data']=array();

      	if(count($itineration)){
      		$i=0;
      		$travel_array=array();
      		foreach ($itineration as $route) {
      			$final_cost=0;
      			$j=0;
      			$loop_data=array();
      			$loop_data['route']=array();
      			$loop_data['map_data']=array();
      			$loop_data['info_data']=array();
      			$final_distance=0;
      			$final_duration=0; 
      			foreach ($route['legs'] as $legs) {
      				$temp_array=array();
	      			$type= $legs['type'];
	      			$distance = $legs['distance']['value'];
	      			$final_distance=$final_distance+$distance;
	      			$unit= $legs['distance']['unit'];
	      			if($distance >= 1000){
	      				$distance= $distance/1000;
	      				$unit="km";
	      			}
	      			$duration= $legs['duration']; 
	      			$final_duration=$final_duration+$duration;
	      			
	      			$route_data['distance']=$distance." ".$unit ;
	      			$route_data['duration']=$duration;
	      			if($type!="Walking"){
	      				//print_r($route_data['type']);die();
	      				$cost= $legs['fare']['cost']['amount'];	
	      				$final_cost=$final_cost+$cost;
	      				$route_data['cost']=$cost;
	      				$route_data['type']=$legs['line']['mode'];
	      				
	      				$start_time= $legs['waypoints'][0]['departureTime'];
	      				$last=count($legs['waypoints'])-1;
	      				
	      				$last_time = $legs['waypoints'][$last]['arrivalTime'];
	      				if(isset($legs['waypoints'][$last]['stop']['name'])){

	      				}else{
	      					$legs['waypoints'][$last]['stop']['name']=" ";
	      				}
	      				$last_station = $legs['waypoints'][$last]['stop']['name'];
	      				
	      				$train =$legs['line']['agency']['name']." ".$legs['line']['mode'];

	      				$d['type']=$legs['line']['mode'];
	      				$d['cost']=$cost;
	      				$d['distance']=$distance." ".$unit;
	      				$d['st_time']=date("h:i A",strtotime($start_time));
	      				$d['ls_time']=date("h:i A",strtotime($last_time));
	      				$d['content1']="Get onto ".$train;
	      				$d['train']=$train;
	      				$d['content2']="Get off at ".$last_station;
	      				array_push($temp_array, $d);
	      				unset($d);
	      			}else{
	      				$route_data['type']="Walking";
	      				foreach ($legs['directions'] as $direction) {
	      					$d['type']= "walk";
	      					$d['distance']=$distance;
	      					$dis=$direction['distance']['value'];
	      					$un=$direction['distance']['unit'];
	      					if($dis >= 1000){
	      						$dis=$dis/1000;
	      						$un="km";
	      					}
	      					$d['content']=$direction["instruction"]. " ".$dis.$un;
	      					
	      					array_push($temp_array, $d);
	      					unset($d);
	      				}
	      			} 

	      			array_push($loop_data['route'], $route_data);
	      			array_push($loop_data['info_data'], $temp_array);
	      			$loop_data['final_cost']= $final_cost;
	      			$loop_data['final_distance']= $final_distance;
	      			$loop_data['final_duration']= $final_duration;
	      			$time_to_display=explode(':',date('H:i', mktime(0,0,$final_duration)));
	      			$loop_data['time_to_display']= $time_to_display[0]." hour(s) ".$time_to_display[1]." minute(s)";
	      			$map_data="";
	      			$map_data=$legs['geometry']['coordinates'];
	      			//print_r($map_data);die();
	      			array_push($loop_data['map_data'], $map_data);
	      			unset($route_data);
	      			unset($type);
	      		} 
	      		$loop_data['departureTime']=date("h:i A",strtotime($route['departureTime']));
	      		array_push($travel_array, $loop_data);

      		} 
      		$min_cost = min(array_map(function($a) { return $a['final_cost']; }, $travel_array));
      		$min_duration = min(array_map(function($a) { return $a['final_duration']; }, $travel_array));
      		$return_data['travel_path']=$travel_array;
      		$return_data['chipest_cost']=$min_cost;
      		$return_data['result']="true";
      		$return_data['min_duration']=$min_duration;
      		$return_data['start_lat']=$from_lat;
      		$return_data['start_lng']=$from_lng;
      		$return_data['end_lat']=$to_lat;
      		$return_data['end_lng']=$to_lng; 

      		print_r(json_encode($return_data));die();

      	}else{
      		echo json_encode(array("result"=>"false","msg"=> "No Result not found.") );
      	}
      }else{
      	echo json_encode(array("result"=>"false","msg"=> "No Result not found.") );
      }

	}
	function check_token(){
		$myFile = FCPATH . 'token.txt';
		$data=file_get_contents($myFile);
		$explod=explode("######", $data);
		$datas['token']=$explod[0];
		$datas['type']=$explod[1];
		$datas['time']=$explod[2];
		if(strtotime(gmdate("Y-m-d H:i:s")) >= strtotime($datas['time']) ){
			$data_t=$this->genereate_token();
			return $data_t;
		}else{
			return $datas;
		}

	}
	function genereate_token(){
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, "https://identity.whereismytransport.com/connect/token");
		$request =array(
			'client_id'=>'251df50a-7785-4e26-9a51-a826ca476222',
			'client_secret'=>'/n/c6bkBe2ggk+SS0kIxj3mg1swNTWs/HKA6yy1ZCrA=',
			'grant_type'=>	'client_credentials',
			'scope'	=>'transportapi:all'
		);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$checkLogin = trim(curl_exec($ch),"\"");
		curl_close($ch);
		$token_array =json_decode($checkLogin,true);

		 $token=$token_array['access_token'];
		 $token_type=$token_array['token_type'];
		$expires_in=$token_array['expires_in'];
       
		$data=$token.'#######'.$token_type.'#######'.gmdate('Y-m-d H:i:s',strtotime('+3600 seconds'));
		file_put_contents(FCPATH . 'token.txt',$data);
		$datas['token']=$token_array['access_token'];
		$datas['type']=$token_array['token_type'];
		$datas['time']=gmdate('Y-m-d H:i:s',strtotime('+3600 seconds'));
		return $datas;
	}
}
