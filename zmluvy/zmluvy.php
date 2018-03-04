<?PHP
//tymto sa spusta ponuka 

session_start(); 
    $_SESSION['kli_vhsxy'] = 13287465;

$copern = $_REQUEST['copern'];

?>
<HTML>
<?php

       do
       {
if ( $copern !== 99 )
{

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

}


// cislo operacie
$copern = $_REQUEST['copern'];
$prihl=1;
$kli_vxcf=63;
$kli_vxcf2=0;
$kli_vxcf3=0;
$kli_vxcf4=0;
$kli_vxcf5=0;
if( $_SERVER['SERVER_NAME'] == 'www.dssbrodske.sk' ) {$kli_vxcf=531; $kli_vxcf2=0; $kli_vxcf3=0; $kli_vxcf4=0; $kli_vxcf5=0; $kli_vxcf6=0;}
if( $_SERVER['SERVER_NAME'] == 'www.zszzsmrdaky.sk' ) {$kli_vxcf=8; $kli_vxcf2=7; $kli_vxcf3=6; $kli_vxcf4=5; $kli_vxcf5=4; $kli_vxcf6=3; $kli_vxcf7=2; $kli_vxcf8=1; }
if( $_SERVER['SERVER_NAME'] == 'www.szsgbely.sk' ) {$kli_vxcf=7; $kli_vxcf2=6; $kli_vxcf3=5; $kli_vxcf4=4; $kli_vxcf5=3; $kli_vxcf6=2; $kli_vxcf7=1;}

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$eurosecomvirtualnyserver=0;
if( file_exists("../pswd/eurosecomvirtualnyserver.ano")) { $eurosecomvirtualnyserver=1; }
if( $eurosecomvirtualnyserver == 1 ) { mysql_query("SET CHARACTER SET cp1250"); }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<style type="text/css">


  </style>
<title>Zverejnené zmluvy</title>

<script type="text/javascript">

    function ObnovUI()
    {


    }

    function PozriZmluvu(cislo, firma)
    {
window.open('../dokumenty/FIR' + firma + '/fakdodav/dd' + cislo + '.pdf', '_blank', 'width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )
    }

    function PozriFakturu(cislo, firma)
    {
window.open('../dokumenty/FIR' + firma + '/fakdodav/d' + cislo + '.pdf', '_blank', 'width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )
    }

</script>
</HEAD>
<BODY class="white" onload="ObnovUI();" >




<table class="h2" width="100%" >
<tr>

<td>Zverejnené zmluvy, objednávky a faktúry v súlade so zákonom è.546/2010 Zbierky zákonov

</td>
<td align="right"></td>
</tr>
</table>

<br />



<?php
if( $prihl == 1 )
{


$sqltt = "SELECT * FROM F$kli_vxcf"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i) OR $i == 0 )
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);
if( $datumsk == '00.00.0000') { $datumsk="";  }
?>

<?php if( $i == 0 ) { ?>
<table class="fmenu" width="100%" >

<tr>
<td class="bmenu" width="10%" align="left">Dátum zverejnenia
<td class="hmenu" width="50%" align="left">Popis dokumentu
<td class="hmenu" width="20%" align="left">Prezeranie a vyh¾adávanie v zmluve
<td class="hmenu" width="20%" align="left">Prezeranie a vyh¾adávanie vo faktúre
</tr>
<?php               } ?>


<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


if( $kli_vxcf2 > 0 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf2"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);

?>

<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf2/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf2/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf2;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf2;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


          }
//koniec tabulka2
?>
<?php
//tabulka3
if( $kli_vxcf3 > 0 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf3"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);

?>

<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf3/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf3/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf3;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf3;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


          }
//koniec tabulka3
?>
<?php
//tabulka4
if( $kli_vxcf4 > 0 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf4"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);

?>

<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf4/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf4/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf4;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf4;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


          }
//koniec tabulka4
?>

<?php
//tabulka5
if( $kli_vxcf5 > 0 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf5"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);

?>

<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf5/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf5/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf5;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf5;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


          }
//koniec tabulka5
?>

<?php
//tabulka6
if( $kli_vxcf6 > 0 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf6"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);

?>

<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf6/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf6/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf6;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf6;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


          }
//koniec tabulka6
?>

<?php
//tabulka7
if( $kli_vxcf7 > 0 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf7"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);

?>

<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf7/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf7/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf7;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf7;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


          }
//koniec tabulka7
?>

<?php
//tabulka8
if( $kli_vxcf8 > 0 )
          {

$sqltt = "SELECT * FROM F$kli_vxcf8"."_fakdod ".
" WHERE dok > 0  ".
" ORDER BY dat DESC ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datumsk=SkDatum($riadok->dat);

?>

<tr>
<td class="fmenu" align="left" ><?php echo $datumsk;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->txp;?></td>
<td class="fmenu" align="left" >
<?php
$subor1=0;
$subor2=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf8/fakdodav/dd$riadok->dok.pdf")) { $subor1=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf8/fakdodav/d$riadok->dok.pdf")) { $subor2=1; }
?>
<?php if( $subor1 == 1 ) { ?>
Zmluva <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie v zmluve' onClick='PozriZmluvu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf8;?>);' >
<?php                    } ?>
<td class="fmenu" align="left" >
<?php if( $subor2 == 1 ) { ?>
Faktúra <img src='../obr/pdf.png' width=15 height=15 border=0 title='Prezeranie a vyh¾adávanie vo faktúre' onClick='PozriFakturu(<?php echo $riadok->dok;?>, <?php echo $kli_vxcf8;?>);' >
<?php                    } ?>
</td>

</tr>

<?php
  }
$i = $i + 1;
   }


          }
//koniec tabulka8
?>

</table>

<?php
//koniec ak prihlasenie = 1 daj tabulku
}
?>


<?php
$_SESSION['kli_vhsxy'] = 13289997465;

// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
