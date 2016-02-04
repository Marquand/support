<?php

namespace PointWeb\GalleryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PointWeb\AdminBundle\Entity\File;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="PointWeb\GalleryBundle\Entity\GalleryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Gallery
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",  nullable=true)
     */
    private $description;

    /**
     *
     * @ORM\ManyToMany(targetEntity="PointWeb\AdminBundle\Entity\File", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="gallery_file",
     *      joinColumns={@ORM\JoinColumn(name="gallery_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    public $pictures;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

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
        $this->pictures = new ArrayCollection();
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
     * @return Gallery
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
     * Set description
     *
     * @param string $description
     * @return Gallery
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add Pictures
     *
     * @param File $picture
     * @return Gallery
     */
    public function addPicture(File $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    public function removePicture(File $picture)
    {
        $this->pictures->removeElement($picture);
    }

    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Gallery
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
     * @return Gallery
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

    /**
     * Set position
     *
     * @param integer $position
     * @return Gallery
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
}
