<?php

namespace AppBundle\Domain\Core;

/**
 * Interface UseCase.
 */
interface UseCase
{
    /**
     * @param BaseRequest $request
     *
     * @return mixed
     */
    public function validation(BaseRequest $request);

    /**
     * @param BaseRequest $request
     *
     * @return mixed
     */
    public function initRepository(BaseRequest $request);
}
