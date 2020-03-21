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