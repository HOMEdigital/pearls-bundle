<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 01.03.2018
 * Time: 10:59
 */

namespace Home\PearlsBundle\Resources\contao\hooks;



class insertTagReplacer
{
    public function replaceInsertTags($strTag)
    {
        if(strpos($strTag,'page_alias') !== false) return $this->getPageAlias($strTag);
        return false;
    }

    public function getPageAlias($strTag)
    {
        $elements = explode('::', $strTag);
        $strModel = \PageModel::findByIdOrAlias($elements[1]);

        return $strModel->alias;
    }
}