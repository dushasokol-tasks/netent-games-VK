<?
//  require_once "../common.php";
//  seterr();
//  dbinit();


$text2DB = '';
$percent = 40;

//    $myQueryText="SELECT * FROM rep_gomoList ORDER BY ts DESC LIMIT 1";

//    $q = @mysql_query ($myQueryText) or die ("mysql_query: " . mysql_error());

//	if (@mysql_num_rows($q) != 0)
{
	//	    $f = @mysql_fetch_array($q);

	$startTS = time() - 86400;
	$operCount;

	$myQueryText = "SELECT * FROM cashlog WHERE timestamp>$startTS;";
	$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

	if (@mysql_num_rows($q) != 0) {

		while ($f = @mysql_fetch_array($q)) {
			$msgs = explode(";", $f['msg']);
			$oper = 0;
			$client = 0;
			foreach ($msgs as $e) {
				$arg = explode("=", $e);
				if ($arg[0] == 'oper')	if ($arg[1] == 'addcredit')	$oper = 1;
				if ($arg[0] == 'client_id')	$client = $arg[1];
			}
			if ($oper != 0 and $client != 0) {
				$operations[$f['club_id']][$client]++;
				$operCount[$f['club_id']]++;
			}
		}
		$fromClub;
		foreach ($operCount as $club => $clOp) {
			$p = 0;
			//"$club: ".$clOp."<br>";
			foreach ($operations[$club] as $e => $v) {
				$p = round($v / $clOp * 100, 2);
				if ($p >= $percent) $fromClub[$club] .= "cl=$e;op=$v;perC=$p;";
			}
		}
	}
}

foreach ($fromClub as $e => $v) {
	$text2DB = date("d-m-Y", time()) . ";club=" . $e . ";" . $v . ",";
	$myQueryText = "log=concat(log,'" . $text2DB . "')";
	$myQueryText = "UPDATE rep_departments SET $myQueryText WHERE id=$e;";
	//		echo $myQueryText."<br>";
	$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
}


//echo	 $text2DB;
//	$myQueryText="INSERT INTO rep_gomoList (ts,data) values ('".time()."','$text2DB');";
//	$q = @mysql_query ($myQueryText) or die ("mysql_query: " . mysql_error());
