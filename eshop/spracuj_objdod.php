<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kopia_dok = 1*strip_tags($_REQUEST['kopia_dok']);
$cislo_dok = 1*strip_tags($_REQUEST['cislo_dok']);
$hladaj_uce = 1*strip_tags($_REQUEST['hladaj_uce']);
if( $hladaj_uce == 0 ) $hladaj_uce=31100;
$lensklad = 1*$_REQUEST['lensklad'];
$zprac = 1*$_REQUEST['zprac'];
$dodaneobj = 1*$_REQUEST['dodaneobj'];

//echo "dodaneobj ".$dodaneobj."<br />";
//echo "zprac ".$zprac."<br />";
//echo "lensklad ".$lensklad."<br />";
//echo "cislo_dok ".$cislo_dok."<br />";
//echo "hladaj_uce ".$hladaj_uce."<br />";
//echo "copern ".$copern."<br />";
//echo "drupoh ".$drupoh."<br />";
//exit;


$vsetkozaico=0; 
$xico99=0;


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$citwebs = include("../funkcie/citaj_webs.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$somvprirskl=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$dnes_sql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pole = explode("-", $dnes_sql);
$ume = $pole[1].".".$pole[0];

$kli_vxcfxxx=$kli_vxcf;

$kopia_dok=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdol WHERE dok > 0 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kopia_dok=1*$riaddok->dok + 1;
  $hladaj_uce=1*$riaddok->uce;
  }

$sqlttt = "INSERT INTO F$kli_vxcf"."_fakdol ( uce, dok, doq ) VALUES ('$hladaj_uce', '$kopia_dok', '$kopia_dok')"; 
$sqldok = mysql_query("$sqlttt");


if( $copern == 2 )
    {
$sqlttt = "SELECT * FROM F$kli_vxcfxxx"."_kosikobj WHERE xdok = $cislo_dok ORDER BY xdok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $ico=$riaddok->xice;
 $odbmk=1*$riaddok->xodbm;
 $datm=$riaddok->xdatm;
 $xid=$riaddok->xid;
 }
    }


if( $copern == 2 AND $drupoh == 11 )
  {
$skl=$fir_xfa05;
$str=$fir_fakstr;
$zak=$fir_fakzak;
$poh=61;
$ekto="";


$skdatum=SkDatum($datm); 

$cislo_obj=$cislo_dok;
$txp="Objednávka è.".$cislo_dok." z ".$skdatum." objednal ".$ekto;
if( $fir_fico == 46614478 ) { $txp="Objednávka è.".$cislo_dok." z ".$skdatum; }

$dns=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $ico ORDER BY ico LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dns=1*$riaddok->dns;
  }


$dsqlt = "UPDATE F$kli_vxcf"."_fakdol SET odbm='$odbx', sz3='$kopia_dok', id='$kli_uzid', ".
" hodm='$hodm', kurz='$kurz', mena='$mena', zmen='$zmen', str='$str', zak='$zak', ksy='0308', obj='$cislo_obj', dol='$kopia_dok', prf='', ".
" zk0='$zk0', zk1='$zk1', zk2='$zk2', dn1='$dn1', dn2='$dn2', sp1='$sp1', sp2='$sp2', hod='$hod', skl=0, poh=0, fak='$kopia_dok', ".
" txp='$txp', fak=0, unk='$unk', dat='$dnes_sql', das=DATE_ADD(dat,INTERVAL $dns DAY), daz='$dnes_sql', ico='$ico',  ume='$ume' WHERE dok=$kopia_dok ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt;
//exit;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_fakdol WHERE dok = $kopia_dok ORDER BY dok DESC LIMIT 1"; 
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $ico=$riaddok->ico;
 $dat=$riaddok->dat;
 $ume=$riaddok->ume;
 }

if( $zprac == 0 ) 
     {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_kosikobj ".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_kosikobj.xcis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_sklzaspriemer".
" ON F$kli_vxcf"."_sklcis.cis=F$kli_vxcf"."_sklzaspriemer.cis".
" WHERE xdok = $cislo_dok AND xfak = 0 ORDER BY xdok,xcpo ";
     }


//echo $sqlttt;
//exit;


$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;


while ($i <= $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
    {
  $riadok=mysql_fetch_object($sql);

//sklfak cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  dol  prf  poz  str  zak  
//cis  nat  dph  mer  pop  mno  cen  cep  ced  id  sk2  datm  me2  mn2 


//kosikobj xdok  xfak  xsx1  xsx2  xsx3  xdx1  xdx2  xdx3  xice  xcpo  xcpl  xcis  xnat  xdph  xcep  xced  xmno  xhdb  xhdd  xid  xdatm  
  
if( $riadok->xsx3 == 0 AND $zprac == 0 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklfak "." SELECT".
" 0,'$ume','$dat','$kopia_dok','$kopia_dok','$skl','$poh','$ico','$kopia_dok','$riadok->xcpo','$riadok->xsx1','','','$str','$zak',".
" '$riadok->xcis','$riadok->nat','$riadok->xdph','$riadok->mer','','$riadok->xmno','$riadok->cen','$riadok->xcep','$riadok->xced',$kli_uzid,0,now(),0,0 ".
" FROM F$kli_vxcfxxx"."_kosikobj ".
" WHERE xcpo = $riadok->xcpo  ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
  }


if( $zprac == 0 )
  {
$sqtz = "UPDATE F$kli_vxcfxxx"."_kosikobj SET xfak='$kopia_dok' WHERE xcpo=$riadok->xcpo ";
$upravene = mysql_query("$sqtz");
//echo $sqtz;
  }


//fakslu dok  fak  dol  prf  cpl  slu  nsl  pop  pon  dph  cen  cep  ced  mno  mer  pfak  cfak  dfak  id  datm  

if( $riadok->xsx3 == 1 AND $zprac == 0 )
  {
$cislo=1*$riadok->xcis;
$nazov=$riadok->xnat;

$dsqlt = "INSERT INTO F$kli_vxcf"."_fakslu "." SELECT".
" '$kopia_dok','$kopia_dok',0,0,0,".
" '$cislo','$nazov','','','$riadok->xdph',0,'$riadok->xcep','$riadok->xced','$riadok->xmno','$riadok->mer',0,0,0,$kli_uzid,now() ".
" FROM F$kli_vxcfxxx"."_kosikobj ".
" WHERE xcpo = $riadok->xcpo ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
  }


//pripocitaj do napoctov novu
$h_ced=$riadok->xced*$riadok->xmno;
$h_cep=$riadok->xcep*$riadok->xmno;
$h_dph=$riadok->xdph;

$h_ced2 = $h_ced;
$h_cep2 = $h_cep;
$h_ced1 = 0;
$h_cep1 = 0;
$h_cep0 = 0;
if( $h_dph == $fir_dph1 )
{
$h_ced1 = $h_ced;
$h_cep1 = $h_cep;
$h_ced2 = 0;
$h_cep2 = 0;
$h_cep0 = 0;
}
if( $h_dph == 0 )
{
$h_cep0 = $h_cep;
$h_ced1 = 0;
$h_cep1 = 0;
$h_ced2 = 0;
$h_cep2 = 0;
}

$sqtz = "UPDATE F$kli_vxcf"."_fakdol SET zk1=zk1+'$h_cep1', sp1=sp1+('$h_ced1'), dn1=sp1-zk1,".
" zk2=zk2+'$h_cep2', sp2=sp2+('$h_ced2'), dn2=sp2-zk2,".
" zk0=zk0+'$h_cep0', hod=sp1+sp2+zk0 ".
" WHERE dok='$kopia_dok'";
$upravene = mysql_query("$sqtz");


    }
$i=$i+1;
}



  }
//koniec if( $copern == 2 AND $drupoh == 11 )

//$sqtz = "UPDATE F54_kosikobj SET xfak=0 ";
//exit;

$priemer = include("../sklad/skl_rekonstrukcia.php");

//<a href='vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=31100&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT
//&cislo_dok=720010&h_fak=720010&h_dol=0&h_prf=0'>

//exit;

if( $copern == 2 )
  {
?> 
<script type="text/javascript">
  var okno = window.open("../faktury/vstf_u.php?sysx=UCT&hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=ANO&copern=8&drupoh=11&page=1&h_tltv=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $kopia_dok; ?>&h_uce=<?php echo $hladaj_uce; ?>","_self");
</script>
<?php 
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Spracuj OBJ</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>



<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    



</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
