<?php

namespace Sonar\Zipcode\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $tables = 'cities';


    protected $fillable = ['id','prefectuer_id','name','kana'];

    public static function boot()
    {
        parent::boot();
    }
}
