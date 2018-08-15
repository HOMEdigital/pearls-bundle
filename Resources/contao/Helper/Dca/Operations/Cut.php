<?php

/**
 * Cut - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

class Cut
{
    /**
     * copy operation settings
     * @var array
     */
    const SETTINGS = array (
        'href' => 'act=paste&amp;mode=cut',
        'icon' => 'cut.gif',
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }
}
