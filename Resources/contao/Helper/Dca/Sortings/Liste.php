<?php

/**
 * Liste - dca sorting (Liste weil List ein reservierter Begriff ist)
 * --- flag --- Sorting mode (integer) ----------------
 * 1 Sort by initial letter ascending
 * 2 Sort by initial letter descending
 * 3 Sort by initial X letters ascending (see length)
 * 4 Sort by initial X letters descending (see length)
 * 5 Sort by day ascending
 * 6 Sort by day descending
 * 7 Sort by month ascending
 * 8 Sort by month descending
 * 9 Sort by year ascending
 * 10 Sort by year descending
 * 11 Sort ascending
 * 12 Sort descending
 * ----------------------------------------------------
 *
 * --- length --- Sorting length (integer)-------------
 * Allows to specify the number of characters that are
 * used to build sorting groups (flag 3 and 4).
 * ----------------------------------------------------
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Sortings;

class Liste
{
    /**
     * list sorting operation settings
     * @var array
     */
    const SETTINGS = array (
        'mode' => 1,
        'flag' => 1,
        //'length' => 3,
        'fields' => ['name'],
        'headerFields' => ['name'],
        'panelLayout' => 'debug;filter;sort,search,limit',
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }
}