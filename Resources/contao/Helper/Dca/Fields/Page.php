<?php
/**
 * Page - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Page extends Base
{
    /**
     * page field settings
     * @var array
     */
    const SETTINGS = array (
        'exclude'                 => true,
        'inputType'               => 'pageTree',
        'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr'),
        'sql'                     => "blob NULL default ''"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
