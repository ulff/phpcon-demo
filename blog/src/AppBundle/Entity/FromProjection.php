<?php

namespace AppBundle\Entity;

use Domain\ReadModel\Projection;

interface FromProjection
{
    /**
     * @param Projection $projection
     * @return FromProjection
     */
    public static function createFromProjection(Projection $projection);
}
