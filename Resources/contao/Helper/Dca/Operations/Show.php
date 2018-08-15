<?php

/**
 * Show - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

class Show
{
	/**
	 * show operation settings
	 * @var array
	 */
	const SETTINGS = array (
        'href' => 'act=show',
        'icon' => 'show.gif'
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}
}