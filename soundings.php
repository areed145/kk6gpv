<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!– style –><?php include('includes/style.php');?>
<!– header –><?php include('includes/header.php');?>
<!- nav -><?php include('includes/nav.php');?>
<!- nav_soaringforecast -><?php include('includes/nav_aws.php');?>

<html>

<h4 align=center>Soaring Forecast - Soundings</h4>

<table bgcolor="#F0FFFF">
<tr><td>
  <p align=center><img src="content/imap_skewt.png" width=500 border=1></p>
</td></tr>
    <tr>
        <td>
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

/* Style the buttons inside the tab */
.tab21 button {
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
.tab22 button {
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
.tab23 button {
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
.tab24 button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    width: 14.28%;
}
.tab25 button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    width: 14.28%;
}

/* Change background color of buttons on hover */
.tab21 button:hover {
    background-color: #ddd;
}
.tab22 button:hover {
    background-color: #ddd;
}
.tab23 button:hover {
    background-color: #ddd;
}
.tab24 button:hover {
    background-color: #ddd;
}
.tab25 button:hover {
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

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 0px solid #ccc;
    border-top: none;
}
</style>

<div class="tab21">
  <button class="tablinks2" onclick="open2(event, 'oak')" id="defaultOpen2">OAK</button>
  <button class="tablinks2" onclick="open2(event, 'rev')">REV</button>
  <button class="tablinks2" onclick="open2(event, 'lkn')">LKN</button>
  <button class="tablinks2" onclick="open2(event, 'slc')">SLC</button>
  <button class="tablinks2" onclick="open2(event, 'gjt')">GJT</button>
  <button class="tablinks2" onclick="open2(event, 'dnr')">DNR</button>
</div>
<div class="tab22">
  <button class="tablinks2" onclick="open2(event, 'vbg')">VBG</button>
  <button class="tablinks2" onclick="open2(event, 'edw')">EDW</button>
  <button class="tablinks2" onclick="open2(event, 'dra')">DRA</button>
  <button class="tablinks2" onclick="open2(event, 'fgz')">FGZ</button>
  <button class="tablinks2" onclick="open2(event, 'abq')">ABQ</button>
  <button class="tablinks2" onclick="open2(event, 'ama')">AMA</button>
</div>
<div class="tab23">
  <button class="tablinks2" onclick="open2(event, 'nkx')">NKX</button>
  <button class="tablinks2" onclick="open2(event, 'tus')">TUS</button>
  <button class="tablinks2" onclick="open2(event, 'epz')">EPZ</button>
  <button class="tablinks2" onclick="open2(event, 'maf')">MAF</button>
  <button class="tablinks2" onclick="open2(event, 'slidemt')">Slide Mt</button>
</div>
<div class="tab24">
  <button class="tablinks2" onclick="open2(event, '925r')">925mb</button>
  <button class="tablinks2" onclick="open2(event, '850r')">850mb</button>
  <button class="tablinks2" onclick="open2(event, '700r')">700mb</button>
  <button class="tablinks2" onclick="open2(event, '500r')">500mb</button>
  <button class="tablinks2" onclick="open2(event, '300r')">300mb</button>
  <button class="tablinks2" onclick="open2(event, '250r')">250mb</button>
  <button class="tablinks2" onclick="open2(event, '200r')">200mb</button>
</div>
<div class="tab25">
  <button class="tablinks2" onclick="open2(event, '925c')">925mb</button>
  <button class="tablinks2" onclick="open2(event, '850c')">850mb</button>
  <button class="tablinks2" onclick="open2(event, '700c')">700mb</button>
  <button class="tablinks2" onclick="open2(event, '500c')">500mb</button>
  <button class="tablinks2" onclick="open2(event, '300c')">300mb</button>
  <button class="tablinks2" onclick="open2(event, '250c')">250mb</button>
  <button class="tablinks2" onclick="open2(event, '200c')">200mb</button>
</div>
</td>
</tr>
</table>
<table>
  <tr>
    <td>
<div id="rev" class="tabcontent2">
  <h3>KREV</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/rev.gif" width="100%" ></p>
</div>

<div id="oak" class="tabcontent2">
  <h3>KOAK</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/oak.gif" width="100%"></p>
</div>

<div id="edw" class="tabcontent2">
  <h3>KEDW</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/edw.gif" width="100%"></p>
</div>

<div id="vbg" class="tabcontent2">
  <h3>KVBG</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/vbg.gif" width="100%"></p>
</div>

<div id="nkx" class="tabcontent2">
  <h3>KNKX</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/nkx.gif" width="100%"></p>
</div>

<div id="dra" class="tabcontent2">
  <h3>NDRA</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/dra.gif" width="100%"></p>
</div>

<div id="abq" class="tabcontent2">
  <h3>KABQ</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/abq.gif" width="100%"></p>
</div>

<div id="lkn" class="tabcontent2">
  <h3>KLKN</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/lkn.gif" width="100%"></p>
</div>

<div id="slc" class="tabcontent2">
  <h3>KSLC</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/slc.gif" width="100%"></p>
</div>

<div id="gjt" class="tabcontent2">
  <h3>KGJT</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/gjt.gif" width="100%"></p>
</div>

<div id="dnr" class="tabcontent2">
  <h3>KDNR</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/dnr.gif" width="100%"></p>
</div>

<div id="fgz" class="tabcontent2">
  <h3>KFGZ</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/fgz.gif" width="100%"></p>
</div>

<div id="ama" class="tabcontent2">
  <h3>KAMA</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/ama.gif" width="100%"></p>
</div>

<div id="tus" class="tabcontent2">
  <h3>KTUS</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/twc.gif" width="100%"></p>
</div>

<div id="epz" class="tabcontent2">
  <h3>KEPZ</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/epz.gif" width="100%"></p>
</div>

<div id="maf" class="tabcontent2">
  <h3>KMAF</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/maf.gif" width="100%"></p>
</div>

<div id="925r" class="tabcontent2">
  <h3>925mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaRAOB_925.gif" width="100%"></p>
</div>

<div id="850r" class="tabcontent2">
  <h3>850mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaRAOB_850.gif" width="100%"></p>
</div>

<div id="700r" class="tabcontent2">
  <h3>700mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaRAOB_700.gif" width="100%"></p>
</div>

<div id="500r" class="tabcontent2">
  <h3>500mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaRAOB_500.gif" width="100%"></p>
</div>

<div id="300r" class="tabcontent2">
  <h3>300mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaRAOB_300.gif" width="100%"></p>
</div>

<div id="250r" class="tabcontent2">
  <h3>250mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaRAOB_250.gif" width="100%"></p>
</div>

<div id="200r" class="tabcontent2">
  <h3>200mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaRAOB_200.gif" width="100%"></p>
</div>

<div id="925c" class="tabcontent2">
  <h3>925mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaCNTR_925.gif" width="100%"></p>
</div>

<div id="850c" class="tabcontent2">
  <h3>850mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaCNTR_850.gif" width="100%"></p>
</div>

<div id="700c" class="tabcontent2">
  <h3>700mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaCNTR_700.gif" width="100%"></p>
</div>

<div id="500c" class="tabcontent2">
  <h3>500mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaCNTR_500.gif" width="100%"></p>
</div>

<div id="300c" class="tabcontent2">
  <h3>300mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaCNTR_300.gif" width="100%"></p>
</div>

<div id="250c" class="tabcontent2">
  <h3>250mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaCNTR_250.gif" width="100%"></p>
</div>

<div id="200c" class="tabcontent2">
  <h3>200mb</h3>
  <p align=center><img src="http://weather.rap.ucar.edu/upper/upaCNTR_200.gif" width="100%"></p>
</div>

<div id="slidemt" class="tabcontent2">
  <h3>Slide Mountain</h3>
  <p align=center><img src="http://www.wrh.noaa.gov/images/rev/remote/slideT.png" width="100%"></p>
  <p align=center><img src="http://www.wrh.noaa.gov/images/rev/remote/slideW.png" width="100%"></p>
</div>

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
