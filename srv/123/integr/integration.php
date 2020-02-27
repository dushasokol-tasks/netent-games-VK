<?
if ($cmd != '') {
	/*
	    if($_GET['sessid']=='VK10637772')
	    {
	    $bt['credit']=$credit/100;

		if($_Game['world']!=0)
		{
		    $bt['credit'.$_Game['world']]=$credit/100;
		}

	    }
	    else
*/
	$bt['credit'] = $credit / 100;
	include("cmd/cmd.php");
	$result = mysql_query("SELECT * FROM " . $DB2 . "." . $term_table . " where id='" . $mainTerminalId . "';");
	//echo "a= SELECT * FROM ".$DB2.".".$term_table." where id='".$_GET['sessid']."';&";
	$row = mysql_fetch_assoc($result);
	$newCredit = $row['credit'] * 100;
} else {
	$creditCurrentWorld = 'credit';
	///	    if($_GET['sessid']=='VK10637772' or $_GET['sessid']=='VK532248891')
	{
		//	    $bt['credit']=$credit/100;

		if ($_Game['world'] != 0) {
			//		    $bt['credit'.$_Game['world']]=$credit/100;
			$creditCurrentWorld .= $_Game['world'];
		}
	}

	$query = "UPDATE " . $DB2 . "." . $term_table . " set " . $creditCurrentWorld . "='" . ($credit / 100) . "' where id='" . $mainTerminalId . "';";
	//	    $result = mysql_query("UPDATE ".$DB2.".".$term_table." set ".$creditCurrentWorld."='".($credit/100)."' where id='".$mainTerminalId."';");
	$result = mysql_query($query);
	$newCredit = $credit;
}
//if($_GET['sessid']=='VK10637772') echo $query;

//echo 	$newCredit;
if ($_GET['action'] == "reloadbalance" or $_GET['action'] == "init") $output .= "credit=" . $newCredit . "&";
//	else $output.=$credit."&";

//    echo $output;


//echo "<br>";
