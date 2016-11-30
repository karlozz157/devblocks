<?php

namespace Application\Form;

use Application\Manager\Manager;
use Zend\Form\Form;

abstract class AbstractForm extends Form
{
    /**
     * @var Manager $manager
     */
    protected $manager;

    public function __construct(Manager $manager = null)
    {
        parent::__construct(null, null);

        $this->manager = $manager;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $this->constraints();

        return parent::isValid();
    }

    /**
     * @return void
     */
    abstract protected function constraints();
}
