<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Tahoe\Bundle\MultiTenancyBundle\Model\MultiTenantUserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"usuario_alumno" = "Alumno", "usuario_docente" = "Docente"})
 *
 */
abstract class User extends BaseUser implements MultiTenantUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    protected $activeTenant;

    public function __construct()
    {
        parent::__construct();
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
     * @return mixed
     */
    public function getActiveTenant()
    {
        return $this->activeTenant;
    }

    /**
     * @param mixed $activeTenant
     *
     * @return $this
     */
    public function setActiveTenant($activeTenant)
    {
        $this->activeTenant = $activeTenant;
        return $this;
    }
}