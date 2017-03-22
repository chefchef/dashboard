<?php

namespace AppBundle\Application\Dashboards\UseCases;

use AppBundle\Domain\Core\BaseResponse;

/**
 * Class AddWidgetToDashboardResponse.
 */
class AddWidgetToDashboardResponse extends BaseResponse
{
    protected $status;
    /**
     * @return mixed
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
