<?
$output .= "jackpotcurrencyiso=" . $jpCurrencyIso . "&";
$output .= "jackpotcurrency=" . $jpCurrency . "&";
$output .= "playercurrencyiso=" . $playerCurrencyIso . "&";
$output .= "playercurrency=" . $playerCurrencyIso . "&";

$output .= "isJackpotWin=" . $isJackpotWin . "&";
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
//	    elseif($_GET['action']=='random_wilds_spin') $output.= "totalwin.coins=".($totalWinsDB+$total_win)."&";
//	    elseif($lastAction=="initfreespin") $output.= "game.win.coins=0&";
else  $output .= "totalwin.coins=" . ($totalWinsDB) . "&";

$output .= "totalwin.cents=" . ($total_winCents) . "&"; //pishet vnizu

$output .= "game.win.amount=" . $total_win . "&"; // huynya

if ($_GET['action'] != "init") $output .= "credit=" . $newCredit . "&";

$output .= "jackpot.megafortunedreams_major." . $jpCurrencyIso . ".amount-30s=500000&";
$output .= "jackpot.megafortunedreams_major." . $jpCurrencyIso . ".amount=500000&";
$output .= "jackpot.megafortunedreams_major." . $jpCurrencyIso . ".lastpayedout=" . $major_lastpayedout . "&";
$output .= "jackpot.megafortunedreams_mega." . $jpCurrencyIso . ".amount-30s=15000000&";
$output .= "jackpot.megafortunedreams_mega." . $jpCurrencyIso . ".amount=15000000&";
$output .= "jackpot.megafortunedreams_mega." . $jpCurrencyIso . ".lastpayedout=" . $mega_lastpayedout . "&";
$output .= "jackpot.megafortunedreams_rapid." . $jpCurrencyIso . ".amount-30s=5000&";
$output .= "jackpot.megafortunedreams_rapid." . $jpCurrencyIso . ".amount=5000&";
$output .= "jackpot.megafortunedreams_rapid." . $jpCurrencyIso . ".lastpayedout=" . $rapid_lastpayedout . "&";


$output .= "cashback=$cashBack&";
