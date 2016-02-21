<?php

namespace Domain\FixturesEngine;

class EventStorageNotEmptyException extends \Exception
{
    public function __construct()
    {
        $this->message = "EventStorage is not empty!";
    }
}
