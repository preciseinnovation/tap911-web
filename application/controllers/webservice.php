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
        $login                     = isset($_REQUEST['login']) ? $_REQUEST['login'] : "";
        $password                  = isset($_REQUEST['password']) ? $_REQUEST['password'] : "";
        $notification_device_token = isset($_REQUEST['notification_device_token']) ? $_REQUEST['notification_device_token'] : "";
        $mobile_type               = isset($_REQUEST['mobile_type']) ? $_REQUEST['mobile_type'] : "";
        
        
        if ($login == "" or $password == "" or $notification_device_token == '' or $mobile_type == "") {
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
    ------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/facebook_login?login=sbsgroup@gmail.com&notification_device_token=123456&mobile_type=android&facebook_id&first_name=abc&last_name=assd
    -----------------------------------------------------------------------------------------------------
    */
    function facebook_login()
    {
        $login                     = isset($_REQUEST['login']) ? $_REQUEST['login'] : "";
        $notification_device_token = isset($_REQUEST['notification_device_token']) ? $_REQUEST['notification_device_token'] : "";
        $mobile_type               = isset($_REQUEST['mobile_type']) ? $_REQUEST['mobile_type'] : "";
        $first_name                = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
        $last_name                 = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
        $facebook_id               = isset($_REQUEST['facebook_id']) ? $_REQUEST['facebook_id'] : "";
        
        
        if ($login == "" or $facebook_id == "" or $notification_device_token == '' or $mobile_type == "" or $last_name == "" or $last_name == "" or $facebook_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            
            $login  = $_REQUEST['login'];
            $result = $this->user_model->facebook_login($login);
            $result = json_encode($result);
            print_r($result);
        }
    }
    
    /*
    ------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/google_login?login=sbsgroup@gmail.com&notification_device_token=123456&mobile_type=android&google_id=2&first_name=abc&last_name=assd
    -----------------------------------------------------------------------------------------------------
    */
    function google_login()
    {
        $login                     = isset($_REQUEST['login']) ? $_REQUEST['login'] : "";
        $notification_device_token = isset($_REQUEST['notification_device_token']) ? $_REQUEST['notification_device_token'] : "";
        $mobile_type               = isset($_REQUEST['mobile_type']) ? $_REQUEST['mobile_type'] : "";
        $first_name                = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
        $last_name                 = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
        $google_id                 = isset($_REQUEST['google_id']) ? $_REQUEST['google_id'] : "";
        
        
        if ($login == "" or $google_id == "" or $notification_device_token == '' or $mobile_type == "" or $last_name == "" or $last_name == "" or $google_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            
            $login  = $_REQUEST['login'];
            $result = $this->user_model->google_login($login);
            $result = json_encode($result);
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
        
        $first_name                = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
        $last_name                 = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
        $user_name                 = isset($_REQUEST['user_name']) ? $_REQUEST['user_name'] : "";
        $email                     = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
        $user_type_id              = isset($_REQUEST['user_type_id']) ? $_REQUEST['user_type_id'] : "";
        $country_id                = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : "";
        $phone_number              = isset($_REQUEST['phone_number']) ? $_REQUEST['phone_number'] : "";
        // $phone_number_voice_notification_country_code = isset($_REQUEST['phone_number_voice_notification_country_code']) ? $_REQUEST['phone_number_voice_notification_country_code'] : "";
        // $phone_number_voice_notification              = isset($_REQUEST['phone_number_voice_notification']) ? $_REQUEST['phone_number_voice_notification'] : "";
        $password                  = isset($_REQUEST['password']) ? $_REQUEST['password'] : "";
        $notification_device_token = isset($_REQUEST['notification_device_token']) ? $_REQUEST['notification_device_token'] : "";
        $mobile_type               = isset($_REQUEST['mobile_type']) ? $_REQUEST['mobile_type'] : "";
        // $profile_pic = isset($_REQUEST['profile_pic']) ? $_REQUEST['profile_pic'] :"";
        
        if ($first_name == "" or $last_name == "" or $user_name = "" or $email = "" or $country_id = "" or $phone_number == "" or $password == "" or $notification_device_token == "" or $mobile_type = "" or $user_type_id == "") {
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                 $total_page = $this->user_model->get_page_number_community();
                  $json_data = $this->user_model->get_community($token); //user_id
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $logo = $results->community_logo;
                        $path = base_url() . 'uploads/';
                        if ($logo) {
                            
                            $logos = $path . $logo;
                            
                        } else {
                            $logos = $path . '1517561100258.png';
                        }
                        
                        $arr[] = array(
                            
                            'community_name' => $results->community_name,
                            'community_id' => $results->community_id,
                            'community_description' => $results->community_description,
                            'add_date' => $results->add_date,
                            'community_email' => $results->community_email,
                            'request_status' => $results->request_status,
                            'community_logo' => $logos,
                            'community_address' => $results->community_address
                            
                        );
                    }
                    
                    $returnresult = array(
                        'status' => 1,
                        'total_page'=>$total_page,
                        'message' => 'Record found',
                        'community_list' => $arr
                    );
                    $response = json_encode($returnresult);
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
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $response = $this->user_model->user_community_request($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
    
    // function get_user_message()
    // {
    
    //     $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    //     $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
    //     if ($token == "" or $user_id == '') {
    //         die(json_encode(array(
    //             "status" => 0,
    //             "message" => "Input parameters are not found"
    //         )));
    
    //     } else {
    //         $token = $_REQUEST['token'];
    //         $sql   = "SELECT token FROM tbl_user where token='$token'";
    //         $res   = $this->db->query($sql);
    //         $row   = $res->row();
    //         if ($row) {
    //             $response = $this->user_model->get_user_message($token);
    //             if ($response) {
    
    //                 $returnresult = array(
    //                     'status' => 1,
    //                     'message' => 'Record found',
    //                     'user_message' => $response
    //                 );
    //                 $response     = json_encode($returnresult);
    //                 print_r($response);
    
    
    //             } else {
    
    //                 $returnresult = array(
    //                     'status' => 0,
    //                     'message' => 'Record  not found'
    //                 );
    //                 $response     = json_encode($returnresult);
    //                 print_r($response);
    //             }
    
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Authentication failed'
    //             );
    //             $response     = json_encode($returnresult);
    //             print_r($response);
    //         }
    //     }
    // }
    
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
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token       = $_REQUEST['token'];
            $oldpassword = $_REQUEST['oldpassword'];
            $user_id     = $_REQUEST['user_id'];
            $newpassword = $_REQUEST['newpassword'];
            $newPass     = md5($newpassword);
            $token       = $_REQUEST['token'];
            $oldpassword = md5($oldpassword);
            $sql         = "SELECT * FROM tbl_user WHERE user_id='" . $user_id . "'";
            $res         = $this->db->query($sql);
            $row         = $res->row();
            $user_ids    = $row->user_id;
            $tokens      = $row->token;
            $password    = $row->password;
            if ($password != $oldpassword) {
                $returnresult = die(json_encode(array(
                    'status' => 0,
                    'message' => 'Old password doesnt match!'
                )));
                
            } elseif ($tokens != $token) {
                $returnresult = die(json_encode(array(
                    'status' => 0,
                    'message' => 'Authentication failed!'
                )));
                
            }
            if ($oldpassword == $newPass) {
                $returnresult = die(json_encode(array(
                    'status' => 0,
                    'message' => 'Old Password and new password cannot be same!'
                )));
                
            } else {
                
                $sql1 = mysql_query("UPDATE tbl_user SET password='" . $newPass . "' where user_id='" . $user_ids . "'");
                
                $res = die(json_encode(array(
                    'status' => 1,
                    'message' => 'Your password has been changed.'
                )));
                
                
            }
            $response = json_encode($returnresult);
            print_r($response);
            
            
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
    
    // function user_comment_alertwise()
    // {
    //     $comment_user_id = isset($_REQUEST['comment_user_id']) ? $_REQUEST['comment_user_id'] : "";
    //     $alert_id        = isset($_REQUEST['alert_id']) ? $_REQUEST['alert_id'] : "";
    //     $comment_text    = isset($_REQUEST['comment_text']) ? $_REQUEST['comment_text'] : "";
    //     $token           = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    
    //     if ($comment_text == "" or $alert_id == "" or $comment_text == "" or $token == "") {
    //         die(json_encode(array(
    //             "status" => 0,
    //             "message" => "Input parameters are not found"
    //         )));
    
    //     } else {
    
    //         $token = $_REQUEST['token'];
    //          $comment_user_id = $_REQUEST['comment_user_id'];
    //         $sql   = "SELECT token FROM tbl_user where token='$token' and user_id='$comment_user_id'";
    //         $res   = $this->db->query($sql);
    //         $row   = $res->row();
    //         if ($row) {
    //             $response = $this->user_model->user_comment_alertwise($token);
    //             $response = json_encode($response);
    //             print_r($response);
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Authentication failed'
    //             );
    //             $response     = json_encode($returnresult);
    //             print_r($response);
    //         }
    //     }
    // }
    
    /*
    -----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/user_comment_communitywise?token=dd088bfaaaf468cb&comment_user_id=1&community_id=2&comment_text=this%20is%20good
    -----------------------------------------------------------------------------------------------------------
    */
    
    // function user_comment_communitywise()
    // {
    //     $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
    //     $community_id    = isset($_REQUEST['community_id']) ? $_REQUEST['community_id'] : "";
    //     $comment_text    = isset($_REQUEST['comment_text']) ? $_REQUEST['comment_text'] : "";
    //     $token           = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    //     $comment_user_id = isset($_REQUEST['comment_user_id']) ? $_REQUEST['comment_user_id'] : "";
    
    //     if ($comment_text == "" or $community_id == "" or $comment_text == "" or $token == "" or $user_id=="" ) {
    //         die(json_encode(array(
    //             "status" => 0,
    //             "message" => "Input parameters are not found"
    //         )));
    
    //     } else {
    
    //         $token = $_REQUEST['token'];
    //         $user_id = $_REQUEST['user_id'];
    //         $sql   = "SELECT token FROM tbl_user where token='$token' and user_id='$user_id'";
    //         $res   = $this->db->query($sql);
    //         $row   = $res->row();
    //         if ($row) {
    //             $response = $this->user_model->user_comment_communitywise($token);
    
    //               $response     = json_encode($response);
    //             print_r($response);
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Authentication failed'
    //             );
    //             $response     = json_encode($returnresult);
    //             print_r($response);
    //         }
    //     }
    // }
    
    /*
    -------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_comment_communitywise?token=dd088bfaaaf468cb
    ------------------------------------------------------------------------------------------------------
    */
    
    // function get_comment_communitywise()
    // {
    //     $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    //      $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
    //       $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : "";
    //     if ($token == "") {
    //         die(json_encode(array(
    //             "status" => 0,
    //             "message" => "Input parameters are not found"
    //         )));
    
    //     } else {
    //         $token = $_REQUEST['token'];
    //         $user_id = $_REQUEST['user_id'];
    //         $limit = $_REQUEST['limit'];
    //         $sql   = "SELECT token FROM tbl_user where token='$token' and user_id=$user_id";
    //         $res   = $this->db->query($sql);
    //         $row   = $res->row();
    //         if ($row) {
    //             $response = $this->user_model->get_comment_communitywise($token, $limit);
    //             if ($response) {
    //                 $arr = array();
    //                 foreach ($response as $results) {
    //                     $arr[] = array(
    //                         'user_name' => $results->first_name." ".$results->last_name,
    //                         'comment_id' => $results->comment_id,
    //                         'community_id' => $results->community_id,
    //                         'comment_user_id' => $results->comment_user_id,
    //                         'comment_text' => $results->comment_text,
    //                         'comment_date_time' => $results->comment_date_time,
    //                         'add_date' => $results->add_date
    //                         // 'status' => $results->status
    
    //                     );
    //                 }
    //                 $returnresult = array(
    //                     'status' => 1,
    //                     'message' => 'Record found',
    //                     'comment_community_wise' => $arr
    //                 );
    //                 $data         = json_encode($returnresult);
    //                 print_r($data);
    
    
    //             } else {
    //                 $returnresult = array(
    //                     'status' => 0,
    //                     'message' => 'Record not found'
    //                 );
    //                 $data         = json_encode($returnresult);
    //                 print_r($data);
    //             }
    
    
    
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Authentication failed'
    //             );
    //             $response     = json_encode($returnresult);
    //             print_r($response);
    //         }
    //     }
    // }
    
    /*
    --------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_comment_alertwise?token=dd088bfaaaf468cb
    --------------------------------------------------------------------------------------------------
    */
    
    // function get_comment_alertwise()
    // {
    //     $token    = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    //     $alert_id = isset($_REQUEST['alert_id']) ? $_REQUEST['alert_id'] : "";
    //     if ($token == "" or $alert_id == '') {
    //         die(json_encode(array(
    //             "status" => 0,
    //             "message" => "Input parameters are not found"
    //         )));
    
    //     } else {
    //         $token = $_REQUEST['token'];
    //         $user_id = $_REQUEST['user_id'];
    //         $sql   = "SELECT token FROM tbl_user where token='$token' and user_id=$user_id";
    //         $res   = $this->db->query($sql);
    //         $row   = $res->row();
    //         if ($row) {
    //             $response = $this->user_model->get_comment_alertwise($token, $alert_id);
    //             if ($response) {
    //                 $arr = array();
    //                 foreach ($response as $results) {
    
    //                     $arr[] = array(
    //                         'user_name' => $results->first_name." ".$results->last_name,
    //                         'comment_id' => $results->comment_id,
    //                         'comment_user_id' => $results->comment_user_id,
    //                         'comment_text' => $results->comment_text,
    //                         'comment_date_time' => $results->comment_date_time,
    //                         'add_date' => $results->add_date
    
    
    //                     );
    //                 }
    //                 $returnresult = array(
    //                     'status' => 1,
    //                     'message' => 'Record found',
    //                     'comment' => $arr
    //                 );
    //                 $data         = json_encode($returnresult);
    //                 print_r($data);
    //             } else {
    //                 $returnresult   = array(
    //                     'status' => 0,
    //                     'message' => 'Record not found'
    //                 );
    //                 $responseresult = json_encode($returnresult);
    //                 print_r($responseresult);
    //             }
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Authentication failed'
    //             );
    //             $response     = json_encode($returnresult);
    //             print_r($response);
    //         }
    //     }
    // }
    
    /*
    ------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_alert_communitywise?token=dd088bfaaaf468cb
    ------------------------------------------------------------------------------------------------
    */
    
    // function get_alert_communitywise()
    // {
    //     $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    //     if ($token == "") {
    //         die(json_encode(array(
    //             "status" => 0,
    //             "message" => "Input parameters are not found"
    //         )));
    
    //     } else {
    //         $token = $_REQUEST['token'];
    //          $user_id = $_REQUEST['user_id'];
    //         $sql   = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id ";
    //         $res   = $this->db->query($sql);
    //         $row   = $res->row();
    //         if ($row) {
    //             $response = $this->user_model->get_alert_communitywise($token);
    
    //             if ($response) {
    
    //                 $arr = array();
    //                 foreach ($response as $results) {
    //                     $logo=$results->community_logo;
    //                       $path = base_url().'uploads/';
    //                       if($logo){
    
    //                         $logos= $path.$logo;
    
    //                      }
    //                      else{
    //                      $logos= $path.'1517561100258.png';
    //                      }
    //                     $arr[] = array(
    //                         'alert_id' => $results->alert_id,
    //                         'user_id' => $results->user_id,
    //                        // 'alert_id' => $results->alert_id,
    //                         'alert_lat' => $results->alert_lat,
    //                         'alert_lang' => $results->alert_lang,
    //                         'alert_heading' => $results->alert_heading,
    //                         'alert_descrption' => $results->alert_descrption,
    //                         'community_logo' => $logos,
    //                         'is_comment' => $results->is_comment,
    //                         'alert_date_time' => $results->alert_date_time,
    //                         'add_date' => $results->add_date
    //                         // 'status' => $results->status
    
    //                     );
    //                 }
    //                 $returnresult = array(
    //                     'status' => 1,
    //                     'message' => 'Record found',
    //                     'alert_communitywise' => $arr
    //                 );
    //                 $response     = json_encode($returnresult);
    //                 print_r($response);
    
    
    //             } else {
    //                 $returnresult = array(
    //                     'status' => 0,
    //                     'message' => 'Record not found'
    //                 );
    //                 $response     = json_encode($returnresult);
    //                 print_r($response);
    //             }
    
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Authentication failed'
    //             );
    //             $response     = json_encode($returnresult);
    //             print_r($response);
    //         }
    //     }
    // }
    
    
    
    /*
    ------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_user_alert?token=c53afe04a17ef62b&user_id=101&alert_type=user
    ------------------------------------------------------------------------------------------------
    */
    
    // function get_user_alert()
    // {
    //     $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
    //      $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
    //     // $alert_type = isset($_REQUEST['alert_type']) ? $_REQUEST['alert_type'] : "";
    //       $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : "";
    //     if ($token == "" or  $user_id=="") {
    //         die(json_encode(array(
    //             "status" => 0,
    //             "message" => "Input parameters are not found"
    //         )));
    
    //     } else {
    //          $user_id = $_REQUEST['user_id'];
    //         $token = $_REQUEST['token'];
    //          $sql   = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id ";
    //         $res   = $this->db->query($sql);
    //         $row   = $res->row();
    //         if ($row) {
    //             $response = $this->user_model->get_user_alert($token,$limit);
    
    //             if ($response) {
    
    //                 $arr = array();
    //                 foreach ($response as $results) {
    //                     if (is_null($results->community_id)) {
    //                        $results->community_id = "";
    
    //                          }
    
    //                          if (is_null($results->add_date)) {
    //                        $results->add_date = "";
    
    //                          }
    
    //                      $logo=$results->community_logo;
    //                       $path = base_url().'uploads/';
    //                       if($logo){
    
    //                         $logos= $path.$logo;
    
    //                      }
    //                      else{
    //                      $logos= $path.'1517561100258.png';
    //                      }
    
    //                     $profile_pic=$results->profile_pic;
    //                       $path = base_url().'uploads/';
    //                       if($profile_pic){
    
    //                         $profile_picture= $path.$profile_pic;
    
    //                      }
    //                      else{
    //                      $profile_picture= $path.'1517561100258.png';
    //                      }
    
    
    
    
    //                     $arr[] = array(
    //                         'alert_id' => $results->alert_id,
    //                         'community_id' => $results->community_id,
    //                         'user_id' => $results->user_id,
    //                         'alert_type' => $results->alert_type,
    //                         'tracking_user_id' => $results->tracking_user_id,
    //                         'alert_lat' => $results->alert_lat,
    //                         'alert_lang' => $results->alert_lang,
    //                          'alert_address' => $results->alert_address,
    //                         'request_status' => $results->request_status,
    //                         'add_date' => $results->add_date,
    //                         'accept_time' => $results->accept_time,
    //                         'community_logo' =>$logos,
    //                         'alert_heading' => $results->alert_heading,
    //                         'alert_descrption' => $results->alert_descrption,
    //                         'is_comment' => $results->is_comment,
    //                         'alert_date_time' => $results->alert_date_time,
    //                         'add_date' => $results->add_date,
    //                         'user_name' => $results->first_name." ".$results->last_name,
    //                         'profile_pic' => $profile_picture,
    //                         'user_message' => 'i need help'
    
    
    //                     );
    //                 }
    //                 $returnresult = array(
    //                     'status' => 1,
    //                     'message' => 'Record found',
    //                     'user_alert_list' => $arr
    //                 );
    //                 $response     = json_encode($returnresult);
    //                 print_r($response);
    
    
    //             } else {
    //                 $returnresult = array(
    //                     'status' => 0,
    //                     'message' => 'Record  not found'
    //                 );
    //                 $response     = json_encode($returnresult);
    //                 print_r($response);
    //             }
    
    //         } else {
    //             $returnresult = array(
    //                 'status' => 0,
    //                 'message' => 'Authentication failed'
    //             );
    //             $response     = json_encode($returnresult);
    //             print_r($response);
    //         }
    //     }
    // }
    
    
    
    
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                 
                
                $results        = $this->db->query("SELECT community_id from tbl_community_user_mapping where user_id=$user_id and request_status =3 and status=1");
                $resultdata     = $results->result_array();
                $countvarresult = count($resultdata);
                
                $arr2  = array();
                $arra1 = array();
                for ($i = 0; $i < $countvarresult; $i++) {
                    
                    $id                    = $resultdata[$i]['community_id'];
                    $sql                   = "SELECT * FROM tbl_community WHERE `community_id` IN ('$id')";
                    $res                   = $this->db->query($sql);
                    $rows                  = $res->row();
                    $community_id_my       = $rows->community_id;
                    $community_name        = $rows->community_name;
                    $community_description = $rows->community_description;
                    $community_website     = $rows->community_website;
                    $community_email       = $rows->community_email;
                    $community_address     = $rows->community_address;
                    $add_date              = $rows->add_date;
                    
                    $arr1 = array();
                    $total_page = $this->user_model->get_page_number_community_contact($id);
                
                    $json_data = $this->user_model->get_community_emergency_contact($id);
                    if ($json_data == '') {
                        $returnresult = array(
                            'status' => 0,
                            'message' => 'No record found'
                        );
                    }
                    foreach ($json_data as $results) {
                        $arr1[] = array(
                            'community_emergency_number_id' => $results->community_emergency_number_id,
                            // 
                            'community_emergency_number' => $results->community_emergency_number,
                            'community_emergency_number_type' => $results->community_emergency_number_type
                        );
                        
                        array_push($arra1, $arr1);
                    }
                    $logo = $results2->community_logo;
                    $path = base_url() . 'uploads/';
                    if ($logo) {
                        
                        $logos = $path . $logo;
                        
                    } else {
                        $logos = $path . '1517561100258.png';
                    }
                    
                    $arr2[] = array(
                        'community_name' => $community_name,
                        'community_id' => $community_id_my,
                        'community_description' => $community_description,
                        'community_logo' => $logos,
                        'community_website' => $community_website,
                        'community_email' => $community_email,
                        'community_address' => $community_address,
                        'add_date' => $add_date,
                        'number' => $arr1
                        
                        
                    );
                    
                    
                }
                
                
                $returnresult = array(
                    'status' => 1,
                    'total_page'=>$total_page,
                    'message' => 'Record found',
                    'all_record' => $arr2
                );
                $returnresult = json_encode($returnresult);
                print_r($returnresult);
            }
            
            else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $sql   = "SELECT token,user_id FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->notification_setting($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
        if ($token == "" or $user_id == "" or $notification_tone == '') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT token,user_id FROM tbl_user where token='$token'";
            $res   = $this->db->query($sql);
            $row   = $res->row();
            if ($row) {
                $response = $this->user_model->set_notification_tone($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $sql   = "SELECT token,user_id FROM tbl_user where token='$token'";
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
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
        
        $token                  = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id                = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $first_name             = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "";
        $last_name              = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "";
        $email                  = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
        $language               = isset($_REQUEST['language']) ? $_REQUEST['language'] : "";
        $medical_history        = isset($_REQUEST['medical_history']) ? $_REQUEST['medical_history'] : "";
        $medication_instraction = isset($_REQUEST['medication_instraction']) ? $_REQUEST['medication_instraction'] : "";
        $allergies              = isset($_REQUEST['allergies']) ? $_REQUEST['allergies'] : "";
        $special_need           = isset($_REQUEST['special_need']) ? $_REQUEST['special_need'] : "";
        // $user_lat                                     = isset($_REQUEST['user_lat']) ? $_REQUEST['user_lat'] : "";
        // $user_long                                    = isset($_REQUEST['user_long']) ? $_REQUEST['user_long'] : "";
        // $phone_number_text_msg_country_code           = isset($_REQUEST['phone_number_text_msg_country_code']) ? $_REQUEST['phone_number_text_msg_country_code'] : "";
        $phone_number           = isset($_REQUEST['phone_number']) ? $_REQUEST['phone_number'] : "";
        // $phone_number_voice_notification_country_code = isset($_REQUEST['phone_number_voice_notification_country_code']) ? $_REQUEST['phone_number_voice_notification_country_code'] : "";
        // $phone_number_voice_notification              = isset($_REQUEST['phone_number_voice_notification']) ? $_REQUEST['phone_number_voice_notification'] : "";
        if ($first_name == "" or $last_name == ""  or $email = "" or $phone_number == "" or $user_id == "" or $medical_history == "" or $medication_instraction == "" or $allergies == "" or $special_need == "" or $token == "" or $language == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $response = $this->user_model->update_profile($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    function update_profile_picture()
    {
        //      $token = isset($_REQUEST['token']) ? $_REQUEST['token'] :"";
        //       $profile_pic = isset($_REQUEST['profile_pic']) ? $_REQUEST['profile_pic'] :"";
        //       $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :"";
        //  if($token=="" or $profile_pic=="" or $user_id==''){
        //   $returnresult = die(json_encode(array("status"=>0,
        //     "message"=> "Input parameters are not found"
        // )));
        
        //  }
        // else{
        $token   = $_REQUEST['token'];
        $user_id = $_REQUEST['user_id'];
        $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
        $res     = $this->db->query($sql);
        $row     = $res->row();
        if ($row) {
            $response = $this->user_model->update_profile_picture($token);
            $response = json_encode($response);
            print_r($response);
        } else {
            $returnresult = array(
                'status' => 0,
                'message' => 'Authentication failed'
            );
            $response     = json_encode($returnresult);
            print_r($response);
        }
        
        // }
        //}
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $response = $this->user_model->update_home_address($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    /*
    ----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/add_user_emergency_contact?token=2386f8654def0a2b&user_id=1&emergency_user_help_id=77,94&tap911_user=1
    -----------------------------------------------------------------------------------------------------------
    */
    
    function add_user_emergency_contact()
    {
        $token                  = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        //        $name         = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";
        $user_id                = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $emergency_user_help_id = isset($_REQUEST['emergency_user_help_id']) ? $_REQUEST['emergency_user_help_id'] : "";
        //        $phone_number = isset($_REQUEST['phone_number']) ? $_REQUEST['phone_number'] : "";
        $tap911_user            = isset($_REQUEST['tap911_user']) ? $_REQUEST['tap911_user'] : "";
        //        $country_code = isset($_REQUEST['country_code']) ? $_REQUEST['country_code'] : "";
        if ($token == "" or $user_id == "" or $tap911_user == "" or $emergency_user_help_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token = $_REQUEST['token'];
            $sql   = "SELECT token,user_id FROM tbl_user where token='$token'";
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
        $tap911_user          = isset($_REQUEST['tap911_user']) ? $_REQUEST['tap911_user'] : "";
        $country_code         = isset($_REQUEST['country_code']) ? $_REQUEST['country_code'] : "";
        if ($token == "" or $name == "" or $description == "" or $phone_number == "" or $country_code == "" or $emergency_contact_id == "" or $tap911_user == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $response = $this->user_model->update_user_emergency_contact($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
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
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
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
                            'country_code' => $results->country_code,
                            'tap911_user' => $results->tap911_user
                            
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
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
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
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
                'message' => 'Record not found'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $response = $this->user_model->add_emergency_tracking($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
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
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
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
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $user_id = $_REQUEST['user_id'];
            $token   = $_REQUEST['token'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
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
                        'message' => 'Record not found'
                        // 'all_city' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->delete_user($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id=$user_id";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->delete_emergency_contact($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
        
    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/add_emergency_user?token=03ed32f30ee37fbb&user_id=77&emergency_latitude=22.719569&geo_long=75.857726&emergency_longitude=1.33356&emergency_address=abc&in_alert=1&emergency_type=1
    -----------------------------------------------------------------------------------------------------
    */
    function add_emergency_user()
    {
        
        $token               = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id             = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $emergency_latitude  = isset($_REQUEST['emergency_latitude']) ? $_REQUEST['emergency_latitude'] : "";
        $emergency_longitude = isset($_REQUEST['emergency_longitude']) ? $_REQUEST['emergency_longitude'] : "";
        $emergency_address   = isset($_REQUEST['emergency_address']) ? $_REQUEST['emergency_address'] : "";
        $emergency_type      = isset($_REQUEST['emergency_type']) ? $_REQUEST['emergency_type'] : "";
        
        
        if ($token == "" or $user_id == '' or $emergency_latitude == "" or $emergency_longitude == "" or $emergency_address == "" or $emergency_type == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->add_emergency_user($token);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data            = $this->user_model->get_user_profiledata($token, $user_id);
                $json_dataemergency   = $this->user_model->get_emergency_contact($token, $user_id);
                $json_datahomeaddress = $this->user_model->get_home_address($token, $user_id);
                
                if ($json_data) {
                    
                    $arr = array();
                    foreach ($json_data as $results) {
                        
                        $logo = $results->profile_pic;
                        $path = base_url() . 'uploads/';
                        if ($logo) {
                            
                            $logos = $path . $logo;
                            
                        } else {
                            $logos = $path . '1517561100258.png';
                        }
                        
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
                            'profile_pic' => $logos,
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
                    $arr1 = array();
                    foreach ($json_dataemergency as $results) {
                        
                        $arr1[] = array(
                            'emergency_contact_id' => $results->emergency_contact_id,
                            'user_id' => $results->user_id,
                            'name' => $results->name,
                            'description' => $results->description,
                            'phone_number' => $results->phone_number,
                            'country_code' => $results->country_code
                            
                        );
                    }
                    $arr2 = array();
                    foreach ($json_datahomeaddress as $results) {
                        $arr2[] = array(
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
                        'profile_data' => $arr,
                        'user_home_address' => $arr2,
                        'emergency_contect' => $arr1
                        
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
        
    }
    
    
    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/accept_emergency_request?token=03ed32f30ee37fbb&alert_id=1
    -----------------------------------------------------------------------------------------------------
    */
    
    function accept_emergency_request()
    {
        $token                     = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $emergency_notification_id = isset($_REQUEST['emergency_notification_id']) ? $_REQUEST['emergency_notification_id'] : "";
        
        
        
        if ($token == "" or $emergency_notification_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->accept_emergency_request($token, $emergency_notification_id);
                $data      = json_encode($json_data);
                print_r($data);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
    /*
    -----------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_emergency_live_location?token=67a4690e03c9935e&emergency_id=506
    -----------------------------------------------------------------------------------------
    */
    
    function get_emergency_live_location()
    {
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $emergency_id = isset($_REQUEST['emergency_id']) ? $_REQUEST['emergency_id'] : "";
        
        
        
        if ($token == "" or $emergency_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_emergency_live_location($token); //user_id
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            
                            'tracking_id' => $results->tracking_id,
                            'first_name' => $results->first_name,
                            'emergency_address' => $results->emergency_address,
                            'add_date' => $results->add_date,
                            'status' => $results->status
                            
                        );
                    }
                    
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'live_user' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_user_type
    -----------------------------------------------------------------------------------------------------
    */
    
    function get_user_type()
    {
        
        $json_data = $this->user_model->get_user_type();
        if ($json_data) {
            $arr = array();
            foreach ($json_data as $results) {
                $arr[] = array(
                    
                    'user_type_id' => $results->user_type_id,
                    'user_type_name' => $results->user_type_name,
                    'add_date' => $results->add_date,
                    'status' => $results->status
                    
                );
            }
            $returnresult = array(
                'status' => 1,
                'message' => 'Record found',
                'user_type_list' => $arr
            );
            $response     = json_encode($returnresult);
            print_r($response);
        }
        
        else {
            $returnresult = array(
                'status' => 1,
                'message' => 'Record not found'
                
            );
            $response     = json_encode($returnresult);
            print_r($response);
        }
        
    }
    
    /*
    ----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/add_community_communitaction?token=dd088bfaaaf468cb&from_user_id=1&to_user_id=0&community_id=0&message_data=hello
    -----------------------------------------------------------------------------------------------------------
    */
    
    function add_community_communitaction()
    {
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $from_user_id = isset($_REQUEST['from_user_id']) ? $_REQUEST['from_user_id'] : "";
        $to_user_id   = isset($_REQUEST['to_user_id']) ? $_REQUEST['to_user_id'] : "";
        $community_id = isset($_REQUEST['community_id']) ? $_REQUEST['community_id'] : "";
        $message_data = isset($_REQUEST['message_data']) ? $_REQUEST['message_data'] : "";
        $msg_type     = isset($_REQUEST['msg_type']) ? $_REQUEST['msg_type'] : "";
        
        if ($token == "" or $from_user_id == "" or $to_user_id == "" or $community_id == "" or $message_data == "" or $msg_type == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token        = $_REQUEST['token'];
            $from_user_id = $_REQUEST['from_user_id'];
            $sql          = "SELECT token FROM tbl_user where token='$token' and user_id='$from_user_id'";
            $res          = $this->db->query($sql);
            $row          = $res->row();
            if ($row) {
                $response = $this->user_model->add_community_communitaction($token);
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
    http://104.237.3.116/tap911/index.php/webservice/add_emergency_communitaction?token=dd088bfaaaf468cb&user_id=1&emergency_id=491&message_data=anywhere%20contect%20me
    -----------------------------------------------------------------------------------------------------------
    */
    
    function add_emergency_communitaction()
    {
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id      = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $emergency_id = isset($_REQUEST['emergency_id']) ? $_REQUEST['emergency_id'] : "";
        $message_data = isset($_REQUEST['message_data']) ? $_REQUEST['message_data'] : "";
        
        if ($token == "" or $user_id == "" or $message_data == "" or $emergency_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $response = $this->user_model->add_emergency_communitaction($token);
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
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_emergancy_communication?token=8ff636448bae3be3&emergency_id=503
    -----------------------------------------------------------------------------------------------------
    */
    
    function get_emergancy_communication()
    {
        
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $emergency_id = isset($_REQUEST['emergency_id']) ? $_REQUEST['emergency_id'] : "";
        
        
        if ($token == "" or $emergency_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_emergancy_communication($token); //user_id
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            
                            'first_name' => $results->first_name,
                            'emergency_id' => $results->emergency_id,
                            'message_data' => $results->message_data,
                            'add_date' => $results->add_date,
                            'status' => $results->status
                            
                        );
                    }
                    
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'live_user' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                } else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    
    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_emergancy_communication?token=8ff636448bae3be3&emergency_id=503
    -----------------------------------------------------------------------------------------------------
    */
    
    function get_community_communication()
    {
        
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $from_user_id = isset($_REQUEST['from_user_id']) ? $_REQUEST['from_user_id'] : "";
        if ($token == "" or $from_user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token        = $_REQUEST['token'];
            $from_user_id = $_REQUEST['from_user_id'];
            // $limit = $_REQUEST['limit'];
            $sql          = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$from_user_id'";
            $res          = $this->db->query($sql);
            $row          = $res->row();
            if ($row) {
                $response = $this->user_model->get_community_communication($token);
                if ($response) {
                    $arr = array();
                    foreach ($response as $results) {
                        $arr[] = array(
                            'community_communitaction_id' => $results->community_communitaction_id,
                            'from_user_id' => $results->from_user_id,
                            'to_user_id' => $results->to_user_id,
                            'community_id' => $results->community_id,
                            'message_data' => $results->message_data,
                            'add_date' => $results->add_date,
                            'msg_type' => $results->msg_type
                            
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'message_list' => $arr
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
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    
    /*
    -----------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/get_tap911_user_list?token=03ed32f30ee37fbb&user_id=77
    -----------------------------------------------------------------------------------------------------
    */
    
    function get_tap911_user_list()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        if ($token == "" or $user_id == '') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_tap911_user_list($token, $user_id);
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            'user_name' => $results->first_name . " " . $results->last_name,
                            'phone_number_text_msg' => $results->phone_number_text_msg,
                            'user_id' => $results->user_id
                            
                        );
                    }
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record found',
                        'emergency_user_list' => $arr
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                else {
                    $returnresult = array(
                        'status' => 1,
                        'message' => 'Record not found'
                        
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
        
    }
    
 
    /*
    
    http://104.237.3.116/tap911/index.php/webservice/get_community_contact?token=8ff636448bae3be3&user_id=45
    
    */
    
    function get_community_contact()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        
        
        if ($token == "" or $user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $json_data = $this->user_model->get_community_contact($token);
                if ($json_data) {
                    $arr = array();
                    foreach ($json_data as $results) {
                        $arr[] = array(
                            
                            'community_emergency_number_id' => $results->community_emergency_number_id,
                            'community_emergency_number' => $results->community_emergency_number,
                            'community_emergency_number_type' => $results->community_emergency_number_type
                            
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
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
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
    
    function add_other_emergency_contact()
    {
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $name         = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";
        $user_id      = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        $description  = isset($_REQUEST['description']) ? $_REQUEST['description'] : "";
        $phone_number = isset($_REQUEST['phone_number']) ? $_REQUEST['phone_number'] : "";
        $tap911_user  = isset($_REQUEST['tap911_user']) ? $_REQUEST['tap911_user'] : "";
        $country_code = isset($_REQUEST['country_code']) ? $_REQUEST['country_code'] : "";
        if ($token == "" or $name == "" or $user_id == "" or $description == "" or $phone_number == "" or $country_code == "" or $tap911_user == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {
                $response = $this->user_model->add_other_emergency_contact($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    function get_accept_notification_user_list()
    {
        
        $user_id      = $_REQUEST['user_id'];
        $emergency_id = $_REQUEST['emergency_id'];
        $token        = $_REQUEST['token'];
        $token        = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id      = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        if ($token == "" or $user_id == '') {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            
            $sql = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res = $this->db->query($sql);
            $row = $res->row();
            if ($row) {
                
                $results = $this->db->query("SELECT emergency_id,notification_user_id from tbl_emergency_notification where emergency_id='" . $_REQUEST['emergency_id'] . "' and emergency_status=1");
                
                $resultdata     = $results->result_array();
                $countvarresult = count($resultdata);
                
                $emcreateusers = array();
                
                for ($i = 0; $i < $countvarresult; $i++) {
                    //$alert_type ='user';
                    $id = $resultdata[$i]['notification_user_id'];
                    // $em_lat = $resultdata[$i]['em_lat'];
                    //$em_long = $resultdata[$i]['em_long'];
                    
                    $sql          = "SELECT user_id,phone_number_text_msg,first_name,last_name FROM tbl_user WHERE `user_id` IN('$id')";
                    $res          = $this->db->query($sql);
                    $rows         = $res->row();
                    $user_ids     = $rows->user_id;
                    $phone_number = $rows->phone_number_text_msg;
                    //  $em_long = $rows->em_long;
                    $first_name   = $rows->first_name;
                    $last_name    = $rows->last_name;
                    $user_name    = $first_name . " " . $last_name;
                    
                    
                    if (!ini_get('date.timezone')) {
                        date_default_timezone_set('UTC');
                    }
                    $dateValue = date("Y-m-d H:i:s");
                    $time      = strtotime($dateValue);
                    $month     = date("F", $time);
                    $year      = date("Y", $time);
                    $table     = "tbl_tracking" . '_' . $month . '_' . $year;
                    
                    
                    $sql       = "SELECT latitude,longitude FROM  $table  WHERE `user_id` IN('$id')";
                    $res       = $this->db->query($sql);
                    $rows      = $res->row();
                    $latitude  = $rows->latitude;
                    $longitude = $rows->longitude;
                    
                    
                    $returnresult1[] = array(
                        'user_name' => $user_name,
                        'phone_number' => $phone_number,
                        'user_id' => $user_ids,
                        'latitude' => $latitude,
                        'longitude' => $longitude
                    );
                }
                
                $sql                 = "SELECT emergency_id,user_id,emergency_id,emergency_latitude,emergency_longitude FROM tbl_emergency WHERE `emergency_id`='" . $_REQUEST['emergency_id'] . "'";
                $res                 = $this->db->query($sql);
                $rows                = $res->row();
                $em_user_id          = $rows->user_id;
                $emergency_id        = $rows->emergency_id;
                $emergency_latitude  = $rows->emergency_latitude;
                $emergency_longitude = $rows->emergency_longitude;
                // $emergency_address = $rows->emergency_address;
                // $emergency_type = $rows->emergency_type;
                // $add_date = $rows->add_date;
                
                $sql            = "SELECT user_id,first_name,last_name,phone_number_text_msg FROM tbl_user WHERE `user_id`='$em_user_id'";
                $res            = $this->db->query($sql);
                $row            = $res->row();
                $first_name     = $row->first_name;
                $last_name      = $row->last_name;
                $phone_numbers  = $row->phone_number_text_msg;
                $user_name      = $first_name . " " . $last_name;
                $emcreateuser[] = array(
                    'user_name' => $user_name,
                    'user_id' => $em_user_id,
                    'emergency_id' => $emergency_id,
                    'emergency_latitude' => $emergency_latitude,
                    'emergency_longitude' => $emergency_longitude,
                    'phone_number' => $phone_numbers
                    
                );
                
                array_push($emcreateusers, $emcreateuser);
                
                
                
                $returnresult = array(
                    'status' => 1,
                    'message' => 'Record found',
                    'emergency_create_user' => $emcreateuser,
                    'emergency_accept_user' => $returnresult1
                    
                );
                
                
                if ($returnresult1) {
                    
                    $response = json_encode($returnresult);
                    print_r($response);
                }
                
                else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record not found'
                        
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                    
                }
                
            } else {
                
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    
    
    /*
    ----------------------------------------------------------------------------------------------------------
    http://104.237.3.116/tap911/index.php/webservice/end_emergency_by_helping_user?token=dd088bfaaaf468cb&notification_user_id=147&emergency_id=603&message_data=test for end emergency
    -----------------------------------------------------------------------------------------------------------
    */
    
    function end_emergency_by_helping_user()
    {
        $token                = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $notification_user_id = isset($_REQUEST['notification_user_id']) ? $_REQUEST['notification_user_id'] : "";
        $emergency_id         = isset($_REQUEST['emergency_id']) ? $_REQUEST['emergency_id'] : "";
        $message_data         = isset($_REQUEST['message_data']) ? $_REQUEST['message_data'] : "";
        if ($token == "" or $notification_user_id == "" or $emergency_id == "" or $message_data == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token                = $_REQUEST['token'];
            $notification_user_id = $_REQUEST['notification_user_id'];
            $sql                  = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$notification_user_id'";
            $res                  = $this->db->query($sql);
            $row                  = $res->row();
            if ($row) {
                $response = $this->user_model->end_emergency_by_helping_user($token);
                $response = json_encode($response);
                print_r($response);
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }
    


    
 /*
    
    http://104.237.3.116/tap911/index.php/webservice/get_community_contact?token=8ff636448bae3be3&user_id=45
    
    */
    
    function get_emergency_user()
    {
        
        $token   = isset($_REQUEST['token']) ? $_REQUEST['token'] : "";
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
        
        
        if ($token == "" or $user_id == "") {
            die(json_encode(array(
                "status" => 0,
                "message" => "Input parameters are not found"
            )));
            
        } else {
            $token   = $_REQUEST['token'];
            $user_id = $_REQUEST['user_id'];
            $sql     = "SELECT token,user_id FROM tbl_user where token='$token' and user_id='$user_id'";
            $res     = $this->db->query($sql);
            $row     = $res->row();
            if ($row) {

               
               $json_datatotal = $this->user_model->emergency_create_user();
               //echo $json_datatotal;
                 $json_data = $this->user_model->get_emergency_user();
                 //print_r($json_data);die();
                if ($json_data) {
                    // $notificationuser = array();
                    foreach ($json_data as $results) {
                      // echo $results->estatus;die();
                       $loginuserid =$results->user_id;
                       if($loginuserid==$user_id){
                        $notificationuser[] = array(

                         'emergency_notification_id' =>$results->emergency_notification_id,
                        'user_name' =>$results->user_name,
                        'user_id' => $results->user_id,
                        'emergency_id' => $results->emergency_id,
                        'emergency_latitude' => $results->emergency_latitude,
                        'emergency_longitude' => $results->emergency_longitude,
                        'emergency_address' => $results->emergency_address,
                        'emergency_type' =>$results->emergency_type,
                        'add_date' => $results->add_date,
                        'emergency_status' =>'3'
                            
                        );
                       }
                          if($loginuserid!=$user_id){
                          $notificationuser[] = array(

                         'emergency_notification_id' =>$results->emergency_notification_id,
                        'user_name' =>$results->user_name,
                        'user_id' => $results->user_id,
                        'emergency_id' => $results->emergency_id,
                        'emergency_latitude' => $results->emergency_latitude,
                        'emergency_longitude' => $results->emergency_longitude,
                        'emergency_address' => $results->emergency_address,
                        'emergency_type' =>$results->emergency_type,
                        'add_date' => $results->add_date,
                        'emergency_status' =>$results->estatus
                            
                        );

                       }
                       // print_r($notificationuser);
                    //}
                }
             
                    // $result = array_merge($notificationuser, $emergencyuser);
                  
                    $returnresult = array(
                        'status' => 1,
                         'total_page'=>$json_datatotal,
                        'message' => 'Record found',
                        'emergency_user_list' => $notificationuser
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                
               } 
                else {
                    $returnresult = array(
                        'status' => 0,
                        'message' => 'Record not found'
                    );
                    $response     = json_encode($returnresult);
                    print_r($response);
                }
                
            } else {
                $returnresult = array(
                    'status' => 0,
                    'message' => 'Authentication failed'
                );
                $response     = json_encode($returnresult);
                print_r($response);
            }
        }
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
