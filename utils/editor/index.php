<?
header('Access-Control-Allow-Origin: *');
include('settings.php');

//$gameId=2;
echo "<h1><a href='index.php'>gameId=" . $gameId . ", PR=" . $payrate . "</a> | <a href='bindex.php'>TO BONUS</a></h1>";


if ($gameId == 10) $reelOnDisplay = 7;
else $reelOnDisplay = 5;

if ($_GET['reel'] != '') {
	$result = mysql_query("SELECT * from ns.reels where id=" . $_GET['reel'] . " and gameId=" . $gameId . " and payrate=" . $payrate . ";");
	//echo "SELECT * from ns.reels where id=".$_GET['reel'].";";
	$row = mysql_fetch_assoc($result);
	$data = explode('_', $row['symbols']);
	$new = '';


	foreach ($data as $e => $v) {
		if ($e == $_GET['pos']) $v = $_GET['symb'];
		if ($new == '') $new = $v;
		else $new .= "_" . $v;
	}

	$result = mysql_query("update ns.reels set symbols='" . $new . "' where id=" . $_GET['reel'] . " and gameId=" . $gameId . " and payrate=" . $payrate . ";");

	echo "<h3>Reels updated!!!</h3>";
}

if ($gameId == 9) {
	$result2 = mysql_query("SELECT * from ns.reels where (id=5 or id=6 or id=7 or id=8 or id=9) and gameId=" . $gameId . " and payrate=" . $payrate . ";");

	while ($reels = mysql_fetch_assoc($result2)) {
		$reel[$reels['id']] = explode("_", $reels['symbols']);
	}

	$result2 = mysql_query("SELECT * from ns.bonuses where type=5 and gameId=" . $gameId . ";");
	$bnses = mysql_fetch_assoc($result2);
	$bns[$bnses['type']] = explode("_", $bnses['symbols']);
	//echo "^".$bns."^";
	echo
		"
<div style='display:block;position:absolute;left:500px;top:60px'>
    <table border=1>
    <tr>
    <td colspan=3>FEATURE RATES</td><td colspan=3>FINAL CHANCE STONE RATES</td>
    <tr>
    <td>HAMMER</td><td>ARROW</td><td>SWORD</td><td>BLUE</td><td>GREEN</td><td>RED</td>
    <tr>
    <td>" . $reel[5][0] . "</td><td>" . $reel[5][1] . "</td><td>" . $reel[5][2] . "</td><td>" . $reel[5][3] . "</td><td>" . $reel[5][4] . "</td><td>" . $reel[5][5] . "</td>
    <tr><td colspan=6>&nbsp;</td>
    <tr>
    <td colspan=6>SIDE SCATTERS IN RESPINS</td>
    <tr>
    <td colspan=2>BLUE</td><td colspan=2>GREEN</td><td colspan=2>RED</td>
    <tr>
    <td colspan=2>" . $reel[9][0] . "</td><td colspan=2>" . $reel[9][1] . "</td><td colspan=2>" . $reel[9][2] . "</td>
    <tr><td colspan=6>&nbsp;</td>
    <tr>
    <td colspan=6>SCATTERS IN BONUS</td>
    <tr>
    <td colspan=2>BLUE</td><td colspan=2>GREEN</td><td colspan=2>RED</td>
    <tr>
    <td colspan=2>" . $bns[5][0] . "</td><td colspan=2>" . $bns[5][1] . "</td><td colspan=2>" . $bns[5][2] . "</td>
    </table>
</div>
";
}

$symbWidth = '50';

//$gameId=1;

//$symbolsOnReel;


$result = mysql_query("SELECT * from ns.reels where gameId=" . $gameId . " and payrate=" . $payrate . " order by id asc;");
//echo "SELECT * from ns.reels where gameId=".$gameId." order by id asc;";

$i = 0;
while ($row = mysql_fetch_assoc($result)) {
	$data[$row['id']] = $row['symbols'];
	$i++;
}

//for($i=0;$i<$reelOnDisplay;$i++)
//echo $data[5];

for ($i = 0; $i < $reelOnDisplay; $i++) {
	$reelcontent[$i] .= "<table border=0><tr>";
	$reel[$i] = explode('_', $data[$i]);
	//	$a.="reel".$i." ";
	foreach ($reel[$i] as $e => $v) {

		echo "<div id='" . $i . "_" . $e . "' style='display:none;position:absolute;left:0px;top:" . ($symbWidth * $e) . ";'>
		<table  bgcolor=black>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=0'><img src='img/" . $gameId . "/0.png' width=" . $symbWidth . "></a></div>
		</td>";

		if ($gameId != 1)
			echo "
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=1'><img src='img/" . $gameId . "/1.png' width=" . $symbWidth . "></a></div>
		</td>";

		if ($gameId == 5)
			echo "
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=2'><img src='img/" . $gameId . "/2.png' width=" . $symbWidth . "></a></div>
		</td>";

		echo "
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=3'><img src='img/" . $gameId . "/3.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=4'><img src='img/" . $gameId . "/4.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=5'><img src='img/" . $gameId . "/5.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=6'><img src='img/" . $gameId . "/6.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=7'><img src='img/" . $gameId . "/7.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=8'><img src='img/" . $gameId . "/8.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=9'><img src='img/" . $gameId . "/9.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=10'><img src='img/" . $gameId . "/10.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=11'><img src='img/" . $gameId . "/11.png' width=" . $symbWidth . "></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=12'><img src='img/" . $gameId . "/12.png' width=" . $symbWidth . "></a></div>
		</td>";


		if ($gameId == 6 or $gameId == 9 or $gameId == 13 or $gameId == 14)
			echo "
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=13'><img src='img/" . $gameId . "/13.png' width=" . $symbWidth . "></a></div>
		</td>";
		if ($gameId == 6 or $gameId == 9)
			echo "
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=14'><img src='img/" . $gameId . "/14.png' width=" . $symbWidth . "></a></div>
		</td>
		";

		if ($gameId == 9)
			echo "
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=15'><img src='img/" . $gameId . "/15.png' width=" . $symbWidth . "></a></div>
		</td>
		";

		echo "</table></div>";

		$symbolsOnReel[$i][$v]++;
		$reelcontent[$i] .= "<td style='vertical-align:top;'><img width=" . $symbWidth . " class='mainImg' src='img/" . $gameId . "/" . $v . ".png' onClick=showMenu('" . $i . "_" . $e . "')></a><td><tr>";

		//	$reelcontent[$i].="<tr>";

	}
	//	$a.="<br>";

	$reelcontent[$i] .= "</table>";
}


for ($i = 0; $i < $reelOnDisplay; $i++) {
	$headerTable[$i] .= "<b>R" . $i . "-" . count($reel[$i]) . "</b><br><br>";
	foreach ($symbolsOnReel[$i] as $e => $v) 	$headerTable[$i] .= "S" . $e . "=" . $v . "<br>";
}

echo "

<script>

    function showMenu(menuId)
    {
	var a,mouseX,mouseY;
	var divs = document.getElementsByTagName('div');
	for(var i = 0; i < divs.length; i++){
	    divs[i].style.display='none';
	}

	mouseX=window.event.clientX+30;
//	mouseY=window.event.clientY-20;

//	alert(menuId);

	a=document.getElementById(menuId);
	a.style.left=mouseX+'px';
	a.style.top=mouseY+'px';
//	alert(a.style.left);
	a.style.display='block';
    }

</script>



";



echo "
<table width=400>
<tr>
";

for ($i = 0; $i < $reelOnDisplay; $i++)
	echo "
    <td style='vertical-align:top;'>" . $headerTable[$i] . "</td>
";
echo "<tr>";
for ($i = 0; $i < $reelOnDisplay; $i++)
	echo "
    <td style='vertical-align:top;'>" . $reelcontent[$i] . "</td>
";

echo "
</table>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
";



mysql_close($link);
