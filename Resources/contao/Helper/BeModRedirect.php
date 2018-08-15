<?php

/**
 * BeModRedirect
 * 
 * Diese Funktion ermöglicht es, in die Backend Modul-Navigationsleitste (auf der linken Seite) Aktionen/Redirects (z.B. Links) einzufügen.
 * 
 * Zum Beispiel zu einem bestimmten CSS oder Module.
 * Aber auch Aktionen wie Wartungsscreen ein-/ausblenden.
 * Example:
    $GLOBALS['BE_MOD']['content']['NachrichtenAktuelles'] = array(
       'callback'   => 'Home\PearlsBundle\Resources\contao\Helper\BeModRedirect',
       'action'     => array('link'=>'/contao/main.php?do=news&table=tl_news&id=1'),
    );
 * 
 * @package    pearls
 * @copyright  HOME - HolsteinMedia
 * @author     Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper;

class BeModRedirect extends \BackendModule
{
	public function generate()
	{
		if (HelperFunctions::array_key_path_exist(array('BE_MOD','content',$this->Input->get('do'),'action', 'link'), $GLOBALS)) {
		    $this->redirect($GLOBALS['BE_MOD']['content'][$this->Input->get('do')]['action']['link']);
        }
	}
	
	protected function compile()
	{
		
	}
}