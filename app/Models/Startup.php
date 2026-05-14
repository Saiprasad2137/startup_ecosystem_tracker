<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    protected $fillable = ['name', 'industry', 'stage', 'funding_raised'];

    public function founders()
    {
        return $this->hasMany(Founder::class);
    }

    public function fundingRounds()
    {
        return $this->hasMany(FundingRound::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
