<?php

namespace AppBundle\Entity;

use Domain\EventEngine\Aggregate;

interface FromAggregate
{
    /**
     * @param Aggregate $aggregate
     * @return FromAggregate
     */
    public static function createFromDomainObject(Aggregate $aggregate);
}
