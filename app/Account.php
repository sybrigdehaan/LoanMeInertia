<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class,'user_id');
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
