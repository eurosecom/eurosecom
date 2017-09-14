<?PHP
$dajmenu=1*$dajmenu;
session_start();
$h5rtgh5 = include("odpad2010/h5rtgh5.php");

$alert=0;
if( $dajmenu != 1 ) { $alert=0; }
if( $alert == 1 )
 {
?>
<script type="text/javascript">
alert ("POZOR ! Dnes v štvrtok 2.6.2016 od 20.00 hod. do piatka 3.6.2016 20.00 hod. bude na Vašej doméne prebiehať údržba a aplikácia nebude funkčná. \r Ospravedlňujeme sa za krátkodobú prekážku v práci.");
</script>
<?php
 }


$prehliadac=$_SERVER['HTTP_USER_AGENT'];
$chrome=0;
$msie=0;
$android=0;

$pos = strpos($prehliadac, "MSIE");
// Všimněte si použití ===. Obyčejné == by nefungovalo podle předpokladu,
// protože 'a' je na nultém (prvním) místě.
if ($pos === false) {
    $msie=0;
} else {
    $msie=1;
}

$pos = strpos($prehliadac, "MSIE 10.0");
if ($pos === false) {
    $msie10=0;
} else {
    $msie10=1;
}
$pos = strpos($prehliadac, "rv:11.0");
if ($pos === false) {
    $msie11=0;
} else {
    $msie11=1;
}

if( $msie11 == 1 ) { $msie10=1; }
$_SESSION['ie10']=$msie10;

//Safari
$pos = strpos($prehliadac, "Safari");
if ($pos === false) {
    $safari=0;
} else {
    $safari=1;
}

//Chrome
$pos = strpos($prehliadac, "Chrome");
if ($pos === false) {
    $chrome=0;
} else {
    $chrome=1; $safari=0;
}

$pos = strpos($prehliadac, "Edge");
if ($pos === false) {
    $edge=0;
} else {
    $edge=1; $msie=0; $msie10=0; $msie11=0; $chrome=0; $safari=0;
}

$_SESSION['chrome']=$chrome;

//Android
$pos = strpos($prehliadac, "Android");
if ($pos === false) {
    $android=0;
} else {
    $android=1; $safari=0;
}

$_SESSION['android']=$android;

//iPad
$pos = strpos($prehliadac, "iPad");
if ($pos === false) {
    $ipad=0;
} else {
    $ipad=1; $safari=0;
}

$_SESSION['ipad']=$ipad;

//iPhone
$pos = strpos($prehliadac, "iPhone");
if ($pos === false) {
    $iphone=0;
} else {
    $iphone=1;
    $ipad=1; $safari=0;
}

$_SESSION['iphone']=$iphone;

$_SESSION['safari']=$safari;

$_SESSION['nieie']=0;
if( $android == 1 OR $chrome == 1 OR $safari == 1 OR $ipad == 1 OR $iphone == 1 OR $msie10 == 1 ) { $_SESSION['nieie']=1; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php

if( $dajmenu == 0 ) { $hs = 1*$_REQUEST['hs']; }

if( $dajmenu == 1 ) { 
$sys = 'ALL';
$urov = 10;
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

  $kli_uzid = $_SESSION['kli_uzid'];
  $kli_uzmeno = $_SESSION['kli_uzmeno'];
  $kli_uzprie = $_SESSION['kli_uzprie'];
  $verzia = $_SESSION['verzia'];


$sql = "SELECT m062018 FROM $mysqldb2017.kalendar";
$vysledok = mysql_query($sql);
if (!$vysledok):
$kalend = include("cis/kalendar.php");
endif;

$nerob=1;
if( $nerob == 0 )
    {
if(isset($mysqldb2010))
{
$sql = "SELECT m062016 FROM $mysqldb2010.kalendar";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sqlfir = "DROP TABLE $mysqldb2010.kalendar";
$fir_vysledok = mysql_query($sqlfir);

$sqlfir = "CREATE TABLE $mysqldb2010.kalendar SELECT * FROM kalendar";
$fir_vysledok = mysql_query($sqlfir);
               }
}

if(isset($mysqldb2011))
{
$sql = "SELECT m062016 FROM $mysqldb2011.kalendar";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sqlfir = "DROP TABLE $mysqldb2011.kalendar";
$fir_vysledok = mysql_query($sqlfir);

$sqlfir = "CREATE TABLE $mysqldb2011.kalendar SELECT * FROM kalendar";
$fir_vysledok = mysql_query($sqlfir);
               }
}

if(isset($mysqldb2012))
{
$sql = "SELECT m062016 FROM $mysqldb2012.kalendar";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sqlfir = "DROP TABLE $mysqldb2012.kalendar";
$fir_vysledok = mysql_query($sqlfir);

$sqlfir = "CREATE TABLE $mysqldb2012.kalendar SELECT * FROM kalendar";
$fir_vysledok = mysql_query($sqlfir);
               }
}

if(isset($mysqldb2013))
{
$sql = "SELECT m062016 FROM $mysqldb2013.kalendar";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sqlfir = "DROP TABLE $mysqldb2013.kalendar";
$fir_vysledok = mysql_query($sqlfir);

$sqlfir = "CREATE TABLE $mysqldb2013.kalendar SELECT * FROM kalendar";
$fir_vysledok = mysql_query($sqlfir);
               }
}

if(isset($mysqldb2014))
{
$sql = "SELECT m062016 FROM $mysqldb2014.kalendar";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sqlfir = "DROP TABLE $mysqldb2014.kalendar";
$fir_vysledok = mysql_query($sqlfir);

$sqlfir = "CREATE TABLE $mysqldb2014.kalendar SELECT * FROM kalendar";
$fir_vysledok = mysql_query($sqlfir);
               }
}

if(isset($mysqldb2015))
{
$sql = "SELECT m062016 FROM $mysqldb2015.kalendar";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sqlfir = "DROP TABLE $mysqldb2015.kalendar";
$fir_vysledok = mysql_query($sqlfir);

$sqlfir = "CREATE TABLE $mysqldb2015.kalendar SELECT * FROM kalendar";
$fir_vysledok = mysql_query($sqlfir);
               }
}
    }
//ak nerob==0

//echo $mysqldb;

//ak je lenan
$lenan=0;
$sqlfir = "SELECT * FROM druzis WHERE uzid=$kli_uzid";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) {
$cpol = mysql_num_rows($fir_vysledok);
if( $cpol == 1 )
     {
$fir_riadok=mysql_fetch_object($fir_vysledok);

$lenan = $fir_riadok->lenan;
     }
                   }
//koniec ak je lenan

if( $lenan == 1 )
{
?>
<script type="text/javascript">
    window.open('analyzy.php?copern=1', '_self' );
</script>
<?php
}

                    } 
//koniec ak dajmenu=1
?>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EuroSecom - internetový,webový ekonomický IS - účtovníctvo, mzdy, sklad, doprava, faktúry, kniha jázd, kuchyňa, normovanie stravy</title>
<meta name="keywords" content="EuroSecom - internetový,webový ekonomický IS - účtovníctvo, mzdy, sklad, doprava, faktúry, kniha jázd, kuchyňa, normovanie stravy" />
<meta name="description" content="EuroSecom - internetový,webový ekonomický IS - účtovníctvo, mzdy, sklad, doprava, faktúry, kniha jázd, kuchyňa, normovanie stravy" />
<meta name="author" content="EDcom s.r.o. Senica">
<link href="css/templatemo_style1.css" rel="stylesheet" type="text/css" />
<style>
div.overlay {
  z-index: 1;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #000;
  opacity: 0.7;
  filter: alpha(opacity = 70);
}
div.modal {
  z-index: 2;
  position: fixed;
  top: 50%;
  left: 50%;
  width: 400px;
  height: 250px;
  margin: -125px 0 0 -200px;
  border: 2px solid #39f;
  border-radius: 5px;
  text-align: center;
  background-color: lightblue;
  font-family: arial, sans-serif;
}
div.modal h2 {
  background-color: yellow;
  height: 46px;
  line-height: 46px;
  color: black;
  font-size: 20px;
  font-weight: bold;
  margin: 0;
  padding: 0;
  letter-spacing: 1px;
}
div.modal div {
  height: 100px;
  font-size: 16px;
  line-height: 22px;
  margin-top: 15px;
}

a.go-btn {
  display: block;
  width: 150px;
  height: 30px;
  line-height: 30px;
  background-color: white;
  text-decoration: none;
  font-size: 14px;
  font-weight: bold;
  margin: 0 auto;
  color: #39f;
  border: 2px solid #39f;
  border-radius: 5px;
}
</style>


  <script type="text/javascript">
    function Nad(Obj,Text)
    {
      Obj.className='Amenu';
      Info.innerHTML=Text;
    }
    function Mimo(Obj)
    {
      Obj.className='menu'
      Info.innerHTML='&nbsp;'
    }
  </script>
  <script type="text/javascript">
<!--
function select (row){
row.style.background = '#d9d9ff';
}
function deselect (row){
row.style.background = '#f0f8ff';
}
// -->
  </script>

  <script type="text/javascript">

    function ciovergrid ()
    {
        if(document.forms.formg.rtxgr.value != '' ){ overgrid(); }
    }

  </script>

<script type="text/javascript" src="../ajax/spr_grid_xml.js"></script>

<script type="text/javascript" src="../ajax/ovr_grid_xml.js"></script>

<script type="text/javascript" src="../js/webtoolkit.md5.js"></script>

</head>
<body <?php if( $dajmenu != 1 ) { ?>onload="dajgrid();"<?php } ?> >

    <noscript>
      Váš prehliadač nepodporuje Javascript , volajte servis
    </noscript>

<script>
<!--

<?php if ( $msie == 0 AND $chrome == 0 AND $safari == 0 AND $android == 0 AND $ipad == 0 AND $iphone == 0 AND $msie10 == 0 )
{ ?>
alert ("POZOR ! Pre spravnu funkciu programu musite pouzit \r prehliadac Microsoft Internet Explorer, Chrome, Safari, iPad, iPhone alebo Android ! \r <?php echo $prehliadac; ?>");
window.close();
<?php  
}
?>

// -->
</script>

<?php if ( $dajmenu != 1 AND $_SERVER['SERVER_NAME'] == "www.xxxeducto.sk" ) { ?>

<div id="overalert" class="overlay"></div>
<div id="modalalert" class="modal">
 <h2>Info</h2>
 <div>Z dôvodu technickej údržby,<br> v dňoch <strong>27.11. od 20.00 hod. až do 28.11. do 20.00 hod.</strong>,<br>bude doména www.educto.sk<br> <strong>mimo prevádzky</strong>.<br>
      Ďakujeme za porozumenie.<br><br>
  <a href="#" onclick="modalalert.style.display='none'; overalert.style.display='none';" title="Pokračovať na prihlásenie" class="go-btn">Pokračovať</a>
 </div>
</div>

<?php                      } ?>

<div id="templatemo_wrapper_outer">
<div id="templatemo_wrapper_inner">

    <div id="templatemo_menu">
	    <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
           
            <li></li>
            
        </ul>
    
    
       
    </div> <!-- end of menu -->
    
    <div id="templatemo_content_wrapper">
    
    	<div class="templatemo_side_bar margin_right_10" >
        	
                <ul>
                
                    <li><A Href="#" onClick="window.open('http://www.edcom.sk/ram1/novinkyweb.php', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );">Novinky, tipy, triky </A></li>
                    <li><A Href="http://www.edcom.sk/web/eurosecom.html" >Užívateľský manuál </A></li>
                    <li><A Href="http://www.edcom.sk/web/video.html" >Video manuál </A></li>
                    <li><A Href="http://www.edcom.sk/web/cennik.php" >Cenník software </A></li> 
                    <li><A Href="http://www.edcom.sk/web/eurosecom.html" >Kontakty </A></li>
                    <li><A Href="http://www.facebook.com/eurosecom" title="Nájdete nás aj na Facebook-u" >
<img src="../obr/facebook.jpg" width="20" height="20" title="Nájdete nás aj na Facebook-u" /> Facebook </A></li>
                    <li><A Href="https://plus.google.com/u/0/103698066631874918134" title="Pripojte sa k nám na Google+" >
<img src="../obr/googleplus.jpg" width="20" height="20" title="Pripojte sa k nám na Google+" /> Google+ </A></li>

<?php if( $_SERVER['SERVER_NAME'] == "xxwww.eurosecom.sk" OR $_SERVER['SERVER_NAME'] == "xxlocalhost" ) { ?>
                    <li><A Href="secom/index.php" >Upgrade programov Secom </A></li> 
<?php                                                                                                   } ?>                    

                </ul>
            <div class="margin_bottom_20 horizontal_divider"></div> 
			      
            <div class="margin_bottom_20"></div>

                
            
            <div class="image_wrapper_01"><a href="../obr/reklama/reklama.jpg"><img src="../obr/reklama/reklama.jpg" width="170" height="150" title="IS EuroSecom" /></a></div>
            
            <div class="margin_bottom_20"></div>
            
        </div> <!-- end of left side bar -->
        
        <div class="templatemo_content margin_right_10">
        
        	<div class="content_section">
           	  
<?php if( $hs != 1 ) { ?>
              <div class="header_02">EuroSecom - internetový ekonomický InfoSystém</div>
<?php                } ?>
<?php if( $hs == 1 ) { ?>
              <div class="header_02">EuroSecom - internetový hotelový InfoSystém</div>
<?php                } ?>
              <!-- obsah zaciatok --> 

<?php 
$menuadr="menu";
$sirkavyskajpg="";

if (File_Exists ('tmp/menu2.on') AND File_Exists ('obr/menu2/ucto.jpg') ) { $menuadr="menu2"; $sirkavyskajpg=" width=120 height=90 "; }
if (File_Exists ('tmp/menu3.on') AND File_Exists ('obr/menu3/ucto.jpg') ) { $menuadr="menu3"; }

//echo $menuadr;
?>

              
<?php if( $dajmenu != 1 ) { ?>

              <FORM name="form1" method="post" action="hsoverenie.php?hs=<?php echo $hs; ?>" > 
               <B>Meno:</B><INPUT type="text" name="rtxmn" id="rtxmn" class="a" size="20" maxlength="10" onclick="ciovergrid();"><br /> 
               <B>Heslo:</B><INPUT type="password" name="rtxhs" id="rtxhs" class="a" size="20" maxlength="10" ><br /> 
               <INPUT type="submit" id="inputb" value="Prihlásiť" class="b" > 
              </FORM> 
 
              <FORM name="formg" method="post" action="" > 
                <table width="100%" > 
                  <tr> 
                    <td width="98%" align="right" style=" background-color:#ffff90; color:black; font-weight:bold; height:12px; font-size:16px; " > 
                    <span id="grid" > </span></td> 
 
                    <td width="2%" align="right" style=" background-color:#ffff90; color:black; font-weight:bold; height:12px; font-size:16px; " > 
                    <span id="grid" > </span><INPUT type="password" name="rtxgr" id="rtxgr" class="a" size="6" maxlength="6"> 
                    <input class="hvstup" type="hidden" name="rtxhsh" id="rtxhsh" value="<?php echo $_SESSION['gridhash'];?>" /> 
                    </td> 
                  </tr> 
                </table> 
              </FORM> 
 
              <br />


<?php if( $dajmenu != 1 AND $hs == 0 ) { ?>

              <table align="center" width="620px" height="330px" border="1" cellspacing="2" cellpadding="2">
                <tr bgcolor='#f0f8ff'>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/pucto.php"><img src="obr/<?php echo $menuadr; ?>/ucto.jpg"  title="Finančné účtovníctvo" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/pucto.php"><br />Finančné účtovníctvo</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/mzdy.php"><img src="obr/<?php echo $menuadr; ?>/mzdy.jpg"  title="Mzdy a personalistika" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/mzdy.php"><br />Mzdy a personalistika</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/faktury.php?copern=1"><img src="obr/<?php echo $menuadr; ?>/faktury.jpg"  title="Odbyt, faktúry" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/faktury.php?copern=1"><br />Odbyt, faktúry</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/sklad.php?copern=1"><img src="obr/<?php echo $menuadr; ?>/sklady.jpg"  title="Sklad, zásoby" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/sklad.php?copern=1">Sklad, zásoby</a></td>
                </tr>
                <tr bgcolor='#f0f8ff'>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/majetok.php"><img src="obr/<?php echo $menuadr; ?>/majetok.jpg"  title="Dlhodobý majetok" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/majetok.php"><br />Dlhodobý majetok</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/doprava.php"><img src="obr/<?php echo $menuadr; ?>/doprava.jpg"  title="Dopravné služby" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/doprava.php"><br />Dopravné služby</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/manual.php?copern=1"><img src="obr/<?php echo $menuadr; ?>/vyroba.jpg"  title="Riadenie výroby" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/manual.php?copern=1"><br />Riadenie výroby</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/manual.php?copern=1"><img src="obr/<?php echo $menuadr; ?>/analyzy.jpg"  title="Finančné analýzy" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/manual.php?copern=1"><br />Finančné analýzy</a></td>
                </tr>
                
              </table>

<?php                                  } ?>


<?php if( $dajmenu != 1 AND $hs == 1 ) { ?>

              <table align="center" width="620px" height="330px" border="1" cellspacing="2" cellpadding="2">
                <tr bgcolor='#f0f8ff'>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/rest.php"><img src="obr/<?php echo $menuadr; ?>/restauracia.jpg"  title="Reštaurácia, Jedáleň" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/rest.php">Reštaurácia</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/kuch.php"><img src="obr/<?php echo $menuadr; ?>/kuchyna.jpg"  title="Kuchyňa" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/kuch.php"><br />Kuchyňa</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/sklad.php?copern=1"><img src="obr/<?php echo $menuadr; ?>/sklady.jpg"  title="Sklad, zásoby" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/sklad.php?copern=1">Sklad, zásoby</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/ubyt.php?copern=1"><img src="obr/<?php echo $menuadr; ?>/ubytovanie.jpg"  title="Ubytovanie" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/ubyt.php?copern=1">Ubytovanie</a></td>
                </tr>
                <tr bgcolor='#f0f8ff'>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/faktury.php?copern=1"><img src="obr/<?php echo $menuadr; ?>/faktury.jpg"  title="Odbyt, faktúry" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/faktury.php?copern=1">Odbyt, faktúry</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="http://www.eurosecom.sk/ram1/doprava.php"><img src="obr/<?php echo $menuadr; ?>/doprava.jpg"  title="Dopravné služby" <?php echo $sirkavyskajpg; ?> /></a> <a href="http://www.eurosecom.sk/ram1/doprava.php">Dopravné služby</a></td>
                </tr>
                
              </table>

<?php                                  } ?>

              
<?php                       } ?> 

              
<?php if( $dajmenu == 1 ) { ?>

<?php

$webnaz=$_SERVER['SERVER_NAME'];
$akehttp="http:";

if (File_Exists ('pswd/https_all.on'))
{
$akehttp="https:";
}
?>

<?php if( $dajmenu == 1 AND $hs == 0 ) { ?>

              <table align="center" width="620px" height="330px" border="1" cellspacing="2" cellpadding="2">
                <tr bgcolor='#f0f8ff'>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/podvojneu.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/ucto.jpg"  title="Finančné účtovníctvo" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/podvojneu.php?copern=1&newmenu=1" target='_blank'><br />Finančné účtovníctvo</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/mzdy.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/mzdy.jpg"  title="Mzdy a personalistika" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/mzdy.php?copern=1&newmenu=1" target='_blank'><br />Mzdy a personalistika</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/fakt.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/faktury.jpg"  title="Odbyt, faktúry" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/fakt.php?copern=1&newmenu=1" target='_blank'><br />Odbyt, faktúry</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/sklad.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/sklady.jpg"  title="Sklad, zásoby" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/sklad.php?copern=1&newmenu=1" target='_blank'><br />Sklad, zásoby</a></td>
                </tr>
                <tr bgcolor='#f0f8ff'>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/majetok.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/majetok.jpg"  title="Dlhodobý majetok" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/majetok.php?copern=1&newmenu=1" target='_blank'><br />Dlhodobý majetok</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/dopr.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/doprava.jpg"  title="Dopravné služby" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/dopr.php?copern=1&newmenu=1" target='_blank'><br />Dopravné služby</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/vyroba.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/vyroba.jpg"  title="Riadenie výroby" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/vyroba.php?copern=1&newmenu=1" target='_blank'><br />Riadenie výroby</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/analyzy.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/analyzy.jpg"  title="Finančné analýzy" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/analyzy.php?copern=1&newmenu=1" target='_blank'><br />Finančné analýzy</a></td>
                </tr>
              </table>
<?php                                  } ?>

<?php if( $dajmenu == 1 AND $hs == 1 ) { ?>

              <table align="center" width="620px" height="330px" border="1" cellspacing="2" cellpadding="2">
                <tr bgcolor='#f0f8ff'>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/restauracia/rest.php?copern=1&newmenu=1&hotel=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/restauracia.jpg"  title="Reštaurácia, Jedáleň" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/restauracia/rest.php?copern=1&newmenu=1&hotel=1" target='_blank'>Reštaurácia</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/kuchyna/kuch.php?copern=1&newmenu=1&hotel=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/kuchyna.jpg"  title="Kuchyňa" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/kuchyna/kuch.php?copern=1&newmenu=1&hotel=1" target='_blank'><br />Kuchyňa</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/sklad.php?copern=1&newmenu=1&hotel=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/sklady.jpg"  title="Sklad, zásoby" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/sklad.php?copern=1&newmenu=1&hotel=1" target='_blank'>Sklad, zásoby</a></td>
                 <td width="25%" onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/ubyt/ubyt.php?copern=1&newmenu=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/ubytovanie.jpg"  title="Ubytovanie" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/ubyt/ubyt.php?copern=1&newmenu=1&hotel=1" target='_blank'>Ubytovanie</a></td>
                </tr>
                <tr bgcolor='#f0f8ff'>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/fakt.php?copern=1&newmenu=1&hotel=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/faktury.jpg"  title="Odbyt, faktúry" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/fakt.php?copern=1&newmenu=1&hotel=1" target='_blank'>Odbyt, faktúry</a></td>
                 <td onmouseover='select(this);' onmouseout='deselect(this);'><a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/dopr.php?copern=1&newmenu=1&hotel=1" target='_blank'><img src="obr/<?php echo $menuadr; ?>/doprava.jpg"  title="Dopravné služby" <?php echo $sirkavyskajpg; ?> /></a> <a href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/dopr.php?copern=1&newmenu=1&hotel=1" target='_blank'>Dopravné služby</a></td>
                </tr>
              </table>
<?php                                  } ?>

              <br />

              <table align="center" width="620px" height="40px" border="1" cellspacing="2" cellpadding="2">
                <tr bgcolor='lightblue'>
                 <td align="left" colspan="2">           
<A Href="ckli.php?copern=1&page=1" target='_blank'>
<img border=2 src="obr/ikony/uziv.jpg" width=30 height=30 border=1 title="Číselník užívateľov"/></A>
<A Href="cfir.php?copern=1&page=1" target='_blank'>
<img border=2 src="obr/ikony/firmy.jpg" width=30 height=30 border=1 title="Číselník účtovných jednotiek"/></A>
<A Href="../cis/certifikat.php" target='_blank'>
<img border=2 src="obr/ikony/cecko.jpg" width=30 height=30 border=1 title="Certifikát ekonomického systému"/></A>
<A Href="../mzdy/dochadzka.php?zmenu=1" target='_self'>
<img border=2 src="obr/ikony/hodiny.jpg" width=30 height=30 border=1 title="Dochádzkový systém"/></A>
<A Href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/dopr.php?copern=1&newmenu=1&kjazd=1" target='_blank'>
<img border=2 src="obr/ikony/volant.jpg" width=30 height=30 border=1 title="Kniha jázd"/></A>
<?php if( ( $_SERVER['SERVER_NAME'] == "www.edcom.sk" OR $_SERVER['SERVER_NAME'] == "localhost" ) AND $kli_uzid != 53 ) { ?>
<A Href="<?php echo $akehttp; ?>//<?php echo $webnaz; ?>/secom/servis.php?copern=1&druhzoznamu=1" target='_blank'>
<img border=2 src="obr/banky/euro.jpg" width=30 height=30 border=1 title="Užívatelia Reg.pokladnice Secom,Edcom,Eurosecom..."/></A>
<?php                                                                     } ?>
                </tr>               
              </table>


<?php                       } ?>               
              
              <!-- obsah konec --> 
              <div class="margin_bottom_20"></div>
              
                
                <div class="cleaner"></div>
            </div>
            
             
			      
            
        </div> <!-- end of content -->
        
       
    	
        <div class="cleaner"></div>    
    </div> <!-- end of content wrapper -->
    
</div>
</div>


 <div id="templatemo_footer">

 Copyright © 2011  <b>EDcom</b> <?php if( $dajmenu == 1 ) { echo "verzia: ".$verzia." "; } ?>       

<?php if( $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 AND $_SESSION['android'] == 0 AND $_SESSION['ipad'] == 0 AND $_SESSION['iphone'] == 0 AND $_SESSION['ie10'] == 0 ) { echo " IE"; } ?>
<?php if( $_SESSION['ie10'] == 1 AND $msie11 == 0 ) { echo " IE v.10"; } ?>
<?php if( $_SESSION['ie10'] == 1 AND $msie11 == 1 ) { echo " IE v.11"; } ?>
<?php if( $_SESSION['chrome'] == 1 ) { echo " Chrome"; } ?>
<?php if( $_SESSION['android'] == 1 ) { echo " Android"; } ?>
<?php if( $_SESSION['safari'] == 1 ) { echo " Apple Safari"; } ?>
<?php if( $_SESSION['ipad'] == 1 AND $_SESSION['iphone'] == 0 ) { echo " iPad"; } ?>
<?php if( $_SESSION['ipad'] == 1 AND $_SESSION['iphone'] == 1 ) { echo " iPhone"; } ?>
<?php if( $_SERVER['SERVER_NAME'] == "www.edcom.sk" AND $kli_uzid == 17 ) { echo " ".$prehliadac; } ?>

   	</div> <!-- end of footer -->
    <div class="margin_bottom_10"></div>
    
    <div class="content_section">
    	<center>
       
	    </center>
		<div class="margin_bottom_10"></div>
	</div>

<?php if( $dajmenu == 0 ) { $_SESSION['kli_vhsxy'] = 1010; } ?>

</body>
</html>