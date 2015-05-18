<?PHP
$ajwebstranka=0;
if( $_SERVER['SERVER_NAME'] == "www.dssbrodske.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.edcom.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.zszzsmrdaky.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.szsgbely.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.biomeat.sk" ) { $ajwebstranka=1; }

$odstavka=0;
if( $odstavka == 1 )
 {
$ajwebstranka=0;
echo "<br /><br /><br />";
echo "Na stránke sa momentálne pracuje, dostupná bude v sobotu 16.11.2013 od 18.00 hod. Ïakujeme za pochopenie.";
exit;
 }

if( $ajwebstranka == 0 )
 {
?>
<script type="text/javascript">
    window.open('../hses.php', '_self' );
</script>
<?php
 }
if( $ajwebstranka == 1 AND $_SERVER['SERVER_NAME'] != "www.medosro.sk" )
 {
?>
<script type="text/javascript">
    window.open('index.html', '_self' );
</script>
<?php
 }
?>
<?php
if( $ajwebstranka == 1 AND $_SERVER['SERVER_NAME'] == "www.medosro.sk" )
 {
?>
<script type="text/javascript">
    window.open('../webpage/index.html', '_self' );
</script>
<?php
 }
?>

