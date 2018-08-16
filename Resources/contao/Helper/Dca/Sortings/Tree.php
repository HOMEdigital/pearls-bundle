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
        'panelLayout' => 'debug;filter;sort,search,limit'
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }
}