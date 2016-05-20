<?php

namespace Sonar\Zipcode\Test;

use Sonar\Zipcode\ZipcodeTransfer;

class ZipcodeTransferTest extends TestCase
{
    public function testInstance()
    {
        $obj = new ZipcodeTransfer;

        $this->assertTrue($obj instanceof ZipcodeTransfer);
    }

    public function testCsvRecord()
    {
        $obj = new ZipcodeTransfer;
        $csv = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15' ];
        $csv2 = [ 'A1', 'A2', '3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15' ];
        $csv3 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10', 'B11', 'B12', '1', 'B14', 'B15' ];
        $csv4 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'C6', 'B7', 'C8', 'C9', 'B10', 'B11', 'B12', '1', 'B14', 'B15' ];

        $this->assertNull($obj->csvRecord($csv));
        $this->assertNull($obj->csvRecord($csv2));
        $this->assertNull($obj->csvRecord($csv3));
        $this->assertNull($obj->csvRecord($csv4));

        $this->assertTrue($obj->getData() != '');

    }

}
