<?php
/**
 * Base - dca list definition
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Configs;
use Home\LibrareeBundle\Resources\contao\models\BasePortfolioModel;

class Tree
{
    /**
     * base list settings
     * @var array
     */
    const SETTINGS = array (
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid' => 'index',
            ]
        ],
        'onsubmit_callback' 			=> array(
            array('Home\PearlsBundle\Resources\contao\Helper\Dca\Configs\Tree', 'onSubmitCallback')
        ),
        'oncut_callback' 				=> array(
            array('Home\PearlsBundle\Resources\contao\Helper\Dca\Configs\Tree', 'onCutCallback')
        ),
        'oncopy_callback' 				=> array(
            array('Home\PearlsBundle\Resources\contao\Helper\Dca\Configs\Tree', 'onCopyCallback')
        ),
        'ondelete_callback' 			=> array(
            array('Home\PearlsBundle\Resources\contao\Helper\Dca\Configs\Tree', 'onDeleteCallback')
        ),
    );

    public static function getSettings()
    {
        return self::SETTINGS;
    }

    /**
     * onsubmit_callback - wird nach dem submit aufgerufen

     * @see Home\Pearls.Form::onSubmitCallback()
     * @param \DataContainer $dc
     * @return \DataContainer
     */
    public function onSubmitCallback(\DataContainer $dc)
    {
        $moduleName = $_GET['do'];
        $modelName = ucfirst($moduleName) . 'PortfolioModel';
        $class = 'Home\LibrareeBundle\Resources\contao\models\\'.$modelName;

        #-- save the type
        $obj = $class::findByIdOrAlias($dc->id);
        if ($obj !== null) {
            // save the portfolio because now the closures are written
            $obj->save();
        }

        return $dc;
    }

    /**
     * @see Home\Pearls.Form::onDeleteCallback()
     */
    public function onDeleteCallback(\DataContainer $dc)
    {
        $moduleName = $_GET['do'];
        $modelName = ucfirst($moduleName) . 'PortfolioModel';
        $class = 'Home\LibrareeBundle\Resources\contao\models\\'.$modelName;
        $closureTable = 'tl_' . $moduleName . '_closures';

        $obj = $class::findByPk($dc->id);
        $obj->deleteClosures($closureTable);
    }

    /**
     * @see Home\Pearls.Form::onCutCallback()
     */
    public function onCutCallback(\DataContainer $dc)
    {
        $this->updateClosure($dc->id, $dc);
    }

    public function onCopyCallback($intId, \DataContainer $dc)
    {
        $this->updateClosure($intId, $dc);
    }

    /**
     * update the closure relations in db for actual item and all children
     *
     * @param $intId
     * @param \DataContainer $dc
     * @return \DataContainer
     */
    public function updateClosure($intId, \DataContainer $dc)
    {
        $moduleName = $_GET['do'];
        $modelName = ucfirst($moduleName) . 'PortfolioModel';
        $class = 'Home\LibrareeBundle\Resources\contao\models\\'.$modelName;
        #-- load data set and save it. needed for updating the closure db table
        $obj = $class::findByPk($intId);
        // model must be refreshed because the findByPk function returns an stored object with the old values
        $obj->refresh();
        $obj->updateClosure();
        return $dc;
    }
}
