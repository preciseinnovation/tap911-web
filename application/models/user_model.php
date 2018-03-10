<?php
class User_model extends CI_Model
{
    
    
    function __construct()
    {
        parent::__construct();
    }
    
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
            
            $returnarray = array(
                'status' => 0,
                'message' => 'Username or pasword is invalid'
            );
        }
        return $returnarray;
    }


function facebook_login()
    {
         $login = $_REQUEST['login'];
         $facebook_id = $_REQUEST['facebook_id'];
        $sql = "SELECT user_name ,user_id, email FROM tbl_user where email = '$login' and facebook_id='$facebook_id' and status=1";
        $res = $this->db->query($sql);
        
        if ($res->num_rows > 0 && $facebook_id!="") {
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
           $data = array(
                    'facebook_id' =>  $facebook_id,
                    'email' => $login,
                    'first_name' => $_REQUEST['first_name'],
                    'last_name' => $_REQUEST['last_name'],
                    'token' => $token,
                    'notification_device_token' => $_REQUEST['notification_device_token'],
                    'mobile_type' => $_REQUEST['mobile_type'],
                    'status' => 1
                );
                $data = $this->db->insert('tbl_user', $data);
                $id   = $this->db->insert_id();
                $sql = "SELECT token,user_id FROM tbl_user WHERE user_id ='" .  $id . "'";
                $res = $this->db->query($sql);
                 $row = $res->row();
                $user_id      = $row->user_id;
                $token = $row->token;
                $returnarray = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $user_id
            );
        }
        return $returnarray;
    }
    
    

function google_login()
    {
         $login = $_REQUEST['login'];
         $google_id = $_REQUEST['google_id'];
        $sql = "SELECT user_name ,user_id, email FROM tbl_user where email = '$login' and google_id='$google_id'  and status=1";
        $res = $this->db->query($sql);
        
        if ($res->num_rows > 0 &&  $google_id!="") {
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
           $data = array(
                    'google_id' =>  $google_id,
                    'email' => $login,
                    'first_name' => $_REQUEST['first_name'],
                    'last_name' => $_REQUEST['last_name'],
                    'token' => $token,
                    'notification_device_token' => $_REQUEST['notification_device_token'],
                    'mobile_type' => $_REQUEST['mobile_type'],
                    'status' => 1
                );
                $data = $this->db->insert('tbl_user', $data);
                $id   = $this->db->insert_id();
                $sql = "SELECT token,user_id FROM tbl_user WHERE user_id ='" .  $id . "'";
                $res = $this->db->query($sql);
                 $row = $res->row();
                $user_id      = $row->user_id;
                $token = $row->token;
                $returnarray = array(
                'status' => 1,
                'token' => $token,
                'user_id' => $user_id
            );
        }
        return $returnarray;
    }


    function user_registration()
    {
        
        $check = "SELECT * FROM tbl_user WHERE email ='" . $_REQUEST['email'] . "' or user_name ='" . $_REQUEST['user_name'] . "'";
        $rs    = mysql_query($check);
        $data  = mysql_fetch_array($rs);
        if ($data[0] > 1) {
            $returnresult = array(
                'status' => 0,
                'message' => 'User already in Exists'
            );
        } else {
            
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
               // if (!preg_match('/^[0-9]{20}+$/', $_REQUEST['phone_number']))
                  if(!is_numeric($_REQUEST['phone_number']))
                 {
                    $returnresult = die(json_encode(array(
                        "status" => 0,
                        "message" => "Please Enter number only"
                    )));
                }
                if (ctype_alpha($_REQUEST['user_name']) === false) {
                    
                    $returnresult = die(json_encode(array(
                        "status" => 0,
                        "message" => "User Name must only contain letters!"
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
                    'phone_number_text_msg_country_code' => $_REQUEST['country_id'],
                    'phone_number_text_msg' => $_REQUEST['phone_number'],
                    // 'phone_number_voice_notification_country_code' => $_REQUEST['phone_number_voice_notification_country_code'],
                    // 'phone_number_voice_notification' => $_REQUEST['phone_number_voice_notification'],
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
    
    function get_community()
    {
        $user_id = $_REQUEST['user_id'];
        $result  = $this->db->query("SELECT tc.community_name,tc.community_id,tc.community_description,tc.community_logo,tc.community_website,tc.community_email,tc.community_address,tc.add_date,tc.status,
ifnull((select ifnull(tcum.`request_status`,0) as request_status from `tbl_community_user_mapping` tcum where tcum.`user_id`=$user_id and tcum.`community_id`=tc.`community_id`),tc.`default_status`) as request_status
FROM `tbl_community` tc WHERE tc.status=1 and del_date='0000-00-00 00:00:00'");
        return $result->result();
    }
    
    
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
            $data      = array(
                'user_id' => $_REQUEST['user_id'],
                'community_id' => $_REQUEST['community_id'],
                'request_status' => $_REQUEST['request_status'],
                
                'status' => 1
            );
            $data      = $this->db->insert('tbl_community_user_mapping', $data);
            $insert_id = $this->db->insert_id($data);
            
            $sql              = "SELECT community_id,community_user_mapping_id FROM tbl_community_user_mapping where community_user_mapping_id ='" . $insert_id . "'";
            $res              = $this->db->query($sql);
            $row              = $res->row();
            $community_id     = $row->community_id;
            $sqlresult        = "SELECT community_name,community_id,community_description FROM tbl_community where community_id ='" . $community_id . "'";
            $resresult        = $this->db->query($sqlresult);
            $rows             = $resresult->row();
            $community_name   = $rows->community_name;
            $alert_descrption = $rows->community_description;
            
            
            $data = array(
                'user_id' => $_REQUEST['user_id'],
                'community_id' => $community_id,
                'alert_heading' => $community_name,
                'alert_descrption' => $alert_descrption,
                'alert_lat' => $_REQUEST['alert_lat'],
                'alert_lang' => $_REQUEST['alert_lang'],
                'status' => 1
            );
            $data = $this->db->insert('tbl_alert', $data);
            
            $returnresult = array(
                'status' => 1,
                'message' => 'User community request is confirmed',
                'request_status' => $_REQUEST['request_status']
            );
        }
        
        return $returnresult;
    }
    // function get_user_message()
    // {
    //     $user_id = $_REQUEST['user_id'];
    //     $this->db->select('tbl_user.user_id,tbl_community_user_mapping.user_id,tbl_community_user_mapping.status,tbl_community.*');
    //     $this->db->from('tbl_community_user_mapping');
    //     $this->db->join('tbl_user', 'tbl_user.user_id = tbl_community_user_mapping.user_id', 'INNER');
    //     $this->db->join('tbl_community', 'tbl_community.community_id = tbl_community_user_mapping.community_id', 'INNER');
    //     $this->db->where('tbl_community_user_mapping.status', 1);
    //     $this->db->where('tbl_community_user_mapping.user_id', $user_id);
    //     $query = $this->db->get();
    //     return $query->result();
    // }
    
    
    function user_comment_alertwise()
    {
        $data = array(
            'comment_user_id' => $_REQUEST['comment_user_id'],
            'alert_id' => $_REQUEST['alert_id'],
            'comment_text' => $_REQUEST['comment_text'],
            'status' => 1
        );
        $data = $this->db->insert('tbl_comment', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User comment successfully submit'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
    }
    function user_comment_communitywise()
    {
        $data = array(
            'comment_user_id' => $_REQUEST['comment_user_id'],
            'community_id' => $_REQUEST['community_id'],
            'comment_text' => $_REQUEST['comment_text'],
            'status' => 1
        );
        $data = $this->db->insert('tbl_comment', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User comment successfully submit'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
    }
    
    
    function get_comment_communitywise($limit, $start = 100)
    {
        $community_id = $_REQUEST['community_id'];
         $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.*,tbl_user.user_id,tbl_comment.*');
        $this->db->from('tbl_comment');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_comment.comment_user_id', 'RIGHT');
        $this->db->join('tbl_community', 'tbl_community.community_id = tbl_comment.community_id', 'RIGHT');
        $this->db->limit($limit, $start);
        $this->db->where('tbl_comment.community_id', $community_id);
        $this->db->where('tbl_user.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_comment_alertwise()
    {
        $alert_id = $_REQUEST['alert_id'];
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.*,tbl_comment.*');
        $this->db->from('tbl_comment');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_comment.comment_user_id', 'INNER');
        $this->db->join('tbl_alert', 'tbl_alert.alert_id = tbl_comment.alert_id', 'INNER');
        $this->db->where('tbl_alert.alert_id', $alert_id);
         $this->db->where('tbl_user.user_id', $user_id);
        $this->db->group_by('comment_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_alert_communitywise()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.*,tbl_user.user_id,tbl_alert.user_id,tbl_alert.*,tbl_community.*');
        $this->db->from('tbl_alert');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_alert.user_id', 'INNER');
        $this->db->join('tbl_community', 'tbl_community.community_id = tbl_alert.community_id', 'INNER');
         $this->db->where('tbl_user.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_user_alert($limit, $start = 50)
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.*,tbl_user.user_id,tbl_alert.user_id,tbl_alert.*,tbl_community.*,tbl_alert.status as userstatus');
        $this->db->from('tbl_alert');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_alert.user_id', 'left');
        $this->db->join('tbl_community', 'tbl_community.community_id = tbl_alert.community_id', 'left');
         $this->db->limit($limit, $start);
        $this->db->where('tbl_alert.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function get_community_emergency_contact($community_ids)
    {
        $tmp_community_id = $community_ids;
        $this->db->select('tbl_community_emergency_number.*');
        $this->db->from('tbl_community_emergency_number');
        $this->db->where('tbl_community_emergency_number.community_id', $tmp_community_id);

        $query = $this->db->get();
        return $query->result();
        
        
    }
    function get_community_emergency_list()
    {
        
        $this->db->select('tbl_community.*');
        $this->db->from('tbl_community');
        $query = $this->db->get();
        return $query->result();
    }
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
                'phone_number_text_msg_country_code' => $_REQUEST['phone_number_text_msg_country_code'],
                'phone_number_text_msg' => $_REQUEST['phone_number_text_msg'],
                'phone_number_voice_notification_country_code' => $_REQUEST['phone_number_voice_notification_country_code'],
                'phone_number_voice_notification' => $_REQUEST['phone_number_voice_notification'],
                'medical_history' => $_REQUEST['medical_history'],
                'medication_instraction' => $_REQUEST['medication_instraction'],
                'allergies' => $_REQUEST['allergies'],
                'special_need' => $_REQUEST['special_need'],
                'user_lat' => $_REQUEST['user_lat'],
                'user_long' => $_REQUEST['user_long']
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
    // function update_profile_picture()
    // {
        
    //     $check = "SELECT * FROM tbl_user WHERE user_id ='" . $_REQUEST['user_id'] . "'";
    //     $res   = $this->db->query($check);
    //     if ($res->num_rows > 0) {
    //         $row         = $res->row();
    //         $user_id         = $res->user_id;
    //         $target      = "./uploads/";
    //         $target      = $target . basename($_FILES['profile_pic']['name']);
    //         $profile_pic = ($_FILES['profile_pic']['name']);
    //         if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
                
    //             $data = array(
    //                 'user_id' => $_REQUEST['user_id'],
    //                 'profile_pic' => $profile_pic
    //             );
    //             $this->db->where('user_id', $user_id);
    //             $data = $this->db->update('tbl_user', $data);
    //             if ($data) {
    //                 $returnresult = array(
    //                     'status' => 1,
    //                     'message' => 'User profile picture update successfully'
    //                 );
    //             }
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Some data not valid'
    //             );
    //         }
    //        return $returnresult;
    //     }

    // }
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
    function add_user_emergency_contact()
    {
        
        $data = array(
            'user_id' => $_REQUEST['user_id'],
            'name' => $_REQUEST['name'],
            'description' => $_REQUEST['description'],
            'phone_number' => $_REQUEST['phone_number'],
            'tap911_user' => $_REQUEST['tap911_user'],
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
        
        return $returnresult;
    }
    
    function update_user_emergency_contact()
    {
        $check = "SELECT * FROM  tbl_emergency_contact WHERE emergency_contact_id ='" . $_REQUEST['emergency_contact_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row                  = $res->row();
            $emergency_contact_id = $row->emergency_contact_id;

            $data                 = array(
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
        }else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'contact not found'
                );
            }
            
            return $returnresult;
        
    }
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
    function get_user_profiledata()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.*');
        $this->db->from('tbl_user');
        $this->db->where('tbl_user.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_notification_setting()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_notification.*');
        $this->db->from('tbl_notification');
        $this->db->where('tbl_notification.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    
    function get_country_emergency_number()
    {
        $this->db->select('tbl_country.*');
        $this->db->from('tbl_country');
        $this->db->where('tbl_country.status', 1);
        $this->db->order_by("tbl_country.country_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    function get_country_emergency_number_with_token()
    {
        $this->db->select('tbl_country.*');
        $this->db->from('tbl_country');
        $this->db->where('tbl_country.status', 1);
        $this->db->order_by("tbl_country.country_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
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
    
    function get_emergency_tracking()
    {
        $this->db->select('tbl_emergency.*');
        $this->db->from('tbl_emergency');
        $this->db->where('tbl_emergency.status', 1);
        $this->db->order_by("tbl_emergency.emergency_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    function get_state()
    {
        $this->db->select('tbl_state.*');
        $this->db->from('tbl_state');
        $this->db->where('tbl_state.status', 1);
        $this->db->order_by("tbl_state.state_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    function get_city()
    {
        $this->db->select('tbl_city.*');
        $this->db->from('tbl_city');
        $this->db->where('tbl_city.status', 1);
        $this->db->order_by("tbl_city.city_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    function delete_user()
    {
        $user_id = $_REQUEST['user_id'];
        //$this->db->where('user_id', $user_id);
       // $data = $this->db->delete('tbl_user');
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
    
    
    
    function get_emergency_user()
    {
        // $user_id = $_REQUEST['user_id'];
        // $this->db->select('tbl_emergency.*');
        // $this->db->from('tbl_emergency');
        // $this->db->where('user_id', $user_id);
        // $query = $this->db->get();
        // return $query->result();

        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_emergency.*,tbl_user.*,tbl_emergency_notification.*');
        $this->db->from('tbl_emergency_notification');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_emergency_notification.notification_user_id', 'left');
        $this->db->join('tbl_emergency', 'tbl_emergency.emergency_id = tbl_emergency_notification.emergency_id', 'left');
        $this->db->where('tbl_user.del_date', '0000-00-00 00:00:00');
         $this->db->where('tbl_emergency_notification.emergency_status', '0');
         $this->db->where('tbl_user.status', 1);
          $this->db->where('tbl_emergency_notification.notification_user_id',$user_id);
        $query = $this->db->get();
        //  echo $this->db->last_query();
        return $query->result();

    }
    
    
    
    
    function add_emergency_user()
    {
        $user_lat  = $_REQUEST['emergency_latitude'];
        $user_long = $_REQUEST['emergency_longitude'];
        $data      = array(
            'user_id' => $_REQUEST['user_id'],
            'emergency_latitude' => $user_lat,
            'emergency_longitude' => $user_long,
            'emergency_address' => $_REQUEST['emergency_address'],
            'emergency_type' => $_REQUEST['emergency_type'],
            'status' => 1
        );
        
        $data = $this->db->insert('tbl_emergency', $data);
        $ids  = $this->db->insert_id();
        
        
        /* user notify */
        
        $results = $this->db->query("SELECT user_id,first_name,user_lat,user_long,
            3956 * 2 * ASIN(SQRT( POWER(SIN(($user_lat -  tbl_user.user_lat) * pi()/180 / 2), 2) + COS($user_lat * pi()/180) * COS( tbl_user.user_lat * pi()/180) *
            POWER(SIN(($user_long - tbl_user.user_long) * pi()/180 / 2), 2) )) as
            distance FROM tbl_user
             WHERE  tbl_user.user_id NOT IN ('" . $_REQUEST['user_id'] . "')   
            GROUP BY tbl_user.user_id HAVING distance <= 5 ORDER by distance ASC");
        
        $resultdata     = $results->result_array();
        $countvarresult = count($resultdata);
        $require        = array();
        // $alert_type[] ='user';
        for ($i = 0; $i < $countvarresult; $i++) {
            //$alert_type ='user';
            $id         = $resultdata[$i]['user_id'];
            // $alert_address = $data[$i]['address'];
            $alert_lat  = $resultdata[$i]['user_lat'];
            $alert_lang = $resultdata[$i]['user_long'];
            $SQL        = "insert into tbl_emergency_notification(notification_user_id,emergency_id,em_lat,em_long) values('$id','$ids','$alert_lat','$alert_lang')";
            $res        = mysql_query($SQL);
            $emergency_notification_id   = $this->db->insert_id();
            
            
            $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$id')";
            $res = $this->db->query($sql);
            $row = $res->row();
            // print_r($row);
            // die();
            if ($row) {
                $notification_device_token  = $row->notification_device_token;
                $mobile_type = $row->mobile_type;
                $ch          = curl_init("https://fcm.googleapis.com/fcm/send");
                
                $usertoken    = $notification_device_token;
                $title        = "tap911";
                $body         = "This is test message from tap911.";
                $notification = array(
                    'title' => $title,
                    'text' => $body,
                    'emergency_notification_id' => $emergency_notification_id
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
                    $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
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
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Some data not valid'
                );
            }
        }
        
        /*  end user */
        
        if (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }
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
        $data   = $result->result_array();
        
        $countvar = count($data);
        $require  = array();
        // $alert_type[] ='user';
        for ($i = 0; $i < $countvar; $i++) {
            //$alert_type ='user';
            $id         = $data[$i]['user_id'];
            // $alert_address = $data[$i]['address'];
            $alert_lat  = $data[$i]['latitude'];
            $alert_lang = $data[$i]['longitude'];
            $SQL        = "insert into tbl_emergency_notification(notification_user_id,emergency_id,em_lat,em_long) values('$id','$ids','$alert_lat','$alert_lang')";
            $res        = mysql_query($SQL);
            $emergency_notification_id   = $this->db->insert_id();
            
            
            $sql = "SELECT * FROM tbl_user WHERE `user_id` IN ('$id')";
            $res = $this->db->query($sql);
            $row = $res->row();
            // print_r($row);
            // die();
            if ($row) {
                $notification_device_token  = $row->notification_device_token;
                $mobile_type = $row->mobile_type;
                $ch          = curl_init("https://fcm.googleapis.com/fcm/send");
                
                $usertoken    = $notification_device_token;
                $title        = "tap911";
                $body         = "This is test message from tap911.";
                $notification = array(
                    'title' => $title,
                    'text' => $body,
                    'emergency_notification_id' => $emergency_notification_id
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
                    $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
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
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Some data not valid'
                );
            }
        }
        
        $returnresult = array(
            'status' => 1,
            'data' => $require,
            'message' => 'success'
            
        );
        
        return $returnresult;
    }
    
    
    
    function accept_emergency_request()
    {
        $emergency_notification_id = $_REQUEST['emergency_notification_id'];
        //$tracking_user_id = $_REQUEST['tracking_user_id'];
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
            
            
            // if($value>=2){
            
            //           $returnresult = array(
            //                'status' => 1,
            //                'message' => 'Only two user allow accept request'
            //                //'response'=>$require
            //            );
            
            
            //             }
            if ($value != 0 && $value >= 2) {
                
                
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
                    
                    
                    $sql          = "SELECT * FROM tbl_user WHERE `user_id` IN ('$user_id')";
                    $res          = $this->db->query($sql);
                    $row          = $res->row();
                    $notification_device_token   = $row->notification_device_token;
                    $mobile_type  = $row->mobile_type;
                    //  print_r($row);  
                    $ch           = curl_init("https://fcm.googleapis.com/fcm/send");
                    $title        = $first_name;
                    $body         = "Accept your helping request.";
                    $notification = array(
                        'title' => $title,
                        'text' => $body
                    );
                    $arrayToSend  = array(
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
                        $headers[] = 'Authorization: key= AIzaSyC5Z-wS9-IFx4nVCAfMjF9v7MwBQQR_5kw'; // key here
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
                
                $data = array(
                    'emergency_status' => 2
                    
                    
                );
                $this->db->where('emergency_id', $emergency_id);
                $data = $this->db->update('tbl_emergency_notification', $data);
                
            }
            
            
            else {
                
                $data = array(
                    'emergency_status' => 1
                    
                    
                );
                $this->db->where('emergency_notification_id', $emergency_notification_id);
                $data = $this->db->update('tbl_emergency_notification', $data);
                if ($data) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Thank you for accepting help request'
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
    
    
    function get_emergency_live_location()
    {
        
        if (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }
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
    
    
    function get_user_type()
    {
        $this->db->select('*');
        $this->db->from('tbl_user_type');
        $query = $this->db->get();
        return $query->result();
    }
    
    function add_community_communitaction()
    {
        
        $data = array(
            'from_user_id' => $_REQUEST['from_user_id'],
            'to_user_id' => $_REQUEST['to_user_id'],
            'community_id' => $_REQUEST['community_id'],
            'message_data' => $_REQUEST['message_data'],
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
     function get_tap911_user_list()
    {
         $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.*');
        $this->db->from('tbl_user');
        $this->db->where('status', 1);
        $this->db->where('del_date', '0000-00-00 00:00:00');
        $this->db->where_not_in('user_id', $user_id);
        $this->db->order_by("user_id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
}
