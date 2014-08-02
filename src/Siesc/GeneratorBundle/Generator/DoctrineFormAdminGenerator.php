<?php

namespace Siesc\GeneratorBundle\Generator;


use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\Process\Exception\RuntimeException;

class DoctrineFormAdminGenerator extends DoctrineGenerator
{

    /**
     * Generates the entity form class if it does not exist.
     *
     * @param BundleInterface $bundle The bundle in which to create the class
     * @param BundleInterface $targetBundle
     * @param string $entity The entity relative class name
     * @param ClassMetadataInfo $metadata The entity metadata class
     *
     * @throws \RuntimeException
     */
    public function generate(BundleInterface $bundle, BundleInterface $targetBundle, $entity, ClassMetadataInfo $metadata)
    {
        $parts       = explode('\\', $entity);
        $entityClass = array_pop($parts);
        $subDir = str_replace(array("Bundle", "Siesc"), "", $bundle->getName());

        $this->setClassName($entityClass.'Type');
        $dirPath         = $targetBundle->getPath().'/Form/'.$subDir; // prob want to enable this sometime
        $this->setClassPath($dirPath.'/'.str_replace('\\', '/', $entity).'Type.php');

        if (count($metadata->identifier) > 1) {
            throw new \RuntimeException('The form generator does not support entity classes with multiple primary keys.');
        }

        $parts = explode('\\', $entity);
        array_pop($parts);

        $this->renderFile('form/FormAdminType.php.twig', $this->classPath, array(
            'fields'           => $this->getFieldsFromMetadata($metadata),
            'namespace'        => $targetBundle->getNamespace(),
            'entity_namespace' => implode('\\', $parts),
            'entity_class'     => $entityClass,
            'bundle'           => $bundle->getName(),
            'form_class'       => $this->className,
            'form_type_name'   => strtolower(str_replace('\\', '_', $targetBundle->getNamespace()).($parts ? '_' : '').implode('_', $parts).'_' . strtolower($subDir) .'_'.substr($this->className, 0, -4)),
            'subdir'           => $subDir,
            'alt_namespace' => $bundle->getNamespace()
        ));
    }
} 