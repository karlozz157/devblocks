<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="answers")
 */
class Answer extends Entity
{
    /**
     * @var int $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Question $question
     *
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;

    /**
     * @var string $text
     *
     * @ORM\Column(type="string")
     */
    protected $text;

    /**
     * @var boolean $correct
     *
     * @ORM\Column(type="boolean")
     */
    protected $correct = false;

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Answer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Answer
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set question
     *
     * @param \Application\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\Application\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Application\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @return bool
     */
    public function isCorrect()
    {
        return $this->correct;
    }

    /**
     * @param boolean $correct
     *
     * @return $this
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * @param $parent
     */
    public function setParent($parent)
    {
        $this->question = $parent;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return $this->question ? $this->question : 'Application\\Entity\\Question';
    }
}
