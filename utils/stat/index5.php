<?
header('Access-Control-Allow-Origin: *');
$start = microtime(true);

echo "
<style>
.summary{font-size:15px;}

td{width:300px;}

table {border-spacing:0;padding:0;}

table td {font-size:10px;}

</style>
";

$lastGameId = 18;

include('../../srv/dbConnect.php');
$link = mysql_connect($db_host, $db_user, $db_pass);

$myQueryText = "SELECT * FROM birjadb.rep_nsStats ORDER BY ts ASC";
//    $myQueryText="SELECT * FROM birjadb.rep_nsStats ORDER BY ts DESC limit ".$_GET['period'];

$res = mysql_query($myQueryText);



$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

while ($f = @mysql_fetch_array($q))

//	if (@mysql_num_rows($q) != 0)
{
	//	    $f = @mysql_fetch_array($q);

	$gameStat = explode('_', $f['data']);


	for ($i = 0; $i <= $lastGameId - 1; $i++) {
		//echo $gameStat[$i]."<br>";
		$temp = explode(';', $gameStat[$i]);
		foreach ($temp as $e => $v) {

			//echo $v."<br>";
			$temp2 = explode(',', $v);
			$isVK = strstr($temp2[0], 'VK');
			if (!$isVK) {

				//		    if($i==1 and $temp2[0]==5256) echo $temp2[0];

				//		    echo $temp2[0]." ".date("d.m.y",$f['ts'])."<br>";


				$statByGame[$f['ts']][$i]['in'] += $temp2[2];
				$statByGame[$f['ts']][$i]['out'] += $temp2[3];
				$statByGame[$f['ts']][$i]['spins'] += $temp2[4];

				$full_in[$i] += $temp2[2];
				$full_out[$i] += $temp2[3];
				$full_spins[$i] += $temp2[4];

				$statByTerm[$f['ts']][$temp2[0]]['in'] += $temp2[2];
				$statByTerm[$f['ts']][$temp2[0]]['pr'] = $temp2[1]; //payrate
				$statByTerm[$f['ts']][$temp2[0]]['out'] += $temp2[3];
				$statByTerm[$f['ts']][$temp2[0]]['spins'] += $temp2[4];
			}
			//		    if($i==1 and $temp2[0]==5256) echo $statByTerm[$f['ts']][$temp2[0]]['in']."<br>";

			//		    $full_in[$i]=$temp2[2];

		}

		//	    $cells[$k][$i]='';

		//	    $k++;

	}
	//echo $f['ts']."<br>";
}
echo "ok";
//echo $statByTerm['1537943704']['5256']['pr'];
//echo "!!".$full_spins[11]."??";

//echo $time = microtime(true) - $start;

echo "<h2>BY GAME</h2>";
echo "<table border=01>";
echo "<tr>";
echo "<td>DATE</td><td>RHood</td><td>CCats</td><td>fShop</td><td>wCub</td><td>jHamm</td><td>jHend</td><td>Hansel</td><td>Sburst</td><td>wLords</td><td>hLine</td><td>aStones</td><td>Jumanji</td><td>Mirror</td><td>Rrush</td><td>Bolly</td><td>bFly</td><td>CoinsOE</td><td>Shangri</td>";

$i = count($statByGame) - 1;
$a = 0;

foreach ($statByGame as $e => $v) {
	if (($i - $a) < $_GET['period']) {
		echo "<tr><td>" . date('d-m-Y', $e) . "</td>";
		foreach ($v as $e1 => $v1) {
			echo "<td>";

			echo "<b>" . $v1['spins'] . "</b> " . round($v1['in']) . " / " . round($v1['out']) . " = " . round(($v1['in'] - $v1['out']));

			echo "</td>";
		}
	}
	$a++;
}

echo "<tr><td class='summary'>SUMMARY</td>";
for ($i = 0; $i <= $lastGameId - 1; $i++) {
	echo "<td class='summary'>";
	echo "in " . round($full_in[$i]) . "<br>";
	echo "out " . round($full_out[$i]) . "<br>";
	$inout = round($full_in[$i]) - round($full_out[$i]);
	$percent = round(($full_out[$i]) / ($full_in[$i]), 4) * 100;
	echo "i/o " . $inout . " <b>%" . $percent . "</b><br>";
	echo "spn " . round($full_spins[$i]) . "<br>";
	echo "</td>";
}

echo "</table>";

$i = 0;
echo "<h2>BY TERM</h2>";

echo "<table border=1><tr><td>";
$i = count($statByTerm) - 1;
$a = 0;

//	asort($statByTerm);

foreach ($statByTerm as $e => $v) {
	if (($i - $a) < $_GET['period']) {
		echo "<b>" . date('d-m-Y', $e) . "</b><br>";
		foreach ($v as $e1 => $v1) {
			echo $e1 . " (" . $v1['pr'] . "):" . round($v1['in']) . " / " . round($v1['out']) . " = " . round(($v1['in'] - $v1['out'])) . " S=" . $v1['spins'] . "<br> ";

			if (is_numeric($e1) and $i == $a) {
				$myQueryText = "SELECT * FROM birjadb.terminals where id=$e1";
				$q = mysql_query($myQueryText);
				if (@mysql_num_rows($q) != 0) {
					$f = @mysql_fetch_array($q);
					$pidor = $f['total_in'] - $f['total_out'];
					if ($pidor > 0) $style = 'black';
					else $style = 'red';
					if ($f['credit'] < 0) $cred_html = "<b style='color:red;'>DEP: " . $f['credit'] . "</b>";
					else $cred_html = "<b>DEP: " . $f['credit'] . "</b>";
					$cashList .= "<b>" . $e1 . " (" . $f['name'] . ")</b> " . $f['total_in'] . " / " . $f['total_out'] . " = <span  style='color:" . $style . ";'>" . $pidor . "</span> $cred_html<br>";
				}
			}
		}
	}
	$a++;
}

echo "</td>
<td valign=top>
" . $cashList . "
</td>
</table>
";

/*

echo "<table border=0>";
echo "<tr>";
echo "<td style='width:60px;'>date</td><td>RHood</td><td>CCats</td><td>fShop</td><td>wCub</td><td>jHamm</td><td>jHend</td><td>Hansel</td><td>Sburst</td><td>wLords</td><td>hLine</td>";

foreach ($counter as $dtDate=>$v)
    {
    echo "<tr>";
    echo "<td  style='width:60px;'>".$dtDate."</td>";
    echo "<td colspan=10><table border=1 width=100%>";
    unset($cell);
    foreach($v as $dtGame=>$v1)
	{
    	foreach($v1 as $dtTerm=>$v2)
	    {


	    $cell[$dtGame]['spins']+=round($v2['spins'],2);
	    $cell[$dtGame]['ins']+=round($v2['ins'],2);
	    $cell[$dtGame]['outs']+=round($v2['outs'],2);

	    $overall[$dtGame]['spins']+=round($v2['spins'],2);
	    $overall[$dtGame]['ins']+=round($v2['ins'],2);
	    $overall[$dtGame]['outs']+=round($v2['outs'],2);



	    }
	}

	    echo "<tr>";

	    for($i=1;$i<=10;$i++)
	    if($cell[$i]['ins']!='')
		echo "<td>".$cell[$i]['spins']." | ".$cell[$i]['ins']." / ".$cell[$i]['outs']."<b> (".round($cell[$i]['ins']-$cell[$i]['outs'],2).") </b> </td>";
	    else echo "<td></td>";



    echo "</table></td>";

    }
echo "</table>";

echo "<br><br>";

echo "<table border=0><tr><td style='width:80px;'>SUMM</td>";

	    for($i=1;$i<=10;$i++)
	    {
		echo "<td style='font-size:14px;'>".$overall[$i]['spins']." | ".$overall[$i]['ins']." / ".$overall[$i]['outs']."<b> (".round($overall[$i]['ins']-$overall[$i]['outs'],2).") ".round($overall[$i]['outs']/$overall[$i]['ins']*100,2)."%</b> </td>";

		$total_in+=$overall[$i]['ins'];
		$total_out+=$overall[$i]['outs'];
	    }

echo "</table>";

echo "<h2>total in= ".$total_in."; total out= ".$total_out."; inout= ".($total_in-$total_out)."</h2>";
*/

mysql_close($link);
