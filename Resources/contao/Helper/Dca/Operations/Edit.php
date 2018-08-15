<?php

/**
 * Edit - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

class Edit
{
	/**
	 * edit operation settings
	 * @var array
	 */
	const SETTINGS = array (
        // add c-table as href
        //'href'      => 'table=tl_content',
        'href'      => 'act=edit',
		'icon'      => 'edit.gif'
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}
}