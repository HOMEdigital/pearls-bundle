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
            'tl_class'=>'w50 wizard'
        ),
        'sql' => "varchar(255) NOT NULL default ''",
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
