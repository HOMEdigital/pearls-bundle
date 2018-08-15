<?php
/**
 * Id - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Id extends Base
{
    /**
     * id field settings
     * @var array
     */
    const SETTINGS = array (
        'sql' => "int(10) unsigned NOT NULL auto_increment"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
