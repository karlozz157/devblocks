<?php

namespace Application\Form;

use Application\Manager\Manager;
use Zend\InputFilter\InputFilter;

class UserForm extends AbstractForm
{
    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager = null)
    {
        parent::__construct($manager);

        $this
            ->add([
                'name' => 'email',
                'type' => 'Email',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options' => [
                    'label' => 'Email',
                ],
            ])
            ->add([
                'name' => 'password',
                'type' => 'Password',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options' => [
                    'label' => 'Password',
                ]
            ])
            ->add([
                'name' => 'submit',
                'type' => 'Submit',
                'attributes' => [
                    'value' => 'Login',
                    'class' => 'btn btn-primary btn-sm'
                ],
            ]);
    }

    /**
     * @return void
     */
    protected function constraints()
    {
        $inputFilter = new InputFilter();
        $inputFilter
            ->add([
                'name'     => 'email',
                'required' => true
            ])
            ->add([
                'name'     => 'password',
                'required' => true,
            ]);

        $this->filter = $inputFilter;
    }
}