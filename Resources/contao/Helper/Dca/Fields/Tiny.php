<?php
/**
 * TinyMCE - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Tiny extends Base
{
    /**
     * tinyMCE field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'		=> 'textarea',
        'exclude'		=> true,
        'search'        => true,
        'eval'			=> array('rte'=>'tinyMCE'),
        'sql'			=> "text NULL",
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
