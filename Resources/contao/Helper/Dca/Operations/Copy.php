<?php

/**
 * Copy - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

class Copy
{
	/**
	 * copy operation settings
	 * @var array
	 */
	const SETTINGS = array (
        'href' => 'act=copy',
        'icon' => 'copy.gif',
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}
}