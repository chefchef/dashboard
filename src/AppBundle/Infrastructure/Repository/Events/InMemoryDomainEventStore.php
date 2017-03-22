<?php

namespace AppBundle\Infrastructure\Repository\Events;

use AppBundle\Domain\Events\DomainEvent;
use AppBundle\Domain\Events\DomainEventStore;
use AppBundle\Domain\Events\EventsPublishRepository;

/**
 * Class DomainEventStore.
 */
class InMemoryDomainEventStore implements DomainEventStore
{
    /**
     * @var EventsPublishRepository
     */
    protected $publishRepository;
    /**
     * @var DomainEvent[]
     */
    private $events = [];

    /**
     * DomainEventStore constructor.
     *
     * @param EventsPublishRepository $publishRepository
     */
    public function __construct(EventsPublishRepository $publishRepository)
    {
        $this->publishRepository = $publishRepository;
    }

    /**
     * @param DomainEvent $event
     */
    public function addEvent(DomainEvent $event)
    {
        $this->events[$event->id()] = $event;
    }

    public function persist()
    {
        foreach ($this->events as $event) {
            if ($event->canPersist() && null === $event->onDatePersist()) {
                if ($this->publishRepository->exists($event)) {
                    $event->setDatePublish();
                    continue;   // no persist, no publish
                }

                $res = $this->publishRepository->persist($event);
                if ($res) {
                    $event->setDatePersist();
                }
            }
        }
    }
    public function publish()
    {
        foreach ($this->events as $event) {
            if ($event->canPublish() && null === $event->onDatePublish()) {
                $res = $this->publishRepository->publish($event);

                if ($res) {
                    $event->setDatePublish();
                }
            }
        }
    }
}
