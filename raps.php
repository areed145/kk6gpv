<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_soaringforecast -><?php include('includes/nav_aws.php');?>

<html>

<h4 align=center>Soaring Forecast - RAP Model</h4>

<table bgcolor="#F0FFFF">
<style>

/* Style the tab */
.tab21 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #f4416e;
}
.tab22 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #f45e41;
}
.tab23 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #f4af41;
}
.tab24 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #c7f441;
}
.tab25 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #41f4ee;
}
.tab26 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #3dd367;
}
.tab27 {
    overflow: hidden;
    border: 0px solid #000000;
    background-color: #4286f4;
}

/* Style the buttons inside the tab */
div[class^="tab"] button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    width: 5.26%;
}

/* Change background color of buttons on hover */
div[class^="tab"] button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab21 button.active {
    background-color: #960f31;
}
.tab22 button.active {
    background-color: #912611;
}
.tab23 button.active {
    background-color: #a86f15;
}
.tab24 button.active {
    background-color: #7da013;
}
.tab25 button.active {
    background-color: #13a39e;
}
.tab26 button.active {
    background-color: #169339;
}
.tab27 button.active {
    background-color: #1149a3;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 0px solid #ccc;
    border-top: none;
}
</style>
<tr><td>Temp</td>
<td>
<div class="tab21">
  <button class="tablinks2" onclick="open2(event, 't00')" id="defaultOpen2">00</button>
  <?php for ($x = 1; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo "<button class=\"tablinks2\" onclick=\"open2(event, 't$hr')\" id=\"defaultOpen2\">$hr</button>";
  }?>
</div>
</td>
</tr>
<tr><td>Dewpt</td>
<td>
<div class="tab22">
  <?php for ($x = 0; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo "<button class=\"tablinks2\" onclick=\"open2(event, 'd$hr')\" id=\"defaultOpen2\">$hr</button>";
  }?>
</div>
</td>
</tr>
<tr><td>Radar</td>
<td>
<div class="tab23">
  <?php for ($x = 0; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo "<button class=\"tablinks2\" onclick=\"open2(event, 'r$hr')\" id=\"defaultOpen2\">$hr</button>";
  }?>
</div>
</td>
</tr>
<tr><td>Precip</td>
<td>
<div class="tab24">
  <?php for ($x = 0; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo "<button class=\"tablinks2\" onclick=\"open2(event, 'p$hr')\" id=\"defaultOpen2\">$hr</button>";
  }?>
</div>
</td>
</tr>
<tr><td>CAPE / CIN</td>
<td>
<div class="tab25">
  <?php for ($x = 0; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo "<button class=\"tablinks2\" onclick=\"open2(event, 'c$hr')\" id=\"defaultOpen2\">$hr</button>";
  }?>
</div>
</td>
</tr>
<tr><td>MLSP / Winds</td>
<td>
<div class="tab26">
  <?php for ($x = 0; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo "<button class=\"tablinks2\" onclick=\"open2(event, 'm$hr')\" id=\"defaultOpen2\">$hr</button>";
  }?>
</div>
</td>
</tr>
<tr><td>Clouds</td>
<td>
<div class="tab27">
  <?php for ($x = 0; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo "<button class=\"tablinks2\" onclick=\"open2(event, 'l$hr')\" id=\"defaultOpen2\">$hr</button>";
  }?>
</div>
</td>
</tr>
</table>
<table bgcolor="#F0FFFF">
<tr>
<td>
<?php
for ($x = 0; $x <= 18; $x++) {
  $hr = sprintf("%02d",$x);
  echo '<div id="t'.$hr.'" class="tabcontent2">
    <h3></h3>
    <p align=center><img src="http://weather.rap.ucar.edu/model/ruc'.$hr.'hr_sfc_temp.gif" width="100%"><br></p>
  </div>

  <div id="d'.$hr.'" class="tabcontent2">
    <h3></h3>
    <p align=center><img src="http://weather.rap.ucar.edu/model/ruc'.$hr.'hr_sfc_dewp.gif" width="100%"><br></p>
  </div>

  <div id="r'.$hr.'" class="tabcontent2">
    <h3></h3>
    <p align=center><img src="http://weather.rap.ucar.edu/model/ruc'.$hr.'hr_sfc_refl.gif" width="100%"><br></p>
  </div>

  <div id="p'.$hr.'" class="tabcontent2">
    <h3></h3>
    <p align=center><img src="http://weather.rap.ucar.edu/model/ruc'.$hr.'hr_sfc_prcp.gif" width="100%"><br></p>
  </div>

  <div id="c'.$hr.'" class="tabcontent2">
    <h3></h3>
    <p align=center><img src="http://weather.rap.ucar.edu/model/ruc'.$hr.'hr_sfc_cape.gif" width="100%"><br></p>
  </div>

  <div id="m'.$hr.'" class="tabcontent2">
    <h3></h3>
    <p align=center><img src="http://weather.rap.ucar.edu/model/ruc'.$hr.'hr_sfc_wind.gif" width="100%"><br></p>
  </div>

  <div id="l'.$hr.'" class="tabcontent2">
    <h3></h3>
    <p align=center><img src="http://weather.rap.ucar.edu/model/ruc'.$hr.'hr_0_clouds.gif" width="100%"><br></p>
  </div>';
}?>

<script>
function open2(evt, Name) {
    var i, tabcontent2, tablinks2;
    tabcontent2 = document.getElementsByClassName("tabcontent2");
    for (i = 0; i < tabcontent2.length; i++) {
        tabcontent2[i].style.display = "none";
    }
    tablinks2 = document.getElementsByClassName("tablinks2");
    for (i = 0; i < tablinks2.length; i++) {
        tablinks2[i].className = tablinks2[i].className.replace(" active", "");
    }
    document.getElementById(Name).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen2").click();
</script>
        </td>
    </tr>
</table>
</html>

<!- footer -><?php include('includes/footer.php');?>
