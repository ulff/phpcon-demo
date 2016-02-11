<?php

namespace Infrastructure\ODM;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Domain\EventEngine\AggregateId;
use Domain\ReadModel\ProjectionStorage;
use Domain\ReadModel\Projection;
use Infrastructure\ODM\Document\StoredProjection;

class ODMProjectionStorage implements ProjectionStorage
{
    /**
     * @var DocumentManager
     */
    private $manager;

    /**
     * @var DocumentRepository
     */
    private $repository;

    public function __construct(DocumentManager $manager, ManagerRegistry $managerRegistry)
    {
        $this->manager = $manager;
        $this->repository = $managerRegistry->getRepository('\Infrastructure\ODM\Document\StoredProjection');
    }

    /**
     * @param Projection $projection
     */
    public function save(Projection $projection)
    {
        $storedProjection = new StoredProjection($projection->getProjectionName(), $projection->getAggregateId(), $projection);
        $this->manager->persist($storedProjection);
        $this->manager->flush();
    }

    /**
     * @param Projection $projection
     */
    public function remove(Projection $projection)
    {
        $storedProjection = $this->repository->find($projection->getProjectionName() . '_' . $projection->getAggregateId());
        if(!empty($storedProjection)) {
            $this->manager->remove($storedProjection);
            $this->manager->flush();
        }
    }

    /**
     * @param $projectionName
     * @return Projection[]
     */
    public function find($projectionName)
    {
        $projections = [];
        /** @var $storedProjection StoredProjection */
        $storedProjections = $this->repository->findBy(['projectionName' => (string) $projectionName]);
        foreach ($storedProjections as $storedProjection) {
            $projections[] = $storedProjection->getProjection();
        }

        return $projections;
    }

    /**
     * @param $projectionName
     * @param AggregateId $aggregateId
     * @return Projection
     */
    public function findById($projectionName, AggregateId $aggregateId)
    {
        $storedProjection = $this->repository->findOneBy([
            'projectionName' => (string) $projectionName,
            'aggregateId' => (string) $aggregateId
        ]);

        return empty($storedProjection) ? null : $storedProjection->getProjection();
    }
}
