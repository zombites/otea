<?php

namespace Zombit\OteaBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;
	
    public function getName()
    {
        return $this->name;
    }
	
	
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * @ORM\ManyToOne(targetEntity="Localidad", inversedBy="users")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     */
    protected $localidad;

    /**
     * Set localidad
     *
     * @param \Zombit\OteaBundle\Entity\Localidad $localidad
     * @return User
     */
    public function setLocalidad(\Zombit\OteaBundle\Entity\Localidad $localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \Zombit\OteaBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
}
