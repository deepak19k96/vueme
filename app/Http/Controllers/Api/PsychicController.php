<?php namespace App\Http\Controllers\Api;




use App\Models\User;
use App\Models\UserReferral;
use App\Services\NotificationUtils;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ApiUtils;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Services\EmailUtils;
use CreateUserReferral;

class PsychicController extends Controller {

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api');
        $this->middleware('role:1');
        $this->middleware('verifield');
        $this->auth = $auth;
    }
    public function UpdatePsychic(Request $request)
    {

       
        $this->validate($request, [
            'period' => ['string', Rule::in(['Monthly','Daily'])],
            'goal'=> 'integer|min:1'
        ]);

         
        $user = Auth::user();
        $period =  $request->input('period');
        $goal =  $request->input('goal');
        
        if($period && $goal){
            if($period == 'Monthly'){
              
                $user->earnings_goal_month = $goal;
            }else{
               
                $user->earnings_goal_daily = $goal;
            }

            $user->save();

            return ApiUtils::response_success('OK',Response::HTTP_OK);

        }

       
    }

    public function referralEmail(Request $request)
    {

        $request->validate([
            'referral_email' => ['required', 'email', 'unique:user_referral',  'bail'],
        ]);
        
        if (!empty($request['referral_email'])) {
            $request['referral_email'] = trim($request['referral_email']);
        }
        

        $user = Auth::user();
        $user_referral = new UserReferral();
        $user_referral->referral_email = $request['referral_email'];
        $user_referral->user_id = $user->id;
        $user_referral->action = 'Invite Sent';

        if ($user_referral->save()){
                EmailUtils::send_referral_email($user,$request['referral_email']);
                return response()->json(['message'=> 'Sent Email'], 200);
            }
        return ApiUtils::response_fail(['message'=> 'An invitation has been sent to this email'], 400);
        
    }


    public function referralEmailResend(Request $request)
    {
        
        $user = Auth::user();
        

        $user_referral = UserReferral::where(array('id' => $request['line']))->first();
        $user_referral->action = 'Invite Resend';
        $user_referral->save();

        EmailUtils::send_referral_email($user,$request['referral_email']);
        return response()->json(['message'=> 'Sent Email'], 200);


    }
    

  

}
