<?php

namespace Siesc\AppBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Siesc\AppBundle\Entity\Tenant;

class DocenteRepository extends EntityRepository
{
    /**
     * @param Tenant $tenant
     * @return array
     */
    public function findForTenant(Tenant $tenant)
    {
        $query = $this->_em->createQueryBuilder()
            ->select('tu')
            ->from('TahoeMultiTenancyBundle:TenantUser', 'tu')
            ->join('tu.user', 'd')
            ->andWhere('d INSTANCE OF SiescAppBundle:Docente')
            ->andWhere('tu.tenant = :tenant')
            ->setParameter('tenant', $tenant)
        ;

        return $query->getQuery()->getResult();
    }
} 