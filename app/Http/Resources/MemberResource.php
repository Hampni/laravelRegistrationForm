<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday,
            'report_subject' => $this->report_subject,
            'country' => $this->country,
            'phone' => $this->phone,
            'email' => $this->email,
            'company' => $this->company,
            'position' => $this->position,
            'about_me' => $this->about_me,
            'photo' => $this->photo
        ];
    }
}
