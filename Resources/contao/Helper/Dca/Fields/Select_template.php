<?php
/**
 * Select Template - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 *
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Select_template extends Base
{
    /**
     * select_template field settings
     * @var array
     */
    const SETTINGS = array (
        'exclude'                 	=> true,
        'inputType'              	=> 'select',
        'sql'                    	=> "varchar(255) NOT NULL default ''",
        'options_callback'      => array('Home\PearlsBundle\Resources\contao\Helper\Dca\Fields\Select_template', 'getTemplateOptions'),
        'eval' => array(
            'includeBlankOption' => true,
            'tl_class' => 'w50 clr',
            'chosen' => true,
        ),
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }

    public static function getTemplateOptions(\DataContainer $dc)
    {

        $prefix = $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['tempPrefix'];
        if($prefix){
            $return = \TemplateLoader::getPrefixedFiles($prefix);
            sort($return);
            return $return;
        }else{
            return array();
        }
    }
}
