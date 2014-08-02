<?php
namespace Siesc\GeneratorBundle\Generator;


use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class DoctrineControllerAdminGenerator extends DoctrineGenerator
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
        $parts = explode('\\', $entity);
        $entityClass = array_pop($parts);
        $subDir = str_replace(array("Bundle", "Siesc"), "", $bundle->getName());
        $targetSubdir = str_replace(array("Bundle", "Siesc"), "", $targetBundle->getName());

        $this->setClassName($entityClass . 'Controller');
        $dirPath = sprintf("%s/Controller/%s", $targetBundle->getPath(), $subDir);
        $this->setClassPath($dirPath . '/' . str_replace('\\', '/', $entity) . 'Controller.php');

        if (count($metadata->identifier) > 1) {
            throw new \RuntimeException('The factory generator does not support entity classes with multiple primary keys.');
        }

        $parts = explode('\\', $entity);
        array_pop($parts);

        $fields = $this->getFieldsFromMetadata($metadata);
        $normalName = implode(' ', preg_split("/(?<=[a-z])(?![a-z])/", $entityClass, -1, PREG_SPLIT_NO_EMPTY));
        $this->renderFile('controller/Controller.php.twig', $this->classPath, array(
            'fields' => $fields,
            'fields_methods' => $this->getFieldsSetters($fields),
            'namespace' => $bundle->getNamespace(),
            'alt_namespace' => $targetBundle->getNamespace(),
            'entity_namespace' => implode('\\', $parts),
            'entity_class' => $entityClass,
            'entity_normal_name' => $normalName,
            'bundle' => $bundle->getName(),
            'controller_class' => $this->className,
            'template_dir' => sprintf('@%s:Admin/%s', $bundle->getName(), $entity),
            'subdir' => $subDir,
            'routing_prefix' => strtolower($targetSubdir) . "_" . strtolower($subDir) . "_" . str_replace(' ', '_', strtolower($normalName)),
        ));

        // create routing file
        $prefix = str_replace(' ', '_', strtolower($normalName));
        $routingFile = $targetBundle->getPath() ."/../WebBundle" . sprintf("/Resources/config/routing/data/%s/%s.yml", strtolower($subDir), $prefix);
        $this->renderFile('routing/routing.yml.twig', $routingFile, array(
            'routing_prefix' => strtolower($targetSubdir) . "_" . strtolower($subDir) . "_" . str_replace(' ', '_', strtolower($normalName)),
            'entity_class' => $entityClass,
            'bundle' => $targetBundle->getName(),
            'targetBundle' => $subDir
        ));

        // import routing in the routing.yml file
        $this->importRouting($targetBundle->getPath() ."/../WebBundle"  . "/Resources/config/routing/data/data.yml", "SiescWebBundle", $normalName, strtolower($subDir));
    }

    protected function importRouting($path, $bundle, $normalName, $subdir)
    {
        $prefix = str_replace(' ', '_', strtolower($normalName));
        $current = '';

        if (file_exists($path)) {
            $current = file_get_contents($path);
        } elseif (!is_dir($dir = dirname($path))) {
            mkdir($dir, 0777, true);
        }

        $code = sprintf("%s_%s:\n", $bundle, $prefix);
        $code .= sprintf("    resource: \"@%s/Resources/config/routing/data/%s/%s.%s\"\n", $bundle, $subdir, $prefix, "yml");
        $code .= sprintf("    prefix:   /%s/%s\n", $subdir, implode('-', explode(' ', strtolower($normalName))));
        $code .= "\n";
        $code .= $current;

        if (false === file_put_contents($path, $code)) {
            return false;
        }

        return true;
    }
} 