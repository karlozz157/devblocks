<?php

namespace Application\Form;

use Application\Manager\Manager;
use Zend\InputFilter\InputFilter;

 class QuestionForm extends AbstractForm
{
     /**
      * @param Manager $manager
      */
    public function __construct(Manager $manager = null)
    {
        parent::__construct($manager);

        $this
        ->add([
            'name' => 'name',
            'type' => 'Text',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Question',
            ],
        ])
        ->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Save',
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
                'name'     => 'name',
                'required' => true
            ]);

        $this->filter = $inputFilter;
    }
}
