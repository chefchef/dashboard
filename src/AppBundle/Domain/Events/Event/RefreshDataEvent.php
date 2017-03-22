<?php

namespace AppBundle\Domain\Events\Event;

/**
 * Class RefreshDataEvent.
 */
class RefreshDataEvent extends BaseEvent
{
    /**
     * @return mixed
     */
    public function nameEvent()
    {
        return 'event:widgetdata';
    }

    /**
     * @return int
     */
    public function message()
    {
        return $this->data()['idInstanceWidget'];
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
        return false;
    }
}
