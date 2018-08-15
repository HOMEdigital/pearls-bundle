<?php
/**
 * Text - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Text extends Base
{
    /**
     * text field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'		=> 'text',
        'exclude'		=> true,
        'eval'			=> array('maxlength'=>255),
        'sql'			=> "varchar(255) NOT NULL default ''",
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
