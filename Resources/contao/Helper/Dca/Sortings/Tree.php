<?php

/**
 * Tree - dca sorting
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Sortings;

class Tree extends \Backend
{
    /**
     * tree sorting operation settings
     * @var array
     */
    const SETTINGS = array (
        'mode' => 5,
        'fields' => ['name'],
        'headerFields' => ['name'],
        'panelLayout' => 'debug;filter;sort,search,limit',
        'paste_button_callback'   => array('Home\PearlsBundle\Resources\contao\Helper\Dca\Sortings\Tree', 'pasteElement')
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }

    public function pasteElement($dc, $row, $table)
    {
        $imagePasteAfter = \Image::getHtml('pasteafter.gif', sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id']));
        return '<a href="'.$this->addToUrl('act=cut&mode=1&pid='.$row['id']).'" title="'.specialchars(sprintf($GLOBALS['TL_LANG'][$table]['pasteafter'][1], $row['id'])).'" onclick="Backend.getScrollOffset()">'.$imagePasteAfter.'</a> ';

    }
}