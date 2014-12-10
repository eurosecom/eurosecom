<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
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
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");


//nacitanie standartnej uctovej osnovy
    if ( $copern == 155 AND $fir_allx11 > 0 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naèíta úètovanie z firmy è.<?php echo $fir_allx11; ?> ?") )
         { window.close()  }
else
         { location.href='uctovanie.php?copern=156&page=1'  }
</script>
<?php
    }

    if ( $copern == 156 )
    {
$copern=1;

$dsqlt = "DROP TABLE F$kli_vxcf"."_mzducty ";
$dsql = mysql_query("$dsqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_mzducty SELECT * FROM ".$databaza."F".$fir_allx11."_mzducty ";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzducty SET cfuct=0 ";
$dsql = mysql_query("$dsqlt");

//koniec nacitania standartnej uctovej osnovy
    }

$sql = "SELECT ucm_dovo FROM F$kli_vxcf"."_mzducty";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucm_ddpf VARCHAR(10) DEFAULT '52490' AFTER puc_kon";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucd_ddpf VARCHAR(10) DEFAULT '33690' AFTER ucm_ddpf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucm_dovm VARCHAR(10) DEFAULT '0' AFTER ucm_ddpf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucm_dovo VARCHAR(10) DEFAULT '0' AFTER ucm_ddpf";
$vysledek = mysql_query("$sql");
}


// zapis upravene sadzby
if ( $copern == 3 )
    {

$ucty = strip_tags($_REQUEST['ucty']);
$ucf_zp = strip_tags($_REQUEST['ucf_zp']);
$ucf_np = strip_tags($_REQUEST['ucf_np']);
$ucf_sp = strip_tags($_REQUEST['ucf_sp']);
$ucf_ip = strip_tags($_REQUEST['ucf_ip']);
$ucf_pn = strip_tags($_REQUEST['ucf_pn']);
$ucf_up = strip_tags($_REQUEST['ucf_up']);
$ucf_gf = strip_tags($_REQUEST['ucf_gf']);
$ucf_rf = strip_tags($_REQUEST['ucf_rf']);
$ucp_zp = strip_tags($_REQUEST['ucp_zp']);
$ucp_np = strip_tags($_REQUEST['ucp_np']);
$ucp_sp = strip_tags($_REQUEST['ucp_sp']);
$ucp_ip = strip_tags($_REQUEST['ucp_ip']);
$ucp_pn = strip_tags($_REQUEST['ucp_pn']);
$ucp_up = strip_tags($_REQUEST['ucp_up']);
$ucp_gf = strip_tags($_REQUEST['ucp_gf']);
$ucp_rf = strip_tags($_REQUEST['ucp_rf']);
$ucz_zp = strip_tags($_REQUEST['ucz_zp']);
$ucz_zpn = strip_tags($_REQUEST['ucz_zpn']);
$ucz_np = strip_tags($_REQUEST['ucz_np']);
$ucz_sp = strip_tags($_REQUEST['ucz_sp']);
$ucz_ip = strip_tags($_REQUEST['ucz_ip']);
$ucz_pn = strip_tags($_REQUEST['ucz_pn']);
$ucz_up = strip_tags($_REQUEST['ucz_up']);
$ucz_gf = strip_tags($_REQUEST['ucz_gf']);
$ucz_rf = strip_tags($_REQUEST['ucz_rf']);

$ucm_soc = strip_tags($_REQUEST['ucm_soc']);
$ucd_soc = strip_tags($_REQUEST['ucd_soc']);
$puc_zam = strip_tags($_REQUEST['puc_zam']);
$puc_kon = strip_tags($_REQUEST['puc_kon']);
$cfuct = strip_tags($_REQUEST['cfuct']);
$ucm_ddpf = strip_tags($_REQUEST['ucm_ddpf']);
$ucd_ddpf = strip_tags($_REQUEST['ucd_ddpf']);
$ucm_dovm = strip_tags($_REQUEST['ucm_dovm']);
$ucm_dovo = strip_tags($_REQUEST['ucm_dovo']);

$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_mzducty SET ".
" ucf_zp='$ucf_zp', ucf_np='$ucf_np', ucf_sp='$ucf_sp', ucf_ip='$ucf_ip', ucf_pn='$ucf_pn', ".
" ucf_up='$ucf_up', ucf_gf='$ucf_gf', ucf_rf='$ucf_rf',".
" ucp_zp='$ucp_zp', ucp_np='$ucp_np', ucp_sp='$ucp_sp', ucp_ip='$ucp_ip', ucp_pn='$ucp_pn', ".
" ucp_up='$ucp_up', ucp_gf='$ucp_gf', ucp_rf='$ucp_rf',".
" ucz_zp='$ucz_zp', ucz_np='$ucz_np', ucz_sp='$ucz_sp', ucz_ip='$ucz_ip', ucz_pn='$ucz_pn', ".
" ucz_up='$ucz_up', ucz_gf='$ucz_gf', ucz_rf='$ucz_rf', ucm_dovm='$ucm_dovm', ucm_dovo='$ucm_dovo',".
" ucm_soc='$ucm_soc', ucd_soc='$ucd_soc', puc_zam='$puc_zam', puc_kon='$puc_kon', ucm_ddpf='$ucm_ddpf', ucd_ddpf='$ucd_ddpf',  cfuct='$cfuct' ".
" WHERE ucty = 1"; 
//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych sadzieb




//nacitaj udaje
if ( $copern > 1 )
    {

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzducty WHERE ucty = 1";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$datum = $fir_riadok->datum;
$ucf_zp = $fir_riadok->ucf_zp;
$ucf_np = $fir_riadok->ucf_np;
$ucf_sp = $fir_riadok->ucf_sp;
$ucf_ip = $fir_riadok->ucf_ip;
$ucf_pn = $fir_riadok->ucf_pn;
$ucf_up = $fir_riadok->ucf_up;
$ucf_gf = $fir_riadok->ucf_gf;
$ucf_rf = $fir_riadok->ucf_rf;
$ucp_zp = $fir_riadok->ucp_zp;
$ucp_np = $fir_riadok->ucp_np;
$ucp_sp = $fir_riadok->ucp_sp;
$ucp_ip = $fir_riadok->ucp_ip;
$ucp_pn = $fir_riadok->ucp_pn;
$ucp_up = $fir_riadok->ucp_up;
$ucp_gf = $fir_riadok->ucp_gf;
$ucp_rf = $fir_riadok->ucp_rf;
$ucz_zp = $fir_riadok->ucz_zp;
$ucz_np = $fir_riadok->ucz_np;
$ucz_sp = $fir_riadok->ucz_sp;
$ucz_ip = $fir_riadok->ucz_ip;
$ucz_pn = $fir_riadok->ucz_pn;
$ucz_up = $fir_riadok->ucz_up;
$ucz_gf = $fir_riadok->ucz_gf;
$ucz_rf = $fir_riadok->ucz_rf;

$ucm_dovm = $fir_riadok->ucm_dovm;
$ucm_dovo = $fir_riadok->ucm_dovo;
$ucm_soc = $fir_riadok->ucm_soc;
$ucd_soc = $fir_riadok->ucd_soc;
$puc_zam = $fir_riadok->puc_zam;
$puc_kon = $fir_riadok->puc_kon;
$cfuct = $fir_riadok->cfuct;
$ucm_ddpf = $fir_riadok->ucm_ddpf;
$ucd_ddpf = $fir_riadok->ucd_ddpf;

mysql_free_result($fir_vysledok);

    }
//koniec nacitania




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uctovanie Mzdy</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
<?php
//uprava sadzby
  if ( $copern == 2 )
  { 
?>
    function ObnovUI()
    {

    document.formv1.ucf_zp.value = '<?php echo "$ucf_zp";?>';
    document.formv1.ucf_np.value = '<?php echo "$ucf_np";?>';
    document.formv1.ucf_sp.value = '<?php echo "$ucf_sp";?>';
    document.formv1.ucf_ip.value = '<?php echo "$ucf_ip";?>';
    document.formv1.ucf_pn.value = '<?php echo "$ucf_pn";?>';
    document.formv1.ucf_up.value = '<?php echo "$ucf_up";?>';
    document.formv1.ucf_gf.value = '<?php echo "$ucf_gf";?>';
    document.formv1.ucf_rf.value = '<?php echo "$ucf_rf";?>';

    document.formv1.ucp_zp.value = '<?php echo "$ucp_zp";?>';
    document.formv1.ucp_np.value = '<?php echo "$ucp_np";?>';
    document.formv1.ucp_sp.value = '<?php echo "$ucp_sp";?>';
    document.formv1.ucp_ip.value = '<?php echo "$ucp_ip";?>';
    document.formv1.ucp_pn.value = '<?php echo "$ucp_pn";?>';
    document.formv1.ucp_up.value = '<?php echo "$ucp_up";?>';
    document.formv1.ucp_gf.value = '<?php echo "$ucp_gf";?>';
    document.formv1.ucp_rf.value = '<?php echo "$ucp_rf";?>';

    document.formv1.ucz_zp.value = '<?php echo "$ucz_zp";?>';
    document.formv1.ucz_np.value = '<?php echo "$ucz_np";?>';
    document.formv1.ucz_sp.value = '<?php echo "$ucz_sp";?>';
    document.formv1.ucz_ip.value = '<?php echo "$ucz_ip";?>';
    document.formv1.ucz_pn.value = '<?php echo "$ucz_pn";?>';
    document.formv1.ucz_up.value = '<?php echo "$ucz_up";?>';
    document.formv1.ucz_gf.value = '<?php echo "$ucz_gf";?>';
    document.formv1.ucz_rf.value = '<?php echo "$ucz_rf";?>';

    document.formv1.ucm_dovm.value = '<?php echo "$ucm_dovm";?>';
    document.formv1.ucm_dovo.value = '<?php echo "$ucm_dovo";?>';
    document.formv1.ucm_soc.value = '<?php echo "$ucm_soc";?>';
    document.formv1.ucd_soc.value = '<?php echo "$ucd_soc";?>';
    document.formv1.puc_zam.value = '<?php echo "$puc_zam";?>';
    document.formv1.puc_kon.value = '<?php echo "$puc_kon";?>';
    document.formv1.cfuct.value = '<?php echo "$cfuct";?>';
    document.formv1.ucm_ddpf.value = '<?php echo "$ucm_ddpf";?>';
    document.formv1.ucd_ddpf.value = '<?php echo "$ucd_ddpf";?>';
    }
<?php
//koniec uprava
  }
?>



<?php
//nie uprava
  if ( $copern != 2 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
//koniec uprava
  }
?>

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
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt väèší ako 2029.\r"; err=3 }
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
		



		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
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


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des) 
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
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }



</script>



</HEAD>
<BODY class="white" onload="ObnovUI();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 ) echo " Úètovanie miezd";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zobraz nastavene sadzby
if ( $copern == 1 OR $copern == 3 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_mzducty WHERE ucty = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>

<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musí by celé kladné èíslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Dátum musí by v tvare DD.MM.RRRR,DD.MM alebo DD napríklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 2 desatinné miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 4 desatinné miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 1 desatinné miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OSÈ musí by celé kladné èíslo v rozsahu 1 a 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Musíte vyplni všetky poloky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloka OSÈ=<?php echo $h_oc;?> správne uloená</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="uctovanie.php?copern=2" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%">
<a href='uctovanie.php?copern=155&page=1'>
<?php if( $fir_allx11 > 0 ) { ?>
<img src='../obr/orig.png' width=20 height=15 border=0 alt="Naèíta úètovanie z firmy minulého roka è. <?php echo $fir_allx11; ?> "></a>
<?php                       } ?>
</td>
</tr>

<tr>
<td class="bmenu" colspan="2">Fond</td>
<td class="bmenu" colspan="2">UCD Zamestnanec</td>
<td class="bmenu" colspan="2">UCM Zamestnávate¾</td>
<td class="bmenu" colspan="2">UCD Zamestnávate¾</td>
</tr>

<tr>
<td class="bmenu" colspan="2">ZP Zdravotné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_zp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_zp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_zp";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">NP Nemocenské poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_np";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_np";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_np";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">DP Starobné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_sp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_sp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_sp";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">DP Invalidné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_ip";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_ip";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_ip";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">PvN Poistenie v nezamestnanosti</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_pn";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_pn";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_pn";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">UP Úrazové poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_up";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_up";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_up";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">GF Garanèné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_gf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_gf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_gf";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">RF Poistenie do rezervného fondu</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucz_rf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucf_rf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucp_rf";?></td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr>
<td class="bmenu" colspan="2">UCM Sociálny fond</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucm_soc";?></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCD Sociálny fond</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucd_soc";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">UCM DDP zamestnávate¾</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucm_ddpf";?></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCD DDP zamestnávate¾</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucd_ddpf";?></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCM Odúètovanie dovolenka min.rok</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucm_dovm";?></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCM Odúètovanie dovolenka min.rok odvody</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->ucm_dovo";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Protiúèet konate¾,majite¾</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->puc_kon";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Protiúèet zamestnanec</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->puc_zam";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Èíslo firmy Úètovníctvo/Mzdy</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->cfuct";?><td class="bmenu" colspan="2">0=rovnaké ako Úètovníctvo/Mzdy</td>
</tr>

<tr></tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia  sadzieb
?>



<?php
//upravy  sadzby
if ( $copern == 2 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musí by celé kladné èíslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Dátum musí by v tvare DD.MM.RRRR,DD.MM alebo DD napríklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 2 desatinné miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 4 desatinné miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 1 desatinné miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OSÈ musí by celé kladné èíslo v rozsahu 1 a 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Musíte vyplni všetky poloky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloka OSÈ=<?php echo $h_oc;?> správne uloená</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="uctovanie.php?copern=3" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Fond</td>
<td class="bmenu" colspan="2">UCD Zamestnanec</td>
<td class="bmenu" colspan="2">UCM Zamestnávate¾</td>
<td class="bmenu" colspan="2">UCD Zamestnávate¾</td>
</tr>
<tr>
<td class="bmenu" colspan="2">ZP Zdravotné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_zp" id="ucz_zp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_zp" id="ucf_zp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_zp" id="ucp_zp" /></td>
</tr>

<td class="bmenu" colspan="2">NP Nemocenské poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_np" id="ucz_np" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_np" id="ucf_np" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_np" id="ucp_np" /></td>
</tr>

<td class="bmenu" colspan="2">DP Starobné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_sp" id="ucz_sp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_sp" id="ucf_sp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_sp" id="ucp_sp" /></td>
</tr>

<td class="bmenu" colspan="2">DP Invalidné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_ip" id="ucz_ip" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_ip" id="ucf_ip" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_ip" id="ucp_ip" /></td>
</tr>

<td class="bmenu" colspan="2">PvN Poistenie v nezamestnanosti</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_pn" id="ucz_pn" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_pn" id="ucf_pn" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_pn" id="ucp_pn" /></td>
</tr>

<td class="bmenu" colspan="2">UP Úrazové poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_up" id="ucz_up" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_up" id="ucf_up" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_up" id="ucp_up" /></td>
</tr>

<td class="bmenu" colspan="2">GF Garanèné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_gf" id="ucz_gf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_gf" id="ucf_gf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_gf" id="ucp_gf" /></td>
</tr>

<td class="bmenu" colspan="2">RF Poistenie do rezervného fondu</td>
<td class="fmenu" colspan="2"><input type="text" name="ucz_rf" id="ucz_rf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucf_rf" id="ucf_rf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="ucp_rf" id="ucp_rf" /></td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr>
<td class="bmenu" colspan="2">UCM Sociálny fond</td>
<td class="fmenu" colspan="2"><input type="text" name="ucm_soc" id="ucm_soc" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCD Sociálny fond</td>
<td class="fmenu" colspan="2"><input type="text" name="ucd_soc" id="ucd_soc" /></td>
</tr>

<tr>
<td class="bmenu" colspan="2">UCM DDP zamestnávate¾</td>
<td class="fmenu" colspan="2"><input type="text" name="ucm_ddpf" id="ucm_ddpf" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCD DDP zamestnávate¾</td>
<td class="fmenu" colspan="2"><input type="text" name="ucd_ddpf" id="ucd_ddpf" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCM Odúètovanie dovolenka min.rok</td>
<td class="fmenu" colspan="2"><input type="text" name="ucm_dovm" id="ucm_dovm" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2">UCM Odúètovanie dovolenka min.rok odvody</td>
<td class="fmenu" colspan="2"><input type="text" name="ucm_dovo" id="ucm_dovo" /></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Protiúèet konate¾,majite¾</td>
<td class="fmenu" colspan="2"><input type="text" name="puc_kon" id="puc_kon" /></td>
</tr>


<tr>
<td class="bmenu" colspan="2">Protiúèet zamestnanec</td>
<td class="fmenu" colspan="2"><input type="text" name="puc_zam" id="puc_zam" /></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Èíslo firmy Úètovníctvo/Mzdy</td>
<td class="fmenu" colspan="2"><input type="text" name="cfuct" id="cfuct" /><td class="bmenu" colspan="2">0=rovnaké ako Úètovníctvo/Mzdy</td>
</tr>


<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="uctovanie.php?copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>
<div id="myBANKADZelement"></div>
<div id="jeBANKADZelement"></div>
<div id="myBANKASelement"></div>
<div id="jeBANKASelement"></div>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  sadzby
?>





<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
