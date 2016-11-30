<?php

namespace Application\Controller;

use Application\Entity\Entity;
use Application\Manager\Manager;
use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

class CrudController extends AbstractActionController
{
    /**
     * @var string $action
     */
    protected $action = 'index';

    /**
     * @var string $class
     */
    protected $class;

    /**
     * @var string $entityClass
     */
    protected $entityClass;

    /**
     * @var string $formClass
     */
    protected $formClass;

    /**
     * @var string $route
     */
    protected $route;

    public function __construct()
    {
        $class = str_replace('Controller', '', get_class($this));
        $this->class = end(explode('\\', $class));
        $this->route = strtolower($this->class);
        $this->entityClass = 'Application\\Entity\\' . $this->class;
        $this->formClass = sprintf('Application\\Form\\%sForm', $this->class);
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $criteria = [];
        $parent   = null;
        $parentId = $this->params()->fromRoute('id');

        /** @var Entity $entity */
        $entity = new $this->entityClass();

        /** @var Manager $manager */
        $manager = $this->getService('manager');

        if ($parentId && $entity->getParent()) {
            $parent    = $manager->findById($entity->getParent(), $parentId);
            $parentKey = end(explode('\\', $entity->getParent()));
            $criteria  = [strtolower($parentKey) => $parent->getId()];
        }

        return ['results' => $manager->findAll($this->entityClass, $criteria), 'parent' => $parent];
    }

    /**
     * @return array
     */
    public function newAction()
    {
        $parent   = null;
        $parentId = $this->params()->fromRoute('id');

        /** @var Manager $manager */
        $manager = $this->getService('manager');

        /** @var Entity $entity */
        $entity = new $this->entityClass();
        $entity->setManager($manager);

        if ($parentId && $entity->getParent()) {
            $parent = $manager->findById($entity->getParent(), $parentId);
            $entity->setParent($parent);
        }

        /** @var Form $form */
        $form = new $this->formClass($manager);

        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $entity->exchangeArray($form->getData());
                $manager->persist($entity);

                return $this->redirect()->toRoute($this->route, ['action' => $this->action, 'id' => $parentId]);
            }
        }

        return ['form' => $form, 'parent' => $parent];
    }

    /**
     * @return array
     */
    public function editAction()
    {
        $id       = $this->params()->fromRoute('id');
        $parent   = null;
        $parentId = null;

        /** @var Request $request */
        $request = $this->getRequest();

        /** @var Manager $manager */
        $manager = $this->getService('manager');

        /** @var Entity $entity */
        $entity = $this->getService('manager')->findById($this->entityClass, $id);
        $entity->setManager($manager);

        if ($entity->getParent()) {
            $parent   = $entity->getParent();
            $parentId = $parent->getId();
        }

        /** @var Form $form */
        $form = new $this->formClass($manager);
        $form->bind($entity);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $manager->persist($form->getData());

                return $this->redirect()->toRoute($this->route, ['action' => $this->action, 'id' => $parentId]);
            }
        }

        return ['form' => $form, 'parent' => $parent];
    }

    /**
     * @return array
     */
    public function deleteAction()
    {
        $id     = $this->params()->fromRoute('id');
        $parent = null;

        /** @var Manager $manager */
        $manager = $this->getService('manager');
        $entity  = $manager->findById($this->entityClass, $id);

        if ($entity->getParent()) {
            $parent = $entity->getParent()->getId();
        }

        $manager->remove($entity);

        return $this->redirect()->toRoute($this->route, ['action' => $this->action, 'id' => $parent]);
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    protected function getService($id)
    {
        return $this->getPluginManager()->getServiceLocator()->get($id);
    }
}
