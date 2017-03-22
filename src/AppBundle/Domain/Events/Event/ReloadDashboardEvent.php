<?php

namespace AppBundle\Domain\Events\Event;

/**
 * Class ReloadDashboard.
 */
class ReloadDashboardEvent extends BaseEvent
{
    /**
     * @return mixed
     */
    public function nameEvent()
    {
        return 'event:dashboard';
    }

    /**
     * @return int
     */
    public function message()
    {
        return 'reload';
    }

    /**
     * @return bool
     */
    public function canPublish()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function canPersist()
    {
        return false;
    }
}
