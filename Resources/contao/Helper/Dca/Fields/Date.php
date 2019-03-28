<?php
/**
 * Date - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Date extends Base
{
    /**
     * date field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType' => 'text',
        'exclude' => true,
        'eval' => array(
            'rgxp'=>'datim',
            'datepicker'=>true,
            'tl_class'=>'w50 wizard clr'
        ),
        'sql' => "int(10) unsigned NOT NULL default '0'",
        'save_callback' => array(
            array('Home\PearlsBundle\Resources\contao\Helper\Dca\Fields\Date','onSave'),
        ),
        'load_callback' => array(
            array('Home\PearlsBundle\Resources\contao\Helper\Dca\Fields\Date','onLoad'),
        ),
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }

    public static function onLoad($varValue, $dc)
    {
        if($varValue && $varValue !== 0){
            return $varValue;
        }else{
            return time();
        }
    }

    public static function onSave($varValue, $dc)
    {
        if($varValue && $varValue !== 0){
            return $varValue;
        }else{
            return time();
        }
    }
}
