<?php

namespace AppBundle\Tests\Model\Widgets;

use AppBundle\Domain\Widgets\Widget;

/**
 * Class WidgetInstanceTest.
 */
class WidgetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Widget
     */
    protected $sut;

    public function testWidgetNew()
    {
        $name = 'test widget';
        $this->initSut($name);

        $this->assertNotNull($this->sut->id(), 'id');
        $this->assertSame($name, $this->sut->name());
    }

    public function testWidgetModify()
    {
        $id = 2;
        $name = 'test widget';
        $this->initSutEntity($id, $name);

        $this->assertSame($id, $this->sut->id());
        $this->assertSame($name, $this->sut->name());
    }

    public function testWidgetToArrayDefault()
    {
        $id = 2;
        $name = 'test widget';
        $this->initSutEntity($id, $name);

        $this->assertSame([
            'id' => $id,
            'name' => 'test widget',
        ], $this->sut->toArray());
    }

    /**
     * @param $name
     */
    protected function initSut($name)
    {
        $this->sut = Widget::create($name);
    }

    /**
     * @param $id
     * @param $name
     */
    protected function initSutEntity($id, $name)
    {
        $this->sut = Widget::createEntity($id, $name);
    }
}
