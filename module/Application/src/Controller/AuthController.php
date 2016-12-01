<?php

namespace Application\Controller;

use Application\Form\UserForm;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineModule\Authentication\Adapter\ObjectRepository;


class AuthController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $form = new UserForm();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                /** ObjectRepository $authService */
                $authService = $this->getService('auth_service');

                /** @var Result $authResult */
                $authResult = $authService
                    ->setIdentity($request->getPost('email'))
                    ->setCredential($request->getPost('password'))
                    ->authenticate();

                if ($authResult->isValid()) {
                    // open the session
                }
            }
        }

        return ['form' => $form];
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    protected function getService($id)
    {
        return $this->getPluginManager()->getServiceLocator()->get($id);
    }
}
