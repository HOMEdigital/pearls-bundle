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
        if(strpos($strTag,'download_link_open') !== false) return $this->getDownloadLinkOpen($strTag);
        if(strpos($strTag,'download_link_close') !== false) return $this->getDownloadLinkClose();

        return false;
    }


    /**
     * getPageAlias - liefert den Seiten-Alias anhand der Seiten-Id.
     *
     * @param $strTag - string- der inserttag
     * @return string
     */
    public function getPageAlias($strTag)
    {
        $strModel = \PageModel::findByIdOrAlias(self::splitInserttag($strTag));
        return $strModel->alias;
    }

    /**
     * getDownloadLinkOpen - liefert ein öffnenden Link-Tag, mit dem Dateien heruntergeladen werden können
     *
     * zusätzliche Parameter:
     *      title: [string] title text
     *      class: [string] CSS class
     *      blank: öffnet Ziel in neuem Fenster
     *
     * @param $strTag - string- der inserttag
     * @return string
     */
    public function getDownloadLinkOpen($strTag)
    {
        $itValue = self::splitInserttag($strTag);
        $file = (\Validator::isUuid($itValue['value'])) ? \FilesModel::findByUuid($itValue['value']) : \FilesModel::findByPath($itValue['value']);

        #-- set the additional parameters
        if (array_key_exists('params', $itValue) === true) {
            $title = (array_key_exists('title', $itValue['params'])) ? ' title=' . $itValue['params']['title'] : '';
            $class = (array_key_exists('class', $itValue['params'])) ? ' class=' . $itValue['params']['class'] : '';
            $blank = (array_key_exists('blank', $itValue['params'])) ? ' target=_blank' : '';
        }
        return '<a href="' . $file->path . '"' . $title . $class . $blank .'>';
    }

    /**
     * getDownloadLinkClose - liefert den schliessenden Link-Tag für getDownloadLinkOpen
     *
     * @return string
     */
    public function getDownloadLinkClose()
    {
        return '</a>';
    }

    /**
     * splitInserttag - liefert den den Inserttag aufgesplittet zurück
     *
     * @param $onlyValue - bool [true] - wenn true, dann wird nur der Wert zurückgeliefert. Also das hinter dem ::
     *              wenn weitere Attribute mit ? übergeben wurden, dann ist die Rückgabe ein Array
     *                  value: der Inserttag-Value als das direkt hinter dem ::
     *                  params: die weiteren Attribute die übergeben wurden als array mit key => value
     * @param $strTag - string- der inserttag
     * @return mixed
     */
    public static function splitInserttag($strTag, $onlyValue=true) {
        $inserttag = explode('::', $strTag);

        #-- wenn parameter gesetzt wurden
        if(strpos($inserttag[1],'?') !== false) {
            $params = explode('?', $inserttag[1]);
            parse_str($params[1], $variables);

            $inserttag[1] = array(
                'value' => $params[0],
                'params' => $variables
            );
        }

        if ($onlyValue) return $inserttag[1];
        else return $inserttag;
    }
}