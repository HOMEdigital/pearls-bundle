<?php
/**
 * integer - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Integer extends Base
{
    /**
     * integer field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'		=> 'text',
        'exclude'		=> true,
        'eval'			=> array('maxlength'=>10),
        'sql'			=> "int(10) NULL",
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}


