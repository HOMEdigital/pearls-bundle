<?php

/**
 * All - dca global_operation (Mehrere bearbeiten)
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\GlobalOperations;

class All
{
	/**
	 * all global_operation settings (Mehrere bearbeiten)
	 * @var array
	 */
	const SETTINGS = array (
        'href'                => 'act=select',
        'class'               => 'header_edit_all',
        'attributes'          => 'accesskey="e"'
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}
}