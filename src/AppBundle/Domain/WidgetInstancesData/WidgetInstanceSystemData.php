<?php

namespace AppBundle\Domain\WidgetInstancesData;

/**
 * Class WidgetInstanceSystemData.
 */
class WidgetInstanceSystemData implements WidgetInstanceDataEntity
{
    const SLEEP_TIME_IN_SECODS = 3;

    protected $idWidgetInstance;

    protected $idleStatus = [
        80 => self::NORMAL_LEVEL,
        40 => self::WARNING_LEVEL,
        0 => self::ERROR_LEVEL,
    ];

    /**
     * @return mixed
     */
    public function generateData()
    {
        $cpuInfo = $this->getInfoCpu();

        $idle = 100 - $cpuInfo['user'] - $cpuInfo['sys'];

        return [
            'data' => [
                'user' => $cpuInfo['user'],
                'sys' => $cpuInfo['sys'],
                'idle' => $idle,
            ],
            'status' => [
                $this->status($idle),
            ],
            'refresh' => 4,
        ];
    }

    /**
     * @param $idle
     *
     * @return mixed
     */
    private function status($idle)
    {
        foreach ($this->idleStatus as $percentage => $status) {
            if ($percentage < $idle) {
                return $status;
            }
        }

        return self::ERROR_LEVEL;
    }

    /**
     * @return array
     */
    private function getInfoCpu()
    {
        $stat1 = file('/proc/stat');
        clearstatcache();
        sleep(self::SLEEP_TIME_IN_SECODS);
        $stat2 = file('/proc/stat');
        clearstatcache();
        $info1 = explode(' ', preg_replace('!cpu +!', '', $stat1[0]));
        $info2 = explode(' ', preg_replace('!cpu +!', '', $stat2[0]));
        $dif = [];
        $dif['user'] = $info2[0] - $info1[0];
        $dif['nice'] = $info2[1] - $info1[1];
        $dif['sys'] = $info2[2] - $info1[2];
        $dif['idle'] = $info2[3] - $info1[3];
        $total = array_sum($dif);

        $cpu = [];
        foreach ($dif as $x => $y) {
            $cpu[$x] = round($y / $total * 100, 1);
        }

        return $cpu;
    }
}
