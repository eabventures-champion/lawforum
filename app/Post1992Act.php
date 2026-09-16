<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post1992Act extends Model
{
    protected $fillable = [
        'title',
        'preamble',
        'year',
        'post_category',
        'post_group',
        'upload_pdf',
    ];
}
