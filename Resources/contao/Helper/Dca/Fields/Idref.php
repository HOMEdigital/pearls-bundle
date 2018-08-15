<?php
/**
 * idref - field definition reference id
 * 
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Idref extends Base
{
    /**
     * idref field settings
     * @var array
     */
    const SETTINGS = array (
        'sql' => "int(10) unsigned NOT NULL"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
