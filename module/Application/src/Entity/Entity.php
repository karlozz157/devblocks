<?php

namespace Application\Entity;

use Application\Manager\Manager;

abstract class Entity
{
    /**
     * @var array $entities
     */
    protected $entities = [];

    /**
     * @var Manager $manager
     */
    protected $manager;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager = null)
    {
        $this->manager = $manager;
    }

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        $properties = array_keys(get_object_vars($this));

        foreach ($data as $property => $value) {
            if (!in_array($property, $properties)) {
                continue;
            }

            if (in_array($property, array_keys($this->entities))) {
                $class = $this->entities[$property];

                if (!is_array($value)) {
                    $entityNewValue = $this->manager->getReference($class, $value);
     
                    if ($this->$property->getId() !== $entityNewValue->getId()) {
                        $this->$property = $entityNewValue;
                    }
                } else {
                    foreach ($value as $val) {
                        $idsSaved = [];

                        foreach ($this->$property as $entity) {
                            $idsSaved[] = $entity->getId();
                        }

                        $newEntity = $this->manager->getReference($class, $val);

                        if (!in_array($newEntity->getId(), $idsSaved)) {
                            $this->$property[] = $newEntity;
                        }
                    }
                }

                continue;
            }

            $this->$property = $value;
        }
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $objectVars = get_object_vars($this);
        $data = [];

        foreach ($objectVars as $property => $value) {
            if ($value instanceof \Doctrine\ORM\PersistentCollection) {
                $ids = [];

                foreach ($value as $entity) {
                    $ids[] = $entity->getId();
                }

                $data[$property] = $ids;

                continue;
            }

            $data[$property] = $value;
        }

        return $data;
    }

    /**
     * @param $parent
     */
    public function setParent($parent)
    {
        // override
    }

    /**
     * @return null
     */
    public function getParent()
    {
        return null;
    }

    /**
     * @param Manager $manager
     */
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
    }
}
