<?php
namespace Siesc\PartesBundle\Security\Voters;

use Siesc\AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class AbstractVoter implements VoterInterface
{
    protected $container;
    protected $supportedAttributes;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param TokenInterface $token
     * @param object $object
     * @param array $attributes
     *
     * @return VoterInterface::ACCESS_DENIED|VoterInterface::ACCESS_ABSTAIN|VoterInterface::ACCESS_GRANTED
     */
    abstract public function vote(TokenInterface $token, $object, array $attributes);

    /**
     * @param string $class
     *
     * @return bool
     */
    abstract public function supportsClass($class);

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        if (in_array($attribute, $this->supportedAttributes)) {
            return true;
        }

        return false;
    }

    /**
     * @return User|null
     */
    protected function getUser()
    {
        return $this->token->getUser();
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurity()
    {
        return $this->container->get('security.context');
    }

    public function esSecretario()
    {
        return $this->getSecurity()->isGranted('ROLE_PARTES_SECRETARIO');
    }

    public function esRepresentanteLegal()
    {
        return $this->getSecurity()->isGranted('ROLE_PARTES_RL');
    }

    public function esLiquidador()
    {
        return $this->getSecurity()->isGranted('ROLE_PARTES_LIQUIDADOR');
    }
} 