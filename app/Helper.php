<?php

use App\IpProviders\IpProvider;
use App\JobLog;
use App\Jobs\{GetIspname, GetFibonacciSequence};
use App\Misc\TaskStatus;
use App\Misc\TaskType;

if (!function_exists('fibonacci')) {
    function fibonacci($num) // $num - номер интересующего нас элемента
    {
        $result = [];

        if ($num < 1) {
            return $result;
        }

        for ($i = 1; $i <= $num; $i++) {

            if ($i <= 2) {
                $result[] = $i - 1;
                continue;
            }

            $result[] = $result[$i - 3] + $result[$i - 2];
        }
        return $result;
    }
}

if (!function_exists('generateTask')) {
    function generateTask($type = TaskType::ISPNAME, $data)
    {
        $result = 0;

        switch ($type) {
            case TaskType::ISPNAME:
                $ip = $data['ip'] ?? "";
                $result = app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch((new GetIspname(app(IpProvider::class), $ip))->delay(10));
                break;
            case TaskType::FIBONACCI:
                $number = $data['int'] ?? -1;
                $result = app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch((new GetFibonacciSequence($number))->delay(10));
                break;
        }

        if (!empty($result)) {
            JobLog::create([
                'id' => $result,
                'type' => $type,
                'status' => TaskStatus::PENDING
            ]);
        }

        return $result;
    }
}
