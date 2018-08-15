<?php
/**
 * Url - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Url extends Base
{
    /**
     * url field settings
     * @var array
     */
    const SETTINGS = array (
        'exclude'                 => true,
        'search'                  => true,
        'inputType'               => 'text',
        'eval'                    => array(
            //'mandatory'=>true,
            'rgxp'=>'url',
            'decodeEntities'=>true,
            'maxlength'=>255,
            'dcaPicker'=>true,
            'tl_class'=>'w50 clr wizard'
        ),
        'sql'                     => "varchar(255) NOT NULL default ''"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}


