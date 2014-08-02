<?php

namespace Siesc\AppBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;

class NotificacionRepository extends EntityRepository
{
    public function findUnreadsForUser(UserInterface $user)
    {
        $query = $this->createQueryBuilder('n')
            ->select('count(n)')
            ->andWhere('n.destinatario = :user')
            ->andWhere('n.leida = :unread')
            ->setParameters(array(
                'user' => $user,
                'unread' => false
            ))
        ;

        return $query->getQuery()->getSingleScalarResult();
    }
} 