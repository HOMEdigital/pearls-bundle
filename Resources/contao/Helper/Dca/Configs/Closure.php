<?php
/**
 * Base - dca list definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Configs;

class Closure
{
    /**
     * base list settings
     * @var array
     */
    const SETTINGS = array (
        'dataContainer' => 'Table',
        'sql' => array (
            'keys' => array	(
                'ancestor_id' 	=> 'index',
                'descendant_id'	=> 'index'
            )
        )
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }
}
