<?php
/**
 * MultiColumnWizard - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Mcw extends Base
{
    /**
     * multiColumnWizard field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'               => 'multiColumnWizard',
        'exclude'                 => true,
        //'eval'                    => array(
            //'columnFields' => array(
            // #-- add fields here
            //)
        //),
        'sql'                     => "blob NULL"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
