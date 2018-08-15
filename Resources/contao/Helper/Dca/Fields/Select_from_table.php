<?php
/**
 * Selecttable - dca field definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 *
 *
 * Example:
 * ->addField('select_from_table','taxonomee', array(
 *     'foreignKey'=>'taxonomee.name',
 *     'relation'=>array(
 *         'table'=>'tl_taxonomee',
 *         'type'=>'hasOne',
 *         'load'=>'eager',
 *         'field'=>'id',
 *     )
 * ))
 *
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Fields;

class Select_from_table extends Base
{
    /**
     * selectTable field settings
     * @var array
     */
    const SETTINGS = array (
        'exclude'                 	=> true,
        'inputType'              	=> 'select',
        'sql'                    	=> "varchar(255) NOT NULL default ''",
        // #-- add following fields as settings via addField()
        /*
        'foreignKey'                => 'tl_taxonomee.name',
        'relation' => array(
            'type'=>'hasOne',
            'load'=>'eager',
            'table'=>'tl_taxonomee',
            'field'=>'id',
        ),
        */
    );

    public static function getSettings()
    {
        return array_replace_recursive(parent::getSettings(), self::SETTINGS);
    }
}
