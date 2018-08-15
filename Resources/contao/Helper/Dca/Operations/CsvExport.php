<?php

/**
 * Edit - dca operation
 *
 * @category	pearls
 * @copyright	HOME
 * @author		Dirk Holstein <dh@holsteinmedia.com>
 */

namespace Home\PearlsBundle\Resources\contao\Helper\Dca\Operations;

use Home\LibrareeBundle\Resources\contao\models\BaseClosuresModel;

class CsvExport
{
	/**
	 * edit operation settings
	 * @var array
	 */
	const SETTINGS = array (
        'href'      => 'key=csvExport',
		'icon'      => 'diff.gif'
	);
	
	public static function getSettings()
	{
		return self::SETTINGS;
	}

    public static function exportAsCsv()
    {
        $id = $_GET['id'];
        $do = $_GET['do'];

        if($id && $id > 0 && $do){
            $pids = BaseClosuresModel::findChildren($id, 0, 'tl_' . $do . '_closures');

            $sql = '
                SELECT *
                FROM tl_' . $do . '_pin
                WHERE pid IN (' . implode(',', $pids) . ')
            ';

            $db = \Contao\Database::getInstance();
            $pins = $db->prepare($sql)->execute()->fetchAllAssoc();

            $sql = '
                SELECT *
                FROM tl_' . $do . '_portfolio
                WHERE id IN (' . implode(',', $pids) . ')
            ';
            $portfolios = $db->prepare($sql)->execute()->fetchAllAssoc();
            $portfolioArr = array();
            if(is_array($portfolios) && count($portfolios) > 0){
                foreach ($portfolios as $portfolio){
                    $portfolioArr[$portfolio['id']] = $portfolio;
                }
            }

            if(is_array($pins) && count($pins) > 0){
                $fileName = 'export.csv';
                $exportArr = array(
                    0 => array(
                        'Parent Name',
                        'Id',
                        'Name',
                        'Titel',
                    )
                );

                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header('Content-Description: File Transfer');
                header("Content-type: text/csv");
                header("Content-Disposition: attachment; filename={$fileName}");
                header("Expires: 0");
                header("Pragma: public");

                $csv = @fopen( 'php://output', 'w' );

                fputs($csv, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
                fputcsv($csv, $exportArr[0]);

                foreach ($pins as $key => $pin){
                    if(array_key_exists($pin['pid'], $portfolioArr)){
                        $exportArr[$key] = array(
                            '"'.$portfolioArr[$pin['pid']]['name'].'"',
                            $pin['id'],
                            $pin['name'],
                            $pin['title']
                        );
                    }else{
                        $exportArr[$key] = array(
                            '',
                            $pin['id'],
                            $pin['name'],
                            $pin['title']
                        );
                    }
                    fputcsv($csv, $exportArr[$key]);
                }
                fclose($csv);
                exit;
            }
            exit;
        }
    }

}