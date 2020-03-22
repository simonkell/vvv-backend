<?php
function calc_distance($coord1, $coord2){
    $r = 6371e3;
    $lat1 = deg2rad($coord1[0]);
    $lat2 = deg2rad($coord2[0]);
    $dLat = deg2rad($coord2[0] - $coord1[0]);
    $dLong = deg2rad($coord2[1] - $coord1[1]);
    
    $a = pow(sin($dLat/2), 2) + cos($lat1) * cos($lat2) * pow(sin($dLong/2), 2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $r * $c;
}

//0 => latitude, 1 => longitude
$leipzig = array(51.3406321, 12.3747329);
$essen = array(51.4582235, 7.0158171);
//echo calc_distance($leipzig, $essen)." Meter";

//SELECT v.user_id, v.radius, g.ORT_NAME, g.ORT_LAT, g.ORT_LON FROM volunteer_profile AS v INNER JOIN geodata AS g ON v.PLZ = g.POSTLEITZAHL WHERE users.id=;
return $query->whereRaw("
ST_Distance_Sphere(
point(ORT_LAN, ORT_LAT),
point(?, ?)
) * .000621371192 < ?
", [
$lon,
$lat,
$radius
]);
/*
ST_Distance_Sphere:


DELIMITER $$

DROP FUNCTION IF EXISTS `ST_Distance_Sphere`$$

CREATE FUNCTION `ST_Distance_Sphere` (point1 POINT, point2 POINT)

RETURNS FLOAT
no sql deterministic
BEGIN
declare R INTEGER DEFAULT 6371000;
declare `φ1` float;
declare `φ2` float;
declare `Δφ` float;
declare `Δλ` float;
declare a float;
declare c float;
set `φ1` = radians(y(point1));
set `φ2` = radians(y(point2));
set `Δφ` = radians(y(point2) - y(point1));
set `Δλ` = radians(x(point2) - x(point1));

set a = sin(`Δφ` / 2) * sin(`Δφ` / 2) + cos(`φ1`) * cos(`φ2`) * sin(`Δλ` / 2) * sin(`Δλ` / 2);
set c = 2 * atan2(sqrt(a), sqrt(1-a));

return R * c;
END$$

DELIMITER ;
*/

//6371e3* 2 * atan2(sqrt(pow(sin($dLat/2), 2) + cos($lat1) * cos($lat2) * pow(sin($dLong/2), 2)), sqrt(1-pow(sin($dLat/2), 2) + cos($lat1) * cos($lat2) * pow(sin($dLong/2), 2)));