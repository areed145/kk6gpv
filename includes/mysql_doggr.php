<?php
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
$header["pwt"] = $pwt[1][0];
$header["spuddate"] = $spuddate[1][0];
$header["gissrc"] = $gissrc[1][0];
$header["elev"] = $elev[1][0];
$header["latitude"] = $latitude[1][0];
$header["longitude"] = $longitude[1][0];

if(empty($header[apinum])){$header["apinum"] = 'null';}
if(empty($header[lease])){$header["lease"] = 'null';}
if(empty($header[well])){$header["well"] = 'null';}
if(empty($header[county])){$header["county"] = 'null';}
if(empty($header[countycode])){$header["countycode"] = 'null';}
if(empty($header[district])){$header["district"] = -9;}
if(empty($header[operator])){$header["operator"] = 'null';}
if(empty($header[operatorcode])){$header["operatorcode"] = 'null';}
if(empty($header[field])){$header["field"] = 'null';}
if(empty($header[fieldcode])){$header["fieldcode"] = 'null';}
if(empty($header[area])){$header["area"] = 'null';}
if(empty($header[areacode])){$header["areacode"] = 'null';}
if(empty($header[section])){$header["section"] = -9;}
if(empty($header[township])){$header["township"] = 'null';}
if(empty($header[rnge])){$header["rnge"] = 'null';}
if(empty($header[bm])){$header["bm"] = 'null';}
if(empty($header[wellstatus])){$header["wellstatus"] = 'null';}
if(empty($header[pwt])){$header["pwt"] = 'null';}
if(empty($header[spuddate])){$header["supddate"] = 'null';}
if(empty($header[gissrc])){$header["gissrc"] = 'null';}
if(empty($header[elev])){$header["elev"] = -999;}
if(empty($header[latitude])){$header["latitude"] = 0;}
if(empty($header[longitude])){$header["longitude"] = 0;}

echo "api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude, date, oil, water, gas, daysprod, oilgrav, pcsg, ptbg, btu, method, waterdisp, pwt_status_p, welltype_p, status_p, poolcode_p<br>";

$query_p = "INSERT INTO $doggrtable_prodinj
    (api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude, date, oil, water, gas, daysprod, oilgrav, pcsg, ptbg, btu, method, waterdisp, pwtstatus_p, welltype_p, status_p, poolcode_p) 
    VALUES(:api, :lease, :well, :county, :district, :operator, :operatorcode, :field, :fieldcode, :area, :areacode, :section, :township, :rnge, :bm, :wellstatus, :gissrc, :elev, :latitude, :longitude, :date, :oil, :water, :gas, :daysprod, :oilgrav, :pcsg, :ptbg, :btu, :method, :waterdisp, :pwtstatus_p, :welltype_p, :status_p, :poolcode_p);";
$statement_p = $connect->prepare($query_p);
preg_match_all("/{\"Production+(.*?)}/", $html, $prod);
foreach ($prod[0] as $p){
    $proda = json_decode($p, true);
    preg_match("/\/Date\((.*)\)/", $proda[ProductionDate], $date);
    $datestr = substr($date[1],0, -3);
    $date = gmdate("Y-m-d", $datestr);
    $statement_p->execute(
        array(
            ':api' => $api,
            ':lease' => $header[lease],
            ':well' => $header[well],
            ':county' => $header[county],
            ':district' => $header[district],
            ':operator' => $header[operator],
            ':operatorcode' => $header[operatorcode],
            ':field' => $header[field],
            ':fieldcode' => $header[fieldcode],
            ':area' => $header[area],
            ':areacode' => $header[areacode],
            ':section' => $header[section],
            ':township' => $header[township],
            ':rnge' => $header[rnge],
            ':bm' => $header[bm],
            ':wellstatus' => $header[wellstatus],
            ':gissrc' => $header[gissrc],
            ':elev' => $header[elev],
            ':latitude' => $header[latitude],
            ':longitude' => $header[longitude],
            ':date' => $date,
            ':oil' => $proda[OilProduced],
            ':water' => $proda[WaterProduced],
            ':gas' => $proda[GasProduced],
            ':daysprod' => $proda[NumberOfDaysProduced],
            ':oilgrav' => $proda[OilGravity],
            ':pcsg' => $proda[CasingPressure],
            ':ptbg' => $proda[TubingPressure],
            ':btu' => $proda[BTU],
            ':method' => $proda[MethodOfOperation],
            ':waterdisp' => $proda[WaterDisposition],
            ':pwtstatus_p' => $proda[PWTStatus],
            ':welltype_p' => $proda[WellType],
            ':status_p' => $proda[Status],
            ':poolcode_p' => $proda[PoolCode],
        )
    );
    echo $api.",";
    echo $header[lease].",";
    echo $header[well].",";
    echo $header[county].",";
    echo $header[district].",";
    echo $header[operator].",";
    echo $header[operatorcode].",";
    echo $header[field].",";
    echo $header[fieldcode].",";
    echo $header[area].",";
    echo $header[areacode].",";
    echo $header[section].",";
    echo $header[township].",";
    echo $header[rnge].",";
    echo $header[bm].",";
    echo $header[wellstatus].",";
    echo $header[gissrc].",";
    echo $header[elev].",";
    echo $header[latitude].",";
    echo $header[longitude].",";
    echo $date.",";
    echo $proda[OilProduced].",";
    echo $proda[WaterProduced].",";
    echo $proda[GasProduced].",";
    echo $proda[NumberOfDaysProduced].",";
    echo $proda[OilGravity].",";
    echo $proda[CasingPressure].",";
    echo $proda[TubingPressure].",";
    echo $proda[BTU].",";
    echo $proda[MethodOfOperation].",";
    echo $proda[WaterDisposition].",";
    echo $proda[PWTStatus].",";
    echo $proda[WellType].",";
    echo $proda[Status].",";
    echo $proda[PoolCode].",";
    echo "<br>";
}

echo "api, lease, well, county, district, operator, operatorcode, field, fieldcode, area, areacode, section, township, rnge, bm, wellstatus, gissrc, elev, latitude, longitude, date, waterdisposal, waterflood, steamflood, cyclic, gasinj, airinj, lpginj, daysinj, pinjsurf, watsrc, watknd, pwt_status_i, welltype_i, status_i, poolcode_i<br>";

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
    $statement_i->execute(
        array(
            ':api' => $api,
            ':lease' => $header[lease],
            ':well' => $header[well],
            ':county' => $header[county],
            ':district' => $header[district],
            ':operator' => $header[operator],
            ':operatorcode' => $header[operatorcode],
            ':field' => $header[field],
            ':fieldcode' => $header[fieldcode],
            ':area' => $header[area],
            ':areacode' => $header[areacode],
            ':section' => $header[section],
            ':township' => $header[township],
            ':rnge' => $header[rnge],
            ':bm' => $header[bm],
            ':wellstatus' => $header[wellstatus],
            ':gissrc' => $header[gissrc],
            ':elev' => $header[elev],
            ':latitude' => $header[latitude],
            ':longitude' => $header[longitude],
            ':date' => $date,
            ':waterdisposal' => $waterdisposal,
            ':waterflood' => $waterflood,
            ':steamflood' => $steamflood,
            ':cyclic' => $cyclic,
            ':gasinj' => $gasinj,
            ':airinj' => $airinj,
            ':lpginj' => $lpginj,
            ':daysinj' => $inja[NumberOfDaysInjected],
            ':pinjsurf' => $inja[SurfaceInjectionPressure],
            ':watsrc' => $inja[SourceOfWater],
            ':watknd' => $inja[KindOfWater],
            ':pwtstatus_i' => $inja[PWTStatus],
            ':welltype_i' => $inja[WellType],
            ':status_i' => $inja[Status],
            ':poolcode_i' => $inja[PoolCode],
        )
    );
    echo $api.",";
    echo $header[lease].",";
    echo $header[well].",";
    echo $header[county].",";
    echo $header[district].",";
    echo $header[operator].",";
    echo $header[operatorcode].",";
    echo $header[field].",";
    echo $header[fieldcode].",";
    echo $header[area].",";
    echo $header[areacode].",";
    echo $header[section].",";
    echo $header[township].",";
    echo $header[rnge].",";
    echo $header[bm].",";
    echo $header[wellstatus].",";
    echo $header[gissrc].",";
    echo $header[elev].",";
    echo $header[latitude].",";
    echo $header[longitude].",";
    echo $date.",";
    echo $waterdisposal.",";
    echo $waterflood.",";
    echo $steamflood.",";
    echo $cyclic.",";
    echo $gasinj.",";
    echo $airinj.",";
    echo $lpginj.",";
    echo $proda[NumberOfDaysInjected].",";
    echo $proda[SurfaceInectionPressure].",";
    echo $proda[SourceOfWater].",";
    echo $proda[KindOfWater].",";
    echo $proda[PWTStatus].",";
    echo $proda[WellType].",";
    echo $proda[Status].",";
    echo $proda[PoolCode].",";
    echo "<br>";
}

//print '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
//print '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre>';

?>
