<?

//  require_once "../common.php";
//  seterr();
//  dbinit();

$myQueryText = "SELECT * FROM rep_crdStats ORDER BY ts DESC LIMIT 1";

$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

if (@mysql_num_rows($q) != 0) {
	$f = @mysql_fetch_array($q);

	$startTS = $f['ts'];

	$myQueryText = "SELECT * FROM cashlog WHERE timestamp>$startTS";
	$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
	while ($f = @mysql_fetch_array($q)) {

		$params = urldecode($f['msg']);
		$clientId  = extractCsvParam($params, "rfid");
		if ($clientId != '' and $clientId != 'nocard' and $clientId != 'nouser') // and ($oper=='addcred' or $oper=='paycredit'))
		{
			$oper  = extractCsvParam($params, "oper");
			if ($oper == 'addcredit' or $oper == 'paycredit') {
				//		    echo $clientId. ' '.$oper;
				if ($oper == 'addcredit') $client[$clientId] += extractCsvParam($params, "addval");
				else $client[$clientId] -= extractCsvParam($params, "payval");
			}
		}
	}

	$myQueryText = "SELECT * FROM rep_contracts WHERE card_id!=''";
	$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
	while ($f = @mysql_fetch_array($q)) {
		$cardsDelta[$f['card_id']] += $client[$f['number']];
	}
	foreach ($cardsDelta as $e => $v) $text2DB .= "$e=$v;";
}

//echo	 $text2DB;
$myQueryText = "INSERT INTO rep_crdStats (ts,data) values ('" . time() . "','$text2DB');";
$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
