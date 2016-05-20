<?php
namespace Sonar\Zipcode;

use Sonar\Common\Imports\AbstractImport;
use Sonar\Common\Imports\CsvReaderTrait;

use Sonar\Zipcode\EloquentModels\Zipcode;

class ZipcodeImport extends AbstractImport
{
    use CsvReaderTrait;

    private $is_prefecture;
    private $is_city;
    private $zipcode;
    private $prefecture_import;
    private $city_import;

    public function __construct(Zipcode $zipcode, PrefectureImport $prefecture_import, CityImport $city_import)
    {
        parent::__construct();

        $this->zipcode = $zipcode;
        $this->prefecture_import = $prefecture_import;
        $this->city_import = $city_import;

        $this->is_prefecture = false;
        $this->is_city = false;
    }
    public function setPrefectureConfig($config)
    {
        $this->prefecture_import->setConfig($config);
    }
    public function setCityConfig($config)
    {
        $this->city_import->setConfig($config);
    }
    public function setIsPrefecture($bool)
    {
        $this->is_prefecture = $bool ? true : false;
    }

    public function setIsCity($bool)
    {
        $this->is_city = $bool ? true : false;
    }

    public function csvRecord(array $csv)
    {
        if (count($csv) <= 14 || is_numeric($csv[1]) === false) {
            return;
        }

        if ($this->is_prefecture) {
            $this->prefecture_import->csvRecord($csv);
        }
        if ($this->is_city) {
            $this->city_import->csvRecord($csv);
        }

        $model = $this->zipcode->findOrNew(trim($csv[1]));
        $models = [
            'zipcodes' => [
                $model,
            ]
        ];
        $this->setModels($models, $csv);
        unset($models);

        return true;
    }
    public function setPrefectureId($model, $key, $csv, $col)
    {
        $model->$key = substr(sprintf("%05d", $csv[$col-1]), 0, 2)+0;
        return true;
    }
    public function setCityId($model, $key, $csv, $col)
    {
        $model->$key = $csv[$col-1]+0;
        return true;
    }
    public function setName($model, $key, $csv, $col)
    {
        $val = $csv[$col-1];
        if (mb_strlen($val, 'utf-8') > 50) {
            $model->$key = mb_substr($val, 0, mb_strpos($val, '（'));
        } else {
            $model->$key = $val;
        }
        return true;
    }
    public function setKana($model, $key, $csv, $col)
    {
        $val = mb_convert_kana($csv[$col-1], 'KV');
        if (mb_strlen($val, 'utf-8') > 100) {
            $model->$key = mb_substr($val, 0, mb_strpos($val, '（'));
        } else {
            $model->$key = $val;
        }
        return true;
    }
}
