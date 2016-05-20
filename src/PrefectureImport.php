<?php
namespace Sonar\Zipcode;

use Sonar\Common\Imports\AbstractImport;
use Sonar\Common\Imports\CsvReaderTrait;

use Sonar\Zipcode\EloquentModels\Prefecture;

class PrefectureImport extends AbstractImport
{
    use CsvReaderTrait;

    private $prefecture;

    public function __construct(Prefecture $prefecture)
    {
        parent::__construct();
        $this->prefecture = $prefecture;
    }

    public function csvRecord(array $csv)
    {
        if ( count($csv) <= 14 ) return;
        if ( is_numeric($csv[0]) === false ) return;

        $model = $this->prefecture->findOrNew(substr(sprintf("%05d", trim($csv[0])),0,2)+0);
        $models = [
            'prefectures' => [
                $model,
            ]
        ];
        $this->setModels($models,$csv);
        unset($models);

        return true;
    }
    public function setPrefectureId($model, $key, $csv, $col)
    {
        $model->$key = substr(sprintf("%05d",$csv[$col-1]),0,2) + 0;
        return true;
    }
    public function setName($model, $key, $csv, $col)
    {
        $val = $csv[$col-1];
        $this->setLengthValue($model, $key, $val, 50);
        return true;
    }
    public function setKana($model,$key,$csv,$col)
    {
        $val = mb_convert_kana($csv[$col-1],'KV');
        $this->setLengthValue($model, $key, $val, 100);
        return true;
    }
    private function setLengthValue($model, $key, $val, $length)
    {
        if (mb_strlen($val,'utf-8')  > $length) {
            $model->$key = mb_substr($val, 0, mb_strpos($val, '（'));
        } else {
            $model->$key = $val;
        }
    }

}
