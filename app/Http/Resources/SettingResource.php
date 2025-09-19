<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'site_name'=>$this->site_name,
            'email'=>$this->email,
            'favicon'=>asset($this->favicon),
            'logo'=>asset($this->logo),
            'facebook'=>$this->facebook,
            'twitter'=>$this->twitter,
            'insagram'=>$this->insagram,
            'youtupe'=>$this->youtupe,
            'phone'=>$this->phone,
            'country'=>$this->country,
            'city'=>$this->city,
            'street'=>$this->street,
            'address'=>$this->street . ',' . $this->city . ',' . $this->country,
            'small_desc'=>$this->small_desc,
            'created_at'=>$this->created_at->format('Y-m-d'),
        ];

    }
}
