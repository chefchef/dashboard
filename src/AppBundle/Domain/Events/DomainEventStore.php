<?php

namespace AppBundle\Domain\Events;

/**
 * Class DomainEventStore.
 */
interface DomainEventStore
{
    /**
     * DomainEventStore constructor.
     *
     * @param EventsPublishRepository $publishRepository
     */
    public function __construct(EventsPublishRepository $publishRepository);

    /**
     * @param DomainEvent $event
     */
    public function addEvent(DomainEvent $event);

    public function persist();

    public function publish();
}
