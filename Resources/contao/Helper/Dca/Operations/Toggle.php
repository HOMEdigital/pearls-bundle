<?php

/**
 * Toggle - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

class Toggle extends \Backend
{
    /**
     * TODO toggle the visibility dos not work
     * toggle operation settings
     * @var array
     */
    const SETTINGS = array (
        'icon'                => 'visible.svg',
        'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
        'button_callback'     => array('Home\PearlsBundle\Resources\contao\Helper\Dca\Operations\Toggle', 'toggleIcon')
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }

    /**
     * button_callback - toggles the visibility icon
     *
     * @param array $arrRow - the current row
     * @param string $href - the url of the embedded link of the button
     * @param string $label - label text for the button
     * @param string $title - title value for the button
     * @param string $icon - url of the image for the button
     * @param string $attributes - additional attributes for the button (fetched from the array key "attributes" in the DCA)
     * @param string $strTable - the name of the current table
     * @param $arrRootIds - array of the ids of the selected "page mounts" (only in tree view)
     * @param $arrChildRecordIds - ids of the childs of the current record (only in tree view)
     * @param boolean $blnCircularReference - determines if this record has a circular reference (used to prevent pasting of an cutted item from an tree into any of it's childs).
     * @param string $strPrevious - id of the previous entry on the same parent/child level. Used for move up/down buttons. Not for root entries in tree view.
     * @param string $strNext - id of the next entry on the same parent/child level. Used for move up/down buttons. Not for root entries in tree view.
     *
     * @return string
     */
    public function toggleIcon($arrRow, $href, $label, $title, $icon, $attributes, $strTable, $arrRootIds, $arrChildRecordIds, $blnCircularReference, $strPrevious, $strNext)
    {
        if ($this->_dcName === null) {
            $this->_dcName = $strTable;
        }

        $this->import('BackendUser', 'User');

        #-- calling the action
        if (strlen(\Input::get('tid')))
        {
            $this->toggleVisibility(\Input::get('tid'), (\Input::get('state') == 1));
            $this->redirect($this->getReferer());
        }

        #-- builing the button
        // Check permissions AFTER checking the tid, so hacking attempts are logged
        /** TODO: checkink the permissions
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_calendar_events::published', 'alexf'))
        {
        return '';
        }
         */

        $href .= '&amp;tid='.$arrRow['id'].'&amp;state='.($arrRow['published'] ? '' : 1);

        if (!$arrRow['published']) {
            $icon = 'invisible.gif';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.\Image::getHtml($icon, $label).'</a> ';
    }

    /**
     * Disable/enable a user group
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        // Check permissions to edit
        \Input::setGet('id', $intId);
        \Input::setGet('act', 'toggle');
        // $this->checkPermission(); /** TODO: check the permission */

        // Check permissions to publish
        /*
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_calendar_events::published', 'alexf'))
        {
            $this->log('Not enough permissions to publish/unpublish event ID "'.$intId.'"', __METHOD__, TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }
        */

        $objVersions = new \Versions($this->_dcName, $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA'][$this->_dcName]['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA'][$this->_dcName]['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $this);
                }
            }
        }

        // Update the database
        /** TODO: hier sollte keine Datenbank Abfrage drinstehen. Dies sollte über ein Model/Broker passieren. Jedoch habe ich den Model Name nicht, da es sich ja um eine globale operation handelt... */
        $db   = \Database::getInstance();
        $db->prepare('UPDATE '.$this->_dcName.' SET tstamp='.time().', published="'. ($blnVisible ? 1 : '').'" WHERE id=?')
            ->execute($intId);

        $objVersions->create();
        $this->log('A new version of record "'.$this->_dcName.'.id='.$intId.'" has been created'.$this->getParentEntries($this->_dcName, $intId), __METHOD__, TL_GENERAL);

    }
}