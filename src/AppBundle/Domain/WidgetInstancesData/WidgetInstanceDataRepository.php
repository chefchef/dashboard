<?php

namespace AppBundle\Domain\WidgetInstancesData;

/**
 * Interface WidgetInstanceRepository.
 */
interface WidgetInstanceDataRepository
{
    /**
     * @param $idWidgetInstance
     * @param $data
     *
     * @return mixed
     */
    public function create($idWidgetInstance, $data);

    /**
     * @param $idWidgetInstance
     *
     * @return mixed
     */
    public function fetch($idWidgetInstance);
}
