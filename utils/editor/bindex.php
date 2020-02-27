<?
header('Access-Control-Allow-Origin: *');
include('settings.php');

//$gameId=1;
echo "<h1><a href='/servlet/editor/bindex.php'>gameId=" . $gameId . ", PR=" . $payrate . "</a> | <a href='/servlet/editor/index.php'> TO MAINGAME</a></h1>";

if ($_GET['reel'] != '') {
	$result = mysql_query("SELECT * from ns.bonuses where type=" . $_GET['reel'] . " and gameId=" . $gameId . " and payrate=" . $payrate . ";");
	//echo "SELECT * from ns.reels where id=".$_GET['reel'].";";
	$row = mysql_fetch_assoc($result);
	$data = explode('_', $row['symbols']);
	$new = '';
	//echo "xcx".$row['id'];
	//echo "<br>";
	//echo $row['symbols'];
	//echo "<br>";

	foreach ($data as $e => $v) {
		if ($e == $_GET['pos']) $v = $_GET['symb'];
		if ($new == '') $new = $v;
		else $new .= "_" . $v;
	}
	//echo "<br>";
	//echo $new;

	$result = mysql_query("update ns.bonuses set symbols='" . $new . "' where type=" . $_GET['reel'] . " and gameId=" . $gameId . "  and payrate=" . $payrate . ";");

	echo "<h3>Reels updated!!!</h3>";
}


$symbWidth = '50';


//$gameId=1;

//$symbolsOnReel;


$result = mysql_query("SELECT * from ns.bonuses where gameId=" . $gameId . " and payrate=" . $payrate . " order by type asc;");
//echo "SELECT * from ns.bonuses where gameId=".$gameId." order by type asc;";

$i = 0;
while ($row = mysql_fetch_assoc($result)) {
	$data[$row['type']] = $row['symbols'];
	$i++;
}

for ($i = 0; $i < 5; $i++) {
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

		//	    if($gameId!=1)
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
		/*
	    if($gameId==6)
		echo "
		<tr>
		<td>
		<a href='?reel=".$i."&pos=".$e."&symb=13'><img src='img/".$gameId."/13.png' width=".$symbWidth."></a></div>
		</td>
		<tr>
		<td>
		<a href='?reel=".$i."&pos=".$e."&symb=14'><img src='img/".$gameId."/14.png' width=".$symbWidth."></a></div>
		</td>
		";
*/
		if ($gameId == 6 or $gameId == 9 or $gameId == 13 or $gameId == 14)
			echo "
		<tr>
		<td>
		<a href='?reel=" . $i . "&pos=" . $e . "&symb=13'><img src='img/" . $gameId . "/13.png' width=" . $symbWidth . "></a></div>
		</td>
		";
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


		echo "
		</table></div>		";

		$symbolsOnReel[$i][$v]++;
		$reelcontent[$i] .= "<td style='vertical-align:top;'><img width=" . $symbWidth . " class='mainImg' src='img/" . $gameId . "/" . $v . ".png' onClick=showMenu('" . $i . "_" . $e . "')></a><td><tr>";

		//	$reelcontent[$i].="<tr>";

	}
	//	$a.="<br>";

	$reelcontent[$i] .= "</table>";
}


for ($i = 0; $i < 5; $i++) {
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
    <td style='vertical-align:top;'>" . $headerTable[0] . "</td>
    <td style='vertical-align:top;'>" . $headerTable[1] . "</td>
    <td style='vertical-align:top;'>" . $headerTable[2] . "</td>
    <td style='vertical-align:top;'>" . $headerTable[3] . "</td>
    <td style='vertical-align:top;'>" . $headerTable[4] . "</td>

<tr>
    <td style='vertical-align:top;'>" . $reelcontent[0] . "</td>
    <td style='vertical-align:top;'>" . $reelcontent[1] . "</td>
    <td style='vertical-align:top;'>" . $reelcontent[2] . "</td>
    <td style='vertical-align:top;'>" . $reelcontent[3] . "</td>
    <td style='vertical-align:top;'>" . $reelcontent[4] . "</td>
</table>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
";







mysql_close($link);
