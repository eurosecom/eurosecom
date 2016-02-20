<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 1000;
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
//copern=1 z bankoveho
$copern = 1*$_REQUEST['copern'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_uce = 1*$_REQUEST['cislo_uce'];
$podvojne=1;
if( $kli_vduj == 9 ) { $podvojne=0; }


$citfir = include("../cis/citaj_fir.php");

//uloz polozku
if( $copern == 1003 )
{
$h_ucex = strip_tags($_REQUEST['h_ucex']);
$h_uced = strip_tags($_REQUEST['h_uced']);
$h_ibanx = strip_tags($_REQUEST['h_ibanx']);
$h_popx = strip_tags($_REQUEST['h_popx']);
$h_vsyx = 1*$_REQUEST['h_vsyx'];
$h_ucey = 1*$_REQUEST['h_ucex'];
$h_ucey1 = 1*$_REQUEST['h_uced'];

$ulozttt = "INSERT INTO F$kli_vxcf"."_uctimportbankyuce ( ibanx, vsyx, ucex, uced, popx ) ".
" VALUES ( '$h_ibanx', '$h_vsyx', '$h_ucex', '$h_uced', '$h_popx' ); ";
if( $h_ucey > 0 OR $h_ucey1 > 0 ) { $vysledok = mysql_query("$ulozttt"); }

$copern=1001;
}
//koniec uloz polozku

$zmazanie=0;
//zmaz polozku
if( $copern == 1006 )
{
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_uctimportbankyuce WHERE porx = $cislo_cpl");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ibanx=$riadico->ibanx;
  $vsyx=$riadico->vsyx;
  $ucex=$riadico->ucex;
  $uced=$riadico->uced;
  $popx=$riadico->popx;
  $zmazanie=1;
  }


$ulozttt = "DELETE FROM F$kli_vxcf"."_uctimportbankyuce WHERE porx = $cislo_cpl";
$vysledok = mysql_query("$ulozttt");

$copern=1001;
}
//koniec zmaz polozku



$sql = "SELECT ucex FROM F$kli_vxcf"."_uctimportbankyuce  ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE F".$kli_vxcf."_uctimportbankyuce ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   porx         int not null auto_increment,
   ibanx        VARCHAR(50) NOT NULL,
   vsyx         DECIMAL(12,0) DEFAULT 0,
   ucex         VARCHAR(50) NOT NULL,
   PRIMARY KEY(porx)
);
statistika_p1304;

$vsql = "CREATE TABLE F".$kli_vxcf."_uctimportbankyuce ".$sqlt;
$vytvor = mysql_query("$vsql");

}

$sql = "SELECT popx FROM F$kli_vxcf"."_uctimportbankyuce  ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "ALTER TABLE F".$kli_vxcf."_uctimportbankyuce ADD uced VARCHAR(50) NOT NULL AFTER ucex ";
$vytvor = mysql_query("$vsql");
$vsql = "ALTER TABLE F".$kli_vxcf."_uctimportbankyuce ADD popx VARCHAR(30) NOT NULL AFTER uced ";
$vytvor = mysql_query("$vsql");

}

$sql = "SELECT pops FROM F$kli_vxcf"."_importbanky".$kli_uzid." ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE F".$kli_vxcf."_importbanky".$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   porc         int not null auto_increment,
   dat          DATE NOT NULL,
   ucm          VARCHAR(20) NOT NULL,
   ucd          VARCHAR(20) NOT NULL,
   ico          DECIMAL(10,0) DEFAULT 0,
   name         VARCHAR(30) NOT NULL,
   pops         VARCHAR(30) NOT NULL,
   suma         DECIMAL(10,2) DEFAULT 0,
   pohyb        VARCHAR(20) NOT NULL,
   iban         VARCHAR(50) NOT NULL,
   info         VARCHAR(50) NOT NULL,
   vsy          DECIMAL(12,0) DEFAULT 0,
   riadok       VARCHAR(250) NOT NULL,
   PRIMARY KEY(porc)
);
statistika_p1304;

$vsql = "CREATE TABLE F".$kli_vxcf."_importbanky".$kli_uzid." ".$sqlt;
$vytvor = mysql_query("$vsql");

}
$vsql = "DELETE FROM F".$kli_vxcf."_importbanky".$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$nazovsuboru="importbanka".$kli_uzid.".xml";
$obsah="";
$i=1;

if ($_REQUEST["odeslano"]==1) 
{     
  if (move_uploaded_file($_FILES['original']['tmp_name'], "../tmp/$nazovsuboru")) 
  { 
//tu bude import

$subor = fopen("../tmp/$nazovsuboru", "r");
$riadok = fread($subor,filesize("../tmp/$nazovsuboru"));
fclose($subor);
 
//echo $riadok."<br />";

$pole = explode("<Ntry>", $riadok);

$i=0;
foreach ($pole as &$value) {

$p1dat = explode("<ValDt><Dt>", $value);
$p2dat = explode("</Dt>", $p1dat[1]);
$dat=$p2dat[0];

$p1suma = explode("<Amt Ccy=\"EUR\">", $value);
$p2suma = explode("</Amt>", $p1suma[1]);
$suma=$p2suma[0];

$p1pohyb = explode("<CdtDbtInd>", $value);
$p2pohyb = explode("</CdtDbtInd>", $p1pohyb[1]);
$pohyb=$p2pohyb[0];

$p1iban = explode("<IBAN>", $value);
$p2iban = explode("</IBAN>", $p1iban[1]);
$iban=$p2iban[0];

$p1name = explode("<Dbtr><Nm>", $value);
$p2name = explode("</Nm>", $p1name[1]);
$name=$p2name[0];

$p1pops = explode("<RmtInf><Ustrd>", $value);
$p2pops = explode("</Ustrd", $p1pops[1]);
$pops=$p2pops[0];

$p1info = explode("<EndToEndId>", $value);
$p2info = explode("</EndToEndId>", $p1info[1]);
$info=$p2info[0];

$p1vsy = explode("/VS", $info);
$p2vsy = explode("/SS", $p1vsy[1]);
$vsy=$p2vsy[0];

$text=$value."\r\n";
if( $i > 0 ) 
    {

$vsql = "INSERT INTO F".$kli_vxcf."_importbanky$kli_uzid ( riadok, dat, suma, pohyb, iban, name, pops, info, vsy ) VALUES ".
" ( '$text', '$dat', '$suma', '$pohyb', '$iban', '$name', '$pops', '$info', '$vsy' ) ";
$vytvor = mysql_query("$vsql");

    }
//if i > 0

$i=$i+1;
}

fclose($soubox);




          $vyslettt = "SELECT * FROM F$kli_vxcf"."_importbanky$kli_uzid WHERE porc > 0 ORDER BY porc ";
          $vysledok = mysql_query("$vyslettt");
          while ($riadok = mysql_fetch_object($vysledok))
          {
          //zaciatok cyklu


//hladanie ico

$ico=0;
$nasielico=0;
$nasieluce=0;
$xvsy=1*$riadok->vsy;
$tabulka="odb";
if( $riadok->pohyb == 'DBIT' ) { $tabulka="dod"; }

$ucproti=26100;
$ucprotidebet=26100; 
$sqlico = mysql_query("SELECT uce,ico,hod,dn1,dn2 FROM F$kli_vxcf"."_fak".$tabulka." WHERE fak = $xvsy ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ucproti=$riadico->uce;
  $ucprotidebet=$riadico->uce;
  $ico=$riadico->ico;
  $hdp=$riadico->dn1+$riadico->dn2;
  $nasielico=1;
  $nasieluce=1;
  }
if( $nasielico == 0 ) 
{
$sqlico = mysql_query("SELECT uce,ico,hod,dn1,dn2 FROM F$kli_vxcf"."_fak".$tabulka."poc WHERE fak = $xvsy ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $ucproti=$riadico->uce;
  $ucprotidebet=$riadico->uce;
  $ico=$riadico->ico;
  $hdp=$riadico->dn1+$riadico->dn2;
  $nasielico=1;
  $nasieluce=1;
  }
}



if( $nasielico == 0 AND $riadok->iban != '' ) 
{
$sqlfir1 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ib1 LIKE '%".$riadok->iban."%' ";
$fir_vysledok1 = mysql_query($sqlfir1);
$polico1 = 1*mysql_num_rows($fir_vysledok1);
if( $polico1 > 0 ) 
{
$fir_riadok1=mysql_fetch_object($fir_vysledok1);

$ico = $fir_riadok1->ico;
$nasielico=1;
}
  }


if( $nasielico == 0 AND $riadok->iban != '' ) 
  {
$sqlfir2 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ib2 LIKE '%".$riadok->iban."%' ";
$fir_vysledok2 = mysql_query($sqlfir2);
$polico2 = 1*mysql_num_rows($fir_vysledok2);
if( $polico2 > 0 ) 
{
$fir_riadok2=mysql_fetch_object($fir_vysledok2);

$ico = $fir_riadok2->ico;
$nasielico=1;
}
  }

if( $nasielico == 0 AND $riadok->iban != '' ) 
  {
$sqlfir3 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ib3 LIKE '%".$riadok->iban."%' ";
$fir_vysledok3 = mysql_query($sqlfir3);
$polico3 = 1*mysql_num_rows($fir_vysledok3);
if( $polico3 > 0 ) 
{
$fir_riadok3=mysql_fetch_object($fir_vysledok3);

$ico = $fir_riadok3->ico;
$nasielico=1;
}
  }

//koniec hladanie ico

//hladanie uce

if( $nasieluce == 0 AND $riadok->iban != '' ) 
  {
$sqlfir4 = "SELECT * FROM F$kli_vxcf"."_uctimportbankyuce WHERE ibanx LIKE '%".$riadok->iban."%' AND vsyx = $riadok->vsy ";
//echo $sqlfir4;
$fir_vysledok4 = mysql_query($sqlfir4);
$polico4 = 1*mysql_num_rows($fir_vysledok4);
if( $polico4 > 0 ) 
{
$fir_riadok4=mysql_fetch_object($fir_vysledok4);

$ucproti = $fir_riadok4->ucex;
$ucprotidebet = $fir_riadok4->uced;
$nasieluce=1;
}
  }

if( $nasieluce == 0 AND $riadok->iban != '' ) 
  {
$sqlfir5 = "SELECT * FROM F$kli_vxcf"."_uctimportbankyuce WHERE ibanx LIKE '%".$riadok->iban."%' ";
//echo $sqlfir5;
$fir_vysledok5 = mysql_query($sqlfir5);
$polico5 = 1*mysql_num_rows($fir_vysledok5);
if( $polico5 > 0 ) 
{
$fir_riadok5=mysql_fetch_object($fir_vysledok5);

$ucproti = $fir_riadok5->ucex;
$ucprotidebet = $fir_riadok5->uced;
$nasieluce=1;
}
  }

//koniec hladanie uce

$ucproti=trim($ucproti);
$ucprotidebet=trim($ucprotidebet);
if( $ucproti == '' ) { $ucproti="26100"; } 
if( $ucprotidebet == '' ) { $ucprotidebet="26100"; } 

//dok	ddu	poh	cpl	ucm	ucd	rdp	dph	hod	hodm	kurz	mena	zmen	ico	fak	pop	str	zak	unk	id	datm
$sqty = "UPDATE F$kli_vxcf"."_importbanky$kli_uzid SET ".
" ucm='$cislo_uce', ucd='$ucproti', ico='$ico' WHERE pohyb = 'CRDT' AND porc = $riadok->porc ";
//echo $sqty; 
$ulozene = mysql_query("$sqty"); 

$sqty = "UPDATE F$kli_vxcf"."_importbanky$kli_uzid SET ".
" ucd='$cislo_uce', ucm='$ucprotidebet', ico='$ico' WHERE pohyb = 'DBIT' AND porc = $riadok->porc ";
//echo $sqty; 
$ulozene = mysql_query("$sqty");

 
if( $nasielico == 0 AND $nasieluce == 0 )
{
$x_txx=$riadok->iban." ".$riadok->name." ".$riadok->pops;

$sqty = "INSERT INTO F$kli_vxcf"."_uctban ( dok,ddu,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_dok', '$riadok->dat', '551', '0', '0', '0', '0', '0', '0', '0', '$x_txx',".
" '0', '0', '', '$kli_uzid' );"; 
$ulozene = mysql_query("$sqty"); 
}


if( $podvojne == 1 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctban SELECT ".
" '$cislo_dok',dat,'551',0,ucm,ucd,'1','0',suma,0,0,'',0,ico,vsy,'',0,0,'','$kli_uzid',now() ".
" FROM F".$kli_vxcf."_importbanky$kli_uzid ".
" WHERE ( pohyb = 'CRDT' OR pohyb = 'DBIT' ) AND porc = $riadok->porc ";
//echo $sqty; 
$ulozene = mysql_query("$sqty"); 
}


          }
          //koniec cyklu




//exit;
//koniec importu
  }

}
//koniec if odeslano


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Import IBAN xml</title>

<script type="text/javascript">

    function ObnovUI()
    {
<?php if( $zmazanie == 1 ) { ?>
    document.formv1.h_ibanx.value = '<?php echo "$ibanx";?>';
    document.formv1.h_vsyx.value = '<?php echo "$vsyx";?>';
    document.formv1.h_ucex.value = '<?php echo "$ucex";?>';
    document.formv1.h_uced.value = '<?php echo "$uced";?>';
    document.formv1.h_popx.value = '<?php echo "$popx";?>';
    document.formv1.h_ibanx.focus();
    document.formv1.h_ibanx.select();
<?php                      } ?>
    }


</script>
</HEAD>
<BODY class="white" onload="ObnovUI();" >


<?php
if ($_REQUEST["odeslano"]!=1) 
{ 
?> 

<?php if( $copern == 1 ) { ?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom - Import XML bankovÈho v˝pisu
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok; ?>&cislo_uce=<?php echo $cislo_uce; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr>
        <td  width="10%" align="left" >
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $cislo_uce; ?>&rozuct=ANO&copern=8&drupoh=4&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_ico=&h_uce=<?php echo $cislo_uce; ?>&h_unk=', '_self' )">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Sp‰ù do ˙Ëtovania bankovÈho v˝pisu" ></a></td> 
        <td  width="10%" align="right" >Vyberte s˙bor:</td> 
        <td  width="60%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE="700000" > 
        <input type="file" name="original" size="60"> 
        </td> 
        <td  width="10%" align="left" >(max. 700 kB)</td> 
        <td  width="10%" align="right" >
<a href="#" onClick="window.open('vspk_importxml.php?copern=1001&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>
&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/next.png' width=15 height=15 border=0 title="Nastavenie proti˙Ëtu banky 221 pre IBAN a variabiln˝ symbol" ></a>
</td> 
      </tr> 
      <tr> 
        <td colspan="3"> 
              <input type="hidden" name="odeslano" value="1"> 
          <p align="center"><input type="submit" value="NaËÌtaù"></td> 
      </tr> 
    </table> 
    </form> 
<?php 
                         }
//koniec copern == 1
?>
<?php if( $copern == 1001 ) { ?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom - Nastavenie proti˙Ëtu banky 221 pre IBAN a variabiln˝ symbol
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
    <form method="POST" name="formv1" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?copern=1003&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok; ?>&cislo_uce=<?php echo $cislo_uce; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="10%" align="left" >
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $cislo_uce; ?>&rozuct=ANO&copern=8&drupoh=4&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_ico=&h_uce=<?php echo $cislo_uce; ?>&h_unk=', '_self' )">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Sp‰ù do ˙Ëtovania bankovÈho v˝pisu" ></a></td>

        <td  width="20%" align="left" >IBAN</td>
        <td  width="10%" align="left" >VSY</td>
        <td  width="10%" align="left" >˙Ëet Kredit</td>
        <td  width="10%" align="left" >˙Ëet Debet</td>
        <td  width="20%" align="left" >popis</td>
        <td  width="5%" align="left" >Zmazaù</td>


        <td  width="5%" align="right" > </td> 
        <td  width="10%" align="right" >
<a href="#" onClick="window.open('vspk_importxml.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>
&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/prev.png' width=15 height=15 border=0 title="Sp‰ù do naËÌtania bankovÈho v˝pisu XML" ></a>
</td> 

      </tr> 


<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctimportbankyuce  WHERE porx > 0 ORDER BY porx ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
?>
        <tr>
        <td  colspan="1" align="left" > </td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->ibanx; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->vsyx; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->ucex; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->uced; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->popx; ?></td>
        <td  colspan="1" align="left" ><a href="#" onClick="window.open('vspk_importxml.php?copern=1006&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>
&cislo_uce=<?php echo $cislo_uce;?>&cislo_cpl=<?php echo $hlavicka->porx; ?>', '_self' )">
<img src='../obr/zmaz.png' width=15 height=15 border=0 title="Zmazaù poloûku" ></a>
</td>
        </tr>

<?php
}
$i=$i+1;
  }
?>
        <tr>
        <td  colspan="1" align="left" > </td>
        <td  colspan="1" align="left" ><input type="text" name="h_ibanx" id="h_ibanx" size="35"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_vsyx" id="h_vsyx" size="12"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_ucex" id="h_ucex" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_uced" id="h_uced" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_popx" id="h_popx" size="35"/></td>
        </tr>
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" ></td>
</tr>
    </table> 
    </form> 
<?php 
                            }
//koniec copern == 1001
} 
//koniec if neodeslano
?>

<?php
//prepni spat

//vspk_u.php?sysx=UCT&hladaj_uce=22100&rozuct=ANO&copern=8&drupoh=4&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT
//&cislo_dok=30004&h_ico=36084233&h_uce=22100&h_unk=
if( $copern == 1 AND $_REQUEST["odeslano"] == 1 )
{
?>
<script type="text/javascript">

window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $cislo_uce; ?>&rozuct=ANO&copern=8&drupoh=4&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_ico=&h_uce=<?php echo $cislo_uce; ?>&h_unk=', '_self' )

</script>
<?php
}
?>


<?php
exit;

//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
