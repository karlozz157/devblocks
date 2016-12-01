<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Symfony\Component\Console\Application;

class Module
{
    const VERSION = '3.0.2dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'manager' => function($sm) {
                    return new \Application\Manager\Manager($sm->get('Doctrine\ORM\EntityManager'));
                },
                'auth_service' => function($sm) {
                    $authService = $sm->get('doctrine.authenticationservice.orm_default');

                    $adapter = $authService
                        ->getAdapter()
                        ->setOptions([
                            'object_manager'      => 'Doctrine\ORM\EntityManager',
                            'object_repository'   => $sm->get('manager')->getRepository('Application\Entity\User'),
                            'identity_class'      => 'Application\Entity\User',
                            'identity_property'   => 'email',
                            'credential_property' => 'password',
                        ]);

                    return $adapter;
                }
            ],
        ];
    }
}
