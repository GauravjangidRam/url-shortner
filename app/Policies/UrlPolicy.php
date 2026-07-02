<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Url;

class UrlPolicy
{
    public function view(User $user, Url $url)
    {
        return match ($user->role) {
            'SuperAdmin' => true,
            'Admin'      => $url->company_id === $user->company_id,
            'Member'     => $url->user_id === $user->id,
            default      => false,
        };
    }

}