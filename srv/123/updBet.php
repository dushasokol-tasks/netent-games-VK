<?
$result = mysql_query("SELECT * FROM ns.states where sessionId='" . $_GET['sessid'] . "';");

if (1 == @mysql_num_rows($result)) {
	$row = mysql_fetch_assoc($result);
	$wildsDB = $row['wilds'];
	$answer = $row['answer'];
	$common = $row['common'];				////////////////////???????????????
	$lastActionDB = $row['lastAction'];
	$lastRsDB = $row['lastRs'];
	$lock = $row['locked'];

	include('settings.php');

	if ($gameId != $gameIdDB) {
		$answer = "";
		$lastRsDB = '';
		$lastActionDB = 'spin';
	}

	$Info = explode(";", $answer);
	foreach ($Info as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	//check session activite permissions

	if ($lastActionDB != 'init' and $lastActionDB != 'reloadbalance') {
		$activity = round(microtime(true), 2);
		if ($lastActivity < ($activity - .6)) {

			if (isset($_Term_overlay['old_sessid']) and (($today_ts - $lastActivity) > 140)) {
				//echo "<br>".$lastActivity." < ".$today_ts." : ".$_Term_overlay['old_sessid']." = ".($today_ts-$lastActivity)."<br><br>";
				$query = "UPDATE " . $DB2 . "." . $term_table . " set terminalOverlay='' where id='" . $_Term_overlay['old_sessid'] . "';";
				$result = mysql_query($query);
				$_GET['action'] = "reload";
				$output = "errordata=Game+Server+Error+Code&error=TECHNICAL_ERROR&errorcode=9&";
			} else 	$query = "`activity`='" . $activity . "'";
		} elseif (($gameId == 1 or $gameId == 7) and ($_GET['action'] == "bonusaction" or $_GET['action'] == "endbonus")) {
		} elseif ($_GET['bot'] != 1) exit();
	}




	////////////////////////////////////////////////////////
	//update bet, denom
	///////////////////////////////////////////////////////
	if ($gameId == 1) {
		$query .= ", `lines`='20'";
		$linesDB = 20;
	}
	if ($gameId == 2) {
		$query .= ", `lines`='25'";
		$linesDB = 25;
	}
	if ($gameId == 3) {
		$query .= ", `lines`='15'";
		$linesDB = 15;
	}
	if ($gameId == 4) {
		$query .= ", `lines`='20'";
		$linesDB = 20;
	}
	if ($gameId == 5) {
		$query .= ", `lines`='25'";
		$linesDB = 25;
	}
	if ($gameId == 6) {
		$query .= ", `lines`='20'";
		$linesDB = 20;
	}
	if ($gameId == 7) {
		$query .= ", `lines`='10'";
		$linesDB = 10;
	}
	if ($gameId == 8) {
		$query .= ", `lines`='10'";
		$linesDB = 10;
	}
	if ($gameId == 9) {
		$query .= ", `lines`='30'";
		$linesDB = 30;
	}
	if ($gameId == 10) {
		$query .= ", `lines`='30'";
		$linesDB = 30;
	}
	if ($gameId == 11) {
		$query .= ", `lines`='20'";
		$linesDB = 20;
	}
	if ($gameId == 12) {
		$query .= ", `lines`='36'";
		$linesDB = 36;
		if (!isset($token) or $token == '') $token = 'crocodile';
	}
	if ($gameId == 13) {
		$query .= ", `lines`='1'";
		$linesDB = 1;
	}
	if ($gameId == 14) {
		$query .= ", `lines`='1'";
		$linesDB = 1;
	}
	if ($gameId == 15) {
		$query .= ", `lines`='9'";
		$linesDB = 9;
	}
	if ($gameId == 16) {
		$query .= ", `lines`='40'";
		$linesDB = 40;
	}
	if ($gameId == 17) {
		$query .= ", `lines`='20'";
		$linesDB = 20;
	}
	if ($gameId == 18) {
		$query .= ", `lines`='1'";
		$linesDB = 1;
	}
	if ($gameId == 19) {
		$query .= ", `lines`='1'";
		$linesDB = 1;
	}

	//if($gameId==999) {$query.=", `lines`='1'";$linesDB=1;$_GET['bet_betlevel']=1;}

	if ($gameId == 100) {
		$query .= ", `lines`='1'";
		$linesDB = 1;
	}

	if ($lock == "0") {
		foreach ($_GET as $v => $e) {
			if ($v == 'bet_betlevel') {
				if ($e == 0) $e = 1;
				$query .= ", bet='" . intval($e) . "'";
				$betDB = intval($e);
			}
			if ($v == 'bet_denomination') {
				if ($e == 0) $e = 1;
				$query .= ", denom='" . intval($e) . "'";
				$denomDB = intval($e);
			}
			if ($gameId == 10) {
				if ($v == 'bet_hotlines') {
					$query .= ", anBetVar='" . $e . "'";
					$anBetVarDB = $e;
				}
			}
			if ($gameId == 12) {
				if ($v == 'bonus_token') {
					$token = $e;
				}
			}
		}
		$query .= ", gameId='" . $gameId . "'";
		$query = "UPDATE ns.common set " . $query . " where sessionId='" . $_GET['sessid'] . "';";
		if ($query != '') $result = mysql_query($query);
	}
} else $forceExit = "no such id";

//////////////stat for logs
$gameInfo = "bet=" . $betDB . ";denom=" . $denomDB . ";anBV=" . $anBetVarDB . ";ownId=" . $ownerId . ";";
//////////////
