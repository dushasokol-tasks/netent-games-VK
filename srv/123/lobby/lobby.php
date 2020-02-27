<?
header('Access-Control-Allow-Origin: *');
////////////////////////////////////////////////////////////////////////////////
//reels
//	5	wild stacks vari
//	6	random_wild	symbol_transform	symbol_overlay
//	7	symbol_overlay combinations vari
//	8	bonus type vari
//bonus
//	5	coinwin value
////////////////////////////////////////////////////////////////////////////////
$answ = "";
$gameover = "true";
$wilds = '';
$table_locked = 0;
$isJackpotWin = "false";
$rapid_lastpayedout = 0;
$mega_lastpayedout = 0;
$major_lastpayedout = 0;
$freerounds = 3;
////////////////////////////////////
//correct action check
////////////////////////////////////
/*
    if($_GET['action']=="freespin" and ($lastActionDB=="spin" or $lastActionDB=="respin" or $lastActionDB=="symbol_transform" or $lastActionDB=="symbol_overlay")) exit;
    if($_GET['action']=="freespin" and $lastActionDB=="paytable" and $answer=='') exit;
    if($_GET['action']=="freespin" and $lastActionDB=="init") exit;
    if($_GET['action']=="freespin" and $lastActionDB!="freespin" and $lastActionDB!="startfreespin" and $lastActionDB!="paytable" and $lastActionDB!="lastrespin" ) exit;

    if($_GET['action']=="bonusaction" and ($lastActionDB=="spin" or $lastActionDB=="respin" or $lastActionDB=="lastrespin" or $lastActionDB=="symbol_transform" or $lastActionDB=="symbol_overlay")) exit;
    if($_GET['action']=="bonusaction" and $lastActionDB=="paytable" and $answer=='') exit;
    if($_GET['action']=="bonusaction" and $lastActionDB=="init") exit;

    if($_GET['action']=="bonusaction" and $lastActionDB!="bonusaction" and $lastActionDB!="bonusgame" and $lastActionDB!="paytable") exit;

    if($_GET['action']=="bonus_feature_pick")
	if($lastActionDB=="paytable" and $answer=='') exit;
	elseif($lastActionDB!="bonus_feature_pick" and $lastActionDB!="paytable" and $lastActionDB!="fairy_pre_bonus")exit;
*/
if ($_GET['action'] == "init") {
	include($gamePath . 'init.php');
	include($gamePath . 'common.php');
	$lastAction = "init";
	$lastRs = $lastRsDB;
}

if ($_GET['action'] == "paytable") {
	if ($answer == '') $table_locked = 0;
	else {
		$table_locked = 1;
		$answ = $answer;
	}
	include($gamePath . 'payt.php');
	$lastAction = "paytable";
	$lastRs = $lastRsDB;
}


if ($_GET['action'] == 'initfreespin') {
	$output .= "bet.betlevel=1&";
	$output .= "bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
	$output .= "bet.denomination=2&";
	$output .= "clientaction=initfreespin&";
	$output .= "freespins.betlevel=1&";
	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
	$output .= "freespins.denomination=2.000&";
	$output .= "freespins.initial=" . $fs_left . "&";
	$output .= "freespins.left=" . $fs_left . "&";
	$output .= "freespins.multiplier=3&";
	$output .= "freespins.total=" . $fs_left . "&";
	$output .= "freespins.totalwin.cents=0&";
	$output .= "freespins.totalwin.coins=0&";
	$output .= "freespins.wavecount=1&";
	$output .= "freespins.win.cents=0&";
	$output .= "freespins.win.coins=0&";
	$output .= "gamestate.current=freespin&";
	$output .= "gamestate.history=basic&";
	$output .= "gamestate.stack=basic%2Cfreespin&";
	$output .= "nextaction=freespin&";
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
	$output .= "rs.i1.nearwin=4%2C2%2C3&";
	$output .= "rs.i1.r.i0.attention.i0=2&";
	$output .= "rs.i1.r.i0.hold=false&";
	$output .= "rs.i1.r.i0.pos=42&";
	$output .= "rs.i1.r.i0.strip=SYM5%2CSYM8%2CSYM9%2CSYM12%2CSYM8%2CSYM9%2CSYM1%2CSYM4%2CSYM12%2CSYM9%2CSYM8%2CSYM5%2CSYM9%2CSYM11%2CSYM12%2CSYM9%2CSYM3%2CSYM11%2CSYM7%2CSYM9%2CSYM11%2CSYM12%2CSYM10%2CSYM9%2CSYM12%2CSYM11%2CSYM0%2CSYM10%2CSYM8%2CSYM11%2CSYM10%2CSYM9%2CSYM12%2CSYM11%2CSYM10%2CSYM8%2CSYM11%2CSYM7%2CSYM12%2CSYM11%2CSYM1%2CSYM8%2CSYM9%2CSYM7%2CSYM0%2CSYM11%2CSYM4%2CSYM8%2CSYM5%2CSYM9%2CSYM11%2CSYM5%2CSYM12%2CSYM9%2CSYM11%2CSYM12%2CSYM8%2CSYM11%2CSYM12%2CSYM10%2CSYM0%2CSYM6%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM10%2CSYM6%2CSYM12%2CSYM1%2CSYM11%2CSYM6%2CSYM12%2CSYM11%2CSYM7%2CSYM10%2CSYM6%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM0%2CSYM6%2CSYM12%2CSYM11%2CSYM7%2CSYM6%2CSYM10%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM10%2CSYM6%2CSYM3%2CSYM11%2CSYM7%2CSYM6%2CSYM10%2CSYM12%2CSYM9%2CSYM10%2CSYM6%2CSYM12%2CSYM11&";
	$output .= "rs.i1.r.i0.syms=SYM9%2CSYM7%2CSYM0&";
	$output .= "rs.i1.r.i1.attention.i0=0&";
	$output .= "rs.i1.r.i1.hold=false&";
	$output .= "rs.i1.r.i1.pos=46&";
	$output .= "rs.i1.r.i1.strip=SYM7%2CSYM12%2CSYM4%2CSYM3%2CSYM8%2CSYM0%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM1%2CSYM11%2CSYM4%2CSYM8%2CSYM10%2CSYM4%2CSYM12%2CSYM10%2CSYM5%2CSYM9%2CSYM7%2CSYM0%2CSYM3%2CSYM10%2CSYM1%2CSYM9%2CSYM5%2CSYM7%2CSYM8%2CSYM4%2CSYM7%2CSYM3%2CSYM5%2CSYM0%2CSYM10%2CSYM6%2CSYM12%2CSYM3%2CSYM5%2CSYM7%2CSYM8%2CSYM1%2CSYM11%2CSYM4%2CSYM12%2CSYM5%2CSYM0%2CSYM10%2CSYM6%2CSYM12%2CSYM9%2CSYM4%2CSYM3%2CSYM8%2CSYM12%2CSYM11%2CSYM8%2CSYM9%2CSYM11%2CSYM8%2CSYM6%2CSYM11%2CSYM10%2CSYM9%2CSYM3%2CSYM8%2CSYM12%2CSYM11%2CSYM8%2CSYM9%2CSYM11%2CSYM8%2CSYM6%2CSYM11&";
	$output .= "rs.i1.r.i1.syms=SYM0%2CSYM10%2CSYM6&";
	$output .= "rs.i1.r.i2.attention.i0=2&";
	$output .= "rs.i1.r.i2.hold=false&";
	$output .= "rs.i1.r.i2.pos=44&";
	$output .= "rs.i1.r.i2.strip=SYM3%2CSYM6%2CSYM2%2CSYM3%2CSYM7%2CSYM9%2CSYM2%2CSYM3%2CSYM4%2CSYM7%2CSYM9%2CSYM4%2CSYM7%2CSYM9%2CSYM5%2CSYM12%2CSYM2%2CSYM5%2CSYM12%2CSYM7%2CSYM2%2CSYM5%2CSYM6%2CSYM10%2CSYM11%2CSYM8%2CSYM0%2CSYM12%2CSYM8%2CSYM1%2CSYM11%2CSYM10%2CSYM1%2CSYM12%2CSYM7%2CSYM1%2CSYM8%2CSYM10%2CSYM3%2CSYM7%2CSYM0%2CSYM10%2CSYM7%2CSYM2%2CSYM11%2CSYM10%2CSYM0%2CSYM12%2CSYM8%2CSYM1%2CSYM7%2CSYM9%2CSYM4%2CSYM2%2CSYM3%2CSYM7%2CSYM9%2CSYM1%2CSYM4%2CSYM7%2CSYM9%2CSYM2%2CSYM4%2CSYM7%2CSYM5%2CSYM9%2CSYM4%2CSYM5%2CSYM1%2CSYM12%2CSYM8%2CSYM5%2CSYM11%2CSYM1%2CSYM10%2CSYM8%2CSYM0%2CSYM6%2CSYM4%2CSYM2%2CSYM11%2CSYM10%2CSYM1%2CSYM6%2CSYM7%2CSYM1%2CSYM10%2CSYM3%2CSYM1%2CSYM7%2CSYM10%2CSYM8%2CSYM4%2CSYM10%2CSYM8%2CSYM12%2CSYM4%2CSYM5%2CSYM11%2CSYM10%2CSYM8%2CSYM12%2CSYM2%2CSYM8%2CSYM10%2CSYM4%2CSYM3%2CSYM7%2CSYM9%2CSYM11%2CSYM7%2CSYM9%2CSYM4&";
	$output .= "rs.i1.r.i2.syms=SYM11%2CSYM10%2CSYM0&";
	$output .= "rs.i1.r.i3.hold=false&";
	$output .= "rs.i1.r.i3.pos=116&";
	$output .= "rs.i1.r.i3.strip=SYM12%2CSYM9%2CSYM0%2CSYM8%2CSYM10%2CSYM11%2CSYM9%2CSYM3%2CSYM10%2CSYM11%2CSYM7%2CSYM2%2CSYM8%2CSYM4%2CSYM12%2CSYM8%2CSYM11%2CSYM10%2CSYM5%2CSYM12%2CSYM11%2CSYM10%2CSYM1%2CSYM6%2CSYM11%2CSYM7%2CSYM8%2CSYM10%2CSYM2%2CSYM9%2CSYM7%2CSYM2%2CSYM12%2CSYM8%2CSYM11%2CSYM12%2CSYM1%2CSYM8%2CSYM9%2CSYM7%2CSYM2%2CSYM8%2CSYM9%2CSYM4%2CSYM8%2CSYM9%2CSYM4%2CSYM8%2CSYM2%2CSYM9%2CSYM5%2CSYM11%2CSYM12%2CSYM9%2CSYM2%2CSYM12%2CSYM11%2CSYM1%2CSYM5%2CSYM3%2CSYM12%2CSYM1%2CSYM6%2CSYM12%2CSYM10%2CSYM11%2CSYM6%2CSYM2%2CSYM11%2CSYM10%2CSYM6%2CSYM12%2CSYM2%2CSYM11%2CSYM10%2CSYM1%2CSYM11%2CSYM12%2CSYM7%2CSYM11%2CSYM1%2CSYM5%2CSYM11%2CSYM12%2CSYM10%2CSYM6%2CSYM12%2CSYM11%2CSYM9%2CSYM10%2CSYM6%2CSYM2%2CSYM11%2CSYM10%2CSYM6%2CSYM2%2CSYM12%2CSYM11%2CSYM1%2CSYM10%2CSYM12%2CSYM2%2CSYM11%2CSYM7%2CSYM12%2CSYM11%2CSYM10%2CSYM2%2CSYM9%2CSYM8%2CSYM4%2CSYM10%2CSYM12%2CSYM11%2CSYM7%2CSYM12%2CSYM11%2CSYM10%2CSYM3%2CSYM6&";
	$output .= "rs.i1.r.i3.syms=SYM11%2CSYM10%2CSYM3&";
	$output .= "rs.i1.r.i4.hold=false&";
	$output .= "rs.i1.r.i4.pos=54&";
	$output .= "rs.i1.r.i4.strip=SYM1%2CSYM11%2CSYM10%2CSYM5%2CSYM0%2CSYM3%2CSYM8%2CSYM12%2CSYM10%2CSYM9%2CSYM8%2CSYM2%2CSYM10%2CSYM11%2CSYM12%2CSYM10%2CSYM11%2CSYM12%2CSYM8%2CSYM11%2CSYM6%2CSYM10%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM8%2CSYM9%2CSYM2%2CSYM8%2CSYM9%2CSYM11%2CSYM4%2CSYM9%2CSYM10%2CSYM11%2CSYM12%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM1%2CSYM12%2CSYM8%2CSYM9%2CSYM10%2CSYM3%2CSYM10%2CSYM11%2CSYM12%2CSYM5%2CSYM10%2CSYM9%2CSYM11%2CSYM12%2CSYM0%2CSYM10%2CSYM11%2CSYM12%2CSYM8%2CSYM10%2CSYM11%2CSYM1%2CSYM12%2CSYM10%2CSYM7%2CSYM11%2CSYM9%2CSYM10%2CSYM12%2CSYM1%2CSYM6%2CSYM11%2CSYM8%2CSYM10%2CSYM2%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM1%2CSYM10%2CSYM11%2CSYM9%2CSYM2%2CSYM8%2CSYM9%2CSYM1%2CSYM4%2CSYM9%2CSYM8%2CSYM7%2CSYM2%2CSYM11%2CSYM12%2CSYM4%2CSYM9%2CSYM8%2CSYM12%2CSYM9%2CSYM3%2CSYM0%2CSYM8%2CSYM9%2CSYM0%2CSYM12%2CSYM4%2CSYM11%2CSYM9%2CSYM12%2CSYM8%2CSYM3%2CSYM4%2CSYM2%2CSYM6%2CSYM7%2CSYM11%2CSYM10%2CSYM8%2CSYM11%2CSYM10%2CSYM12%2CSYM6&";
	$output .= "rs.i1.r.i4.syms=SYM10%2CSYM3%2CSYM10&";


	//echo "<br>!!!!<br>".$lastRsDB."<br><br>";

	//$output.= $lastRsDB;

	$gameover = 'false';
	$lastAction = "initfreespin";
}

if ($_GET['action'] == 'initbonus') {
	$lastAction = "initbonus";
	$query = "SELECT * FROM ns.bonuses where payRate=" . $payRate . " and gameId=" . $gameId . " and (id=5 or id=6 or id=7);";
	$result = mysql_query($query);
	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$reels['id']] = explode(",", $reels['symbols']);
	}

	include('./integr/busters.php');

	foreach ($reel[5] as $e => $v) $output .= "bonus.wheel.i0.pos.i" . $e . ".value=" . $v . "&";
	foreach ($reel[6] as $e => $v) $output .= "bonus.wheel.i1.pos.i" . $e . ".value=" . $v . "&";
	foreach ($reel[7] as $e => $v) $output .= "bonus.wheel.i2.pos.i" . $e . ".value=" . $v . "&";

	$output .= "bonusgame.coinvalue=1.00&";
	$output .= "clientaction=initbonus&";
	$output .= "gamestate.bonusid=mf2bonus&";
	$output .= "gamestate.current=bonus&";
	$output .= "gamestate.history=basic&";
	$output .= "gamestate.stack=basic%2Cbonus&";
	$output .= "nextaction=bonusaction&";
	$output .= "nextactiontype=pickbonus&";
	$output .= "phase=WHEEL1&";
	$output .= "totalbonuswin.cents=0&";
	$output .= "totalbonuswin.coins=0&";

	$output .= "gamestate.previous=basic&";

	$phase = "WHEEL1";
	$bonus_totalwin = 0;
	$gameover = "false";
	$table_locked = 1;
	$lastAction = "initbonus";
}
if ($_GET['action'] == 'bonusaction') {
	$lastAction = "bonusaction";
	$query = "SELECT * FROM ns.bonuses where payRate=" . $payRate . " and gameId=" . $gameId . " and (id=5 or id=6 or id=7 or id=8 or id=9);";
	$result = mysql_query($query);
	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$reels['id']] = explode(",", $reels['symbols']);
	}

	include('./integr/busters.php');

	foreach ($reel[5] as $e => $v) $output .= "bonus.wheel.i0.pos.i" . $e . ".value=" . $v . "&";
	foreach ($reel[6] as $e => $v) $output .= "bonus.wheel.i1.pos.i" . $e . ".value=" . $v . "&";
	foreach ($reel[7] as $e => $v) $output .= "bonus.wheel.i2.pos.i" . $e . ".value=" . $v . "&";

	$bonusend = 0;

	if ($phase == 'WHEEL1') {
		$length = (count($reel[5]) - 1);
		$pos = round(rand(0, $length));
		//	$pos=0;
		$temp = $reel[5][$pos];

		//echo "<br>l: ".$length."; p: ".$pos."; t: ".$temp."<br>";

	} elseif ($phase == 'WHEEL2') {
		$length = (count($reel[8]) - 1);
		$pos = round(rand(0, $length));
		//	$pos=0;
		$temp = $reel[8][$pos];
		//echo "<br>l: ".$length."; p: ".$pos."; t: ".$temp."<br>";
	} elseif ($phase == 'WHEEL3') {
		$length = (count($reel[9]) - 1);
		$pos = round(rand(0, $length));
		//	$pos=8;
		$temp = $reel[9][$pos];
		//echo "<br>l: ".$length."; p: ".$pos."; t: ".$temp."<br>";
	}
	if ($temp == 'ARROW') {
		if ($phase == 'WHEEL1') $output .= "bonus.history.i0.value=ARROW&";
		if ($phase == 'WHEEL2') {
			$output .= "bonus.history.i0.value=ARROW&";
			$output .= "bonus.history.i1.value=ARROW&";
		}
	} elseif ($temp == 'RAPID_JACKPOT') {
		$output .= "bonus.jackpot.win.id=megafortunedreams_rapid&";
		$output .= "bonus.history.i0.value=ARROW&";
		$bonusend = 1;
	} elseif ($temp == 'MAJOR_JACKPOT') {
		$output .= "bonus.jackpot.win.id=megafortunedreams_major&";
		$output .= "bonus.history.i0.value=ARROW&";
		$output .= "bonus.history.i1.value=ARROW&";
		$bonusend = 1;
	} elseif ($temp == 'MEGA_JACKPOT') {
		$output .= "bonus.jackpot.win.id=megafortunedreams_mega&";
		$output .= "bonus.history.i0.value=ARROW&";
		$output .= "bonus.history.i1.value=ARROW&";
		$bonusend = 1;
	} else {
		$bonusend = 1;
	}

	if ($bonusend == 1) {
		if ($phase == 'WHEEL1')	$output .= "bonus.history.i0.value=" . $temp . "&";
		elseif ($phase == 'WHEEL2') $output .= "bonus.history.i1.value=" . $temp . "&";
		elseif ($phase == 'WHEEL3') $output .= "bonus.history.i2.value=" . $temp . "&";

		if ($temp == 'RAPID_JACKPOT') {
			$temp = 50;
			$rapid_lastpayedout = 5000;
		}
		if ($temp == 'MAJOR_JACKPOT') {
			$temp = 5000;
			$major_lastpayedout = 500000;
		}
		if ($temp == 'MEGA_JACKPOT') {
			$temp = 150000;
			$mega_lastpayedout = 15000000;
		}

		$bonus_totalwin += $temp;
		$total_winCents = $bonus_totalwin;
		$output .= "totalbonuswin.cents=" . $temp . "&";
		$output .= "totalbonuswin.coins=" . $temp . "&";
		$output .= "bonuswin.cents=" . $temp . "&";
		$output .= "bonuswin.coins=" . $temp . "&";

		$output .= "bonusgameover=true&";
		$output .= "nextaction=endbonus&";
		$output .= "phase=END&";
		$phase = "END";
	} else {
		if ($phase == "WHEEL1") $phase = "WHEEL2";
		elseif ($phase == "WHEEL2") $phase = "WHEEL3";
		$output .= "bonusgameover=false&";
		$output .= "nextaction=bonusaction&";
		$output .= "phase=" . $phase . "&";
	}

	$output .= "bonusgame.coinvalue=1.00&";
	$output .= "clientaction=bonusaction&";
	$output .= "gamestate.bonusid=mf2bonus&";
	$output .= "gamestate.current=bonus&";
	$output .= "gamestate.history=basic%2Cbonus&";
	$output .= "gamestate.stack=basic%2Cbonus&";
	$output .= "gamestate.previous=basic&";


	$gameover = "false";
	$table_locked = 1;
}


if ($_GET['action'] == 'endbonus') {
	$output .= "clientaction=endbonus&";
	$output .= "gamestate.current=basic&";
	$output .= "gamestate.previous=basic&";
	$output .= "gamestate.history=basic%2Cbonus&";
	$output .= "gamestate.stack=basic&";
	$output .= "nextaction=spin&";


	$total_win = $bonus_totalwin;
	$total_winCents = $total_win * $denomDB;

	$credit /= 100;
	$real_win = $bonus_totalwin * $denomDB * 0.01;
	$credit += $real_win;
	$creditDB = $credit * 100;
	$credit *= 100;
	$symb_combs = "bonuswin=" . $bonus_totalwin . ";";

	$lastAction = "endbonus";
	$table_locked = 0;
}


if ($_GET['action'] == "spin" or $_GET['action'] == "respin" or $_GET['action'] == "freespin") {

	$lastAction = "spin";
	if ($lastActionDB == "paytable" and isset($restoreAction)) {
		$lastActionDB = $restoreAction;
	}

	if ($lastActionDB == "freespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "initfreespin" and $_GET['action'] == "freespin") $lastAction = "freespin";
	if ($lastActionDB == "lastrespin" and $_GET['action'] == "freespin" and $fs_left > 0) $lastAction = "freespin";

	//    if($lastActionDB=="mirror" and $_GET['action']=="respin")$lastAction="respin";
	//    if($lastActionDB=="mirror2" and $_GET['action']=="respin")$lastAction="respin";
	//    if($lastActionDB=="mirrorFS" and $_GET['action']=="respin")$lastAction="respin";
	//    if($lastActionDB=="respin" and $_GET['action']=="respin")$lastAction="respin";

	////////////////////
	//symbol generation
	////////////////////
	$i = 0;

	if ($lastAction == "freespin") {
		$query = "SELECT * FROM ns.bonuses where payRate='" . $payRate . "' and gameId='" . $gameId . "' and (type=0 or type=1 or type=2 or type=3 or type=4 or type=5 or type=6 or type=7  or type=8) order by type asc;";
		$fs_left--;
		$fs_played++;
	} else	$query = "SELECT * FROM ns.reels where payRate=" . $payRate . " and gameId=" . $gameId . " order by id asc;";

	//    echo $query."<br><br>";

	$result = mysql_query($query);

	while ($reels = mysql_fetch_assoc($result)) {
		$reel[$i] = explode("_", $reels['symbols']);
		$i++;
	}

	for ($i = 0; $i < 5; $i++) {
		$length = (count($reel[$i]) - 1);
		$pos = round(rand(0, $length));
		$positions[$i] = $pos;

		$symbols[$i][0] = $reel[$i][$pos];
		if ($pos == $length) {
			$symbols[$i][1] = $reel[$i][0];
			$symbols[$i][2] = $reel[$i][1];
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
		}
	}
	/*
echo "<br><br>XXX: ";
echo $_Features['wheelTime'];
echo "<br><br>XXX: ";
echo $_Social['extra_wheel'];
echo "<br><br>YYY ";
*/

	$wheel_tries = $_Social['extra_wheel'];
	if ($_Features['wheelTime'] < 0) $wheel_tries++;

	$buster_tries = $_Social['extra_busterspin'];
	if ($_Features['safeTime'] < 0) $buster_tries++;

	if (
		$lastAction == "spin" and $buster_tries > 0 and
		$lastActionDB != "startbonus" and $lastActionDB != "initbonus"  and $lastActionDB != "bonusaction" and
		$lastActionDB != "startfreespin" and $lastActionDB != "initfreespin" and $lastActionDB != "freespin"
	) {
		$lastAction = "startfreespin";
		$y = round(rand(0, 2));
		$symbols[4][$y] = 0;
		if ($buster_tries > 1) {
			$y = round(rand(0, 2));
			$symbols[2][$y] = 0;
		}
		if ($buster_tries > 2) {
			$y = round(rand(0, 2));
			$symbols[0][$y] = 0;
		}
	} elseif (
		$lastAction == "spin" and $wheel_tries > 0 and
		$lastActionDB != "startbonus" and $lastActionDB != "initbonus"  and $lastActionDB != "bonusaction" and
		$lastActionDB != "startfreespin" and $lastActionDB != "initfreespin" and $lastActionDB != "freespin"
	) {
		$lastAction = "startbonus";
		$y = round(rand(0, 2));
		$symbols[4][$y] = 2;
		if ($buster_tries > 1) {
			$y = round(rand(0, 2));
			$symbols[2][$y] = 2;
		}
		if ($buster_tries > 2) {
			$y = round(rand(0, 2));
			$symbols[0][$y] = 2;
		}
	} elseif ($lastAction == "spin") // and $buster_tries==0 and $wheel_tries==0)
	{
		$lastAction = 'emptySpin';
		$symbols[0][0] = 4;
		$symbols[0][1] = 4;
		$symbols[0][2] = 4;
		$symbols[1][0] = 5;
		$symbols[1][1] = 3;
		$symbols[1][2] = 5;
		$symbols[2][0] = 3;
		$symbols[2][1] = 5;
		$symbols[2][2] = 3;
		$symbols[3][0] = 5;
		$symbols[3][1] = 3;
		$symbols[3][2] = 5;
		$symbols[4][0] = 4;
		$symbols[4][1] = 4;
		$symbols[4][2] = 4;
		$symbolsOverlayed = $symbols;
	}


	if ($lastAction == "freespin" and $_Social['tutorStep'] == 5) {
		$symbols[0][0] = 6;
		$symbols[0][1] = 12;
		$symbols[0][2] = 11;
		$symbols[1][0] = 6;
		$symbols[1][1] = 12;
		$symbols[1][2] = 11;
		$symbols[2][0] = 6;
		$symbols[2][1] = 12;
		$symbols[2][2] = 11;
		$symbols[3][0] = 8;
		$symbols[3][1] = 12;
		$symbols[3][2] = 9;
		$symbols[4][0] = 7;
		$symbols[4][1] = 12;
		$symbols[4][2] = 11;
		$symbolsOverlayed = $symbols;
	}

	/*
if(isset($fs_left))
{
//    if($fs_left==2)
    {
$symbols[0][0]=10;$symbols[0][1]=6;$symbols[0][2]=6;
$symbols[1][0]=10;$symbols[1][1]=12;$symbols[1][2]=8;
$symbols[2][0]=10;$symbols[2][1]=12;$symbols[2][2]=8;
$symbols[3][0]=11;$symbols[3][1]=7;$symbols[3][2]=7;
$symbols[4][0]=7;$symbols[4][1]=7;$symbols[4][2]=7;
    }

}
*/
	//    $has3symb=0;$has4symb=0;$has5symb=0;$has6symb=0;$has7symb=0;

	$bonusSymbCount = 0;
	$wildsSymbCount = 0;
	foreach ($symbols as $tReel => $t)
		foreach ($t as $tRow => $e) {
			if ($symbols[$tReel][$tRow] == 0) {
				$bonusSymbCount++;
				$bonusReels[$tReel] = 1;
			}
			if ($symbols[$tReel][$tRow] == 3) $has3symb = 1;
			if ($symbols[$tReel][$tRow] == 4) $has4symb = 1;
			if ($symbols[$tReel][$tRow] == 5) $has5symb = 1;
			if ($symbols[$tReel][$tRow] == 6) $has6symb = 1;
			if ($symbols[$tReel][$tRow] == 7) $has7symb = 1;
		}

	include('./integr/busters.php');


	/*
///////////////////////////////////////
    $fairyPreBonusRate=$reel[5][0];
    $string4Var=$reel[5][1];
    $string5Var=$reel[5][2];
    $mirror1Rate=$reel[6][0];
    $mirror2Rate=$reel[6][1];
    $symbTransformRate=$reel[6][2];
    $symbolOverlayRate=$reel[6][3];
//////////////////////////////////////
 if($_GET['action']=="spin")
 {
    if($bonusSymbCount<3 and $lastAction=="spin")
    {
	if($lastActionDB=="spin")
	{
	    if(rand(0,1000)<$mirror1Rate)
	    {
		$lastAction="mirror";
	    }
	}
	if($lastActionDB=="spin" and $lastAction!="mirror" and $bonusSymbCount==0)
	{
	 if(($has3symb+$has4symb+$has5symb+$has6symb+$has7symb)>2)
	    if(rand(0,1000)<$symbTransformRate)
	    {
		$lastAction="symbol_transform";
	    }
	}

	if ($lastAction!="mirror" and $lastAction!="symbol_transform" and $bonusSymbCount==0)
	{
         if(rand(0,1000)<$symbolOverlayRate)
	 {
	    $lastAction="symbol_overlay";
	 }
	}

	if ($lastAction!="mirror" and $lastAction!="symbol_transform" and $lastAction!="symbol_overlay")
	{
         if(rand(0,1000)<$mirror2Rate)
	 {
	    $lastAction="mirror2";
	 }
	}
    }
 }
*/

	if ($lastAction != "bonusgame" and $lastAction != "emptySpin")
		include($gamePath . 'lines.php');
	else $symb_combs .= " fake spin;";
	//////////
	//draw rs
	//////////

	$wild = 0;
	$nearwin = 0;
	$nearwinstr = '';
	$map = 0;
	$anim_num = 0;

	for ($i = 0; $i < 5; $i++) {
		if ($overlaySym != 0) {
			for ($j = 0; $j < 3; $j++) {
			}
			if ($lastAction == "symbol_transform")		$anim_num = 0;
		}

		$output .= "rs.i0.r.i" . $i . ".hold=false&";
		$output .= "rs.i0.r.i" . $i . ".pos=" . $positions[$i] . "&";
		$lastRs .= "rs.i0.r.i" . $i . ".syms=SYM" . $symbolsOverlayed[$i][0] . ",SYM" . $symbolsOverlayed[$i][1] . ",SYM" . $symbolsOverlayed[$i][2] . "&";
	}
	$output .= $lastRs;

	/////////////////////////////
	//draw ws			
	///////////////////////////
	$anim_num = 0;
	$total_win = 0;

	if ($lastAction == "startbonus") {
		$output .= "ws.i0.reelset=basic&";
		$output .= "ws.i0.direction=left_to_right&";
		$output .= "ws.i0.betline=null&";
		$output .= "ws.i0.sym=SYM2&";
		$output .= "ws.i0.types.i0.bonusid=mf2bonus&";
		$output .= "ws.i0.types.i0.wintype=bonusgame&";
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == 0) {
					$output .= "ws.i0.pos.i" . $anim_num . "=" . $i . "," . $j . "&";
					$anim_num++;
				}
			}
		}

		$anim_num = 1;
	}

	if ($lastAction == "startfreespin") {
		foreach ($symbolsOverlayed as $tReel => $t)
			foreach ($t as $tRow => $e) {
				if ($symbolsOverlayed[$tReel][$tRow] == 0)
					$output .= "ws.i" . $anim_num . ".pos.i0=" . $tReel . "%2C" . $tRow . "&";
			}
		$output .= "ws.i" . $anim_num . ".betline=null&";
		$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
		$output .= "ws.i" . $anim_num . ".reelset=basic&";
		$output .= "ws.i" . $anim_num . ".sym=SYM0&";
		$output .= "ws.i" . $anim_num . ".types.i0.freespins=" . $buster_tries . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.multipliers=1&";
		$output .= "ws.i" . $anim_num . ".types.i0.wintype=freespins&";

		$fs_left = $buster_tries;
		$anim_num++;
	}


	foreach ($win as $e => $v) {
		$tmp = explode("_", $v);

		if ($lastAction != "freespin") $output .= "ws.i" . $anim_num . ".reelset=basic&";

		else $output .= "ws.i" . $anim_num . ".reelset=freespin&";

		if ($lastAction == "freespin") {
			$tmp2 = 'busterWin' . $symbOverlays[$e];
			$$tmp2 += $tmp[0];
			//	    echo "<br>BW (".$tmp2.")".$$tmp2."---<br>";
		}

		$right_coins = $tmp[0] * $denomDB;

		$output .= "ws.i" . $anim_num . ".sym=SYM" . $symbOverlays[$e] . "&";

		$output .= "ws.i" . $anim_num . ".direction=left_to_right&";
		$output .= "ws.i" . $anim_num . ".betline=0&";
		$output .= "ws.i" . $anim_num . ".types.i0.coins=" . $tmp[0] . "&";
		$output .= "ws.i" . $anim_num . ".types.i0.cents=" . $right_coins . "&";

		$output .= "ws.i" . $anim_num . ".types.i0.wintype=coins&";

		$total_win += $tmp[0];

		$ani = explode(";", $tmp[1]);
		$i = 0;

		foreach ($ani as $smb) {
			$output .= "ws.i" . $anim_num . ".pos.i" . $i . "=" . $smb . "&";
			$i++;
		}
		$anim_num++;
	}

	/*
	    if($lastAction=="startfreespin")
	    {
		$output.= "ws.i".$anim_num.".betline=0&";
		$output.= "ws.i".$anim_num.".direction=left_to_right&";
		$output.= "ws.i".$anim_num.".pos.i0=0%2C0&";
		$output.= "ws.i".$anim_num.".pos.i1=1%2C0&";
		$output.= "ws.i".$anim_num.".pos.i2=2%2C0&";
		$output.= "ws.i".$anim_num.".pos.i3=3%2C0&";
		$output.= "ws.i".$anim_num.".pos.i4=4%2C0&";
		$output.= "ws.i".$anim_num.".pos.i5=0%2C1&";
		$output.= "ws.i".$anim_num.".pos.i6=1%2C1&";
		$output.= "ws.i".$anim_num.".pos.i7=2%2C1&";
		$output.= "ws.i".$anim_num.".pos.i8=3%2C1&";
		$output.= "ws.i".$anim_num.".pos.i9=4%2C1&";
		$output.= "ws.i".$anim_num.".pos.i10=0%2C2&";
		$output.= "ws.i".$anim_num.".pos.i11=1%2C2&";
		$output.= "ws.i".$anim_num.".pos.i12=2%2C2&";
		$output.= "ws.i".$anim_num.".pos.i13=3%2C2&";
		$output.= "ws.i".$anim_num.".pos.i14=4%2C2&";


		$output.= "ws.i".$anim_num.".betline=null&";
		$output.= "ws.i".$anim_num.".direction=left_to_right&";
		$output.= "ws.i".$anim_num.".reelset=basic&";
		$output.= "ws.i".$anim_num.".sym=SYM0&";
		$output.= "ws.i".$anim_num.".types.i0.freespins=".$buster_tries."&";
		$output.= "ws.i".$anim_num.".types.i0.multipliers=1&";
		$output.= "ws.i".$anim_num.".types.i0.wintype=freespins&";
	    }
*/

	if ($lastAction == "freespin") {
		$fs_total = $fs_left + $fs_played;
		$fs_totalwin += $total_win;
		$table_locked = 1;

		if ($fs_left == 0 and $lastAction == "freespin") {
			$output .= "gamestate.current=basic&";
			$output .= "nextaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "next.rs=basic&";
			$lastAction = "endfreespin";



			$output .= "rs.i0.id=basic&";
			$output .= "current.rs.i0=basic&";
			$output .= "next.rs=basic&";
			$output .= "previous.rs.i0=basic&";
			$output .= "last.rs=basic&";
			$output .= "clientaction=spin&";
			$output .= "gamestate.stack=basic&";
			$output .= "gamestate.history=basic&";


			$botAction = "spin";
			$table_locked = 0;
		} else {
			$output .= "rs.i0.id=freespin&";

			$output .= "current.rs.i0=freespin&";
			$output .= "next.rs=freespin&";
			$output .= "nextaction=freespin&";

			$botAction = "freespin";

			$output .= "last.rs=freespin&";
			$output .= "previous.rs.i0=freespin&";
			$output .= "clientaction=freespin&";

			$output .= "gamestate.current=freespin&";
			$output .= "gamestate.stack=basic%2Cfreespin&";
			$output .= "gamestate.history=basic%2C2Cfreespin&";

			$table_locked = 1;
			$gameover = 'false';
		}

		$output .= "freespins.total=" . $fs_total . "&";
		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.played=" . $fs_played . "&";
		$output .= "freespins.totalwin.coins=" . $fs_totalwin . "&";
		$output .= "freespins.totalwin.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.cents=" . $fs_totalwin . "&";
		$output .= "freespins.win.coins=" . $fs_totalwin . "&";

		$symb_combs .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";";
	} elseif ($lastAction == "startfreespin") {
		$output .= "clientaction=spin&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.initial=" . $buster_tries . "&";
		$output .= "freespins.left=" . $buster_tries . "&";
		$output .= "freespins.multiplier=1&";
		$output .= "freespins.total=3&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.win.coins=0&";
		$output .= "gamestate.current=freespin&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.stack=basic%2Cfreespin&";
		$output .= "nextaction=freespin&";
		$output .= "rs.i0.id=basic&";

		$fs_left = $buster_tries;
		$fs_played = 0;
		$fs_totalwin = 0;
		$gameover = 'false';
		$botAction = "spin";
		$table_locked = 1;
	} elseif ($lastAction == "startbonus") {
		$output .= "clientaction=spin&";
		$output .= "gamestate.bonusid=mf2bonus&";
		$output .= "gamestate.current=bonus&";
		$output .= "gamestate.previous=basic&";
		$output .= "gamestate.history=basic&";
		$output .= "gamestate.stack=basic%2Cbonus&";
		$output .= "nextaction=bonusaction&";
		$output .= "nextactiontype=pickbonus&";
		$output .= "rs.i0.id=basic&";

		$fs_left = $buster_tries;
		$gameover = 'false';
		$botAction = "spin";
		$table_locked = 1;
	} else {

		$output .= "rs.i0.id=basic&";
		$output .= "current.rs.i0=basic&";

		$output .= "clientaction=spin&";
		$output .= "nextaction=spin&";

		$output .= "gamestate.current=basic&";
		$output .= "gamestate.stack=basic&";
		$output .= "gamestate.history=basic&";

		$botAction = "spin";
		$table_locked = 0;
	}


	if ($lastAction != 'emptySpin') {

		$spincost = 0;
		if ($lastAction != 'freespin' and $lastAction != 'endfreespin') {
			$spin_to_history = 1;
			//	$spincost=$betDB*$denomDB*0.1;
		}
		if ($lastAction == 'lastrespin' and isset($fs_left)) {
			$spin_to_history = 0;
			$spincost = 0;
		}


		//    if($lastAction!='respin' and $lastAction!='freespin' and $lastAction!='endfreespin') {$credit-=$spincost;}

		if ($lastAction == 'startfreespin' or $lastAction == 'startbonus') {
			$credit /= 100;
			$real_win = $total_win * $denomDB * 0.01;
			$credit += $real_win;
			$creditDB = $credit * 100;
			$credit *= 100;
		}

		if ($lastAction == 'freespin') {
			$wilds = $wildsDB;
			$dop2 .= "(" . $wildsDB . ")";
		}

		if ($lastAction == 'mirrorFS' or $lastAction == 'freespin' or $lastAction == 'endfreespin') $totalWinsDB = $fs_totalwin;
		elseif ($lastAction == 'respin' and isset($fs_left)) $totalWinsDB = $fs_totalwin;
		elseif ($lastAction == 'lastrespin' and isset($fs_left)) $totalWinsDB = $fs_totalwin;
		elseif ($lastAction != 'respin' and $lastAction != 'mirror' and $lastAction != 'mirror2') $totalWinsDB = $total_win;
	}
}

if ($lastAction == "freespin" or $lastAction == "startfreespin" or $lastAction == "initfreespin") {
	$answ .= "fs_left=" . $fs_left . ";fs_played=" . $fs_played . ";fs_totalwin=" . $fs_totalwin . ";" . $answFS;
	if ($lastAction == "freespin")
		for ($i = 6; $i <= 12; $i++) {
			$tmp2 = 'busterWin' . $i;
			if (isset($$tmp2)) $answ .= $tmp2 . "=" . $$tmp2 . ";";
		}
}
if ($lastAction == "initbonus" or $lastAction == "bonusaction") {
	$answ .= "bonus_totalwin=" . $bonus_totalwin . ";phase=" . $phase . ";";
}

echo "LADB=$lastActionDB&LA=$lastAction&";
$query = "answer='" . $answ . "'";

$query .= ", locked='" . $table_locked . "'";

$query .= ", lastAction='" . $lastAction . "',wilds='" . $wilds . "', lastRs='" . $lastRs . "'";

$query = "UPDATE ns.states set " . $query . " where sessionId='" . $_GET['sessid'] . "';";

//echo "<br><br>".$query;

$result = mysql_query($query);
