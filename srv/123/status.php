<?
header('Access-Control-Allow-Origin: *');

$game = 'shangri';

include('../dbConnect.php');
$link = mysql_connect($db_host, $db_user, $db_pass);

$query = "select lastAction from ns.states where sessionId='" . $_GET['sessid'] . "';";

$result = mysql_query($query);

$res = mysql_fetch_assoc($result);

//    if($game=='jimi' and $res['lastAction']=='initfreespin') echo 'bonusaction';
//    elseif($game=='hansel' and $res['lastAction']=='bonusgame') echo 'bonusaction';
//     else
//    if($game=='hotline' and $res['lastAction']=='spin1') echo 'spin';
//    else  echo $res['lastAction'];

if ($game == 'mirror') {
	if ($res['lastAction'] == 'mirror') echo 'respin';
	elseif ($res['lastAction'] == 'mirror2') echo 'respin';
	elseif ($res['lastAction'] == 'mirrorFS') echo 'respin';

	elseif ($res['lastAction'] == 'lastrespin') echo 'freespin';

	elseif ($res['lastAction'] == 'symbol_overlay') echo 'spin';
	elseif ($res['lastAction'] == 'symbol_transform') echo 'spin';

	elseif ($res['lastAction'] == "fairy_pre_bonus") echo "bonus_feature_pick";

	elseif ($res['lastAction'] == "bonusgame") echo "bonusaction";
	elseif ($res['lastAction'] == "coin") echo "spin";

	elseif ($res['lastAction'] == "startfreespin") echo "freespin";
	elseif ($res['lastAction'] == "endfreespin") echo "spin";

	else echo $res['lastAction'];
}
if ($game == 'reelrush') {
	if ($res['lastAction'] == 'lastrespin') echo 'spin';
	elseif ($res['lastAction'] == 'lastrespin') echo 'spin';
	elseif ($res['lastAction'] == 'startfreespin') echo 'freespin';
	elseif ($res['lastAction'] == 'endfreespin') echo 'spin';
	else echo $res['lastAction'];
}
if ($game == 'bollywood') {
	if ($res['lastAction'] == 'lastrespin') echo 'spin';
	elseif ($res['lastAction'] == 'addfreespin') echo 'freespin';
	elseif ($res['lastAction'] == 'startfreespin') echo 'freespin';
	elseif ($res['lastAction'] == 'endfreespin') echo 'spin';
	else echo $res['lastAction'];
}
if ($game == 'shangri') {
	if ($res['lastAction'] == 'lastrespin') echo 'spin';
	elseif ($res['lastAction'] == 'addfreespin') echo 'freespin';
	elseif ($res['lastAction'] == 'startfreespin') echo 'freespin';
	elseif ($res['lastAction'] == 'endfreespin') echo 'spin';
	else echo $res['lastAction'];
}

mysql_close($link);
