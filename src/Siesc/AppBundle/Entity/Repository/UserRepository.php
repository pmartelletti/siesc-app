<?php

namespace Siesc\AppBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;

class UserRepository extends EntityRepository
{
    
    public function getUserInTenant($user)
    {
        $query_user = $this->createQueryBuilder('u')
                ->where('u.id IN (:user_tenat)')
                ->setParameter('user_tenat', $user)
                ->getQuery()
                ->getResult();
        
        return $query_user;
        
    }  
    
    public function getUserNotInTenant($user, $role_1 = 'ROLE_SUPER_ADMIN', $role_2 = 'ROLE_ADMIN_DATA')
    {
        $query_user = $this->createQueryBuilder('u')
                ->where('(u.roles LIKE :role_1 OR u.roles LIKE :role_2 )')
                ->setParameter('role_1', '%"'.$role_1.'"%')
                ->setParameter('role_2', '%"'.$role_2.'"%');
        
        if(count($user)>0){
            $query_user->andWhere('u.id NOT IN (:user_tenat)')
                    ->setParameter('user_tenat', $user);
        }
        
        return $query_user->getQuery()->getResult();
        
    }  
} 