<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dni' => $this->dni,
            'email' => $this->email,
            'career' => $this->career,
            'profile_photo' => $this->profilePhotoUrl(),
            'created_at' => $this->created_at->format("d-m-Y"),
        ];
    }

    protected function profilePhotoUrl()
    {
        return $this->profile_photo ? asset('storage/profiles/' . $this->profile_photo) : null;
    }
}
