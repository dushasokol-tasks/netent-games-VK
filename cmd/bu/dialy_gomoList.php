<?
//  require_once "../common.php";
//  seterr();
//  dbinit();

$text2DB = '';

$myQueryText = "SELECT * FROM rep_gomoList ORDER BY ts DESC LIMIT 1";

$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

if (@mysql_num_rows($q) != 0) {
	$f = @mysql_fetch_array($q);

	$startTS = $f['ts'];

	$myQueryText = "SELECT * FROM rep_contracts;";
	$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
	while ($f = @mysql_fetch_array($q)) {
		$cl[$f['passSer'] . "-" . $f['passNum']] += $f['full_delta'];
	}
	foreach ($cl as $e => $v) $text2DB .= "$e=$v;";
}
//echo	 $text2DB;
$myQueryText = "INSERT INTO rep_gomoList (ts,data) values ('" . time() . "','$text2DB');";
$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
