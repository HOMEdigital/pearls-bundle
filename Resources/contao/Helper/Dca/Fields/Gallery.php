<?php
/**
 * Gallery - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Gallery extends Base
{
    /**
     * gallery field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'               => 'fileTree',
        'exclude'                 => true,
        'eval'                    => array(
            'multiple'		=> true,
            'fieldType'		=> 'checkbox',
            'isGallery'		=> true,
            'files'=>true,
            'filesOnly'=>true,
            'extensions'=>'jpg,jpeg,gif,png,svg',
        ),
        'sql'                     => "blob NULL"
    );

    /**
     * gallery order field settings
     * @var array
     */
    const ORDER_SETTINGS = array (
        'sql'	    => "blob NULL"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }

    public static function getOrderFieldSettings()
    {
        $orderSettings = self::ORDER_SETTINGS;
        $orderSettings['label'] = $GLOBALS['TL_LANG']['tl_content']['orderSRC'];
        return $orderSettings;
    }
}
