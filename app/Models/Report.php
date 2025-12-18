<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    public function status() : BelongsTo {
        return $this->belongsTo(Status::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
