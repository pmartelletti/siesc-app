<?php

namespace Siesc\WebBundle\Helper;

class JsonHelper
{
    public static function collectionToAssociativeArray($collection)
    {
        $res = array();
        foreach($collection as $item) {
            $res[$item->getId()] = $item->__toString();
        }
        return $res;
    }
} 