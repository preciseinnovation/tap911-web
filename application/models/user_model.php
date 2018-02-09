<?php
class User_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
    }
    
    function checklogin($login, $password)
    {
        
        $sql = "SELECT * FROM tbl_user where ( user_name='$login' OR email = '$login') and password = '$password' ";
        $res = $this->db->query($sql);
        
        if ($res->num_rows > 0) {
            $row         = $res->row();
            $customer_id = $row->user_id;
            $tokens      = openssl_random_pseudo_bytes(8);
            $token       = bin2hex($tokens);
            $returnarray = array(
                'status' => 1,
                'user_id' => $customer_id,
                'token' => $token
            );
            $data        = array(
                'token' => $token
            );
            $this->db->where('user_id', $customer_id);
            $value = $this->db->update('tbl_user', $data);
        } else {
            
            $returnarray = array(
                'status' => 0,
                'message' => ' fail, Username or pasword is invalid'
            );
        }
        return $returnarray;
    }
    function user_registration()
    {
        
        $check = "SELECT * FROM tbl_user WHERE user_name ='" . $_REQUEST['user_name'] . "'";
        $rs    = mysql_query($check);
        $data  = mysql_fetch_array($rs);
        if ($data[0] > 1) {
            $returnresult = array(
                'status' => 0,
                'message' => 'User already in Exists'
            );
        } else {
            
            $target      = "./uploads/";
            $path        = "http://104.237.3.116/tap911/uploads/";
            $target      = $target . basename($_FILES['profile_pic']['name']);
            $profile_pic = ($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
                
                
                
                $data = array(
                    'first_name' => $_REQUEST['first_name'],
                    'last_name' => $_REQUEST['last_name'],
                    'user_name' => $_REQUEST['user_name'],
                    'email' => $_REQUEST['email'],
                    'phone_number_text_msg_country_code' => $_REQUEST['phone_number_text_msg_country_code'],
                    'phone_number_text_msg' => $_REQUEST['phone_number_text_msg'],
                    'phone_number_voice_notification_country_code' => $_REQUEST['phone_number_voice_notification_country_code'],
                    'phone_number_voice_notification' => $_REQUEST['phone_number_voice_notification'],
                    'password' => md5($_REQUEST['password']),
                    'user_type' => 'user',
                    'profile_pic' => $path . $profile_pic,
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
                        'message' => 'User registration successfully submit'
                    );
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'error' => 'Some data not valid'
                    );
                }
            } else {
                
                $data = array(
                    'first_name' => $_REQUEST['first_name'],
                    'last_name' => $_REQUEST['last_name'],
                    'user_name' => $_REQUEST['user_name'],
                    'email' => $_REQUEST['email'],
                    'phone_number_text_msg_country_code' => $_REQUEST['phone_number_text_msg_country_code'],
                    'phone_number_text_msg' => $_REQUEST['phone_number_text_msg'],
                    'phone_number_voice_notification_country_code' => $_REQUEST['phone_number_voice_notification_country_code'],
                    'phone_number_voice_notification' => $_REQUEST['phone_number_voice_notification'],
                    'password' => md5($_REQUEST['password']),
                    'user_type' => 'user',
                    'status' => 1
                );
                $data = $this->db->insert('tbl_user', $data);
                $id   = $this->db->insert_id();
                if ($data) {
                    $data         = array(
                        'user_id' => $id,
                        'status' => 1
                    );
                    $data         = $this->db->insert('tbl_notification', $data);
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'User registration successfully submit'
                    );
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'error' => 'Some data not valid'
                    );
                }
            }
            return $returnresult;
        }
        //}
        
    }
    
    function get_community()
    {
        $user_id = $_REQUEST['user_id'];
        $result  = $this->db->query("
SELECT tc.*,
ifnull((select ifnull(tcum.`request_status`,0) as request_status from `tbl_community_user_mapping` tcum where tcum.`user_id`=$user_id and tcum.`community_id`=tc.`community_id`),tc.`default_status`) as request_status
FROM `tbl_community` tc");
        return $result->result();
    }
    
    function get_community_result()
    {
        
        $this->db->select('*');
        $this->db->from('tbl_community');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    function get_community_user_map()
    {
        $this->db->select('*');
        $this->db->from('tbl_community_user_mapping');
        $this->db->where('user_id', '77');
        $query = $this->db->get();
        return $query->result_array();
        
    }
    
    function user_community_request()
    {
        $sql = "SELECT * FROM tbl_community_user_mapping WHERE community_id ='" . $_REQUEST['community_id'] . "' and user_id ='" . $_REQUEST['user_id'] . "' ";
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
                $sql            = "SELECT * FROM tbl_community_user_mapping WHERE user_id ='" . $user_id . "'";
                $res            = $this->db->query($sql);
                $row            = $res->row();
                $request_status = $row->request_status;
                $returnresult   = array(
                    'status' => 1,
                    'message' => 'User request successfully submit',
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
            
            $sql              = "SELECT * FROM tbl_community_user_mapping where community_user_mapping_id ='" . $insert_id . "'";
            $res              = $this->db->query($sql);
            $row              = $res->row();
            $community_id     = $row->community_id;
            $sqlresult        = "SELECT * FROM tbl_community where community_id ='" . $community_id . "'";
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
                'message' => 'User request successfully submit',
                'request_status' => $_REQUEST['request_status']
            );
        }
        
        return $returnresult;
    }
    function get_user_message()
    {
        $user_id = $_REQUEST['user_id'];
        $this->db->select('tbl_user.user_id,tbl_community_user_mapping.user_id,tbl_community_user_mapping.status,tbl_community.*');
        $this->db->from('tbl_community_user_mapping');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_community_user_mapping.user_id', 'INNER');
        $this->db->join('tbl_community', 'tbl_community.community_id = tbl_community_user_mapping.community_id', 'INNER');
        $this->db->where('tbl_community_user_mapping.status', 1);
         $this->db->where('tbl_community_user_mapping.user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    
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
        $this->db->select('tbl_user.*,tbl_user.user_id,tbl_comment.*');
        $this->db->from('tbl_comment');
         $this->db->join('tbl_user', 'tbl_user.user_id = tbl_comment.comment_user_id', 'INNER');
       // $this->db->join('tbl_user', 'tbl_user.user_id = tbl_community_user_mapping.user_id', 'INNER');
       // $this->db->join('tbl_comment', 'tbl_comment.comment_user_id = tbl_community_user_mapping.user_id', 'INNER');
        $this->db->join('tbl_community', 'tbl_community.community_id = tbl_comment.community_id', 'INNER');
        $this->db->limit($limit, $start);
         $this->db->where('tbl_comment.community_id', $community_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_comment_alertwise()
    {
        $alert_id = $_REQUEST['alert_id'];
        $this->db->select('tbl_user.*,tbl_user.user_id, tbl_comment.*');
        $this->db->from('tbl_comment');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_comment.comment_user_id', 'INNER');
        // $this->db->join('tbl_comment', 'tbl_comment.comment_user_id = tbl_community_user_mapping.user_id', 'INNER');
        $this->db->join('tbl_alert', 'tbl_alert.alert_id = tbl_comment.alert_id', 'INNER');
        $this->db->where('tbl_alert.alert_id', $alert_id);
        $this->db->group_by('comment_id');
        //$this->db->order_by("tbl_comment.comment_id", "asc");
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_alert_communitywise()
    {
        $this->db->select('tbl_user.*,tbl_user.user_id,tbl_alert.user_id,tbl_alert.*,tbl_community.*');
        $this->db->from('tbl_alert');
        $this->db->join('tbl_user', 'tbl_user.user_id = tbl_alert.user_id', 'INNER');
        $this->db->join('tbl_community', 'tbl_community.community_id = tbl_alert.community_id', 'INNER');
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
        // $sql = $this->db->last_query();
        //echo  $sql;
        //die();
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
                    'message' => 'User history update successfully'
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
    function update_profile_picture()
    {
        
        $check = "SELECT * FROM  tbl_user WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row         = $res->row();
            $target      = "./uploads/";
            $path        = "http://104.237.3.116/tap911/uploads/";
            //echo $target;die;
            $target      = $target . basename($_FILES['profile_pic']['name']);
            $profile_pic = ($_FILES['profile_pic']['name']);
            $user_id     = $_REQUEST['user_id'];
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
                //  $profile_pic = $path.$profile_pic;
                // );
                $data = array(
                    
                    'profile_pic' => $path . $profile_pic
                );
                $this->db->where('user_id', $user_id);
                $data = $this->db->update('tbl_user', $data);
                if ($data) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'User profile update successfully'
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
                    'status' => 0,
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
            // 'country_id' => $_REQUEST['country_id'],
            'country_code' => $_REQUEST['country_code'],
            'status' => 1
        );
        $data = $this->db->insert('tbl_emergency_contact', $data);
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
                // 'user_id' => $_REQUEST['user_id'],
                'name' => $_REQUEST['name'],
                'description' => $_REQUEST['description'],
                'phone_number' => $_REQUEST['phone_number'],
                // 'country_id' => $_REQUEST['country_id'],
                'country_code' => $_REQUEST['country_code'],
                'status' => 1
            );
            $this->db->where('emergency_contact_id', $emergency_contact_id);
            $data = $this->db->update('tbl_emergency_contact', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 1,
                    'message' => 'User contact  update successfully'
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
        $this->db->where('user_type', 'user');
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
        $check = "SELECT * FROM  tbl_emergency_tracking WHERE user_id ='" . $_REQUEST['user_id'] . "'";
        $res   = $this->db->query($check);
        if ($res->num_rows > 0) {
            $row     = $res->row();
            $user_id = $row->user_id;
            
            $data = array(
                'user_id' => $_REQUEST['user_id'],
                'address' => $_REQUEST['address'],
                'latitude' => $_REQUEST['latitude'],
                'longitude' => $_REQUEST['longitude'],
                'status' => 1
            );
            $this->db->where('user_id', $user_id);
            $data = $this->db->update('tbl_emergency_tracking', $data);
            if ($data) {
                $returnresult = array(
                    'status' => 0,
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
            $data = $this->db->insert('tbl_emergency_tracking', $data);
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
    
    function get_emergency_tracking()
    {
        $this->db->select('tbl_emergency_tracking.*');
        $this->db->from('tbl_emergency_tracking');
        $this->db->where('tbl_emergency_tracking.status', 1);
        $this->db->order_by("tbl_emergency_tracking.emergency_tracking_id", "DESC");
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
        $this->db->where('user_id', $user_id);
        $data = $this->db->delete('tbl_user');
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


     function add_geofence()
    {
       $data = array(
                        'user_id' => $_REQUEST['user_id'],
                        'geo_lat' => $_REQUEST['geo_lat'],
                        'geo_long' => $_REQUEST['geo_long'],
                        'radius' => $_REQUEST['radius'],
                        'geofence_name' => $_REQUEST['geofence_name'],
                         'in_alert' => $_REQUEST['in_alert'],
                         'out_alert' => $_REQUEST['out_alert'],
                         'address' => $_REQUEST['address'],
                         'geo_type' => $_REQUEST['geo_type'],
                         'zone_address' => $_REQUEST['zone_address'],
                         'distance' => $_REQUEST['distance'],
                         
                          'status' => 1
        );

        $data = $this->db->insert('tbl_geo_fence', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User geofence successfully submit'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
}

    function list_geofence()
    {
         $user_id =$_REQUEST['user_id'];
        $this->db->select('tbl_geo_fence.*');
        $this->db->from('tbl_geo_fence');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

     function update_geofence()
    {
        $geo_fence_id = $_REQUEST['geo_fence_id'];
       $data = array(
                        'user_id' => $_REQUEST['user_id'],
                        'geo_lat' => $_REQUEST['geo_lat'],
                        'geo_long' => $_REQUEST['geo_long'],
                        'radius' => $_REQUEST['radius'],
                        'geofence_name' => $_REQUEST['geofence_name'],
                         'in_alert' => $_REQUEST['in_alert'],
                         'out_alert' => $_REQUEST['out_alert'],
                         'address' => $_REQUEST['address'],
                         'geo_type' => $_REQUEST['geo_type'],
                         'zone_address' => $_REQUEST['zone_address'],
                         'distance' => $_REQUEST['distance']
                         
        );
           $this->db->where('tbl_geo_fence.geo_fence_id', $geo_fence_id);
           $data = $this->db->update('tbl_geo_fence', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User geofence update successfully'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
}


 function delete_geofence()
    {
        $geo_fence_id = $_REQUEST['geo_fence_id'];
        $this->db->where('geo_fence_id', $geo_fence_id);
        $data = $this->db->delete('tbl_geo_fence');
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'Geofence delete successfully'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        return $returnresult;
    }


     function add_emergency_user()
    {
       $data = array(
                        'user_id' => $_REQUEST['user_id'],
                        'user_lat' => $_REQUEST['user_lat'],
                        'user_long' => $_REQUEST['user_long'],
                        'address' => $_REQUEST['address'],
                         'emergency_type' => $_REQUEST['emergency_type'],
                          'status' => 1
        );

        $data = $this->db->insert('tbl_geofenece_emergency_user', $data);
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User information successfully submit'
            );
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Some data not valid'
            );
        }
        
        return $returnresult;
}



function get_distance_user(){

       $latitude = $_REQUEST['latitude'];
       $longitude = $_REQUEST['longitude'];
       $distance = $_REQUEST['distance'];
        $result  = $this->db->query("SELECT  tbl_emergency_tracking.*,tbl_user.*,
            3956 * 2 * ASIN(SQRT( POWER(SIN(($latitude - tbl_emergency_tracking.latitude) * pi()/180 / 2), 2) + COS($latitude * pi()/180) * COS(tbl_emergency_tracking.latitude * pi()/180) *
            POWER(SIN(($longitude - tbl_emergency_tracking.longitude) * pi()/180 / 2), 2) )) as
            distance FROM tbl_emergency_tracking
             JOIN  tbl_user on tbl_user.user_id =  tbl_emergency_tracking.user_id    
            GROUP BY emergency_tracking_id HAVING distance <= $distance ORDER by distance ASC");

        return $result->result();
    }


     function  user_emergency_request()
    {
        $usertoken =$_REQUEST['usertoken'];
        $type =$_REQUEST['type'];
        $title =$_REQUEST['title'];
        $body =$_REQUEST['body'];

       $data = array(
                        'emergency_tracking_id' => $_REQUEST['emergency_tracking_id'],
                        'user_id' => $_REQUEST['user_id'],
                        'user_lat' => $_REQUEST['user_lat'],
                        'user_long' => $_REQUEST['user_long'],
                        'address' => $_REQUEST['address'],
                        'accept_status'=>0,
                          'status' => 1
        );

        $data = $this->db->insert('tbl_user_emergency_notification', $data);
    $ch = curl_init("https://fcm.googleapis.com/fcm/send");
    $notification = array('title' =>$title , 'text' => $body);
    $arrayToSend = array('to' => $usertoken, 'notification' => $notification,'priority'=>'high');
    $json = json_encode($arrayToSend);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    if($type=='ios'){
        $headers[] = 'Authorization: key= AIzaSyAoqpGCTIDQJ5JtNwSRRGjsR5D9LsCgLcE'; // key here
    }else{
        $headers[] = 'Authorization: key= AIzaSyD0tsbWK80QkBHPYGP3Re2hHRrGPrX8G1k'; // key here
    }
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
        if ($data) {
            $returnresult = array(
                'status' => 1,
                'message' => 'User request successfully submit'
                
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

