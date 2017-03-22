<?php

namespace AppBundle\Domain\Core;

/**
 * Class ListDashboardsResponse.
 */
abstract class BaseResponse
{
    public $data;

    public $message;

    public $tpl;

    abstract public function toArray();

    /**
     * @return int
     */
    public function status()
    {
        if (null !== $this->message) {
            return 500;
        }

        if ((null === $this->data) || (false === $this->data)) {
            return 404;
        }

        return 200;
    }

    /**
     * @param $tpl
     */
    public function addTpl($tpl)
    {
        $this->tpl = $tpl;
    }
}
