<?php

namespace App\Services;
use Exception;
use App\Services\WhiteLabel;
use Twilio\Rest\Client;
use App\Models\User;


class TwilioUtils
{
     
   
    public static function is_valid_number($number,$code= null)
    {
    
        if($code == null){
            $code ='US';
        }
        try {

            $account_sid = WhiteLabel::config('twilio')->account;      
            $auth_token = WhiteLabel::config('twilio')->auth_token;  
            $client = new Client($account_sid, $auth_token);         
            $phone_number = $client->lookups->v1->phoneNumbers('+'.$number)->fetch(array("type" => array("carrier")));
            return $phone_number->carrier['type']!='voip';
            //return true;
       
        } catch (Exception $ex) {
            return false;           
        }
       
    } 
    public static function send_sms_first_message($number,$message,$code = null)
    {
        $account_sid = WhiteLabel::config('twilio')->account;      
        $auth_token = WhiteLabel::config('twilio')->auth_token;
        $twilio_number =WhiteLabel::config('twilio')->system_numbers['US'];         
        $client = new Client($account_sid, $auth_token);
        
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            '+'.$number,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );
      
    }
    public static function send_sms_appointment_booked($appointment)
    {       

        $mobile = $appointment->user()->first()->user_mobile_nums()->first();       
        $message = 'Your reading with '.
            $appointment->psychic()->first()->UserProfile()->first()->display_name.' is booked: '.route('user_dashboard_appointments').'?p='.self::get_rand_number();
        self::send_message($mobile,$message);  
      
    } 
    public static function send_sms_appointment_cancel($appointment)
    {       

        $app = ApiUtils::url();
        $mobile = $appointment->user()->first()->user_mobile_nums()->first();        
        $message = 'Your reading with '.
            $appointment->psychic()->first()->UserProfile()->first()->display_name.' was declined. Try another Psychic: '.$app.'?p='.self::get_rand_number();
        self::send_message($mobile,$message); 
      
    } 
    public static function send_sms_psychic_is_ready_to_initiate_service($user_1_1_chat_request)
    {       

        $mobile = $user_1_1_chat_request->user()->first()->user_mobile_nums()->first();       
        $message = $user_1_1_chat_request->model()->first()->UserProfile()->first()->display_name.
        ' is ready for your reading! Join now: '.route('user_dashboard_appointments').'?r='.$user_1_1_chat_request->id;
        self::send_message($mobile,$message); 
       
    }
    
        
    public static function send_sms_when_user_create_appointment($appointment,$now_or_later)
    {       

        $mobile = $appointment->psychic()->first()->user_mobile_nums()->first(); 

        $app = ApiUtils::url();
        $name = $appointment->user()->first()->UserProfile()->first()->name;
        $message = $name.' has requested a reading - confirm now! '.$app.'/dashboard/appointments';

        if($now_or_later == 'later'){
            $message = $name.' has requested a scheduled reading - confirm now! '.route('dashboard').'?a='.$appointment->id;
        }       
        self::send_message($mobile,$message); 
    
    } 

    public static function send_sms_to_psychic_request_now_received($user_1_1_chat_request)
    {
        $mobile = $user_1_1_chat_request->model()->first()->user_mobile_nums()->first();       
        $message = $user_1_1_chat_request->user()->first()->UserProfile()->first()->name.
        ' has requested a reading - start now! '.route('dashboard').'?r='.$user_1_1_chat_request->id;
        self::send_message($mobile,$message); 
    }
    public static function send_sms_psychic_and_user_when_appointment_will_start($user_1_1)
    {       

        $mobile_user = $user_1_1->user()->first()->user_mobile_nums()->first();      
        $message = $user_1_1->model()->first()->UserProfile()->first()->display_name.
            ' is ready for your reading! Join now: '.route('user_dashboard_appointments').'/r='.$user_1_1->id;
       self::send_message($mobile_user,$message, null, 'SmsMarketing');

       $mobile_psychic = $user_1_1->model()->first()->user_mobile_nums()->first();      
       $message = 'Begin '.
           $user_1_1->user()->first()->UserProfile()->first()->name.'`s Reading Now! '.route('dashboard').'?r='.$user_1_1->id;

        self::send_message($mobile_psychic,$message, null, 'SmsMarketing');
      
    }
    
    public static function send_sms_to_psychic_appointment_cancel($appointment)
    {       
    
        $mobile = $appointment->psychic()->first()->user_mobile_nums()->first();          
        $message = 'Your appointment with '.
        $appointment->user()->first()->UserProfile()->first()->name.' has been canceled. https://psychics1on1.com/dashboard';
        self::send_message($mobile,$message);
      
    }
    public static function send_sms_to_user_when_psychic_appointment_cancel($appointment)
    {       
    
        $app = ApiUtils::url(); 
        $mobile = $appointment->user()->first()->user_mobile_nums()->first();          
        $message = 'Your reading with '.
        $appointment->model()->first()->UserProfile()->first()->display_name.' was declined. Try another Psychic: '. $app.'?p='.self::get_rand_number();
        self::send_message($mobile,$message);
      
    }  
    public static function send_sms_to_psychic_appointment_rescheduled($appointment)
    {       

        $mobile = $appointment->psychic()->first()->user_mobile_nums()->first();         
        $message = 'Your reading with '.
        $appointment->user()->first()->UserProfile()->first()->name.' was rescheduled. Confirm Now: https://psychics1on1.com/dashboard';
        self::send_message($mobile,$message);
      
    } 

    public static function send_sms_to_psychic_first_message_new_chat($chat)
    {
        $code = rand(1000, 99999);
        $mobile = $chat->receiver()->first()->user_mobile_nums()->first(); 
        $message = $chat->receiver->online ?
         'You have a new message from '. $chat->user()->first()->UserProfile()->first()->name.'. Please respond ASAP: '.' https://psychics1on1.com/chat?user='.$chat->user->id : 
         'You have a new message from '. $chat->user()->first()->UserProfile()->first()->name.'. Please respond within 24 hours: '.' https://psychics1on1.com/chat?user='.$chat->user->id;
        self::send_message($mobile,$message);
      
    }


    public static function send_verification_sms($mobile, $user, $reminder = false)
    {
        $message = 'Your Psychics1on1 verification code is: '.$mobile->verification_code;
        if($user->role_id == 2){
            $message = $mobile->verification_code.' is your Psychics1on1 verification code. Secure your account to get your free $5 credit!';
            if($reminder)
            $message = $mobile->verification_code.' is your Psychics1on1 verification code. Don’t miss out on your free $5 credit and finish securing your account now! ';
        }
       
        self::send_message($mobile,$message);
    }


    

    public static function phone_weekly_horoscope_sign_sms($user)
    {
        $message = $user->name.", what's in the stars for you this week? Check your weekly Psychics1on1 Horoscope to find out https://psychics1on1.com/horoscope/".$user->zodiac;
        self::send_message_horoscope($user,$message);
    }



    private static function send_message_horoscope($number_obj,$message,$code2=null, $did = "twilio"){

        
         $number = $number_obj->country_code.$number_obj->number;
         if($number){
                  $is_valid = self::is_valid_number($number,$code2);
                 if($is_valid){
                     $account_sid = WhiteLabel::config($did)->account;      
                     $auth_token = WhiteLabel::config($did)->auth_token;
                     $twilio_number =WhiteLabel::config($did)->system_numbers['US'];         
                     $client = new Client($account_sid, $auth_token);            
                         $client->messages->create(
                         // Where to send a text message (your cell phone?)
                         '+'.$number,
                         array(
                             'from' => $twilio_number,
                             'body' => $message
                         )
                         );            
                 }
 
         }
        
 
       
      
            
     } 


    public static function send_to_user_after_one_day_regiter_first_chat_free($user)
    {
        $mobile = $user->user_mobile_nums()->first();
        $app = ApiUtils::url(); 
        $message = 'Get $5 free credit with your first reading! Find your Psychic today '.$app;
        self::send_message($mobile,$message, null, 'SmsMarketing');

    }
    public static function send_to_psychic_when_request_expired($psychic)
    {
       $total_request_expired = $psychic->lost_requests;
       if($total_request_expired == 10 || $total_request_expired == 25) {
        $message = 'Psychics1on1 Warning: Your profile visibility has been downgraded due to 10+ missed client requests. Unresponsive Psychics create a poor client experience. Questions? Contact support@psychics1on1.com';
           if($total_request_expired == 25){
           $message = 'Psychics1on1 Last Warning: Your profile has been downgraded to lowest visibility due to 25+ missed client requests. Continued unresponsiveness when online will result in account deactivation.';
           }
        $mobile = $psychic->user_mobile_nums()->first();
        if($mobile){
            self::send_message($mobile,$message, null, 'SmsMarketing');
        }
        
       }

    }

    public static function send_SMS($mobile,$message, $did = 'SmsMarketing')
    {
       
        self::send_message($mobile,$message, null, $did);

    }
    private static function get_rand_number(){
        return  rand(1000, 99999);
    }
    private static function check_user_disabled($user){
       
    }


    private static function send_message($number_obj,$message,$code2=null, $did = "twilio"){

       if($number_obj->user->email_validated)
       {
        $number = $number_obj->prefix.$number_obj->number;
        $code2 = $number_obj->code2; 
        if($number){
                 $is_valid = self::is_valid_number($number,$code2);
                if($is_valid){
                    $account_sid = WhiteLabel::config($did)->account;      
                    $auth_token = WhiteLabel::config($did)->auth_token;
                    $twilio_number =WhiteLabel::config($did)->system_numbers['US'];         
                    $client = new Client($account_sid, $auth_token);            
                        $client->messages->create(
                        // Where to send a text message (your cell phone?)
                        '+'.$number,
                        array(
                            'from' => $twilio_number,
                            'body' => $message
                        )
                        );            
                }

        }
       }

      
     
           
    } 
    
    }  

    
