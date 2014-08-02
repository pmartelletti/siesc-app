<?php

namespace Siesc\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CicloLectivo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CicloLectivo
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
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actual", type="boolean")
     */
    private $actual;

    public function __toString() {
        $nombre = $this->getNombre();

        return isset($nombre) ? $nombre : "";
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
     * Set nombre
     *
     * @param string $nombre
     * @return CicloLectivo
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
     * Set actual
     *
     * @param boolean $actual
     * @return CicloLectivo
     */
    public function setActual($actual)
    {
        $this->actual = $actual;
    
        return $this;
    }

    /**
     * Get actual
     *
     * @return boolean 
     */
    public function getActual()
    {
        return $this->actual;
    }
}