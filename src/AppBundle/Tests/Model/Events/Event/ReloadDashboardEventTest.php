<?php

namespace AppBundle\Tests\Model\Events\Event;

use AppBundle\Domain\Events\DomainEvent;
use AppBundle\Domain\Events\Event\ReloadDashboardEvent;

/**
 * Class ReloadDashboardEventTest.
 */
class ReloadDashboardEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DomainEvent
     */
    private $event;

    protected function setUp()
    {
        $this->event = ReloadDashboardEvent::create();
    }
    public function testCreateInstance()
    {
        $this->assertInstanceOf(DomainEvent::class, $this->event);
        $this->assertInstanceOf(ReloadDashboardEvent::class, $this->event);
        $this->assertNotNull($this->event->id());
        $this->assertNotNull($this->event->onDate());
    }

    public function testDatePublish()
    {
        $this->assertNull($this->event->onDatePublish());
        $this->event->setDatePublish();
        $this->assertNotNull($this->event->onDatePublish());
    }

    public function testCanPublish()
    {
        $this->assertTrue($this->event->canPublish());
    }

    public function testChannelAndMessage()
    {
        $this->assertSame('reload', $this->event->message());
        $this->assertSame('event:dashboard', $this->event->nameEvent());
    }
}
