<?

//  require_once "../common.php";
//  seterr();
//  dbinit();
$lastGameId = 18;

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
	for ($i = 1; $i <= $lastGameId; $i++) {
		$stat[$i][$f['sessionId']]['in'] = 0;
		$stat[$i][$f['sessionId']]['out'] = 0;
		$stat[$i][$f['sessionId']]['spins'] = 0;
	}
	$payRate[$f['sessionId']] = $f['payRate'];
}

$myQueryText = "SELECT * FROM birjadb.rep_nsStats ORDER BY ts DESC LIMIT 1";

$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

if (@mysql_num_rows($q) != 0) {
	$f = @mysql_fetch_array($q);

	$startTS = $f['ts'];

	//	    echo date('H:i:s d-m-Y', $startTS);
	//	    echo time();

	//	    $myQueryText="SELECT * FROM ns.logs3 WHERE ts=0 and gameId!=0";
	$myQueryText = "SELECT * FROM ns.logs3 WHERE ts>$startTS";
	//echo "<br><br>";
	$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
	while ($f = @mysql_fetch_array($q)) {

		//		echo $f['gameId']." ".$f['termName']." ".$f['win']."<br>";

		$stat[$f['gameId']][$f['termName']]['in'] += $f['spin_cost'];
		$stat[$f['gameId']][$f['termName']]['out'] += $f['win'];
		$stat[$f['gameId']][$f['termName']]['spins']++;
	}
}

for ($i = 1; $i <= $lastGameId; $i++) {
	foreach ($stat[$i] as $e => $v) {
		$in = 0;
		$out = 0;
		$spins = 0;
		foreach ($v as $e1 => $v1) {
			if ($e1 == 'in') $in = $v1;
			elseif ($e1 == 'out') $out = $v1;
			elseif ($e1 == 'spins') $spins = $v1;
		}

		$text2DB .= "$e," . $payRate[$e] . ",$in,$out,$spins;";
	}
	$text2DB .= "_";
}

//echo	$text2DB;


$myQueryText = "INSERT INTO birjadb.rep_nsStats (ts,data) values ('" . time() . "','$text2DB');";
$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

mysql_close($link);
