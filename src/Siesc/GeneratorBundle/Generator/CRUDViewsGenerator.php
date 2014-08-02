<?php
namespace Siesc\GeneratorBundle\Generator;


use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class CRUDViewsGenerator extends DoctrineGenerator
{
    protected $templates = array(
        'edit', 'show', 'new', '_details', 'index'
    );

    protected $jsTempaltes = array(
        'filters', 'table'
    );

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
        $parts = explode('\\', $entity);
        $entityClass = array_pop($parts);
        $subDir = str_replace(array("Bundle", "Siesc"), "", $bundle->getName());
        $dirPath = sprintf('%s/Resources/views/Data/%s/%s', $targetBundle->getPath(), $subDir, str_replace('\\', '/', $entity));

        $parts = explode('\\', $entity);
        array_pop($parts);
        $normalName = implode(' ', preg_split("/(?<=[a-z])(?![a-z])/", $entityClass, -1, PREG_SPLIT_NO_EMPTY));

        // create all crud templates
        foreach ($this->templates as $template) {
            $this->renderFile("crud/$template.html.twig", $dirPath . "/$template.html.twig", array(
                    'bundle' => $bundle->getName(),
                    'subdir' => $subDir,
                    'entity' => $entity,
                    'entity_normal_name' => $normalName,
                    'route_prefix' => 'data' . "_" . strtolower($subDir). '_' . str_replace(' ', '_', strtolower($normalName)),
                    'fields' => $metadata->fieldMappings,
                    'doctrine_fields' => $this->getFieldsFromMetadata($metadata),
                    'template_dir' => sprintf('%s:Data/%s/%s', $targetBundle->getName(), $subDir, $entity)
                ));
        }

        // create all js templates
        foreach ($this->jsTempaltes as $template) {
            $this->renderFile("crud/$template.js.twig", $dirPath . "/$template.js.twig", array(
                    'bundle' => $bundle->getName(),
                    'entity' => $entity,
                    'entity_normal_name' => $normalName,
                    'route_prefix' => 'data' . "_" . strtolower($subDir). '_' . str_replace(' ', '_', strtolower($normalName)),
                    'fields' => $metadata->fieldMappings,
                    'doctrine_fields' => $this->getFieldsFromMetadata($metadata),
                    'template_dir' => sprintf('%s:Data/%s/%s', $targetBundle->getName(), $subDir, $entity)
                ));
        }

    }

}