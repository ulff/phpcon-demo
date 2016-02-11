<?php

namespace Domain\ReadModel;

class ProjectionPopulatorStats
{
    /**
     * @var int
     */
    private $removedProjectionsCounter;

    /**
     * @var int
     */
    private $processedEventsCounter;

    /**
     * @var int
     */
    private $totalEventsCounter;

    /**
     * @var int
     */
    private $populatedProjectionsCounter;

    public function __construct()
    {
        $this->removedProjectionsCounter = 0;
        $this->populatedProjectionsCounter = 0;
        $this->processedEventsCounter = 0;
        $this->totalEventsCounter = 0;
    }

    public function increaseRemoved()
    {
        ++$this->removedProjectionsCounter;
    }

    public function increaseProcessedEvents()
    {
        ++$this->processedEventsCounter;
    }

    public function increaseTotalEvents()
    {
        ++$this->totalEventsCounter;
    }

    /**
     * @param int $number
     */
    public function setPopulatedProjections($number)
    {
        $this->populatedProjectionsCounter = $number;
    }

    /**
     * @return int
     */
    public function getRemoved()
    {
        return $this->removedProjectionsCounter;
    }

    /**
     * @return int
     */
    public function getPopulatedProjections()
    {
        return $this->populatedProjectionsCounter;
    }

    /**
     * @return int
     */
    public function getProcessedEvents()
    {
        return $this->processedEventsCounter;
    }

    /**
     * @return int
     */
    public function getTotalEvents()
    {
        return $this->totalEventsCounter;
    }
}
