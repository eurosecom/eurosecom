<HTML>
<?php

//toto je prenos externej pokladnice z ineho cisla firmy
// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$h_sys = 1*$_REQUEST['h_sys'];
$h_obdp = 1*$_REQUEST['h_obdp'];

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokpokl_".$h_sys."_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { echo "Prenos externej pokladnice $h_sys v obdobÌ $h_obdp.$kli_vrok je zablokovanÈ"; exit; } 

//echo "idem prenos $h_sys v obdobÌ $h_obdp";
//exit;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$h_cfir=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklsluudaje WHERE xuce1 = $h_sys ORDER BY xuce1 ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jeuctovaniesluziebpok=1;
  if( $i == 0 ) { $h_cfir=1*$riaddok->xuce2; } 
  }

if( $copern == 55 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete preniesù extern˙ pokladnicu <?php echo $h_sys; ?> z firmy <?php echo $h_cfir; ?> za obdobie <?php echo $h_obdp; ?>.<?php echo $kli_vrok; ?> ?") )
         { window.close();  }
else
  var okno = window.open("ext_pokl.php?copern=56&page=1&h_sys=<?php echo $h_sys; ?>&h_obdp=<?php echo $h_obdp; ?>&drupoh=1&uprav=1","_self");
</script>

<?php
exit;
}


//exit;

///////prenes pokladnicu
if( $copern == 56 )
{


$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$datp_ume=$kli_vrok.'-'.$h_obdp.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_ume', '$datp_ume', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp=SUBDATE('$datp_ume',0),  datk=LAST_DAY('$datp_ume')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_ume=$riadok->datp;
  $datk_ume=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$podmdat=" dat >= '".$datp_ume."' AND dat <= '".$datk_ume."' ";

//echo $podmdat;
//exit;


$pohcis=1000000*$h_obdp+$h_sys;
$kli_vzcf=$h_cfir;


//daj do faktur fakodb
$dsqlt = "DELETE FROM F$kli_vxcf"."_pokpri WHERE uce = $h_sys AND $podmdat ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt."<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_pokvyd WHERE uce = $h_sys AND $podmdat ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt."<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_uctpokuct WHERE unk = $pohcis ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt."<br />";


//pokpri uce	ume	dat	dok	doq	txp	txz	ico	kto	unk	poz	
//zk0	zk1	zk2	zk3	zk4	sz1	sz2	sz3	sz4	dn1	dn2	dn3	dn4	sp1	sp2	sp3	sp4	
//zk0u	zk1u	zk2u	dn1u	dn2u	sp0u	sp1u	sp2u	hodu	hod	hodm	kurz	mena	zmen	id	datm

//pokvyd uce	ume	dat	dok	doq	txp	txz	ico	kto	unk	poz	
//zk0	zk1	zk2	zk3	zk4	sz1	sz2	sz3	sz4	dn1	dn2	dn3	dn4	sp1	sp2	sp3	sp4	
//zk0u	zk1u	zk2u	dn1u	dn2u	sp0u	sp1u	sp2u	hodu	hod	hodm	kurz	mena	zmen	id	datm

//uctpokuct dok	poh	cpl	ucm	ucd	rdp	dph	hod	hodm	kurz	mena	zmen	ico	fak	pop	str	zak	
//unk	id	datm
 

$dsqlt = "INSERT INTO F$kli_vxcf"."_pokpri ".
" SELECT ".
" uce, ume, dat, dok, doq, txp, txz, ico, kto, unk, poz,".	
" zk0, zk1, zk2, zk3, zk4, sz1, sz2, sz3, sz4, dn1, dn2, dn3, dn4, sp1, sp2, sp3, sp4,".	
" zk0u, zk1u, zk2u, dn1u, dn2u, sp0u, sp1u, sp2u, hodu, hod, hodm, kurz, mena, zmen, id, datm".
" FROM F$kli_vzcf"."_pokpri ".
" WHERE  uce = $h_sys AND $podmdat ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_pokvyd ".
" SELECT ".
" uce, ume, dat, dok, doq, txp, txz, ico, kto, unk, poz,".	
" zk0, zk1, zk2, zk3, zk4, sz1, sz2, sz3, sz4, dn1, dn2, dn3, dn4, sp1, sp2, sp3, sp4,".	
" zk0u, zk1u, zk2u, dn1u, dn2u, sp0u, sp1u, sp2u, hodu, hod, hodm, kurz, mena, zmen, id, datm".
" FROM F$kli_vzcf"."_pokvyd ".
" WHERE  uce = $h_sys AND $podmdat ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$sqltt = "SELECT * FROM F$kli_vzcf"."_pokpri WHERE uce = $h_sys AND $podmdat ORDER BY dok";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);



$dsqlt = "INSERT INTO F$kli_vxcf"."_uctpokuct ".
" SELECT ".
" dok, poh, 0, ucm, ucd, rdp, dph, hod, hodm, kurz, mena, zmen, ico, fak, pop, str, zak,".
" '$pohcis', id, datm".
" FROM F$kli_vzcf"."_uctpokuct ".
" WHERE  dok = $riadok->dok  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


}
$i=$i+1;
  }

$sqltt = "SELECT * FROM F$kli_vzcf"."_pokvyd WHERE uce = $h_sys AND $podmdat ORDER BY dok";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);



$dsqlt = "INSERT INTO F$kli_vxcf"."_uctpokuct ".
" SELECT ".
" dok, poh, 0, ucm, ucd, rdp, dph, hod, hodm, kurz, mena, zmen, ico, fak, pop, str, zak,".
" '$pohcis', id, datm".
" FROM F$kli_vzcf"."_uctpokuct ".
" WHERE  dok = $riadok->dok  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


}
$i=$i+1;
  }

//echo $dsqlt."<br />";
//exit;


}
///////koniec prenos pokladnice


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Za˙Ëtovanie intern˝ch fakt˙r</title>
  <style type="text/css">
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

    

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Za˙Ëtovanie intern˝ch fakt˙r

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
if( $copern == 56  )
{

?>
OK
<script type="text/javascript">
    window.open('vstpok.php?copern=1&drupoh=1&page=1&hladaj_uce=<?php echo $h_sys;?>', '_self' );
</script>
<?php
}
?>


<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
