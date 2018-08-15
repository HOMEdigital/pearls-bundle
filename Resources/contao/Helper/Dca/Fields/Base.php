<?php 
/**
 * Base - the dca field abstract
*
* @category		pearls
* @copyright	HOME
* @author		Dirk Holstein <dh@holsteinmedia.com>
*/

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Base
{
	/**
	 * base fild settings
	 * @var array
	 */
	const SETTINGS = array (
	);
	
	public static function getSettings()
	{

		return self::SETTINGS;
	}
}