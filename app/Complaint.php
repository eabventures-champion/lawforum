<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['name', 'email', 'type', 'subject', 'message'];

    public function replies()
    {
        return $this->hasMany(ComplaintReply::class);
    }
}
