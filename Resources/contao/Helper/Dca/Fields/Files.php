<?php
/**
 * Files - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Files extends Base
{
    /**
     * files field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'               => 'fileTree',
        'exclude'                 => true,
        'eval'                    => array(
            'files' => true,
            'filesOnly' => true,
            'multiple' => true,
            'fieldType' => 'checkbox',
        ),
        'sql'                     => "blob NULL"
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
