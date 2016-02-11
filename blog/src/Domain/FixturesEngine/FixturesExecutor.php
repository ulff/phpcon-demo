<?php

namespace Domain\FixturesEngine;

use Domain\EventEngine\EventBus;
use Domain\EventEngine\EventStorage;
use Domain\ReadModel\ProjectionStorage;
use Domain\FixturesEngine\Data as Data;

class FixturesExecutor
{
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var EventStorage
     */
    private $eventStorage;

    /**
     * @var ProjectionStorage
     */
    private $projectionStorage;

    /**
     * @var ReferenceRepository
     */
    private $referenceRepository;

    /**
     * @var FixtureInterface[]
     */
    private $orderedFixtures;

    /**
     * @var boolean
     */
    private $forced;

    public function __construct(EventBus $eventBus, EventStorage $eventStorage, ProjectionStorage $projectionStorage)
    {
        $this->eventBus = $eventBus;
        $this->eventStorage = $eventStorage;
        $this->projectionStorage = $projectionStorage;
        $this->referenceRepository = new ReferenceRepository();
        $this->orderedFixtures = [];
        $this->forced = false;
    }

    public function run()
    {
        $this->checkEventStorage();
        $this->fetchFixtures();
        $this->sortFixtures();
        $this->execFixtures();
    }

    public function force()
    {
        $this->forced = true;
    }

    private function checkEventStorage()
    {
        if($this->forced === true) {
            return;
        }

        $storedEvents = $this->eventStorage->getAll();
        foreach($storedEvents as $storedEvent) {
            if (get_class($storedEvent) != 'Domain\EventModel\Event\ThemeWasCreated') {
                throw new EventStorageNotEmptyException();
            }
        }
    }

    private function fetchFixtures()
    {
        foreach (new \DirectoryIterator(__DIR__ . '/Data/') as $fileInfo) {
            if($fileInfo->getExtension() == 'php') {
                $className = 'Domain\\FixturesEngine\\Data\\' . basename($fileInfo->getFilename(), '.php');
                if(class_exists($className) && in_array('Domain\FixturesEngine\FixtureInterface', class_implements($className))) {
                    $this->orderedFixtures[] = new $className($this->eventBus, $this->eventStorage, $this->projectionStorage);
                }
            }
        }
    }

    private function sortFixtures()
    {
        uasort($this->orderedFixtures, function($a, $b) {
            return ($a->getOrder() < $b->getOrder()) ? -1 : 1;
        });
    }

    private function execFixtures()
    {
        foreach($this->orderedFixtures as $fixture) {
            $fixture->load($this->referenceRepository);
        }
    }
}
