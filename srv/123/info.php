<?
include('../dbConnect.php');
$link = mysql_connect($db_host, $db_user, $db_pass);

//echo "SELECT jpCurrencyIso FROM ns.common where sessionId='".$mainTerminalId."';<br>";

$result = mysql_query("SELECT jpCurrencyIso FROM ns.common where sessionId='" . $_GET['sessid'] . "';");
//$result = mysql_query("SELECT jpCurrencyIso FROM ns.common where sessionId='".$mainTerminalId."';");
$st = mysql_fetch_assoc($result);

$jpCurrencyIso = $st['jpCurrencyIso'];

$output .= "jackpot.megafortunedreams_major." . $jpCurrencyIso . ".amount-30s=500000&";
$output .= "jackpot.megafortunedreams_major." . $jpCurrencyIso . ".amount=500000&";
$output .= "jackpot.megafortunedreams_major." . $jpCurrencyIso . ".lastpayedout=0&";
$output .= "jackpot.megafortunedreams_mega." . $jpCurrencyIso . ".amount-30s=15000000&";
$output .= "jackpot.megafortunedreams_mega." . $jpCurrencyIso . ".amount=15000000&";
$output .= "jackpot.megafortunedreams_mega." . $jpCurrencyIso . ".lastpayedout=0&";
$output .= "jackpot.megafortunedreams_rapid." . $jpCurrencyIso . ".amount-30s=5000&";
$output .= "jackpot.megafortunedreams_rapid." . $jpCurrencyIso . ".amount=5000&";
$output .= "jackpot.megafortunedreams_rapid." . $jpCurrencyIso . ".lastpayedout=0&";

echo $output;
mysql_close($link);
//echo "jackpot.megafortunedreams_rapid.RUR.amount-30s=5000&jackpot.megafortunedreams_mega.RUR.amount-30s=15000000&jackpot.megafortunedreams_mega.RUR.lastpayedout=0&jackpot.megafortunedreams_major.RUR.amount=500000&jackpot.megafortunedreams_mega.RUR.nplayers=1&jackpot.megafortunedreams_mega.RUR.amount=15000000&jackpot.megafortunedreams_rapid.RUR.amount=5000&jackpot.megafortunedreams_rapid.RUR.lastpayedout=0&jackpot.megafortunedreams_major.RUR.nplayers=1&jackpot.megafortunedreams_major.RUR.amount-30s=500000&jackpot.megafortunedreams_major.RUR.lastpayedout=0&jackpot.megafortunedreams_rapid.RUR.nplayers=1&";
