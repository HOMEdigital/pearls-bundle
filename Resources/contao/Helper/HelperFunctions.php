<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 26.09.2017
 * Time: 14:31
 */

namespace Home\PearlsBundle\Resources\contao\Helper;


class HelperFunctions
{
    /**
     * recursively check if the array with keys exists in an array as parent-child elements
     * example:
     * keys = array('foo', 'bar', 'so') checks if $array['foo']['bar']['so'] exists
     * @param array $keys
     * @param array $array
     *
     * @return bool
     */
    public static function array_key_path_exist(array $keys, array $array)
    {
        $key = array_shift($keys);
        if (array_key_exists($key, $array)) {
            if (is_array($array[$key]) && $keys) {
                return self::array_key_path_exist($keys, $array[$key]);
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * adds "published = 1" to options array if BE_USER_LOGGED_IN
     *
     * @param $optionsArr
     * @param $table
     * @return array
     */
    public static function addPublishedToOptions($optionsArr, $table)
    {
        if(!BE_USER_LOGGED_IN){
            $optionsArr[] = $table . '.published = 1 ';
        }
        return $optionsArr;
    }

    /**
     * checks if $array is an Array an that the length of $array is greater then 0
     *
     * @param $array
     * @return bool
     */
    public static function checkArray($array)
    {
        return (is_array($array) && count($array) > 0);
    }
}