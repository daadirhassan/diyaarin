<?php
/*
OTP ga ayuu generate gareeynaaya file kaan, iyo sms .


*/
session_start();
error_reporting(E_ALL & ~ E_NOTICE);


// $massage = "";
// $phone = "";

class Controller
{
    
    function __construct() {
        $this->processMobileVerification();
    }
    function processMobileVerification()
    {
        switch ($_POST["action"]) {
            case "send_otp":
                
                $mobile_number = $_POST['mobile_number'];
                 $number = $mobile_number;
             
                $otp = rand(100000, 999999);
                $_SESSION['session_otp'] = $otp;
                $massage = "Your One Time OTP is " . $otp;
                
                try{
                    $response = sendSMS($number, $massage);
                    
                    // echo $mobile_number;
                    require_once ("verification-form.php");
                    //echo $massage;
                    exit();
                }catch(Exception $e){
                    die('Error: '.$e->getMessage());
                }
                break;
                
            case "verify_otp":
                $otp = $_POST['otp'];
                
                if ($otp == $_SESSION['session_otp']) {
                    unset($_SESSION['session_otp']);
                    echo json_encode(array("type"=>"success", "message"=>"Your mobile number is verified!"));
                    // inta gesho home ka ama dashboard kaga
                } else {
                    echo json_encode(array("type"=>"error", "message"=>"Mobile number verification failed"));
                    
                }
                break;
        }
    }
    

   
}
$controller = new Controller();
/*
waa function ka diraayo sms ka OTP Ga eh.


*/
header("Content-Type:application/json");
function sendSMS($number,$massage){
    
    
    $cURLConnection = curl_init();
    
    $url="http://bulksms.tabaarak.com/SendSMS.aspx?user=tEstSmS2021&pass=SmSTeSt@@2021&cont=".urlencode($massage)."&rec=$number";
    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    $response_message = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    //echo json_decode(json_encode($response_message));
    }
//   sendSMS ($number,$massage);  
?>