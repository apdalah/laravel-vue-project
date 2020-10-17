<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $defaultUserData = parent::toArray($request);
        
        $rolesAndPermissions = [
            'role' => $this->roles->first(),
            'permissions' => $this->permissions
        ];

        return array_merge($defaultUserData, $rolesAndPermissions);
    }
}
