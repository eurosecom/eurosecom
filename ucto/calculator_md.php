<HTML>
<?php

// celkovy zaciatok dokkurztu
       do
       {
$sys = 'UCT';
$urov = 100;
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

$citfir = include("../cis/citaj_fir.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";

//vymazanie vsetko
if ( $copern == 66 )
    {

$zmazane = mysql_query("DROP TABLE F$kli_vxcf"."_paskovacka$kli_uzid "); 
$copern=5;

    }
//koniec vymazania vsetko


$sql = "SELECT * FROM F".$kli_vxcf."_paskovacka".$kli_uzid;
$vysledok = mysql_query($sql);
if (!$vysledok):

$sqlt = <<<paskovacka
(
   cpl         int not null auto_increment,
   hdn1        DECIMAL(10,2),
   hdn2        DECIMAL(10,2),
   hdn3        DECIMAL(10,2),
   hdn4        DECIMAL(10,2),
   PRIMARY KEY(cpl)
);
paskovacka;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_paskovacka'.$kli_uzid.$sqlt;
$vysledok = mysql_query($sql);
endif;

$sql = "SELECT nasc FROM F".$kli_vxcf."_paskovacka$kli_uzid ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_paskovacka$kli_uzid ADD nasc DECIMAL(10,4) DEFAULT 0 AFTER hdn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_paskovacka$kli_uzid ADD nasv DECIMAL(10,4) DEFAULT 0 AFTER hdn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_paskovacka$kli_uzid ADD delc DECIMAL(10,4) DEFAULT 0 AFTER hdn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_paskovacka$kli_uzid ADD delv DECIMAL(10,4) DEFAULT 0 AFTER hdn4";
$vysledek = mysql_query("$sql");

               }

// 15=ulozenie polozky do databazy nahratej v paskovacka.php
if ( $copern == 15 )
     {
$h_hdn1 = 1*$_REQUEST['h_hdn1'];
$h_hdn2 = strip_tags($_REQUEST['h_hdn2']);
$h_hdn3 = strip_tags($_REQUEST['h_hdn3']);
$h_hdn4 = strip_tags($_REQUEST['h_hdn4']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

$h_hdn2 = SqlDatum($h_hdn2);
if( $h_hdn1 != 0 ) { $ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_paskovacka$kli_uzid ( hdn1 ) VALUES ('$h_hdn1'); "); }
$copern=5;

    }
//koniec ulozenia

//vymazanie polozky
if ( $copern == 6 )
    {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_paskovacka$kli_uzid WHERE cpl='$cislo_cpl'"); 
$copern=5;

    }
//koniec vymazania polozky


$sqlfir = "SELECT SUM(hdn1) AS shdn1 FROM F$kli_vxcf"."_paskovacka$kli_uzid ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$sucet = 1*$fir_riadok->shdn1;

mysql_free_result($fir_vysledok);

$nasc = 1*$_REQUEST['nasc']; $delc = 1*$_REQUEST['delc']; if( $delc == 0 ) { $delc=1; }
$ulozttt = "UPDATE F$kli_vxcf"."_paskovacka$kli_uzid SET nasc=$nasc, delc=$delc, nasv=$sucet*$nasc, delv=$sucet/$delc "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 


$sqlfir = "SELECT * FROM F$kli_vxcf"."_paskovacka$kli_uzid ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$nasc = 1*$fir_riadok->nasc;
$delc = 1*$fir_riadok->delc;

mysql_free_result($fir_vysledok);

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>KalkulaËka</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//posuny enter


function Hdn1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_hdn1.value == '' ) okvstup=0;
    if ( document.formv1.h_hdn1.value == 0 ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_hdn1.value == '' ) { document.formv1.h_hdn1.focus(); document.formv1.h_hdn1.select(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

function NascEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.nasc.value == '' ) okvstup=0;
    if ( document.formv1.nasc.value == 0 ) okvstup=0;

    if ( okvstup == 0 && document.formv1.nasc.value == '' ) { document.formv1.nasc.focus(); document.formv1.nasc.select(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

function DelcEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.delc.value == '' ) okvstup=0;
    if ( document.formv1.delc.value == 0 ) okvstup=0;

    if ( okvstup == 0 && document.formv1.delc.value == '' ) { document.formv1.delc.focus(); document.formv1.delc.select(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<<?php echo $kli_vrok; ?> && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1998.\r"; err=3 }
		if (rok><?php echo $kli_vrok; ?> && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2009.\r"; err=3 }
		if (rok != <?php echo $kli_vrok; ?> && tecka == 2 && text == "")
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2009.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1)
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         errflag.value = "0";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }


<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_hdn1.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//vymazanie
  if ( $copern == 6 OR $copern == 9 OR $copern == 16 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {

    }

<?php
  }
//koniec vymazania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 )
  {
?>
    function VyberVstup()
    {
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_cpl.disabled = true;
    }

    function ObnovUI()
    {

    }

<?php
  }
?>
<?php
//uprava
  if ( $copern == 8 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.h_hdn1.value = '<?php echo "$h_hdn1";?>';

    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 OR $copern == 8 )
  {
?>


    function Zapis_COOK()
    {

    return (true);
    }

    function Obnov_vstup()
    {

    return (true);
    }

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
     else { Oznam.style.display="none"; }
    }

    function VyberVstup()
    {
    document.formv1.h_hdn1.focus();
    document.formv1.h_cpl.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.h_suma.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_hdn1.value == '' ) okvstup=0;
    if ( document.formv1.h_hdn2.value == '' ) okvstup=0;
    if ( document.formv1.h_hdn3.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

<?php
//koniec nova,uprava
  }
?>

<?php
//nova
  if ( $copern == 5 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.nasc.value = '<?php echo "$nasc";?>';
    document.formv1.delc.value = '<?php echo "$delc";?>';
    }

<?php
//koniec nova
  }
?>

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI(); VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  KalkulaËka
</td>
</tr>
</table>
<br />


<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_paskovacka$kli_uzid ORDER BY cpl");
  }


// celkom poloziek
$cpol = mysql_num_rows($sql);

?>

<table class="fmenu" width="260px" >
<tr>
<td class="bmenu" colspan="4" >
<a href="#" onClick="window.open('paskovacka.php?copern=66', '_self' )" >
<img src='../obr/zmazuplne.png' width=15 height=15 border=0 alt="Vymazaù vöetky poloûky" ></a>
</td>
</tr>
<tr>
<td class="bmenu" colspan="4">Pozn·mka:<input type="text" name="h_poznamka" id="h_poznamka" size="15" /></td>
</tr>

<tr>
<td class="bmenu" width="30%" align="right">poloûka</td>
<td class="bmenu" width="30%" align="right">hodnota</td>
<td class="bmenu" width="30%" align="right">suma</td>
<td class="bmenu" width="10%" align="right">zmaû</td>
</tr>

<?php
$i=0;
$suma=0;
$zaklad=0;
$dphcka=0;
$spolu=0;

$dphsadzba=$fir_dph2;
$dphsadzbac=1*(100+$fir_dph2);

   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$datk_sk=SkDatum($riadok->datk);

$nasv = $riadok->nasv;
$delv = $riadok->delv;

$suma = $suma + $riadok->hdn1;
$zaklad = $zaklad + $riadok->hdn1;
$dphcka = $dphcka + $riadok->hdn1;
$spolu = $spolu + $riadok->hdn1;

$Cislo=$suma+"";
$sSuma=sprintf("%0.2f", $Cislo);

$x1_spolu=$spolu;
$x1_dphcka=$spolu/$dphsadzbac;
$x1_dphcka=$x1_dphcka*$dphsadzba;
$x1_zaklad=1*($x1_spolu-$x1_dphcka);

$Cislo=$x1_spolu+"";
$sx1_spolu=sprintf("%0.2f", $Cislo);
$Cislo=$x1_dphcka+"";
$sx1_dphcka=sprintf("%0.2f", $Cislo);
$Cislo=$x1_zaklad+"";
$sx1_zaklad=sprintf("%0.2f", $Cislo);


$x2_dphcka=$spolu;
$x2_zaklad=$x2_dphcka/$dphsadzba;
$x2_zaklad=$x2_zaklad*100;
$x2_spolu=1*($x2_zaklad+$x2_dphcka);

$Cislo=$x2_spolu+"";
$sx2_spolu=sprintf("%0.2f", $Cislo);
$Cislo=$x2_dphcka+"";
$sx2_dphcka=sprintf("%0.2f", $Cislo);
$Cislo=$x2_zaklad+"";
$sx2_zaklad=sprintf("%0.2f", $Cislo);

$x3_zaklad=$spolu;
$x3_dphcka=$x3_zaklad*$dphsadzba;
$x3_dphcka=$x3_dphcka/100;
$x3_spolu=1*($x3_zaklad+$x3_dphcka);

$Cislo=$x3_spolu+"";
$sx3_spolu=sprintf("%0.2f", $Cislo);
$Cislo=$x3_dphcka+"";
$sx3_dphcka=sprintf("%0.2f", $Cislo);
$Cislo=$x3_zaklad+"";
$sx3_zaklad=sprintf("%0.2f", $Cislo);

?>
<tr>
<td class="fmenu" width="30%" align="right"><?php echo $riadok->cpl;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $riadok->hdn1;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $sSuma;?></td>
<td class="fmenu" width="10%" align="right"><a href='paskovacka.php?copern=6&cislo_cpl=<?php echo $riadok->cpl;?>'>
<img src='../obr/zmaz.png' width=15 height=15 border=0 alt="Vymazaù riadok" ></a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,5,6,7,8,9
?>


<?php
//zobraz pre novu polozku
if ( $copern == 5 OR $copern == 8 )
     {
?>
<tr>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Pomer musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter2 musÌ byù ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka mena=<?php echo $h_hdn1;?> spr·vne uloûen·</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù desatinnÈ ËÌslo </span>
<span id="Datk" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="paskovacka.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_cpl=$cislo_cpl"; } ?>
" >

<td class="fmenu"><input type="text" name="h_cpl" id="h_cpl" size="5" /></td>

<td class="fmenu"><input type="text" name="h_hdn1" id="h_hdn1" size="8"  onKeyDown="return Hdn1Enter(event.which)" 
 onchange="return cele(this,0,99999999,Desc,2,document.formv1.err_hdn1)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_hdn1" value="0"></td>

<td class="fmenu"><input type="text" name="h_suma" id="h_suma" size="5" /></td>

<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="2" /></td>

</tr>


<tr><td class="bmenu" colspan="4" align="right"> </td></tr>
<tr><td class="bmenu" colspan="4" align="right"> </td></tr>
<tr>
<td class="bmenu" colspan="3" align="left"><?php echo $sSuma;?> * 
<input type="text" name="nasc" id="nasc" size="8" onKeyDown="return NascEnter(event.which)" />
 = <?php echo $nasv;?></td>
</tr>
<tr>
<td class="bmenu" colspan="3" align="left"><?php echo $sSuma;?> / 
<input type="text" name="delc" id="delc" size="8" onKeyDown="return DelcEnter(event.which)" />
 = <?php echo $delv;?></td>
</tr>

</FORM>

<tr><td class="bmenu" colspan="4" align="right"> </td></tr>
<tr><td class="bmenu" colspan="4" align="right"> </td></tr>
<tr>
<td class="bmenu" width="30%" align="right">Z·klad<?php echo $dphsadzba; ?>%</td>
<td class="bmenu" width="30%" align="right">DPH<?php echo $dphsadzba; ?>%</td>
<td class="bmenu" width="30%" align="right">Spolu<?php echo $dphsadzba; ?>%</td>
</tr>
<tr>
<td class="fmenu" width="30%" align="right"><?php echo $sx1_zaklad;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $sx1_dphcka;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $sx1_spolu;?></td>
</tr>
<tr>
<td class="fmenu" width="30%" align="right"><?php echo $sx2_zaklad;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $sx2_dphcka;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $sx2_spolu;?></td>
</tr>
<tr>
<td class="fmenu" width="30%" align="right"><?php echo $sx3_zaklad;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $sx3_dphcka;?></td>
<td class="fmenu" width="30%" align="right"><?php echo $sx3_spolu;?></td>
</tr>

</table>
<?php
     }
//koniec zobrazenia pre novu polozku
//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka mena=<?php echo $cislo_cpl;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka mena=<?php echo $cislo_cpl;?> upraven·</span>
</tr>

<?php
     }
//koniec nezobraz pre novu,upravu a mazanie
?>


<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokkurztu

       } while (false);
?>
</BODY>
</HTML>
