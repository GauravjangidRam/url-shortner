<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Url extends Model
{
    use HasFactory;
    protected $fillable = ['original_url', 'short_code', 'company_id', 'user_id', 'hits'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVisibleTo(Builder $query, User $user)
    {
        return match ($user->role) {
            'SuperAdmin' => $query,
            'Admin'      => $query->where('company_id', $user->company_id),
            'Member'     => $query->where('user_id', $user->id),
            default      => $query->whereRaw('1 = 0'),
        };
    }
}