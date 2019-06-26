<?php

namespace Home\PearlsBundle\Resources\contao\Helper;

class GeoCoords
{

    /**
     * getGeoCoordsFromGoogleByAddress
     * get geo coordinates from OSM by an address
     * @param string address - 'street,zip,city'
     * @param string $countryCode - must be the ISO 3166-1alpha2 code
     * @return array - with 'lat' and 'lon' values
     */
    public static function getGeoCoordsByAddress($address, $countryCode = 'de') {
        if (!is_string($address)) return false;

        #-- base url for request
        $osmUrl = 'https://nominatim.openstreetmap.org/search.php';
        #-- set params
        $strGeoUrl = $osmUrl . '?q=' .str_replace(' ', '%20', $address) . '&countrycodes=' . $country .
            '&limit=1&format=json';

        #-- check if curl is enabled on server
        if (function_exists("curl_init")) {
            #-- init curl
            $curl = curl_init();
            if ($curl) {
                #-- set curl options
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $strGeoUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_REFERER => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache"
                    ),
                ));

                #-- get response from curl
                $response = curl_exec($curl);
                $err = curl_error($curl);
                #-- close curl connection
                curl_close($curl);
                #-- decode received json
                $json = json_decode($response, true);

                if ($json && is_array($json) && $json[0] && $json[0]['lat'] && $json[0]['lon']) {
                    #-- return latitude and longitude
                    return array(
                        'lat' => $json[0]['lat'],
                        'lon' => $json[0]['lon']
                    );
                }
            }
        }

        return false;
    }

    /**
     * autoCenterMap
     * return the center lat and lon and zoom level from all data coords to center an OSM map
     * @param array $data - coordinates from all data
     * @param array $myCoord [Null] - coordinates from own location
     * @param string $geocoords ['geocoords'] - the key string where the geocoordinates are stored in the $data-array
     * @return array with 'lat', 'lon' and 'zoom'
     */
    public static function autoCenterMap($data, $myCoord=NULL, $geocoordsName='geocoords') {
        $minLat = ($myCoord != NULL) ? floatval($myCoord['lat']) : 0;
        $maxLat = ($myCoord != NULL) ? floatval($myCoord['lat']) : 0;
        $minLng = ($myCoord != NULL) ? floatval($myCoord['lon']) : 0;
        $maxLng = ($myCoord != NULL) ? floatval($myCoord['lon']) : 0;
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
            "lon" => $centerLng,
            "zoom" => $zoom
        );
    }
}