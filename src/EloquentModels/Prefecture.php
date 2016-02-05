<?php

namespace Sonar\Zipcode\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prefecture extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $tables = 'prefectures';


    protected $fillable = ['id','name','kana'];

    public static function boot()
    {
        parent::boot();
    }
}
