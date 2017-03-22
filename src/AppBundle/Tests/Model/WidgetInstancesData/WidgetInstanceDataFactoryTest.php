<?php

namespace AppBundle\Tests\Model\WidgetInstancesData;

use AppBundle\Domain\WidgetInstancesData\WidgetInstanceClockData;
use AppBundle\Domain\WidgetInstancesData\WidgetInstanceDataFactory;
use AppBundle\Domain\WidgetInstancesData\WidgetInstanceTextData;

/**
 * Class WidgetInstanceDataFactory.
 */
class WidgetInstanceDataFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WidgetInstanceDataFactory
     */
    protected $sut;

    /**
     *
     */
    protected function setUp()
    {
        $this->sut = new WidgetInstanceDataFactory();
    }

    /**
     * @param $idType
     * @param $classInstance
     * @dataProvider dataProvider
     */
    public function testGetInstances($idType, $classInstance)
    {
        $widgetInstanceData = $this->sut->getInstance($idType);
        $this->assertInstanceOf($classInstance, $widgetInstanceData);
        $this->assertNotEmpty($classInstance, $widgetInstanceData->generateData());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedException Data not found
     */
    public function testGetInstancesNotExists()
    {
        $this->sut->getInstance(12021);
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            ['1', WidgetInstanceClockData::class],
            ['2', WidgetInstanceTextData::class],
        ];
    }
}
