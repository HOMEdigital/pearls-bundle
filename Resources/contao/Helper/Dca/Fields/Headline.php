<?php
/**
 * Headline - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Headline extends Base
{
    /**
     * headline field settings
     * @var array
     */
    const SETTINGS = array (
        'exclude'                 => true,
        'search'                  => true,
        'inputType'               => 'inputUnit',
        'options'                 => array('h2', 'h3', 'h4', 'h5', 'h6'),
        'eval'                    => array('maxlength'=>200),
        'sql'                     => "varchar(255) NOT NULL default ''"
    );

    public static function getSettings()
    {
        return array_merge(parent::getSettings(), self::SETTINGS);
    }
}
