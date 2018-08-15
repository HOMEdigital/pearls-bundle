<?php
/**
 * Select - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 *
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Select_article extends Select
{
    /**
     * select field settings
     * @var array
     */
    const SETTINGS = array (
        'options'                   => array(
            'options_callback'      => array('Home\PearlsBundle\Resources\contao\Helper\Dca\Fields\Select_article', 'getArticleAlias'),
            'eval'                  => array('chosen'=>true),
            'sql'                   => "int(10) unsigned NOT NULL default '0'"
        )
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }

    /**
     * this function is copied from contao core and modified so it will work in FE Modules too
     *
     * @param \DataContainer $dc
     * @see core\dca\tl_content
     */
    public function getArticleAlias(\DataContainer $dc) {
        $arrPids = array();
        $arrAlias = array();
        $this->import('BackendUser', 'User');

        if ($dc->ptable == "tl_article") { // then it is a content element
            if (!$this->User->isAdmin)
            {
                foreach ($this->User->pagemounts as $id)
                {
                    $arrPids[] = $id;
                    $arrPids = array_merge($arrPids, $this->Database->getChildRecords($id, 'tl_page'));
                }

                if (empty($arrPids))
                {
                    return $arrAlias;
                }

                $objAlias = $this->Database->prepare("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid WHERE a.pid IN(". implode(',', array_map('intval', array_unique($arrPids))) .") AND a.id!=(SELECT pid FROM tl_content WHERE id=?) ORDER BY parent, a.sorting")
                    ->execute($dc->id);
            }
            else
            {
                $objAlias = $this->Database->prepare("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid WHERE a.id!=(SELECT pid FROM tl_content WHERE id=?) ORDER BY parent, a.sorting")
                    ->execute($dc->id);
            }
        } else { // here it is a fe module element
            $objAlias = $this->Database->prepare("SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid ORDER BY parent, a.sorting")
                ->execute($dc->id);
        }

        if ($objAlias->numRows)
        {
            \System::loadLanguageFile('tl_article');

            while ($objAlias->next())
            {
                $key = $objAlias->parent . ' (ID ' . $objAlias->pid . ')';
                $arrAlias[$key][$objAlias->id] = $objAlias->title . ' (' . ($GLOBALS['TL_LANG']['tl_article'][$objAlias->inColumn] ?: $objAlias->inColumn) . ', ID ' . $objAlias->id . ')';
            }
        }

        return $arrAlias;
    }
}
