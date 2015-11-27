<?php
namespace Sonar\Zipcode;

use Sonar\Common\Imports\AbstractImport;
use Sonar\Common\Imports\CsvReaderTrait;

use Sonar\Zipcode\EloquentModels\Zipcode;

class ZipcodeImport extends AbstractImport
{
    use CsvReaderTrait;

    public function __construct(Zipcode $zipcode)
    {
        parent::__construct();

        $this->zipcode = $zipcode;
    }

    public function csvRecord(array $csv)
    {
        if ( count($csv) <= 14 ) return;
        if ( is_numeric($csv[1]) === false ) return;

        $model = $this->zipcode->findOrNew(trim($csv[1]));
        $models = [
            'zipcodes' => [
                $model,
            ]
        ];
        $this->setModels($models,$csv);
        unset($models);

        return true;
    }
    public function setCityId($model,$key,$csv,$col)
    {
        $model->$key = $csv[$col-1] + 0;
        return true;
    }
    public function setName($model,$key,$csv,$col)
    {
        $val = $csv[$col-1];
        if ( mb_strlen($val,'utf-8')  > 50 ) {
            $model->$key = mb_substr($val,0,mb_strpos($val,'（'));
        } else {
            $model->$key = $val;
        }
        return true;
    }
    public function setKana($model,$key,$csv,$col)
    {
        $val = mb_convert_kana($csv[$col-1],'KV');
        if ( mb_strlen($val,'utf-8')  > 100 ) {
            $model->$key = mb_substr($val,0,mb_strpos($val,'（'));
        } else {
            $model->$key = $val;
        }
        return true;
    }

}
