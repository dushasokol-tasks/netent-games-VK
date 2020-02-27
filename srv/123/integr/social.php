<?
include("soc_func.php");

//@mysql_query("set names 'utf8'");

$graduse = '';
$feature_query = '';
$notif_str = '';

if (!isset($SFR)) $SFR = $_Social['free_rounds'];

$query = "SELECT * FROM ns.social_level where id='" . $_Social['level'] . "'";
$result = mysql_query($query);
$_Levels = mysql_fetch_assoc($result);


$curLevel = $_Social['level'];
$curAchievs = $_Social['achievs'];

$curSpins = $_Social['spins'];
$credsWin = $_Social['credsWin'];
$credsLost = $_Social['credsLost'];
$bustersUse = $_Social['bustersUse'];
$wheelUse = $_Social['wheelUse'];
$daysLogin = $_Social['daysLogin'];

$innerVars['curLevel'] = $curLevel;
$innerVars['curSpins'] = $curSpins;
$innerVars['credsWin'] = $_Social['credsWin'];
$innerVars['credsLost'] = $_Social['credsLost'];
$innerVars['bustersUse'] = $_Social['bustersUse'];
$innerVars['wheelUse'] = $_Social['wheelUse'];
$innerVars['daysLogin'] = $_Social['daysLogin'];
$innerVars['bigWin'] = $real_win;

if ($curLevel > 1) $innerVars['isVK'] = 1;


$today_formatted_date = date('d.m.Y');
$yesterday_formatted_date = date('d.m.Y', ($today_ts - 86400));

/*
$add_busters= array(
    "6" => "0","7" => "0","8" => "0",
    "9" => "0","10" => "0","11" => "0","12" => "0"
);
*/

$real_spin = 0;
//$questNotification=0;
$questNotification = '';
$dialyQuestComplete = 2;
$levelUp = 0;

$newLevelReward = '';
$dialyQuestReward_str = '';
$dialyReward_str = ''; //&&&???
//$newAchievReward_str='';

$tasksState_str = '';

//addME: wheel spin is no real spin
if ($lastAction != 'init' and $lastAction != 'paytable' and $lastAction != 'emptySpin' and $lastAction != 'widgetspin') {
	if ($gameId == 10 and ($anBetVarDB != '0' and $anBetVarDB != '1' and $anBetVarDB != '2')) //HL fix
		$_Social['exp'] += $spincost / 3;
	else
		$_Social['exp'] += $spincost;
	$_Social['credsLost'] += $spincost;
	$_Social['credsWin'] += $real_win;
	$_Social['spins']++;
	$_Social['cashBack'] += round($spincost * 0.07, 2);
	$cashBack = $_Social['cashBack'] * 100;
	$real_spin = 1;
	if ($gameId == 999 and $lastAction == 'endbonus') $_Social['wheelUse']++;
}

if ($_Social['freePurchase'] != $today_formatted_date) $haveFreePurchase = 1;
else $haveFreePurchase = 0;


///////////////////dialybon

if ($_Social['lastLogin'] != $today_formatted_date and $gameId != 0) //fixMe gameid
{
	//    echo "today first login";
	$temp = ($_Social['avaiableGames'] + 1) * 100;
	$query = "SELECT * FROM ns.social_quest where id<" . $temp . " order by id asc";
	$result = mysql_query($query);
	$i = 0;
	while ($quest = mysql_fetch_assoc($result)) {
		//	if($_Social['level']<20)//quest levelup <15 level
		{
			$quests[$i] = $quest;
			$i++;
		}
	}
	$i--;
	$pos1 = round(rand(0, $i));
	$ok = 0;
	do {
		$pos2 = round(rand(0, $i));
		if ($pos2 != $pos1) $ok = 1;
	} while ($ok == 0);
	$ok = 0;
	do {
		$pos3 = round(rand(0, $i));
		if ($pos3 != $pos1 and $pos3 != $pos2) $ok = 1;
	} while ($ok == 0);

	$temp = 0;
	$reward = makeEffects($quests[$pos1]['effect']);
	if ($reward['add_chips']) $temp += $reward['add_chips'];
	$reward = makeEffects($quests[$pos2]['effect']);
	if ($reward['add_chips']) $temp += $reward['add_chips'];
	$reward = makeEffects($quests[$pos3]['effect']);
	if ($reward['add_chips']) $temp += $reward['add_chips'];

	$temp += $curLevel * 100;
	$temp = "add_chips=" . $temp . ";";

	$query = "UPDATE ns.social_feat SET quest1Id=" . $quests[$pos1]['id'] . ", quest2Id=" . $quests[$pos2]['id'] . ", quest3Id=" . $quests[$pos3]['id'] . ", quest1Progress=0, quest2Progress=0, quest3Progress=0,
	 dialyQuestReward='" . $temp . "' WHERE id='" . $_GET['sessid'] . "'";
	$result = mysql_query($query);

	if ($_Social['lastLogin'] == $yesterday_formatted_date) {
		$_Social['daysLogin']++;
	} else {
		$_Social['daysLogin'] = 1;
	}
	$_Social['lastLogin'] = $today_formatted_date;

	if ($_Social['daysLogin'] > 7) $temp = 7;
	else $temp = $_Social['daysLogin'];

	$query = "SELECT * FROM ns.social_dialy where id=" . $temp;
	$result = mysql_query($query);
	$temp2 = mysql_fetch_assoc($result);
	$reward = makeEffects($temp2['effect']);
	$reward_msg = "";
	if ($reward['add_chips']) {
		$reward_msg .= "" . $reward['add_chips'] . " кредитов";
		$newCredit += $reward['add_chips'] * 100;
		$query2 = "UPDATE " . $DB2 . "." . $term_table . " set " . $creditCurrentWorld . "='" . ($newCredit / 100) . "' where id='" . $mainTerminalId . "';";
		$result2 = mysql_query($query2);
		$graduse .= "credit=" . $newCredit . "&";
		$social_logger .= " dialyChips " . $reward['add_chips'] . ";";
	}
	if ($reward['add_wheel']) {
		if ($reward_msg != '') $reward_msg .= " +";
		$reward_msg .= " " . $reward['add_wheel'] . " вращения колеса";
		$_Social['extra_wheel'] = $reward['add_wheel'];
		$social_logger .= " dialyWheel " . $reward['add_wheel'] . ";";
	}
	if ($temp == 7) $next_reward_msg = $reward_msg;
	else {
		$query = "SELECT * FROM ns.social_dialy where id=" . ($temp + 1);
		$result = mysql_query($query);
		$temp2 = mysql_fetch_assoc($result);
		$reward = makeEffects($temp2['effect']);
		$next_reward_msg = "";
		if ($reward['add_chips']) {
			$next_reward_msg .= "" . $reward['add_chips'] . " кредитов";
		}
		if ($reward['add_wheel']) {
			if ($next_reward_msg != '') $next_reward_msg .= " +";
			$next_reward_msg .= " " . $reward['add_wheel'] . " вращения колеса";
		}
	}

	//$dialyReward_str="Бонус ".$_Social['daysLogin']." дня ".$reward_msg."\n\nСледующий день\n".$next_reward_msg;

	//if($_GET['sessid']!='VK10637772')
	$graduse .= "gamestate.dialyReward=Бонус " . $_Social['daysLogin'] . " дня " . $reward_msg . "\n\nСледующий день\n" . $next_reward_msg . "&";

	///if($mainTerminalId=="VK10637772")
	///{
	for ($i = 1; $i < 6; $i++)
		if ($bt['credit' . $i] < 50) {
			$query2 = "UPDATE " . $DB2 . "." . $term_table . " set credit" . $i . "=100 where id='" . $mainTerminalId . "';";
			$result2 = mysql_query($query2);
		}
	if ($bt['credit'] < 50) {
		$query2 = "UPDATE " . $DB2 . "." . $term_table . " set credit=100 where id='" . $mainTerminalId . "';";
		$result2 = mysql_query($query2);
	}
	///}
}


////////////levelup
$exp_delta = $_Levels['endExp'] - $_Social['startExp'];
if ($_Social['exp'] >= $exp_delta) {
	$levelUp = 1;
	$reward = makeEffects($_Levels['effect']);

	$reward_msg = "НАГРАДА";
	if ($reward['add_chips']) {
		$reward_msg .= "\n\n" . $reward['add_chips'] . " кредитов";
		$newCredit += $reward['add_chips'] * 100;
		//	    $query2="UPDATE ".$DB2.".".$term_table." set credit='".($newCredit/100)."' where id='".$_GET['sessid']."';";
		$query2 = "UPDATE " . $DB2 . "." . $term_table . " set " . $creditCurrentWorld . "='" . ($newCredit / 100) . "' where id='" . $mainTerminalId . "';";
		$result2 = mysql_query($query2);
		$social_logger .= " levelChips " . $reward['add_chips'] . ";";
	}
	if ($reward['open_game']) {
		//	    $reward_msg.=" + новая игра";
		$_Social['avaiableGames']++;
		$query2 = "UPDATE ns.social_main set avaiableGames='" . $_Social['avaiableGames'] . "' where id='" . $_GET['sessid'] . "';";
		$result2 = mysql_query($query2);
		$social_logger .= " levelGame " . $_Social['avaiableGames'] . ";";
	}
	if ($reward['add_denom']) {
		$reward_msg .= " + увеличена деноминация";
		$_Social['denomLevel']++;
		$query2 = "UPDATE ns.social_main set denomLevel='" . $_Social['denomLevel'] . "' where id='" . $_GET['sessid'] . "';";
		$result2 = mysql_query($query2);
		$social_logger .= " levelDenom " . $_Social['denomLevel'] . ";";
	}

	if ($reward['add_buster']) {
		$query2 = "SELECT * from ns.social_items where id='" . $reward['add_buster'] . "';";
		$result2 = mysql_query($query2);
		$_Buster = mysql_fetch_assoc($result2);
		$reward_msg .= " + " . $_Buster['name'];
		$temp = 'busterWin' . $reward['add_buster'];
		$$temp++;
		$social_logger .= " levelBuster " . $reward['add_buster'] . ";";
	}

	/*
	if($reward['get_achiev'])
	{
	    $reward_msg.=" + новая игра";
	    $_Social['avaiableGames']++;
	    $query2="UPDATE ns.social_main set avaiableGames='".$_Social['avaiableGames']."' where id='".$_GET['sessid']."';";
////	    $result2 = mysql_query($query2);
	}
*/
	$_Social['level']++;
	$curLevel++;
	$query = "SELECT * FROM ns.social_level where id='" . $_Social['level'] . "'";
	$result = mysql_query($query);
	$_Levels = mysql_fetch_assoc($result);

	$newLevelReward = $reward_msg;

	//if($_GET['sessid']!='VK10637772' and $_GET['sessid']!='VK532248891')
	if ($_Social['tutorStep'] != 0 and $_Social['tutorStep'] <= 5)    $graduse .= "gamestate.newLevelReward=" . $reward_msg . "&";
}


//////////////////////achievs
$query = '';
$newAchievRewards = [];
$newAchievId = '';
$temp = explode(",", $curAchievs);
foreach ($temp as $e => $v) if ($query == '') $query = "id!=" . $v;
else $query .= " and id!=" . $v;
//if($query=='id!=')$query='1';

$query = "SELECT * FROM ns.social_achievs where $query";
$result = mysql_query($query);
while ($_Achievs = mysql_fetch_assoc($result)) {


	$achieve_complete = checkConditions3($_Achievs['condit'], $innerVars);
	//    $achieve_complete=checkConditions($_Achievs['condit'],$credsWin,$curLevel,$questSpins,$questWin,$bustersUse);

	if ($achieve_complete == 1) {
		$reward_msg = $_Achievs['name'];
		$social_logger .= " gotAchiev " . $_Achievs['name'] . ";";
		if ($_Achievs['effect'] != '') {
			$reward = makeEffects($_Achievs['effect']);
			if ($reward['add_chips']) {
				$reward_msg .= "\n\n" . $reward['add_chips'] . " кредитов";
				$newCredit += $reward['add_chips'] * 100;
				//	    $query2="UPDATE ".$DB2.".".$term_table." set credit='".($newCredit/100)."' where id='".$_GET['sessid']."';";
				$query2 = "UPDATE " . $DB2 . "." . $term_table . " set " . $creditCurrentWorld . "='" . ($newCredit / 100) . "' where id='" . $mainTerminalId . "';";
				$result2 = mysql_query($query2);
				$social_logger .= " achievChips " . $reward['add_chips'] . ";";
			}
			if ($reward['add_buster']) {
				$query2 = "SELECT * from ns.social_items where id='" . $reward['add_buster'] . "';";
				$result2 = mysql_query($query2);
				$_Buster = mysql_fetch_assoc($result2);
				$reward_msg .= "\n\n" . $_Buster['name'];
				$temp = 'busterWin' . $reward['add_buster'];
				$$temp++;
				$social_logger .= " achievBuster " . $reward['add_buster'] . ";";
			}
		} else $reward_msg .= "\n\n" . $_Achievs['descr_effect'];

		$newAchievReward = $reward_msg;
		array_push($newAchievRewards, $newAchievReward);
		$_Social['achievs'] .= "," . $_Achievs['id'];

		//    if($_GET['sessid']!='VK10637772'  and $_GET['sessid']!='VK532248891')
		if ($_Social['tutorStep'] != 0 and $_Social['tutorStep'] <= 5)	$graduse .= "gamestate.newAchievReward=" . $reward_msg . "&"; ///del

		if ($newAchievId == '') $newAchievId = $_Achievs['id'];
		else $newAchievId .= ',' . $_Achievs['id'];
	}
}

if ($newAchievId != '')	$graduse .= "gamestate.newAchievId=" . $newAchievId . "&";

$exp_to_lobby = $_Social['exp'];
$_Levels['endExp'] -= $_Levels['startExp'];
$exp_to_lobby -= $_Levels['startExp'];


////////////////quests
$query2 = '';
for ($i = 1; $i < 4; $i++) {
	$temp = "quest" . $i . "Id";
	$query = "SELECT * FROM ns.social_quest where id=" . $_Features[$temp];
	$result = mysql_query($query);
	$_QuestDist[$i] = mysql_fetch_assoc($result);

	$temp3 = explode(":", $_QuestDist[$i]['condit']);

	$temp = "quest" . $i . "Progress";
	$temp2 = "quest" . $i;
	$$temp2 = "status";

	if ($temp3[0] == 'useBuster') {
		$questWins = $_Features[$temp];
		if ($questWins != 'done' and $real_spin == 1) {
			$dialyQuestComplete = 0;
			if ($_Social['activeBuster'] != '') $achieve_complete = 1;
			if ($achieve_complete == 1) {
				$_Features[$temp] = 'done';
				//		    $questNotification=1;
				$questNotification = 'plugin';
			} else $_Features[$temp] = $questWin;
			if ($query2 == '') $query2 = $temp . "='" . $_Features[$temp] . "'";
			else $query2 .= ", " . $temp . "='" . $_Features[$temp] . "'";
		}
	}

	if ($temp3[0] == 'questWin') {
		$questWins = $_Features[$temp];
		if ($questWins != 'done' and $real_spin == 1) {
			$dialyQuestComplete = 0;
			$questWin = $real_win;
			$achieve_complete = checkConditions($_QuestDist[$i]['condit'], $credsWin, $curLevel, $questSpins, $questWin);
			if ($achieve_complete == 1) {
				$_Features[$temp] = 'done';
				$questNotification = 'plugin';
			} else $_Features[$temp] = $questWin;
			if ($query2 == '') $query2 = $temp . "='" . $_Features[$temp] . "'";
			else $query2 .= ", " . $temp . "='" . $_Features[$temp] . "'";
		}
	}
	if ($temp3[0] == 'questSpins') {
		$questSpins = $_Features[$temp];
		if ($questSpins != 'done' and $real_spin == 1) {
			$dialyQuestComplete = 0;
			$questSpins++;
			$achieve_complete = checkConditions($_QuestDist[$i]['condit'], $credsWin, $curLevel, $questSpins);
			if ($achieve_complete == 1) {
				$_Features[$temp] = 'done';
				$questNotification = 'plugin';
			} else $_Features[$temp] = $questSpins;
			if ($query2 == '') $query2 = $temp . "='" . $_Features[$temp] . "'";
			else $query2 .= ", " . $temp . "='" . $_Features[$temp] . "'";
		}
	}
	if ($temp3[0] == 'levelUp') {
		if ($_Features[$temp] != 'done' and $real_spin == 1) {
			$dialyQuestComplete = 0;
			if ($levelUp == 1) {
				$_Features[$temp] = 'done';
				$questNotification = 'plugin';
			}
			if ($query2 == '') $query2 = $temp . "='" . $_Features[$temp] . "'";
			else $query2 .= ", " . $temp . "='" . $_Features[$temp] . "'";
		}
	}

	if ($temp3[0] == 'wheelSpin') {
		$questSpins = $_Features[$temp];
		if ($questSpins != 'done' and $real_spin == 1 and $gameId == 999 and $lastAction == 'endbonus') {
			$questSpins++;
			$dialyQuestComplete = 0;
			$universalVars[$temp3[0]] = $questSpins;
			$achieve_complete = checkConditions2($_QuestDist[$i]['condit'], $universalVars);
			if ($achieve_complete == 1) {
				$_Features[$temp] = 'done';
				$questNotification = 'plugin';
			} else $_Features[$temp] = $questSpins;
			if ($query2 == '') $query2 = $temp . "='" . $_Features[$temp] . "'";
			else $query2 .= ", " . $temp . "='" . $_Features[$temp] . "'";
		}
	}

	if ($temp3[0] == 'Event' and $_Features[$temp] != 'done') {
		include('questEvents.php');
		if ($achieve_complete == 1) {
			$_Features[$temp] = 'done';
			$questNotification = 'plugin';
		}
		if ($query2 == '') $query2 = $temp . "='" . $_Features[$temp] . "'";
		else $query2 .= ", " . $temp . "='" . $_Features[$temp] . "'";
	}


	if ($_Features[$temp] == '0')    $$temp2 .= ":0,descr:Не начато,task:" . $_QuestDist[$i]['descr'];
	elseif ($_Features[$temp] == 'done') $$temp2 .= ":2,descr:Завершено,task:" . $_QuestDist[$i]['descr'];
	else $$temp2 .= ":1,descr:прогресс " . $_Features[$temp] . " из " . $temp3[2] . ",task:" . $_QuestDist[$i]['descr'];
}

$reward = makeEffects($_Features['dialyQuestReward']);
$questreward = "Награда";
if ($reward['add_chips']) {
	$questreward .= " " . $reward['add_chips'] . " кредитов";
	$qr[] = " " . $reward['add_chips'] . " кредитов";
}

if ($_Features['quest1Progress'] === 'done' and $_Features['quest2Progress'] === 'done' and $_Features['quest3Progress'] === 'done' and $dialyQuestComplete == 0) {
	$dialyQuestReward_str = "НАГРАДА\n";
	//$graduse.="gamestate.dialyQuestReward=НАГРАДА\n";

	foreach ($qr as $e => $v) {
		$dialyQuestReward_str .= "\n" . $v;
		//	$graduse.="\n".$v;
		$social_logger .= " dialyQuest " . $v . ";";
	}
	//if($_GET['sessid']!='VK10637772'  and $_GET['sessid']!='VK532248891')$graduse.="gamestate.dialyQuestReward=".$dialyQuestReward_str."&";
	$questNotification = 'plugin';
}

if ($query2 != '') {
	$query2 = "UPDATE ns.social_feat set " . $query2 . " where id='" . $_GET['sessid'] . "';";
	$result = mysql_query($query2);
}

////busters
$busters = '';
$busters_str = '';
if (

	(isset($busterWin6) or isset($busterWin7) or isset($busterWin8) or isset($busterWin9) or isset($busterWin10) or isset($busterWin11) or isset($busterWin12))
	and ($gameId != 999 or ($gameId == 999 and $lastAction != "freespin"))

	//or ($gameId==999 and $lastAction=="endfreespin")
)

////add busters
{
	$temp = explode(',', $_Social['inventory']);
	//		$tmp2='busterWin'.$i;
	//		if(isset($$tmp2))$answ.=$tmp2."=".$$tmp2.";";
	foreach ($temp as $e => $v) if ($v != '') {
		$temp2 = explode(':', $v);

		//		if($busters_str=='')$busters_str=$temp2[0].":".$temp2[1]; else $busters_str.=",".$temp2[0].":".$temp2[1];
		$bstrs[$temp2[0]] = $temp2[1];
	}
	for ($i = 6; $i <= 12; $i++) {
		$tmp = 'busterWin' . $i;
		if (isset($$tmp)) {
			$bstrs[$i] += $$tmp;
			$social_logger .= " gameAddBuster " . $i . "=" . $$tmp . ";";
		}
	}
	foreach ($bstrs as $e => $v) if ($v != '') {
		if ($busters_str == '') $busters_str = $e . ":" . $v;
		else $busters_str .= "," . $e . ":" . $v;
	}
	$_Social['inventory'] = $busters_str;
}

$temp = explode(',', $_Social['inventory']);

foreach ($temp as $e => $v) if ($v != '') {
	$temp2 = explode(':', $v);

	if ($busters == '') $busters = "item" . $temp2[0] . ":" . $temp2[1];
	else $busters .= ",item" . $temp2[0] . ":" . $temp2[1];
}


////wheels
if ($lastAction == 'startbonus' and $wheel_tries > 0) {
	if ($_Social['extra_wheel'] > 0) $_Social['extra_wheel']--;
	else {
		$_Features['wheelTime'] = $today_ts;
		$feature_query = "wheelTime='" . $_Features['wheelTime'] . "'";
	}
}

if ($lastAction == 'startfreespin' and $buster_tries > 0) {
	$_Social['extra_busterspin'] = 0;
	if ($_Features['safeTime'] < 0) {
		$_Features['safeTime'] = $today_ts;
		$feature_query = "safeTime='" . $_Features['safeTime'] . "'";
	}
}
/////


if ($_Social['activeBuster'] != '') {
	$temp = explode(":", $_Social['activeBuster']);
	$activeBuster = $temp[0] . " " . $temp[1];
} else $activeBuster = 0;


//tutorial
$tutorial_output = '';
if ($_Social['tutorStep'] != 0 and ($lastAction == 'spin' or ($lastAction == 'endbonus' and $gameId == 999) or ($lastAction == 'endfreespin' and $gameId == 999) or $lastAction == 'emptySpin'))
	include('tutorial.php');



//world tasks
$reloadLobby = 0;
$newGameAdded = 0;
///if(($_GET['sessid']=='VK10637772' or $_GET['sessid']=='VK532248891') and $real_spin==1)
if ($real_spin == 1) {
	$fullTaskObj = json_decode($_Features['tasksState']);
	$worldComplete = 0;

	foreach ($fullTaskObj->cards as $e => $v) {
		$taskObj = $v;
		if (isset($taskObj->id)) {
			if ($avGS[$taskObj->id] == 2) {
				$worldComplete++;
			}
			if ($taskObj->id == $gameId) {
				if ($avGS[$gameId] != 1) { //echo "<b>CARD is NOT 1 STATUS</b><br>";
				} else {
					if ($taskObj->gameBigwin > 0) $taskObj->gameWinSpins += 1;
					else $taskObj->gameWinSpins = 0;
					if ($_Social['activeBuster'] != '' and $ajaxAction != 'usebuster') $taskObj->gameBSpins += 1; ////////////fixme adds gameBspins in usebuster

					$taskObj->gameSpins += 1;
					$taskObj->gameFullwin += $real_win;
					$taskObj->gameBigwin = $real_win;

					$taskVars['gameSpins'] = $taskObj->gameSpins;
					$taskVars['gameBSpins'] = $taskObj->gameBSpins;
					$taskVars['gameBigwin'] = $taskObj->gameBigwin;
					$taskVars['gameFullwin'] = $taskObj->gameFullwin;
					$taskVars['curLevel'] = $curLevel;

					$taskVars['gameWinSpins'] = $taskObj->gameWinSpins;

					if ($lastAction == "initfreespin") {
						$taskObj->gameInitFs += 1;
					}
					$taskVars['gameInitFs'] = $taskObj->gameInitFs;

					if ($lastAction == "freespin" or $lastAction == "endfreespin") {
						$taskObj->gameFs += 1;
					}
					$taskVars['gameFs'] = $taskObj->gameFs;

					if (isset($freeRoundsLeft) and $freeRoundsLeft > 0) $taskVars['gameFrounds'] = 1;

					//usort for multi???
					foreach ($_Events as $e1 => $v1)
						$taskVars['Event'] = $e1;

					$currentCardStatus = new stdClass();
					$query = "SELECT * FROM ns.social_tasks where card='$gameId'";
					$result = mysql_query($query);
					$cardComplete = 1;
					$newCompleteTask = 0;

					while ($temp = mysql_fetch_assoc($result)) {
						$_Tasks[$temp['card']][$temp['taskNum']] = $temp;
						$task_complete = checkConditions3($_Tasks[$gameId][$temp['taskNum']]['condit'], $taskVars);
						if ($task_complete == 1 and $taskObj->stats->{$temp['taskNum']}->status != 2) {
							$newCompleteTask = 1;
							$taskObj->stats->{$temp['taskNum']}->status = 2;
							$taskObj->stats->{$temp['taskNum']}->perc = 100;

							$questNotification = 'plugin'; //////////////
						} elseif ($taskObj->stats->{$temp['taskNum']}->status != 2) {
							if ($taskObj->stats->{$temp['taskNum']}->status == 0) $taskObj->stats->{$temp['taskNum']}->status = 1;
							$taskObj->stats->{$temp['taskNum']}->perc = discoverTaskProgress($_Tasks[$gameId][$temp['taskNum']]['condit'], $taskVars);
							$cardComplete = 0;
						}
						$currentCardStatus->{$temp['taskNum']}->status = $taskObj->stats->{$temp['taskNum']}->status;
						$currentCardStatus->{$temp['taskNum']}->perc = $taskObj->stats->{$temp['taskNum']}->perc;
					}

					$worldComplete += $cardComplete;
					if ($cardComplete == 1) {
						$avGamesStatus_str = '';

						$reward = makeEffects($_Game['effect']);
						if ($reward['game_status']) {
							foreach ($reward['game_status'] as $e1 => $v1) {
								$avGS[$e1] = $v1;
								if ($v1 == 1) $newGameAdded = $e1;
							}
						}
						if ($reward['if_game_status']) {
							if ($avGS[$reward['if_game_status']] == 0) $avGS[$reward['if_game_status']] = -1;
							elseif ($avGS[$reward['if_game_status']] == -1) {
								$avGS[$reward['if_game_status']] = 1;
								$newGameAdded = $reward['if_game_status'];
							}
						}

						if ($reward['next_world_deposit']) {
							$result = mysql_query("UPDATE " . $DB2 . "." . $term_table . " set credit" . ($_Game['world'] + 1) . "=credit" . ($_Game['world'] + 1) . " + " . $reward['next_world_deposit'] . " where id='" . $mainTerminalId . "';");
						}
					}
					$fullTaskObj->cards[$e] = $taskObj;

					$tasksState_str = json_encode($fullTaskObj);
				}
			}
		}
	}

	if ($worldComplete == ($e + 1)) {
		$tasksState_str = '';
		$query = "SELECT * FROM ns.social_games where world='" . ($_Game['world'] + 1) . "' order by id";
		$result = mysql_query($query);
		$i = 0;
		$tasksState_str = '';
		while ($temp = mysql_fetch_assoc($result)) {
			$tasksState_str .= makeNewWorldJson($temp['id']) . ",";
			if (!isset($avGS[$temp['id']])) $avGS[$temp['id']] = 0;
			$i++;
		}
		$tasksState_str = substr($tasksState_str, 0, -1);
		$tasksState_str = '{"cards": [' . $tasksState_str . ']}';
	}

	foreach ($avGS as $e1 => $v1) {
		$avGamesStatus_str .= "$e1:$v1,";
	}
	$avGamesStatus_str = substr($avGamesStatus_str, 0, -1);
	$_Social['avGamesStatus'] = $avGamesStatus_str;
}



///queries

$query = "level='" . $_Social['level'] . "'";
$query .= ", exp='" . $_Social['exp'] . "'";
$query .= ", achievs='" . $_Social['achievs'] . "'";
if ($tutorial_output != '' or $_Social['tutorStep'] == -2) {
	if ($_Social['tutorStep'] == -2) {
		$_Social['tutorStep'] = 0;
		$newGameAdded = 2;
		$_Social['avGamesStatus'] = '0:2,1:2,2:1,3:0,4:0';
		$tasksState_str = '{"cards":[{"id":"2","gameSpins":0,"gameBSpins":0,"gameWinSpins":0,"gameBigwin":0,"gameFullwin":0,"gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":0,"status":0},"1":{"perc":0,"status":0},"2":{"perc":0,"status":0}}},{"id":"3","gameSpins":"0","gameBSpins":0,"gameWinSpins":0,"gameBigwin":"0","gameFullwin":"0","gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":"0","status":"0"},"1":{"perc":"0","status":"0"},"2":{"perc":"0","status":"0"}}},{"id":"4","gameSpins":"0","gameBSpins":0,"gameWinSpins":0,"gameBigwin":"0","gameFullwin":"0","gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":"0","status":"0"},"1":{"perc":"0","status":"0"},"2":{"perc":"0","status":"0"}}}]}';
		$result = mysql_query("UPDATE " . $DB2 . "." . $term_table . " set credit1=" . $creditCurrentWorld . "+100 where id='" . $mainTerminalId . "';");
		$newCredit += 100;
	} elseif ($_Social['tutorStep'] == 9 and $gameId == 999) {
		$newGameAdded = 2;
		$_Social['avGamesStatus'] = '0:2,1:2,2:1,3:0,4:0';
		$tasksState_str = '{"cards":[{"id":"2","gameSpins":0,"gameBSpins":0,"gameWinSpins":0,"gameBigwin":0,"gameFullwin":0,"gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":0,"status":0},"1":{"perc":0,"status":0},"2":{"perc":0,"status":0}}},{"id":"3","gameSpins":"0","gameBSpins":0,"gameWinSpins":0,"gameBigwin":"0","gameFullwin":"0","gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":"0","status":"0"},"1":{"perc":"0","status":"0"},"2":{"perc":"0","status":"0"}}},{"id":"4","gameSpins":"0","gameBSpins":0,"gameWinSpins":0,"gameBigwin":"0","gameFullwin":"0","gameInitFs":0,"gameFs":0,"stats":{"0":{"perc":"0","status":"0"},"1":{"perc":"0","status":"0"},"2":{"perc":"0","status":"0"}}}]}';
		$result = mysql_query("UPDATE " . $DB2 . "." . $term_table . " set credit1='100' where id='" . $mainTerminalId . "';");
	}
	$query .= ", tutorStep='" . $_Social['tutorStep'] . "'";
}
$query .= ", avaiableGames='" . $_Social['avaiableGames'] . "'";
$query .= ", avGamesStatus='" . $_Social['avGamesStatus'] . "'";
$query .= ", denomLevel='" . $_Social['denomLevel'] . "'";
$query .= ", inventory='" . $_Social['inventory'] . "'";
$query .= ", activeBuster='" . $_Social['activeBuster'] . "'";

$query .= ", lastLogin='" . $_Social['lastLogin'] . "'";
$query .= ", daysLogin='" . $_Social['daysLogin'] . "'";

$query .= ", spins='" . $_Social['spins'] . "'";
$query .= ", credsWin='" . $_Social['credsWin'] . "'";
$query .= ", credsLost='" . $_Social['credsLost'] . "'";
$query .= ", cashBack='" . $_Social['cashBack'] . "'";
$query .= ", wheelUse='" . $_Social['wheelUse'] . "'";

$query .= ", extra_busterspin='" . $_Social['extra_busterspin'] . "'";
$query .= ", extra_wheel='" . $_Social['extra_wheel'] . "'";
$query .= ", free_rounds='" . $_Social['free_rounds'] . "'";





if (
	//($_GET['sessid']=='VK10637772' or $_GET['sessid']=='VK532248891') and 
	$real_spin == 1 or $lastAction == "emptySpin"
) {
	//echo $lastAction."<br><br>&";
	//$dialyQuestReward_str="Бонус ".$_Social['daysLogin']." дня ".$reward_msg."Следующий день".$next_reward_msg;

	// $notif_str='gamestate.notif=dialyQuest;none;3,dialyRew;none;text2&';
	/*
  if($dialyReward_str!='')
    if($_Social['notifQueue']=='')$_Social['notifQueue']="dialyRew;".$dialyReward_str.";none";
     else $_Social['notifQueue'].=",dialyRew;".$dialyReward_str.";none";
*/
	//$newGameAdded=3;

	if ($questNotification != '')
		if ($_Social['notifQueue'] == '') $_Social['notifQueue'] = "none;;" . $questNotification;
		else $_Social['notifQueue'] .= ",none;;" . $questNotification;

	if ($newLevelReward != '')
		if ($_Social['notifQueue'] == '') $_Social['notifQueue'] = "newLevel;" . $newLevelReward . ";none";
		else $_Social['notifQueue'] .= ",newLevel;" . $newLevelReward . ";none";
	if ($dialyQuestReward_str != '')
		if ($_Social['notifQueue'] == '') $_Social['notifQueue'] = "dialyQuest;" . $dialyQuestReward_str . ";both";
		else $_Social['notifQueue'] .= ",dialyQuest;" . $dialyQuestReward_str . ";both";
	if ($newAchievRewards)
		foreach ($newAchievRewards as $e => $v) {
			if ($_Social['notifQueue'] == '') $_Social['notifQueue'] = "newAchiev;" . $v . ";plugin";
			else $_Social['notifQueue'] .= ",newAchiev;" . $v . ";plugin";
		}

	if ($newGameAdded != 0)
		if ($_Social['notifQueue'] == '') $_Social['notifQueue'] = "newGame;" . $newGameAdded . ";plugin";
		else $_Social['notifQueue'] .= ",newGame;" . $newGameAdded . ";plugin";

	if ($lastAction == 'spin' or $lastAction == 'emptySpin' or ($gameId == 1 and $lastAction == 'respin') and $_Social['notifQueue'] != '') {
		$graduse .= "gamestate.notif=" . $_Social['notifQueue'] . "&";
		$_Social['notifQueue'] = '';
	}
	/*
    else
    {
	 if($_Social['notifQueue']=='')$_Social['notifQueue']=$notif_str;
	 else $_Social['notifQueue'].=",".$notif_str;
    }
*/
	//	    $_Social['notifQueue']='';
}
$query .= ", notifQueue='" . $_Social['notifQueue'] . "'";

$query = "UPDATE ns.social_main set " . $query . " where id='" . $_GET['sessid'] . "';";
$result = mysql_query($query);

//if($_GET['sessid']!='VK10637772'  and $_GET['sessid']!='VK532248891')
//{
// if($newGameAdded!=0)$graduse.="gamestate.newGame=".$newGameAdded."&";
//}

//if($_GET['sessid']=='VK10637772') echo "<br>$query<br>";

if ($tasksState_str != '') {
	if ($feature_query == '') $feature_query = "tasksState='" . $tasksState_str . "'";
	else $feature_query .= ", tasksState='" . $tasksState_str . "'";
}

if ($feature_query != '') {
	$query = "UPDATE ns.social_feat set " . $feature_query . " where id='" . $_GET['sessid'] . "';";
	$result = mysql_query($query);
}


///view

$graduse .= "gamestate.level=" . $_Social['level'] . "&gamestate.exp=" . $exp_to_lobby . "&gamestate.endExp=" . $_Levels['endExp'] . "&";

$graduse .= "gamestate.avGames=" . $_Social['avaiableGames'] . "&";

$graduse .= "gamestate.wheelTime=" . $_Features['wheelTime'] . "&gamestate.wheelFullTime=" . $_Features['wheelFullTime'] . "&";
$graduse .= "gamestate.safeTime=" . $_Features['safeTime'] . "&gamestate.safeFullTime=" . $_Features['safeFullTime'] . "&";
$graduse .= "gamestate.busters=" . $busters . "&";
$graduse .= "gamestate.activeBuster=" . $activeBuster . "&";
$graduse .= "gamestate.tillFS=" . $freerounds . "&";

$graduse .= "gamestate.haveFreePurchase=" . $haveFreePurchase . "&";

$graduse .= "gamestate.questreward=" . $questreward . "&";
$graduse .= "gamestate.quest1=" . $quest1 . "&";
$graduse .= "gamestate.quest2=" . $quest2 . "&";
$graduse .= "gamestate.quest3=" . $quest3 . "&";

$graduse .= $tutorial_output;

///////if($questNotification!=0)$graduse.="gamestate.questNotification=".$questNotification."&";

if ($currentCardStatus != new stdClass()) {
	$temp = '';
	foreach ($currentCardStatus as $e => $v) //echo "$e ".$v->perc."<br>";
		$temp .= "gamestate.cardState" . $e . "=status:" . $v->status . ",perc:" . $v->perc . "&";
	$graduse .= $temp;
}




////$graduse.="gamestate.newLevelReward=НАГРАДА \n\n 1000 кредитов \n 1 бустер&";
//$graduse.="gamestate.newAchievReward=НАГРАДА \n\n 100 кредитов&gamestate.newAchievId=2&";
////$graduse.="gamestate.dialyQuestReward=НАГРАДА \n\n 2000 кредитов\n 200 опыта&";
/////$graduse.="gamestate.newGameAvaiable=4&";
//$questreward="Награда 1000 кредитов";
//$quest1="status:2,descr:Завершено,task:Покрути колесо";
//$quest2="status:0,descr:Не начато,task:Выиграй 100 кредитов";
//$quest3="status:1,descr:прогресс 2 из 10,task:Писю нюхай";

///////
//if($lastAction!='init')
//if($gameId==12 and (($buster7=='ok') or ($lastAction=='reloadbalance') or ($lastAction=='init') or $lastAction=='paytable'))
//if($gameId==12 and (($buster7=='ok') or ($lastAction=='init') or $lastAction=='paytable'))
//if($gameId==12 and (($buster7=='ok')))
//{
/// $output.="<br>$buster7<br>";
// $temp=explode('&',$graduse);
// foreach($temp as $e=>$v)
//    $output.="$v<br>";
// $output.="<br><br>";
//}
//else
//{
$output .= "$graduse&";
//}




if ($social_logger != '') {
	$social_logs_table = 'ns.social_log';
	$hDate = date('H:i:s d-m-Y');
	$result = mysql_query("insert into " . $social_logs_table . "
    (id,	termName,		ts,		time,		gameId,		payrate,	action,								events,			credit_old,		new_cred) values
    ('',	'" . $_GET['sessid'] . "',	'" . time() . "',	'" . $hDate . "',	'" . $gameId . "',	'" . $payRate . "', '" . $lastAction . "([" . $_GET['action'] . "]{" . $lastActionDB . "})',	'" . $social_logger . "',	'" . $old_credit . "',	'" . $credit . "');
    ");
}


//echo "&&&&";
