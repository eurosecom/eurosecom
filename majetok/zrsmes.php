<HTML>
<?php
$sys = 'HIM';
$urov = 2000;
$cslm=500502;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;



//tabulka so zostavami
$vsql = "DROP TABLE F$kli_vxcf"."_majzostavy".$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   dat1          timestamp(14) NOT NULL,
   date          timestamp(14) NOT NULL,
   name          VARCHAR(50) NOT NULL,
   nam2          VARCHAR(50) NOT NULL,
   mesx          DECIMAL(10,2) DEFAULT 0,
   konx1         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = "CREATE TABLE F$kli_vxcf"."_majzostavy".$kli_uzid." ".$sqlt;
$vytvor = mysql_query("$vsql");

$adresar = opendir("../dokumenty/FIR".$kli_vxcf);
chdir("../dokumenty/FIR".$kli_vxcf);


while ($soubor = readdir($adresar))
{

if(is_file($soubor))
    {

$filename = "$soubor";
if (file_exists($filename)) {

$datumzmeny=date ("Y-m-d h:i:s", filemtime($filename));


$ttvv = "INSERT INTO F$kli_vxcf"."_majzostavy".$kli_uzid." ( date,name,konx1  ) VALUES ( '$datumzmeny', '$filename', '1' )";
$ttqq = mysql_query("$ttvv");
//echo $ttvv."<br />";

                            }

    }

}

$vsql = "DELETE FROM F$kli_vxcf"."_majzostavy".$kli_uzid." WHERE LEFT(name,6) != 'mesodp' ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F$kli_vxcf"."_majzostavy".$kli_uzid." SET mesx=SUBSTRING(name,8,2), nam2=SUBSTRING(name,8,2)  ";
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_majzostavy".$kli_uzid." SELECT dat1,MAX(date),name,nam2,mesx,2 FROM F$kli_vxcf"."_majzostavy".$kli_uzid." WHERE konx1 = 1 GROUP BY mesx ";
$ttqq = mysql_query("$ttvv");
//echo $ttvv."<br />";

          $vyslettt = "SELECT * FROM F$kli_vxcf"."_majzostavy$kli_uzid WHERE konx1 = 2 ORDER BY mesx ";
          $vysledok = mysql_query("$vyslettt");
          while ($riadok = mysql_fetch_object($vysledok))
          {


                $vsql = "DELETE FROM F$kli_vxcf"."_majzostavy".$kli_uzid." WHERE konx1 = 1 AND mesx = $riadok->mesx AND date != '$riadok->date' ";
                $vytvor = mysql_query("$vsql");


          	//echo $vsql."<br />";



          }
          //koniec cyklu

//koniec tabulka so zostavami


//zrusenie uzavierky
if( $copern == 6 )
           {
$ume = $_REQUEST['ume'];
$pole = explode(".", $ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


$zmaztt = "DELETE FROM F$kli_vxcf"."_majmajmes WHERE ume=$ume ";
//echo $zmaztt;
$zmazane = mysql_query("$zmaztt"); 

$zmaztt = "DELETE FROM F$kli_vxcf"."_majodpisy WHERE ume=$ume ";
//echo $zmaztt;
$zmazane = mysql_query("$zmaztt");

if (File_Exists ("../dokumenty/FIR/$kli_vxcf/mesodp.$kli_vmes.pdf")) { $soubor = unlink("../dokumenty/FIR/$kli_vxcf/mesodp.$kli_vmes.pdf"); }

$sqlt = "DROP TABLE F$kli_vxcf"."_majmaj";
//echo $sqlt;

$vysledok = mysql_query("$sqlt");

$rentt = "RENAME TABLE F$kli_vxcf"."_majmaj_$kli_vmes"."_$kli_vrok"." TO F$kli_vxcf"."_majmaj";
//echo $rentt;

$vysledok = mysql_query("$rentt");


//oznac pohyby hx2=0
$sqtoz = "UPDATE F$kli_vxcf"."_majpoh".
" SET hx2=0".
" WHERE ume = $ume ";
$oznac = mysql_query("$sqtoz");

$copern=1;
           }

?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zruöenie mesaËnÈho odpisu</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
function DajZostavu(zostava)
                {

window.open('../dokumenty/FIR<?php echo $kli_vxcf; ?>/' + zostava + '',
 "_blank", "width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes" );
                }

</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Prehæady a ruöenie mesaËn˝ch odpisov dlhodobÈho majetku</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 

$poslhh = "DROP TABLE F$kli_vxcf"."_majmajmes".$kli_uzid." ";
$posl = mysql_query("$poslhh");
$poslhh = "CREATE TABLE F$kli_vxcf"."_majmajmes".$kli_uzid." SELECT * FROM F$kli_vxcf"."_majmajmes ";
$posl = mysql_query("$poslhh");

//otestuj ci tam je mesiac ak existuje majmaj_1_2015 
$mesac=1;
while( $mesac < 13 ) 
  {
$poslhh = "SELECT * FROM F$kli_vxcf"."_majmaj_$mesac"."_$kli_vrok ";
$posl = mysql_query("$poslhh");
if($posl)
     {
//echo $poslhh."<br />";


$mesacrok=$mesac.".".$kli_vrok;
$niejemesac=1;
$poslhh2 = "SELECT * FROM F$kli_vxcf"."_majmajmes$kli_uzid WHERE ume = $mesacrok ORDER BY ume DESC LIMIT 1";
$posl2 = mysql_query("$poslhh2"); 
  if (@$zaznam=mysql_data_seek($posl2,0))
  {
  $posled2=mysql_fetch_object($posl2);
  $niejemesac=0;
  }

//echo $poslhh2."<br />";

if( $niejemesac == 1 ) 
       {
$poslhh3 = "INSERT INTO F$kli_vxcf"."_majmajmes$kli_uzid ( ume, druh, drm, mno ) VALUES ( '$mesacrok', 0, 999, 0 ) ";
$posl3 = mysql_query("$poslhh3");

       }

//echo $poslhh3."<br />";

     }


$mesac=$mesac+1;
  }

$poslhh = "SELECT * FROM F$kli_vxcf"."_majmajmes$kli_uzid WHERE ume > 0 ORDER BY ume DESC LIMIT 1";
$posl = mysql_query("$poslhh"); 
  if (@$zaznam=mysql_data_seek($posl,0))
  {
  $posled=mysql_fetch_object($posl);
  $poslume = $posled->ume;
  }

$tovtt = "SELECT * FROM F$kli_vxcf"."_majmajmes$kli_uzid ".
" WHERE ume > 0 ".
" ORDER BY ume";
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;
?>

<?php
//Ak je tovar tvtvtvtvtvtvtvtvtvtvtvtvtvtvtvtvtvtvtvttvtvtv
if( $jetovar == 1 )
           {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="10%">Obdobie
<td class="bmenu" width="10%">Poloûiek
<td class="bmenu" width="10%" align="right" >Obstar·vacia cena
<td class="bmenu" width="10%" align="right" >Opr·vky
<td class="bmenu" width="10%" align="right" >Zostatkov· cena
<td class="bmenu" width="10%" align="right" >MesaËn˝ odpis
<td class="bmenu" width="10%" align="right" >RoËn˝ odpis
<td class="bmenu" width="10%" align="right" >RoËn˝ pl·nov.odpis
<td class="bmenu" width="10%" align="center" >Zostavy
<td class="bmenu" width="10%" align="center" >Zruöiù spracovanie
</tr>

<?php
//zaciatok vypisu
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$pole = explode(".", $rtov->ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

?>

<tr>
<td class="fmenu" >&nbsp;<?php echo $rtov->ume;?></td>
<td class="fmenu" >&nbsp;<?php echo $rtov->mno;?></td>
<td class="fmenu" align="right">&nbsp;<?php echo $rtov->cen;?></td>
<td class="fmenu" align="right">&nbsp;<?php echo $rtov->ops;?></td>
<td class="fmenu" align="right">&nbsp;<?php echo $rtov->zos;?></td>
<td class="fmenu" align="right">&nbsp;<?php echo $rtov->mes;?></td>
<td class="fmenu" align="right">&nbsp;<?php echo $rtov->ros;?></td>
<td class="fmenu" align="right">&nbsp;<?php echo $rtov->rop;?></td>
<td class="fmenu" align="center">
<?php
$zostavaxx="";
$poslhh = "SELECT * FROM F$kli_vxcf"."_majzostavy$kli_uzid WHERE konx1 = 1 AND mesx = $kli_vmes ";
$posl = mysql_query("$poslhh"); 
  if (@$zaznam=mysql_data_seek($posl,0))
  {
  $posled=mysql_fetch_object($posl);
  $zostavaxx = $posled->name;
  }

?>
<img src='../obr/tlac.png' width=15 onclick="DajZostavu('<?php echo $zostavaxx; ?>');" height=10 border=0 title="Zostava mesaËn˝ch odpisov <?php echo $rtov->ume; ?>" ></a>
</td>
<td class="fmenu" align="center">
<?php
if( $poslume == $rtov->ume )
{
?>
<a href="zrsmes.php?copern=6&ume=<?php echo $rtov->ume; ?>" target="_self">
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt="Zruöiù mesaËnÈ odpisy <?php echo $rtov->ume; ?>" ></a>
<?php
}
?>
</td>
</tr>


<?php
}
$i = $i + 1;
  }
?>

</table>

<?php
///////////////////////////////Koniec tlace tovaru tvtvtvtvtvtvtvtvtvtvtvtvtvtvtvtvt
           }
?>


<?php
// celkovy koniec dokumentu

$cislista = include("maj_lista.php");

       } while (false);
?>
</BODY>
</HTML>
