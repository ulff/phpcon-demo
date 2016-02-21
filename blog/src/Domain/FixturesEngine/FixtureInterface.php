<?php

namespace Domain\FixturesEngine;

interface FixtureInterface
{
    /**
     * @param ReferenceRepository $referenceRepository
     */
    public function load(ReferenceRepository $referenceRepository);

    /**
     * @return int
     */
    public function getOrder();
}
