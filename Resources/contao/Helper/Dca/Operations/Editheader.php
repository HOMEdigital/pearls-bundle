<?php

/**
 * Editheader - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

class Editheader
{
	/**
	 * editheader operation settings
	 * @var array
	 */
	const SETTINGS = array (
        'href'      => 'act=edit',
		'icon'      => 'header.gif'
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}
}