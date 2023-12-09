<?php

namespace App\Services;

use Pusher\Pusher;

class PusherService
{
    private $pusher;

    public function __construct()
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => false,
        );
        $this->pusher = new Pusher(
            'ba94d855ff15be911df8',
            'c3de087ec918e4c5be04',
            '1721508',
            $options
        );
    }

    public function getPusher(): Pusher
    {
        return $this->pusher;
    }
}
