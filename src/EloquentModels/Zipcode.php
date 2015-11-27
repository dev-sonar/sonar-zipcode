<?php

namespace Sonar\Zipcode\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zipcode extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $tables = 'zipcodes';


    protected $fillable = ['id','city_id','name','code','kana'];

    public static function boot()
    {
        parent::boot();
    }
}
