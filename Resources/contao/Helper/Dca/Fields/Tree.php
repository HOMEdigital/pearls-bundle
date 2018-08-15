<?php
/**
 * Tree - dca field definition
 *
 * WICHTIG:
 * - Die Erweiterung widget_tree_picker wird benötigt
 *      -> composer require codefog/contao-widget_tree_picker
 * - Im Bereich 'eval' müssen die Werte 'foreignTable' & 'managerHref' gesetzt werden
 *
 * Bsp:
 * array('eval' =>
 *     array(
 *         'foreignTable' => 'tl_lib_portfolio',
 *         'managerHref' => 'do=libraree_portfolio&table=tl_lib_portfolio'
 *     )
 * )
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Tree extends Base
{
    /**
     * tree field settings
     * @var array
     */
    const SETTINGS = array (
        'inputType'	 => 'treePicker',
        'exclude'    => true,
        'sql'        => "blob NULL",
        'eval'       => array (
            'titleField'     => 'name',
            'searchField'    => 'name',
            'fieldType'      => 'checkbox',
            'selectParents'  => false,
            'multiple'       => false,
            'pickerCallback' => array('Home\PearlsBundle\Resources\contao\Helper\Dca\Fields\Tree', 'pickerCallback')
        )
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }

    private static function pickerCallback($row)
    {
        var_dump('pickerCallback');
        return $row['title'] . ' [' . $row['id'] . ']';
    }
}
