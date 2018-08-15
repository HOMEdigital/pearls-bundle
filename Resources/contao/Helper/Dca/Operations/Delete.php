<?php

/**
 * Delete - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

class Delete
{
	/**
	 * delete operation settings
     * example:
     * ->addOperation('delete','delete',array('attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;"'))
     *
	 * @var array
	 */
	const SETTINGS = array (
        'href' => 'act=delete',
        'icon' => 'delete.gif',
        //'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;"',
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}
}