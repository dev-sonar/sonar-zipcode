<?php
namespace Sonar\Zipcode\Test;

use Illuminate\Contracts\Foundation\Application;
use Illumicate\Contracts\Events\Dispatcher;
use Sonar\Zipcode\ZipcodeServiceProvider;

use Mockery;

require_once __DIR__ . "/helpers.php";

class ZipcodeServiceProviderTest extends TestCase
{
    public function setUp()
    {
        $this->application = Mockery::mock(Application::class);
        $this->event = Mockery::mock(Dispacher::class);
        parent::setUp();
    }
    public function testboot()
    {

        $obj = new ZipcodeServiceProvider(['events' => $this->event]);
        $this->assertNull($obj->boot());
    }
    public function testprovides()
    {

        $obj = new ZipcodeServiceProvider(['events' => $this->event]);
        $this->assertEquals($obj->provides(),['sonar_zipcode']);
    }

    public function testRegister()
    {
        $this->event->shouldReceive('listen');
        $obj = new ZipcodeServiceProvider(['events' => $this->event]);
        $this->assertNull($obj->register());

    }

}
