<?php

namespace Domain\FixturesEngine;

class ReferenceRepository
{
    /**
     * @var array
     */
    private $repo;

    public function __construct()
    {
        $this->repo = [];
    }

    /**
     * @param string $identifier
     * @param mixed $value
     */
    public function addReference($identifier, $value)
    {
        $this->repo[$identifier] = $value;
    }

    /**
     * @param string $identifier
     * @return mixed
     */
    public function getReference($identifier)
    {
        return $this->repo[$identifier];
    }
}
