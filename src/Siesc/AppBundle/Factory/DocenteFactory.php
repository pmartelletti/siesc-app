<?php

namespace Siesc\AppBundle\Factory;

use Siesc\AppBundle\Entity\Docente;

class DocenteFactory
{

    /**
     * @param $data
     * @return Docente
     */
    public function createFrom($data)
    {
        if ($data instanceof Docente) {
            $resource = $data;
        } else {
            $resource = self::createNew();
        }
        if (isset($data['username'])) {
            $resource->setUsername($data['username']);
        }
        if (isset($data['usernameCanonical'])) {
            $resource->setUsernameCanonical($data['usernameCanonical']);
        }
        if (isset($data['email'])) {
            $resource->setEmail($data['email']);
        }
        if (isset($data['emailCanonical'])) {
            $resource->setEmailCanonical($data['emailCanonical']);
        }
        if (isset($data['enabled'])) {
            $resource->setEnabled($data['enabled']);
        }
        if (isset($data['salt'])) {
            $resource->setSalt($data['salt']);
        }
        if (isset($data['password'])) {
            $resource->setPassword($data['password']);
        }
        if (isset($data['lastLogin'])) {
            $resource->setLastLogin($data['lastLogin']);
        }
        if (isset($data['locked'])) {
            $resource->setLocked($data['locked']);
        }
        if (isset($data['expired'])) {
            $resource->setExpired($data['expired']);
        }
        if (isset($data['expiresAt'])) {
            $resource->setExpiresAt($data['expiresAt']);
        }
        if (isset($data['confirmationToken'])) {
            $resource->setConfirmationToken($data['confirmationToken']);
        }
        if (isset($data['passwordRequestedAt'])) {
            $resource->setPasswordRequestedAt($data['passwordRequestedAt']);
        }
        if (isset($data['roles'])) {
            $resource->setRoles($data['roles']);
        }
        if (isset($data['credentialsExpired'])) {
            $resource->setCredentialsExpired($data['credentialsExpired']);
        }
        if (isset($data['credentialsExpireAt'])) {
            $resource->setCredentialsExpireAt($data['credentialsExpireAt']);
        }
        if (isset($data['cuil'])) {
            $resource->setCuil($data['cuil']);
        }
        if (isset($data['nombre'])) {
            $resource->setNombre($data['nombre']);
        }
        if (isset($data['apellido'])) {
            $resource->setApellido($data['apellido']);
        }
        if (isset($data['direccion'])) {
            $resource->setDireccion($data['direccion']);
        }
        if (isset($data['telefono'])) {
            $resource->setTelefono($data['telefono']);
        }
        if (isset($data['observaciones'])) {
            $resource->setObservaciones($data['observaciones']);
        }
        if (isset($data['funcionPrincipal'])) {
            $resource->setFuncionPrincipal($data['funcionPrincipal']);
        }
        return $resource;
    }

    public static function createNew()
    {
        return new Docente();
    }

}
