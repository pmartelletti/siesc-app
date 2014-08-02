<?php
namespace Siesc\PartesBundle\Security\Voters;

use Siesc\PartesBundle\Entity\Novedad;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class NovedadVoter extends AbstractVoter
{
    protected $container;
    protected $token;
    protected $supportedAttributes = array(
        'EDITAR',
        'CREAR',
        'VER',
        'ELIMINAR',
        'AUTORIZAR'
    );

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $this->token = $token;

        if (!$this->supportsClass($object)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        /** @var Novedad $object */

        //if ($this->getSecurity()->isGranted('ROLE_PARTES_ADMIN')) return true;

        foreach($attributes as $attribute){
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }
            switch ($attribute) {
                case 'CREAR':
                case 'VER':
                    return $this->esSecretario();
                case 'EDITAR':
                case 'ELIMINAR':
                    return $this->esSecretario() && $this->puedeModificarNovedad($object);
                case 'AUTORIZAR':
                    return $this->esRepresentanteLegal();
            }
        }
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        if ($class instanceof Novedad) {
            return true;
        }

        return false;
    }

    public function puedeModificarNovedad(Novedad $novedad)
    {
        return !in_array($novedad->getEstado(), array('autorizada', 'rechazada', 'liquidada'));
    }
} 