<?php

namespace Application\Form;

use Application\Manager\Manager;
use Zend\InputFilter\InputFilter;

class AnswerForm extends AbstractForm
{
    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager = null)
    {
        parent::__construct($manager);

        $this
            ->add([
                'name' => 'text',
                'type' => 'Text',
                'attributes' => [
                    'class' => 'form-control',
                ],
                'options' => [
                    'label' => 'Answer',
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
                'name'     => 'text',
                'required' => true
            ]);

        $this->filter = $inputFilter;
    }
}