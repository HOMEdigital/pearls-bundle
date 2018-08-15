<?php
/**
 * Textarea - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Textarea extends Base
{
    /**
     * textarea field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'		=> 'textarea',
        'exclude'		=> true,
        'search'        => true,
        'eval'			=> array('tl_class'=>'clr'),
        'sql'			=> "text NULL",
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
