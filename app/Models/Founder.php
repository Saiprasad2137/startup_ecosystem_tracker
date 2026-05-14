<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Founder extends Model
{
    protected $fillable = ['startup_id', 'name', 'role'];

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }
}
