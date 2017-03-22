<?php

namespace AppBundle\Application\WidgetsInstance\UseCases;

use AppBundle\Domain\Core\BaseResponse;

/**
 * Class UpdateWidgetToDashboardResponse.
 */
class UpdateWidgetToDashboardResponse extends BaseResponse
{
    protected $status;
    /**
     * @return mixed
     */
    public function toArray()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
