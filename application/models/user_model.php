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
        
        $sql = "SELECT user_name ,user_id, password, email FROM tbl_user where ( user_name='$login' OR email = '$login') and password = '$password' and status=1";
        $res = $this->db->query($sql);
        
        if ($res->num_rows > 0) {
            $row                       = $res->row();
            $customer_id               = $row->user_id;
            $tokens                    = openssl_random_pseudo_bytes(8);
            $token                     = bin2hex($tokens);
            $notification_device_token = $_REQUEST['notification_device_token'];
            $mobile_type               = $_REQUEST['mobile_type'];
             $time_zone               = $_REQUEST['time_zone'];
            $data                      = array(
                'token' => $token,
                'notification_device_token' => $notification_device_token,
                'mobile_type' => $mobile_type,
                'time_zone' => $time_zone
                
            );
            $this->db->where('user_id', $customer_id);
            $value       = $this->db->update('tbl_user', $data);
            $returnarray = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $customer_id
            );
            
            
        } else {
            
            $returnarray = array(
                'status' => 0,
                'message' => 'Username or pasword is invalid'
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
        
$check = "SELECT * FROM tbl_user WHERE status=1 and (email ='" . $_REQUEST['email'] . "' OR user_name ='" . $_REQUEST['user_name'] . "')";
        $rs    = mysql_query($check);
        $data  = mysql_fetch_array($rs);
        // $status = $data['status'];

        if ($data[0] > 1) {
            
            $returnresult = array(
                'status' => 0,
                'message' => 'User already in Exists'
            );
          
        } 
        
        else {
            
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
                if (!is_numeric($_REQUEST['phone_number'])) {
                    $returnresult = die(json_encode(array(
                        "status" => 0,
                        "message" => "Please Enter number only"
                    )));
                }
                // if (ctype_alpha($_REQUEST['user_name']) === false) {
                    
                //     $returnresult = die(json_encode(array(
                //         "status" => 0,
                //         "message" => "User Name must only contain letters!"
                //     )));
                // }
                
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
                    'gender' => $_REQUEST['gender'],
                    'phone_number_text_msg_country_code' => $_REQUEST['country_id'],
                    'phone_number_text_msg' => $_REQUEST['phone_number'],
                    'user_lat' => $_REQUEST['user_lat'],
                    'user_long' => $_REQUEST['user_long'],
                    'password' => md5($_REQUEST['password']),
                    'user_type_id' => $_REQUEST['user_type_id'],
                    'profile_pic' => $profile_pic,
                    'notification_device_token' => $_REQUEST['notification_device_token'],
                    'mobile_type' => $_REQUEST['mobile_type'],
                    'status' => 1
                );
                $data = $this->db->insert('tbl_user', $data);
                $id   = $this->db->insert_id();
                if ($data) {
                    
                    $data = array(
                        'user_id' => $id,
                        'status' => 1
                    );
                    $data = $this->db->insert('tbl_notification', $data);
                    
                    $returnresult = array(
                        'status' => 1,
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
    
    function add_question_answer(){

        $jsondata    = $_REQUEST['jsondata'];
        $medical_condition    = $_REQUEST['medical_condition'];
        $previous_surgeries_procedure    = $_REQUEST['previous_surgeries_procedure'];
        $medication    = $_REQUEST['medication'];
        $allergies    = $_REQUEST['allergies'];
        $special_need    = $_REQUEST['special_need'];
        $jsondatas = urldecode(stripslashes($jsondata));
        $data3 = json_decode($jsondatas);

        foreach ($data3 as $row) {
              $user_id = $row->user_id;
              $question_id = $row->question_id;
              $answer = $row->answer;
              $yes_no_ans = $row->yes_no_ans;
              $other = $row->other;
         $SQL = "insert into tbl_user_question_answer(user_id,question_id,answer,yes_no_ans,other,status)values('$user_id','$question_id','$answer','$yes_no_ans','$other','1')";
                $res = mysql_query($SQL);
}

       if ($res) {
            $data = array(
                'medical_condition' => $_REQUEST['medical_condition'],
                'previous_surgeries_procedure' => $_REQUEST['previous_surgeries_procedure'],
                'medication' => $_REQUEST['medication'],
                'allergies' => $_REQUEST['allergies'],
                'special_need' => $_REQUEST['special_need']
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_user', $data);
            $returnresult = array(
                'status' => 1,
                'message' => 'User data save successfully'
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
        $medical_condition    = $_REQUEST['medical_condition'];
        $previous_surgeries_procedure    = $_REQUEST['previous_surgeries_procedure'];
        $medication    = $_REQUEST['medication'];
        $allergies    = $_REQUEST['allergies'];
        $special_need    = $_REQUEST['special_need'];
        $jsondatas = urldecode(stripslashes($jsondata));
        $data3 = json_decode($jsondatas);

        foreach ($data3 as $row) {
              $user_id = $row->user_id;
              $question_id = $row->question_id;
              $answer = $row->answer;
              $yes_no_ans = $row->yes_no_ans;
              $other = $row->other;
$SQL = "UPDATE tbl_user_question_answer SET question_id='$question_id',answer='$answer',yes_no_ans='$yes_no_ans',other='$other' where question_id='$question_id' and user_id='$user_id'";
                $res = mysql_query($SQL);
}

       if ($res) {
            $data = array(
                'medical_condition' => $_REQUEST['medical_condition'],
                'previous_surgeries_procedure' => $_REQUEST['previous_surgeries_procedure'],
                'medication' => $_REQUEST['medication'],
                'allergies' => $_REQUEST['allergies'],
                'special_need' => $_REQUEST['special_need']
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_user', $data);
            $returnresult = array(
                'status' => 1,
                'message' => 'User data save successfully'
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
                    'message' => 'User notification setting update successfully'
                    
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
                    'message' => 'User notification tone update successfully'
                    
                );
            }
        }
        
        
        return $returnresult;
    }
    
    
    /*-------------------------------update_profile----------------------------------------------- */
    
    function update_profile()
    {
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
                'allergies' => $_REQUEST['allergies'],
                'special_need' => $_REQUEST['special_need']
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_user', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'User profile update successfully'
                );
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Some data not valid'
                );
            }
            
            return $returnresult;
        }
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
                        'message' => 'User profile picture update successfully'
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
                    'message' => 'User address update successfully'
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
                    'message' => 'User address successfully submit'
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
                
                $SQL = "insert into tbl_emergency_contact(user_id,emergency_user_help_id,name,phone_number,tap911_user)
            values('$user_id','$emergency_user_help_id','$name','$phone_number','$tap911_user')";
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
                    'message' => 'User emergency contact update successfully'
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
       `address` varchar(20) NOT NULL,
      `latitude` varchar(20) NOT NULL,
       `longitude` varchar(255) NOT NULL,
       `add_uid` int(11) NOT NULL,
       `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `del_uid` int(11) NOT NULL,
       `del_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
       `status` tinyint(1) NOT NULL,
        PRIMARY KEY (tracking_id)
)";
        if (mysql_query($sql)) {
            
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
                'message' => 'User emergency contact delete successfully'
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
        $sql        = "SELECT * FROM tbl_user WHERE `user_id`='$emuserid'";
        $resultdata = $this->db->query($sql);
        $resultdata = $resultdata->row();
        $emfirst_name = $resultdata->first_name;
        $emlast_name  = $resultdata->last_name;
        $user_name = $emfirst_name . " " . $emlast_name;
        // print_r($notification_device_token);die();
        
        $results           = $this->db->query("SELECT * from tbl_emergency_contact where user_id='$emuserid'");
        $remergencycontact = $results->result_array();
        $countvarresults   = count($remergencycontact);
        $require           = array();
        for ($j = 0; $j < $countvarresults; $j++) {
            
                $id = $remergencycontact[$j]['emergency_user_help_id'];
            
                
                $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id)values('$id','$ids')";
                $res = mysql_query($SQL);
                
                $sql     = "SELECT * FROM tbl_user WHERE `user_id` IN('$id')";
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
                    $usertoken    = $notification_device_token;
                    $title        = "hello i am" . $user_name;
                    $body         = $helpuser_name . " " . "Please help me";
                    $notification = array(
                        'title' => $title,
                        'text' => $body,
                        'sound'=>$sound
                        // 'emergency_notification_id' => $emergency_notification_id
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
                    if ($usertoken){
                         $returnresult = array(
            'status' => 1,
            'data' => $require,
            'message' => 'success'
            
           );
                  
}else{
     die(json_encode(array(
                "status" => 0,
                "message" => "no user"
            )));
}
                    curl_close($ch);
                    if ($mobile_type == 'android' || $mobile_type == 'ios') {
                        
                    }
                }
                
                return $returnresult;
            
        }
        
        
        
        
    }
    
    
    
    
    public function send_miles_notification($ids, $user_lat, $user_long)
    {
        
        /*-------------------------------register user notfication end start 3 miles user notification----------------------------------------------- */
        
        $ids       = $ids;
        $user_lat  = $user_lat;
        $user_long = $user_long;
        
        $sql        = "SELECT * FROM tbl_emergency where emergency_id='$ids'";
        $res        = $this->db->query($sql);
        $row        = $res->row();
        $emuserid   = $row->user_id;
        $sql        = "SELECT * FROM tbl_user WHERE `user_id`='$emuserid'";
        $resultdata = $this->db->query($sql);
        $resultdata = $resultdata->row();
        $first_name = $resultdata->first_name;
        $last_name  = $resultdata->last_name;
        $user_name  = $first_name . " " . $last_name;
        
        $dateValue = date("Y-m-d H:i:s");
        $time      = strtotime($dateValue);
        $month     = date("F", $time);
        $year      = date("Y", $time);
        $table     = "tbl_tracking" . '_' . $month . '_' . $year;
        
        $result = $this->db->query("SELECT $table.*, $table.add_date as userdate,tbl_user.*,tbl_user.add_date as adate,
            3956 * 2 * ASIN(SQRT( POWER(SIN(($user_lat -  $table.latitude) * pi()/180 / 2), 2) + COS($user_lat * pi()/180) * COS( $table.latitude * pi()/180) *
            POWER(SIN(($user_long -  $table.longitude) * pi()/180 / 2), 2) )) as
            distance FROM $table
             JOIN  tbl_user on tbl_user.user_id =   $table.user_id
             WHERE  $table.add_date >= NOW() - INTERVAL 10 MINUTE and  $table.user_id NOT IN ('" . $_REQUEST['user_id'] . "')   
            GROUP BY  $table.tracking_id HAVING distance <= 5 ORDER by distance ASC");
        
        
        
        $datas = $result->result_array();
        
            
            $countvars = count($datas);
            $require   = array();
            for ($j = 0; $j < $countvars; $j++) {

                $uid                       = $datas[$j]['user_id'];

                $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id) values('$uid','$ids')";

                $res                       = mysql_query($SQL);
                $emergency_notification_id = $this->db->insert_id();
                
                
                $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$uid')";
                $res = $this->db->query($sql);
                $row = $res->row();

                if ($row) {
                    $notification_device_token = $row->notification_device_token;
                    $first_names                = $row->first_name;
                    $last_names                 = $row->last_name;
                    $helpuser_name                = $first_names . " " . $last_names;
                    $mobile_type               = $row->mobile_type;
                      $user_id               = $row->user_id;
                    $sql        = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
                    $resultdatatone = $this->db->query($sql);
                    $resultdatatone = $resultdatatone->row();
                    $notification_tone = $resultdatatone->notification_tone;
            
                    $ch                        = curl_init("https://fcm.googleapis.com/fcm/send");
                    $sound = $notification_tone;
                    $usertoken    = $notification_device_token;
                    $title        = "Hello i am" ." ". $user_name;
                    $body         = $helpuser_name . " " . "Please help me";
                    $notification = array(
                        'title' => $title,
                        'text' => $body,
                        'sound' =>$sound
                       
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
                    if ($usertoken){
                          $returnresult = array(
            'status' => 1,
            'data' => $require,
            'message' => 'success'
            
           );
                   
}else{
   
      die(json_encode(array(
                "status" => 0,
                "message" => "no user"
            )));

}
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
        
            return $returnresult;
        
    }
    
    /*-------------------------------emergency create by user ----------------------------------------------- */
    
    
    public function add_emergency_user()
    {
        $user_lat  = $_REQUEST['emergency_latitude'];
        $user_long = $_REQUEST['emergency_longitude'];
        $emergency_address = $_REQUEST['emergency_address'];
        if($emergency_address==""){
        $address=file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=$user_lat,$user_long&sensor=true");
        $json_data=json_decode($address);
        $full_address=$json_data->results[0]->formatted_address;

        $data      = array(
            'user_id' => $_REQUEST['user_id'],
            'emergency_latitude' => $user_lat,
            'emergency_longitude' => $user_long,
            'emergency_address' => $full_address,
            'emergency_type' => $_REQUEST['emergency_type'],
            'status' => 1
        );
        
        $data = $this->db->insert('tbl_emergency', $data);
        $ids  = $this->db->insert_id();
    }else{

         $data      = array(
            'user_id' => $_REQUEST['user_id'],
            'emergency_latitude' => $user_lat,
            'emergency_longitude' => $user_long,
            'emergency_address' => $emergency_address,
            'emergency_type' => $_REQUEST['emergency_type'],
            'status' => 1
        );
        
        $data = $this->db->insert('tbl_emergency', $data);
        $ids  = $this->db->insert_id();

    }
        
        
        $register = $this->send_miles_notification($ids, $user_lat, $user_long);
        $temp     = $this->send_notification_emegrency_contact($ids, $user_lat, $user_long);
        
        return $temp;
        return $register;
        
/*--------------------------------------------------------get user create by----------------------------------------------------------*/
        
        $sql        = "SELECT user_id FROM tbl_emergency where emergency_id='$ids'";
        $res        = $this->db->query($sql);
        $row        = $res->row();
        $emuserid   = $row->user_id;
        $sql        = "SELECT * FROM tbl_user WHERE `user_id`='$emuserid'";
        $resultdataname = $this->db->query($sql);
        $resultdataname = $resultdataname->row();
        $emfirst_name = $resultdataname->first_name;
        $emlast_name  = $resultdataname->last_name;
        $user_name  = $emfirst_name . " " . $emlast_name;
        $fcmtoken = $resultdataname->$notification_device_token;
     
        
        /*-----------------------------------------------------------------------------------------------------------------------------------*/
        
        /*-------------------------------start register user notfication ----------------------------------------------- */
        
        
        $results = $this->db->query("SELECT user_id,first_name,user_lat,user_long,
            3956 * 2 * ASIN(SQRT( POWER(SIN(($user_lat -  tbl_user.user_lat) * pi()/180 / 2), 2) + COS($user_lat * pi()/180) * COS( tbl_user.user_lat * pi()/180) *
            POWER(SIN(($user_long - tbl_user.user_long) * pi()/180 / 2), 2) )) as
            distance FROM tbl_user
             WHERE  tbl_user.user_id NOT IN ('" . $_REQUEST['user_id'] . "')   
            GROUP BY tbl_user.user_id HAVING distance <= 5 ORDER by distance ASC");
        
        
        
            $resultdata = $results->result_array();
            $countvarresult = count($resultdata);
            $require        = array();

            for ($i = 0; $i < $countvarresult; $i++) {
             
                $id                        = $resultdata[$i]['user_id'];
               
        $SQL = "insert into tbl_emergency_notification(notification_user_id,emergency_id) values('$id','$ids')";
                $res                       = mysql_query($SQL);
                $emergency_notification_id = $this->db->insert_id();
                
                
                $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$id')";
                $res = $this->db->query($sql);
                $row = $res->row();
                if ($row) {
                    $notification_device_token = $row->notification_device_token;
                    $first_name                = $row->first_name;
                    $last_name                 = $row->last_name;
                    $user_names                = $first_name . " " . $last_name;
                    $mobile_type               = $row->mobile_type;
                    $user_id                   = $row->user_id;
                    $sql        = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
                    $resultdatatone = $this->db->query($sql);
                    $resultdatatone = $resultdatatone->row();
                    $notification_tone = $resultdatatone->notification_tone;
                    $ch                        = curl_init("https://fcm.googleapis.com/fcm/send");
                     $sound = $notification_tone;
                    $usertoken    = $notification_device_token;
                    $title        = "Hello i am". " " .$user_name;
                    $body         = $user_names . " " . "Please help me";
                    $notification = array(
                        'title' => $title,
                        'text' => $body,
                        'sound' => $sound
                       
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
                    // $returnresult = 
                     array_push($require, curl_exec($ch));
                    if ($usertoken){
            $returnresult = array(
            'status' => 1,
            'data' => $require,
            'message' => 'success'
            
           );
        }else{
     
     die(json_encode(array(
                "status" => 0,
                "message" => "no user"
            )));

}
                    curl_close($ch);
                    if ($mobile_type == 'android' || $mobile_type == 'ios') {
                        
                    }
                    
                } else {
                    

                    $returnresult = array(
                    'status' => 1,
                    'message' =>'No user available for help'
            
                   );  
                }
            }
        
        /*-------------------------------end 3 miles user notification----------------------------------------------- */

        
      
        return $returnresult;
    }
    
    /*-------------------------------accept_emergency_request----------------------------------------------- */
    
    
    function accept_emergency_request()
    {
        $emergency_notification_id = $_REQUEST['emergency_notification_id'];
        $result                    = "SELECT * FROM  tbl_emergency_notification WHERE emergency_notification_id ='" . $_REQUEST['emergency_notification_id'] . "'";
        $res                       = $this->db->query($result);
        $row                       = $res->row();
        $emergency_id              = $row->emergency_id;
        $notification_user_id      = $row->notification_user_id;
        
        $check    = "SELECT COUNT(1) as total FROM tbl_emergency_notification WHERE emergency_status = 1 and emergency_id='" . $emergency_id . "'";
        $res      = $this->db->query($check);
        $data     = $res->result_array();
        $countvar = count($data);
        for ($i = 0; $i < $countvar; $i++) {
            $value = $data[$i]['total'];
            
        }
        
        if ($value==2) {
            
            $returnresult = array(
                'status' => 0,
                'message' => 'Only two user allow accept request'
            );
            
        } else {
            $date = date("Y-m-d H:i:s");
            $data = array(
                'emergency_status' => 1,
                'accept_date_time' => $date
                
            );
            $this->db->where('emergency_notification_id', $emergency_notification_id);
            $data = $this->db->update('tbl_emergency_notification', $data);
            
            $emergency_notification_id = $_REQUEST['emergency_notification_id'];
            
            $result               = "SELECT * FROM  tbl_emergency_notification WHERE emergency_notification_id ='" . $_REQUEST['emergency_notification_id'] . "'";
            $res                  = $this->db->query($result);
            $row                  = $res->row();
            $emergency_id         = $row->emergency_id;
            $notification_user_id = $row->notification_user_id;
            
            $check    = "SELECT * FROM  tbl_emergency_notification WHERE emergency_id ='" . $emergency_id . "'";
            $res      = $this->db->query($check);
            $data     = $res->result_array();
            $countvar = count($data);
            for ($i = 0; $i < $countvar; $i++) {
                $user_ids = $data[$i]['notification_user_id'];
                
                
                $result     = "SELECT * FROM  tbl_user WHERE user_id ='" . $user_ids . "'";
                $res        = $this->db->query($result);
                $row        = $res->row();
                $first_name = $row->first_name;
                // $tracking_user_id = $row->tracking_user_id;
                
                
                $require = array();
                
                $result  = "SELECT * FROM  tbl_emergency WHERE emergency_id ='" . $emergency_id . "'";
                $res     = $this->db->query($result);
                $row     = $res->row();
                $user_id = $row->user_id;
                
                
                $sql                       = "SELECT * FROM tbl_user WHERE `user_id` IN ('$user_id')";
                $res                       = $this->db->query($sql);
                $row                       = $res->row();
                $notification_device_token = $row->notification_device_token;
                $mobile_type               = $row->mobile_type;
                $user_id                   = $row->user_id;
                $sql                       = "SELECT notification_tone,user_id FROM tbl_notification WHERE `user_id`='$user_id'";
                    $resultdatatone = $this->db->query($sql);
                    $resultdatatone = $resultdatatone->row();
                    $notification_tone = $resultdatatone->notification_tone;
                //  print_r($row);  
                $ch                        = curl_init("https://fcm.googleapis.com/fcm/send");
                $sound = $notification_tone;
                $title                     = $first_name;
                $body                      = "Accept your helping request.";
                $notification              = array(
                     'title' => $title,
                     'text' => $body,
                     'sound'=>$sound
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
            }
             $returnresult = array(
            'status' => 1,
            'message' => 'success',
            'response' => $require
           );
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
 WHERE from_user_id=$from_user_id and community_id= $community_id");
return $result->result();


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
        $check = "SELECT * FROM tbl_emergency_contact WHERE user_id ='" . $_REQUEST['user_id'] . "' and emergency_user_help_id ='0' and phone_number ='" . $_REQUEST['phone_number'] . "' ";
        $rs    = mysql_query($check);
        $data  = mysql_fetch_array($rs);
        if ($data[0] > 1) {
            $returnresult = array(
                'status' => 0,
                'message' => 'User contact in Exists'
            );
        } else {
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
                    'message' => 'User contact successfully submit'
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
        
        
        
        $data = array(
            'emergency_status' => 2
            
        );
        $this->db->where('notification_user_id', $notification_user_id);
        $this->db->where('emergency_id', $emergency_id);
        $data = $this->db->update('tbl_emergency_notification', $data);
        
        if ($data) {
            
            $data = array(
                'user_id' => $notification_user_id,
                'emergency_id' => $emergency_id,
                'message_data' => $message_data,
                'status' => 1
            );
            $data = $this->db->insert('tbl_emergency_communitaction', $data);
            
            $returnresult = array(
                'status' => 1,
                'message' => 'Emergency end successfully'
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

$result  =$this->db->query("SELECT `tbl_user`.user_id,`tbl_user`.user_name,`tbl_emergency`.user_id,`tbl_emergency`.emergency_id,`tbl_emergency`.emergency_latitude,`tbl_emergency`.emergency_longitude,`tbl_emergency`.emergency_address,`tbl_emergency`.emergency_type,`tbl_emergency`.add_date,`tbl_emergency_notification`.emergency_notification_id,`tbl_emergency_notification`.emergency_status,`tbl_emergency_notification`.send_date_time,`tbl_emergency_notification`.accept_date_time,CONVERT_TZ(`tbl_emergency_notification`.send_date_time, @@session.time_zone, '$time')as senddate
FROM `tbl_user`
JOIN `tbl_emergency` ON `tbl_emergency`.`user_id` = `tbl_user`.`user_id`
JOIN `tbl_emergency_notification` on `tbl_emergency`.`emergency_id` = `tbl_emergency_notification`.`emergency_id`
 WHERE(`tbl_emergency_notification`.`notification_user_id`=$user_id or `tbl_emergency`.`user_id` = $user_id ) and `tbl_emergency_notification`.emergency_status!=2 ORDER BY `tbl_emergency_notification`.send_date_time DESC LIMIT $start,10");

       
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
       $user_id = $_REQUEST['user_id'];
       $result  = $this->db->query("SELECT asset_id,user_id,asset_name,asset_type,asset_number,asset_number,latitude,longitude from tbl_user_asset where user_id='$user_id'");
  
       return $result->result();
  
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
                    'message' => 'User asset update successfully'
                );
            }
         else {
            $returnresult = array(
                'status' => 0,
                'message' => 'contact not found'
            );
        }
        
        return $returnresult;
        
    }

}