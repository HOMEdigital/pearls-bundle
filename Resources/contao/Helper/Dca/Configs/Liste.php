<?php
/**
 * Base - dca list definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Configs;

class Liste
{
    /**
     * base list settings
     * @var array
     */
    const SETTINGS = array (
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }
}
