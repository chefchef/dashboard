<?php

namespace AppBundle\Domain\WidgetInstancesData;

/**
 * Class WidgetInstanceSystemData.
 */
class WidgetInstanceSystemMemoryData implements WidgetInstanceDataEntity
{
    protected $idWidgetInstance;

    protected $freeMemory = [
        80 => self::NORMAL_LEVEL,
        40 => self::WARNING_LEVEL,
        0 => self::ERROR_LEVEL,
    ];

    /**
     * @return mixed
     */
    public function generateData()
    {
        $memory = $this->memory();

        return [
            'data' => [
                'free' => $memory['free'],
                'other' => $memory['other'],
                'used' => $memory['used'],
            ],
            'status' => [
                $this->status($memory['free'] + $memory['other']),
            ],
            'refresh' => 5,
        ];
    }

    /**
     * @param $memoryUnused
     *
     * @return string
     */
    private function status($memoryUnused)
    {
        foreach ($this->freeMemory as $percentage => $status) {
            if ($percentage < $memoryUnused) {
                return $status;
            }
        }

        return self::ERROR_LEVEL;
    }

    /**
     * @return array
     */
    private function memory()
    {
        $memory = [];

        exec('free -mo', $out);

        preg_match_all('/\s+([0-9]+)/', $out[1], $matches);
        list($total, , $free, $shared, $buffers) = $matches[1];

        $memory['free'] = floor(($free / $total) * 100);
        $memory['other'] = floor((($buffers + $shared) / $total) * 100);
        $memory['used'] = 99 - $memory['free'] - $memory['other'];

        return $memory;
    }
}
