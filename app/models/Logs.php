<?php


namespace App\v1;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;

class Logs
{
    private $logs;

    public function get($date)
    {
        $client = new Client([
            'base_uri' => 'http://dsdev.tech',
            'timeout' => 60.0
        ]);

        try {
            $response = $client->request('GET', '/logs/' . $date);
        } catch (BadResponseException $e) {
            $response = $e->getCode() . ' ' . $e->getMessage();
        } catch (GuzzleException $e) {
            $response = $e->getCode() . ' ' . $e->getMessage();
        }

        if (gettype($response) === 'string') {
            return $response;
        } else {
//            $code = $response->getStatusCode();
//            $reason = $response->getReasonPhrase();
            $body = json_decode($response->getBody());

            $i = 0;
            foreach ($body->logs as $log) {
                $body->logs[$i]->created_at = date('Y-m-d H:m:s', strtotime($log->created_at));
                $i++;
            }

//            echo '<b>Сортированный</b> <br>';
//            echo '<pre>' . print_r($this->sort($body->logs)) . '</pre>';
//            echo '<b>НЕСортированный</b> <br>';
            return $this->sort($body->logs);
        }
    }

    public function sort($logs)
    {
        $newLogs = $logs;

        usort($newLogs, function ($date1, $date2) {
            return strtotime($date1->created_at) - strtotime($date2->created_at);
        });

        return $newLogs;
    }
}