<?
//  require_once "../common.php";
//  seterr();
//  dbinit();

$myQueryText = "SELECT * FROM rep_departments WHERE ballsPercent>0";
$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

if (@mysql_num_rows($q) != 0) {
	while ($f = @mysql_fetch_array($q)) {
		$deptDict[$f['id']] = $f['ballsPercent'];
	}
}


$myQueryText = "SELECT * FROM rep_contracts WHERE card_id!='' and balls_delta>=5";
$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

if (@mysql_num_rows($q) != 0) {
	while ($f = @mysql_fetch_array($q)) {
		if (!empty($deptDict[$f['dept']])) {
			$j = $f['number'];
			$e = $f['card_id'];
			$v = round($f['balls_delta'] * $deptDict[$f['dept']] * 0.01, 0);
			$myQueryText = "UPDATE rep_cards SET balls=balls+$v WHERE cid='$e';";
			$z = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
			$myQueryText = "UPDATE rep_contracts SET balls_delta='0' WHERE number='$j';";
			$z = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
		}
	}
}
