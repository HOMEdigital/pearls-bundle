<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 26.09.2017
 * Time: 14:31
 */

namespace Home\PearlsBundle\Resources\contao\Helper;


class DataHelper
{
    /**
     * convert a database values like serialized data in array or file-uuid in file-object
     *
     * @param mixed $value - the original database value
     * @return array
     */
    public static function convertValue($value)
    {

        #-- check if $value is serialized. if so deserialize it
        $value = self::deserialize($value);

        #-- if $value is array unserialize the whole array data
        if (is_array($value)) {
            $value = self::unserializeArrayData($value);
        }

        #-- convert uuid in file object
        $value = self::_unUuidData($value);

        return $value;
    }

    /**
     * find out if $value is serialized or not. If, it will deserialize $value and return it. If not, it will return $value
     *
     * @param mixed $value
     * @return array
     */
    public static function deserialize($value)
    {
        return (self::isSerialized($value)) ? deserialize($value) : $value;
    }

    /**
     * check if parameter is serialized or not
     *
     * @param mixed $str
     * @return bool true | false
     */
    public static function isSerialized($str)
    {
        return ($str == serialize(false) || @unserialize($str) !== false);
    }

    /**
     * unserialize all values in the $_arrayData array.
     * needed for db results to unserialize all blob data
     *
     * @param array $data - data with serialized values like db results
     * @return array - with unserialized data
     */
    public static function unserializeArrayData($data)
    {
        $return = array();
        if (is_array($data) && !empty($data)) {
            foreach($data as $key=>$value) {
                if (is_array($value)) {
                    $return[$key] = self::unserializeArrayData($value);
                } else {
                    $return[$key] = deserialize($value);
                }
            }
        }
        return $return;
    }

    /**
     * convert uuid data in array (_getFileDataFromUuid) it also finds uuids in an array and convert them
     *
     * @param $data
     * @return array|string
     */
    protected static function _unUuidData($data)
    {
        if (is_array($data)) {
            $return = array();
            foreach($data as $key=>$value) {
                if (is_array($value)) {
                    $return[$key] = self::_unUuidData($value);
                } elseif (!is_object($value) && \Validator::isUuid($value)) {
                    $return[$key] = \StringUtil::binToUuid($value);
                } else {
                    $return[$key] = $value;
                }
            }
            return $return;
        } elseif (!is_object($value) && \Validator::isUuid($data)) {
            return \StringUtil::binToUuid($data);
        }

        return $data;
    }
}