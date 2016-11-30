<?php

namespace Application\Controller;

class ExamController extends CrudController
{
    /**
     * @return array
     */
    public function detailAction()
    {
        $id     = $this->params()->fromRoute('id');
        $detail = $this->getService('manager')->findById($this->entityClass, $id);

        return ['detail' => $detail];
    }
}
