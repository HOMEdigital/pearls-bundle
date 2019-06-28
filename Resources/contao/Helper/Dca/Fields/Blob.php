<?php
/**
 * Alias - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Blob extends Base
{
    /**
     * alias field settings
     * @var array
     */
    const SETTINGS = array (
        'exclude'       => true,
        'search'        => false,
        'filter'        => false,
        'sorting'       => false,
        'sql'           => "blob NULL"
    );

    public static function getSettings()
    {
        return array_merge(parent::getSettings(), self::SETTINGS);
    }
}
