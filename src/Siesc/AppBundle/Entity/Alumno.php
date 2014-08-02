<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_alumno")
 * @UniqueEntity(fields = "username", targetClass = "Acme\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Acme\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Alumno extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    public function __construct() {
        parent::__construct();
        // main roles for alumno
        $this->roles = array('ROLE_ACADEMICO', 'ROLE_ACADEMICO_ALUMNO');
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
}