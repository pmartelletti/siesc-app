<?php

namespace Siesc\PartesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantAwareInterface;
use Tahoe\Bundle\MultiTenancyBundle\Model\TenantTrait;

/**
 * Categoria
 *
 * @ORM\Table(name="partes_categoria")
 * @ORM\Entity
 */
class Categoria
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Funcion")
     */
    private $funcion;

    /**
     * @var string
     *
     * @ORM\Column(name="requireHoras", type="boolean")
     */
    private $requiereHoras;

    /**
     * @var string
     *
     * @ORM\Column(name="topeHoras", type="float", nullable=true)
     */
    private $topeHoras;

    /**
     * @var string
     *
     * @ORM\Column(name="requireAsignatura", type="boolean")
     */
    private $requiereAsignatura;

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
     * Set codigo
     *
     * @param string $codigo
     * @return Categoria
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set funcion
     *
     * @param string $funcion
     * @return Categoria
     */
    public function setFuncion($funcion)
    {
        $this->funcion = $funcion;

        return $this;
    }

    /**
     * Get funcion
     *
     * @return string 
     */
    public function getFuncion()
    {
        return $this->funcion;
    }

    /**
     * Set requiereHoras
     *
     * @param boolean $requiereHoras
     * @return Categoria
     */
    public function setRequiereHoras($requiereHoras)
    {
        $this->requiereHoras = $requiereHoras;

        return $this;
    }

    /**
     * Get requiereHoras
     *
     * @return boolean 
     */
    public function getRequiereHoras()
    {
        return $this->requiereHoras;
    }

    /**
     * Set horas
     *
     * @param float $horas
     * @return Categoria
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get horas
     *
     * @return float 
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * Set requiereAsignatura
     *
     * @param boolean $requiereAsignatura
     * @return Categoria
     */
    public function setRequiereAsignatura($requiereAsignatura)
    {
        $this->requiereAsignatura = $requiereAsignatura;

        return $this;
    }

    /**
     * Get requiereAsignatura
     *
     * @return boolean 
     */
    public function getRequiereAsignatura()
    {
        return $this->requiereAsignatura;
    }

    /**
     * @param string $nombre
     *
     * @return $this
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $topeHoras
     *
     * @return $this
     */
    public function setTopeHoras($topeHoras)
    {
        $this->topeHoras = $topeHoras;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTopeHoras()
    {
        return $this->topeHoras;
    }

    public function __toString()
    {
        return sprintf('%s (%s)', $this->getNombre(), $this->getFuncion());
    }
}
