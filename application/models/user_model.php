<?php
class User_model extends CI_Model
{
    
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    /*-------------------------------user login----------------------------------------------- */
    
    function checklogin($login, $password)
    {
        
        $sql = "SELECT user_name,first_name,last_name,phone_number_text_msg,user_id, password,assistance_status, email FROM tbl_user where  email = '$login' and password = '$password' and status=1";
        $res = $this->db->query($sql);
        
        if ($res->num_rows > 0) {
            $row                       = $res->row();
            $customer_id               = $row->user_id;
            $assistance_status               = $row->assistance_status;
            $first_name               = $row->first_name;
            $last_name               = $row->last_name;
            $phone_number_text_msg               = $row->phone_number_text_msg;
            $tokens                    = openssl_random_pseudo_bytes(8);
            $token                     = bin2hex($tokens);
            $notification_device_token = $_REQUEST['notification_device_token'];
            $mobile_type               = $_REQUEST['mobile_type'];
             $time_zone               = $_REQUEST['time_zone'];
            $data                      = array(
                'token' => $token,
                'notification_device_token' => $notification_device_token,
                'mobile_type' => $mobile_type,
                'time_zone' => $time_zone,
                'login_status'=>1
                
            );
            $this->db->where('user_id', $customer_id);
            $value       = $this->db->update('tbl_user', $data);
            $returnarray = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $customer_id,
                'assistance_status'=>$assistance_status,
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'phone_number'=>$phone_number_text_msg
            );
            
            
        } else {
            
            $returnarray = array(
                'status' => 0,
                'message' => 'Email or Password is invalid'
            );
        }
        return $returnarray;
    }
    
    
    /*-------------------------------feacbook login----------------------------------------------- */
    
    function facebook_login()
    {
        $login       = $_REQUEST['login'];
        $facebook_id = $_REQUEST['facebook_id'];
        $sql         = "SELECT user_name ,user_id, email FROM tbl_user where email = '$login' and facebook_id='$facebook_id' and status=1";
        $res         = $this->db->query($sql);
        
        if ($res->num_rows > 0 && $facebook_id != "") {
            $row                       = $res->row();
            $customer_id               = $row->user_id;
            $tokens                    = openssl_random_pseudo_bytes(8);
            $token                     = bin2hex($tokens);
            $notification_device_token = $_REQUEST['notification_device_token'];
            $mobile_type               = $_REQUEST['mobile_type'];
            $data                      = array(
                'token' => $token,
                'notification_device_token' => $notification_device_token,
                'mobile_type' => $mobile_type
            );
            $this->db->where('user_id', $customer_id);
            $value       = $this->db->update('tbl_user', $data);
            $returnarray = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $customer_id
            );
            
            
        } else {
            $tokens                    = openssl_random_pseudo_bytes(8);
            $token                     = bin2hex($tokens);
            $notification_device_token = $_REQUEST['notification_device_token'];
            $mobile_type               = $_REQUEST['mobile_type'];
            $data                      = array(
                'facebook_id' => $facebook_id,
                'email' => $login,
                'first_name' => $_REQUEST['first_name'],
                'last_name' => $_REQUEST['last_name'],
                'token' => $token,
                'notification_device_token' => $_REQUEST['notification_device_token'],
                'mobile_type' => $_REQUEST['mobile_type'],
                'status' => 1
            );
            $data                      = $this->db->insert('tbl_user', $data);
            $id                        = $this->db->insert_id();
            $sql                       = "SELECT token,user_id FROM tbl_user WHERE user_id ='" . $id . "'";
            $res                       = $this->db->query($sql);
            $row                       = $res->row();
            $user_id                   = $row->user_id;
            $token                     = $row->token;
            $returnarray               = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $user_id
            );
        }
        return $returnarray;
    }
    
    
    
    /*-------------------------------google login----------------------------------------------- */
    
    
    function google_login()
    {
        $login     = $_REQUEST['login'];
        $google_id = $_REQUEST['google_id'];
        $sql       = "SELECT user_name ,user_id, email FROM tbl_user where email = '$login' and google_id='$google_id'  and status=1";
        $res       = $this->db->query($sql);
        
        if ($res->num_rows > 0 && $google_id != "") {
            $row                       = $res->row();
            $customer_id               = $row->user_id;
            $tokens                    = openssl_random_pseudo_bytes(8);
            $token                     = bin2hex($tokens);
            $notification_device_token = $_REQUEST['notification_device_token'];
            $mobile_type               = $_REQUEST['mobile_type'];
            $data                      = array(
                'token' => $token,
                'notification_device_token' => $notification_device_token,
                'mobile_type' => $mobile_type
            );
            $this->db->where('user_id', $customer_id);
            $value       = $this->db->update('tbl_user', $data);
            $returnarray = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $customer_id
            );
            
            
        } else {
            $tokens                    = openssl_random_pseudo_bytes(8);
            $token                     = bin2hex($tokens);
            $notification_device_token = $_REQUEST['notification_device_token'];
            $mobile_type               = $_REQUEST['mobile_type'];
            $data                      = array(
                'google_id' => $google_id,
                'email' => $login,
                'first_name' => $_REQUEST['first_name'],
                'last_name' => $_REQUEST['last_name'],
                'token' => $token,
                'notification_device_token' => $_REQUEST['notification_device_token'],
                'mobile_type' => $_REQUEST['mobile_type'],
                'status' => 1
            );
            $data                      = $this->db->insert('tbl_user', $data);
            $id                        = $this->db->insert_id();
            $sql                       = "SELECT token,user_id FROM tbl_user WHERE user_id ='" . $id . "'";
            $res                       = $this->db->query($sql);
            $row                       = $res->row();
            $user_id                   = $row->user_id;
            $token                     = $row->token;
            $returnarray               = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $user_id
            );
        }
        return $returnarray;
    }
    
    
    /*-------------------------------user registration----------------------------------------------- */
    
    
    function user_registration()
    {
        $phone_number= $_REQUEST['phone_number'];
        $check = "SELECT phone_number_text_msg,email FROM tbl_user WHERE status=1 and (email ='" . $_REQUEST['email'] . "' OR phone_number_text_msg ='" . $phone_number . "')";
        $rs    = mysql_query($check);
        $data  = mysql_fetch_array($rs);
          $phone_number_text_msg = $data['phone_number_text_msg'];
           $email = $data['email']; 
        if ($email==$_REQUEST['email']) {
            
            $returnresult = array(
                'status' => 0,
                'message' =>'This email is already registered with another user'
            );
          
        }
         elseif($phone_number_text_msg==$phone_number){
              $returnresult = die(json_encode(array(
                    "status" => 0,
                    "message" => "This Phone number is already registered with another user"
                )));
            }
         else {
            
            $time_zone               = $_REQUEST['time_zone'];
            $tokens                    = openssl_random_pseudo_bytes(8);
            $token                     = bin2hex($tokens);
            $target      = "./uploads/";
            $target      = $target . basename($_FILES['profile_pic']['name']);
            $profile_pic = ($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
                $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $returnresult = die(json_encode(array(
                        "status" => 0,
                        "message" => "Please enter valid email address"
                    )));
                    
                }
                if (!is_numeric($phone_number)) {
                    $returnresult = die(json_encode(array(
                        "status" => 0,
                        "message" => "Please Enter number only"
                    )));
                }
              
                if (ctype_alpha($_REQUEST['first_name']) === false) {
                    
                    $returnresult = die(json_encode(array(
                        "status" => 0,
                        "message" => "First name must only contain letters!"
                    )));
                }
                if (ctype_alpha($_REQUEST['last_name']) === false) {
                    
                    $returnresult = die(json_encode(array(
                        "status" => 0,
                        "message" => "Last name must only contain letters!"
                    )));
                }
                
                
                $data = array(
                    'first_name' => $_REQUEST['first_name'],
                    'last_name' => $_REQUEST['last_name'],
                    'user_name' => $_REQUEST['user_name'],
                     'email' => $_REQUEST['email'],
                     'dob' => $_REQUEST['dob'],
                     'token' => $token,
                     'time_zone'=>$time_zone,
                    'gender' => $_REQUEST['gender'],
                    'phone_number_text_msg_country_code' => $_REQUEST['country_id'],
                    'phone_number_text_msg' => $phone_number,
                    'user_lat' => $_REQUEST['user_lat'],
                    'user_long' => $_REQUEST['user_long'],
                    'password' => md5($_REQUEST['password']),
                    'user_type_id' => $_REQUEST['user_type_id'],
                    'profile_pic' => $profile_pic,
                    'notification_device_token' => $_REQUEST['notification_device_token'],
                    'mobile_type' => $_REQUEST['mobile_type'],
                    'assistance_status' => 1,
                     'radius' => 3,
                    'status' => 1
                );
                $data = $this->db->insert('tbl_user', $data);
                $id   = $this->db->insert_id();
                $check = "SELECT assistance_status FROM tbl_user WHERE status=1 and user_id= $id";
                $rs    = mysql_query($check);
                $data  = mysql_fetch_array($rs);
                $assistance_status = $data['assistance_status'];
        
                if ($data) {
                    
                    $data = array(
                        'user_id' => $id,
                        'status' => 1
                    );
                    $data = $this->db->insert('tbl_notification', $data);
                    $dateValue = date("Y-m-d H:i:s");
                    $time      = strtotime($dateValue);
                    $month     = date("F", $time);
                    $year      = date("Y", $time);
                    $table     = "tbl_tracking" . '_' . $month . '_' . $year;

                      $data = array(
                        'user_id' => $id,
                        'gps_status'=>1,
                        'status' => 1
                    );
                    $data = $this->db->insert($table, $data);

                    $returnresult = array(
                        'status' => 1,
                        'user_id'=>$id,
                        'token'=>$token,
                        'assistance_status'=>$assistance_status,
                        'message' => 'Your registration is now confirmed'
                    );
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'error' => 'Some data not valid'
                    );
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Please upload profile picture'
                );
            }
            
        }
        //}
        return $returnresult;
    }

     /*-------------------------------add question list----------------------------------------------- */
    
    function add_question_answer($token,$user_id){

        $jsondata    = $_REQUEST['jsondata'];
         $loginuser_id = $user_id;
         //$loginuser_id ;
        $jsondatas = urldecode(stripslashes($jsondata));
        $data3 = json_decode($jsondatas);

            //$user_id = $_REQUEST['user_id'];
            $sql     = "SELECT question_id,user_id FROM tbl_user_question_answer where user_id='$loginuser_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
             $user_ids=$row->user_id;
             $question_ids=$row->question_id;
       
//die;

        foreach ($data3 as $row) {
              $user_id = $row->user_id;
              $question_id = $row->question_id;
              $answer = $row->answer;
              $yes_no_ans = $row->yes_no_ans;
              $other = $row->other;

       
         if($question_id==$question_ids && $user_ids==$user_id){
        $returnresult =  die(json_encode(array(
                'status' => 0,
                'message' => 'Question allrady available'
            )));
         }
else{
         $SQL = "insert into tbl_user_question_answer(user_id,question_id,answer,yes_no_ans,other,status)values('$user_id','$question_id','$answer','$yes_no_ans','$other','1')";
                $res = mysql_query($SQL);
   }
}

       if ($res) {
                  $data = array(
                  'assistance_status' => 0
            
                         );
        
             $this->db->where('user_id', $loginuser_id);
             $data = $this->db->update('tbl_user', $data);
              $sql     = "SELECT assistance_status FROM tbl_user where user_id='$loginuser_id'";
             $res     = $this->db->query($sql);
             $row     = $res->row();
             $assistance_status=$row->assistance_status;
            $returnresult = array(
                'status' => 1,
                'assistance_status'=>$assistance_status,
                'message' => 'Assistance info saved successfully'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
        
    }


  /*-------------------------------add question list----------------------------------------------- */
    
    function update_question_answer(){

        $jsondata    = $_REQUEST['jsondata'];
        $jsondatas = urldecode(stripslashes($jsondata));
        $data3 = json_decode($jsondatas);

        foreach ($data3 as $row) {
              $user_id = $row->user_id;
              $question_id = $row->question_id;
              $answer = $row->answer;
              $yes_no_ans = $row->yes_no_ans;
              $other = $row->other;

$sql = "SELECT question_id,user_id FROM tbl_user_question_answer where question_id='$question_id'and user_id='$user_id'";
             $res     = $this->db->query($sql);
             $rowdata     = $res->row();
             $question_ids=$rowdata->question_id;
             $user_ids=$rowdata->user_id;
           if($question_ids=="" && $user_ids=="")
            {

                $SQL = "insert into tbl_user_question_answer(user_id,question_id,answer,yes_no_ans,other,status)values('$user_id','$question_id','$answer','$yes_no_ans','$other','1')";
                $res = mysql_query($SQL);
   }else{

$SQL = "UPDATE tbl_user_question_answer SET question_id='$question_id',answer='$answer',yes_no_ans='$yes_no_ans',other='$other' where question_id='$question_id' and user_id='$user_id'";
                $res = mysql_query($SQL);
 }
}
       if ($res) {
           // $data = $this->db->update('tbl_user', $data);
            $returnresult = array(
                'status' => 1,
                'message' => 'Assistance info saved successfully'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
        
    }

    /*-------------------------------get city list----------------------------------------------- */
    
    function get_user_question_answer()
    {
         $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user_question_answer.*');
        $this->db->from('tbl_user_question_answer');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*-------------------------------get community list ----------------------------------------------- */
    
    
    function get_community()
    {
         $index = $_REQUEST['index'];
        // $starts=$index*10;
        $start = ($index-1)*10;
         
          $user_id = $_REQUEST['user_id'];
        $result  = $this->db->query("SELECT tc.community_name,tc.community_id,tc.community_description,tc.community_logo,tc.community_website,tc.community_email,tc.community_address,tc.add_date,tc.status,
ifnull((select ifnull(tcum.`request_status`,0) as request_status from `tbl_community_user_mapping` tcum where tcum.`user_id`=$user_id and tcum.`community_id`=tc.`community_id`),tc.`default_status`) as request_status
FROM `tbl_community` tc WHERE tc.status=1 and del_date='0000-00-00 00:00:00' ORDER BY add_date DESC LIMIT $start,10");
        return $result->result();
    }
    
    function get_page_number_community(){
     $user_id = $_REQUEST['user_id'];

  $result  =$this->db->query("SELECT tc.community_name,tc.community_id,tc.community_description,tc.community_logo,tc.community_website,tc.community_email,tc.community_address,tc.add_date,tc.status,
ifnull((select ifnull(tcum.`request_status`,0) as request_status from `tbl_community_user_mapping` tcum where tcum.`user_id`=$user_id and tcum.`community_id`=tc.`community_id`),tc.`default_status`) as request_status
FROM `tbl_community` tc WHERE tc.status=1 and del_date='0000-00-00 00:00:00'
");
  
  $total = count($result->result());
     
    $totalpage = $total/10;    
    $pagenumber = ceil($totalpage);
  return $pagenumber;
 }
    
    
    /*-------------------------------request community by user ----------------------------------------------- */
    
    
    function user_community_request()
    {
        $sql = "SELECT community_id,user_id FROM tbl_community_user_mapping WHERE community_id ='" . $_REQUEST['community_id'] . "' and user_id ='" . $_REQUEST['user_id'] . "' ";
        $res = $this->db->query($sql);
        $row = $res->row();
        if ($row) {
            $user_id      = $row->user_id;
            $community_id = $row->community_id;
            $data         = array(
                'request_status' => $_REQUEST['request_status']
            );
            $this->db->where('user_id', $user_id);
            $this->db->where('community_id', $community_id);
            $data = $this->db->update('tbl_community_user_mapping', $data);
            if ($data) {
                $sql            = "SELECT user_id,request_status FROM tbl_community_user_mapping WHERE user_id ='" . $user_id . "'";
                $res            = $this->db->query($sql);
                $row            = $res->row();
                $request_status = $row->request_status;
                $returnresult   = array(
                    'status' => 1,
                    'message' => 'User community request is confirmed',
                    'request_status' => $_REQUEST['request_status']
                );
            }
        } else {
            $data = array(
                'user_id' => $_REQUEST['user_id'],
                'community_id' => $_REQUEST['community_id'],
                'request_status' => $_REQUEST['request_status'],
                
                'status' => 1
            );
            $data = $this->db->insert('tbl_community_user_mapping', $data);
            
            $returnresult = array(
                'status' => 1,
                'message' => 'User community request is confirmed',
                'request_status' => $_REQUEST['request_status']
            );
        }
        
        return $returnresult;
    }
    
    
    /*-------------------------------get_community_emergency_contact list ----------------------------------------------- */
    
    function get_community_emergency_contact($id)
    {
        $tmp_community_id = $id;
       
        $this->db->select('community_emergency_number_id,community_emergency_number,community_emergency_number_type');
        $this->db->from('tbl_community_emergency_number');
        $this->db->where_in('tbl_community_emergency_number.community_id', $tmp_community_id);
        //$this->db->limit($start,10);
        $query = $this->db->get();
        return $query->result();
        
        
    }
    
   
    /*-------------------------------get_community_emergency_list ----------------------------------------------- */
    
    
    function get_community_emergency_list()
    {
        
        $user_id        = $_REQUEST['user_id'];
        $results        = $this->db->query("SELECT community_id from tbl_community_user_mapping where user_id=$user_id and request_status=1");
        $resultdata     = $results->result_array();
        $countvarresult = count($resultdata);

        for ($i = 0; $i < $countvarresult; $i++) {
            $id     = $resultdata[$i]['community_id'];
            $result = $this->db->query("SELECT * FROM tbl_community WHERE `community_id` IN ($id)");
            
        }
        
        
        return $result->result();
        
    }
    
    /*-------------------------------notification_setting ----------------------------------------------- */
    
    
    function notification_setting()
    {
        $check = "SELECT * FROM  tbl_notification WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row     = $res->row();
            $user_id = $row->user_id;
            $app     = $row->app;
            $email   = $row->email;
            $text    = $row->text;
            $voice   = $row->voice;
            
            if ($_REQUEST['notification_type'] == 'app') {
                
                if ($app == 1) {
                    $data = array(
                        'app' => 0,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                } else {
                    $data = array(
                        'app' => 1,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                }
            }
            if ($_REQUEST['notification_type'] == 'email') {
                
                if ($email == 1) {
                    $data = array(
                        'email' => 0,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                } else {
                    $data = array(
                        'email' => 1,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                }
            }
            if ($_REQUEST['notification_type'] == 'text') {
                
                if ($text == 1) {
                    $data = array(
                        'text' => 0,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                } else {
                    $data = array(
                        'text' => 1,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                }
            }
            
            if ($_REQUEST['notification_type'] == 'voice') {
                
                if ($voice == 1) {
                    $data = array(
                        'voice' => 0,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                } else {
                    $data = array(
                        'voice' => 1,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update('tbl_notification', $data);
                }
            }
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'User notification setting updated successfully'
                    
                );
            }
        }
        
        return $returnresult;
    }
    
    
    
    /*-------------------------------set_notification_tone----------------------------------------------- */
    
    
    function set_notification_tone()
    {
        $check = "SELECT * FROM  tbl_notification WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row     = $res->row();
            $user_id = $row->user_id;
            
            $data = array(
                'notification_tone' => $_REQUEST['notification_tone'],
                'user_id' => $_REQUEST['user_id']
                
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_notification', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'User notification tone updated successfully'
                    
                );
            }
        }
        
        
        return $returnresult;
    }
    
    
    /*-------------------------------update_profile----------------------------------------------- */
    
    function update_profile()
    {
       
        $checkuser = "SELECT phone_number_text_msg,email,user_id FROM tbl_user WHERE status=1 and (email ='" . $_REQUEST['email'] . "' OR phone_number_text_msg ='" . $_REQUEST['phone_number'] . "')";
        $resresult    = mysql_query($checkuser);
        $data  = mysql_fetch_array($resresult);
        $phone_number_text_msg = $data['phone_number_text_msg'];
        $email = $data['email'];
        $user_id = $data['user_id']; 
        if ($email==$_REQUEST['email'] && $user_id!= $_REQUEST['user_id']) {
            
           $returnresult = array(
                'status' => 0,
                'message' =>'This email is already registered with another user'
            );
          
        }
         elseif($phone_number_text_msg==$_REQUEST['phone_number'] && $user_id!= $_REQUEST['user_id']){
             $returnresult = die(json_encode(array(
                    "status" => 0,
                    "message" => "This Phone number is already registered with another user"
                )));
            }

        else{

        $check = "SELECT * FROM  tbl_user WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row     = $res->row();
            $user_id = $row->user_id;
            $data    = array(
                
                'user_id' => $_REQUEST['user_id'],
                'first_name' => $_REQUEST['first_name'],
                'last_name' => $_REQUEST['last_name'],
                 'email' => $_REQUEST['email'],
                'language' => $_REQUEST['language'],
                'phone_number_text_msg' => $_REQUEST['phone_number'],
                'medical_history' => $_REQUEST['medical_history'],
                'medication_instraction' => $_REQUEST['medication_instraction'],
                'previous_surgeries_procedure' => $_REQUEST['previous_surgeries_procedure'],
                'allergies' => $_REQUEST['allergies'],
                'special_need' => $_REQUEST['special_need'],
                 'radius' => $_REQUEST['radius']
                
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_user', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'User profile updated successfully'
                );
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Some data not valid'
                );
            }
            
            }
        }
            return $returnresult;
        
    
    }
    
    
    /*-------------------------------update_profile_picture----------------------------------------------- */
    
    function update_profile_picture()
    {
        
        $check = "SELECT * FROM tbl_user WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row         = $res->row();
            $user_id     = $row->user_id;
            $target      = "./uploads/";
            $target      = $target . basename($_FILES['profile_pic']['name']);
            $profile_pic = ($_FILES['profile_pic']['name']);
            
           
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
               
                $data = array(
            
                    'profile_pic' => $profile_pic
                );
                $this->db->where('user_id', $user_id);
                $data = $this->db->update('tbl_user', $data);
                if ($data) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'User profile updated successfully'
                    );
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Some data not valid'
                );
            }
            return $returnresult;
        }
        
    }
    
    
    /*-------------------------------update_home_address----------------------------------------------- */
    
    
    function update_home_address()
    {
        
        $check = "SELECT * FROM  tbl_user_address WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row     = $res->row();
            $user_id = $row->user_id;
            
            $data = array(
                'user_id' => $_REQUEST['user_id'],
                'home_address_line_1' => $_REQUEST['home_address_line_1'],
                'home_address_line_2' => $_REQUEST['home_address_line_2'],
                'city_id' => $_REQUEST['city_id'],
                'state_id' => $_REQUEST['state_id'],
                'zip' => $_REQUEST['zip'],
                'country_id' => $_REQUEST['country_id'],
                'status' => 1
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_user_address', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'Home address saved successfully'
                );
            }
        } else {
            $data = array(
                'user_id' => $_REQUEST['user_id'],
                'home_address_line_1' => $_REQUEST['home_address_line_1'],
                'home_address_line_2' => $_REQUEST['home_address_line_2'],
                'city_id' => $_REQUEST['city_id'],
                'state_id' => $_REQUEST['state_id'],
                'zip' => $_REQUEST['zip'],
                'country_id' => $_REQUEST['country_id'],
                'status' => 1
            );
            $data = $this->db->insert('tbl_user_address', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'Home address saved successfully'
                );
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Some data not valid'
                );
            }
        }
        return $returnresult;
    }
    
    
    /*-------------------------------add_user_emergency_contact----------------------------------------------- */
    
    
    function add_user_emergency_contact()
    {
        
        
        $tap911_user            = $_REQUEST['tap911_user'];
        $emergency_user_help_id = $_REQUEST['emergency_user_help_id'];
        $user_id                = $_REQUEST['user_id'];
        
        $values = explode(',', $emergency_user_help_id);
        
        foreach ($values as $value) {
            
            $emergency_user_help_id = $value;
            
            $result = $this->db->query("SELECT * FROM tbl_user WHERE user_id IN ('$emergency_user_help_id')");
            $data   = $result->result_array();
            $countvar = count($data);
            for ($i = 0; $i < $countvar; $i++) {
                $firstname    = $data[$i]['first_name'];
                $last_name    = $data[$i]['last_name'];
                $phone_number = $data[$i]['phone_number_text_msg'];
                $name         = $firstname . " " . $last_name;
                
                $SQL = "insert into tbl_emergency_contact(user_id,emergency_user_help_id,name,phone_number,tap911_user,country_code,status)
            values('$user_id','$emergency_user_help_id','$name','$phone_number','$tap911_user','1','1')";
                $res = mysql_query($SQL);
                
            }
        }
        if ($res) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User emergency contact successfully submit'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
    }
    
    
    /*-------------------------------update_user_emergency_contact with community----------------------------------------------- */
    
    
    function update_user_emergency_contact()
    {
        $check = "SELECT * FROM  tbl_emergency_contact WHERE emergency_contact_id ='" . $_REQUEST['emergency_contact_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row                  = $res->row();
            $emergency_contact_id = $row->emergency_contact_id;
            
            $data = array(
                'emergency_contact_id' => $_REQUEST['emergency_contact_id'],
                'name' => $_REQUEST['name'],
                'description' => $_REQUEST['description'],
                'phone_number' => $_REQUEST['phone_number'],
                'tap911_user' => $_REQUEST['tap911_user'],
                'country_code' => $_REQUEST['country_code'],
                'status' => 1
            );
            $this->db->where('emergency_contact_id', $emergency_contact_id);
            $data = $this->db->update('tbl_emergency_contact', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'Contact updated successfully'
                );
            }
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'contact not found'
            );
        }
        
        return $returnresult;
        
    }
    
    
    /*-------------------------------get_home_address----------------------------------------------- */
    
    
    function get_home_address()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user_address.*,tbl_country.*,tbl_city.*, tbl_state.*,tbl_user.*');
        $this->db->from('tbl_user_address');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_user_address.user_id', 'INNER');
        $this->db->join('tbl_country', 'tbl_country.country_id = tbl_user_address.country_id', 'INNER');
        $this->db->join('tbl_state', 'tbl_state.state_id = tbl_user_address.state_id', 'INNER');
        $this->db->join('tbl_city', 'tbl_city.city_id = tbl_user_address.city_id', 'INNER');
        $this->db->where('tbl_user.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
        
    }
    
    
    /*-------------------------------get_emergency_contact----------------------------------------------- */
    
    
    
    function get_emergency_contact()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_emergency_contact.*,tbl_user.*');
        $this->db->from('tbl_emergency_contact');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_emergency_contact.user_id', 'INNER');
        $this->db->where('tbl_emergency_contact.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
        
    }
    
    /*-------------------------------get_user_profiledata----------------------------------------------- */
    
    function get_user_profiledata()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.*');
        $this->db->from('tbl_user');
        $this->db->where('tbl_user.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*-------------------------------get_notification_setting----------------------------------------------- */
    
    function get_notification_setting()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_notification.*');
        $this->db->from('tbl_notification');
        $this->db->where('tbl_notification.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*-------------------------------get_country_emergency_number----------------------------------------------- */
    
    function get_country_emergency_number()
    {
        $this->db->select('tbl_country.*');
        $this->db->from('tbl_country');
        $this->db->where('tbl_country.status', 1);
        $this->db->order_by("tbl_country.country_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    /*-------------------------------get_country_emergency_number_with_token----------------------------------------------- */
    
    function get_country_emergency_number_with_token()
    {
        $this->db->select('tbl_country.*');
        $this->db->from('tbl_country');
        $this->db->where('tbl_country.status', 1);
        $this->db->order_by("tbl_country.country_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    /*-------------------------------add_emergency_tracking----------------------------------------------- */
    
    
    function add_emergency_tracking()
    {
        
        if (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }
        $dateValue = date("Y-m-d H:i:s");
        $time      = strtotime($dateValue);
        $month     = date("F", $time);
        $year      = date("Y", $time);
        $table     = "tbl_tracking" . '_' . $month . '_' . $year;
        
        $sql = "CREATE TABLE IF NOT EXISTS $table(
     `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
       `user_id` int(11) NOT NULL,
       `address` varchar(255) NOT NULL,
      `latitude` varchar(100) NOT NULL,
       `longitude` varchar(100) NOT NULL,
       `add_uid` int(11) NOT NULL,
       `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `del_uid` int(11) NOT NULL,
       `del_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
       `status` tinyint(1) NOT NULL,
       `gps_status` tinyint(1) NOT NULL DEFAULT '1',
        PRIMARY KEY (tracking_id)
)";
        if ($this->db->query($sql)) {
            
            $check = "SELECT * FROM  $table WHERE user_id ='" . $_REQUEST['user_id'] . "'";
            $res   = $this->db->query($check);

            if ($res->num_rows > 0 && $check != "") {
                $row     = $res->row();
                $user_id = $row->user_id;
                $data    = array(
                    'user_id' => $_REQUEST['user_id'],
                    'address' => $_REQUEST['address'],
                    'latitude' => $_REQUEST['latitude'],
                    'longitude' => $_REQUEST['longitude'],
                    'status' => 1
                );
                $this->db->where('user_id', $user_id);
                $data = $this->db->update($table, $data);
                if ($data) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'User emergency tracking update successfully'
                    );
                }
            } else {
                $data = array(
                    'user_id' => $_REQUEST['user_id'],
                    'address' => $_REQUEST['address'],
                    'latitude' => $_REQUEST['latitude'],
                    'longitude' => $_REQUEST['longitude'],
                    'status' => 1
                );
                $data = $this->db->insert($table, $data);
                if ($data) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'User emergency tracking successfully submit'
                    );
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Some data not valid'
                    );
                }
            }
            return $returnresult;
        }
    }
	
	
	function add_emergency_tracking_latest($token,$data,$user_id)
    {
		if (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }
        $dateValue = date("Y-m-d H:i:s");
        $time      = strtotime($dateValue);
        $month     = date("F", $time);
        $year      = date("Y", $time);
        $table     = "tbl_tracking" . '_' . $month . '_' . $year;
        
        $sql = "CREATE TABLE IF NOT EXISTS $table(
     `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
       `user_id` int(11) NOT NULL,
       `address` varchar(255) NOT NULL,
      `latitude` varchar(100) NOT NULL,
       `longitude` varchar(100) NOT NULL,
       `add_uid` int(11) NOT NULL,
       `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `del_uid` int(11) NOT NULL,
       `del_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
       `status` tinyint(1) NOT NULL,
       `gps_status` tinyint(1) NOT NULL DEFAULT '1',
        PRIMARY KEY (tracking_id)
)";
        if ($this->db->query($sql)) {
            
            $check = "SELECT * FROM  $table WHERE user_id ='" . $user_id . "'";
            $res   = $this->db->query($check);

            if ($res->num_rows > 0 && $check != "") {
                $row     = $res->row();
                $user_id = $row->user_id;
                $data    = array(
                    'user_id' => $user_id,
                    'address' => $data['address'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'status' => 1
                );
                $this->db->where('user_id', $user_id);
                $data = $this->db->update($table, $data);
                if ($data) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'User emergency tracking update successfully'
                    );
                }
            } else {
                $data = array(
                    'user_id' => $user_id,
                    'address' => $data['address'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'status' => 1
                );
                $data = $this->db->insert($table, $data);
                if ($data) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'User emergency tracking successfully submit'
                    );
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Some data not valid'
                    );
                }
            }
            return $returnresult;
        }
    }
    
    
    /*-------------------------------get emergency tracking list----------------------------------------------- */
    
    
    function get_emergency_tracking()
    {
        $this->db->select('tbl_emergency.*');
        $this->db->from('tbl_emergency');
        $this->db->where('tbl_emergency.status', 1);
        $this->db->order_by("tbl_emergency.emergency_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    /*-------------------------------get state list----------------------------------------------- */
    
    function get_state()
    {
        $this->db->select('tbl_state.*');
        $this->db->from('tbl_state');
        $this->db->where('tbl_state.status', 1);
        $this->db->order_by("tbl_state.state_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /*-------------------------------get city list----------------------------------------------- */
    
    function get_city()
    {
        $this->db->select('tbl_city.*');
        $this->db->from('tbl_city');
        $this->db->where('tbl_city.status', 1);
        $this->db->order_by("tbl_city.city_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    /*-------------------------------delete user from user list----------------------------------------------- */
    
    function delete_user()
    {
        $user_id = $_REQUEST['user_id'];
        
        $data = array(
            
            'status' => 0
        );
        $this->db->where('user_id', $user_id);
        $data = $this->db->update('tbl_user', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User delete successfully'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        return $returnresult;
    }
    
    
    
    /*-------------------------------delete emergency contact list----------------------------------------------- */
    
    
    function delete_emergency_contact()
    {
        $emergency_contact_id = $_REQUEST['emergency_contact_id'];
        $this->db->where('emergency_contact_id', $emergency_contact_id);
        $data = $this->db->delete('tbl_emergency_contact');
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'Contact deleted successfully'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        return $returnresult;
    }
    
    
    // /*-------------------------------send notification emergency contact----------------------------------------------- */
    
    public function send_notification_emegrency_contact($ids, $user_lat, $user_long)
    {
        $ids        = $ids;
        $user_lat   = $user_lat;
        $user_long  = $user_long;

        $sql        = "SELECT * FROM tbl_emergency where emergency_id='$ids'";
        $res        = $this->db->query($sql);
        $row        = $res->row();
        $emuserid   = $row->user_id;
        $sql        = "SELECT * FROM tbl_user WHERE `user_id`='$emuserid' and login_status=1";
        $resultdata = $this->db->query($sql);
        $resultdata = $resultdata->row();
        $emfirst_name = $resultdata->first_name;
        $emlast_name  = $resultdata->last_name;
        $user_name = $emfirst_name . " " . $emlast_name;
        // print_r($notification_device_token);die();
        
        $results           = $this->db->query("SELECT * from tbl_emergency_contact where user_id='$emuserid' and tap911_user=1");
        $remergencycontact = $results->result_array();
        $countvarresults   = count($remergencycontact);
        $require           = array();
        for ($j = 0; $j < $countvarresults; $j++) {
            
                $id = $remergencycontact[$j]['emergency_user_help_id'];
            
                
                $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id,creator_id)values('$id','$ids','$emuserid')";
                $res = mysql_query($SQL);
                
                $sql     = "SELECT * FROM tbl_user WHERE `user_id` IN('$id') and login_status=1";
                $results = $this->db->query($sql);
                $result  = $results->row();
                
                //  print_r($result);
                
                if ($result) {
                    $notification_device_token = $result->notification_device_token;
                    $first_name                = $result->first_name;
                    $last_name                 = $result->last_name;
                    $helpuser_name                 = $first_name . " " . $last_name;
                    // print_r($notification_device_token);die();
                    $mobile_type               = $result->mobile_type;
                     $user_id               = $row->user_id;
                    $sql        = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
                    $resultdatatone = $this->db->query($sql);
                    $resultdatatone = $resultdatatone->row();
                    $notification_tone = $resultdatatone->notification_tone;
                    $ch                        = curl_init("https://fcm.googleapis.com/fcm/send");
                    $sound = $notification_tone;
                     if($sound==""){
                     $sound="notification01.mp3";
                     }else{
                     $sound = $notification_tone;
                     }
                    $usertoken    = $notification_device_token;
                    $title        = "Emergency Request" ;
                    $body         =  $user_name." "."need your help. Click to help.";
                    $click_action    = "ALERT";
                $notification= array(
                     'title' => $title,
                     'text' => $body,
                     'sound'=>$sound,
                     'click_action'=>$click_action
                );
                    $arrayToSend  = array(
                        'to' => $usertoken,
                        'notification' => $notification,
                        'priority' => 'high'
                    );
                    
                    $json      = json_encode($arrayToSend);
                    $headers   = array();
                    $headers[] = 'Content-Type: application/json';
                    if ($mobile_type == 'android') {
                        $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
                    } else {
                        $headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
                    }
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                     array_push($require, curl_exec($ch));
                    
               
                 $returnresult = array(
                               'status' => 1,
                               'data' => $require,
                               'message' => 'success'
            
                         );

                    curl_close($ch);
                    if ($mobile_type == 'android' || $mobile_type == 'ios') {
                        
                    }
                }
                
             if($returnresult){
                $data = json_encode($returnresult);
                print_r($data);
               }
                else{
                $data = die(json_encode(array(
                "status" => 0,
               "message" =>"No user on radius"
                        )));
                print_r($data);
               }
           
        }
         return $returnresult;   
    }
    
    
    /*-------------------------------emergency create by user ----------------------------------------------- */
    
    
    // public function add_emergency_user()
    // {
    //    $user_lat  = $_REQUEST['emergency_latitude'];
    //     $user_long = $_REQUEST['emergency_longitude'];
    //     $emergency_address = $_REQUEST['emergency_address'];
    //     //print_r($_REQUEST['emergency_address']);
    //     $data      = array(
    //         'user_id' => $_REQUEST['user_id'],
    //         'emergency_latitude' => $user_lat,
    //         'emergency_longitude' => $user_long,
    //         'emergency_address' => $emergency_address,
    //         'emergency_type' => $_REQUEST['emergency_type'],
    //         'status' => 1);
        
    //     $data = $this->db->insert('tbl_emergency', $data);
    //     $ids  = $this->db->insert_id();

    //     $sqluser        = "SELECT * FROM tbl_user where user_id='".$_REQUEST['user_id']."'";
    //     $raduisres      = $this->db->query($sqluser);
    //     $user_row       = $raduisres->row();
    //     $radius         = $user_row->radius;
    //     $emfirst_name   = $user_row->first_name;
    //     $emlast_name    = $user_row->last_name;
    //     $user_name      = $emfirst_name . " " . $emlast_name;
    //     // print_r($notification_device_token);die();
        
    //     $results        = $this->db->query("SELECT * from tbl_emergency_contact where tap911_user=1 and user_id='".$_REQUEST['user_id']."'");
    //     $remergencycontact = $results->result_array();
    //     $countvarresults   = count($remergencycontact);
    //     if($countvarresults){
    //         $emergency_contact_user = array();
    //         for ($j = 0; $j < $countvarresults; $j++) {
    //             $emergency_contact_user[] =$remergencycontact[$j]['emergency_user_help_id'];
    //         }
    //     }
               
    //     $dateValue = date("Y-m-d H:i:s");
    //     $time      = strtotime($dateValue);
    //     $month     = date("F", $time);
    //     $year      = date("Y", $time);
    //     $table     = "tbl_tracking" . '_' . $month . '_' . $year;
    //     $emergency_contact_user_string     = implode(',', $emergency_contact_user);

    //     $result = $this->db->query("SELECT $table.*, $table.add_date as userdate,tbl_user.*,tbl_user.add_date as adate,
    //         3956 * 2 * ASIN(SQRT( POWER(SIN(($user_lat -  $table.latitude) * pi()/180 / 2), 2) + COS($user_lat * pi()/180) * COS( $table.latitude * pi()/180) *
    //         POWER(SIN(($user_long -  $table.longitude) * pi()/180 / 2), 2) )) as
    //         distance FROM $table
    //         JOIN  tbl_user on tbl_user.user_id =   $table.user_id
    //         WHERE tbl_user.login_status=1 and $table.gps_status=1 and $table.user_id NOT IN ('$emergency_contact_user_string') and $table.user_id NOT IN ('" . $_REQUEST['user_id'] ."')    
    //         GROUP BY  $table.tracking_id HAVING distance <= $radius ORDER by distance ASC");
    //     $datavalue  = $result->result_array();
    //     $countvars  = count($datavalue);
       
    //     for ($i = 0; $i < $countvars; $i++) {
    //         $uid[]=$datavalue[$i]['user_id'];
    //     }
    //     $values=array_merge($emergency_contact_user,$uid);
    //     $result = $this->db->query("SELECT * FROM tbl_user WHERE user_id IN (".implode(',',$values).")");
    //     $data   = $result->result_array();
    //     print_r($data);
    //     $countvar = count($data);
    //     $require    = array();
    //     for ($i = 0; $i < $countvar; $i++) {
    //         $uids    = $data[$i]['user_id'];
    //         $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id,creator_id)values('$uids','$ids','".$_REQUEST['user_id']."')";
    //         $res = mysql_query($SQL);


    //         $notification_device_token = $data[$i]['notification_device_token'];
    //         $first_names                = $data[$i]['first_name'];
    //         $last_names                 = $data[$i]['last_name'];
    //         $helpuser_name                = $first_names . " " . $last_names;
    //         $mobile_type               = $data[$i]['mobile_type'];
    //         $user_id               = $data[$i]['user_id'];
    //         $ch                     = curl_init("https://fcm.googleapis.com/fcm/send");
    //         $sound="default_ringtone.mp3";
    //         $usertoken    = $notification_device_token;
    //         $title        = $_REQUEST['emergency_type']." "."Emergency Request";
    //         $body         =  $user_name." "."need your help. Click to help.";
    //         $click_action    = "ALERT";
    //         $notification= array(
    //              'title' => $title,
    //              'text' => $body,
    //              'sound'=>$sound,
    //              'click_action'=>$click_action
    //         );
    //         $arrayToSend  = array(
    //             'to' => $usertoken,
    //             'notification' => $notification,
    //             'priority' => 'high'
    //         );
                
    //         $json      = json_encode($arrayToSend);
    //         $headers   = array();
    //         $headers[] = 'Content-Type: application/json';
    //         if ($mobile_type == 'android') {
    //             $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
    //         } else {
    //             $headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
    //         }
    //         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //         array_push($require, curl_exec($ch));
               
               
    //         curl_close($ch);
    //         if ($mobile_type == 'android' || $mobile_type == 'ios') {
                    
    //         }

    //     }
    //     $returnresult = array(
    //         'status' => 1,
    //         'response' => $require,
    //         'message' => 'success'
    //     );  
    //     return $returnresult;
    // }
    
    /*-------------------------------accept_emergency_request----------------------------------------------- */
    
    
    function accept_emergency_request()
    {
         $emergency_notification_id = $_REQUEST['emergency_notification_id'];
        //$emergency_notification_id = $_REQUEST['emergency_notification_id'];
        $result                    = "SELECT * FROM  tbl_emergency_notification WHERE emergency_notification_id ='" . $_REQUEST['emergency_notification_id'] . "'";
        $res                       = $this->db->query($result);
        $row                       = $res->row();
        $emergency_id              = $row->emergency_id;
        $notification_user_id      = $row->notification_user_id;
        $creator_id      = $row->creator_id;
		
    
$enduser = "SELECT COUNT(4) as totalvalue FROM tbl_emergency_notification WHERE emergency_status = 4 and emergency_id='" . $emergency_id . "'";
        $enduserresult  = $this->db->query($enduser);
        $endresult     = $enduserresult->result_array();
        $countresult = count($endresult);

   for ($j = 0; $j < $countresult; $j++) {
            $endvalue = $endresult[$j]['totalvalue'];
            
        }

         if($endvalue>0){

        $returnresult = array(
                'status' => 0,
                'message' => 'This emergency is ended by other user.'
            );
            $closedemrgency = array(
                'emergency_status' => 4, 
            );
            $this->db->where('emergency_id', $emergency_id);
            $this->db->update('tbl_emergency_notification', $closedemrgency);

         }
else{
        $check    = "SELECT COUNT(1) as total FROM tbl_emergency_notification WHERE emergency_status = 1 and emergency_id='" . $emergency_id . "'";
        $res      = $this->db->query($check);
        $data     = $res->result_array();
        $countvar = count($data);
        for ($i = 0; $i < $countvar; $i++) {
            $value = $data[$i]['total'];
            
        }                    
        
        if($value==2) {
            
            $returnresult = array(
                'status' => 0,
                'message' => 'This emergency is already accepted by two users.'
            );

            $data = array(
                'emergency_status' => 3
            );
             $this->db->where('emergency_notification_id',$emergency_notification_id);
            $data = $this->db->update('tbl_emergency_notification', $data);
            
         }
        else {
            $date = date("Y-m-d H:i:s");
            $data = array(
                'emergency_status' => 1,
                'accept_date_time' => $date
                
            );
            $this->db->where('emergency_notification_id', $emergency_notification_id);
            $data = $this->db->update('tbl_emergency_notification', $data);

     $check    = "SELECT COUNT(1) as totals FROM tbl_emergency_notification WHERE emergency_status = 1 and emergency_id='" . $emergency_id . "'";
        $res      = $this->db->query($check);
        $datavalue     = $res->result_array();
        $countvars = count($datavalue);
        for ($i = 0; $i < $countvars; $i++) {
            $toatlvalue = $datavalue[$i]['totals'];
            
        } 
        if($toatlvalue==2){
          $data = array(
             'emergency_status' => 3
                
            );
             $this->db->where_not_in('emergency_status', 1);
             $this->db->where('emergency_id', $emergency_id);
            $data = $this->db->update('tbl_emergency_notification', $data);
        }
            
            $emergency_notification_id = $_REQUEST['emergency_notification_id'];
            
            $result               = "SELECT emergency_id,notification_user_id FROM  tbl_emergency_notification WHERE emergency_notification_id ='" . $_REQUEST['emergency_notification_id'] . "'";
               $res                  = $this->db->query($result);
               $row                  = $res->row();
               $emergency_id         = $row->emergency_id;
                $user_ids = $row->notification_user_id;

                $result     = "SELECT first_name,last_name FROM  tbl_user WHERE user_id ='" . $user_ids . "'";
                $resultdata        = $this->db->query($result);
                $rowdata        = $resultdata->row();
                $first_name = $rowdata->first_name;
                $last_name = $rowdata->last_name;
                $require = array();
                $result  = "SELECT user_id FROM tbl_emergency WHERE emergency_id ='" . $emergency_id . "'";
                $emuser     = $this->db->query($result);
                $emrow     = $emuser->row();
                $user_id = $emrow->user_id;
                
                
                $sql                       = "SELECT notification_device_token,mobile_type,user_id FROM tbl_user WHERE user_id='$user_id'";
                $res                       = $this->db->query($sql);
                $row                       = $res->row();
                $notification_device_token = $row->notification_device_token;
                $mobile_type               = $row->mobile_type;
                $user_id                   = $row->user_id;
                $sql                       = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
                    $resultdatatone = $this->db->query($sql);
                    $resultdatatone = $resultdatatone->row();
                    $notification_tone = $resultdatatone->notification_tone;
                    $sound = $notification_tone;
                     if($sound==""){
                     $sound="notification01.mp3";
                     }else{
                     $sound = $notification_tone;
                     }
				
				$results        = $this->db->query("SELECT * from tbl_emergency_contact where user_id='".$creator_id."' and tap911_user=1");
				$remergencycontact = $results->result_array();
				$countvarresults   = count($remergencycontact);
				if($countvarresults){
					$emergency_contact_user = array();
					for ($j = 0; $j < $countvarresults; $j++) {
						$emergency_contact_user[] =$remergencycontact[$j]['emergency_user_help_id'];
					}
				}
				
                $ch  = curl_init("https://fcm.googleapis.com/fcm/send");
                    $usertoken    = $notification_device_token;
                    $title        = "Emergency Request" ;
					//print_r($emergency_contact_user);
					//exit;
                    if(in_array($user_ids,$emergency_contact_user)){
						$body =  $first_name." ".$last_name." ".'has accepted your request.';
					}else{
						$body =  'Someone has accepted your request.';
					}
					//$body         =  $first_name." ".$last_name." ".'has accepted your request.';
                    $click_action    = "ALERT";
                $notification              = array(
                     'title' => $title,
                     'text' => $body,
                     'sound'=>$sound,
                     'click_action'=>$click_action
                );
                $arrayToSend               = array(
                    'to' => $notification_device_token,
                    'notification' => $notification,
                    'priority' => 'high'
                );
                
                $json      = json_encode($arrayToSend);
                $headers   = array();
                $headers[] = 'Content-Type: application/json';
                if ($mobile_type == 'android') {
                    $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
                } else {
                    $headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
                }
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $returnresult = 
                array_push($require, curl_exec($ch));
                curl_close($ch);
                if ($mobile_type == 'android' || $mobile_type == 'ios') {
                    
                    
                }
          // }
             $returnresult = array(
            'status' => 1,
            'message' => 'success'
           );
         }
     }
        
        return $returnresult;
    }
    
    
    /*-------------------------------get_emergency_live_location----------------------------------------------- */
    
    
    function get_emergency_live_location()
    {
        
        // if (!ini_get('date.timezone')) {
        //     date_default_timezone_set('UTC');
        // }
        $dateValue    = date("Y-m-d H:i:s");
        $time         = strtotime($dateValue);
        $month        = date("F", $time);
        $year         = date("Y", $time);
        $table        = "tbl_tracking" . '_' . $month . '_' . $year;
        $emergency_id = $_REQUEST['emergency_id'];
        $this->db->select('' . $table . '.*,tbl_user.*,tbl_emergency.*,tbl_emergency_notification.*');
        $this->db->from('' . $table . '');
        $this->db->join('tbl_user', 'tbl_user.user_id = ' . $table . '.user_id', 'INNER');
        $this->db->join('tbl_emergency_notification', 'tbl_emergency_notification.notification_user_id = ' . $table . '.user_id', 'INNER');
        $this->db->join('tbl_emergency', 'tbl_emergency.emergency_id = tbl_emergency_notification.emergency_id', 'INNER');
        $this->db->where('tbl_emergency_notification.emergency_id', $emergency_id);
        $this->db->where('tbl_emergency_notification.emergency_status', 1);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /*-------------------------------get_user_type----------------------------------------------- */
    
    
    function get_user_type()
    {
        $this->db->select('*');
        $this->db->from('tbl_user_type');
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /*-------------------------------add_community_communitaction----------------------------------------------- */
    
    
    function add_community_communitaction()
    {
        
        $data = array(
            'from_user_id' => $_REQUEST['from_user_id'],
            'to_user_id' => $_REQUEST['to_user_id'],
            'community_id' => $_REQUEST['community_id'],
            'message_data' => $_REQUEST['message_data'],
            'msg_type' => $_REQUEST['msg_type'],
            
            'status' => 1
        );
        $data = $this->db->insert('tbl_community_communitaction', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'Message successfully submit'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
    }
    
    
    /*-------------------------------add_emergency_communitaction----------------------------------------------- */
    
    function add_emergency_communitaction()
    {
        
        $data = array(
            'user_id' => $_REQUEST['user_id'],
            'emergency_id' => $_REQUEST['emergency_id'],
            'message_data' => $_REQUEST['message_data'],
            'status' => 1
        );
        $data = $this->db->insert('tbl_emergency_communitaction', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'Message successfully submit'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
    }
    
    
    /*-------------------------------get_emergancy_communication----------------------------------------------- */
    
    function get_emergancy_communication()
    {
        $emergency_id = $_REQUEST['emergency_id'];
        $this->db->select('tbl_emergency_communitaction.*,tbl_user.*,tbl_emergency.*');
        $this->db->from('tbl_emergency_communitaction');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_emergency_communitaction.user_id', 'left');
        $this->db->join('tbl_emergency', 'tbl_emergency.emergency_id = tbl_emergency_communitaction.emergency_id', 'left');
        $this->db->where('tbl_emergency_communitaction.emergency_id', $emergency_id);
        $query = $this->db->get();
        //  echo $this->db->last_query();
        return $query->result();
        
    }
    
    
    /*-------------------------------get_community_communication----------------------------------------------- */
    
    
    function get_community_communication($time_zone)
    {
          $index = $_REQUEST['index'];
        // $starts=$index*10;
           $start = ($index-1)*10;
            $from_user_id = $_REQUEST['from_user_id'];
            $community_id = $_REQUEST['community_id'];
            $timezone1 = explode("+",$time_zone);
            $timezone2 = explode("-",$time_zone);
            $time1=$timezone1[1];
            $time2=$timezone2[1];
            if($time1!=""){
              $time="+".$timezone1[1];
            }else{
               $time="-".$timezone2[1];
            }

$result  =$this->db->query("SELECT community_communitaction_id,from_user_id,to_user_id,community_id,community_id,message_data,add_date,msg_type,CONVERT_TZ(add_date, @@session.time_zone, '$time')as senddate
 FROM `tbl_community_communitaction`
 WHERE from_user_id=$from_user_id and community_id= $community_id ORDER BY `tbl_community_communitaction`.add_date DESC LIMIT $start,10");
return $result->result();


    }
    
    /*-------------------------------total_community_msg----------------------------------------------- */
    
    
    function total_community_msg()
    {
        
            $from_user_id = $_REQUEST['from_user_id'];
            $community_id = $_REQUEST['community_id'];
            
$result  =$this->db->query("SELECT community_communitaction_id,from_user_id,to_user_id,community_id,community_id,message_data,add_date,msg_type
 FROM `tbl_community_communitaction`
 WHERE from_user_id=$from_user_id and community_id= $community_id");
 $total = count($result->result());
     
    $totalpage = $total/10;    
    $pagenumber = ceil($totalpage);
  return $pagenumber;

    }


    /*-------------------------------get_tap911_user_list----------------------------------------------- */
    
    
    function get_tap911_user_list()
    {
        
        $user_id   = $_REQUEST['user_id'];
        $result    = $this->db->query("SELECT emergency_user_help_id,user_id FROM tbl_emergency_contact WHERE user_id='$user_id' and status=1");
        $data      = $result->result_array();
        $countvar  = count($data);
        $arrayName = array();
        for ($i = 0; $i < $countvar; $i++) {
            
            $emergency_user_help_id = $data[$i]['emergency_user_help_id'];
            
            $arr = array(
                $emergency_user_help_id
            );
            
            $arr[0];
            array_push($arrayName, $arr[0]);
            
        }
        $result = implode(",", $arrayName);
        
       // echo $result;die;
        if ($result) {
    $query = $this->db->query("SELECT * FROM `tbl_user` WHERE user_id NOT IN($result) and user_id NOT IN($user_id)");
            $data  = $query->result();
        } else {
            $query = $this->db->query("SELECT * FROM `tbl_user` WHERE  user_id NOT IN($user_id)");
            $data  = $query->result();
            
        }
        return $data;
        
    }
    
    /*-------------------------------get_community_contact----------------------------------------------- */
    
    
    function get_community_contact()
    {
        $community_id = $_REQUEST['community_id'];
        $this->db->select('tbl_community_emergency_number.*');
        $this->db->from('tbl_community_emergency_number');
        $this->db->where('tbl_community_emergency_number.community_id', $community_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /*-------------------------------add_other_emergency_contact----------------------------------------------- */
    
    
    function add_other_emergency_contact()
    {
        $checkdata = "SELECT user_id,phone_number_text_msg FROM tbl_user WHERE user_id ='" . $_REQUEST['user_id'] ."'";
             $res     = $this->db->query($checkdata);
            $row     = $res->row();
            $phone_number_text_msg=$row->phone_number_text_msg;
        $check = "SELECT * FROM tbl_emergency_contact WHERE user_id ='" . $_REQUEST['user_id'] . "' and phone_number ='" . $_REQUEST['phone_number'] . "' ";
        $rs    = mysql_query($check);
        $data  = mysql_fetch_array($rs);
        if ($data[0] > 1) {
            $returnresult = array(
                'status' => 0,
                'message' => 'This contact is already exist'
            );
        }
            elseif($phone_number_text_msg==$_REQUEST['phone_number']){
              $returnresult = die(json_encode(array(
                    "status" => 0,
                    "message" => "Please do not insert your own number"
                )));
            }
         else {
            if (!is_numeric($_REQUEST['phone_number'])) {
                $returnresult = die(json_encode(array(
                    "status" => 0,
                    "message" => "Please Enter number only"
                )));
            }
            $data = array(
                'user_id' => $_REQUEST['user_id'],
                'tap911_user' => $_REQUEST['tap911_user'],
                'emergency_user_help_id' => 0,
                'name' => $_REQUEST['name'],
                'description' => $_REQUEST['description'],
                'phone_number' => $_REQUEST['phone_number'],
                'country_code' => $_REQUEST['country_code'],
                'status' => 1
            );
            $data = $this->db->insert('tbl_emergency_contact', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'Contact added successfully'
                );
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Some data not valid'
                );
            }
        }
        
        return $returnresult;
    }
    
    
    
    /*-------------------------------end emergency for help user----------------------------------------------- */
    
    
    function end_emergency_by_helping_user()
    {
         $notification_user_id = $_REQUEST['notification_user_id'];
         $emergency_id         = $_REQUEST['emergency_id'];
         $message_data         = $_REQUEST['message_data'];
		 $close_uid         = $_REQUEST['notification_user_id'];
		 
		$sql_eme = "SELECT user_id FROM tbl_emergency WHERE emergency_id='$emergency_id'";
		$result_eme = $this->db->query($sql_eme);
		$datas_eme = $result_eme->row();
		$creater_id['notification_user_id'] = $datas_eme->user_id;
        
        $check    = "SELECT COUNT(1) as totalresult FROM tbl_emergency_notification WHERE emergency_status = 1 and emergency_id='" . $emergency_id . "'";
        $resone      = $this->db->query($check);
        $onedata     = $resone->result_array();
        $countvarone = count($onedata);
        for ($i = 0; $i < $countvarone; $i++) {
            $value = $onedata[$i]['totalresult'];
             
             } 

             $checkdata    = "SELECT COUNT(2) as totalresults FROM tbl_emergency_notification WHERE emergency_status = 2 and emergency_id='" . $emergency_id . "'";
        $restwo      = $this->db->query($checkdata);
        $datatwo     = $restwo->result_array();
        $countvartwo = count($datatwo);
        for ($m = 0; $m < $countvartwo; $m++) {
            $totalresults = $datatwo[$m]['totalresults'];
             
             }                
        if($value>0 && $totalresults>0) {
            
        $data = array(
            'emergency_status' => 4
            
        );
        $this->db->where('notification_user_id', $notification_user_id);
        $this->db->where('emergency_id', $emergency_id);
        $data = $this->db->update('tbl_emergency_notification', $data);
    }
    else{
    
        $check    = "SELECT COUNT(4) as totalresultsdata FROM tbl_emergency_notification WHERE emergency_status = 4 and emergency_id='" . $emergency_id . "'";
        $res      = $this->db->query($check);
        $data     = $res->result_array();
        $countvar = count($data);
        for ($m = 0; $m < $countvar; $m++) {
            $totalresultsdata = $data[$m]['totalresultsdata'];
             
             }  

        if($totalresultsdata>0 && $totalresults>0){

       $data = array(
            'emergency_status' => 4
            
        );
        $this->db->where('emergency_id', $emergency_id);
        $data = $this->db->update('tbl_emergency_notification', $data);  
        }

    else if($totalresults>0){ 

   $data = array(
            'emergency_status' => 4
            
        );
        $this->db->where('emergency_id', $emergency_id);
        $data = $this->db->update('tbl_emergency_notification', $data); 
    }
       
       }
        if ($data) {
            
            $data = array(
                'user_id' => $notification_user_id,
                'emergency_id' => $emergency_id,
                'message_data' => $message_data,
                'status' => 1
            );
            $data = $this->db->insert('tbl_emergency_communitaction', $data);
            
     $sql = "SELECT first_name,last_name,user_id FROM tbl_user WHERE user_id='$notification_user_id'";
                $res = $this->db->query($sql);
                $row = $res->row();
                $first_names                = $row->first_name;
                $last_names                 = $row->last_name;
                $helpuser_name                = $first_names . " " . $last_names;

            $sql = "SELECT notification_user_id FROM tbl_emergency_notification WHERE emergency_id='$emergency_id' AND notification_user_id NOT IN ($close_uid)";
             $result = $this->db->query($sql);
            $datas = $result->result_array();
			array_push($datas,$creater_id);
            $countvars = count($datas);
            $require   = array();
			
			for ($j = 0; $j < $countvars; $j++) {
                $uid = $datas[$j]['notification_user_id'];              
                $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$uid')";
                $res = $this->db->query($sql);
                $row = $res->row();

                if ($row) {
                   $notification_device_token = $row->notification_device_token;
                    $mobile_type               = $row->mobile_type;
					$user_id               = $row->user_id;
					
					$emergency_contact_user = array();
					$results        = $this->db->query("SELECT * from tbl_emergency_contact where user_id='".$user_id."' and tap911_user=1");
					$remergencycontact = $results->result_array();
					$countvarresults   = count($remergencycontact);
					if($countvarresults){
						$require    = array();
						for ($o = 0; $o < $countvarresults; $o++) {
							$emergency_contact_user[] =$remergencycontact[$o]['emergency_user_help_id'];
						}
					}
					
					$sql        = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
					$resultdatatone = $this->db->query($sql);
                    $resultdatatone = $resultdatatone->row();
                    $notification_tone = $resultdatatone->notification_tone;
					

					$ch                        = curl_init("https://fcm.googleapis.com/fcm/send");
					$sound = $notification_tone;
					 if($sound==""){
					 $sound="notification01.mp3";
					 }else{
					 $sound = $notification_tone;
					 }
					$usertoken    = $notification_device_token;
					
					if(in_array($close_uid,$emergency_contact_user)){
						$title        = $helpuser_name." "."End Emergency." ;
					}else{
						$title        = "Someone End Emergency." ;
					}
					
					$body         =  "Thanks for your help!";
					 $click_action    = "ALERT";
					$notification = array(
						'title' => $title,
						'text' => $body,
						'sound' =>$sound,
						'click_action'=>$click_action
					);
					$arrayToSend  = array(
						'to' => $usertoken,
						'notification' => $notification,
						'priority' => 'high'
					);
					
					$json      = json_encode($arrayToSend);
					$headers   = array();
					$headers[] = 'Content-Type: application/json';
					if ($mobile_type == 'android') {
						$headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
					} else {
						$headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
					}
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					array_push($require, curl_exec($ch));
					curl_close($ch);
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Some data not valid'
                    );
                }
            }
        
           $returnresult = array(
            'status' => 1,
            'message' => 'success',
            'response' => $require
           );

        return $returnresult;
        }
        
    }



 /*-------------------------------end emergency for help user----------------------------------------------- */
    
    
    function end_emergency_by_creator()
    {
        $creator_id = $_REQUEST['creator_id'];
        $emergency_id         = $_REQUEST['emergency_id'];
		
		$emergency_contact_user = array();
		$results        = $this->db->query("SELECT * from tbl_emergency_contact where user_id='".$creator_id."' and tap911_user=1");
		$remergencycontact = $results->result_array();
		$countvarresults   = count($remergencycontact);
		if($countvarresults){
			$require    = array();
			for ($j = 0; $j < $countvarresults; $j++) {
				$emergency_contact_user[] =$remergencycontact[$j]['emergency_user_help_id'];
			}
		}
      
        
        $data = array(
            'emergency_status' => 4
            
        );
        $this->db->where('creator_id', $creator_id);
        $this->db->where('emergency_id', $emergency_id);
        $data = $this->db->update('tbl_emergency_notification', $data);
        
          $sql = "SELECT first_name,last_name FROM tbl_user WHERE user_id='$creator_id'";
                $res = $this->db->query($sql);
                $row = $res->row();
                $first_names                = $row->first_name;
                $last_names                 = $row->last_name;
                $helpuser_name                = $first_names . " " . $last_names;

            $sql = "SELECT notification_user_id FROM tbl_emergency_notification WHERE emergency_id='$emergency_id'";
             $result = $this->db->query($sql);
            $datas = $result->result_array();
            $countvars = count($datas);
            $require   = array();

            for ($j = 0; $j < $countvars; $j++) {
                $uid = $datas[$j]['notification_user_id'];              
                $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$uid')";
                $res = $this->db->query($sql);
                $row = $res->row();

                if ($row) {
                    $notification_device_token = $row->notification_device_token;
                    $mobile_type               = $row->mobile_type;
                      $user_id               = $row->user_id;
                    $sql        = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
                    $resultdatatone = $this->db->query($sql);
                    $resultdatatone = $resultdatatone->row();
                    $notification_tone = $resultdatatone->notification_tone;
            
                    $ch                        = curl_init("https://fcm.googleapis.com/fcm/send");
                   $sound = $notification_tone;
                     if($sound==""){
                     $sound="notification01.mp3";
                     }else{
                     $sound = $notification_tone;
                     }
                    $usertoken    = $notification_device_token;
                    
					if(in_array($user_id,$emergency_contact_user)){
						$title        = $helpuser_name." "."End Emergency." ;
					}else{
						$title        = "Someone End Emergency." ;
					}
					
                    
					$body         =  "Thanks for your help!";
                     $click_action    = "ALERT";
                    $notification = array(
                        'title' => $title,
                        'text' => $body,
                        'sound' =>$sound,
						'time_interval'=>'5',
                        'click_action'=>$click_action
                    );
                    $arrayToSend  = array(
                        'to' => $usertoken,
                        'notification' => $notification,
                        'priority' => 'high'
                    );
                    
                    $json      = json_encode($arrayToSend);
                    $headers   = array();
                    $headers[] = 'Content-Type: application/json';
                    if ($mobile_type == 'android') {
                        $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
                    } else {
                        $headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
                    }
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    array_push($require, curl_exec($ch));
                    curl_close($ch);
                    if ($mobile_type == 'android' || $mobile_type == 'ios') {
                        
                    }
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Some data not valid'
                    );
                }
            }
        
           $returnresult = array(
            'status' => 1,
            'message' => 'success',
            'response' => $require
           );

        return $returnresult;
        
    }

    
/*-------------------------------end emergency for help user----------------------------------------------- */
    
    
    function update_accept_user()
    {
        $notification_user_id = $_REQUEST['notification_user_id'];
        $emergency_id         = $_REQUEST['emergency_id'];
        // $message_data         = $_REQUEST['message_data'];
        
        
        $check    = "SELECT COUNT(4) as totalresult FROM tbl_emergency_notification WHERE emergency_status = 4 and emergency_id='" . $emergency_id . "'";
        $res      = $this->db->query($check);
        $data     = $res->result_array();
        $countvar = count($data);
        for ($i = 0; $i < $countvar; $i++) {
            $value = $data[$i]['totalresult'];
             
             }                 
    //     if($value>0) {
            
    //     $data = array(
    //         'emergency_status' => 4
            
    //     );
    //     $this->db->where('notification_user_id', $notification_user_id);
    //     $this->db->where('emergency_id', $emergency_id);
    //     $data = $this->db->update('tbl_emergency_notification', $data);

    // }else{

        
        $data = array(
            'emergency_status' => 2
            
        );
        $this->db->where('notification_user_id', $notification_user_id);
        $this->db->where('emergency_id', $emergency_id);
        $data = $this->db->update('tbl_emergency_notification', $data);
        
        //}
        if ($data) {
            
            $returnresult = array(
                'status' => 1,
                'message' => 'Emergency Accepted Successfully'
            );
        }
        
        return $returnresult;
        
    
}



function get_emergency_user($time_zone){

        $user_id = $_REQUEST['user_id'];
        $index = $_REQUEST['index'];
        // $starts=$index*10;
           $start = ($index-1)*10;
           $timezone1 = explode("+",$time_zone);
           $timezone2 = explode("-",$time_zone);
            $time1=$timezone1[1];
            $time2=$timezone2[1];
            if($time1!=""){
              $time="+".$timezone1[1];
            }else{
               $time="-".$timezone2[1];
            }
           
         // $limit = $index*$end;

	$result  =$this->db->query("SELECT `tbl_user`.user_id,`tbl_user`.first_name,`tbl_user`.profile_pic,`tbl_user`.phone_number_text_msg,
		`tbl_user`.last_name,`tbl_emergency`.user_id,`tbl_emergency`.emergency_id,`tbl_emergency`.emergency_latitude,`tbl_emergency`.emergency_longitude,`tbl_emergency`.emergency_address,`tbl_emergency`.emergency_type,`tbl_emergency`.add_date,`tbl_emergency_notification`.emergency_notification_id,`tbl_emergency_notification`.emergency_status,`tbl_emergency_notification`.send_date_time,`tbl_emergency_notification`.accept_date_time,CONVERT_TZ(`tbl_emergency_notification`.send_date_time, @@session.time_zone, '$time')as senddate
	FROM `tbl_user`
	JOIN `tbl_emergency` ON `tbl_emergency`.`user_id` = `tbl_user`.`user_id`
	JOIN `tbl_emergency_notification` on `tbl_emergency`.`emergency_id` = `tbl_emergency_notification`.`emergency_id`
	 WHERE(`tbl_emergency_notification`.`notification_user_id`=$user_id or `tbl_emergency`.`user_id` = $user_id ) AND tbl_emergency_notification.emergency_status IN (0,1,2,3) GROUP BY `tbl_emergency`.`emergency_id` ORDER BY `tbl_emergency_notification`.send_date_time DESC LIMIT $start,10");

       
        return $result->result();

  

}
 function emergency_create_user(){
     $user_id = $_REQUEST['user_id'];
  $result  =$this->db->query("SELECT `tbl_user`.*,`tbl_emergency`.*
FROM `tbl_user`
JOIN `tbl_emergency` ON `tbl_emergency`.`user_id` = `tbl_user`.`user_id`
JOIN `tbl_emergency_notification` on `tbl_emergency`.`emergency_id` = `tbl_emergency_notification`.`emergency_id`
 WHERE `tbl_emergency_notification`.`notification_user_id`=$user_id and `tbl_emergency_notification`.emergency_status!=2
UNION SELECT `tbl_user`.*, `tbl_emergency`.*
FROM `tbl_user`
JOIN `tbl_emergency` ON `tbl_emergency`.`user_id` = `tbl_user`.`user_id`
WHERE `tbl_emergency`.`user_id` = $user_id
");
  
  $total = count($result->result());
     
    $totalpage = $total/10;    
    $pagenumber = ceil($totalpage);
  return $pagenumber;
 }

function add_asset(){

$check = "SELECT asset_number FROM tbl_user_asset WHERE status=1 and asset_number ='".$_REQUEST['asset_number']."'";
        $rs    = mysql_query($check);
        $data  = mysql_fetch_array($rs);
        // $status = $data['status'];

        if ($data[0] > 1) {
            
            $returnresult = array(
                'status' => 0,
                'message' => 'Asset number already in Exists'
            );
          
        } 
        
        else {

             $data = array(
                     'user_id' => $_REQUEST['user_id'],
                     'asset_name' => $_REQUEST['asset_name'],
                     'asset_type' => $_REQUEST['asset_type'],
                     'asset_number' => $_REQUEST['asset_number'],
                     'address' => $_REQUEST['address'],
                     'latitude' => $_REQUEST['latitude'],
                     'longitude' => $_REQUEST['longitude'],
                     'status' => 1
                );

                $data = $this->db->insert('tbl_user_asset', $data);

                $returnresult = array(
                'status' => 1,
                'message' => 'User asset added successfully'
            );
        }
         return $returnresult;
}


 /*-------------------------------get state list----------------------------------------------- */
    
    function get_asset()
    {
        $index = $_REQUEST['index'];
        // $starts=$index*10;
           $start = ($index-1)*10;
       $user_id = $_REQUEST['user_id'];
       $result  = $this->db->query("SELECT asset_id,user_id,asset_name,asset_type,asset_number,asset_number,latitude,longitude,address as asset_address from tbl_user_asset where user_id='$user_id' and status=1 ORDER BY asset_id DESC LIMIT $start,10");
  
       return $result->result();
  
     }
     

    function get_total_asset_page()
    {
      
     $user_id = $_REQUEST['user_id'];
       $result  = $this->db->query("SELECT asset_id,user_id,asset_name,asset_type,asset_number,asset_number,latitude,longitude,address as asset_address from tbl_user_asset where user_id='$user_id' and status=1");
  
    $total = count($result->result());
     
    $totalpage = $total/10;    
    $pagenumber = ceil($totalpage);
    return $pagenumber;
 }



     /*-------------------------------update_user_emergency_contact with community----------------------------------------------- */
    
    
    function update_asset()
    {
        
           $asset_id = $_REQUEST['asset_id'];
            
            $data = array(
               
                 'asset_name' => $_REQUEST['asset_name'],
                 'asset_type' => $_REQUEST['asset_type'],
                 'asset_number' => $_REQUEST['asset_number'],
                 'address' => $_REQUEST['address'],
                 'latitude' => $_REQUEST['latitude'],
                 'longitude' => $_REQUEST['longitude']
            );
            $this->db->where('asset_id', $asset_id);
            $data = $this->db->update('tbl_user_asset', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'User asset updated successfully'
                );
            }
         else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Asset not found'
            );
        }
        
        return $returnresult;
        
    }

     /*-------------------------------delete user from user list----------------------------------------------- */
    
    function delete_asset()
    {
        $asset_id = $_REQUEST['asset_id'];
        
        $data = array(
            
            'status' => 0
        );
        $this->db->where('asset_id', $asset_id);
        $data = $this->db->update('tbl_user_asset', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'Asset deleted successfully'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        return $returnresult;
    }



 /*-------------------------------update_user_emergency_contact with community----------------------------------------------- */
    
    
    function logout()
    {
        
           $user_id = $_REQUEST['user_id'];
            
            $data = array(
               
                 'login_status' =>0
                
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_user', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'User logout successfully'
                );
            }
         else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Asset not found'
            );
        }
        
        return $returnresult;
        
    }



      /*-------------------------------gps_setting ----------------------------------------------- */
    
    
    function gps_setting()
    {

        $dateValue = date("Y-m-d H:i:s");
        $time      = strtotime($dateValue);
        $month     = date("F", $time);
        $year      = date("Y", $time);
        $table     = "tbl_tracking" . '_' . $month . '_' . $year;

        $check = "SELECT gps_status,user_id FROM $table WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
              $row     = $res->row();
               $user_id = $row->user_id;
               $gps_status     = $row->gps_status;


                if ($gps_status == 1) {
                    $data = array(
                        'gps_status' => 0,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update($table, $data);
                } else {
                    $data = array(
                        'gps_status' => 1,
                        'user_id' => $_REQUEST['user_id']
                        
                    );
                    $this->db->where('user_id', $user_id);
                    $data = $this->db->update($table, $data);
                }
           
            if ($data) {

            $check = "SELECT gps_status,user_id FROM $table WHERE user_id ='" . $_REQUEST['user_id'] . "'";
              $res   = $this->db->query($check);
              $row     = $res->row();
               $gps_status     = $row->gps_status;
                $returnresult = array(
                    'status' => 1,
                    'message' => 'Gps setting updated successfully',
                   'gps_status'=>$gps_status
                    
                );
            }
        }
        
        return $returnresult;
    }
    

   /*-------------------------------gps_setting ----------------------------------------------- */
    
    
    // function get_gps_setting()
    // {

    //     $dateValue = date("Y-m-d H:i:s");
    //     $time      = strtotime($dateValue);
    //     $month     = date("F", $time);
    //     $year      = date("Y", $time);
    //     $table     = "tbl_tracking" . '_' . $month . '_' . $year;

    //     $check = "SELECT gps_status FROM $table WHERE user_id ='" . $_REQUEST['user_id'] . "'";
    //     $res   = $this->db->query($check);
    //     return $res->result(); 
    // }




    // public function send_miles_notifications($ids, $user_lat, $user_long,$radius)
    // {
        
    //     /*-------------------------------register user notfication end start 3 miles user notification----------------------------------------------- */
        
    //     $ids       = $ids;
    //     $user_lat  = $user_lat;
    //     $user_long = $user_long;
    //     $radius = $radius;
        
    //     $sql        = "SELECT * FROM tbl_emergency where emergency_id='$ids'";
    //     $res        = $this->db->query($sql);
    //     $row        = $res->row();
    //     $emuserid   = $row->user_id;
    //     $emergency_type   = $row->emergency_type;
    //     $sql        = "SELECT * FROM tbl_user WHERE `user_id`='$emuserid'";
    //     $resultdata = $this->db->query($sql);
    //     $resultdata = $resultdata->row();
    //     $first_name = $resultdata->first_name;
    //     $last_name  = $resultdata->last_name;
    //     $user_name  = $first_name . " " . $last_name;
        

    // $results = $this->db->query("SELECT * from tbl_emergency_contact where user_id='$emuserid' and tap911_user=1");

    //     $remergencycontact = $results->result_array();

    //     foreach ($remergencycontact as $emresult) {
            
    //             $uid = $emresult['emergency_user_help_id']; 
    //            }

    //     $dateValue = date("Y-m-d H:i:s");
    //     $time      = strtotime($dateValue);
    //     $month     = date("F", $time);
    //     $year      = date("Y", $time);
    //     $table     = "tbl_tracking" . '_' . $month . '_' . $year;
        
    //     $result = $this->db->query("SELECT $table.*, $table.add_date as userdate,tbl_user.*,tbl_user.add_date as adate,
    //         3956 * 2 * ASIN(SQRT( POWER(SIN(($user_lat -  $table.latitude) * pi()/180 / 2), 2) + COS($user_lat * pi()/180) * COS( $table.latitude * pi()/180) *
    //         POWER(SIN(($user_long -  $table.longitude) * pi()/180 / 2), 2) )) as
    //         distance FROM $table
    //          JOIN  tbl_user on tbl_user.user_id =   $table.user_id
    //          WHERE tbl_user.login_status=1 and $table.gps_status=1 and $table.user_id NOT IN ('" . $_REQUEST['user_id'] . " ') and NOT IN ('". $uid ."')   
    //         GROUP BY  $table.tracking_id HAVING distance <= $radius ORDER by distance ASC");
       
    //             $dataresult = $result->result_array();
    //            $countvars = count($datas);
    //             $require   = array();
                   

    //            foreach ($dataresult as $result) {

    //            if( $countvars>0){
                  
    //                $uid= $result['user_id'];
    //                }else{

    //                   $uid= $id;

    //                }
              

    //             $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id,creator_id)values('$uid','$ids','$emuserid')";

    //             $res                       = mysql_query($SQL);
    //             $emergency_notification_id = $this->db->insert_id();
          
    //             $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$uid')";
    //             $res = $this->db->query($sql);
    //             $row = $res->row();

    //             if ($row) {
    //                 $notification_device_token = $row->notification_device_token;
    //                 $first_names                = $row->first_name;
    //                 $last_names                 = $row->last_name;
    //                 $helpuser_name                = $first_names . " " . $last_names;
    //                 $mobile_type               = $row->mobile_type;
    //                   $user_id               = $row->user_id;
    //                 $sql        = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
    //                 $resultdatatone = $this->db->query($sql);
    //                 $resultdatatone = $resultdatatone->row();
    //                 $notification_tone = $resultdatatone->notification_tone;
            
    //                 $ch                        = curl_init("https://fcm.googleapis.com/fcm/send");
    //                 $sound = $notification_tone;
    //                  if($sound==""){
    //                  $sound="notification01.mp3";
    //                  }else{
    //                  $sound = $notification_tone;
    //                  }
    //                 $usertoken    = $notification_device_token;
    //                 $title        = "Emergency Request"." ".$emergency_type;
    //                 $body         =  $user_name." "."need your help. Click to help.";
    //                $click_action    = "ALERT";
    //             $notification= array(
    //                  'title' => $title,
    //                  'text' => $body,
    //                  'sound'=>$sound,
    //                  'click_action'=>$click_action
    //             );
    //                 $arrayToSend  = array(
    //                     'to' => $usertoken,
    //                     'notification' => $notification,
    //                     'priority' => 'high'
    //                 );
                    
    //                 $json      = json_encode($arrayToSend);
    //                 $headers   = array();
    //                 $headers[] = 'Content-Type: application/json';
    //                 if ($mobile_type == 'android') {
    //                     $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
    //                 } else {
    //                     $headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
    //                 }
    //                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //                 curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //                 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    //                array_push($require, curl_exec($ch));
                   
                   
    //                curl_close($ch);
    //                 if ($mobile_type == 'android' || $mobile_type == 'ios') {
                        
    //                 }
                    
    //             } else {
    //                 $returnresult = array(
    //                     'status' => 0,
    //                     'message' => 'Some data not valid'
    //                 );
    //             }
    //             //}
    //        }
       
        
        
    //                       $returnresult = array(
    //                       'status' => 1,
    //                        'data' => $require,
    //                        'message' => 'success'
            
    //        );
    //        if($returnresult){
    //             $data = json_encode($returnresult);
    //             print_r($data);
    //            }
    //         else{
    //             $returnresult = die(json_encode(array(
    //             "status" => 0,
    //            "message" =>"No user on radius"
    //                     )));
    //            }
    //    return $returnresult;
        
    // }
    
    /*-------------------------------emergency create by user ----------------------------------------------- */
    
    
    // public function add_emergency_user()
    // {
     
    //     $user_lat  = $_REQUEST['emergency_latitude'];
    //     $user_long = $_REQUEST['emergency_longitude'];
    //     $emergency_address = $_REQUEST['emergency_address'];
  
    //      $data      = array(
    //         'user_id' => $_REQUEST['user_id'],
    //         'emergency_latitude' => $user_lat,
    //         'emergency_longitude' => $user_long,
    //         'emergency_address' => $emergency_address,
    //         'emergency_type' => $_REQUEST['emergency_type'],
    //         'status' => 1
    //     );
        
    //     $data = $this->db->insert('tbl_emergency', $data);
    //     $ids  = $this->db->insert_id();

    //    $sqlradius        = "SELECT radius FROM tbl_user where user_id='".$_REQUEST['user_id']."'";
    //     $raduisres        = $this->db->query($sqlradius);
    //     $row        = $raduisres->row();
    //     $radius   = $row->radius;
    //     $sql        = "SELECT * FROM tbl_emergency where emergency_id='$ids'";
    //     $res        = $this->db->query($sql);
    //     $row        = $res->row();
    //     $emuserid   = $row->user_id;
    //     $emergency_type   = $row->emergency_type;
    //     $sql        = "SELECT * FROM tbl_user WHERE `user_id`='$emuserid' and login_status=1";
    //     $resultdata = $this->db->query($sql);
    //     $resultdata = $resultdata->row();
    //     $emfirst_name = $resultdata->first_name;
    //     $emlast_name  = $resultdata->last_name;
    //     $user_name = $emfirst_name . " " . $emlast_name;
    //     // print_r($notification_device_token);die();
        
    //     $results           = $this->db->query("SELECT * from tbl_emergency_contact where user_id='$emuserid' and tap911_user=1");
    //     $remergencycontact = $results->result_array();
    //     $countvarresults   = count($remergencycontact);
    //     if($countvarresults){
    //     $require           = array();
    //     $tags = array();
    //     for ($j = 0; $j < $countvarresults; $j++) {
            
      
    //          $tags[] =$remergencycontact[$j]['emergency_user_help_id'];
      
    //         }

    //        }
               
    //     $dateValue = date("Y-m-d H:i:s");
    //     $time      = strtotime($dateValue);
    //     $month     = date("F", $time);
    //     $year      = date("Y", $time);
    //     $table     = "tbl_tracking" . '_' . $month . '_' . $year;
    //     $var=implode(',', $tags);
        
    //     $result = $this->db->query("SELECT $table.*, $table.add_date as userdate,tbl_user.*,tbl_user.add_date as adate,
    //         3956 * 2 * ASIN(SQRT( POWER(SIN(($user_lat -  $table.latitude) * pi()/180 / 2), 2) + COS($user_lat * pi()/180) * COS( $table.latitude * pi()/180) *
    //         POWER(SIN(($user_long -  $table.longitude) * pi()/180 / 2), 2) )) as
    //         distance FROM $table
    //          JOIN  tbl_user on tbl_user.user_id =   $table.user_id
    //          WHERE tbl_user.login_status=1 and $table.gps_status=1 and $table.user_id NOT IN ('$var') and $table.user_id NOT IN ('" . $_REQUEST['user_id'] ."')    
    //         GROUP BY  $table.tracking_id HAVING distance <= $radius ORDER by distance ASC");
       
    //                $datavalue     = $result->result_array();
    //                $countvars = count($datavalue);
    //                $require=array();
    //           for ($i = 0; $i < $countvars; $i++) {
     
    //              $uid= $datavalue[$i]['user_id'];

    //             $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id,creator_id)values('$uid','$ids','$emuserid')";

    //             $res                       = mysql_query($SQL);
    //             $emergency_notification_id = $this->db->insert_id();
          
    //             $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$uid')";
    //             $res = $this->db->query($sql);
    //             $row = $res->row();

    //             if ($row) {
    //                 $notification_device_token = $row->notification_device_token;
    //                 $first_names                = $row->first_name;
    //                 $last_names                 = $row->last_name;
    //                 $helpuser_name                = $first_names . " " . $last_names;
    //                 $mobile_type               = $row->mobile_type;
    //                   $user_id               = $row->user_id;
    //                 $ch                     = curl_init("https://fcm.googleapis.com/fcm/send");
    //                  $sound="default_ringtone.mp3";
    //                 $usertoken    = $notification_device_token;
    //                 $title        = $emergency_type." "."Emergency Request";
    //                  $body         =  $user_name." "."need your help. Click to help.";
    //                $click_action    = "ALERT";
    //             $notification= array(
    //                  'title' => $title,
    //                  'text' => $body,
    //                  'sound'=>$sound,
    //                  'click_action'=>$click_action
    //             );
    //                 $arrayToSend  = array(
    //                     'to' => $usertoken,
    //                     'notification' => $notification,
    //                     'priority' => 'high'
    //                 );
                    
    //                 $json      = json_encode($arrayToSend);
    //                 $headers   = array();
    //                 $headers[] = 'Content-Type: application/json';
    //                 if ($mobile_type == 'android') {
    //                     $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
    //                 } else {
    //                     $headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
    //                 }
    //                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //                 curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //                 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    //                array_push($require, curl_exec($ch));
                   
                   
    //                curl_close($ch);
    //                 if ($mobile_type == 'android' || $mobile_type == 'ios') {
                        
    //                 }
                    
    //             } else {
    //                 $returnresult = array(
    //                     'status' => 0,
    //                     'message' => 'Some data not valid'
    //                 );
    //             }
            
    //        }
      
    //               $returnresult = array(
    //               'status' => 1,
    //               'response' => $require,
    //               'message' => 'success'
                  
    //        );
          
    //    return $returnresult;
    // }



 public function add_emergency_user()
    {
        $user_lat  = $_REQUEST['emergency_latitude'];
        $user_long = $_REQUEST['emergency_longitude'];
        $emergency_address = $_REQUEST['emergency_address'];
        $data      = array(
            'user_id' => $_REQUEST['user_id'],
            'emergency_latitude' => $user_lat,
            'emergency_longitude' => $user_long,
            'emergency_address' => $emergency_address,
            'emergency_type' => $_REQUEST['emergency_type'],
            'status' => 1);
        
        $data = $this->db->insert('tbl_emergency', $data);
        $ids  = $this->db->insert_id();

        $sqluser        = "SELECT * FROM tbl_user where user_id='".$_REQUEST['user_id']."'";
        $raduisres      = $this->db->query($sqluser);
        $user_row       = $raduisres->row();
        $radius         = $user_row->radius;
        $emfirst_name   = $user_row->first_name;
        $emlast_name    = $user_row->last_name;
        $user_name      = $emfirst_name . " " . $emlast_name;
        // print_r($notification_device_token);die();
        
        $results        = $this->db->query("SELECT * from tbl_emergency_contact where user_id='".$_REQUEST['user_id']."' and tap911_user=1");
        $remergencycontact = $results->result_array();
        $countvarresults   = count($remergencycontact);
        if($countvarresults){
            $require    = array();
            $emergency_contact_user = array();
            for ($j = 0; $j < $countvarresults; $j++) {
                $emergency_contact_user[] =$remergencycontact[$j]['emergency_user_help_id'];
            }
        }
               
        $dateValue = date("Y-m-d H:i:s");
        $time      = strtotime($dateValue);
        $month     = date("F", $time);
        $year      = date("Y", $time);
        $table     = "tbl_tracking" . '_' . $month . '_' . $year;
       
        if(count($emergency_contact_user)>0){
        $emergency_contact_user_string     = implode(',', $emergency_contact_user);
    }else{
        $emergency_contact_user_string="";
    }

        $result = $this->db->query("SELECT $table.*, $table.add_date as userdate,tbl_user.*,tbl_user.add_date as adate,
            3956 * 2 * ASIN(SQRT( POWER(SIN(($user_lat -  $table.latitude) * pi()/180 / 2), 2) + COS($user_lat * pi()/180) * COS( $table.latitude * pi()/180) *
            POWER(SIN(($user_long -  $table.longitude) * pi()/180 / 2), 2) )) as
            distance FROM $table
            JOIN  tbl_user on tbl_user.user_id =   $table.user_id
            WHERE tbl_user.login_status=1 and tbl_user.gps_status=1 and $table.user_id NOT IN ('$emergency_contact_user_string') and $table.user_id NOT IN (" . $_REQUEST['user_id'] .")    
            GROUP BY  $table.tracking_id HAVING distance <= $radius ORDER by distance ASC");
        $datavalue  = $result->result_array();
        $countvars  = count($datavalue);
        $require    = array();
          $uid = array();
        for ($i = 0; $i < $countvars; $i++) {
            $uid[]=$datavalue[$i]['user_id'];
        }
        if(count($emergency_contact_user)>0 && count($uid)>0){
            $values = array_merge($emergency_contact_user,$uid);
        }elseif(count($emergency_contact_user)>0){
            $values = $emergency_contact_user;
        }elseif(count($uid)>0){
            $values = $uid;
        }else{
            return false;
        }
        $id =implode(',', $values);
        $result = $this->db->query("SELECT * FROM tbl_user WHERE user_id IN ($id)");
        $data1   = $result->result_array();
        $countvar = count($data1);
        for ($i = 0; $i < $countvar; $i++) {
             $uids    = $data1[$i]['user_id'];
            $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id,creator_id)values('$uids','$ids','".$_REQUEST['user_id']."')";
            $res = $this->db->query($SQL);


            $notification_device_token = $data1[$i]['notification_device_token'];
            $first_names                = $data1[$i]['first_name'];
            $last_names                 = $data1[$i]['last_name'];
            $helpuser_name                = $first_names . " " . $last_names;
            $mobile_type               = $data1[$i]['mobile_type'];
            //$user_id               = $data[$i]['user_id'];
            $ch                     = curl_init("https://fcm.googleapis.com/fcm/send");
            $sound="default_ringtone.mp3";
            $usertoken    = $notification_device_token;
            $title        = $_REQUEST['emergency_type']." "."Emergency Request";
            //$body         =  $user_name." "."need your help. Click to help.";
			
			if(in_array($uids,$emergency_contact_user)){
				$body =  $user_name." "."need your help. Click to help.";
			}else{
				$body =  "Someone need your help. Click to help.";
			}
			
            $click_action    = "ALERT";
            $notification= array(
                 'title' => $title,
                 'text' => $body,
                 'sound'=>$sound,
                 'click_action'=>$click_action
            );
            $arrayToSend  = array(
                'to' => $usertoken,
                'notification' => $notification,
                'priority' => 'high'
            );
                
            $json      = json_encode($arrayToSend);
            $headers   = array();
            $headers[] = 'Content-Type: application/json';
            if ($mobile_type == 'android') {
                $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
            } else {
                $headers[] = 'Authorization: key= AIzaSyAkPpQ-GiN4GVSjniMyHuSwXJVekEL7FWk'; // key here
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            array_push($require, curl_exec($ch));
               
               
            curl_close($ch);
        }
        $returnresult = array(
            'status' => 1,
            'response' => $require,
            'message' => 'success'
        );  
        return $returnresult;
    }
	
	function add_tracking($data_td,$id)
    {
		$data = array(
			'user_id' => $id,
			'address' => $data_td['address'],
			'latitude' => $data_td['latitude'],
			'longitude' => $data_td['longitude'],
			'add_date' => $data_td['Time'],
			'status' => 1
		);
		$this->db->insert('all_tracking_data', $data);
		return $this->db->insert_id();
    }

}