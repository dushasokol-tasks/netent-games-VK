<?
$output .= "jackpotcurrencyiso=" . $jpCurrencyIso . "&";
$output .= "jackpotcurrency=" . $jpCurrency . "&";
$output .= "playercurrencyiso=" . $playerCurrencyIso . "&";
$output .= "playercurrency=" . $playerCurrencyIso . "&";

$output .= "isJackpotWin=false&";
$output .= "g4mode=false&";
$output .= "historybutton=false&";

$output .= "multiplier=" . $multiplier . "&";
$output .= "wavecount=" . $wavecount . "&";
$output .= "gameover=" . $gameover . "&";


$output .= "game.win.coins=" . ($totalWinsDB) . "&"; //xz

$output .= "game.win.cents=" . $total_win . "&";

if ($lastAction == "freespin") $output .= "totalwin.coins=" . ($fs_totalwin) . "&";
elseif ($lastAction == "bonusaction") $output .= "totalwin.coins=" . ($bonus_totalwin) . "&";
elseif ($lastAction == "endbonus") $output .= "totalwin.coins=" . ($bonus_totalwin) . "&";
else  $output .= "totalwin.coins=" . ($totalWinsDB) . "&";

$output .= "totalwin.cents=" . ($total_winCents) . "&"; //pishet vnizu

$output .= "game.win.amount=" . $total_win . "&"; // huynya

if ($_GET['action'] != "init") $output .= "credit=" . $newCredit . "&";

$output .= "cashback=$cashBack&";
