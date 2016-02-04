<?php

namespace PointWeb\GuestBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GuestBook
 *
 * @ORM\Table(name="guest_book")
 * @ORM\Entity(repositoryClass="PointWeb\GuestBookBundle\Entity\GuestBookRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GuestBook
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Ce champs ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Ce champs ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="notation", type="integer", nullable=true)
     */
    private $notation;

    /**
     * @var integer
     * @Assert\Range(min = "0")
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online", type="boolean")
     */
    private $online;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas un email valide.",
     *     checkMX = true
     * )
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="date")
     */
    private $updateDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="date")
     */
    private $createDate;

    public function __construct()
    {
        //Je déclare le online à false
        return $this->online = false;
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
     * Set lastname
     *
     * @param string $lastname
     * @return GuestBook
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return GuestBook
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return GuestBook
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set notation
     *
     * @param integer $notation
     * @return GuestBook
     */
    public function setNotation($notation)
    {
        $this->notation = $notation;

        return $this;
    }

    /**
     * Get notation
     *
     * @return integer
     */
    public function getNotation()
    {
        return $this->notation;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return GuestBook
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set online
     *
     * @param boolean $online
     * @return GuestBook
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return boolean
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return GuestBook
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return GuestBook
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return GuestBook
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        if (null == $this->createDate) {
            $this->createDate = new \DateTime();
        }
        $this->updateDate = new \DateTime();
    }
}
