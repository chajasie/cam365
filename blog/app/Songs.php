<?php
/**
 * Created by PhpStorm.
 * User: rausd_000
 * Date: 11.03.2015
 * Time: 16:29
 */

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Songs extends Eloquent {
    protected $fillable =  [
        'title', 'lyrics'
    ];
} 