<?php


namespace App\v1;

class App
{
    public function getLogs($date)
    {
        $logs = new Logs();
        return $logs->get($date);
    }
}