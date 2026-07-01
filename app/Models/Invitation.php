<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['email', 'role', 'company_id', 'token', 'accepted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}