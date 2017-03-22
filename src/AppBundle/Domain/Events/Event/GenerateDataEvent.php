<?php

namespace AppBundle\Domain\Events\Event;

/**
 * Class RefreshDataEvent.
 */
class GenerateDataEvent extends BaseEvent
{
    /**
     * @return mixed
     */
    public function nameEvent()
    {
        return 'event:generatedata';
    }

    /**
     * @return int
     */
    public function message()
    {
        return $this->data()['idDashboard'].':'.$this->data()['idInstanceWidget'].':'.$this->data()['expire'];
    }

    /**
     * @return bool
     */
    public function canPublish()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function canPersist()
    {
        return true;
    }

    /**
     * @return int
     */
    public function expirePersist()
    {
        return $this->data()['expire'];
    }
}
