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
                foreach([5,8] as $num ) {
                    if ( $csv[$num] != $prev_csv[$num] ) {
                        $csv[$num] = $prev_csv[$num] . $csv[$num];
                    }
                }
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
