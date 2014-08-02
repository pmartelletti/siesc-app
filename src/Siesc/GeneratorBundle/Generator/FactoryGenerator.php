<?php
namespace Siesc\GeneratorBundle\Generator;


use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class FactoryGenerator extends DoctrineGenerator
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

        $this->setClassName($entityClass.'Factory');
        $dirPath         = $bundle->getPath().'/Factory';
        $this->setClassPath($dirPath.'/'.str_replace('\\', '/', $entity).'Factory.php');

        if (count($metadata->identifier) > 1) {
            throw new \RuntimeException('The factory generator does not support entity classes with multiple primary keys.');
        }

        $parts = explode('\\', $entity);
        array_pop($parts);

        $fields = $this->getFieldsFromMetadata($metadata);

        $this->renderFile('factory/Factory.php.twig', $this->classPath, array(
            'fields'           => $fields,
            'fields_methods' => $this->getFieldsSetters($fields),
            'namespace'        => $bundle->getNamespace(),
            'entity_namespace' => implode('\\', $parts),
            'entity_class'     => $entityClass,
            'bundle'           => $bundle->getName(),
            'factory_class'       => $this->className
        ));
    }
} 