<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="exams")
 */
class Exam extends Entity
{
    /**
     * @var array $entities
     */
    protected $entities = [
        'subject'   => 'Application\\Entity\\Subject',
        'questions' => 'Application\\Entity\\Question',
    ];

    /**
     * @var int $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name;
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var \Doctrine\Common\Collections\Collection $user
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="exams_users",
     *      joinColumns={@ORM\JoinColumn(name="exam_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $user;

    /**
     * @var Subject $subject
     *
     * @ORM\ManyToOne(targetEntity="Subject")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    protected $subject;

    /**
     * @var \Doctrine\Common\Collections\Collection $questions
     *
     * @ORM\ManyToMany(targetEntity="Question")
     * @ORM\JoinTable(name="exams_questions",
     *      joinColumns={@ORM\JoinColumn(name="exam_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id", unique=false)}
     * )
     */
    protected $questions;

    /**
     * @var User $owner
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();

        if (!$this->getCreatedAt()) {
            $this->createdAt = new \DateTime('now');
        }
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Exam
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
     * Set name
     *
     * @param string $name
     *
     * @return Exam
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Exam
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add user
     *
     * @param \Application\Entity\User $user
     *
     * @return Exam
     */
    public function addUser(\Application\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Application\Entity\User $user
     */
    public function removeUser(\Application\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set subject
     *
     * @param \Application\Entity\Subject $subject
     *
     * @return Exam
     */
    public function setSubject(\Application\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Application\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Add question
     *
     * @param \Application\Entity\Question $question
     *
     * @return Exam
     */
    public function addQuestion(\Application\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \Application\Entity\Question $question
     */
    public function removeQuestion(\Application\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
