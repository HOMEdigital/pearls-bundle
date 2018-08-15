<?php

/**
 * ToggleNodes - dca global_operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\GlobalOperations;

class ToggleNodes
{
	/**
	 * toggleNodes global_operation settings
	 * @var array
	 */
	const SETTINGS = array (
        'href'                => 'ptg=all',
        'class'               => 'header_toggle',
        'showOnSelect'        => true
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}
}