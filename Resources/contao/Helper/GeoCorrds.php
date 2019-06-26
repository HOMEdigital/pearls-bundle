<?php

namespace Home\PearlsBundle\Resources\contao\Helper;

class GeoCorrds
{

    /**
     * getGeoCoordsFromGoogleByAddress
     * get geo coordinates from goolge by an address
     * @param string address - 'street zip city'
     * @param string country - the country like 'de'
     * @return array with 'lat' and 'lng' values
     */
    public static function getGeoCoordsFromGoogleByAddress($address, $country = 'de') {
        if (!is_string($address)) return false;

        $googleUrl = 'https://maps.google.com/maps/api/geocode/xml';
        $strGeoUrl = $googleUrl . '?address=' .str_replace(' ', '+', $address) . '&region=' . $country . '&sensor=false';

        // get geo coordinates
        if (function_exists("curl_init")) {
            $curl = curl_init();
            if ($curl) {
                if (curl_setopt($curl, CURLOPT_URL, $strGeoUrl) && curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1) && curl_setopt($curl, CURLOPT_HEADER, 0)) {
                    $curlVal = curl_exec($curl);
                    curl_close($curl);

                    $xml = new \SimpleXMLElement($curlVal);
                    if($xml) {
                        return array(
                            'lat'=>$xml->result->geometry->location->lat,
                            'lng'=>$xml->result->geometry->location->lng);
                    }
                }
            }
        }

        return false;
    }

    /**
     * autoCenterMap
     * return the center lat and lng and zoom level from all data coords to center an google map
     * @param array $data - coordinates from all data
     * @param array $myCoord [Null] - coordinates from own location
     * @param string $geocoords ['geocoords'] - the key string where the geocoordinates are stored in the $data-array
     * @return array with 'lat', 'lng' and 'zoom'
     */
    public static function autoCenterMap($data, $myCoord=NULL, $geocoordsName='geocoords') {
        $minLat = ($myCoord != NULL) ? floatval($myCoord['lat']) : 0;
        $maxLat = ($myCoord != NULL) ? floatval($myCoord['lat']) : 0;
        $minLng = ($myCoord != NULL) ? floatval($myCoord['lng']) : 0;
        $maxLng = ($myCoord != NULL) ? floatval($myCoord['lng']) : 0;
        $centerLat = 0;
        $centerLng = 0;
        $zoom = 0;

        #-- find out the min/max latitude and longitude for the markers
        if(is_array($data) && count($data) > 0) {
            foreach ($data as $key=>$value){
                if ( $value[$geocoordsName] != "" AND $value[$geocoordsName] != ",") {
                    $coords = explode(",", $value[$geocoordsName]);
                    if ( $minLng == 0  && $mingLat == 0) {
                        $minLat = floatval($coords[0]);
                        $maxLat = floatval($coords[0]);
                        $minLng = floatval($coords[1]);
                        $maxLng = floatval($coords[1]);
                    } else {
                        if ($coords[0] < $minLat ) {$minLat = floatval($coords[0]);}
                        if ($coords[0] > $maxLat ) {$maxLat = floatval($coords[0]);}
                        if ($coords[1] < $minLng ) {$minLng = floatval($coords[1]);}
                        if ($coords[1] > $maxLng ) {$maxLng = floatval($coords[1]);}
                    }
                }
            }
        }

        #-- calculate the center point of the resulting area
        $centerLat = $minLat + ($maxLat - $minLat) / 2 ;
        $centerLng = $minLng + ($maxLng - $minLng) / 2 ;

        #-- calculating the distance in miles between two coordinates
        $miles = (3958.75 * acos(sin($minLat / 57.2958) * sin($maxLat / 57.2958) + cos($minLat / 57.2958) * cos($maxLat / 57.2958) * cos($maxLng / 57.2958 - $minLng / 57.2958)));

        #-- find the right zoom level
        if     ($miles < 0.2) : $zoom = 16;
        elseif ($miles < 0.5) : $zoom = 15;
        elseif ($miles < 1)   : $zoom = 14;
        elseif ($miles < 2)   : $zoom = 13;
        elseif ($miles < 3)   : $zoom = 12;
        elseif ($miles < 7)   : $zoom = 11;
        elseif ($miles < 15)  : $zoom = 10;
        elseif ($miles < 60)  : $zoom = 9;
        elseif ($miles < 100)  : $zoom = 8;
        elseif ($miles < 180)  : $zoom = 7;
        elseif ($miles < 300)  : $zoom = 6;
        else  : $zoom = 5;
        endif;

        return array(
            "lat" => $centerLat,
            "lng" => $centerLng,
            "zoom" => $zoom
        );
    }
}