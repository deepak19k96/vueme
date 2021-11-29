<?php namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\ChatAuth;
use App\model_chat_show;
use App\Models\fan_chat_room;
use App\Models\model_chat_room;
use App\Models\User;
use App\Models\ProfileViews;
use App\Models\UserCreditLog;
use App\Models\user_1_1_chat_request;
use App\Services\ChatRoomUtils;
use App\Services\NotificationUtils;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ApiUtils;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserCreditLogsResourceCollection;
use App\Services\PayoutUtils;

class AnalyticsController extends Controller {

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api'); 
        $this->middleware('role:1');      
        $this->auth = $auth;
    }

    
    public function get_psychic_income_analytic(Request $request)
    {

      
            $result = $this->get_profile_income($request->months);

       return $result;
     
      
      


    }
    public function get_profile_income($total_months){
        
        
        $months_before = $total_months;
        $today = date('Y-m-d');
        $months =[];
        $credits =[]; 
        $net_income_aux =0;
        $net_income_total = 0;
        $percent_to_pay = WhiteLabel::config('accounting')->percent_to_payout;       
      
        $result=[];
        if($months_before>0){
            for ($i= $months_before ; $i > 0   ; $i--) { 

                $last_month = date('Y-m-d', strtotime("-".$i." months") );
                $first = date('Y-m-01', strtotime($last_month));
                $last =  date('Y-m-t', strtotime($last_month));
                $month =date("M", strtotime($first));
    
                $net_income_credits = UserCreditLog::where(['psychic_id'=> Auth::user()->id ])
                ->whereBetween('created_at',[$first,$last])->sum('credits');
                $income_credits = $net_income_credits * $percent_to_pay/100;
                $net_income_total += $income_credits;
            
                array_push($months,$month);
                array_push($credits,$income_credits);               
             
            }     
        }
            $first = date('Y-m-01', strtotime($today));
            $last =  date('Y-m-t', strtotime($today));
            $month =date("M", strtotime($first));
    
            $net_income_credits = UserCreditLog::where(['psychic_id'=> Auth::user()->id])
            ->whereBetween('created_at',[$first,$last])->sum('credits');
            $income_credits = $net_income_credits * $percent_to_pay/100;
            $net_income = $income_credits + $net_income_total;
           
            
                array_push($months,$month);
                array_push($credits,$income_credits);
        


       
       


            array_push($result,['months'=> $months,'views'=>$credits,'net_income'=>number_format((float)$net_income,2)]);

          return $result;
    }
    public function get_psychic_overview_analytic(Request $request)
    {

      
            $result = $this->get_profile_views($request->months);

       return $result;
     
      
      


    }
    public function get_profile_views($total_months){
        
        
        $months_before = $total_months;
        $today = date('Y-m-d');
        $months =[];
        $views =[];       
        $psychic_session=[];
        $result=[];
        if($months_before>0){
             for ($i= $months_before ; $i > 0   ; $i--) { 

            $last_month = date('Y-m-d', strtotime("-".$i." months") );
            $first = date('Y-m-01', strtotime($last_month));
            $last =  date('Y-m-t', strtotime($last_month));
            $month =date("M", strtotime($first));
            $profile_views = ProfileViews::where(['psychic_id'=> Auth::user()->id ])
            ->whereBetween('created_at',[$first,$last])->count();

            $count_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
            {
                 $q->where('service_id',1)->orWhere('service_id',3);
            })
            ->whereBetween('created_at',[$first,$last])->count();
            array_push($psychic_session,$count_sessions);
            array_push($months,$month);
            array_push($views,$profile_views);
            # code...



        }     
        }
             $first = date('Y-m-01', strtotime($today));
             $last =  date('Y-m-t', strtotime($today));
             $month =date("M", strtotime($first));

            $profile_views = ProfileViews::where(['psychic_id'=> Auth::user()->id , ])
            ->whereBetween('created_at',[$first,$last])->count();

            $count_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
            {
                $q->where('service_id',1)->orWhere('service_id',3);
            })
            ->whereBetween('created_at',[$first,$last])->count();

            array_push($psychic_session,$count_sessions);
            array_push($months,$month);
            array_push($views,$profile_views);

        
       
       

            array_push($result,['months'=> $months,'views'=>$views,'sessions'=>$psychic_session]);

          return $result;
    }
    function get_psychic_earnings_analytic(){


        $percent_to_pay = WhiteLabel::config('accounting')->percent_to_payout; 
        $count_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
        {
            $q->where('service_id',1)->orWhere('service_id',3);
        })->count();

        // $count_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
        // {
        //      $q->where('action','Video Chat')->orWhere('action','Calling');
        // })->count();

        $min_sessions = UserCreditLog::where('psychic_id','=' ,Auth::user()->id)->where(function ($q)
        {
            $q->where('service_id',1)->orWhere('service_id',3);
        })->sum('duration');

       
         if(!$count_sessions || !$min_sessions){
             $avg = 0;
         }else{
             $avg = $min_sessions/$count_sessions;
         }


         $income_credits = UserCreditLog::where(['psychic_id'=> Auth::user()->id])
         ->sum('credits');
         if(!$income_credits || !$count_sessions){
            $avg_earnings = 0;
        }else{
            
            $income_credits_aux =  $income_credits * $percent_to_pay/100;
            $avg_earnings = $income_credits_aux/$count_sessions;
        }

        $today = date('Y-m-d');
        $first = date('Y-m-01', strtotime($today));
        $last =  date('Y-m-t', strtotime($today));
       

        
            $earning_this_month = UserCreditLog::where(['psychic_id'=> Auth::user()->id])
            ->whereBetween('created_at',[$first,$last])->sum('credits') * $percent_to_pay/100;

            $earning_today = UserCreditLog::where(['psychic_id'=> Auth::user()->id])->whereDate('created_at','=',$today)
           ->sum('credits')  * $percent_to_pay/100;

        return [ 'total_sessions'=>$count_sessions,
                 'minutes'=>intval($min_sessions),
                 'avg_minutes_x_session'=>round($avg,2),
                 'avg_earnings_x_session'=>number_format((float)$avg_earnings,2),
                 'earning_this_month' => number_format((float)$earning_this_month,2),
                 'earning_today' => number_format((float)$earning_today,2) ];
    }
    public function header_data_earning_reviews_views(Request $request)
    {
      $user = Auth::user();

      $total_earning = PayoutUtils::get_all_time_earnings();
      $all_payment_amount = PayoutUtils::get_all_time_earnings();   


      $current_balance =   PayoutUtils::get_current_balance();
     
      $reviews = $user->reviews()->count();

      $profile_views = $user->psychic_profile_views()->count();
      $rarting_reiews = $user->reviews()->sum('rating');
      $rating_reviews = $reviews >0 && $rarting_reiews>0 ? intval($rarting_reiews)/intval($reviews): 0;
       return  ApiUtils::response_success(['t_earning'=> number_format((float)$total_earning,2),'current_balance'=> number_format((float)$current_balance,2), 'reviews_rating'=> round($rating_reviews,1), 'reviews'=> $reviews, 'p_views' => $profile_views ]); 
           
            
   
    }


    


}
