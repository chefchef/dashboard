<?php

namespace AppBundle\Application\Users\UseCases;

/**
 * Class ResponseBase.
 */
class ResponseBase
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var
     */
    protected $errors = [];

    /**
     * @param $error
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
