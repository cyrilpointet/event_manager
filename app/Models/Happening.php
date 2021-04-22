<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Happening extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'place',
        'team_id',
        'start_at',
        'end_at',
        'status_id'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
