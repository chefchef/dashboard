<?php

namespace AppBundle\Domain\Events;

/**
 * Interface DomainEvent.
 */
interface DomainEvent
{
    /**
     * @return string
     */
    public function nameEvent();

    /**
     * @return mixed
     */
    public function message();

    /**
     * @return mixed
     */
    public function onDate();

    /**
     * @return mixed
     */
    public function onDatePersist();

    /**
     * @return mixed
     */
    public function setDatePersist();

    /**
     * @return mixed
     */
    public function onDatePublish();

    public function setDatePublish();

    public function canPublish();

    public function canPersist();

    public function expirePersist();

    public function id();

    public function data();
}
