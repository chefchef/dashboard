<?php

namespace AppBundle\Infrastructure\Repository\Events;

use AppBundle\Domain\Events\DomainEvent;
use AppBundle\Domain\Events\EventsPublishRepository;
use Predis\Client as Redis;

/**
 * Class RedisEventsRepository.
 */
class RedisEventsRepository implements EventsPublishRepository
{
    /**
     * @var Redis
     */
    private $conn;

    /**
     * @param $conn
     *
     * @return mixed
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param DomainEvent $event
     *
     * @return mixed
     */
    public function exists(DomainEvent $event)
    {
        try {
            $res = (bool) $this->conn->get($this->keyPersist($event));
        } catch (\Exception $e) {
            $res = false;
        }

        return $res;
    }

    /**
     * @param DomainEvent $event
     *
     * @return mixed
     */
    public function persist(DomainEvent $event)
    {
        try {
            $res = (bool) $this->conn->set($this->keyPersist($event), $event->message());
            $this->conn->expire($this->keyPersist($event), $event->expirePersist() - 1);
        } catch (\Exception $e) {
            $res = false;
        }

        return $res;
    }

    /**
     * @param DomainEvent $event
     *
     * @return int
     */
    public function publish(DomainEvent $event)
    {
        try {
            $res = (bool) $this->conn->publish($event->nameEvent(), $event->message());
        } catch (\Exception $e) {
            $res = false;
        }

        return $res;
    }

    /**
     * @param DomainEvent $event
     *
     * @return string
     */
    protected function keyPersist(DomainEvent $event)
    {
        return 'event:'.md5($event->nameEvent().serialize($event->data()));
    }
}
