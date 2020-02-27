<?
$base_delta = 3000;

include('../../srv/dbConnect.php');
$link = mysql_connect($db_host, $db_user, $db_pass);
/*
    $db_selected = mysql_select_db('ns', $link);
    if (!$db_selected) {
	die ('Не удалось выбрать базу: ' . mysql_error());
    }
*/

$myQueryText = "SELECT sessionId, payRate FROM ns.common ORDER BY sessionId";

$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
while ($f = @mysql_fetch_array($q)) {
	/*
	for($i=1;$i<=$lastGameId;$i++)
	{
	$stat[$i][$f['sessionId']]['in']=0;
	$stat[$i][$f['sessionId']]['out']=0;
	$stat[$i][$f['sessionId']]['spins']=0;
	}
*/
	$payRate[$f['sessionId']] = $f['payRate'];
}

foreach ($payRate as $e => $v) {
	$pr = 1;
	if (is_numeric($e) and $e > 5000) {
		$myQueryText = "SELECT * FROM birjadb.terminals where id=$e;";
		$q2 = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
		$f2 = @mysql_fetch_array($q2);
		$delta = $f2['total_in'] - $f2['total_out'] - $f2['credit'];
		//	echo floatval($base_delta);
		$percent = round(floatval($delta) * 100 / floatval($base_delta), 2);
		//	echo $e." - ".$f2['total_in']." ".$f2['total_out']." ".$f2['credit']." = ".$delta."<br>";


		if ($percent < 0) {
			$percent *= -1;
			if (round(rand(0, 100), 2) > $percent) {
				$pr = 1;
				//		echo $e." ".$f2['total_in']." ".$f2['total_out']." ".$f2['credit']." = ".$delta." / ".$percent;
			} else $pr = 2;

			//echo	    $myQueryText="UPDATE ns.common SET payRate=$pr where sessionId=$e;";
			//echo "<br>";
			//	    $q3= @mysql_query ($myQueryText) or die ("mysql_query: " . mysql_error());
		}

		$myQueryText = "UPDATE ns.common SET payRate=$pr where sessionId=$e;";
		$q3 = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
		//echo "<br>";
	}
	//     echo $e." = ".$v."<br>";
}
mysql_close($link);
