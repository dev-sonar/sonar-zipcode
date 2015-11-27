<?php
namespace Sonar\Zipcode\FluentModels;

use Illuminate\Database\Query\Builder;

class Zipcode
{
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }
    public function getListByCityId($city_id)
    {
        if ( ! $city_id ) return [];

        return $this->builder->from('zipcodes')->select(['id','code','name','kana'])
            ->whereNull('deleted_at')
            ->where('city_id','=',$city_id)
            ->orderBy('id','asc')
            ->get();
    }
}
