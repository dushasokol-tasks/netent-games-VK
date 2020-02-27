<?
////////////////////////////////////////////////////////////////////////////////
//terminal settings init
////////////////////////////////////////////////////////////////////////////////

$result = mysql_query("SELECT * FROM ns.common where sessionId='" . $_GET['sessid'] . "';");
$st = mysql_fetch_assoc($result);

$lastActivity = $st['activity'];

$betDB = $st['bet'];
$linesDB = $st['lines'];
$denomDB = $st['denom'];
$anBetVarDB = $st['anBetVar'];

$payRate = $st['payRate'];

$playerCurrencyIso = $st['playerCurrencyIso'];
$playerCurrency = $st['playerCurrency'];
$jpCurrencyIso = $st['jpCurrencyIso'];
$jpCurrency = $st['jpCurrency'];
$widgetOn = $st['widgetOn'];

if (!isset($clientId)) $clientId = $st['clientId'];
if (!isset($ownerId)) $ownerId = $st['ownerId'];

$wavecount = '1';
$multiplier = '1';
$gameover = 'true';

$total_win = 0;
$game_win = 0;

$betted_full = $st['betted_full'];
$winned_full = $st['winned_full'];

$gameIdDB = $st['gameId'];

$query = "SELECT * FROM ns.social_main where id='" . $_GET['sessid'] . "'";
$result = mysql_query($query);
$_Social = mysql_fetch_assoc($result);
$cashBack = $_Social['cashBack'] * 100;
if ($_Social) {
    $social_logger = '';
    $query = "SELECT * FROM ns.social_feat where id='" . $_GET['sessid'] . "'";
    $result = mysql_query($query);
    $_Features = mysql_fetch_assoc($result);
    $_Features['wheelTime'] = $_Features['wheelFullTime'] - ($today_ts - $_Features['wheelTime']);
    $_Features['safeTime'] = $_Features['safeFullTime'] - ($today_ts - $_Features['safeTime']);
}

////////////////////////////////////////////////////////////////////////////////
//slot init
////////////////////////////////////////////////////////////////////////////////
$result = mysql_query("SELECT * FROM ns.symbols where gameId='" . $gameId . "' order by combination asc;");
$i = 0;
while ($row = mysql_fetch_assoc($result)) {
    for ($j = 0; $j < 16; $j++)
        $lineWinMarix[$row['combination']][$j] = $row[$j];
}



$total_winCents = 0;
