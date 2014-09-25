<HTML>
<?php

//VERZIA SOBOTU a NEDELU nerobim, ak je sviatok a nie je to So a Ne a nemem nahratu 510 daj mi odpracovane
// celkovy zaciatok dokumentu
       do
       {
$sys = 'VYR';
$urov = 2000;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

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


if ( $copern == 1 )
        {
?>
<script type="text/javascript">
if( !confirm ("Chcete generovaù doch·dzku ? \r POZOR !!! Doterajöia doch·dzka v nastavenom ˙Ëtovnom mesiaci bude vymazan·. ") )
         { window.close();  }

else
         { location.href='dochadzka_gen.php?copern=2&drupoh=3&page=1';  }

</script>
<?php
exit;
        }


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$ume=$kli_vume;
//pocet dni v mesiaci
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

$pocetbezsonesv=20;
$sqltt = "SELECT * FROM kalendar WHERE ume = $ume AND akyden < 6 AND svt = 0 ";
$sql = mysql_query("$sqltt");
$pocetbezsonesv = mysql_num_rows($sql);

//prvy a posledny den
$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ORDER BY dat ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $denprvy=$riaddok->dat;
  $denprvysk=SkDatum($riaddok->dat);
  }


$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ORDER BY dat DESC";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $denposledny=$riaddok->dat;
  $denposlednysk=SkDatum($riaddok->dat);
  }

//ktore dni su pondelky
$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vume AND akyden = 1 ORDER BY dat ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pon1=$riaddok->dat;
  }
  if (@$zaznam=mysql_data_seek($sqldok,1))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pon2=$riaddok->dat;
  }
  if (@$zaznam=mysql_data_seek($sqldok,2))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pon3=$riaddok->dat;
  }
//echo $pon1." ".$pon2." ".$pon3." ";

//vymaz doterajsiu
$dsqlt = "DELETE  FROM F$kli_vxcf"."_mzddochadzka WHERE ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");


$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcuoc'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   pox          DECIMAL(10,0) DEFAULT 0,
   cpx          int not null auto_increment,
   ume          DECIMAL(7,4) DEFAULT 0,
   str          DECIMAL(10,0) DEFAULT 0,
   dok          DECIMAL(10,0) DEFAULT 0,
   dm           DECIMAL(10,0) DEFAULT 0,
   dat          DATE not null,
   dap1         DATE not null,
   dak1         DATE not null,
   dap          DATE not null,
   dak          DATE not null,
   oc           DECIMAL(10,0) DEFAULT 0,
   dni          DECIMAL(10,1) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kon          INT(7) DEFAULT 0,
   PRIMARY KEY(cpx)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcuoc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$strxx=" oc < 0 ";
$strkunxx=" oc >= 0 ";

$generovacie=0;
if( $_SERVER['SERVER_NAME'] == "www.merkfood.sk" ) { $generovacie=1; }
if( $_SERVER['SERVER_NAME'] == "www.eurolark.sk" ) { $generovacie=1; }

if( $generovacie == 1 ) 
{
$strxx=" str != 1 ";
$strkunxx=" stz = 1 AND pom = 1 ";
}
//mzdmes cpl dok dat ume oc dm dp dk dni hod mnz saz kc str zak stj msx1 msx2 msx3 msx4 pop id datm 

//ak ma vyplnene dp,dk v mesacnej zarad priamo do dochadzky
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcx".$kli_uzid.
" SELECT 1,0,ume,0,dok,dm,dat,dp,dk,dp,dk,oc,dni,hod,0 ".
" FROM F$kli_vxcf"."_mzdzalmes ".
" WHERE ume = $kli_vume AND dp >= '$denprvy' AND dp <= '$denposledny' AND dk >= '$denprvy' AND dk <= '$denposledny' AND dm > 500 AND dm < 899 ";
$dsql = mysql_query("$dsqlt");


$mzdkun="mzdkun";
if( $generovacie == 1 ) 
{
$mzdkun="mzdkunx".$kli_uzid;

$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "CREATE TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume ";
$sqlxx = mysql_query("$sqlttxx");
}
if( $generovacie == 1  ) 
{
$mzdkun="mzdkunx".$kli_uzid;

$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "CREATE TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume AND stz = 1 AND pom = 1 ";
$sqlxx = mysql_query("$sqlttxx");
}


$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcx".$kli_uzid.",F$kli_vxcf"."_$mzdkun ".
" SET F$kli_vxcf"."_mzdprcx".$kli_uzid.".str=F$kli_vxcf"."_$mzdkun.stz".
" WHERE F$kli_vxcf"."_mzdprcx".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." WHERE $strxx ";
$dsql = mysql_query("$dsqlt");



//ak nema vyplnene dp,dk v mesacnej rozhod nahodne na dni podla poctu dni v dni z mesacnej
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SELECT 1,0,ume,0,dok,dm,dat,'','','','',oc,dni,hod,0 ".
" FROM F$kli_vxcf"."_mzdzalmes ".
" WHERE ume = $kli_vume AND dp = '0000-00-00' AND dk = '0000-00-00' AND dm > 500 AND dm < 899 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE dm = 508 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcu".$kli_uzid.",F$kli_vxcf"."_$mzdkun ".
" SET F$kli_vxcf"."_mzdprcu".$kli_uzid.".str=F$kli_vxcf"."_$mzdkun.stz".
" WHERE F$kli_vxcf"."_mzdprcu".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." WHERE $strxx ";
$dsql = mysql_query("$dsqlt");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=$riaddok->uva_hod;
  }

//vyries sviatky
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcuoc$kli_uzid ".
" SELECT 1,0,'$kli_vume',0,dok,dm,dat,'','','','',oc,SUM(dni),0,0 ".
" FROM F$kli_vxcf"."_mzdprcu$kli_uzid ".
" WHERE dm = 510 GROUP BY oc ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcuoc$kli_uzid ".
" SELECT 1,0,0,0,9,510,'','','','','',oc,0,0,0 ".
" FROM F$kli_vxcf"."_$mzdkun ".
" WHERE $strkunxx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcuoc$kli_uzid ".
" SELECT 2,0,'$kli_vume',0,dok,dm,dat,'','','','',oc,SUM(dni),0,0 ".
" FROM F$kli_vxcf"."_mzdprcuoc$kli_uzid ".
" WHERE oc > 0 GROUP BY oc ";
$dsql = mysql_query("$dsqlt");

//exit;

$sqlttxx = "DELETE FROM F$kli_vxcf"."_mzdprcuoc$kli_uzid WHERE pox != 2 ";
$sqlxx = mysql_query("$sqlttxx");

//ktore dni su sviatky max3
$svt1="0000-00-00"; $svt1den=0; $svt2="0000-00-00"; $svt2den=0; $svt3="0000-00-00"; $svt3den=0;
$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vume AND svt = 1 ORDER BY dat ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $svt1=$riaddok->dat; $svt1den=$riaddok->akyden;
  }
  if (@$zaznam=mysql_data_seek($sqldok,1))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $svt2=$riaddok->dat; $svt2den=$riaddok->akyden;
  }
  if (@$zaznam=mysql_data_seek($sqldok,2))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $svt3=$riaddok->dat; $svt3den=$riaddok->akyden;
  }

//echo $svt1." ".$svt1den." ".$svt2." ".$svt2den." ".$svt3." ".$svt3den;
//jeden zamestnanec
$sqlttk = "SELECT * FROM F$kli_vxcf"."_mzdprcuoc$kli_uzid WHERE oc > 0 ORDER BY oc ";
$sqlk = mysql_query("$sqlttk");
$polk = mysql_num_rows($sqlk);

$ik=0;
  while ( $ik <= $polk )
  {
  if (@$zaznam=mysql_data_seek($sqlk,$ik))
{
$hlavickak=mysql_fetch_object($sqlk);

if( $svt1 != '0000-00-00' AND $hlavickak->dni > 0 )
     {
$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickak->ume',  '$hlavickak->dok', '510', '$svt1', '$svt1', '$svt1', '$hlavickak->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");
     }
if( $svt2 != '0000-00-00' AND $hlavickak->dni > 1 )
     {
$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickak->ume',  '$hlavickak->dok', '510', '$svt2', '$svt2', '$svt2', '$hlavickak->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");
     }
if( $svt3 != '0000-00-00' AND $hlavickak->dni > 2 )
     {
$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickak->ume',  '$hlavickak->dok', '510', '$svt3', '$svt3', '$svt3', '$hlavickak->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");
     }

if( $svt1 != '0000-00-00' AND $hlavickak->dni == 0 )
     {
$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickak->ume',  '$hlavickak->dok', '1', '$svt1', '$svt1', '$svt1', '$hlavickak->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");
     }
if( $svt2 != '0000-00-00' AND $hlavickak->dni == 0 )
     {
$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickak->ume',  '$hlavickak->dok', '1', '$svt2', '$svt2', '$svt2', '$hlavickak->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");
     }
if( $svt3 != '0000-00-00' AND $hlavickak->dni == 0 )
     {
$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickak->ume',  '$hlavickak->dok', '1', '$svt3', '$svt3', '$svt3', '$hlavickak->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");
     }

//echo $dsqlt;
//exit;

}
$ik=$ik+1;
  }
$sqlttxx = "DELETE FROM F$kli_vxcf"."_mzdprcuoc$kli_uzid ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "DELETE FROM F$kli_vxcf"."_mzdprcu$kli_uzid WHERE dm=510 ";
$sqlxx = mysql_query("$sqlttxx");
//koniec vyries sviatky



//vyries polozky bez dp,dk
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcuoc$kli_uzid ".
" SELECT 1,0,0,0,9,99,'','','','','',oc,0,0,0 ".
" FROM F$kli_vxcf"."_$mzdkun ".
" WHERE $strkunxx ";
$dsql = mysql_query("$dsqlt");


//jeden zamestnanec
$sqlttk = "SELECT * FROM F$kli_vxcf"."_mzdprcuoc$kli_uzid WHERE oc > 0 ORDER BY oc ";
$sqlk = mysql_query("$sqlttk");
$polk = mysql_num_rows($sqlk);

$ik=0;
  while ( $ik <= $polk )
  {
  if (@$zaznam=mysql_data_seek($sqlk,$ik))
{
$hlavickak=mysql_fetch_object($sqlk);


//tu mu vytvorim volny kalendar a vymazem polozky obsadene
$sqlttxx = "DROP TABLE F".$kli_vxcf."_kalendar".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "CREATE TABLE F".$kli_vxcf."_kalendar".$kli_uzid." SELECT * FROM kalendar WHERE ume = $ume AND akyden < 6 AND svt = 0 ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "UPDATE F$kli_vxcf"."_kalendar$kli_uzid,F$kli_vxcf"."_mzdprcx$kli_uzid ".
" SET svt=2 ".
" WHERE F$kli_vxcf"."_kalendar$kli_uzid.dat >= F$kli_vxcf"."_mzdprcx$kli_uzid.dap AND F$kli_vxcf"."_kalendar$kli_uzid.dat <= F$kli_vxcf"."_mzdprcx$kli_uzid.dak ".
" AND oc = $hlavickak->oc " ;
$sqlxx = mysql_query("$sqlttxx");


$sqlttxx = "DELETE FROM F$kli_vxcf"."_kalendar$kli_uzid WHERE svt=2 ";
$sqlxx = mysql_query("$sqlttxx");

//tu skusim ak ma 506ku >= 5 zistim pondelky a 1,2 alebo 3ti skusim ci su volne dni ut-pia a dam tam 5dni dovolenky
$sqlttd = "SELECT * FROM F$kli_vxcf"."_mzdprcu$kli_uzid WHERE oc = $hlavickak->oc AND dm = 506 AND dni >= 5 ORDER BY oc,dat,dok ";
$sqld = mysql_query("$sqlttd");
$pold = mysql_num_rows($sqld);

$id=0;
  while ( $id <= 0 )
  {

  if (@$zaznam=mysql_data_seek($sqld,$id))
{
$hlavickad=mysql_fetch_object($sqld);

$xpon=rand(1, 3);
$ponx=$pon1; 
if( $xpon == 2 ) { $ponx=$pon2; }
if( $xpon == 3 ) { $ponx=$pon3; }

$poled = explode("-", $ponx);
$ponxd=$poled[2]; $utoxd=$ponxd+1; $strxd=$ponxd+2; $stvxd=$ponxd+3; $piaxd=$ponxd+4; 
$utox=$kli_vrok."-".$kli_vmes."-".$utoxd;
$strx=$kli_vrok."-".$kli_vmes."-".$strxd;
$stvx=$kli_vrok."-".$kli_vmes."-".$stvxd;
$piax=$kli_vrok."-".$kli_vmes."-".$piaxd;
$ponok=0;
$sqlttkal = "SELECT * FROM F".$kli_vxcf."_kalendar".$kli_uzid." WHERE dat='$ponx' ORDER BY dat ";
$sqldokkal = mysql_query("$sqlttkal");
  if (@$zaznam=mysql_data_seek($sqldokkal,0))
  {
  $riaddokkal=mysql_fetch_object($sqldokkal);
  $ponok=1;
  }
$utook=0;
$sqlttkal = "SELECT * FROM F".$kli_vxcf."_kalendar".$kli_uzid." WHERE dat='$utox' ORDER BY dat ";
$sqldokkal = mysql_query("$sqlttkal");
  if (@$zaznam=mysql_data_seek($sqldokkal,0))
  {
  $riaddokkal=mysql_fetch_object($sqldokkal);
  $utook=1;
  }
$strok=0;
$sqlttkal = "SELECT * FROM F".$kli_vxcf."_kalendar".$kli_uzid." WHERE dat='$strx' ORDER BY dat ";
$sqldokkal = mysql_query("$sqlttkal");
  if (@$zaznam=mysql_data_seek($sqldokkal,0))
  {
  $riaddokkal=mysql_fetch_object($sqldokkal);
  $strok=1;
  }
$stvok=0;
$sqlttkal = "SELECT * FROM F".$kli_vxcf."_kalendar".$kli_uzid." WHERE dat='$stvx' ORDER BY dat ";
$sqldokkal = mysql_query("$sqlttkal");
  if (@$zaznam=mysql_data_seek($sqldokkal,0))
  {
  $riaddokkal=mysql_fetch_object($sqldokkal);
  $stvok=1;
  }
$piaok=0;
$sqlttkal = "SELECT * FROM F".$kli_vxcf."_kalendar".$kli_uzid." WHERE dat='$piax' ORDER BY dat ";
$sqldokkal = mysql_query("$sqlttkal");
  if (@$zaznam=mysql_data_seek($sqldokkal,0))
  {
  $riaddokkal=mysql_fetch_object($sqldokkal);
  $piaok=1;
  }
//echo $sqlttkal;
//echo "dm 506 oc ".$hlavickad->oc." ponok".$ponok." utook".$utook." strok".$strok." stvok".$stvok." piaok".$piaok."<br />";

if( $ponok == 1 AND  $utook == 1 AND  $strok == 1 AND  $stvok == 1 AND  $piaok == 1 )
   {
$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, str, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickad->ume', '$hlavickad->str', '$hlavickad->dok', '506', '$ponx', '$ponx', '$ponx', '$hlavickad->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");

$sqlttxx = "DELETE FROM F$kli_vxcf"."_kalendar$kli_uzid WHERE dat='$ponx' ";
$sqlxx = mysql_query("$sqlttxx");

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, str, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickad->ume', '$hlavickad->str', '$hlavickad->dok', '506', '$utox', '$utox', '$utox', '$hlavickad->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");

$sqlttxx = "DELETE FROM F$kli_vxcf"."_kalendar$kli_uzid WHERE dat='$utox' ";
$sqlxx = mysql_query("$sqlttxx");

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, str, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickad->ume', '$hlavickad->str', '$hlavickad->dok', '506', '$strx', '$strx', '$strx', '$hlavickad->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");

$sqlttxx = "DELETE FROM F$kli_vxcf"."_kalendar$kli_uzid WHERE dat='$strx' ";
$sqlxx = mysql_query("$sqlttxx");

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, str, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickad->ume', '$hlavickad->str', '$hlavickad->dok', '506', '$stvx', '$stvx', '$stvx', '$hlavickad->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");

$sqlttxx = "DELETE FROM F$kli_vxcf"."_kalendar$kli_uzid WHERE dat='$stvx' ";
$sqlxx = mysql_query("$sqlttxx");

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, str, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickad->ume', '$hlavickad->str', '$hlavickad->dok', '506', '$piax', '$piax', '$piax', '$hlavickad->oc', 1, '$uva_hod' ) "; 
$upravene = mysql_query("$uprtxt");

$sqlttxx = "DELETE FROM F$kli_vxcf"."_kalendar$kli_uzid WHERE dat='$piax' ";
$sqlxx = mysql_query("$sqlttxx");

$sqlttxx = "UPDATE F$kli_vxcf"."_mzdprcu$kli_uzid SET dni=dni-5 WHERE cpx=$hlavickad->cpx ";
$sqlxx = mysql_query("$sqlttxx");
$sqlttxx = "DELETE FROM F$kli_vxcf"."_mzdprcv$kli_uzid WHERE dni=0 ";
$sqlxx = mysql_query("$sqlttxx");
   }

}
$id=$id+1;

  }
//koniec tu skusim ak ma 506ku >= 5 zistim pondelky a 1,2 alebo 3ti skusim ci su volne dni ut-pia a dam tam 5dni dovolenky
//exit;

$sqlttkd = "SELECT * FROM F$kli_vxcf"."_kalendar$kli_uzid ";
$sqlkd = mysql_query("$sqlttkd");
$zostatokdni = mysql_num_rows($sqlkd);


//jedna polozka zamestnanca
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcu$kli_uzid WHERE oc = $hlavickak->oc ORDER BY oc,dat,dok ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ( $i <= $pol )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$pocdni=1*$hlavicka->dni;
$pochod=1*$hlavicka->hod;
$id=1;
$hodzaden=$uva_hod;

         while ( $id <= $pocdni )
         {

$kolkohod=$hodzaden;

$zostatokid=$zostatokdni-1;
$idat=rand(0, $zostatokid);
//echo $idat."<br />";
$sqlttkal = "SELECT * FROM F".$kli_vxcf."_kalendar".$kli_uzid." WHERE ume = $ume AND akyden < 6 AND svt = 0 ORDER BY dat ";
$sqldokkal = mysql_query("$sqlttkal");
  if (@$zaznam=mysql_data_seek($sqldokkal,$idat))
  {
  $riaddokkal=mysql_fetch_object($sqldokkal);
  $datx=$riaddokkal->dat;
  }

//echo $zostatokdni."<br />";


$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, str, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavicka->ume', '$hlavicka->str', '$hlavicka->dok', '$hlavicka->dm', '$datx', '$datx', '$datx', '$hlavicka->oc', 1, '$kolkohod' ) "; 
$upravene = mysql_query("$uprtxt");
//echo $uprtxt."<br />";

$sqlttxx = "DELETE FROM F$kli_vxcf"."_kalendar$kli_uzid WHERE dat='$datx' ";
$sqlxx = mysql_query("$sqlttxx");
//echo $sqlttxx."<br />";

$zostatokdni=$zostatokdni-1;


$id=$id+1;
         }

}
$i=$i+1;
  }
//koniec jedna polozka zamestnanca


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ".
" SELECT 1,0,'$ume',0,9,1,dat,dat,dat,dat,dat,'$hlavickak->oc',1,'$kolkohod',0 ".
" FROM F$kli_vxcf"."_kalendar$kli_uzid ".
" WHERE ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");



}
$ik=$ik+1;
  }
//koniec jeden zamestnanec


//vyries dm201 prescas kolko hodin 10 urob 10cyklov a pridaj nahodne k dnu
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcu".$kli_uzid." ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcu".$kli_uzid.
" SELECT 1,0,ume,0,dok,dm,dat,'','','','',oc,dni,hod,0 ".
" FROM F$kli_vxcf"."_mzdzalmes ".
" WHERE ume = $kli_vume AND dp = '0000-00-00' AND dk = '0000-00-00' AND dm = 201 ";
$dsql = mysql_query("$dsqlt");

//exit;

$sqlttd = "SELECT * FROM F$kli_vxcf"."_mzdprcu$kli_uzid WHERE dm = 201 ORDER BY oc,dat,dok ";
$sqld = mysql_query("$sqlttd");
$pold = mysql_num_rows($sqld);

$id=0;
  while ( $id <= $pold )
  {

  if (@$zaznam=mysql_data_seek($sqld,$id))
{
$hlavickad=mysql_fetch_object($sqld);


$pocethod201=1*$hlavickad->hod;

$sqltto = "SELECT * FROM F$kli_vxcf"."_mzdprcv$kli_uzid WHERE dm = 1 AND oc = $hlavickad->oc ORDER BY oc,dat,dok ";
$sqlo = mysql_query("$sqltto");
$polo = mysql_num_rows($sqlo);
$polom1=$polo-1;
if( $polom1 < 0 ) $polom1=0;

$xpon=rand(0, $polom1);
$io=$xpon;
  while ( $pocethod201 > 0 )
  {

  if (@$zaznam=mysql_data_seek($sqlo,$io))
{
$hlavickao=mysql_fetch_object($sqlo);

//pox	cpx	ume	str	dok	dm	dat	        dap1	        dak1	        dap	        dak	      oc	dni	hod	kon
//1	1	10.2013	2	1	506	2013-10-17	0000-00-00	0000-00-00	2013-10-17	2013-10-17	1	1.0	8.00	0
$hodin=1;
if( $pocethod201 < 1 ) { $hodin=$pocethod201; }
if( $pocethod201 < 0 ) { $hodin=0; }

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdprcv$kli_uzid ( pox, ume, str, dok, dm, dat, dap, dak, oc, dni, hod) VALUES ".
" ( 1, '$hlavickao->ume', '$hlavickao->str', '$hlavickao->dok', '201', '$hlavickao->dat', '$hlavickao->dat', '$hlavickao->dat', ".
" '$hlavickad->oc', 0, '$hodin' ) "; 
$upravene = mysql_query("$uprtxt");

$pocethod201=$pocethod201-1;

}
$xpon=rand(0, $polom1);
$io=$xpon;

  }

}
$id=$id+1;

  }
//exit;
//koniec vyries dm201 prescas kolko hodin 10 urob 10cyklov a pridaj nahodne k dnu

//napln do mzddochadzka
//mzddochadzka ume oc dmxa dmxb daod dado dnixa dnixb hodxa hodxb xtxt datm datn cplxb polprc 
//9.2013 3 506 0 2013-09-09 2013-09-09 1.00 0.00 0.00 8.00   2013-09-18 12:26:14 0000-00-00 00:00:00 1 0.00 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddochadzka ".
" SELECT ume,oc,dm,0,dap,dak,dni,0,0,hod,'',now(),'0000-00-00 00:00:00',0,0 ".
" FROM F$kli_vxcf"."_mzdprcv".$kli_uzid." ".
" WHERE ume = $kli_vume  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddochadzka ".
" SELECT ume,oc,dm,0,dap,dak,dni,0,0,hod,'',now(),'0000-00-00 00:00:00',0,0 ".
" FROM F$kli_vxcf"."_mzdprcx".$kli_uzid." ".
" WHERE ume = $kli_vume  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddochadzka SET dmxa=809 WHERE ume = $kli_vume AND dmxa = 812 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddochadzka SET dmxa=520 WHERE ume = $kli_vume AND dmxa >= 500 AND dmxa <= 599 ".
" AND dmxa != 502 AND dmxa != 503 AND dmxa != 506 AND dmxa != 510 AND dmxa != 518 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddochadzka SET dmxa=520 WHERE ume = $kli_vume AND dmxa >= 800 AND dmxa <= 899 ".
" AND dmxa != 801 AND dmxa != 802 AND dmxa != 803 AND dmxa != 804 AND dmxa != 809 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddochadzka SET dmxa=801 WHERE ume = $kli_vume AND ( dmxa = 803 OR dmxa = 804 ) ";
$dsql = mysql_query("$dsqlt");


$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcuoc'.$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdprcv'.$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlttxx = "DROP TABLE F".$kli_vxcf."_mzdkunx".$kli_uzid." ";
$sqlxx = mysql_query("$sqlttxx");
?> 
<script type="text/javascript">
  var okno = window.open("../mzdy/dochadzka.php?copern=1&drupoh=1&page=1&subor=0","_self");
</script>
<?php 


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title> </title>
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
