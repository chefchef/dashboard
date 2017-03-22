<?php

namespace AppBundle\Tests\Model\Core;

use AppBundle\Application\Widgets\UseCases\FetchWidgetResponse;

/**
 * Class BaseResponseTest.
 */
class BaseResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FetchWidgetResponse
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new FetchWidgetResponse();
    }

    public function testDefaultValues()
    {
        $this->assertNull($this->sut->data);
        $this->assertNull($this->sut->message);
        $this->assertNull($this->sut->tpl);
    }

    public function testStatus404()
    {
        $this->assertSame(404, $this->sut->status());
    }

    public function testStatus200()
    {
        $this->sut->data = 'data';
        $this->assertSame(200, $this->sut->status());
    }

    public function testStatus500()
    {
        $this->sut->message = 'error';
        $this->assertSame(500, $this->sut->status());

        $this->sut->data = 'data';
        $this->assertSame(500, $this->sut->status());
    }

    /**
     *
     */
    public function testAddTemplate()
    {
        $tpl = 'template.tpl';
        $this->sut->addTpl($tpl);
        $this->assertSame($tpl, $this->sut->tpl);
    }
}
