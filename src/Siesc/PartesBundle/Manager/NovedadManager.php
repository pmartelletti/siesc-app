<?php

namespace Siesc\PartesBundle\Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;

class NovedadManager
{
    private $_em;
    private $security;

    public function __construct(EntityManager $em, SecurityContextInterface $security)
    {
        $this->_em = $em;
        $this->security = $security;
    }

    public function getRepository()
    {
        return $this->_em->getRepository('SiescPartesBundle:Novedad');
    }

    public function getDashboardStats(\DateTime $fechaLimite = null)
    {
        if (is_null($fechaLimite)) $fechaLimite = date_create()->modify('-1 month');
        $estados = array('pendiente_aprobacion', 'pendiente_cambio', 'autorizada', 'desautorizada');
        $stats = array();
        $total = 0;
        foreach($estados as $estado) {
            $cantidad = $this->cantidadPorEstado($estado, $fechaLimite);
            $stats[$estado] = $cantidad;
            $total += $cantidad;
        }

        $stats['total'] = $total;

        return $stats;
    }

    public function cantidadPorEstado($estado, \DateTime $fechaLimite = null, $count = true)
    {
        $query = $this->getRepository()->createQueryBuilder('n')
            ->andWhere('n.estado = :estado')
            ->setParameter('estado', $estado)
        ;

        if($fechaLimite) {
            $query->andWhere('n.createdAt >= :limite')->setParameter('limite', $fechaLimite);
        }

        if (!$this->security->isGranted('ROLE_PARTES_RL')) {
            $secretario = $this->security->getToken()->getUser();
            $query->andWhere('n.secretario = :secretario')->setParameter('secretario', $secretario);
        }

        if ($count) {
            $query->select('count(n)');
            return $query->getQuery()->getSingleScalarResult();
        } else {
            $query->select('n');
            return $query->getQuery()->getResult();
        }


    }

    public function getNovedadesPendientes()
    {
        if ($this->security->isGranted('ROLE_PARTES_RL')) {
            return $this->cantidadPorEstado('pendiente_aprobacion', null, false);
        }

        return $this->cantidadPorEstado('pendiente_cambio', null, false);
    }
} 