<?php
/**
 * Checkbox - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Checkbox extends Base
{
    /**
     * checkbox field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'         => 'checkbox',
        'exclude'			=> true,
        'sql'               => "char(1) NOT NULL default ''"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
