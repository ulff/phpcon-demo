<?php

namespace Domain\EventEngine;

interface AggregateId 
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return AggregateId
     */
    public static function generate();
}
