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
        if ( $city_id) {
            return $this->getListBuilder()
                ->where('city_id','=',$city_id)
                ->get();
        }
        return [];
    }
    public function getListByCode($code)
    {
        if ( $code) {
            return $this->getListBuilder()
                ->where('code','=',str_replace("-","",$code))
                ->get();
        }
        return [];
    }
    private function getListBuilder()
    {
        return $this->builder->table('zipcodes')->select(['id','code','prefecture_id','prefecture_name','city_id','city_name','name'])
            ->whereNull('deleted_at')
            ->orderBy('id','asc');
    }
}
