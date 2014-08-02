<?php

namespace Siesc\PartesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Siesc\AppBundle\Entity\Colegio;
use Siesc\AppBundle\Entity\Docente,
    Siesc\AppBundle\Entity\Seccion;

/**
 * CargoDocente
 *
 * @ORM\Table(name="partes_cargo_docente")
 * @ORM\Entity
 */
class CargoDocente
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
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Docente", fetch="EAGER")
     */
    private $docente;

    /**
     * @ORM\ManyToOne(targetEntity="Convenio", inversedBy="cargos")
     */
    private $convenio;

    /**
     * @ORM\ManyToOne(targetEntity="Categoria")
     */
    private $categoria;

    /**
     * @var integer
     *
     * @ORM\Column(name="horas", type="integer", nullable=true)
     */
    private $horas;

    /**
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Colegio")
     */
    private $colegio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAlta", type="date")
     */
    private $fechaAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaBaja", type="date", nullable=true)
     */
    private $fechaBaja;


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
     * Set docente
     *
     * @param \stdClass $docente
     * @return CargoDocente
     */
    public function setDocente($docente)
    {
        $this->docente = $docente;
    
        return $this;
    }

    /**
     * Get docente
     *
     * @return \stdClass 
     */
    public function getDocente()
    {
        return $this->docente;
    }

    /**
     * Set cargo
     *
     * @param \stdClass $cargo
     * @return CargoDocente
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    
        return $this;
    }

    /**
     * Get cargo
     *
     * @return \stdClass 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set horas
     *
     * @param integer $horas
     * @return CargoDocente
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;
    
        return $this;
    }

    /**
     * Get horas
     *
     * @return integer 
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * Set situacionRevista
     *
     * @param string $situacionRevista
     * @return CargoDocente
     */
    public function setSituacionRevista($situacionRevista)
    {
        $this->situacionRevista = $situacionRevista;
    
        return $this;
    }

    /**
     * Get situacionRevista
     *
     * @return string 
     */
    public function getSituacionRevista()
    {
        return $this->situacionRevista;
    }

    /**
     * Set seccion
     *
     * @param \stdClass $seccion
     * @return CargoDocente
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;
    
        return $this;
    }

    /**
     * Get seccion
     *
     * @return \stdClass 
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return CargoDocente
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;
    
        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     * @return CargoDocente
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;
    
        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime 
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    public function __toString() {
        return sprintf("%s - %s en %s", $this->docente, $this->getCategoria()->getNombre(), $this->getConvenio());
    }

    /**
     * @param mixed $categoria
     *
     * @return $this
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $colegio
     *
     * @return $this
     */
    public function setColegio($colegio)
    {
        $this->colegio = $colegio;
        return $this;
    }

    /**
     * @return Colegio
     */
    public function getColegio()
    {
        return $this->colegio;
    }

    /**
     * @param mixed $convenio
     *
     * @return $this
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

    /**
     * @return Convenio
     */
    public function getConvenio()
    {
        return $this->convenio;
    }
}