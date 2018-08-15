<?php
/**
 * Base - dca list definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Lists;

class Base
{
    /**
     * base list settings
     * @var array
     */
    const SETTINGS = array (
        'sorting' => [],
        'label' => [
            //'fields' => ['name','title'],
            //'format' => '%s (%s)'
            'fields' => ['name'],
            'format' => '%s'
        ],
        'global_operations' => [],
        'operations' => []
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }
}
