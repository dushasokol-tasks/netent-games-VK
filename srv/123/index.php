<?
header('Access-Control-Allow-Origin: *');
session_start();
//if(!isset($_GET['sessid'])) exit;
/*
if($_GET['sessid']=='VK10637772')
{
echo "SSid ".$_GET['sessid']."<br>";
echo "Sess ".$_SESSION['my_valid_user']."<br>";
echo "Session_id ".session_id()."<br>";
echo "Session_name ".session_name()."<br>";
echo "PHPSESS ".$_GET['PHPSESSID']."<br>";
 foreach ($_SESSION as $e=>$v)echo "$e = $v <br>";
}
*/
//echo "Sess ".$_SESSION['club']."<br>";
// foreach ($_SESSION as $e=>$v)echo "$e = $v <br>";
$itsClub = 0;
//is club ver

if (file_exists('club.dat')) {
	$file = file_get_contents('club.dat', true);
	$file = str_replace(chr(13), '', $file);
	$file = str_replace(chr(10), '', $file);
	if ($_SESSION['club'] != $file) exit;
	$itsClub = 1;
} elseif (file_exists('access.dat')) {

	$file = file_get_contents('access.dat', true);
	$file = str_replace(chr(13), '', $file);
	$file = str_replace(chr(10), '', $file);
	if ($_SESSION['user'] != $file) exit;
} elseif (isset($_SESSION['my_valid_user'])) {

	//echo "ss=".$_GET['sessid']."&";
	//echo "ss=".$_SESSION['my_valid_user']."&";

	if ($_GET['sessid'] == $_SESSION['my_valid_user'])
		$_GET['sessid'] = $_SESSION['my_valid_user'];
	else {
		session_destroy();
		exit;
		//$_GET['sessid']=$_SESSION['my_valid_user'];
	}
} else {
	session_destroy();
	exit;
}



$startTime = microtime(true);
$today_ts = time();
$forceExit = "";
$gameId = 0;
$oldSSID = '';
$answ = "";

if ($_GET['gameId'] == 'lobby') $gameId = 999; //

if ($_GET['gameId'] == 'fairyred') $gameId = 1; //
if ($_GET['gameId'] == 'catscats') $gameId = 2; //
if ($_GET['gameId'] == 'fruitshoo') $gameId = 3; //
if ($_GET['gameId'] == 'wolfcob') $gameId = 4;
if ($_GET['gameId'] == 'jackhummer') $gameId = 5; //
if ($_GET['gameId'] == 'jimilegenda') $gameId = 6;
if ($_GET['gameId'] == 'gansel') $gameId = 7;
if ($_GET['gameId'] == 'starcurst') $gameId = 8;
if ($_GET['gameId'] == 'warlord2') $gameId = 9;
if ($_GET['gameId'] == 'hotlink') $gameId = 10; //
if ($_GET['gameId'] == 'asgard') $gameId = 11; //
if ($_GET['gameId'] == 'jumanij') $gameId = 12; //
if ($_GET['gameId'] == 'mirror') $gameId = 13; //
if ($_GET['gameId'] == 'rrush') $gameId = 14; //
if ($_GET['gameId'] == 'bellywood') $gameId = 15; //
if ($_GET['gameId'] == 'butterflystoxx') $gameId = 16; //
if ($_GET['gameId'] == 'goinsofegypt') $gameId = 17; //
if ($_GET['gameId'] == 'shangrila') $gameId = 18;
if ($_GET['gameId'] == 'dezaleme') $gameId = 19;

//if($_GET['gameId']=='finn_not_mobile')$gameId=100;//

if ($gameId != 0) {
	//echo "dasd";
	include('commonVars.php');
	include('../dbConnect.php');
	$output = '';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	@mysql_query("set names 'utf8'");
	$DB2 = 'birjadb';
	$term_table = 'terminals';
	$Uid = $_GET['sessid'];

	if (strtoupper(substr($_GET['sessid'], 0, 2)) == 'VK') {
		$DB2 = 'ns';
		$term_table = 'social_terminals';
		$Uid = $_SESSION['my_valid_user'];
	}

	//echo strtoupper(substr($_GET['sessid'],0,2))."<br>";

	$query = "SELECT * FROM " . $DB2 . "." . $term_table . " where id='" . $_GET['sessid'] . "'";
	$result = mysql_query($query);
	$bt = mysql_fetch_assoc($result);
	$credit = $bt['credit'] * 100;
	$old_credit = $bt['credit'] * 100;

	$mainTerminalId = $_GET['sessid'];
	/*
///terminal overlay
    if($credit==0)
    {
     if($bt['id']!='')
     {
	if($bt['terminalOverlay']!='')
	    $query="SELECT * FROM ".$DB2.".rep_cards where cid='".$bt['terminalOverlay']."';";
	    $result = mysql_query($query);
	    $_Term_overlay = mysql_fetch_assoc($result);
	    if($_Term_overlay['socialAccount']!='')
	    {
//		$_Term_overlay['old_sessid']=$_GET['sessid'];
//		$_GET['sessid']=$_Term_overlay['socialAccount'];

		$mainTerminalId=$_Term_overlay['socialAccount'];
		$overlayClubId=$bt['club_id'];
	        $Uid=$mainTerminalId;

		$query="SELECT * FROM ".$DB2.".".$term_table." where id='".$mainTerminalId."';";
		$result = mysql_query($query);
		$bt = mysql_fetch_assoc($result);
		$bt['club_id']=$overlayClubId;
		$credit=$bt['credit']*100;
		$old_credit=$bt['credit']*100;
	    }
     }
    }
////
*/
	///terminal overlay
	if ($credit == 0) {
		if ($bt['id'] != '') {
			if ($bt['terminalOverlay'] != '')
				$query = "SELECT * FROM " . $DB2 . ".rep_cards where cid='" . $bt['terminalOverlay'] . "';";
			$result = mysql_query($query);
			$_Term_overlay = mysql_fetch_assoc($result);
			if ($_Term_overlay['socialAccount'] != '') {
				$query = "SELECT * FROM " . $DB2 . ".rep_contracts where dept = '" . $bt['club_id'] . "' and card_id = '" . $bt['terminalOverlay'] . "';";
				$result = mysql_query($query);
				$_Contract = mysql_fetch_assoc($result);
				if ($_Contract['number'] != '') {
					$freeroundsRate = 2100;
					$today_formatted_date = date('d.m.Y');
					echo "CLL=" . $_Contract['lastLogin'] . "&";
					if ($_Contract['lastLogin'] != $today_formatted_date) {
						if ($_Contract['balls_delta'] >= 200) {
							if ((rand(0, 1000) < $freeroundsRate and $_GET['action'] == 'init')) {
								$_Contract['free_rounds'] = round(rand(2, 5));
								if ($_Contract['balls_delta'] >= 500) $_Contract['free_rounds'] += round(rand(0, 10));
								if ($_Contract['balls_delta'] >= 1000) $_Contract['free_rounds'] += round(rand(0, 10));
								$answ .= "freeRoundsLeft=" . $_Contract['free_rounds'] . ";";
							}
						}
						if ($_GET['action'] == 'widgetspin') {
							$query = "UPDATE " . $DB2 . ".rep_contracts set lastLogin='" . $today_formatted_date . "'  where dept = '" . $bt['club_id'] . "' and card_id = '" . $bt['terminalOverlay'] . "';";
							$result = mysql_query($query);
						}
					}

					$mainTerminalId = $_Term_overlay['socialAccount'];
					$overlayClubId = $bt['club_id'];
					$Uid = $mainTerminalId;

					$query = "SELECT * FROM " . $DB2 . "." . $term_table . " where id='" . $mainTerminalId . "';";
					$result = mysql_query($query);
					$bt = mysql_fetch_assoc($result);
					$bt['club_id'] = $overlayClubId;
					$credit = $bt['credit'] * 100;
					$old_credit = $bt['credit'] * 100;
				}
			}
		}
	}
	////


	$spin_to_history = 0;
	$spincost = 0;
	$real_win = 0;

	//$dop2="|".$gameId."|";
	////////////////////////////////////////////////////////
	//update bet, denom
	///////////////////////////////////////////////////////
	include('updBet.php');
	////////
	///if($_GET['sessid']=='VK10637772'  or $_GET['sessid']=='VK532248891')
	{
		if ($_Social) {

			$avGamesStatus = explode(',', $_Social['avGamesStatus']);
			foreach ($avGamesStatus as $e1 => $v1) {
				$temp2 = explode(':', $v1);
				$avGS[$temp2[0]] = $temp2[1];
			}

			$query = "SELECT * FROM " . $DB2 . ".social_games where id='" . $gameId . "';";
			$result = mysql_query($query);
			$_Game = mysql_fetch_assoc($result);
			if ($gameId == 999) {
				//		    $end = array_slice($avGS, -1);
				//		    $temp=end($avGS);
				end($avGS);
				$key = key($avGS);
				reset($avGS);
				$query = "SELECT * FROM " . $DB2 . ".social_games where id='" . ($key) . "';";

				$result = mysql_query($query);
				$_tempWorld = mysql_fetch_assoc($result);
				$_Game['world'] = $_tempWorld['world'];
			}
			if ($_Game['world'] != 0) {
				$credit = $bt['credit' . $_Game['world']] * 100;
				$old_credit = $bt['credit' . $_Game['world']] * 100;
			}
		}
	}
	///////


	/////////////
	//PRE integration
	/////////////
	if ($forceExit == "") {
		$cmd = '';
		$result = mysql_query("SELECT * FROM " . $DB2 . ".srvcmd where term_id='" . $mainTerminalId . "';");
		$row = mysql_fetch_assoc($result);
		if ($row['id'] != '') {
			//echo $row['cmd'];
			$cmdId = $row['id'];
			if ($row['cmd'] == 'svaddcred1') {
				$cmd = "svaddcred1ack";

				if ($row['params'] != '') {
					$temp = explode('%3B', $row['params']);
					foreach ($temp as $e => $v) {
						$temp2 = explode('%3D', $v);
						if ($temp2[0] == 'client_id') $clientId = $temp2[1];
						if ($temp2[0] == 'owner_id') $ownerId = $temp2[1];
					}
					$query = "UPDATE ns.common set clientId=" . $clientId . ", ownerId=" . $ownerId . " where sessionId='" . $mainTerminalId . "';";
					$result = mysql_query($query);
				} else {
					$clientId = 0;
					$ownerId = 0;
				}
			}
			if ($row['cmd'] == 'svpaycred1') {
				$cmd = "svpaycred1ack";
				if ($_GET['action'] != "init" and $_GET['action'] != 'confirmPay') $_GET['action'] = "none";
				if ($_GET['action'] != 'confirmPay') $credit = 0;
			}
		}

		include('credOper.php');
		//    if($gameId==999) {$denomDB=100;}
	}
	//echo "w=$gameId&";
	if ($widgetOn == 1 and $gameId != 999)    include('widget.php');

	///////////////////////////////////////////////////
	//gameselector
	//////////////////////////////////////////////////
	if ($forceExit == "") {
		if ($gameId == 999) {
			$gamePath = "lobby/";
			include($gamePath . 'lobby.php');
		}

		if ($gameId == 1) {
			$gamePath = "rhft/";
			include($gamePath . 'fairyred.php');
		}
		if ($gameId == 2) {
			$gamePath = "cpcats/";
			include($gamePath . 'copycats.php');
		}
		if ($gameId == 3) {
			$gamePath = "fshop/";
			include($gamePath . 'fshop.php');
		}
		if ($gameId == 4) {
			$gamePath = "wcub/";
			include($gamePath . 'wcub.php');
		}
		if ($gameId == 5) {
			$gamePath = "jhamm/";
			include($gamePath . 'jhamm.php');
		}
		if ($gameId == 6) {
			$gamePath = "jhendr/";
			include($gamePath . 'jhendr.php');
		}
		if ($gameId == 7) {
			$gamePath = "hgft/";
			include($gamePath . 'hgft.php');
		}

		if ($gameId == 8) {
			$gamePath = "sburst/";
			include($gamePath . 'sburst.php');
		}

		if ($gameId == 9) {
			$gamePath = "wlords/";
			include($gamePath . 'wlords.php');
		}

		if ($gameId == 10) {
			$gamePath = "hline/";
			include($gamePath . 'hline.php');
		}

		if ($gameId == 11) {
			$gamePath = "astone/";
			include($gamePath . 'astone.php');
		}

		if ($gameId == 12) {
			$gamePath = "jumanji/";
			include($gamePath . 'jumanji.php');
		}

		if ($gameId == 13) {
			$gamePath = "mirror/";
			include($gamePath . 'mirror.php');
		}

		if ($gameId == 14) {
			$gamePath = "reelrush/";
			include($gamePath . 'reelrush.php');
		}

		if ($gameId == 15) {
			$gamePath = "bollywood/";
			include($gamePath . 'bollywood.php');
		}

		if ($gameId == 16) {
			$gamePath = "bfly/";
			include($gamePath . 'bfly.php');
		}

		if ($gameId == 17) {
			$gamePath = "coegypt/";
			include($gamePath . 'coegypt.php');
		}

		if ($gameId == 18) {
			$gamePath = "shangri/";
			include($gamePath . 'shangri.php');
		}

		if ($gameId == 19) {
			$gamePath = "dezaleme/";
			include($gamePath . 'dezaleme.php');
		}

		if ($gameId == 100) {
			$gamePath = "finn/";
			include($gamePath . 'relay.php');
		}
		include('integr/integration.php');
	}

	if ($forceExit == "") {
		if ($_Social
			// and $mainTerminalId!='VK532248891'
			// and $mainTerminalId!='VK2952425'
			//and $gameId!=19
		) {
			include('integr/social.php');
		}
		if ($_GET['action'] != "paytable" and $_GET['action'] != "init" and $_GET['action'] != "none" and $_GET['action'] != "reloadbalance") {
			if ($_GET['action'] == "freespin" or $_GET['action'] == "initfreespin" or $lastActionDB == "respin" or $lastActionDB == "random_wilds_spin" or $lastActionDB == "bonus_feature_pick" and  $spincost != 0) $sc = 0;
			else $sc = $spincost;

			if ($gameId == 1) {
				$sc = $spincost;
			}

			if ($gameId == 4) {
				if ($_GET['action'] == "freespin" or $_GET['action'] == "respin" and $spincost != 0) $sc = 0;
				else $sc = $spincost;
			}
			if ($gameId == 5) {
				if ($lastAction == "freespin" or $lastAction == "respin" or $lastAction == "endfreespin" and $spincost != 0) $sc = 0;
				else $sc = $spincost;
			}
			if ($gameId == 7) {
				if ($lastAction == "random_wilds" or $lastAction == "stackSpin" or $lastAction == "endfreespin" and $spincost != 0) $sc = 0;
				else $sc = $spincost;
			}
			if ($gameId == 8) {
				if ($lastAction == "stackSpin" and $spincost != 0) $sc = 0;
				else $sc = $spincost;
			}

			if ($gameId == 10) {
				if ($lastAction == "spin1" and $spincost != 0) $sc = $spincost;
			}
			if ($gameId == 13 or $gameId == 14 or $gameId == 15 or $gameId == 16 or $gameId == 18) {
				$sc = $spincost;
			}
			//	if($gameId==16 and $lastAction=="addfreespin")			{$sc=0;}

			$query = "betted_full='" . ($betted_full + $sc) . "'";
			$query .= ", winned_full='" . ($winned_full + $real_win) . "'";
			$query .= ", payed_spins=payed_spins+" . $spin_to_history;
			if ($payRate == 1 and isset($_Social) and $_Social['level'] > 5) $query .= ", payRate=2";
			$query = "UPDATE ns.common set " . $query . " where sessionId='" . $_GET['sessid'] . "';";

			//	$query="UPDATE ns.common set betted_full='".($betted_full+$sc)."', winned_full='".($winned_full+$real_win)."',    payed_spins=payed_spins+".$spin_to_history." where sessionId='".$_GET['sessid']."';";
			$result = mysql_query($query);
			include($gamePath . 'common.php');
		}
	} else {
		$_GET['sessid'] = "1";
		$lastAction = $forceExit;
	}

	//    $logs_table="ns.logs2";


	$timeWork = round(microtime(true) - $startTime, 4);

	$dop .= "[" . $_GET['action'] . "]";
	$dop .= "{" . $lastActionDB . "}";
	$d = date('H:i:s d-m-Y');
	$gameInfo .= "tw=$timeWork;Uid=" . $Uid . ";";
	$gameInfo = "wld=" . $_Game['world'] . ";" . $gameInfo;
	//						    $gameInfo.="tw=$timeWork;";

	$result = mysql_query("insert into " . $logs_table . " (id,termName,ts,time,gameId,payrate,clientId,gameInfo,action,symbs,credit_old,spin_cost,win,new_cred) values
						     ('', '" . $_GET['sessid'] . "', '" . time() . "', '" . $d . "', '" . $gameId . "', '" . $payRate . "', '" . $clientId . "', '" . $gameInfo . "', '" . $lastAction . "(" . $dop . ")" . $dop2 . "', '" . $symb_combs . "',
						    '" . $old_credit . "', '" . ($sc) . "', '" . $real_win . "', '" . $credit . "');");




	if ($oldSSID == '') {
		if ($_GET['bot'] != 1) echo $output;
		else {
			if ($lastAction == "endfreespin") {
				$lastAction = "spin";
			}
			if ($lastAction == "initfreespin" and $gameId == 4) {
				$lastAction = "respin";
			}
			if ($lastAction == "initfreespin" and $gameId == 6) {
				$lastAction = "bonusaction";
			}
			if ($lastAction == "pHaze" and $gameId == 6) {
				$lastAction = "spin";
			}

			if ($gameId == 7) {
				$lastAction = $botAction;
			}
			if ($gameId == 8) {
				$lastAction = $botAction;
			}
			if ($gameId == 11) {
				$lastAction = $botAction;
			}

			echo $botAction;
		}
	}

	mysql_close($link);
}
