<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Webservice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('User_model');
    }
    public function index()
    {
        
        
    }
    /*
    ------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/checklogin?login=sbsgroup@gmail.com&password=123456
    -----------------------------------------------------------------------------------------------------
    */
    function checklogin()
    {
        $login    = isset($_REQUEST['login']) ? $_REQUEST['login'] : "";
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : "";
        
        
        if ($login == "" or $password == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            
            $login    = $_REQUEST['login'];
            $password = md5($_REQUEST['password']);
            $result   = $this->user_model->checklogin($login, $password);
            $result   = json_encode($result);
            print_r($result);
        }
    }
    
    
    /*
    ------------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911//index.php/webservice/user_registration?first_name=pradeep&last_name=kumar&user_name=pradeepss&email=sunil5.sbsgroup@gmail.com&phone_number_text_msg_country_code=123&phone_number_text_msg=1234567890&phone_number_voice_notification_country_code=1234&phone_number_voice_notification=1234567890&password=123456&profile_pic=1.jpg
    ------------------------------------------------------------------------------------------------------------
    */
    function user_registration()
    {
        $first_name                                   = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
        $last_name                                    = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
        $user_name                                    = isset($_REQUEST['user_name']) ? $_REQUEST['user_name'] : "";
        $email                                        = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
        $phone_number_text_msg_country_code           = isset($_REQUEST['phone_number_text_msg_country_code']) ? $_REQUEST['phone_number_text_msg_country_code'] : "";
        $phone_number_text_msg                        = isset($_REQUEST['phone_number_text_msg']) ? $_REQUEST['phone_number_text_msg'] : "";
        $phone_number_voice_notification_country_code = isset($_REQUEST['phone_number_voice_notification_country_code']) ? $_REQUEST['phone_number_voice_notification_country_code'] : "";
        $phone_number_voice_notification              = isset($_REQUEST['phone_number_voice_notification']) ? $_REQUEST['phone_number_voice_notification'] : "";
        $phone_number_voice_notification              = isset($_REQUEST['phone_number_voice_notification']) ? $_REQUEST['phone_number_voice_notification'] : "";
        $password                                     = isset($_REQUEST['password']) ? $_REQUEST['password'] : "";
        // $profile_pic = isset($_REQUEST['profile_pic']) ? $_REQUEST['profile_pic'] :"";
        
        if ($first_name == "" or $last_name == "" or $user_name = "" or $email = "" or $phone_number_text_msg_country_code = "" or $phone_number_text_msg == "" or $phone_number_voice_notification_country_code == "" or $phone_number_voice_notification == "" or $password == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            // $profile_pic = $_REQUEST['profile_pic'];
            $response = $this->user_model->user_registration();
            $response = json_encode($response);
            print_r($response);
            
        }
    }
    
    /*
    -----------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_community?token=dd088bfaaaf468cb
    -----------------------------------------------------------------------------------------
    */
    
    function get_community()
    {
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        
        
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->get_community($token); //user_id
                if ($response) {
                    
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'community_list' => $response
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    function get_community_result()
    {
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        
        
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response      = $this->user_model->get_community_result($token);
                $responsemap   = $this->user_model->get_community_user_map($token);
                $com_user_data = '';
                foreach ($responsemap as $row) {
                    $com_user_data[$row['community_id']] = $row;
                }
                $data = '';
                foreach ($response as $row) {
                    if (isset($com_user_data[$row['community_id']])) {
                        $data[] = array_merge($row, $com_user_data[$row['community_id']]);
                    } else {
                        $data[] = $row;
                    }
                }
                echo json_encode($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    
    /*
    --------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/user_community_request?token=dd088bfaaaf468cb&user_id=1&community_id=2&request_status=1&alert_lat=1.34545&alert_lang=2.34455
    --------------------------------------------------------------------------------------------
    */
    
    function user_community_request()
    {
        $user_id        = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $community_id   = isset($_REQUEST['community_id']) ? $_REQUEST['community_id'] : "";
        $request_status = isset($_REQUEST['request_status']) ? $_REQUEST['request_status'] : "";
        $alert_lat      = isset($_REQUEST['alert_lat']) ? $_REQUEST['alert_lat'] : "";
        $alert_lang     = isset($_REQUEST['alert_lang']) ? $_REQUEST['alert_lang'] : "";
        $token          = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        
        
        if ($user_id == "" or $community_id == "" or $request_status == "" or $token == "" or $alert_lat == "" or $alert_lang == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->user_community_request($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    -------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_user_message?token=dd088bfaaaf468cb
    -------------------------------------------------------------------------------------
    */
    
    function get_user_message()
    {
        
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
          $user_id        = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        if ($token == "" or $user_id=='') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->get_user_message($token);
                if ($response) {
                    
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'user_message' => $response
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                    
                } else {
                    
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    -----------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/changepassword?token=c5287836c739306e&oldpassword=123456&newpassword=12345
    -----------------------------------------------------------------------------
    */
    
    function changepassword()
    {
        $token       = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $oldpassword = isset($_REQUEST['oldpassword']) ? $_REQUEST['oldpassword'] : "";
        $newpassword = isset($_REQUEST['newpassword']) ? $_REQUEST['newpassword'] : "";
        if ($token == "" or $oldpassword == "" or $newpassword == "") {
            die(json_encode(array(
                "status" => "false",
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $oldpassword = $_REQUEST['oldpassword'];
                $newpassword = $_REQUEST['newpassword'];
                $oldpassword = md5($oldpassword);
                if ($oldpassword != '' && $newpassword != '') {
                    $sql    = "SELECT `user_id` FROM tbl_user WHERE password='" . $oldpassword . "'";
                    $query  = mysql_query($sql);
                    $result = mysql_fetch_array($query);
                    if ($result) {
                        $id      = $result["user_id"];
                        $newPass = md5($newpassword);
                        $sql1    = mysql_query("UPDATE tbl_user SET password='" . $newPass . "' where user_id='" . $id . "'");
                        // $query1 = mysql_query($sql1);
                        $res     = json_encode(array(
                            'status' => 1,
                            'message' => 'Password change successfully.'
                        ));
                        print_r($res);
                        
                    }
                    
                    else {
                        echo json_encode(array(
                            'status' => 0,
                            'message' => 'Old password not exist.'
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'status' => 0,
                        'message' => 'Your detail is not complete.'
                    ));
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    ---------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/forgetpassword?email=sunil2.sbsgroup@gmail.com
    --------------------------------------------------------------------------------------------
    */
    
    function forgetpassword()
    {
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
        
        if ($email == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            
            if (isset($_REQUEST['email'])) {
                $email  = $_REQUEST['email'];
                $sql    = "SELECT `user_id` FROM tbl_user WHERE email='$email'";
                $query  = mysql_query($sql);
                $result = mysql_fetch_array($query);
                if ($result) {
                    $id           = $result["user_id"];
                    $randNum      = rand();
                    $tempPass     = $randNum;
                    $hashTempPass = md5($tempPass);
                    $sql          = mysql_query("UPDATE tbl_user SET password='" . $hashTempPass . "' where user_id='" . $id . "'");
                    $query        = mysql_query($sql);
                    
                    $to      = $email;
                    $from    = "no-reply@tap911.com";
                    $headers = "From: $from\n";
                    $headers .= "MIME-Version: 1.0\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1 \n";
                    $subject = "geechat - Forget Password";
                    $msg     = "Your Temporary Password is : $tempPass";
                    if (!mail($to, $subject, $msg, $headers)) {
                        echo json_encode(array(
                            'status' => 0,
                            'message' => 'Email not sent.'
                        ));
                    } else {
                        echo json_encode(array(
                            'status' => 1,
                            'message' => 'Email sent successfully.'
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'status' => 0,
                        'message' => 'This email is not exist.'
                    ));
                }
            }
        }
    }
    
    /*
    -----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/user_comment_alertwise?token=dd088bfaaaf468cb&comment_user_id=2&alert_id=2&comment_text=this%20is%20my%20first
    -----------------------------------------------------------------------------------------------------------
    */
    
    function user_comment_alertwise()
    {
        $comment_user_id = isset($_REQUEST['comment_user_id']) ? $_REQUEST['comment_user_id'] : "";
        $alert_id        = isset($_REQUEST['alert_id']) ? $_REQUEST['alert_id'] : "";
        $comment_text    = isset($_REQUEST['comment_text']) ? $_REQUEST['comment_text'] : "";
        $token           = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        if ($comment_text == "" or $alert_id == "" or $comment_text == "" or $token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->user_comment_alertwise($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    -----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/user_comment_communitywise?token=dd088bfaaaf468cb&comment_user_id=1&community_id=2&comment_text=this%20is%20good
    -----------------------------------------------------------------------------------------------------------
    */
    
    function user_comment_communitywise()
    {
        $comment_user_id = isset($_REQUEST['comment_user_id']) ? $_REQUEST['comment_user_id'] : "";
        $community_id    = isset($_REQUEST['community_id']) ? $_REQUEST['community_id'] : "";
        $comment_text    = isset($_REQUEST['comment_text']) ? $_REQUEST['comment_text'] : "";
        $token           = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        if ($comment_text == "" or $community_id == "" or $comment_text == "" or $token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->user_comment_communitywise($token);
                if ($response) {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'comment_communitywise' => $response
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                    
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    -------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_comment_communitywise?token=dd088bfaaaf468cb
    ------------------------------------------------------------------------------------------------------
    */
    
    function get_comment_communitywise()
    {
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $limit = $_REQUEST['limit'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->get_comment_communitywise($token, $limit);
                if ($response) {
                    $arr = array();
                    foreach ($response as $results) {
                        $arr[] = array(
                            'user_name' => $results->user_name,
                            'comment_id' => $results->comment_id,
                            'community_id' => $results->community_id,
                            'comment_user_id' => $results->comment_user_id,
                            'comment_text' => $results->comment_text,
                            'comment_date_time' => $results->comment_date_time,
                            'add_date' => $results->add_date,
                            'status' => $results->status
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'comment_community_wise' => $arr
                    );
                    $data         = json_encode($returnresult);
                    print_r($data);
                    
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record not found'
                    );
                    $data         = json_encode($returnresult);
                    print_r($data);
                }
                
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    --------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_comment_alertwise?token=dd088bfaaaf468cb
    --------------------------------------------------------------------------------------------------
    */
    
    function get_comment_alertwise()
    {
        $token    = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $alert_id = isset($_REQUEST['alert_id']) ? $_REQUEST['alert_id'] : "";
        if ($token == "" or $alert_id == '') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            // $tmp_alert_id = $_REQUEST['alert_id'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->get_comment_alertwise($token, $alert_id);
                if ($response) {
                    $arr = array();
                    foreach ($response as $results) {
                        $arr[] = array(
                            'user_name' => $results->user_name,
                            'comment_id' => $results->comment_id,
                            'alert_id' => $results->alert_id,
                            'comment_user_id' => $results->comment_user_id,
                            'comment_text' => $results->comment_text,
                            'comment_date_time' => $results->comment_date_time,
                            'add_date' => $results->add_date,
                            'status' => $results->status
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record fount',
                        'comment' => $arr
                    );
                    $data         = json_encode($returnresult);
                    print_r($data);
                } else {
                    $returnresult   = array(
                        'status' => 0,
                        'message' => 'Record not fount'
                    );
                    $responseresult = json_encode($returnresult);
                    print_r($responseresult);
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    ------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_alert_communitywise?token=dd088bfaaaf468cb
    ------------------------------------------------------------------------------------------------
    */
    
    function get_alert_communitywise()
    {
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->get_alert_communitywise($token);
                
                if ($response) {
                    
                    $arr = array();
                    foreach ($response as $results) {
                        $arr[] = array(
                            'alert_id' => $results->alert_id,
                            'user_id' => $results->user_id,
                            'alert_id' => $results->alert_id,
                            'alert_lat' => $results->alert_lat,
                            'alert_lang' => $results->alert_lang,
                            'alert_heading' => $results->alert_heading,
                            'alert_descrption' => $results->alert_descrption,
                            'community_logo' => $results->community_logo,
                            'is_comment' => $results->is_comment,
                            'alert_date_time' => $results->alert_date_time,
                            'add_date' => $results->add_date,
                            'status' => $results->status
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'alert_communitywise' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    -------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_community_emergency_contact?token=f70bfae97dc8c2d5
    -------------------------------------------------------------------------------------------------------
    */
    
    function get_community_emergency_contact()
    {
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            //$community_id = $_REQUEST['community_id'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                
                $json_data2 = $this->user_model->get_community_emergency_list();
                //$response = json_encode($response);
                
                
                $arr2 = array();
                
                foreach ($json_data2 as $results2) {
                    $community_id_my = $results2->community_id;
                    // echo $community_id_my;
                    
                    $arra1 = array();
                    
                    $json_data = $this->user_model->get_community_emergency_contact($community_id_my);
                    if ($json_data == '') {
                        $returnresult = array(
                            'status' => 0,
                            'message' => 'No record found'
                        );
                    }
                    // elseif($json_data){
                    //    $returnresult = array('status' => 1, 'message' => 'Record found');
                    // }
                    //print_r($json_data);
                    foreach ($json_data as $results) {
                        $arr1 = array(
                            'community_emergency_number_id' => $results->community_emergency_number_id,
                            
                            'community_emergency_number' => $results->community_emergency_number,
                            'community_emergency_number_type' => $results->community_emergency_number_type
                        );
                        
                        array_push($arra1, $arr1);
                    }
                    
                    
                    $arr2[] = array(
                        'community_name' => $results2->community_name,
                        'community_id' => $results2->community_id,
                        'community_description' => $results2->community_description,
                        'community_logo' => $results2->community_logo,
                        'community_website' => $results2->community_website,
                        'community_email' => $results2->community_email,
                        'community_address' => $results2->community_address,
                        'add_date' => $results2->add_date,
                        'numbers' => $arra1,
                        'status' => $results2->status
                        
                    );
                    
                    //array_push($arr1, $arr2)
                }
                
                // $result = array_merge($arr1, $arr2);
                $returnresult = array(
                    'status' => 1,
                    'message' => 'Record found',
                    'all_record' => $arr2
                );
                $returnresult = json_encode($returnresult);
                //  $returnresult2 = json_encode($arr2);
                // $result = array_merge($returnresult, $returnresult2);
                //  $data = json_encode($arr);
                print_r($returnresult);
            }
            
            else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    ----------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/notification_setting?token=f70bfae97dc8c2d5&user_id=45&notification_type=text
    -------------------------------------------------------------------------------------------
    */
    
    function notification_setting()
    {
        $token             = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $notification_type = isset($_REQUEST['notification_type']) ? $_REQUEST['notification_type'] : "";
        $user_id           = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        if ($token == "" or $notification_type == "" or $user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->notification_setting($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
/*
    ----------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/set_notification_tone?token=f70bfae97dc8c2d5&user_id=45&notification_tone=audio
    -------------------------------------------------------------------------------------------
    */
    
    function set_notification_tone()
    {
        $token             = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $notification_tone = isset($_REQUEST['notification_tone']) ? $_REQUEST['notification_tone'] : "";
        $user_id           = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        if ($token == ""  or $user_id == "" or $notification_tone=='') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->set_notification_tone($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }

      /*

       http://104.237.3.116/tap911/index.php/webservice/get_notification_setting?token=8ff636448bae3be3&user_id=45

     */

    function get_notification_setting()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        
        
        if ($token == "" or $user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            // $user_id = $_REQUEST['user_id'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_notification_setting($token, $user_id);
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'notification_id' => $results->notification_id,
                            'user_id' => $results->user_id,
                            'app' => $results->app,
                            'email' => $results->email,
                            'text' => $results->text,
                            'voice' => $results->voice,
                             'notification_tone' => $results->notification_tone
                            
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'notification' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    /*
    -----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/update_profile?token=dd088bfaaaf468cb&user_id=1&first_name=gorav&last_name=kathri&email=sunil6.sbsgroup@gmail.com&phone_number_text_msg_country_code=1234&phone_number_text_msg=1234567890&phone_number_voice_notification_country_code=1234&phone_number_voice_notification=1234567879&medical_history=abcd&medication_instraction=pqrs&allergies=sss&special_need=wwssw&user_lat=22.709399&user_long=75.875544&language=English
    -----------------------------------------------------------------------------------------------------------
    */
    
    function update_profile()
    {
        
        $token                                        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id                                      = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $first_name                                   = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
        $last_name                                    = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
        $email                                        = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
        $language                                     = isset($_REQUEST['language']) ? $_REQUEST['language'] : "";
        $medical_history                              = isset($_REQUEST['medical_history']) ? $_REQUEST['medical_history'] : "";
        $medication_instraction                       = isset($_REQUEST['medication_instraction']) ? $_REQUEST['medication_instraction'] : "";
        $allergies                                    = isset($_REQUEST['allergies']) ? $_REQUEST['allergies'] : "";
        $special_need                                 = isset($_REQUEST['special_need']) ? $_REQUEST['special_need'] : "";
        $user_lat                                     = isset($_REQUEST['special_need']) ? $_REQUEST['user_lat'] : "";
        $user_long                                    = isset($_REQUEST['user_long']) ? $_REQUEST['user_long'] : "";
        $phone_number_text_msg_country_code           = isset($_REQUEST['phone_number_text_msg_country_code']) ? $_REQUEST['phone_number_text_msg_country_code'] : "";
        $phone_number_text_msg                        = isset($_REQUEST['phone_number_text_msg']) ? $_REQUEST['phone_number_text_msg'] : "";
        $phone_number_voice_notification_country_code = isset($_REQUEST['phone_number_voice_notification_country_code']) ? $_REQUEST['phone_number_voice_notification_country_code'] : "";
        $phone_number_voice_notification              = isset($_REQUEST['phone_number_voice_notification']) ? $_REQUEST['phone_number_voice_notification'] : "";
        if ($first_name == "" or $last_name == "" or $user_name = "" or $email = "" or $phone_number_text_msg_country_code = "" or $phone_number_text_msg == "" or $phone_number_voice_notification_country_code == "" or $phone_number_voice_notification == "" or $user_id == "" or $medical_history == "" or $medication_instraction == "" or $allergies == "" or $special_need == "" or $user_lat == "" or $user_long == "" or $user_long == "" or $token == "" or $language == "") {
            die(json_encode(array(
                "status" => "false",
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->update_profile($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    function update_profile_picture()
    {
        //     $token = isset($_REQUEST['token']) ? $_REQUEST['token'] :"";
        //      $profile_pic = isset($_REQUEST['profile_pic']) ? $_REQUEST['profile_pic'] :"";
        //      $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :"";
        // if($token=="" or $profile_pic=="" or $user_id==''){
        // die(json_encode(array("status"=>0, "message"=> "Input parameters are not found")));
        
        // }
        //   else{
        $token = $_REQUEST['token'];
        $sql   = "SELECT * FROM tbl_user where token='$token'";
        $res   = $this->db->query($sql);
        $row   = $res->row();
        if ($row) {
            $response = $this->user_model->update_profile_picture($token);
            $response = json_encode($response);
            print_r($response);
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Token mismatch'
            );
            $response     = json_encode($returnresult);
            print_r($response);
        }
        // }
    }
    
    /*
    -----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/update_home_address?token=dd088bfaaaf468cb&user_id=1&home_address_line_1=pune&home_address_line_2=bhopal&city_id=1&state_id=1&zip=1234&country_id=1
    ---------------------------------------------------------------------------------------------------------
    */
    
    function update_home_address()
    {
        $token               = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $home_address_line_1 = isset($_REQUEST['home_address_line_1']) ? $_REQUEST['home_address_line_1'] : "";
        $user_id             = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $home_address_line_2 = isset($_REQUEST['home_address_line_2']) ? $_REQUEST['home_address_line_2'] : "";
        $city_id             = isset($_REQUEST['city_id']) ? $_REQUEST['city_id'] : "";
        $state_id            = isset($_REQUEST['state_id']) ? $_REQUEST['state_id'] : "";
        $zip                 = isset($_REQUEST['zip']) ? $_REQUEST['zip'] : "";
        $country_id          = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : "";
        if ($token == "" or $home_address_line_1 == "" or $user_id == "" or $home_address_line_2 == "" or $city_id == "" or $state_id == "" or $zip == "" or $country_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->update_home_address($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    ----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/add_user_emergency_contact?token=dd088bfaaaf468cb&user_id=1&name=devandra&description=anywhere%20contect%20me&phone_number=1234567&country_code=12345
    -----------------------------------------------------------------------------------------------------------
    */
    
    function add_user_emergency_contact()
    {
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $name         = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";
        $user_id      = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $description  = isset($_REQUEST['description']) ? $_REQUEST['description'] : "";
        $phone_number = isset($_REQUEST['phone_number']) ? $_REQUEST['phone_number'] : "";
        // $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] :"";
        $country_code = isset($_REQUEST['country_code']) ? $_REQUEST['country_code'] : "";
        if ($token == "" or $name == "" or $user_id == "" or $description == "" or $phone_number == "" or $country_code == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->add_user_emergency_contact($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    -----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/update_user_emergency_contact?token=dd088bfaaaf468cb&emergency_contact_id=1&name=govind&description=anywhere%20contect%20me&phone_number=1234567&country_code=12345
    -----------------------------------------------------------------------------------------------------------
    */
    
    function update_user_emergency_contact()
    {
        $token                = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $name                 = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";
        $emergency_contact_id = isset($_REQUEST['emergency_contact_id']) ? $_REQUEST['emergency_contact_id'] : "";
        // $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :"";
        $description          = isset($_REQUEST['description']) ? $_REQUEST['description'] : "";
        $phone_number         = isset($_REQUEST['phone_number']) ? $_REQUEST['phone_number'] : "";
        // $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] :"";
        $country_code         = isset($_REQUEST['country_code']) ? $_REQUEST['country_code'] : "";
        if ($token == "" or $name == "" or $description == "" or $phone_number == "" or $country_code == "" or $emergency_contact_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->update_user_emergency_contact($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    --------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_home_address?token=dd088bfaaaf468cb&user_id=1
    --------------------------------------------------------------------------------------------------
    */
    
    function get_home_address()
    {
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        
        
        if ($token == "" or $user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            // $user_id = $_REQUEST['user_id'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_home_address($token, $user_id);
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'address_id' => $results->address_id,
                            'user_id' => $results->user_id,
                            'home_address_line_1' => $results->home_address_line_1,
                            'home_address_line_2' => $results->home_address_line_2,
                            'zip' => $results->zip,
                            'country_name' => $results->country_name,
                            'state_name' => $results->state_name,
                            'city_name' => $results->city_name
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'user_home_address' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    --------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_emergency_contact?token=dd088bfaaaf468cb&user_id=1
    --------------------------------------------------------------------------------------------------------
    */
    
    function get_emergency_contact()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        
        
        if ($token == "" or $user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            
            $sql = "SELECT * FROM tbl_user where token='$token'";
            $res = $this->db->query($sql);
            $row = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_emergency_contact($token, $user_id);
                
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'emergency_contact_id' => $results->emergency_contact_id,
                            'user_id' => $results->user_id,
                            'name' => $results->name,
                            'description' => $results->description,
                            'phone_number' => $results->phone_number,
                            'country_code' => $results->country_code
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'emergency_contect' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    ------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_user_profiledata?token=dd088bfaaaf468cb&user_id=1
    -------------------------------------------------------------------------------------------------------
    */
    
    function get_user_profiledata()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        
        
        if ($token == "" or $user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_user_profiledata($token, $user_id);
                
                if ($json_data) {
                    
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'user_id' => $results->user_id,
                            'first_name' => $results->first_name,
                            'last_name' => $results->last_name,
                            'user_name' => $results->user_name,
                            'email' => $results->email,
                            'phone_number_text_msg_country_code' => $results->phone_number_text_msg_country_code,
                            'phone_number_text_msg' => $results->phone_number_text_msg,
                            'phone_number_voice_notification_country_code' => $results->phone_number_voice_notification_country_code,
                            'phone_number_voice_notification' => $results->phone_number_voice_notification,
                            'profile_pic' => $results->profile_pic,
                            'language' => $results->language,
                            'medical_history' => $results->medical_history,
                            'medication_instraction' => $results->medication_instraction,
                            'allergies' => $results->allergies,
                            'special_need' => $results->special_need,
                            'user_lat' => $results->user_lat,
                            'user_long' => $results->user_long,
                            'user_location_date_time' => $results->user_location_date_time
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'profile_data' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    -------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_country_emergency_number_with_token?token=dd088bfaaaf468cb
    -------------------------------------------------------------------------------------------------
    */
    
    function get_country_emergency_number_with_token()
    {
        
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_country_emergency_number_with_token($token);
                if ($json_data) {
                    
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'country_id' => $results->country_id,
                            'country_name' => $results->country_name,
                            'country_code' => $results->country_code,
                            'fire_number' => $results->fire_number,
                            'ambulance_number' => $results->ambulance_number,
                            'police_number' => $results->police_number
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'emergency_number' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    -------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_country_emergency_number
    -------------------------------------------------------------------------------
    */
    
    function get_country_emergency_number()
    {
        $json_data = $this->user_model->get_country_emergency_number();
        
        if ($json_data) {
            
            $arr = array();
            foreach ($json_data as $results) {
                $arr[] = array(
                    'country_id' => $results->country_id,
                    'country_name' => $results->country_name,
                    'country_code' => $results->country_code,
                    'fire_number' => $results->fire_number,
                    'ambulance_number' => $results->ambulance_number,
                    'police_number' => $results->police_number
                );
            }
            $returnresult = array(
                'status' => 1,
                'message' => 'Record found',
                'country_emergency_number' => $arr
            );
            $response     = json_encode($returnresult);
            print_r($response);
            
            
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Record  not found'
            );
            $response     = json_encode($returnresult);
            print_r($response);
        }
        
    }
    
    /*
    ----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/add_emergency_tracking?token=dd088bfaaaf468cb&user_id=1&address=bansi%20trade%20center&latitude=22.719569&longitude=75.857726
    -----------------------------------------------------------------------------------------------------------
    */
    
    function add_emergency_tracking()
    {
        
        $token     = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $address   = isset($_REQUEST['address']) ? $_REQUEST['address'] : "";
        $user_id   = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $latitude  = isset($_REQUEST['latitude']) ? $_REQUEST['latitude'] : "";
        $longitude = isset($_REQUEST['longitude']) ? $_REQUEST['longitude'] : "";
        if ($token == "" or $address == "" or $user_id == "" or $latitude == "" or $longitude == "" or $address == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->add_emergency_tracking($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
            
        }
    }
    
    /*
    ---------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_emergency_tracking?token=dd088bfaaaf468cb
    ---------------------------------------------------------------------------------------------------
    */
    
    function get_emergency_tracking()
    {
        
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_emergency_tracking($token);
                
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            
                            'user_id' => $results->user_id,
                            'address' => $results->address,
                            'add_date' => $results->add_date,
                            'longitude' => $results->longitude,
                            'latitude' => $results->latitude,
                            'add_date' => $results->add_date
                        );
                    }
                    
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'emergenct_tracking' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                } else {
                    
                    
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    -----------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_state?token=dd088bfaaaf468cb
    -----------------------------------------------------------------------------------------
    */
    
    function get_state()
    {
        
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_state($token);
                
                if ($json_data) {
                    
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'state_id' => $results->state_id,
                            'state_name' => $results->state_name,
                            'add_date' => $results->add_date,
                            'status' => $results->status
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'all_state' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                } else {
                    
                    
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record  not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    ---------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_city?token=dd088bfaaaf468c
    ---------------------------------------------------------------------------------
    */
    
    function get_city()
    {
        
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        
        if ($token == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_city($token);
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'city_id' => $results->city_id,
                            'city_name' => $results->city_name,
                            'add_date' => $results->add_date,
                            'status' => $results->status
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'all_city' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                else {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'all_city' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/delete_user?token=8bead3d5ec6c562c&user_id=47
    -----------------------------------------------------------------------------------------------------
    */
    function delete_user()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        if ($token == "" or $user_id == '') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->delete_user($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
   
    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/delete_emergency_contact?token=f0f2c2386c4316f3&emergency_contact_id=16
    -----------------------------------------------------------------------------------------------------
    */
    
    function delete_emergency_contact()
    {
        
        $token                = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $emergency_contact_id = isset($_REQUEST['emergency_contact_id']) ? $_REQUEST['emergency_contact_id'] : "";
        
        if ($token == "" or $emergency_contact_id == '') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->delete_emergency_contact($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }

     /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/add_geofence?token=03ed32f30ee37fbb&user_id=77&geo_lat=22.719569&geo_long=75.857726&radius=1.33356&geofence_name=abc&in_alert=1&out_alert=1&address=indore%20ab%20road&geo_type=qasd
    -----------------------------------------------------------------------------------------------------
    */
    function add_geofence()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $geo_lat = isset($_REQUEST['geo_lat']) ? $_REQUEST['geo_lat'] : "";
        $geo_long = isset($_REQUEST['geo_long']) ? $_REQUEST['geo_long'] : "";
        $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : "";
        $geofence_name = isset($_REQUEST['geofence_name']) ? $_REQUEST['geofence_name'] : "";
        $in_alert = isset($_REQUEST['in_alert']) ? $_REQUEST['in_alert'] : "";
        $out_alert = isset($_REQUEST['out_alert']) ? $_REQUEST['out_alert'] : "";
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : "";
         $geo_type = isset($_REQUEST['geo_type']) ? $_REQUEST['geo_type'] : "";

        
        if ($token == "" or $user_id == '' or $geo_lat=="" or $geo_long ==""  or $geofence_name=="" or $in_alert=="" or $out_alert=="" or $address==""  or $geo_type=='') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->add_geofence($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }

/*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/list_geofence?token=03ed32f30ee37fbb&user_id=77
    -----------------------------------------------------------------------------------------------------
    */

    function list_geofence()
    {
        
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        if ($token == "" or $user_id=='') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->list_geofence($token);
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'geo_fence_id' => $results->geo_fence_id,
                            'user_id' => $results->user_id,
                            'geo_lat' => $results->geo_lat,
                            'geo_long' => $results->geo_long,
                            'radius' => $results->radius,
                            'geofence_name' => $results->geofence_name,
                             'in_alert' => $results->in_alert,
                             'out_alert' => $results->out_alert,
                             'address' => $results->address,
                             'geo_type' => $results->geo_type,
                              'zone_address' => $results->zone_address,
                              'distance' => $results->distance,
                              'add_date' => $results->add_date
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'geofence_list' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                else {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'all_city' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    -----------------------------------------------------------------------------------------------------
     http://104.237.3.116/tap911/index.php/webservice/update_geofence?token=03ed32f30ee37fbb&geo_fence_id=1&user_id=77&geo_type=pqr&geo_lat=22.719569&geo_long=75.857726&radius=1.33356&geofence_name=abc&in_alert=1&out_alert=1&address=indore%20ab%20road
    -----------------------------------------------------------------------------------------------------
    */

 function update_geofence()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $geo_lat = isset($_REQUEST['geo_lat']) ? $_REQUEST['geo_lat'] : "";
        $geo_long = isset($_REQUEST['geo_long']) ? $_REQUEST['geo_long'] : "";
        $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : "";
        $geofence_name = isset($_REQUEST['geofence_name']) ? $_REQUEST['geofence_name'] : "";
        $in_alert = isset($_REQUEST['in_alert']) ? $_REQUEST['in_alert'] : "";
        $out_alert = isset($_REQUEST['out_alert']) ? $_REQUEST['out_alert'] : "";
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : "";
        $geo_type = isset($_REQUEST['geo_type']) ? $_REQUEST['geo_type'] : "";
        $geo_fence_id = isset($_REQUEST['geo_fence_id']) ? $_REQUEST['geo_fence_id'] : "";
        

        
        if ($token == "" or $user_id == '' or $geo_lat=="" or $geo_long ==""  or $geofence_name=="" or $in_alert=="" or $out_alert=="" or $address=="" or $geo_type=='' or $geo_fence_id=='') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->update_geofence($token,$geo_fence_id);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }

    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/delete_geofence?token=f0f2c2386c4316f3&geo_fence_id=2
    -----------------------------------------------------------------------------------------------------
    */
    
    function delete_geofence()
    {
        
        $token                = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $geo_fence_id = isset($_REQUEST['geo_fence_id']) ? $_REQUEST['geo_fence_id'] : "";
        
        if ($token == "" or $geo_fence_id == '') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->delete_geofence($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }


/*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/add_emergency_user?token=03ed32f30ee37fbb&user_id=77&geo_lat=22.719569&geo_long=75.857726&radius=1.33356&geofence_name=abc&in_alert=1&out_alert=1&address=indore%20ab%20road&geo_type=qasd
    -----------------------------------------------------------------------------------------------------
    */
    function add_emergency_user()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $user_lat = isset($_REQUEST['user_lat']) ? $_REQUEST['user_lat'] : "";
        $user_long = isset($_REQUEST['user_long']) ? $_REQUEST['user_long'] : "";
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : "";
        $emergency_type = isset($_REQUEST['emergency_type']) ? $_REQUEST['emergency_type'] : "";

        
        if ($token == "" or $user_id == '' or $user_lat=="" or $user_long ==""  or $address=="" or $emergency_type=="") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->add_emergency_user($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }


    /*
    -----------------------------------------------------------------------------------------
   http://104.237.3.116/tap911/index.php/webservice/get_distance_user?token=be53d02c8766599f&latitude=21.2125123&longitude=72.8304817&distance=5
    -----------------------------------------------------------------------------------------
    */
    
    function get_distance_user()
    {
           $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
           $latitude = isset($_REQUEST['latitude']) ? $_REQUEST['latitude'] : "";
           $longitude = isset($_REQUEST['longitude']) ? $_REQUEST['longitude'] : "";
            $distance = isset($_REQUEST['distance']) ? $_REQUEST['distance'] : "";
        
        
        
        if ($token == "" or $latitude=='' or $longitude=='' or $distance=='') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_distance_user($token); //user_id
               if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'emergency_tracking_id' => $results->emergency_tracking_id,
                            'user_id' => $results->user_id,
                            'address' => $results->address,
                            'first_name' => $results->first_name,
                            'last_name' => $results->last_name,
                            'user_name' => $results->user_name,
                             'phone_number_text_msg' => $results->phone_number_text_msg,
                              'add_date' => $results->add_date
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'user_list' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                else {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record  not found',
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }

/*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/user_emergency_request?token=03ed32f30ee37fbb&user_id=77&emergency_tracking_id=1&user_lat=75.857726&user_long=11.33356&address=Smc%20Tenement,%20Ward%20No.7,%20Vasta%20Devdi%20Rd,%20Gotalawadi,%20Tunki,%20Katargam,%20Surat,%20Gujarat%20395004,%20IndiaSuratGujaratIndia395004Smc%20Tenement&usertoken=f2bEV13XwtA:APA91bGmtUMGNXeAW48RG_o2yHxOrQiGZV6jIr4dI-inmQhpJf6LkJg9_5x9V_y-_7T5c0idOCScjV5LhtuzBPqpvPTqb6xfhKhUOYq6npPRI82mkiaNnrE5skJB8tDCieWtsI1y5tC0&type=ios&title=abc&body=test
    -----------------------------------------------------------------------------------------------------
    */
    function user_emergency_request()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $emergency_tracking_id = isset($_REQUEST['emergency_tracking_id']) ? $_REQUEST['emergency_tracking_id'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $user_lat = isset($_REQUEST['user_lat']) ? $_REQUEST['user_lat'] : "";
        $user_long = isset($_REQUEST['user_long']) ? $_REQUEST['user_long'] : "";
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : "";
         $usertoken = isset($_REQUEST['usertoken']) ? $_REQUEST['usertoken'] : "";
         $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
         $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : "";
         $body = isset($_REQUEST['body']) ? $_REQUEST['body'] : "";
      
        
        if ($token == "" or $user_id == '' or $user_lat=="" or $user_long ==""  or $address=="" or $emergency_tracking_id=="" or $usertoken=='' or $type=='' or  $title=='' or $body=='') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT * FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $json_data = $this->user_model->user_emergency_request($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Token mismatch'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */