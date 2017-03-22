<?php

namespace AppBundle\Domain\Events\Traits;

use AppBundle\Domain\Core\BaseResponse;
use AppBundle\Domain\Events\DomainEventStore;
use AppBundle\Domain\Events\Event\GenerateDataEvent;
use AppBundle\Domain\Events\Event\RefreshDataEvent;
use AppBundle\Domain\Events\Event\ReloadDashboardEvent;

/**
 * Class EventsController.
 */
trait EventsHelper
{
    /**
     * @param BaseResponse $response
     */
    protected function eventReload(BaseResponse $response)
    {
        if ($response->status() === 200) {
            /*
             * @var DomainEventStore
             */
            $eventStore = $this->get('app.infrastructure_repository_events.in_memory_domain_event_store');
            $eventStore->addEvent(ReloadDashboardEvent::create());
            $eventStore->publish();
        }
    }

    /**
     * @param BaseResponse $response
     * @param $idWidgetInstance
     */
    protected function eventRefreshData(BaseResponse $response, $idWidgetInstance)
    {
        if ($response->status() === 200) {
            $data = [
                'idInstanceWidget' => $idWidgetInstance,
            ];

            /*
             * @var DomainEventStore
             */
            $eventStore = $this->get('app.infrastructure_repository_events.in_memory_domain_event_store');
            $eventStore->addEvent(RefreshDataEvent::create($data));
            $eventStore->publish();
        }
    }

    /**
     * @param BaseResponse $response
     * @param $idDashboard
     * @param $idWidgetInstance
     */
    protected function eventGenerateData(BaseResponse $response, $idDashboard, $idWidgetInstance)
    {
        if (isset($response->data['refresh'])) {
            $refresh = $response->data['refresh'];
        } else {
            $refresh = 5;
        }

        $data = [
            'idDashboard' => $idDashboard,
            'idInstanceWidget' => $idWidgetInstance,
            'expire' => $refresh,
        ];

        /*
         * @var DomainEventStore
         */
        $eventStore = $this->get('app.infrastructure_repository_events.in_memory_domain_event_store');
        $eventStore->addEvent(GenerateDataEvent::create($data));

        $eventStore->persist();
        $eventStore->publish();
    }
}
