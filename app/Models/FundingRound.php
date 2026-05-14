<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundingRound extends Model
{
    protected $fillable = ['startup_id', 'round_name', 'amount', 'date'];

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }

    public function investors()
    {
        return $this->belongsToMany(Investor::class);
    }
}
