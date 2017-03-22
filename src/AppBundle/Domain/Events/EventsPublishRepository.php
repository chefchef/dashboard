<?php

namespace AppBundle\Domain\Events;

/**
 * Class RedisEventsRepository.
 */
interface EventsPublishRepository
{
    /**
     * @param DomainEvent $event
     *
     * @return mixed
     */
    public function exists(DomainEvent $event);

    /**
     * @param DomainEvent $event
     *
     * @return mixed
     */
    public function persist(DomainEvent $event);

    /**
     * @param DomainEvent $event
     */
    public function publish(DomainEvent $event);
}
