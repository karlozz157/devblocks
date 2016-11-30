<?php

namespace Application\Form;

use Application\Manager\Manager;
use Zend\InputFilter\InputFilter;

class ExamForm extends AbstractForm
{
    /**.
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
                    'label' => 'Name'
                ],
            ])
            ->add([
                'name' => 'subject',
                'type' => 'Select',
                'attributes' => [
                    'options' => $this->getSubjectOptions(),
                    'class'   => 'form-control',
                ],
                'options' => [
                    'label' => 'Subject',
                ]
            ])
            ->add([
                'name' => 'questions',
                'type' => 'Select',
                'attributes' => [
                    'options'  => $this->getQuestionsOptions(),
                    'class'    => 'form-control',
                    'multiple' => true,
                ],
                'options' => [
                    'label' => 'Questions'
                ]
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
     * @return mixed
     */
    protected function getSubjectOptions()
    {
        $subjects = $this->manager->findAll('Application\\Entity\\Subject');
        $data     = [];

        foreach ($subjects as $subject) {
            $data[$subject->getId()] = $subject->getName();
        }

        return $data;
    }

    /**
     * @return array
     */
    protected function getQuestionsOptions()
    {
        $questions = $this->manager->findAll('Application\\Entity\\Question');
        $data     = [];

        foreach ($questions as $question) {
            $data[$question->getId()] = $question->getName();
        }

        return $data;
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