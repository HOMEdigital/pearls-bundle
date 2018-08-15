<?php
/**
 * TStamp - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Tstamp extends Base
{
    /**
     * tstamp field settings
     * @var array
     */
    const SETTINGS = array (
        'sql' => "int(10) unsigned NOT NULL default '0'"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
