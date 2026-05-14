<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = ['name', 'type', 'website'];

    public function fundingRounds()
    {
        return $this->belongsToMany(FundingRound::class);
    }
}
