<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";


if ($lastActionDB == "freespin" or $lastActionDB == "initfreespin") {

	$bonusInfo = explode(";", $answer);
	foreach ($bonusInfo as $e => $v)
		if ($v != '') {
			$a = explode("=", $v);
			$$a[0] = $a[1];
		}

	$gameover = "false";
	$restore = "true";
	$output .= "current.rs.i0=freespin&next.rs=freespin&";

	$gsStack = "basic%2Cfreespin";
	$gsCur = "freespin";
	$nesxAct = "freespin";
	$answ .= "restoreAction=freespin;" . $answer;


	$multiplier = $fs_multiplier;

	$output .= "freespins.denomination=1.000&";

	$output .= "freespins.initial=" . $fs_initial . "&";
	$output .= "freespins.total=" . $fs_total . "&";
	$output .= "freespins.left=" . $fs_left . "&";
	$output .= "freespins.played=" . $fs_played . "&";
	$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
	$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
	$output .= "freespins.win.cents=" . $fs_totalwin . "&";
	$output .= "freespins.win.coins=" . $fs_totalwin . "&";

	$output .= "freespins.betlevel=1&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.multiplier=1&";

	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24&";

	$table_locked = 1;
}


$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

if ($lastRsDB == '') {

	$lastRsDB = "rs.i0.r.i0.syms=SYM11%2CSYM12%2CSYM1&rs.i0.r.i1.syms=SYM9%2CSYM5%2CSYM7&rs.i0.r.i2.syms=SYM11%2CSYM12%2CSYM1&rs.i0.r.i3.syms=SYM12%2CSYM5%2CSYM9&rs.i0.r.i4.syms=SYM9%2CSYM3%2CSYM10&";
}

$output .= $lastRsDB;


$output = "";
$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "autoplayLossLimitEnabled=false&";
//$output.= "betlevel.all=1%2C2%2C3%2C4&";
//$output.= "betlevel.standard=5&";
$output .= "betlevel.all=1&";
$output .= "betlevel.standard=1&";
$output .= "bl.i0.coins=1&";
$output .= "bl.i0.id=0&";
$output .= "bl.i0.line=1%2C1%2C1%2C1%2C1&";
$output .= "bl.i0.reelset=ALL&";
/*
$output.= "bl.i1.coins=1&";
$output.= "bl.i1.id=1&";
$output.= "bl.i1.line=0%2C0%2C0%2C0%2C0&";
$output.= "bl.i1.reelset=ALL&";
$output.= "bl.i10.coins=1&";
$output.= "bl.i10.id=10&";
$output.= "bl.i10.line=1%2C2%2C1%2C2%2C1&";
$output.= "bl.i10.reelset=ALL&";
$output.= "bl.i11.coins=1&";
$output.= "bl.i11.id=11&";
$output.= "bl.i11.line=0%2C1%2C0%2C1%2C0&";
$output.= "bl.i11.reelset=ALL&";
$output.= "bl.i12.coins=1&";
$output.= "bl.i12.id=12&";
$output.= "bl.i12.line=2%2C1%2C2%2C1%2C2&";
$output.= "bl.i12.reelset=ALL&";
$output.= "bl.i13.coins=1&";
$output.= "bl.i13.id=13&";
$output.= "bl.i13.line=1%2C1%2C0%2C1%2C1&";
$output.= "bl.i13.reelset=ALL&";
$output.= "bl.i14.coins=1&";
$output.= "bl.i14.id=14&";
$output.= "bl.i14.line=1%2C1%2C2%2C1%2C1&";
$output.= "bl.i14.reelset=ALL&";
$output.= "bl.i15.coins=1&";
$output.= "bl.i15.id=15&";
$output.= "bl.i15.line=0%2C1%2C1%2C1%2C0&";
$output.= "bl.i15.reelset=ALL&";
$output.= "bl.i16.coins=1&";
$output.= "bl.i16.id=16&";
$output.= "bl.i16.line=2%2C1%2C1%2C1%2C2&";
$output.= "bl.i16.reelset=ALL&";
$output.= "bl.i17.coins=1&";
$output.= "bl.i17.id=17&";
$output.= "bl.i17.line=0%2C2%2C0%2C2%2C0&";
$output.= "bl.i17.reelset=ALL&";
$output.= "bl.i18.coins=1&";
$output.= "bl.i18.id=18&";
$output.= "bl.i18.line=2%2C0%2C2%2C0%2C2&";
$output.= "bl.i18.reelset=ALL&";
$output.= "bl.i19.coins=1&";
$output.= "bl.i19.id=19&";
$output.= "bl.i19.line=0%2C2%2C2%2C2%2C0&";
$output.= "bl.i19.reelset=ALL&";
$output.= "bl.i2.coins=1&";
$output.= "bl.i2.id=2&";
$output.= "bl.i2.line=2%2C2%2C2%2C2%2C2&";
$output.= "bl.i2.reelset=ALL&";
$output.= "bl.i3.coins=1&";
$output.= "bl.i3.id=3&";
$output.= "bl.i3.line=0%2C1%2C2%2C1%2C0&";
$output.= "bl.i3.reelset=ALL&";
$output.= "bl.i4.coins=1&";
$output.= "bl.i4.id=4&";
$output.= "bl.i4.line=2%2C1%2C0%2C1%2C2&";
$output.= "bl.i4.reelset=ALL&";
$output.= "bl.i5.coins=1&";
$output.= "bl.i5.id=5&";
$output.= "bl.i5.line=0%2C0%2C1%2C0%2C0&";
$output.= "bl.i5.reelset=ALL&";
$output.= "bl.i6.coins=1&";
$output.= "bl.i6.id=6&";
$output.= "bl.i6.line=2%2C2%2C1%2C2%2C2&";
$output.= "bl.i6.reelset=ALL&";
$output.= "bl.i7.coins=1&";
$output.= "bl.i7.id=7&";
$output.= "bl.i7.line=1%2C2%2C2%2C2%2C1&";
$output.= "bl.i7.reelset=ALL&";
$output.= "bl.i8.coins=1&";
$output.= "bl.i8.id=8&";
$output.= "bl.i8.line=1%2C0%2C0%2C0%2C1&";
$output.= "bl.i8.reelset=ALL&";
$output.= "bl.i9.coins=1&";
$output.= "bl.i9.id=9&";
$output.= "bl.i9.line=1%2C0%2C1%2C0%2C1&";
$output.= "bl.i9.reelset=ALL&";
$output.= "bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
$output.= "casinoID=netent&";
*/
$output .= "bl.standard=0&";
$output .= "clientaction=init&";
$output .= "confirmBetMessageEnabled=false&";
//$output.= "denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100&";
$output .= "denomination.all=100&";
$output .= "denomination.standard=100&";
$output .= "g4mode=false&";
$output .= "game.win.amount=null&";
$output .= "game.win.cents=0&";
$output .= "game.win.coins=0&";
$output .= "gameEventSetters.enabled=false&";
$output .= "gameover=true&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "%2F&";

$output .= "gamestate.current=basic&";

$output .= "historybutton=false&";
$output .= "isJackpotWin=false&";
/*
$output.= "jackpot.megafortunedreams_major.RUR.amount-30s=500000&";
$output.= "jackpot.megafortunedreams_major.RUR.amount=500000&";
$output.= "jackpot.megafortunedreams_major.RUR.lastpayedout=0&";
$output.= "jackpot.megafortunedreams_mega.RUR.amount-30s=15000000&";
$output.= "jackpot.megafortunedreams_mega.RUR.amount=15000000&";
$output.= "jackpot.megafortunedreams_mega.RUR.lastpayedout=0&";
$output.= "jackpot.megafortunedreams_rapid.RUR.amount-30s=5000&";
$output.= "jackpot.megafortunedreams_rapid.RUR.amount=5000&";
$output.= "jackpot.megafortunedreams_rapid.RUR.lastpayedout=0&";
*/
$output .= "jackpotcurrency=%26%23x20AC%3B&";
$output .= "jackpotcurrencyiso=RUR&";

$output .= "multiplier=1&";
$output .= "nearwinallowed=true&";

$output .= "nextaction=spin&";

$output .= "playercurrency=%26%23x20AC%3B&";
$output .= "playercurrencyiso=RUR&";
$output .= "playforfun=false&";
$output .= "playforrealpromo.rounds=30&";

$output .= "restore=false&";

$output .= "rs.i0.id=freespin&";
$output .= "rs.i0.r.i0.hold=false&";
$output .= "rs.i0.r.i0.pos=0&";
$output .= "rs.i0.r.i0.strip=SYM12%2CSYM6%2CSYM10%2CSYM9%2CSYM12%2CSYM6%2CSYM9%2CSYM10%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM8%2CSYM7%2CSYM6%2CSYM5%2CSYM4%2CSYM3%2CSYM0%2CSYM9%2CSYM11%2CSYM6%2CSYM8%2CSYM9%2CSYM7%2CSYM6%2CSYM11%2CSYM5%2CSYM9%2CSYM8%2CSYM7%2CSYM6%2CSYM11%2CSYM5%2CSYM6%2CSYM11%2CSYM5%2CSYM1%2CSYM12%2CSYM7%2CSYM9%2CSYM10%2CSYM8%2CSYM11%2CSYM6%2CSYM12%2CSYM1%2CSYM5%2CSYM7%2CSYM9%2CSYM5%2CSYM10%2CSYM6%2CSYM8%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM8%2CSYM1%2CSYM5%2CSYM11%2CSYM6%2CSYM9%2CSYM7%2CSYM5%2CSYM11%2CSYM6%2CSYM9%2CSYM8%2CSYM7%2CSYM5%2CSYM11%2CSYM6%2CSYM5%2CSYM8%2CSYM6%2CSYM11%2CSYM1%2CSYM6%2CSYM5%2CSYM9%2CSYM11%2CSYM5%2CSYM6%2CSYM11%2CSYM1%2CSYM12%2CSYM9%2CSYM10%2CSYM4%2CSYM8%2CSYM7%2CSYM3%2CSYM5%2CSYM9%2CSYM6%2CSYM5%2CSYM7%2CSYM9%2CSYM5%2CSYM7%2CSYM6%2CSYM11%2CSYM5%2CSYM9%2CSYM8%2CSYM7%2CSYM6%2CSYM11%2CSYM5%2CSYM6%2CSYM11%2CSYM8%2CSYM1%2CSYM9%2CSYM11%2CSYM10%2CSYM1%2CSYM8%2CSYM12%2CSYM5%2CSYM6%2CSYM7%2CSYM1%2CSYM8%2CSYM11%2CSYM6%2CSYM9%2CSYM12%2CSYM6%2CSYM10%2CSYM5%2CSYM1%2CSYM8%2CSYM11%2CSYM9%2CSYM10%2CSYM12%2CSYM1%2CSYM5%2CSYM11%2CSYM6%2CSYM5%2CSYM8%2CSYM7%2CSYM5%2CSYM11%2CSYM6%2CSYM9%2CSYM8%2CSYM6%2CSYM9%2CSYM11%2CSYM5%2CSYM6%2CSYM11%2CSYM7%2CSYM0&";
$output .= "rs.i0.r.i0.syms=SYM12%2CSYM6%2CSYM10&";
$output .= "rs.i0.r.i1.hold=false&";
$output .= "rs.i0.r.i1.pos=0&";
$output .= "rs.i0.r.i1.strip=SYM1%2CSYM5%2CSYM11%2CSYM6%2CSYM9%2CSYM5%2CSYM11%2CSYM6%2CSYM9%2CSYM1%2CSYM4%2CSYM11%2CSYM10%2CSYM3%2CSYM8%2CSYM7%2CSYM6%2CSYM8%2CSYM12%2CSYM9%2CSYM0%2CSYM5%2CSYM8%2CSYM12%2CSYM5%2CSYM6%2CSYM1%2CSYM7%2CSYM11%2CSYM5%2CSYM9%2CSYM8%2CSYM12%2CSYM6%2CSYM10%2CSYM1%2CSYM12%2CSYM11%2CSYM1%2CSYM5%2CSYM12%2CSYM7%2CSYM11%2CSYM8%2CSYM10%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM0%2CSYM6%2CSYM8%2CSYM1%2CSYM12%2CSYM9%2CSYM10%2CSYM12%2CSYM7%2CSYM11%2CSYM1%2CSYM10%2CSYM11%2CSYM9%2CSYM12%2CSYM11%2CSYM9%2CSYM6%2CSYM12%2CSYM1%2CSYM9%2CSYM10%2CSYM12%2CSYM8%2CSYM7%2CSYM10%2CSYM11%2CSYM4%2CSYM12%2CSYM3%2CSYM11%2CSYM10%2CSYM12%2CSYM11%2CSYM10%2CSYM1%2CSYM5%2CSYM4%2CSYM10%2CSYM12%2CSYM1%2CSYM8%2CSYM7%2CSYM10%2CSYM12%2CSYM1%2CSYM9%2CSYM11%2CSYM1%2CSYM7%2CSYM11%2CSYM10%2CSYM8%2CSYM9%2CSYM12%2CSYM8%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM7%2CSYM1%2CSYM12%2CSYM10%2CSYM5%2CSYM12%2CSYM11%2CSYM10&";
$output .= "rs.i0.r.i1.syms=SYM1%2CSYM5%2CSYM11&";
$output .= "rs.i0.r.i2.hold=false&";
$output .= "rs.i0.r.i2.pos=0&";
$output .= "rs.i0.r.i2.strip=SYM7%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM1%2CSYM12%2CSYM10%2CSYM9%2CSYM8%2CSYM7%2CSYM6%2CSYM5%2CSYM4%2CSYM3%2CSYM0%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM8%2CSYM7%2CSYM12%2CSYM10%2CSYM9%2CSYM12%2CSYM7%2CSYM2%2CSYM12%2CSYM11%2CSYM10%2CSYM12%2CSYM11%2CSYM10%2CSYM1%2CSYM8%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM7%2CSYM6%2CSYM5%2CSYM2%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM8%2CSYM12%2CSYM6%2CSYM5%2CSYM2%2CSYM11%2CSYM12%2CSYM1%2CSYM9%2CSYM10%2CSYM12%2CSYM8%2CSYM11%2CSYM12%2CSYM9%2CSYM10%2CSYM8%2CSYM7%2CSYM12%2CSYM11%2CSYM7%2CSYM9%2CSYM8%2CSYM10%2CSYM12%2CSYM11%2CSYM10%2CSYM8%2CSYM11%2CSYM10%2CSYM12&";
$output .= "rs.i0.r.i2.syms=SYM7%2CSYM11%2CSYM10&";
$output .= "rs.i0.r.i3.hold=false&";
$output .= "rs.i0.r.i3.pos=0&";
$output .= "rs.i0.r.i3.strip=SYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM10%2CSYM11%2CSYM9%2CSYM6%2CSYM11%2CSYM4%2CSYM10%2CSYM8%2CSYM7%2CSYM12%2CSYM5%2CSYM9%2CSYM11%2CSYM0%2CSYM12%2CSYM3%2CSYM10%2CSYM7%2CSYM8%2CSYM9%2CSYM12%2CSYM11%2CSYM10%2CSYM12%2CSYM8%2CSYM7%2CSYM2%2CSYM9%2CSYM11%2CSYM10%2CSYM12%2CSYM11%2CSYM10%2CSYM12%2CSYM7%2CSYM10%2CSYM5%2CSYM8%2CSYM11%2CSYM6%2CSYM12%2CSYM1%2CSYM5%2CSYM11%2CSYM9%2CSYM8%2CSYM7%2CSYM12%2CSYM9%2CSYM10%2CSYM2%2CSYM12%2CSYM11%2CSYM8%2CSYM10%2CSYM11%2CSYM9%2CSYM12%2CSYM11%2CSYM10%2CSYM12%2CSYM9%2CSYM8%2CSYM10%2CSYM12%2CSYM7%2CSYM9%2CSYM10%2CSYM8%2CSYM11%2CSYM6%2CSYM10%2CSYM12%2CSYM11%2CSYM7%2CSYM12%2CSYM10%2CSYM11%2CSYM8%2CSYM9%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM7%2CSYM10%2CSYM4%2CSYM8%2CSYM11%2CSYM12%2CSYM5%2CSYM9%2CSYM6%2CSYM0%2CSYM12%2CSYM7%2CSYM10%2CSYM9%2CSYM8%2CSYM7%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM7%2CSYM2%2CSYM3%2CSYM11%2CSYM10%2CSYM12%2CSYM11%2CSYM10%2CSYM12%2CSYM11%2CSYM5%2CSYM9%2CSYM8%2CSYM7%2CSYM6%2CSYM10%2CSYM2%2CSYM7%2CSYM11%2CSYM12%2CSYM11%2CSYM10%2CSYM9%2CSYM8%2CSYM11%2CSYM6%2CSYM5%2CSYM0&";
$output .= "rs.i0.r.i3.syms=SYM12%2CSYM11%2CSYM10&";
$output .= "rs.i0.r.i4.hold=false&";
$output .= "rs.i0.r.i4.pos=0&";
$output .= "rs.i0.r.i4.strip=SYM2%2CSYM10%2CSYM11%2CSYM12%2CSYM5%2CSYM10%2CSYM11%2CSYM3%2CSYM8%2CSYM9%2CSYM12%2CSYM10%2CSYM11%2CSYM12%2CSYM10%2CSYM8%2CSYM12%2CSYM10%2CSYM8%2CSYM9%2CSYM2%2CSYM4%2CSYM9%2CSYM12%2CSYM0%2CSYM8%2CSYM11%2CSYM6%2CSYM1%2CSYM10%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM12%2CSYM9%2CSYM11%2CSYM8%2CSYM9%2CSYM10%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM11%2CSYM8%2CSYM9%2CSYM10%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM2%2CSYM10%2CSYM11%2CSYM12%2CSYM5%2CSYM10%2CSYM11%2CSYM3%2CSYM8%2CSYM9%2CSYM12%2CSYM10%2CSYM11%2CSYM12%2CSYM10%2CSYM11%2CSYM12%2CSYM10%2CSYM8%2CSYM9%2CSYM2%2CSYM4%2CSYM9%2CSYM12%2CSYM0%2CSYM8%2CSYM11%2CSYM6%2CSYM10%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM8%2CSYM2%2CSYM9%2CSYM11%2CSYM8%2CSYM9%2CSYM10%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM2%2CSYM8%2CSYM12%2CSYM9%2CSYM10%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9&";
$output .= "rs.i0.r.i4.syms=SYM2%2CSYM10%2CSYM11&";
$output .= "rs.i1.id=basic&";
$output .= "rs.i1.r.i0.hold=false&";
$output .= "rs.i1.r.i0.pos=0&";
$output .= "rs.i1.r.i0.strip=SYM5%2CSYM8%2CSYM9%2CSYM12%2CSYM8%2CSYM9%2CSYM1%2CSYM4%2CSYM12%2CSYM9%2CSYM8%2CSYM5%2CSYM9%2CSYM11%2CSYM12%2CSYM9%2CSYM3%2CSYM11%2CSYM7%2CSYM9%2CSYM11%2CSYM12%2CSYM10%2CSYM9%2CSYM12%2CSYM11%2CSYM0%2CSYM10%2CSYM8%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM11%2CSYM10%2CSYM8%2CSYM11%2CSYM7%2CSYM12%2CSYM11%2CSYM1%2CSYM8%2CSYM9%2CSYM7%2CSYM0%2CSYM11%2CSYM4%2CSYM8%2CSYM5%2CSYM9%2CSYM11%2CSYM5%2CSYM12%2CSYM9%2CSYM11%2CSYM12%2CSYM8%2CSYM11%2CSYM12%2CSYM10%2CSYM0%2CSYM6%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM10%2CSYM6%2CSYM12%2CSYM1%2CSYM11%2CSYM6%2CSYM12%2CSYM11%2CSYM7%2CSYM10%2CSYM6%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM0%2CSYM6%2CSYM12%2CSYM11%2CSYM7%2CSYM6%2CSYM10%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM10%2CSYM6%2CSYM3%2CSYM11%2CSYM7%2CSYM6%2CSYM10%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11&";
$output .= "rs.i1.r.i0.syms=SYM3%2CSYM4%2CSYM5&";
$output .= "rs.i1.r.i1.hold=false&";
$output .= "rs.i1.r.i1.pos=0&";
$output .= "rs.i1.r.i1.strip=SYM7%2CSYM12%2CSYM4%2CSYM3%2CSYM8%2CSYM0%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM1%2CSYM11%2CSYM4%2CSYM8%2CSYM10%2CSYM4%2CSYM12%2CSYM10%2CSYM5%2CSYM9%2CSYM7%2CSYM0%2CSYM3%2CSYM10%2CSYM1%2CSYM9%2CSYM5%2CSYM7%2CSYM8%2CSYM4%2CSYM7%2CSYM3%2CSYM5%2CSYM0%2CSYM10%2CSYM6%2CSYM12%2CSYM3%2CSYM5%2CSYM7%2CSYM8%2CSYM1%2CSYM11%2CSYM4%2CSYM12%2CSYM5%2CSYM0%2CSYM10%2CSYM6%2CSYM12%2CSYM9%2CSYM4%2CSYM3%2CSYM8%2CSYM12%2CSYM11%2CSYM8%2CSYM9%2CSYM11%2CSYM8%2CSYM6%2CSYM11%2CSYM10%2CSYM9%2CSYM3%2CSYM8%2CSYM12%2CSYM11%2CSYM8%2CSYM9%2CSYM11%2CSYM8%2CSYM6%2CSYM11&";
$output .= "rs.i1.r.i1.syms=SYM6%2CSYM7%2CSYM8&";
$output .= "rs.i1.r.i2.hold=false&";
$output .= "rs.i1.r.i2.pos=0&";
$output .= "rs.i1.r.i2.strip=SYM3%2CSYM6%2CSYM2%2CSYM3%2CSYM7%2CSYM9%2CSYM2%2CSYM3%2CSYM4%2CSYM7%2CSYM9%2CSYM4%2CSYM7%2CSYM9%2CSYM5%2CSYM12%2CSYM2%2CSYM5%2CSYM12%2CSYM7%2CSYM2%2CSYM5%2CSYM6%2CSYM10%2CSYM11%2CSYM8%2CSYM0%2CSYM12%2CSYM8%2CSYM1%2CSYM11%2CSYM10%2CSYM1%2CSYM12%2CSYM7%2CSYM1%2CSYM8%2CSYM10%2CSYM3%2CSYM7%2CSYM0%2CSYM10%2CSYM7%2CSYM2%2CSYM11%2CSYM10%2CSYM0%2CSYM12%2CSYM8%2CSYM1%2CSYM7%2CSYM9%2CSYM4%2CSYM2%2CSYM3%2CSYM7%2CSYM9%2CSYM1%2CSYM4%2CSYM7%2CSYM9%2CSYM2%2CSYM4%2CSYM7%2CSYM5%2CSYM9%2CSYM4%2CSYM5%2CSYM1%2CSYM12%2CSYM8%2CSYM5%2CSYM11%2CSYM1%2CSYM10%2CSYM8%2CSYM0%2CSYM6%2CSYM4%2CSYM2%2CSYM11%2CSYM10%2CSYM1%2CSYM6%2CSYM7%2CSYM1%2CSYM10%2CSYM3%2CSYM1%2CSYM7%2CSYM10%2CSYM8%2CSYM4%2CSYM10%2CSYM8%2CSYM12%2CSYM4%2CSYM5%2CSYM11%2CSYM10%2CSYM8%2CSYM12%2CSYM2%2CSYM8%2CSYM10%2CSYM4%2CSYM3%2CSYM7%2CSYM9%2CSYM11%2CSYM7%2CSYM9%2CSYM4&";
$output .= "rs.i1.r.i2.syms=SYM9%2CSYM10%2CSYM11&";
$output .= "rs.i1.r.i3.hold=false&";
$output .= "rs.i1.r.i3.pos=0&";
$output .= "rs.i1.r.i3.strip=SYM12%2CSYM9%2CSYM0%2CSYM8%2CSYM10%2CSYM11%2CSYM9%2CSYM3%2CSYM10%2CSYM11%2CSYM7%2CSYM2%2CSYM8%2CSYM4%2CSYM12%2CSYM8%2CSYM11%2CSYM10%2CSYM5%2CSYM12%2CSYM11%2CSYM10%2CSYM1%2CSYM6%2CSYM11%2CSYM7%2CSYM8%2CSYM10%2CSYM2%2CSYM9%2CSYM7%2CSYM2%2CSYM12%2CSYM8%2CSYM11%2CSYM12%2CSYM1%2CSYM8%2CSYM9%2CSYM7%2CSYM2%2CSYM8%2CSYM9%2CSYM4%2CSYM8%2CSYM9%2CSYM4%2CSYM8%2CSYM2%2CSYM9%2CSYM5%2CSYM11%2CSYM12%2CSYM9%2CSYM2%2CSYM12%2CSYM11%2CSYM1%2CSYM5%2CSYM3%2CSYM12%2CSYM1%2CSYM6%2CSYM12%2CSYM10%2CSYM11%2CSYM6%2CSYM2%2CSYM11%2CSYM10%2CSYM6%2CSYM12%2CSYM2%2CSYM11%2CSYM10%2CSYM1%2CSYM11%2CSYM12%2CSYM7%2CSYM11%2CSYM1%2CSYM5%2CSYM11%2CSYM12%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM9%2CSYM10%2CSYM6%2CSYM2%2CSYM11%2CSYM10%2CSYM6%2CSYM2%2CSYM12%2CSYM11%2CSYM1%2CSYM10%2CSYM12%2CSYM2%2CSYM11%2CSYM7%2CSYM12%2CSYM11%2CSYM10%2CSYM2%2CSYM9%2CSYM8%2CSYM4%2CSYM10%2CSYM12%2CSYM11%2CSYM7%2CSYM12%2CSYM11%2CSYM10%2CSYM3%2CSYM6&";
$output .= "rs.i1.r.i3.syms=SYM12%2CSYM0%2CSYM1&";
$output .= "rs.i1.r.i4.hold=false&";
$output .= "rs.i1.r.i4.pos=0&";
$output .= "rs.i1.r.i4.strip=SYM1%2CSYM11%2CSYM10%2CSYM5%2CSYM0%2CSYM3%2CSYM8%2CSYM12%2CSYM10%2CSYM9%2CSYM8%2CSYM2%2CSYM10%2CSYM11%2CSYM12%2CSYM10%2CSYM11%2CSYM12%2CSYM8%2CSYM11%2CSYM6%2CSYM10%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM8%2CSYM9%2CSYM2%2CSYM8%2CSYM9%2CSYM11%2CSYM4%2CSYM9%2CSYM10%2CSYM11%2CSYM12%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM1%2CSYM12%2CSYM8%2CSYM9%2CSYM10%2CSYM3%2CSYM10%2CSYM11%2CSYM12%2CSYM5%2CSYM10%2CSYM9%2CSYM11%2CSYM12%2CSYM0%2CSYM10%2CSYM11%2CSYM12%2CSYM8%2CSYM10%2CSYM11%2CSYM1%2CSYM12%2CSYM10%2CSYM7%2CSYM11%2CSYM9%2CSYM10%2CSYM12%2CSYM1%2CSYM6%2CSYM11%2CSYM8%2CSYM10%2CSYM2%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM1%2CSYM10%2CSYM11%2CSYM9%2CSYM2%2CSYM8%2CSYM9%2CSYM1%2CSYM4%2CSYM9%2CSYM8%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM0%2CSYM8%2CSYM9%2CSYM0%2CSYM12%2CSYM4%2CSYM11%2CSYM9%2CSYM12%2CSYM8%2CSYM3%2CSYM4%2CSYM2%2CSYM6%2CSYM7%2CSYM11%2CSYM10%2CSYM8%2CSYM11%2CSYM10%2CSYM12%2CSYM6&";
$output .= "rs.i1.r.i4.syms=SYM1%2CSYM3%2CSYM2&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
$output .= "totalwin.cents=0&";
$output .= "totalwin.coins=0&";
$output .= "wavecount=1&";
