<?php

namespace AppBundle\Infrastructure\Repository\WidgetInstanceData;

use AppBundle\Domain\WidgetInstancesData\WidgetInstanceDataRepository;
use Redis;

/**
 * Class RedisWidgetInstanceDataRepository.
 */
class RedisWidgetInstanceDataRepository implements WidgetInstanceDataRepository
{
    /**
     * @var Redis
     */
    private $conn;

    /**
     * @param $conn
     *
     * @return mixed
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param $idWidgetInstance
     * @param $data
     *
     * @return int
     */
    public function create($idWidgetInstance, $data)
    {
        $key = $this->generateKey();
        $hashKey = $this->generateHashKey($idWidgetInstance);

        return $this->conn->set($key.$hashKey, serialize($data));
    }

    /**
     * @param $idWidgetInstance
     *
     * @return mixed
     */
    public function fetch($idWidgetInstance)
    {
        $key = $this->generateKey();
        $hashKey = $this->generateHashKey($idWidgetInstance);

        $res = $this->conn->get($key.$hashKey);

        if (null !== $res) {
            return unserialize($res);
        }

        return;
    }

    /**
     * @return string
     */
    protected function generateKey()
    {
        return 'widgetInstance:data';
    }

    /**
     * @param $idWidgetInstance
     *
     * @return mixed
     */
    private function generateHashKey($idWidgetInstance)
    {
        return $idWidgetInstance;
    }
}
