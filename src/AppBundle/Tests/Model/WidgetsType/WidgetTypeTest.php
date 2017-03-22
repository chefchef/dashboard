<?php

namespace AppBundle\Tests\Model\WidgetsType;

use AppBundle\Domain\WidgetsType\WidgetType;
use Ramsey\Uuid\Uuid;

/**
 * Class WidgetTypeTest.
 */
class WidgetTypeTest extends \PHPUnit_Framework_TestCase
{
    const TEST_WIDGET = 'test widget';
    /**
     * @var WidgetType
     */
    protected $sut;

    public function testIdWidget()
    {
        $this->initSut();
        $this->assertNotNull($this->sut->idWidget());
    }

    public function testDataByDefault()
    {
        $this->initSut();
        $this->assertEmpty($this->sut->data());
    }

    public function testData()
    {
        $data = ['url' => 'http://www.'];
        $this->initSut($data);
        $this->assertSame($data, $this->sut->data());
    }

    /**
     * @param $data
     */
    protected function initSut($data = [])
    {
        $this->sut = WidgetType::create(Uuid::uuid4()->toString(), $data);
    }
}
