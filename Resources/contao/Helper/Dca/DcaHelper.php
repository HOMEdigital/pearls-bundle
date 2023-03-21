<?php
/**
 * dca class
 * 
 * @package    pearls
 * @copyright  HOME - HolsteinMedia
 * @author     Dirk Holstein <dh@holsteinmedia.com>
 *
 */
namespace Home\PearlsBundle\Resources\contao\Helper\Dca;


class DcaHelper
{
	/**
	 * $_dcName - data container name like 'tl_calendar'
	 * @var string
	 * @var string
	 */
	protected $_dcName = '';
	
	/**
	 * $_tlDca - shortcut for the GLOBALS dca
	 * @var string
	 */
	protected $_tlDca = '';
	
	public function __construct($dcName)
	{
		if (!$dcName ||!is_string($dcName) || $dcName == "")
			throw new \Exception('Pearls\DCA: Parameter dcName is missing');
		
		$this->_dcName = $dcName;
		$this->_tlDca = &$GLOBALS['TL_DCA'][$this->_dcName];
	}

    /* ++++++++++++++++++++++++++ CONFIG ++++++++++++++++++++++++ */

    /**
     * adds config settings to dca
     *
     * @param null $presetName
     * @param array $settings
     * @return $this
     */
    public function addConfig($presetName=null, $settings=array())
    {
        #-- set settings
        $presetName = self::determinePresetname('config', $presetName);
        $settings = $this->determineSettings($presetName, $settings);

        #-- set sorting
        array_insert($this->_tlDca['config'], 0, $settings);
        return $this;
    }
	
	/* ++++++++++++++++++++++++++ LIST ++++++++++++++++++++++++++ */
	
	/**
	 * settings from an specific list; overwrite existing ones
	 *
	 * @param string $listKey - the list key in GLOBALS dca
	 * @param string $settingsKey - the settings key in GLOBALS dca
	 * @param $settings $settings - the new settings
     *
     * @return $this
	 */
	public function setListSettings($listKey, $settingsKey, $settings)
	{				
		if ($this->dcaKeyExist(array('list', $listKey))) {
			$this->_tlDca['list'][$listKey][$settingsKey] = $settings;
		}		
		return $this;
	}

    /**
     * adds list settings to dca
     *
     * @param null $presetName
     * @param array $settings
     * @return $this
     */
    public function addList($presetName=null, $settings=array())
    {
        #-- set settings
        $presetName = self::determinePresetname('list', $presetName);
        $settings = $this->determineSettings($presetName, $settings);

        #-- set sorting
        array_insert($this->_tlDca['list'], 0, $settings);
        return $this;
    }

    /* ++++++++++++++++++++++++++ SORTING ++++++++++++++++++++++++++ */

    /**
     * add sorting to dca
     *
     * @param null $presetName - operation presetName; if contains '\\' load own preset otherwise load preset from Home\Pearls\Dca\Sorting
     * @param null $key - operation key in the GLOBALS entry
     * @param array $settings - operation settings will be added to the preset settings
     * @return $this
     * @throws \Exception
     */
    public function addSorting($presetName=null, $key=null, $settings=array())
    {
        #-- set key
        if (($key === NULL || $key === "") && $presetName) {
            $key = $presetName;
        }

        if (!$key || $key == "")
            throw new \Exception('Pearls\DCA: addSorting: neither $key- or $preset-Paramter are set');

        #-- set settings
        $presetName = self::determinePresetname('sorting', $presetName);
        $settings = $this->determineSettings($presetName, $settings);

        #-- set sorting
        array_insert($this->_tlDca['list']['sorting'], 0, $settings);
        return $this;
    }
	
	/* ++++++++++++++++++++++++++ OPERATIONS ++++++++++++++++++++++++++ */

    /**
     * add operation to dca
     *
     * @param null $presetName - operation presetName; if contains '\\' load own preset otherwise load preset from Home\Pearls\Dca\Operations
     * @param null $key - operation key in the GLOBALS entry
     * @param array $settings - operation settings will be added to the preset settings
     * @param string $pos - adds the operation at specific position; if set to "last" it will be set to last position; if set < 0 (like -1) it will count the position from the end (e.g. -1 will be the second last position)
     * @return $this
     * @throws \Exception
     */
	public function addOperation($presetName=null, $key=null, $settings=array(), $pos='_last')
	{
		#-- set key
		if (($key === NULL || $key === "") && $presetName) {
			$key = $presetName;
		} 
		
		if (!$key || $key == "")
			throw new \Exception('Pearls\DCA: addOperation: neither $key- or $preset-Paramter are set');
		
		#-- set settings
        if ($presetName) {
            $presetName = self::determinePresetname('operation', $presetName);
            $settings = $this->determineSettings($presetName, $settings);
        }

		#-- set label
		$settings['label'] = $GLOBALS['TL_LANG'][$this->_dcName][$key];	

		#-- set operation
		$pos = self::determinePos($this->_tlDca['list']['operations'], $pos);	
		array_insert($this->_tlDca['list']['operations'], $pos, array($key=>$settings));		
		return $this;
	}

    /**
     * add global_operation to dca
     *
     * @param null $presetName - global_operation presetName; if contains '\\' load own preset otherwise load preset from Home\Pearls\Dca\GlobalOperations
     * @param null $key - operation key in the GLOBALS entry
     * @param array $settings - operation settings will be added to the preset settings
     * @param string $pos - adds the operation at specific position; if set to "last" it will be set to last position; if set < 0 (like -1) it will count the position from the end (e.g. -1 will be the second last position)
     * @return $this
     * @throws \Exception
     */
    public function addGlobalOperation($presetName=null, $key=null, $settings=array(), $pos='_last')
    {
        #-- set key
        if (($key === NULL || $key === "") && $presetName) {
            $key = $presetName;
        }

        if (!$key || $key == "")
            throw new \Exception('Pearls\DCA: addGlobalOperation: neither $key- or $preset-Paramter are set');

        #-- set settings
        if ($presetName) {
            $presetName = self::determinePresetname('global_operation', $presetName);
            $settings = $this->determineSettings($presetName, $settings);
        }

        #-- set label
        //$settings['label'] = $GLOBALS['TL_LANG'][$this->_dcName][$key];
        $settings['label'] = $GLOBALS['TL_LANG']['MSC'][$key];

        #-- set operation
        $pos = self::determinePos($this->_tlDca['list']['global_operations'], $pos);
        array_insert($this->_tlDca['list']['global_operations'], $pos, array($key=>$settings));
        return $this;
    }
	
	/**
	 * remove operation from dca
	 *
	 * @param string $key - the operation key in the GLOBALS array
	 * @return $this
	 */
	public function removeOperation($key)
	{
		if (!$key || $key =="")
			return false;
		
		if ($this->dcaKeyExist(array('list', 'operations', $key))) {
			unset($this->_tlDca['list']['operations'][$key]);
		}
		return $this;
	}
	
	/* ++++++++++++++++++++++++++ PALETTES ++++++++++++++++++++++++++ */
	
	/**
	 * removes an complete palette
	 *
	 * @param string $paletteKey - the key the palette is stored in GLOBALS
	 * @return $this
	 */
	public function removePalette($paletteKey)
	{		
		#-- remove group
		if ($this->dcaKeyExist(array('palettes', $paletteKey))) {
			unset($this->_tlDca['palettes'][$paletteKey]);
		}
		
		return $this;
	}
	
	/**
	 * add an palette group to a specific position. 
	 * IMPORTANT: If the paletteKey and|or the $groupLegend already exists it will be overwritten.
	 * 
	 * @param string $groupLegend - will also be the group legend string ($groupLegend+'_legend')
	 * @param array $fields - the fields to add
	 * @param string $paletteKey ['default'] - the key the palette is stored in GLOBALS
	 * @param int|string $pos [last] - the position to insert the new group; if set to "last" it will be set to last position; if set < 0 (like -1) it will count the position from the end (e.g. -1 will be the second last position)
	 * @param bool $hide [false] - should the label group be shown or not
	 * @return $this
	 */
	public function addPaletteGroup($groupLegend, array $fields, $paletteKey = "default", $pos = '_last', $hide = false)
	{
		#-- get existing palette
		$palette = $this->importPalette($paletteKey);

		#-- set parameter
		$groupLegend = $groupLegend.'_legend';
		$pos = self::determinePos($palette, $pos);
		
		#-- delete old group if exists
		if (array_key_exists($groupLegend, $palette)) {
			unset($palette[$groupLegend]);
		}
		
		#-- insert new group and export it to GLOBALS
		$group = array(
			$groupLegend => array(
				'values' => $fields, 
				'hide' => $hide
			)
		);
		array_insert($palette, $pos, $group);	
		if ($this->_tlDca != '' && $palette && is_array($palette) && count($palette) > 0) {
			$this->_tlDca['palettes'][$paletteKey] = $this->convertPalette2String($palette);
		}
	
		return $this;
	}
	
	/**
	 * removes an group from an palette
	 *
	 * @param string $groupLegend - will also be the group legend string ($groupLegend+'_legend')
	 * @param string $paletteKey ['default'] - the key the palette is stored in GLOBALS
	 * @return $this
	 */
	public function removePaletteGroup($groupLegend, $paletteKey = "default")
	{		
		#-- get existing palette
		$palette = $this->importPalette($paletteKey);
		
		#-- remove group
		if (array_key_exists($groupLegend, $palette)) {
			unset($palette[$groupLegend]);
		}
		
		#-- export to GLOBALS
		$this->_tlDca['palettes'][$paletteKey] = $this->convertPalette2String($palette);
		
		return $this;
	}

    /**
     * @param $paletteKey
     * @param $newPaletteKey
     * @return $this
     */
	public function copyPalette($paletteKey, $newPaletteKey)
    {
        $origPalette = $this->importPalette($paletteKey);

        $this->_tlDca['palettes'][$newPaletteKey] = $this->convertPalette2String($origPalette);

        return $this;
    }
	
	/* ++++++++++++++++++++++++++ FIELDS ++++++++++++++++++++++++++ */
	
	/**
	 * settings from an specific field; overwrite existing ones
	 *
	 * @param string $fieldKey - the field key in GLOBALS dca
	 * @param string $settingsKey - the settings key in GLOBALS dca
	 * @param $settings - the new settings
     * @return $this
	 */
	public function setFieldSettings($fieldKey, $settingsKey, $settings)
	{		
		if ($this->dcaKeyExist(array('fields', $fieldKey))) {
			$this->_tlDca['fields'][$fieldKey][$settingsKey] = $settings;
		}		
		return $this;
	}

    /**
     * merge the settings from an specific field with the existing ones
     * needed e.g. for 'eval' array
     *
     * @param string $fieldKey - the field key in GLOBALS dca
     * @param string $settingsKey - the settings key in GLOBALS dca
     * @param array $settings - the new settings
     * @return $this
     */
    public function mergeFieldSettings($fieldKey, $settingsKey, $settings)
    {
        if (is_array($settings) && $this->dcaKeyExist(array('fields', $fieldKey))) {
            $this->_tlDca['fields'][$fieldKey][$settingsKey] = array_replace_recursive($this->_tlDca['fields'][$fieldKey][$settingsKey], $settings);
        }
        return $this;
    }

    /**
     * add field to dca
     *
     * @param null $presetName - field preset name
     * @param null $fieldKey - field key
     * @param null $settings - field settings
     * @return $this
     * @throws \Exception
     */
	public function addField($presetName=null, $fieldKey=null, $settings=null)
	{
		#-- set fieldKey
		if (($fieldKey === NULL || $fieldKey === "") && $presetName) {
			$fieldKey = $presetName;
		}

		if (!$fieldKey || $fieldKey == "")
			throw new \Exception('Pearls\DCA: addField: neither $key- or $preset-Paramter are set');

		#-- set the presetClass and settings
        	$presetClass = self::determinePresetname('field', $presetName);
		$settings = $this->determineSettings($presetClass, $settings);

		#-- set label
		if(
		    is_array($GLOBALS['TL_LANG']) &&
		    array_key_exists($this->_dcName, $GLOBALS['TL_LANG']) &&
		    is_array($GLOBALS['TL_LANG'][$this->_dcName]) &&
		    array_key_exists($fieldKey, $GLOBALS['TL_LANG'][$this->_dcName]))
		{
			$settings['label'] = $GLOBALS['TL_LANG'][$this->_dcName][$fieldKey];
		}

		#-- set field
		$this->_tlDca['fields'][$fieldKey] = $settings;

		#-- special behaviours
		if ($presetName == 'gallery') {
		    // +-- set order field name in gallery field
			$this->mergeFieldSettings($fieldKey, 'eval', array('orderField' => $fieldKey.'Order'));
			// +-- set field order
			$this->_tlDca['fields'][$this->_tlDca['fields'][$fieldKey]['eval']['orderField']] = $presetClass::getOrderFieldSettings();
		}

		return $this;
	}

    /**
     * return Field config for rsce_config
     *
     * @param null $presetName
     * @param null $fieldKey
     * @param null $givenSettings
     * @return array|null|string
     * @throws \Exception
     */
    public static function getField($presetName=null, $fieldKey=null, $givenSettings=null)
    {
        #-- set fieldKey
        if (($fieldKey === NULL || $fieldKey === "") && $presetName) {
            $fieldKey = $presetName;
        }

        if (!$fieldKey || $fieldKey == ""){
            return '';
        }

        $presetClass = self::determinePresetname('field', $presetName);
        $settings = array();

        #-- if no preset and no givenSettings
        if ((!$presetClass || $presetClass == "") && !$givenSettings)
            return $settings;

        #-- no preset, just the givenSettings
        if ((!$presetClass || $presetClass == "") && $givenSettings)
            return $givenSettings;

        #-- get settings
        if (is_array($givenSettings) && count($givenSettings) > 0) {
            $settings = array_replace_recursive($presetClass::getSettings(), $givenSettings);
        } else {
            $settings = $presetClass::getSettings();
        }

        if(is_array($settings) && count($settings) > 0){
            foreach ($settings as $key => $setting){
                if($key == 'sql' || $key == 'exclude'){
                    unset($settings[$key]);
                }
            }
        }

        return $settings;
    }
	
	/* ++++++++++++++++++++++++++ INTERN ++++++++++++++++++++++++++ */
	
	/**
	 * determine the full presetname from $presetName or pearls presets with namespace
	 *  
	 * @param string $presetType - ['field', 'operation', ...] needed for path to pearls presets
	 * @param string $presetName
	 * @return string - the $presetClass
     * @throws \Exception
	 */
	private static function determinePresetname($presetType, $presetName)
	{
		$presetClass = "";

	    if (!strstr($presetName, '\\')) {
			#-- get pearls preset
			switch ($presetType) {
			    //Home\PearlsBundle\Resources\contao\Helper\Dca
                case 'config': 	            $presetClass = 'Home\\PearlsBundle\\Resources\\contao\\Helper\\Dca\\Configs\\'.ucfirst($presetName);
                break;
                case 'list': 	            $presetClass = 'Home\\PearlsBundle\\Resources\\contao\\Helper\\Dca\\Lists\\'.ucfirst($presetName);
                break;
                case 'sorting': 	        $presetClass = 'Home\\PearlsBundle\\Resources\\contao\\Helper\\Dca\\Sortings\\'.ucfirst($presetName);
                break;
				case 'field': 		        $presetClass = 'Home\\PearlsBundle\\Resources\\contao\\Helper\\Dca\\Fields\\'.ucfirst($presetName);
				break;
				case 'operation':	        $presetClass = 'Home\\PearlsBundle\\Resources\\contao\\Helper\\Dca\\Operations\\'.ucfirst($presetName);
				break;
                case 'global_operation':    $presetClass = 'Home\\PearlsBundle\\Resources\\contao\\Helper\\Dca\\GlobalOperations\\'.ucfirst($presetName);
                break;
			}
		} else {
	        $presetClass = $presetName;
        }
		
		if ($presetClass === "" || !strstr($presetClass, '\\'))
			throw new \Exception('Pearls\DCA: mergeSettingsWithPreset: the preset can not be found', $presetClass);
		
		return $presetClass;
	}

    /**
     * determine the settings because of an preset (if specified) and merge the preset settings with the given settings
     *
     * @param $presetClass - the preset class
     * @param array $givenSettings - the settings to merge with the preset (if specified)
     * @return array - the merged settings array
     * @throws \Exception
     */
	private function determineSettings($presetClass, $givenSettings = array())
	{
		$settings = array();
		
		#-- if no preset and no givenSettings
		if ((!$presetClass || $presetClass == "") && !$givenSettings)
			return $settings;
		
		#-- no preset, just the givenSettings
		if ((!$presetClass || $presetClass == "") && $givenSettings)
			return $givenSettings;		

		#-- get settings
		if (is_array($givenSettings) && count($givenSettings) > 0) {
			$settings = array_replace_recursive($presetClass::getSettings(), $givenSettings);
		} else {
			$settings = $presetClass::getSettings();
		}
		
		if (!is_array($settings) || count($settings) < 1)
			throw new \Exception('Pearls\DCA: mergeSettingsWithPreset: there are no settings for this operation', $settings);
		
		return $settings;
	}
	
	/**
	 * recursively check if an DCA key exists
	 * e.g. $keys = array('TL_DCA','tl_content','config')
	 * @param array $keys
	 * @return bool
	 */
	private function dcaKeyExist(array $keys)
	{
		$globalsTca = $this->_tlDca;		
		foreach($keys as $key) {	
			if (array_key_exists($key, $globalsTca)) {
				$globalsTca = $globalsTca[$key];				
			} else {
				return false;
			}
		}	
		return true;
	}
	
	/**
	 * determines the correct position
	 * $pos is >= 0 --> 0|1: the first position; 2: the second position; ...
	 * $pos is < 0 --> -1: the second last position; -2: the third last position; ...
	 * $pos is '_last': the last position
	 * $pos is string: the position BEFORE the entry with the key $pos
	 * 
	 * @param array $array - the array to insert a new value on pos
	 * @pos int|string - the position
	 * @return int 
	 */
	private static function determinePos($array, $pos)
	{		
		if ($pos === 0) {
			return 0;
		} else if ($pos == '_last') {		
			#-- last position
			return count($array);
		} else if (is_int($pos) && $pos < 0) {
			#-- negative value
			return count($array) + $pos;
		} else if (is_string($pos)) {
			#-- key string
			return array_search($pos, array_keys($array));
		}
	
		return $pos > 0 ? $pos - 1 : $pos;
	}
	
	/**
	 * import the palette string from GLOBALS dca an convert it to an array
	 * array(
	 *		groupname => array(
	 *			'values' => string - the palette group field name e.g. 'title_legend'
	 *			'hide' => true|false - show or hide the palette group
	 *  	)
	 * )
	 *
	 * @param string $paletteKey - the key the palette is stored in GLOBALS
	 * @return array | null if $palette has no entries
	 */
	private function importPalette($paletteKey)
	{
		$palette = array();
		
		if (!$this->dcaKeyExist(array('palettes', $paletteKey)))
			return $palette;

		$importedArray = array_unique(trimsplit('[,;]', $this->_tlDca['palettes'][$paletteKey]));		
		
		if (is_array($importedArray)) {
			$groupName = 0;
			foreach($importedArray as $importedValue) {
				if (substr($importedValue, 0,1) == "{") { #-- set palette group
					$v = trimsplit(':', substr($importedValue, 1, strlen($importedValue)-2 ));
					$groupName = $v[0];
					$palette[$groupName]['values'] = array();
					if(array_key_exists('1', $v)){
						$palette[$groupName]['hide'] = ($v[1] == "hide")? true : false; // the :hide-Paramter
					}
				} else { #-- set palette field
					$palette[$groupName]['values'][] = $importedValue;
				}
			}
		}
		return $palette;
	}
	
	/**
	 * convert the palette array to an contao palette string
	 * 
	 * @param array $palette - the array defined returned from importPalette function
	 * @return string - the contao palette string definition
	 */
	private function convertPalette2String(array $palette)
	{
		$string = "";
		foreach($palette as $key=>$group) {
			#-- add palette group header to palette string
			if (is_string($key)) {
				$hide = array_key_exists('hide', $group) && $group['hide'] === true ? ":hide" : "";
				$string .= $string != "" ? ";" : "";
				$string .= "{".$key.$hide."},";
			}
	
			#-- add fields to palette string
			if (array_key_exists('values', $group) && is_array($group['values'])) {
				$string .= implode(',', $group['values']);
			}
		}
		
		return $string;
	}

	/**
	 * creates an array needed for the select box from any array like the db result array
	 *
	 * @param array $data - the data to convert. can be a simple array or an Contao\Collection object
	 * @param string $keyString - key whose value will be the new key
	 * @param string|array $valueString - key whose value will be the new value
	 * @param string $glue - if $valueString is an array, the keys will be glued together
	 * @return array
	 */
	public static function makeSelectOptionsArray($data, $keyString, $valueString, $glue=null)
	{
		return (is_a($data, 'Contao\Model\Collection')) ? self::_makeOptionsArrayFromObject($data, $keyString, $valueString, false, $glue) : self::_makeOptionsArrayFromArray($data, $keyString, $valueString, false, $glue);
	}

	/**
	 * creates an grouped array needed for the select box from any array like the db result array
	 *
	 * @param array $data - the data to convert. can be a simple array or an Contao\Collection object
	 * @param string $keyString - key whose value will be the new key
	 * @param string|array $valueString - key whose value will be the new value
	 * @param string $glue - if $valueString is an array, the keys will be glued together
	 * @return array
	 */
	public static function makeSelectOptionsGroupArray($data, $keyString, $valueString, $glue=null)
	{
		return (is_a($data, 'Contao\Model\Collection')) ? self::_makeOptionsArrayFromObject($data, $keyString, $valueString, true, $glue) : self::_makeOptionsArrayFromArray($data, $keyString, $valueString, true, $glue);
	}

	/**
	 * creates an options array (grouped or ungrouped) from Contao\Model\Collection
	 *
	 * @param Collection $objCollection - the contao collection object
	 * @param string $key4newKey - key whose value will be the new key
	 * @param string $key4newValue - key whose value will be the new value
	 * @param bool $grouped [false]
	 * @return multitype:NULL
	 */
	protected static function _makeOptionsArrayFromObject($objCollection, $key4newKey, $key4newValue, $grouped=false, $glue=null)
	{
		$arrReturn = array();
		$keys = array(); // save all pid=0 values for optgroup keys
		$arrData = $objCollection->fetchAll();

		if (empty($arrData)) {
			return $arrReturn;
		}

		#-- create array
		foreach($arrData as $data) {
			// get value


			if ($grouped && $data['pid'] == 0) {
				$arrReturn[$data['id']] = array();
				$keys[$data['id']] = $data[$key4newValue];
			} else if($grouped) {
				if (array_key_exists($data['pid'], $arrReturn)) { // if the parent exists in return array; if it is a grandchild then the parentId does not exists
					$arrReturn[$data['pid']][$data[$key4newKey]] = $data[$key4newValue];
				} else {
					$arrReturn[self::_findFirstParent($arrData, $data['pid'])][$data[$key4newKey]] = $data[$key4newValue];
				}
			} else {
				if (is_array($key4newValue)) {
					$values = "";
					forEach($key4newValue as $single) {
						$values[] = $data[$single];
					}
					$value = implode($glue, $values);

				} else {
					$value = $data[$key4newValue];
				}
				$arrReturn[$data[$key4newKey]] = $value;
			}
		}

		#-- add optgroupvalues
		if ($grouped && count($arrReturn) > 0) {
			foreach($arrReturn as $key=>$value) {
				if (is_array($value)) {
					$arrReturn[$keys[$key]] = $value;
					unset($arrReturn[$key]);
				}
			}
		}

		return $arrReturn;
	}

	/**
	 * creates an options array (grouped or ungrouped) from array
	 *
	 * @param array $arrData - the data array
	 * @param string $key4newKey - key whose value will be the new key
	 * @param string $key4newValue - key whose value will be the new value
	 * @param bool $grouped [false]
	 * @return multitype:NULL
	 */
	protected static function _makeOptionsArrayFromArray($arrData, $key4newKey, $key4newValue, $grouped=false, $glue=null)
	{
		$arrReturn = array();

		if (!is_array($arrData) || empty($arrData)) {
			return $arrReturn;
		}

		foreach($arrData as $data) {
			if ($grouped && is_array($data)) {
				$arrReturn[$data[$key4newKey]] = self::_makeOptionsArrayFromArray($data, $key4newKey, $key4newValue, $grouped);
			} else {
				if (is_array($key4newValue)) {
					$values = "";
					forEach($key4newValue as $single) {
						$values[] = $data[$single];
					}
					$value = implode($glue, $values);

				} else {
					$value = $data[$key4newValue];
				}
				$arrReturn[$data[$key4newKey]] = $value;
			}
		}

		return $arrReturn;
	}
}
