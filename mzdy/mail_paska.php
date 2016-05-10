<HTML>
<?php
$sys = 'MZD';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

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
$cislo_oc = $_REQUEST['cislo_oc'];
$posem = 1*$_REQUEST['posem'];

$outfilex = $_REQUEST['outfilex'];

$citfir = include("../cis/citaj_fir.php");

$sqlt = <<<prsaldo
(
   pox         DECIMAL(10,0),
   oc          DECIMAL(10,0),
   ume         DECIMAL(10,4),
   mail        VARCHAR(50),
   dao         TIMESTAMP
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdmailovanepasky'.$sqlt;
$vytvor = mysql_query("$vsql");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Upomienka PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Výplatná páska do mailu</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 
//////////////////////////////////////////////////////ak je email
if ( $posem == 1 )
          {
//nacitaj meno,heslo a mail
$meno=" ";
$heslo=" ";
$emailkomu="andrejd@edcom.sk";
$emailodkoho="edcom@edcom.sk";
$nazov=" ";

$predmet=$fir_fnaz.", ".$fir_fmes." VYPLATNA PASKA za $kli_vume ";
$text="V prílohe Vám posielame výplatnú pásku za obdobie $kli_vume "."\n";


require_once("activeMailLib.php");
$att1=$outfilex;//set a valid file path



$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkun ".
" WHERE oc = $cislo_oc ".
" ORDER BY oc ";
$sqlmax = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sqlmax);

         
$i=0;
  while ($i <= $cpol )
  {

  if (@$zaznam=mysql_data_seek($sqlmax,$i))
{
$riaddok=mysql_fetch_object($sqlmax);


   $emailkomu=$riaddok->zema;
   $emailodkoho=$fir_fem3;
   $oc=$riaddok->oc;
   $prie=$riaddok->prie;
   $meno=$riaddok->meno;


if( $emailodkoho == '' )
{
 echo "Nemáte zadaný email č.3 v údajoch o Vašej firme <br />";
 exit;
}
 

if( $emailkomu == '' )
{
 echo "Vybraný zamestnanec osč ".$oc." nemá zadaný email v údajoch o zamestnancovi. <br />";
 exit;
}
else
{

$email = new activeMailLib();
$email->enableAddressValidation();

$email->From("$emailodkoho");//set a valid E-mail
$email->Subject("$predmet");
$email->Message("$text");
$email->Attachment($att1,"paska$kli_vume.pdf");
$email->To("$emailkomu");//set a valid E-mail
$email->Send();



print "Email pre ".$prie." ".$meno." osč ".$oc." bol odoslaný .<br>\n";


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmailovanepasky ( pox,oc,ume,mail ) VALUES ( '0', '$cislo_oc', '$kli_vume', '$emailkomu' )  ";
$dsql = mysql_query("$dsqlt");

}

//koniec cyklus
}
$i = $i + 1;
  }



//////////////////////////////////////////////////////koniec ak je email posem=1
          }


//////////////////////////////////////////////////////ak je email
if ( $posem == 444 )
          {

$tovtt = "SELECT * FROM F$kli_vxcf"."_mzdkun ".
" WHERE oc = $cislo_oc ".
" ORDER BY oc ";


$predmet=$fir_fnaz.", ".$fir_fmes." VYPLATNA PASKA za $kli_vume ";
$predmet = StrTr($predmet, "áäčďéěëíľňôóöŕřšťúůüýžÁÄČĎÉĚËÍĽŇÓÖÔŘŔŠŤÚŮÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");

$riadok1="V prílohe Vám posielame výplatnú pásku za obdobie $kli_vume "."\n";
$riadok2=" ";
$riadok3=" "."\n";

$sprava=$riadok1.$riadok2.$riadok3;
$fakrd="";

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
$koniec=$tvpol-1;
if( $tvpol > 0 ) $jetovar=1;
$jednapolozka=0;
if( $tvpol == 1 ) $jednapolozka=1;

//Ak su polozky
if( $jetovar == 1 )
           {
$j=0;
$i=0;
  while ($i <= $koniec )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

if( $i == 0 )
  {
$odberatel="\n"."Pre zamestnanca osč ".$rtov->oc." ".$rtov->prie.", ".$rtov->meno."\n"."\n";
$odberatel = StrTr($odberatel, "áäčďéěëíľňôóöŕřšťúůüýžÁÄČĎÉĚËÍĽŇÓÖÔŘŔŠŤÚŮÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$sprava=$sprava.$odberatel;
  }


$emailkomu=$rtov->zema;
//echo $emailkomu;
}
$i = $i + 1;
$j = $j + 1;


  }
//koniec while
           }
//koniec ak su polozky


$sprava=$sprava." "."\n";



$sprava = StrTr($sprava, "áäčďéěëíľňôóöŕřšťúůüýžÁÄČĎÉĚËÍĽŇÓÖÔŘŔŠŤÚŮÜÝŽ",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");


$emailodkoho=$fir_fem3;
//echo $emailodkoho;

if( $emailkomu == '' )
{
 echo "Vybraný zamestnanec nemá zadaný email v údajoch o zamestnancovi. <br />";
 exit;
}

if( $emailodkoho == '' )
{
 echo "Nemáte zadaný email č.3 v údajoch o Vašej firme <br />";
 exit;
}

if(mail("$emailkomu;$fir_fem3","$predmet","$sprava","From: $emailodkoho"))
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmailovanepasky ( pox,oc,ume,mail ) VALUES ( '0', '$cislo_oc', '$kli_vume', '$emailkomu' )  ";
$dsql = mysql_query("$dsqlt");

 echo "Komu: ".$emailkomu."<br />";
 echo "Od: ".$emailodkoho."<br />";
 echo $predmet."<br />";
 echo $riadok1."<br />";
 echo $riadok2."<br />";
 echo $riadok3."<br />";
 echo $fakrd."<br />";

 echo "<br />";
 echo "<br />";

 print "Email bol úspešne odoslaný. <br />";
}
else
{
 print "Email nebol odoslaný zopakujte odosielanie.<br>\n";
}

//////////////////////////////////////////////////////koniec ak je email
          }

?>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
