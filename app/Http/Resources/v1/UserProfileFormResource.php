<?php

namespace App\Http\Resources\v1;

use Faker\Provider\DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       //var_dump($this);
        if(!is_null($this->birth_date) && $this->birth_date != ""){
            $date = new \DateTime($this->birth_date);
            $birth_date  = $date->format('m/d/Y');
        }else{
            $birth_date  = $this->birth_date;
        }

        

        $ext = pathinfo(storage_path($this->intro_video_path), PATHINFO_EXTENSION);
        $intro_video_thumbnail = str_replace('.'.$ext,'.jpg',$this->intro_video_path);
        

        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'display_name' => $this->display_name,
            'profile_link' => $this->profile_link,
            'email' => $this->email,
            //'country_code' => $this->country_code,
            'birth_date' => $birth_date ,
            'social_link_one' => $this->social_link_one,
            'social_link_two' => $this->social_link_two,
            'social_link_three' => $this->social_link_three,
            'description' => $this->description,
            //'haedshot_path' => $this->haedshot_path,
            //'full_body_path' => $this->full_body_path,
            'profile_headshot_url' => $this->haedshot_path,
            'cover_path' => $this->cover_path,
            'gender' => $this->gender,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'timezone' => $this->timezone,
            'intro_video_path' => $this->intro_video_path,
            'intro_audio_path' => $this->intro_audio_path,
            'intro_video_thumbnail' => $intro_video_thumbnail,
            'tagline' => $this->tagline,  
            'elevator_pitch' => $this->elevator_pitch,  
            'get_featured' => $this->get_featured,  
            'displayNameEdit' => is_null($this->tagline) || preg_match("([^A-Za-z0-9 ,.!'?])",$this->display_name) ? 1 : 0,
            'years_experience' => $this->years_experience,
            'years_experience' => $this->years_experience,
            't_clients' => $this->t_clients,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
