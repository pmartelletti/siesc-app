<?php

namespace Siesc\PartesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Siesc\AppBundle\Entity\Docente;

/**
 * CierreNovedades
 *
 * @ORM\Table(name="partes_cierre_novedades")
 * @ORM\Entity
 */
class CierreNovedades
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCierre", type="date")
     */
    private $fechaCierre;

    /**
     * @var Docente
     *
     * @ORM\ManyToOne(targetEntity="Siesc\AppBundle\Entity\Docente")
     */
    private $encargado;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var Novedad[]
     * @ORM\OneToMany(targetEntity="Novedad", mappedBy="cierre", cascade={"all"})
     *
     */
    private $novedades;

    public function __construct()
    {
        $this->novedades = new ArrayCollection();
        $this->estado = 'pendiente_liquidacion';
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
     * @param \Siesc\AppBundle\Entity\Docente $encargado
     *
     * @return $this
     */
    public function setEncargado($encargado)
    {
        $this->encargado = $encargado;
        return $this;
    }

    /**
     * @return \Siesc\AppBundle\Entity\Docente
     */
    public function getEncargado()
    {
        return $this->encargado;
    }

    /**
     * @param string $estado
     *
     * @return $this
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param \DateTime $fechaCierre
     *
     * @return $this
     */
    public function setFechaCierre($fechaCierre)
    {
        $this->fechaCierre = $fechaCierre;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCierre()
    {
        return $this->fechaCierre;
    }

    /**
     * @param \Siesc\PartesBundle\Entity\Novedad[] $novedades
     *
     * @return $this
     */
    public function setNovedades($novedades)
    {
        $this->novedades = $novedades;
        return $this;
    }

    /**
     * @return \Siesc\PartesBundle\Entity\Novedad[]
     */
    public function getNovedades()
    {
        return $this->novedades;
    }

    /**
     * @param Novedad $novedad
     * @return $this
     */
    public function addNovedad(Novedad $novedad)
    {
        $novedad->setCierre($this);
        $this->novedades->add($novedad);

        return $this;
    }

    /**
     * @param Novedad $novedad
     * @return $this
     */
    public function removeNovedad(Novedad $novedad)
    {
        $this->novedades->removeElement($novedad);
        $novedad->setCierre(null);

        return $this;
    }

    public function hasNovedad(Novedad $novedad)
    {
        return $this->novedades->contains($novedad);
    }
}
