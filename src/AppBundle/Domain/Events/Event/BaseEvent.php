<?php

namespace AppBundle\Domain\Events\Event;

use AppBundle\Domain\Events\DomainEvent;
use Ramsey\Uuid\Uuid;

/**
 * Class BaseEvent.
 */
abstract class BaseEvent implements DomainEvent
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTimeImmutable
     */
    private $dateCreation;

    /**
     * @var array
     */
    private $data;

    /**
     * @var
     */
    private $datePublish;

    /**
     * @var \DateTime
     */
    private $datePersist;

    /**
     * BaseEvent constructor.
     *
     * @param array $data
     */
    private function __construct($data = [])
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->id = Uuid::uuid4()->toString();
        $this->data = $data;
    }

    /**
     * @return string
     */
    abstract public function nameEvent();

    /**
     * @return mixed
     */
    abstract public function message();

    /**
     * @return bool
     */
    abstract public function canPublish();

    /**
     * @return mixed
     */
    abstract public function canPersist();

    /**
     * @param array $data
     *
     * @return static
     */
    public static function create($data = [])
    {
        return new static($data);
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function onDate()
    {
        return $this->dateCreation;
    }

    /**
     * @return mixed
     */
    public function setDatePersist()
    {
        $this->datePersist = new \DateTime();
    }

    /**
     */
    public function onDatePersist()
    {
        return $this->datePersist;
    }

    /**
     *
     */
    public function setDatePublish()
    {
        $this->datePublish = new \DateTime();
    }

    /**
     */
    public function onDatePublish()
    {
        return $this->datePublish;
    }

    /**
     * @return array
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function expirePersist()
    {
        return -1;
    }
}
