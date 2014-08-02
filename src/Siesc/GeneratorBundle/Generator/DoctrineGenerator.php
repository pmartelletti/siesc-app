<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 4/12/14
 * Time: 6:08 PM
 */

namespace Siesc\GeneratorBundle\Generator;


use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sensio\Bundle\GeneratorBundle\Generator\Generator;

class DoctrineGenerator extends Generator
{
    protected $className;
    protected $classPath;

    /**
     * @param mixed $className
     *
     * @return $this
     */
    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $classPath
     *
     * @return $this
     */
    public function setClassPath($classPath)
    {
        $this->classPath = $classPath;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClassPath()
    {
        return $this->classPath;
    }

    /**
     * Returns an array of fields. Fields can be both column fields and
     * association fields.
     *
     * @param  ClassMetadataInfo $metadata
     * @return array             $fields
     */
    protected function getFieldsFromMetadata(ClassMetadataInfo $metadata)
    {
        $fields = (array) $metadata->fieldNames;

        // Remove the primary key field if it's not managed manually
        if (!$metadata->isIdentifierNatural()) {
            $fields = array_diff($fields, $metadata->identifier);
        }

        foreach ($metadata->associationMappings as $fieldName => $relation) {
            if ($relation['type'] !== ClassMetadataInfo::ONE_TO_MANY) {
                $fields[] = $fieldName;
            }
        }

        return $fields;
    }

    protected function getFieldsSetters($fields)
    {
        $methods = array();
        foreach ($fields as $field) {
            $parts = array_map('ucfirst', explode('_', $field));
            $methods[$field] = 'set' . implode('', $parts);
        }

        return $methods;
    }
} 