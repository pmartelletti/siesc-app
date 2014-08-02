<?php

namespace Siesc\WebBundle\Helper;


class FormHelper
{
    public static function collectionToOptions($collection)
    {
        $res = "";
        foreach($collection as $item) {
            $res .= sprintf("<option value='%s'>%s</option>", $item->getId(), $item);
        }
        return $res;
    }
} 