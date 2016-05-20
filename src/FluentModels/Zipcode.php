<?php
namespace Sonar\Zipcode\FluentModels;

use Illuminate\Database\Connection;

class Zipcode
{
    private $builder;

    public function __construct(Connection $builder)
    {
        $this->builder = $builder;
    }
    public function getListByCityId($city_id)
    {
        if ( ! $city_id) {
            return [];
        }

        return $this->builder->table('zipcodes')->select(['id','code','prefecture_id','prefecture_name','city_id','city_name','name'])
            ->whereNull('deleted_at')
            ->where('city_id','=',$city_id)
            ->orderBy('id','asc')
            ->get();
    }
    public function getListByCode($code)
    {
        if ( ! $code) {
            return [];
        }

        return $this->builder->table('zipcodes')->select(['id','code','prefecture_id','prefecture_name','city_id','city_name','name'])
            ->whereNull('deleted_at')
            ->where('code','=',str_replace("-","",$code))
            ->orderBy('id','asc')
            ->get();
    }
}
