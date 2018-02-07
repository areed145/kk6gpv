<?php
error_reporting(0);

include('mysql_cred.php');

$api = $_GET["api"];

function getHtml($url)
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

    //You must send the currency cookie to the website for it to return the json you want to scrape
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Cookie: currencies_code=USD;',
    ));

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}

$html = getHtml("https://secure.conservation.ca.gov/WellSearch/Details?api=$api");

$connect = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseusername, $databasepassword);

$header = array();
preg_match_all("/<span id=\"wellAPI\">\s*(.*)\s*<\/span>/", $html, $apinum);
preg_match_all("/Lease<\/label> <br \/>\s*(.*)\s*<\/div>/", $html, $lease);
preg_match_all("/Well #<\/label> <br \/>\s*(.*)\s*<\/div>/", $html, $well);
preg_match_all("/County<\/label> <br \/>\s*(.*)<span>\s\[(.*)\]\s*<\/span>/", $html, $county);
preg_match_all("/District<\/label> <br \/>\s*(.*)\s*<\/div>/", $html, $district);
preg_match_all("/Operator<\/label> <br \/>\s*(.*)<span>\s\[(.*)\]\s*<\/span>/", $html, $operator);
preg_match_all("/Field<\/label> <br \/>\s*(.*)<span>\s\[(.*)\]\s*<\/span>/", $html, $field);
preg_match_all("/Area<\/label> <br \/>\s*(.*)<span>\s\[(.*)\]\s*<\/span>/", $html, $area);
preg_match_all("/Section<\/label>\s*<br \/>\s*(.*)\s*<\/div>/", $html, $section);
preg_match_all("/Township<\/label>\s*<br \/>\s*(.*)\s*<\/div>/", $html, $township);
preg_match_all("/Range<\/label>\s*<br \/>\s*(.*)\s*<\/div>/", $html, $rnge);
preg_match_all("/Base Meridian<\/label>\s*<br \/>\s*(.*)\s*<\/div>/", $html, $bm);
preg_match_all("/Well Status<\/label>\s*<br \/>\s*(.*)\s*<\/div>/", $html, $wellstatus);
preg_match_all("/Pool WellTypes<\/label>\s*<br \/>\s*(.*)\s*<\/div>\s*<\/div>/", $html, $pwt);
preg_match_all("/SPUD Date<\/label>\s*<br \/>\s*(.*)\s*<\/div>/", $html, $spuddate);
preg_match_all("/GIS Source<\/label> <br \/>\s*(.*)\s*<\/div>/", $html, $gissrc);
preg_match_all("/Datum<\/label> <br \/>\s*(.*)\s*<\/div>/", $html, $elev);
preg_match_all("/Latitude<\/label> <br \/>\s*(.*)\s*<\/div>/", $html, $latitude);
preg_match_all("/Longitude<\/label> <br \/>\s*(.*)\s*<\/div>/", $html, $longitude);

$header["apinum"] = $apinum[1][0];
$header["lease"] = $lease[1][0];
$header["well"] = $well[1][0];
$header["county"] = $county[1][0];
$header["countycode"] = $county[2][0];
$header["district"] = $district[1][0];
$header["operator"] = $operator[1][0];
$header["operatorcode"] = $operator[2][0];
$header["field"] = $field[1][0];
$header["fieldcode"] = $field[2][0];
$header["area"] = $area[1][0];
$header["areacode"] = $area[2][0];
$header["section"] = $section[1][0];
$header["township"] = $township[1][0];
$header["rnge"] = $rnge[1][0];
$header["bm"] = $bm[1][0];
$header["wellstatus"] = $wellstatus[1][0];
$header["gissrc"] = $gissrc[1][0];
$header["elev"] = $elev[1][0];
$header["latitude"] = $latitude[1][0];
$header["longitude"] = $longitude[1][0];

echo "<br>
	api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude
	<br>";
$query_h = "INSERT INTO $doggrtable_prodinj
    (api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude) 
    VALUES(:api, :lease, :well, :county, :district, :operator, :operatorcode, :field, :fieldcode, :area, :areacode, :section, :township, :rnge, :bm, :wellstatus, :gissrc, :elev, :latitude, :longitude);";
$statement_h = $connect->prepare($query_h);
if ($header[apinum] != '') {$apinum = $header["apinum"];} else {$apinum = 'null';}
if ($header[lease] != '') {$lease = $header["lease"];} else {$lease = 'null';}
if ($header[well] != '') {$well = $header["well"];} else {$well = 'null';}
if ($header[county] != '') {$county = $header["county"];} else {$county = 'null';}
if ($header[countycode] != '') {$countycode = $header["countycode"];} else {$countycode = 'null';}
if ($header[district] != '') {$district = $header["district"];} else {$district = -99;}
if ($header[operator] != '') {$operator = $header["operator"];} else {$operator = 'null';}
if ($header[operatorcode] != '') {$operatorcode = $header["operatorcode"];} else {$operatorcode = 'null';}
if ($header[field] != '') {$field = $header["field"];} else {$field = 'null';}
if ($header[fieldcode] != '') {$fieldcode = $header["fieldcode"];} else {$fieldcode = 'null';}
if ($header[area] != '') {$area = $header["area"];} else {$area = 'null';}
if ($header[areacode] != '') {$areacode = $header["areacode"];} else {$areacode = 'null';}
if ($header[section] != '') {$section = $header["section"];} else {$section = 'null';}
if ($header[township] != '') {$township = $header["township"];} else {$township = 'null';}
if ($header[rnge] != '') {$rnge = $header["rnge"];} else {$rnge = 'null';}
if ($header[bm] != '') {$bm = $header["bm"];} else {$bm = 'null';}
if ($header[wellstatus] != '') {$wellstatus = $header["wellstatus"];} else {$wellstatus = 'null';}
if ($header[gissrc] != '') {$gissrc = $header["gissrc"];} else {$gissrc = 'null';}
if ($header[elev] != '') {$elev = $header["elev"];} else {$elev = -99;}
if ($header[latitude] != '') {$latitude = $header["latitude"];} else {$latitude = -99;}
if ($header[longitude] != '') {$longitude = $header["longitude"];} else {$longitude = -99;}
$statement_h->execute(
    array(
        ':api' => $api,
        ':lease' => $lease,
        ':well' => $well,
        ':county' => $county,
        ':district' => $district,
        ':operator' => $operator,
        ':operatorcode' => $operatorcode,
        ':field' => $field,
        ':fieldcode' => $fieldcode,
        ':area' => $area,
        ':areacode' => $areacode,
        ':section' => $section,
        ':township' => $township,
        ':rnge' => $rnge,
        ':bm' => $bm,
        ':wellstatus' => $wellstatus,
        ':gissrc' => $gissrc,
        ':elev' => $elev,
        ':latitude' => $latitude,
        ':longitude' => $longitude
    )
);
echo $api.",";
echo $lease.",";
echo $well.",";
echo $county.",";
echo $district.",";
echo $operator.",";
echo $operatorcode.",";
echo $field.",";
echo $fieldcode.",";
echo $area.",";
echo $areacode.",";
echo $section.",";
echo $township.",";
echo $rnge.",";
echo $bm.",";
echo $wellstatus.",";
echo $gissrc.",";
echo $elev.",";
echo $latitude.",";
echo $longitude;
echo "<br>";

echo "<br>
	api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude, date, oil, water, gas, daysprod, oilgrav, pcsg, ptbg, btu, method, waterdisp, pwtstatus_p, welltype_p, status_p, poolcode_p
	<br>";
$query_p = "INSERT INTO $doggrtable_prodinj
    (api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude, date, oil, water, gas, daysprod, oilgrav, pcsg, ptbg, btu, method, waterdisp, pwtstatus_p, welltype_p, status_p, poolcode_p) 
    VALUES(:api, :lease, :well, :county, :district, :operator, :operatorcode, :field, :fieldcode, :area, :areacode, :section, :township, :rnge, :bm, :wellstatus, :gissrc, :elev, :latitude, :longitude, :date, :oil, :water, :gas, :daysprod, :oilgrav, :pcsg, :ptbg, :btu, :method, :waterdisp, :pwtstatus_p, :welltype_p, :status_p, :poolcode_p);";
$statement_p = $connect->prepare($query_p);
preg_match_all("/{\"Production+(.*?)}/", $html, $prod);
foreach ($prod[0] as $p){
    $proda = json_decode($p, true);
    if ($proda[PWTStatus] != '') {
        preg_match("/\/Date\((.*)\)/", $proda[ProductionDate], $date);
        $datestr = substr($date[1],0, -3);
        $date = gmdate("Y-m-d", $datestr);
        if ($proda[OilProduced] != '') {$oil = $proda[OilProduced];} else {$oil = 0;}
        if ($proda[WaterProduced] != '') {$water = $proda[WaterProduced];} else {$water = 0;} 
        if ($proda[GasProduced] != '') {$gas = $proda[GasProduced];} else {$gas = 0;}
        if ($proda[NumberOfDaysProduced] != '') {$daysprod = $proda[NumberOfDaysProduced];} else {$daysprod = 0;}
        if ($proda[OilGravity] != '') {$oilgrav = $proda[OilGravity];} else {$oilgrav = -99;}
        if ($proda[CasingPressure] != '')  {$pcsg = $proda[CasingPressure];} else {$pcsg = -99;}
        if ($proda[TubingPressure] != '') {$ptbg = $proda[TubingPressure];} else {$ptbg = -99;} 
        if ($proda[BTU] != '') {$btu = $proda[BTU];} else {$btu = -99;}
        if ($proda[MethodOfOperation] != '') {$method = $proda[MethodOfOperation];} else {$method = 'null';}
        if ($proda[WaterDisposition] != '') {$waterdisp = $proda[WaterDisposition];} else {$waterdisp = 'null';}
        if ($proda[PWTStatus] != '') {$pwtstatus_p = $proda[PWTStatus];} else {$pwtstatus_p = 'null';}
        if ($proda[WellType] != '') {$welltype_p = $proda[WellType];} else {$welltype_p = 'null';}
        if ($proda[Status] != '') {$status_p = $proda[Status];} else {$status_p = 'null';}
        if ($proda[PoolCode] != '') {$poolcode_p = $proda[PoolCode];} else {$poolcode_p = 'null';}
        $statement_p->execute(
            array(
                ':api' => $api,
                ':lease' => $lease,
                ':well' => $well,
                ':county' => $county,
                ':district' => $district,
                ':operator' => $operator,
                ':operatorcode' => $operatorcode,
                ':field' => $field,
                ':fieldcode' => $fieldcode,
                ':area' => $area,
                ':areacode' => $areacode,
                ':section' => $section,
                ':township' => $township,
                ':rnge' => $rnge,
                ':bm' => $bm,
                ':wellstatus' => $wellstatus,
                ':gissrc' => $gissrc,
                ':elev' => $elev,
                ':latitude' => $latitude,
                ':longitude' => $longitude,
                ':date' => $date,
                ':oil' => $oil,
                ':water' => $water,
                ':gas' => $gas,
                ':daysprod' => $daysprod,
                ':oilgrav' => $oilgrav,
                ':pcsg' => $pcsg,
                ':ptbg' => $ptbg,
                ':btu' => $btu,
                ':method' => $method,
                ':waterdisp' => $waterdisp,
                ':pwtstatus_p' => $pwtstatus_p,
                ':welltype_p' => $welltype_p,
                ':status_p' => $status_p,
                ':poolcode_p' => $poolcode_p,
            )
        );
        // echo $api.",";
        // echo $lease.",";
        // echo $well.",";
        // echo $county.",";
        // echo $district.",";
        // echo $operator.",";
        // echo $operatorcode.",";
        // echo $field.",";
        // echo $fieldcode.",";
        // echo $area.",";
        // echo $areacode.",";
        // echo $section.",";
        // echo $township.",";
        // echo $rnge.",";
        // echo $bm.",";
        // echo $wellstatus.",";
        // echo $gissrc.",";
        // echo $elev.",";
        // echo $latitude.",";
        // echo $longitude.",";
        // echo $date.",";
        // echo $oil.",";
        // echo $water.",";
        // echo $gas.",";
        // echo $daysprod.",";
        // echo $oilgrav.",";
        // echo $pcsg.",";
        // echo $ptbg.",";
        // echo $btu.",";
        // echo $method.",";
        // echo $waterdisp.",";
        // echo $pwtstatus_p.",";
        // echo $welltype_p.",";
        // echo $status_p.",";
        // echo $poolcode_p;
        // echo "<br>";
    }
}

echo "<br>
	api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude, date, waterdisposal, waterflood, steamflood, cyclic, gasinj, airinj, lpginj, daysinj, pinjsurf, watsrc, watknd, pwtstatus_i, welltype_i, status_i, poolcode_i
	<br>";
$query_i = "INSERT INTO $doggrtable_prodinj 
    (api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude, date, waterdisposal, waterflood, steamflood, cyclic, gasinj, airinj, lpginj, daysinj, pinjsurf, watsrc, watknd, pwtstatus_i, welltype_i, status_i, poolcode_i) 
    VALUES(:api, :lease, :well, :county, :district, :operator, :operatorcode, :field, :fieldcode, :area, :areacode, :section, :township, :rnge, :bm, :wellstatus, :gissrc, :elev, :latitude, :longitude, :date, :waterdisposal, :waterflood, :steamflood, :cyclic, :gasinj, :airinj, :lpginj, :daysinj, :pinjsurf, :watsrc, :watknd, :pwtstatus_i, :welltype_i, :status_i, :poolcode_i) 
    ON DUPLICATE KEY UPDATE 
    waterdisposal = :waterdisposal, 
    waterflood = :waterflood, 
    steamflood = :steamflood, 
    cyclic = :cyclic, 
    gasinj = :gasinj, 
    airinj = :airinj, 
    lpginj = :lpginj, 
    daysinj = :daysinj, 
    pinjsurf = :pinjsurf, 
    watsrc = :watsrc, 
    watknd = :watknd, 
    pwtstatus_i = :pwtstatus_i, 
    welltype_i = :welltype_i, 
    status_i = :status_i, 
    poolcode_i = :poolcode_i;";
    
$statement_i = $connect->prepare($query_i);
preg_match_all("/{\"Injection+(.*?)}/", $html, $inj);
foreach ($inj[0] as $i){
    $inja = json_decode($i, true);
    if ($inja[PWTStatus] != '') {
        preg_match("/\/Date\((.*)\)/", $inja[InjectionDate], $date);
        $datestr = substr($date[1],0, -3);
        $date = gmdate("Y-m-d", $datestr);
        if ($inja[WellType] == 'WD') {$waterdisposal =  $inja[WaterOrSteamInjected];} else {$waterdisposal = 0;}
        if ($inja[WellType] == 'WF') {$waterflood =  $inja[WaterOrSteamInjected];} else {$waterflood = 0;}
        if ($inja[WellType] == 'WS') {$waterflood =  $inja[WaterOrSteamInjected];} else {$waterflood = 0;}
        if ($inja[WellType] == 'SF') {$steamflood =  $inja[WaterOrSteamInjected];} else {$steamflood = 0;}
        if ($inja[WellType] == 'SC') {$cyclic =  $inja[WaterOrSteamInjected];} else {$cyclic = 0;}
        if ($inja[WellType] == 'PM') {$gasinj =  $inja[GasOrAirInjected];} else {$gasinj = 0;}
        if ($inja[WellType] == 'GS') {$gasinj =  $inja[GasOrAirInjected];} else {$gasinj = 0;}
        if ($inja[WellType] == 'GD') {$gasinj =  $inja[GasOrAirInjected];} else {$gasinj = 0;}
        if ($inja[WellType] == 'GD') {$airinj =  $inja[GasOrAirInjected];} else {$airinj = 0;}
        if ($inja[WellType] == 'LG') {$lpginj =  $inja[WaterOrSteamInjected];} else {$lpginj = 0;}
        if ($inja[NumberOfDaysInjected] != '') {$daysinj = $inja[NumberOfDaysInjected];} else {$daysinj = 0;}
        if ($inja[SurfaceInjectionPressure] != '') {$pinjsurf = $inja[SurfaceInjectionPressure];} else {$pinjsurf = -99;}
        if ($inja[SourceOfWater] != '')  {$watsrc = $inja[SourceOfWater];} else {$watsrc = 'null';}
        if ($inja[KindOfWater] != '') {$watknd =  $inja[KindOfWater];} else {$watknd = 'null';}
        if ($inja[PWTStatus] != '') {$pwtstatus_i= $inja[PWTStatus];} else {$pwtstatus_i = 'null';}
        if ($inja[WellType] != '') {$welltype_i= $inja[WellType];} else {$welltype_i = 'null';}
        if ($inja[Status] != '') {$status_i = $inja[Status];} else {$status_i = 'null';}
        if ($inja[PoolCode] != '') {$poolcode_i = $inja[PoolCode];} else {$poolcode_i = 'null';}
        $statement_i->execute(
            array(
                ':api' => $api,
                ':lease' => $lease,
                ':well' => $well,
                ':county' => $county,
                ':district' => $district,
                ':operator' => $operator,
                ':operatorcode' => $operatorcode,
                ':field' => $field,
                ':fieldcode' => $fieldcode,
                ':area' => $area,
                ':areacode' => $areacode,
                ':section' => $section,
                ':township' => $township,
                ':rnge' => $rnge,
                ':bm' => $bm,
                ':wellstatus' => $wellstatus,
                ':gissrc' => $gissrc,
                ':elev' => $elev,
                ':latitude' => $latitude,
                ':longitude' => $longitude,
                ':date' => $date,
                ':waterdisposal' => $waterdisposal,
                ':waterflood' => $waterflood,
                ':steamflood' => $steamflood,
                ':cyclic' => $cyclic,
                ':gasinj' => $gasinj,
                ':airinj' => $airinj,
                ':lpginj' => $lpginj,
                ':daysinj' => $daysinj,
                ':pinjsurf' => $pinjsurf,
                ':watsrc' => $watsrc,
                ':watknd' => $watknd,
                ':pwtstatus_i' => $pwtstatus_i,
                ':welltype_i' => $welltype_i,
                ':status_i' => $status_i,
                ':poolcode_i' => $poolcode_i,
            )
        );
        // echo $api.",";
        // echo $lease.",";
        // echo $well.",";
        // echo $county.",";
        // echo $district.",";
        // echo $operator.",";
        // echo $operatorcode.",";
        // echo $field.",";
        // echo $fieldcode.",";
        // echo $area.",";
        // echo $areacode.",";
        // echo $section.",";
        // echo $township.",";
        // echo $rnge.",";
        // echo $bm.",";
        // echo $wellstatus.",";
        // echo $gissrc.",";
        // echo $elev.",";
        // echo $latitude.",";
        // echo $longitude.",";
        // echo $date.",";
        // echo $waterdisposal.",";
        // echo $waterflood.",";
        // echo $steamflood.",";
        // echo $cyclic.",";
        // echo $gasinj.",";
        // echo $airinj.",";
        // echo $lpginj.",";
        // echo $daysinj.",";
        // echo $pinjsurf.",";
        // echo $watsrc.",";
        // echo $watknd.",";
        // echo $pwtstatus_i.",";
        // echo $welltype_i.",";
        // echo $status_i.",";
        // echo $poolcode_i;
        // echo "<br>";
    }
}

//print '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
//print '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';

?>
