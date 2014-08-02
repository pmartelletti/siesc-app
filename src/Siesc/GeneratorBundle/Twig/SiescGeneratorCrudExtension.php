<?php
namespace Siesc\GeneratorBundle\Twig;

use Doctrine\ORM\PersistentCollection;
use Siesc\AppBundle\Helper\StringUtils;
use Siesc\PartesBundle\Entity\CargoDocente;
use Symfony\Component\Routing\RouterInterface;

class SiescGeneratorCrudExtension extends \Twig_Extension
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('siesc_crud_property', array($this, 'crudPropertyShow'), array('is_safe' => array('html'))),
        );
    }

    public function crudPropertyShow($mainEntity, $property)
    {
        $method = sprintf('get%s', ucwords($property));
        $boolMethod = sprintf('is%s', ucwords($property));
        $property = (property_exists($mainEntity, $property) ?
            (method_exists($mainEntity, $method) ? call_user_func(array($mainEntity,$method))
                : call_user_func(array($mainEntity,$boolMethod))) : $property);
        $htmlProperty = "";

        if (is_array($property) || $property instanceof PersistentCollection ) {
            $htmlProperty .= "<ul>";
            foreach($property as $prop) {
                if (StringUTils::startsWith($prop, 'ROLE_') && !StringUtils::startsWith($prop, 'ROLE_PARTES')) {
                    continue;
                }
                $htmlProperty .= sprintf("<li>%s</li>", $this->crudPropertyShow($mainEntity, $prop));
            }
            $htmlProperty .= "</ul>";

            return $htmlProperty;
        }



        if (is_object($property)) {
            if ($property instanceof \DateTime) {
                return $property->format('d/m/Y');
            }
            $entityName = get_class($property);
            $resource = substr($entityName, strrpos($entityName, '\\') + 1);
            $resource = implode("_", preg_split("/(?<=[a-z])(?![a-z])/", $resource, -1, PREG_SPLIT_NO_EMPTY));

            $url = $this->retryGenerateUrl($resource, $property, array('partes', 'app', 'data_partes', 'data_app'));
            if (empty($url)) return $property;

            return sprintf('<a href="%s">%s</a>', $url, $property);
        }

        if (StringUtils::startsWith($property, 'ROLE_PARTES_')) {
            return str_replace('ROLE_PARTES_', '', $property);
        }

        return $property;

    }

    private function retryGenerateUrl($resource, $property, array $options)
    {
        try {
            $prefix = array_shift($options);
            $url = $this->router->generate(
                $prefix . '_' . str_replace(" ", "_", strtolower($resource)) . "_show",
                array('id' => $property->getId())
            );
        } catch(\Exception $e) {
            if (count($options) <= 1) {
                return '';
            } else {
                return $this->retryGenerateUrl($resource, $property, $options);
            }
        }

        return $url;
    }

    public function getName()
    {
        return 'siesc_generator_crud_extension';
    }
}