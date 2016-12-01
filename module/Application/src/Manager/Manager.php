<?php

namespace Application\Manager;

use Application\Entity\Entity;
use Doctrine\ORM\EntityManager;

class Manager
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $entity
     * @param $id
     *
     * @return null|object
     */
    public function findById($entity, $id)
    {
        return $this->entityManager->getRepository($entity)->findOneBy(['id' => $id]);
    }

    /**
     * @param string $entity
     * @param array  $criteria
     *
     * @return array
     */
    public function findAll($entity, array $criteria = [])
    {
        return $this->entityManager->getRepository($entity)->findBy($criteria);
    }

    /**
     * @param Entity $entity
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param Entity $entity
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $entity
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($entity)
    {
        return $this->entityManager->getRepository($entity);
    }

    /**
     * @param string $entity
     * @param int $id
     *
     * @return object
     */
    public function getReference($entity, $id)
    {
        return $this->entityManager->getReference($entity, $id);
    }
}
