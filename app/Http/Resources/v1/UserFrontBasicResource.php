<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserFrontBasicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'role' => $this->role()->first(),
            'profile' => new UserProfileBasicResource($this->userProfile()->first()),
            'phone_numbers' => $this->user_mobile_nums()->get(),
            'services'=> new UserServiceResourceCollection($this->userService()->where('active', "=", 1)->get()),
            'posts'=> new PostResourceCollection(
                $this->posts()
                    ->whereDate('available_after', '<=', date('Y-m-d'))
                    ->where('status', "PUBLISHED")
                    ->orderBy('available_after', 'desc')
                    ->get()
            ),
            'account_status' => $this->account_status,
            'saved'=> $this->isSaved(),
            'free_chat' => $this->free_chat,
        ];
    }
}
