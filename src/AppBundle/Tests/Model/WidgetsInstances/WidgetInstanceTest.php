<?php

namespace AppBundle\Tests\Model\WidgetsInstances;

use AppBundle\Domain\WidgetsInstances\WidgetInstance;

/**
 * Class WidgetInstanceTest.
 */
class WidgetInstanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WidgetInstance
     */
    protected $sut;

    public function testWidgetNew()
    {
        $idWidget = 4;
        $idDashboard = 1;
        $this->initSut($idWidget, $idDashboard);

        $this->assertNotNull($this->sut->id(), 'id');
        $this->assertSame($idWidget, $this->sut->idWidget(), 'idWidget');
        $this->assertSame($idDashboard, $this->sut->idDashboard(), 'idDashboard');
    }

    public function testWidgetModify()
    {
        $idWidget = 3;
        $idDashboard = 2;
        $this->initSutEntity($idWidget, $idDashboard);

        $this->assertNull($this->sut->id(), 'id');
        $this->assertSame($idWidget, $this->sut->idWidget(), 'idWidget');
        $this->assertSame($idDashboard, $this->sut->idDashboard(), 'idDashboard');
    }

    public function testWidgetForm()
    {
        $this->initSutForm();

        $this->assertNull($this->sut->id(), 'id');
        $this->assertNull($this->sut->idWidget(), 'idWidget');
        $this->assertNull($this->sut->idDashboard(), 'idDashboard');
    }

    public function testWidgetSetters()
    {
        $idWidget = 4;
        $idDashboard = 1;
        $this->initSut($idWidget, $idDashboard);

        $idDashboard2 = 'id-dasdsadsadsa';
        $id2 = '2342434';
        $name = 'name';
        $positionX = 10;
        $positionY = 20;
        $sizeX = 13;
        $sizeY = 24;

        $this->sut->setPosition($positionX, $positionY);
        $this->sut->setSize($sizeX, $sizeY);
        $this->sut->setIdDashboard($idDashboard2);
        $this->sut->setId($id2);
        $this->sut->setName($name);

        $this->assertSame($idDashboard2, $this->sut->idDashboard(), 'idDashboard');
        $this->assertSame($id2, $this->sut->id(), 'idDashboard');
        $this->assertSame($positionX, $this->sut->positionX(), 'positionX');
        $this->assertSame($positionY, $this->sut->positionY(), 'positionY');
        $this->assertSame($sizeX, $this->sut->sizeX(), 'sizeX');
        $this->assertSame($sizeY, $this->sut->sizeY(), 'sizeY');
        $this->assertSame($name, $this->sut->name(), 'name');
    }

    public function testWidgetToArrayDefault()
    {
        $idWidget = 4;
        $idDashboard = 1;
        $this->initSutEntity($idWidget, $idDashboard);

        $this->assertSame([
            'id' => null,
            'idWidget' => 4,
            'idDashboard' => 1,
        ], $this->sut->toArray());
    }

    public function testWidgetToArray()
    {
        $idWidget = 4;
        $idDashboard = 1;
        $positionX = 10;
        $positionY = 20;

        $sizeX = 13;
        $sizeY = 24;

        $name = 'dashboardName';

        $this->initSutEntity($idWidget, $idDashboard);
        $this->sut->setPosition($positionX, $positionY);
        $this->sut->setSize($sizeX, $sizeY);
        $this->sut->setName($name);

        $this->assertSame([
            'id' => null,
            'idWidget' => 4,
            'idDashboard' => 1,
        ], $this->sut->toArray());
    }

    public function testWidgetToArrayNokeys()
    {
        $idWidget = 4;
        $idDashboard = 1;
        $positionX = 10;
        $positionY = 20;

        $sizeX = 13;
        $sizeY = 24;

        $name = 'dashboardName';

        $this->initSutEntity($idWidget, $idDashboard);
        $this->sut->setPosition($positionX, $positionY);
        $this->sut->setSize($sizeX, $sizeY);
        $this->sut->setName($name);

        $noKeys = true;
        $this->assertSame([
            'name' => $name,
            'sizeX' => $sizeX,
            'sizeY' => $sizeY,
            'positionX' => $positionX,
            'positionY' => $positionY,
        ], $this->sut->toArrayNoKeys($noKeys));
    }

    public function testWidgetInstanceToArrayInfo()
    {
        $idWidget = 4;
        $idDashboard = 1;
        $positionX = 10;
        $positionY = 20;

        $sizeX = 13;
        $sizeY = 24;

        $name = 'dashboardName';

        $this->initSutEntity($idWidget, $idDashboard);
        $this->sut->setPosition($positionX, $positionY);
        $this->sut->setSize($sizeX, $sizeY);
        $this->sut->setName($name);

        $noKeys = true;
        $this->assertSame([
            'positionX' => $positionX,
            'positionY' => $positionY,
            'sizeX' => $sizeX,
            'sizeY' => $sizeY,
        ], $this->sut->toArrayInfo($noKeys));
    }

    /**
     * @param $idWidget
     * @param $idDashboard
     */
    protected function initSut($idWidget, $idDashboard)
    {
        $this->sut = WidgetInstance::create($idWidget, $idDashboard, 'test widget');
    }

    /**
     * @param $idWidget
     * @param $idDashboard
     */
    protected function initSutEntity($idWidget, $idDashboard)
    {
        $this->sut = WidgetInstance::createEntity($idWidget, $idDashboard, 'test widget');
    }

    /**
     *
     */
    protected function initSutForm()
    {
        $this->sut = WidgetInstance::createFormEntity();
    }
}
