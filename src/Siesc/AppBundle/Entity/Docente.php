<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use Tahoe\Bundle\MultiTenancyBundle\Model\MultiTenantUserInterface;



/**
 * @ORM\Entity(repositoryClass="Siesc\AppBundle\Entity\Repository\DocenteRepository")
 * @ORM\Table(name="user_docente")
 * @UniqueEntity(fields = "email", targetClass = "Siesc\AppBundle\Entity\User", message="fos_user.email.already_used")
 *
 */
class Docente extends User implements MultiTenantUserInterface
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    protected $activeTenant;
    
    /**
     * @ORM\Column(type="string", length=11, unique=true)
     * @Assert\Regex(pattern="/^[0-9]{11}$/", message="siesc.docente.cuit.invalida", groups={"new", "update"})
     */
    protected $cuil;
    
    /**
     *
     * @var type 
     * @ORM\Column(type="string", length=255)
     */
    protected $nombre;
    
    /**
     *
     * @var type 
     * @ORM\Column(type="string", length=255)
     */
    protected $apellido;
    
    /**
     *
     * @var type 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $direccion;
    
    /**
     *
     * @var type 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $telefono;
    
    /**
     *
     * @var type 
     * @ORM\Column(type="text", nullable=true)
     */
    protected $observaciones;

    /**
     * @var Funcion
     * @ORM\ManyToOne(targetEntity="Funcion")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $funcionPrincipal;

    public function __construct() {
        parent::__construct();
        // main roles for docentes
        $this->roles = array('ROLE_USER_APP', 'ROLE_ACADEMICO_DOCENTE');
    }
    
    // workaround for not using username
    public function setEmail($email) {
        parent::setEmail($email);
        $this->username = $email;

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
     * Set cuil
     *
     * @param integer $cuil
     * @return Docente
     */
    public function setCuil($cuil)
    {
        $this->cuil = $cuil;
    
        return $this;
    }

    /**
     * Get cuil
     *
     * @return integer 
     */
    public function getCuil()
    {
        return $this->cuil;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Docente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Docente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Docente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Docente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Docente
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function __toString()
    {
        return $this->getFullName();
    }

    public function getFullName()
    {
        return sprintf("%s, %s", $this->getApellido(), $this->getNombre());
    }

    /**
     * @param mixed $funcionPrincipal
     *
     * @return $this
     */
    public function setFuncionPrincipal($funcionPrincipal)
    {
        $this->funcionPrincipal = $funcionPrincipal;
        return $this;
    }

    /**
     * @return Funcion
     */
    public function getFuncionPrincipal()
    {
        return $this->funcionPrincipal;
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