<?php
namespace Sonar\Zipcode;

use Sonar\Common\Imports\CsvReaderTrait;

class ZipcodeTransfer
{
    use CsvReaderTrait;

    private $prev_csv;
    private $data;
    private $counter;

    public function __construct()
    {
        $this->prev_csv = null;
        $this->data = '';
        $this->counter = 0;
    }

    public function csvRecord(array $csv)
    {
        if ( isset($this->prev_csv) ) {
            $prev_csv = $this->prev_csv;
            if ( $prev_csv[2] != $csv[2] || $csv[12] != '1' ) {
                $prev_csv[1] = sprintf("%07s%02d",$prev_csv[2],$this->counter);
                $this->data .= implode(",",$prev_csv) . "\n";
                if ( $prev_csv[2] == $csv[2] ) {
                    $this->counter ++;
                } else {
                    $this->counter = 0;
                }
            } else {
                if ( $csv[8] != $prev_csv[8] ) $csv[8] = $prev_csv[8] . $csv[8];
                if ( $csv[5] != $prev_csv[5] ) $csv[5] = $prev_csv[5] . $csv[5];
            }
        }
        $this->prev_csv = $csv;
    }
    public function getData()
    {
        if ( isset($this->prev_csv) ) {
            $this->data .= implode(",",$this->prev_csv) . "\n";
            $this->prev_csv = null;
        }
        return $this->data;
    }

}
