<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_soaringforecast -><?php include('includes/nav_aws.php');?>

<html>

<h4 align=center>Soaring Forecast - BLIP Maps</h4>

<table bgcolor="#F0FFFF">
    <tr>
        <td>
<style>

/* Style the tab */
.tab11 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #e8915f;
}
.tab12 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #5ecce8;
}
.tab13 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #5ee8cc;
}
.tab14 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #cf94e0;
}

/* Style the buttons inside the tab */
.tab11 button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    width: 16.666%;
}
.tab12 button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    width: 20%;
}
.tab13 button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    width: 33.333%;
}
.tab14 button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    width: 20%;
}

/* Change background color of buttons on hover */
.tab11 button:hover {
    background-color: #ddd;
}
.tab12 button:hover {
    background-color: #ddd;
}
.tab13 button:hover {
    background-color: #ddd;
}
.tab14 button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab11 button.active {
    background-color: #d66626;
}
.tab12 button.active {
    background-color: #26a8c9;
}
.tab13 button.active {
    background-color: #16bc9b;
}
.tab14 button.active {
    background-color: #a737c6;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 0px solid #ccc;
    border-top: none;
}
</style>

<div class="tab11">
  <button class="tablinks1" onclick="open1(event, 'tuvbs')" id="defaultOpen1">Thermal Updraft &amp B/S</button>
  <button class="tablinks1" onclick="open1(event, 'tuv')">Thermal Updraft Velocity</button>
  <button class="tablinks1" onclick="open1(event, 'bs')">B/S<br />Ratio</button>
  <button class="tablinks1" onclick="open1(event, 'blh')">Boundary Layer Height</button>
  <button class="tablinks1" onclick="open1(event, 'hcrith')">Hcrit<br />Height</button>
  <button class="tablinks1" onclick="open1(event, 'thv')">Thermal Height Variability</button>
</div>
<div class="tab12">
  <button class="tablinks1" onclick="open1(event, 'blwsd')">Boundary Layer Wind Speed/Dir</button>
  <button class="tablinks1" onclick="open1(event, 'blws')">Boundary Layer Windspeed</button>
  <button class="tablinks1" onclick="open1(event, 'blwd')">Boundary Layer Wind Direction</button>
  <button class="tablinks1" onclick="open1(event, 'blwsh')">Boundary Layer Wind Shear</button>
  <button class="tablinks1" onclick="open1(event, 'blmot')">Boundary Layer Motion</button>
</div>
<div class="tab13">
  <button class="tablinks1" onclick="open1(event, 'cumpotcb')">Cumulus Potential / Cloudbase</button>
  <button class="tablinks1" onclick="open1(event, 'cumpot')">Cumulus<br />Potential</button>
  <button class="tablinks1" onclick="open1(event, 'cumcb')">Cumulus<br />Cloudbase</button>
  <button class="tablinks1" onclick="open1(event, 'ovpotcb')">Overcast Potential / Cloudbase</button>
  <button class="tablinks1" onclick="open1(event, 'ovpot')">Overcast<br />Potential</button>
  <button class="tablinks1" onclick="open1(event, 'ovcb')">Overcast<br />Cloudbase</button>
  <button class="tablinks1" onclick="open1(event, 'relhum')">Boundary Layer Relative Humidity</button>
  <button class="tablinks1" onclick="open1(event, 'cape')">CAPE</button>
  <button class="tablinks1" onclick="open1(event, 'dsurf')">Surface<br />Dewpoint</button>
</div>
<div class="tab14">
  <button class="tablinks1" onclick="open1(event, 'bld')">Boundary Layer Depth</button>
  <button class="tablinks1" onclick="open1(event, 'hsurf')">Surface<br />Heating</button>
  <button class="tablinks1" onclick="open1(event, 'tsurf')">Surface<br />Temp</button>
  <button class="tablinks1" onclick="open1(event, 'topoact')">Topo<br />Actual</button>
  <button class="tablinks1" onclick="open1(event, 'topomod')">Topo<br />Model</button>
</div>
</td>
</tr>
</table>
<table>
  <tr>
    <td>
<div id="tuvbs" class="tabcontent1">
  <h3>Thermal Updraft Velocity and Buoyancy/Shear Ratio</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.wfpm_woustar.21z.PNG" width="100%"></p>
    B/S Ratio stippling (dense=0-4 sparse=4-7) overlays Thermal Updraft Velocity contours to indicate where strong thermals can be broken by vertical wind shear.  See "Thermal Updraft Velocity" and "Buoyancy/Shear Ratio" parameter descriptions below for more information.
</div>

<div id="tuv" class="tabcontent1">
  <h3>Thermal Updraft Velocity (W*)</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.wfpm.21z.PNG" width="100%"></p>
  Average dry thermal updraft strength near mid-BL height.  Subtract glider descent rate to get average vario reading for cloudless thermals.  Thermal strengths will be stronger if convective clouds are present.  W* depends upon both the BL depth and the surface heating.
</div>

<div id="bs" class="tabcontent1">
  <h3>Buoyancy/Shear Ratio (B/S)</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.woustar.21z.PNG" width="100%"></p>
  Dry thermals may be broken up by vertical wind shear (i.e. wind changing with height) and unworkable if B/S ratio is 5 or less.  If convective clouds are present, the actual B/S ratio will be larger than calculated here.  [This parameter is truncated at 20 for plotting.]
</div>

<div id="blh" class="tabcontent1">
  <h3>Height of Boundary Layer Top (TI=0 height)</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.hft.21z.PNG" width="100%"></p>
  Height of the average dry thermal tops, or Thermal Index TI=0 height.  Over flat terrain maximum thermalling heights will be lower due to the glider descent rate and other factors.  However, thermal tops will be higher over small-scale topography not resolved by the model and some pilots have reported that in elevated terrain the heights they can reach over local terrain features correspond better with the TI=0 height than with Hcrit.  In the presence of clouds the thermal top will increase, but the maximum thermalling height will then be limited by the cloud base (see the "Cloud prediction parameters" section below).  [This parameter is truncated at 22,000 for plotting.]
</div>

<div id="hcrith" class="tabcontent1">
  <h3>Hcrit Height</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.hwcritft.21z.PNG" width="100%"></p>
  This parameter estimates the height at which the average dry updraft strength drops below 225 fpm and over flat terrain is expected to give better quantitative numbers for the maximum cloudless thermalling height than is the traditional TI=0 height given above, although the qualitative patterns should be similar for both parameters.  (Note: the present assumptions tend to underpredict the max. thermalling height.) In the presence of clouds the maximum thermalling height may instead be limited by the cloud base (see the "Cloud prediction parameters" section below).  [This parameter is truncated at 22,000 for plotting.]
</div>

<div id="thv" class="tabcontent1">
  <h3>Thermal Height Variability</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.htift.21z.PNG" width="100%"></p>
  This parameter estimates the variability (uncertainty) of the BL top (TI=0) height prediction which can result from meteorological variations.  Larger values indicate greater variability and thus better thermalling over local "hot spots" or small-scale topography not resolved by the model.  But larger values also indicate greater sensitivity to error in the predicted surface temperature, so actual conditions have a greater likelihood of differing from those predicted.
</div>

<div id="blwsd" class="tabcontent1">
  <h3>Wind Speed and Direction in the Boundary Layer</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.blwindkt_blwinddeg.21z.PNG" width="100%"></p>
  BL Wind Direction streamlines overlay BL Wind Speed contours,  See "Wind Speed in the Boundary Layer" and "Wind Direction in the Boundary Layer" parameter descriptions below for more information.
</div>

<div id="blws" class="tabcontent1">
  <h3>Wind Speed in the Boundary Layer</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.blwindkt.21z.PNG" width="100%"></p>
  The speed of the vector-averaged wind in the BL.  This prediction can be misleading if there is a large change in wind direction through the BL (for a complex wind profile, any single number is not an adequate descriptor!).
</div>

<div id="blwd" class="tabcontent1">
  <h3>Wind Direction in the Boundary Layer</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.blwinddeg.21z.PNG" width="100%"></p>
  The direction of the vector-averaged wind in the BL.  This prediction can be misleading if there is a large change in wind direction through the BL (for a complex wind profile, any single number is not an adequate descriptor!).  Note that there will be a abrupt artificial gradient at the "cross-over" between 0 and 360 degrees.
</div>

<div id="blwsh" class="tabcontent1">
  <h3>Wind Shear in the Boundary Layer</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.blwindshearkt.21z.PNG" width="100%"></p>
  The magnitude of the vector wind difference between the top and bottom of the BL.  Note that this represents vertical wind shear and does not indicate "shear lines" (which are horizontal changes of wind speed/direction).
</div>

<div id="blmot" class="tabcontent1">
  <h3>BL Max Up/Down Motion (BL Convergence)/h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.wblmaxkt.21z.PNG" width="100%"></p>
  Maximum grid-area-averaged extensive upward or downward motion within the BL as created by horizontal wind convergence.  Positive convergence is associated with local small-scale convergence lines (often called "shear lines" by pilots, meaning horizontal changes of wind speed/direction) - however, the actual size of such features is much smaller than can be resolved by the model so only stronger ones will be forecast and their predictions are subject to much error.  If CAPE is also large, thunderstorms can be triggered.  Negative convergence (divergence) produces subsiding vertical motion, creating low-level inversions which limit thermalling heights.  This parameter can be noisy, so users should be wary.
</div>

<div id="cumpotcb" class="tabcontent1">
  <h3>Cumulus Cloudbase for Cu Potential > 0</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.zsfclclft_zsfclcldifft.21z.PNG" width="100%"></p>
  Cu Cloudbase Cloudbase contours are plotted only where that cloudbase is theoretically expected.  See "Cumulus Potential" and "Cumulus Cloudbase" parameter descriptions below for more information.  This composite is useful only for locations where the actual potential threshold for cumulus cloud production agrees with the theoretically-predicted value of zero.
</div>

<div id="cumpot" class="tabcontent1">
  <h3>Cumulus Potential</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.zsfclcldifft.21z.PNG" width="100%"></p>
  This evaluates the potential for small, non-extensive "puffy cloud" formation in the BL, being the height difference between the surface-based LCL (see below) and the BL top.  Small cumulus clouds are (simply) predicted when the parameter positive, but it is quite possible that the threshold value is actually greater than zero for your location so empirical evaluation is advised.  I would be interested in receiving end-of-season reports on what threshold value worked for your site.  Clouds can also occur with negative values if the air is lifted up the indicated vertical distance by flow up a small-scale ridge not resolved by the model's smoothed topography.  [This parameter is truncated at -10,000 for plotting.]
</div>

<div id="cumcb" class="tabcontent1">
  <h3>Cumulus Cloudbase (Sfc. LCL)</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.zsfclclft.21z.PNG" width="100%"></p>
  This height estimates the cloudbase for small, non-extensive "puffy" clouds in the BL, if such exist i.e. if the Cumulus Potential parameter (above) is positive or greater than the threshold Cumulus Potential empirically determined for your site.  The surface LCL (Lifting Condensation Level) is the level to which humid air must ascend before it cools enough to reach a dew point temperature based on the surface mixing ratio and is therefore relevant only to small clouds - unlike the below BL-based CL which uses a BL-averaged humidity.  However, this parameter has a theoretical difficulty (see "MoreInfo" link below) and quite possibly that the actual cloudbase will be higher than given here - so perhaps this should be considered a minimum possible cloudbase.  I would be interested in receiving end-of-season reports on how well this parameter worked for your site.  [This parameter is truncated at 22,000 for plotting.]
</div>

<div id="ovpotcb" class="tabcontent1">
  <h3>OvercastDevelopment Cloudbase for OD Potential > 0</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.zblclft_zblcldifft.21z.PNG" width="100%"></p>
  OvercastDevelopment Cloudbase Cloudbase contours are plotted only where that cloudbase is theoretically expected.  See "OvercastDevelopment Potential" and "OvercastDevelopment Cloudbase" parameter descriptions below for more information.  This composite is useful only for locations where the actual potential threshold for OD cloud production agrees with the theoretically-predicted value of zero. 
</div>

<div id="ovpot" class="tabcontent1">
  <h3>OvercastDevelopment Potential</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.zblcldifft.21z.PNG" width="100%"></p>
  This evaluates the potential for extensive cloud formation (OvercastDevelopment) at the BL top, being the height difference between the BL CL (see below) and the BL top.  Extensive clouds and likely OvercastDevelopment are predicted when the parameter is positive, with OvercastDevelopment being increasingly more likely with higher positive values.  OvercastDevelopment can also occur with negative values if the air is lifted up the indicated vertical distance by flow up a small-scale ridge not resolved by the model's smoothed topography.  [This parameter is truncated at -10,000 for plotting.]   MoreInfo 
</div>

<div id="ovcb" class="tabcontent1">
  <h3>OvercastDevelopment Cloudbase (BL CL)</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.zblclft.21z.PNG" width="100%"></p>
  This height estimates the cloudbase for extensive BL clouds (OvercastDevelopment), if such exist, i.e. if the OvercastDevelopment Potential parameter (above) is positive.  The BL CL (Condensation Level) is based upon the humidity averaged through the BL and is therefore relevant only to extensive clouds (OvercastDevelopment) - unlike the above surface-based LCL which uses a surface humidity.  [This parameter is truncated at 22,000 for plotting.]
</div>

<div id="relhum" class="tabcontent1">
  <h3>BL Max. Relative Humidity</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.maxblrh.21z.PNG" width="100%"></p>
  This parameter provides an additional means of evaluating the formation of clouds within the BL and might be used either in conjunction with or instead of the other cloud prediction parameters.  Larger values indicate greater cloud probability, but use of this parameter must be empirical since no theoretical guidance is available - for example, pilots must determine by actual experience the percentage that correlates with formation of clouds above local mountains.  The cloud base height is not predicted, but is expected to be below the TI=0 height.
</div>

<div id="cape" class="tabcontent1">
  <h3>CAPE</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RUC/CANV/FCST/previous.cape.21z.PNG" width="100%"></p>
  Convective Available Potential Energy indicates the atmospheric stability affecting deep convective cloud formation above the BL.  A higher value indicates greater potential instability, larger updraft velocities within deep convective clouds, and greater potential for thunderstorm development (since a trigger is needed to release that potential).  Note that thunderstorms may develop in regions of high CAPE and then get transported downwind to regions of lower CAPE.  Also, locations where both convergence and CAPE values are high can be subject to explosive thunderstorm development.
</div>

<div id="dsurf" class="tabcontent1">
  <h3>Surface Dew Point Temperature</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.sfcdewptf.21z.PNG" width="100%"></p>
  This model-predicted surface dew point temperature can be compared to the actual dew point temperature at 2m during the day to evaluate the accuracy of model moisture predictions.
</div>

<div id="bld" class="tabcontent1">
  <h3>Boundary Layer Depth</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.dft.21z.PNG" width="100%"></p>
  Depth of the layer mixed by thermals.  This parameter can be useful in determining which flight direction allows better thermalling conditions when average surface elevations vary greatly in differing directions.
</div>

<div id="hsurf" class="tabcontent1">
  <h3>Surface Heating</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RAP/CANV/FCST/previous.qswm2.21z.PNG" width="100%"></p>
  Heat transferred into the atmosphere due to solar heating of the ground, i.e. the heating that creates thermals.   [This parameter is truncated at -100 and +1000 for plotting.]
</div>

<div id="tsurf" class="tabcontent1">
  <h3>Surface Temp</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RUC/CANV/FCST/previous.sfctempf.21z.PNG" width="100%"></p>
  This model-predicted surface temperature can be compared to the actual temperature at 2m during the day to evaluate the accuracy of model heating predictions.
</div>

<div id="topoact" class="tabcontent1">
  <h3>Actual Topographic Height</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RUC/CANV/actualtopo.png" width="100%"></p>
</div>

<div id="topomod" class="tabcontent1">
  <h3>Model Topographic Height</h3>
  <p align=center><img src="http://www.drjack.info/BLIP/RUC/CANV/modeltopo.png" width="100%"></p>
</div>

<script>
function open1(evt, Name) {
    var i, tabcontent1, tablinks1;
    tabcontent1 = document.getElementsByClassName("tabcontent1");
    for (i = 0; i < tabcontent1.length; i++) {
        tabcontent1[i].style.display = "none";
    }
    tablinks1 = document.getElementsByClassName("tablinks1");
    for (i = 0; i < tablinks1.length; i++) {
        tablinks1[i].className = tablinks1[i].className.replace(" active", "");
    }
    document.getElementById(Name).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen1").click();
</script>
        </td>
    </tr>
</table>
</html>

<!- footer -><?php include('includes/footer.php');?>
