<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin/login',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'subject' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin/subjects[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\SubjectController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'question' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin/questions[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\QuestionController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'answer' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin/answers[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\AnswerController::class,
                        'action'     => 'question',
                    ],
                ],
            ],
            'exam' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin/exams[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\ExamController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class     => InvokableFactory::class,
            Controller\IndexController::class    => InvokableFactory::class,
            Controller\SubjectController::class  => InvokableFactory::class,
            Controller\QuestionController::class => InvokableFactory::class,
            Controller\AnswerController::class   => InvokableFactory::class,
            Controller\ExamController::class     => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'app_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'app_driver'
                ],
            ],
            'authentication' => [
                'orm_default' => [
                    'object_manager'      => 'Doctrine\ORM\EntityManager',
                    'identity_class'      => 'Application\Entity\User',
                    'identity_property'   => 'email',
                    'credential_property' => 'password',
                ],
            ],
        ],
    ],
];
