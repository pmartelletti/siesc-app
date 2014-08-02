<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pablo
 * Date: 10/30/13
 * Time: 1:01 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Siesc\PartesBundle\Services;


use Doctrine\ORM\EntityManager;

class StatsManager {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function calcularPremioPorPeriodo(array $data = array(), $totalPremio = 0, $tolerancia = 0) {
        $qb = $this->em->createQueryBuilder();
        $query = $qb
            ->select(array('i', 'SUM(i.horas)'))
            ->from('SiescPartesBundle:Inasistencia', 'i')
            ->join('i.parteDiario', 'p')
            ->join('i.cargo', 'c')
            ->join('i.motivo', 'm')
            ->andWhere('c.seccion = :seccion')
            ->andWhere('m.afectaPresentismo = :presentismo')
            ->andWhere($qb->expr()->between('p.fecha', ':desde',':hasta'))
            ->groupBy('c.docente')
            ->setParameters(array(
                'seccion' => $data['seccion'],
                'desde' => $data['desde'],
                'hasta' => $data['hasta'],
                'presentismo' => true
            ))
        ;
        $result = array();

        foreach($query->getQuery()->getResult() as $totales) {
            $inasistencias = $totales[1];
            $cargo = $totales[0];
            if( $inasistencias < $tolerancia ) {
                $result[] = array(
                    'docente' => $cargo->getCargo()->getDocente(),
                    'inasistencias' => $inasistencias,
                    'premio' => floatval($totalPremio / $inasistencias)
                );
            }
        }
        return $result;
    }



}