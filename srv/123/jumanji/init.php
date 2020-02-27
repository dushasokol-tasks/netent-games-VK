<?
$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";
$clientAction = "init";
$clientRS = "basic";


$randomwildsActive = "false";
$stickyActive = "false";
$shuffleActive = "false";
$wildreelsActive = "false";

if ($rollsleft == 0 and $fs_type == "none") {
} elseif ($rollsleft == 0 and $fs_type != "none" and $fs_left < 1) {
} else {
	if (($lastActionDB == "initbonus" or $lastActionDB == "startbonus") and $rollsleft > 0) {
		$gameover = "false";
		$restore = "true";
		$gsStack = "basic%2Crespin";
		$gsCur = "bonus";
		$nesxAct = "bonusaction";

		$answ .= "restoreAction=initbonus;rollsleft=$rollsleft;bonuswin=$bonuswin;boardposition=$boardposition;token=$token;";

		$output = "bonus.rollsleft=$rollsleft&";
		$output .= "bonus.board.position=$boardposition&";

		$output .= "nextactiontype=selecttoken&";

		$output .= "gamestate.history=basic&";
		$output .= "gamestate.bonusid=alan-bonus&";
		$output .= "gamestate.stack=basic%2Cbonus&";

		$output .= "bonus.field.i0.type=mystery&bonus.field.i0.value=unrevealed&";
		$output .= "bonus.field.i1.type=coin&bonus.field.i1.value=1&";
		$output .= "bonus.field.i2.type=reroll&bonus.field.i2.value=1&";
		$output .= "bonus.field.i3.type=coin&bonus.field.i3.value=5&";
		$output .= "bonus.field.i4.type=feature&bonus.field.i4.value=stickywin&";
		$output .= "bonus.field.i5.type=feature&bonus.field.i5.value=stickywin&";
		$output .= "bonus.field.i6.type=reroll&bonus.field.i6.value=1&";
		$output .= "bonus.field.i7.type=coin&bonus.field.i7.value=1&";
		$output .= "bonus.field.i8.type=mystery&bonus.field.i8.value=unrevealed&";
		$output .= "bonus.field.i9.type=reroll&bonus.field.i9.value=1&";
		$output .= "bonus.field.i10.type=coin&bonus.field.i10.value=1&";
		$output .= "bonus.field.i11.type=feature&bonus.field.i11.value=wildreels&";
		$output .= "bonus.field.i12.type=feature&bonus.field.i12.value=wildreels&";
		$output .= "bonus.field.i13.type=coin&bonus.field.i13.value=1&";
		$output .= "bonus.field.i14.type=coin&bonus.field.i14.value=1&";
		$output .= "bonus.field.i15.type=coin&bonus.field.i15.value=2&";
		$output .= "bonus.field.i16.type=mystery&bonus.field.i16.value=unrevealed&";
		$output .= "bonus.field.i17.type=coin&bonus.field.i17.value=1&";
		$output .= "bonus.field.i18.type=reroll&bonus.field.i18.value=1&";
		$output .= "bonus.field.i19.type=coin&bonus.field.i19.value=1&";
		$output .= "bonus.field.i20.type=feature&bonus.field.i20.value=shuffle&";
		$output .= "bonus.field.i21.type=feature&bonus.field.i21.value=shuffle&";
		$output .= "bonus.field.i22.type=coin&bonus.field.i22.value=1&";
		$output .= "bonus.field.i23.type=coin&bonus.field.i23.value=1&";
		$output .= "bonus.field.i24.type=mystery&bonus.field.i24.value=unrevealed&";
		$output .= "bonus.field.i25.type=coin&bonus.field.i25.value=3&";
		$output .= "bonus.field.i26.type=coin&bonus.field.i26.value=1&";
		$output .= "bonus.field.i27.type=feature&bonus.field.i27.value=randomwilds&";
		$output .= "bonus.field.i28.type=feature&bonus.field.i28.value=randomwilds&";
		$output .= "bonus.field.i29.type=coin&bonus.field.i29.value=1&";
		$output .= "bonus.field.i30.type=coin&bonus.field.i30.value=1&";
		$output .= "bonus.field.i31.type=coin&bonus.field.i31.value=1&";

		$output .= "bonuswin.cents=0&bonuswin.coins=0&totalbonuswin.cents=$bonuswin&totalbonuswin.coins=$bonuswin&";
		$output .= "bonusgame.coinvalue=0.01&";

		$table_locked = 1;
	}

	if (($lastActionDB == "bonusaction") and $rollsleft > 0) {
		$gameover = "false";
		$restore = "true";
		$gsStack = "basic%2Cbonus";
		$gsCur = "bonus";
		$nesxAct = "bonusaction";
		$answ = "restoreAction=$lastActionDB;" . $answer;

		$output .= "gamestate.bonusid=alan-bonus&";

		$clientAction = "bonusaction";

		$output .= "nextaction=bonusaction&";
		$output .= "nextactiontype=roll&";

		$output .= "bonusgame.coinvalue=0.01&";

		$output .= "bonus.rollsleft=" . $rollsleft . "&";
		$output .= "bonus.board.position=" . $boardposition . "&";
		$output .= "bonus.token=" . $token . "&";

		$output .= "totalbonuswin.cents=" . $bonuswin . "&";
		$output .= "totalbonuswin.coins=" . $bonuswin . "&";
		$output .= "bonuswin.cents=" . ($coinWin * $mysteryMul) . "&";
		$output .= "bonuswin.coins=" . ($coinWin * $mysteryMul) . "&";

		$table_locked = 1;
	}


	if (
		$lastActionDB == "freespin" or $lastActionDB == "initfreespin" or (($lastActionDB == "sticky" or $lastActionDB == "respin" or $lastActionDB == "lastrespin") and $fs_type == "sticky")
		or (($lastActionDB == "shuffle" or $lastActionDB == "aftershuffle") and $fs_type == "shuffle")
	) {

		if (($lastActionDB == "freespin" or $lastActionDB == "sticky" or $lastActionDB == "respin" or $lastActionDB == "lastrespin") and $fs_type == "sticky")	$answer .= "wildStcks=" . $wildsDB . ";";

		$gameover = "false";
		$restore = "true";

		$gsStack = "basic%2Cfreespin";
		$gsCur = "freespin";
		$nesxAct = "freespin";


		$multiplier = 1;

		$output .= "bonus.rollsleft=$rollsleft&bonus.token=$token&bonus.board.position=$boardposition&";

		$output .= "gamestate.history=basic%2Cbonus&gamestate.bonusid=alan-bonus&";

		$output .= "current.rs.i0=freespin&";
		$output .= "nextaction=freespin&";
		$clientAction = "initfreespin";

		$output .= "next.rs=freespin&";

		$output .= "nextactiontype=roll&";

		$output .= "freespins.left=" . $fs_left . "&";
		$output .= "freespins.initial=" . $fs_initial . "&";
		$output .= "freespins.total=" . $fs_left . "&";
		$output .= "freespins.win.cents=0&";
		$output .= "freespins.win.coins=0&";
		$output .= "freespins.totalwin.cents=0&";
		$output .= "freespins.totalwin.coins=0&";
		$output .= "freespins.betlevel=1&";
		$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
		$output .= "freespins.denomination=1.000&";
		$output .= "freespins.wavecount=1&";
		$output .= "freespins.multiplier=1&";

		$output .= "bet.denomination=1&bet.betlevel=1&bet.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";

		$coinWin = $bonuswin;
		$mysteryMul = 1;
		$totalWinsDB = $bonuswin;
		$total_winCents = $bonuswin;
		$fs_totalwin = $bonuswin;


		if ($fs_type == 'sticky') {
			$output .= "rs.i0.id=basic&";
			$output .= "rs.i1.id=respin&";
			$output .= "rs.i2.id=freespin&";

			$clientRS = "stickyfsa";
			$output .= "feature.sticky.respin=false&";
			$stickyActive = "true";
			$bonusStickyDisabled = "true";

			$output .= "rs.i0.r.i0.syms=SYM7%2CSYM9%2CSYM9&rs.i0.r.i1.syms=SYM8%2CSYM0%2CSYM7%2CSYM7&rs.i0.r.i2.syms=SYM3%2CSYM6%2CSYM6%2CSYM5%2CSYM5&rs.i0.r.i3.syms=SYM5%2CSYM5%2CSYM9%2CSYM0&rs.i0.r.i4.syms=SYM9%2CSYM0%2CSYM7&";
			$output .= "rs.i1.r.i0.syms=SYM7&rs.i1.r.i1.syms=SYM7&rs.i1.r.i2.syms=SYM7&rs.i1.r.i3.syms=SYM11&rs.i1.r.i4.syms=SYM7&rs.i1.r.i5.syms=SYM7&rs.i1.r.i6.syms=SYM11&rs.i1.r.i7.syms=SYM11&rs.i1.r.i8.syms=SYM7&rs.i1.r.i9.syms=SYM11&rs.i1.r.i10.syms=SYM7&rs.i1.r.i11.syms=SYM11&rs.i1.r.i12.syms=SYM11&rs.i1.r.i13.syms=SYM7&rs.i1.r.i14.syms=SYM7&rs.i1.r.i15.syms=SYM11&rs.i1.r.i16.syms=SYM11&rs.i1.r.i17.syms=SYM7&rs.i1.r.i18.syms=SYM11&";
			$output .= "rs.i2.r.i0.syms=SYM6%2CSYM6%2CSYM7&rs.i2.r.i1.syms=SYM4%2CSYM4%2CSYM7%2CSYM7&rs.i2.r.i2.syms=SYM7%2CSYM7%2CSYM6%2CSYM6%2CSYM5&rs.i2.r.i3.syms=SYM4%2CSYM4%2CSYM8%2CSYM8&rs.i2.r.i4.syms=SYM8%2CSYM8%2CSYM7&";
		}
		if ($fs_type == 'wildreels') {
			$output .= "rs.i0.id=basic&";
			$output .= "rs.i1.id=respin&";
			$output .= "rs.i2.id=freespin&";

			$clientRS = "wildfeatures";
			$wildreelsActive = "true";
			$bonusWildreelsDisabled = "true";

			$output .= "rs.i0.r.i0.syms=SYM10%2CSYM0%2CSYM6&";
			$output .= "rs.i0.r.i1.syms=SYM10%2CSYM10%2CSYM0%2CSYM8&";
			$output .= "rs.i0.r.i2.syms=SYM10%2CSYM6%2CSYM6%2CSYM7%2CSYM7&";
			$output .= "rs.i0.r.i3.syms=SYM9%2CSYM6%2CSYM6%2CSYM10&";
			$output .= "rs.i0.r.i4.syms=SYM10%2CSYM10%2CSYM0&";
		}

		if ($fs_type == 'shuffle') {
			$output .= "rs.i0.id=respin&";
			$output .= "rs.i1.id=freespin&";
			$output .= "rs.i2.id=basic&";

			$clientRS = "shuffle&";
			$shuffleActive = "true";
			$bonusShuffleDisabled = "true";

			$output .= "rs.i0.r.i0.syms=SYM7%2CSYM7%2CSYM9&";
			$output .= "rs.i0.r.i1.syms=SYM3%2CSYM9%2CSYM9%2CSYM7&";
			$output .= "rs.i0.r.i2.syms=SYM9%2CSYM9%2CSYM0%2CSYM6%2CSYM6&";
			$output .= "rs.i0.r.i3.syms=SYM0%2CSYM7%2CSYM7%2CSYM9&";
			$output .= "rs.i0.r.i4.syms=SYM0%2CSYM5%2CSYM5&";

			$output .= "rs.i1.r.i0.syms=SYM7&";
			$output .= "rs.i1.r.i1.syms=SYM7&";
			$output .= "rs.i1.r.i2.syms=SYM7&";
			$output .= "rs.i1.r.i3.syms=SYM11&";
			$output .= "rs.i1.r.i4.syms=SYM7&";
			$output .= "rs.i1.r.i5.syms=SYM7&";
			$output .= "rs.i1.r.i6.syms=SYM11&";
			$output .= "rs.i1.r.i7.syms=SYM11&";
			$output .= "rs.i1.r.i8.syms=SYM7&";
			$output .= "rs.i1.r.i9.syms=SYM11&";
			$output .= "rs.i1.r.i10.syms=SYM7&";
			$output .= "rs.i1.r.i11.syms=SYM11&";
			$output .= "rs.i1.r.i12.syms=SYM11&";
			$output .= "rs.i1.r.i13.syms=SYM7&";
			$output .= "rs.i1.r.i14.syms=SYM7&";
			$output .= "rs.i1.r.i15.syms=SYM11&";
			$output .= "rs.i1.r.i16.syms=SYM11&";
			$output .= "rs.i1.r.i17.syms=SYM7&";
			$output .= "rs.i1.r.i18.syms=SYM11&";

			$output .= "rs.i2.r.i0.syms=SYM6%2CSYM6%2CSYM7&";
			$output .= "rs.i2.r.i1.syms=SYM4%2CSYM4%2CSYM7%2CSYM7&";
			$output .= "rs.i2.r.i2.syms=SYM7%2CSYM7%2CSYM6%2CSYM6%2CSYM5&";
			$output .= "rs.i2.r.i3.syms=SYM4%2CSYM4%2CSYM8%2CSYM8&";
			$output .= "rs.i2.r.i4.syms=SYM8%2CSYM8%2CSYM7&";
		}

		if ($fs_type == 'randomwilds') {
			$output .= "rs.i0.id=basic&";
			$output .= "rs.i1.id=respin&";
			$output .= "rs.i2.id=freespin&";


			$clientRS = "wildfeatures";
			$randomwildsActive = "true";
			$bonusRandomwildsDisabled = "true";

			$output .= "rs.i0.r.i0.syms=SYM7%2CSYM3%2CSYM3&";
			$output .= "rs.i0.r.i1.syms=SYM6%2CSYM0%2CSYM8%2CSYM8&";
			$output .= "rs.i0.r.i2.syms=SYM8%2CSYM9%2CSYM9%2CSYM0%2CSYM6&";
			$output .= "rs.i0.r.i3.syms=SYM8%2CSYM10%2CSYM10%2CSYM0&";
			$output .= "rs.i0.r.i4.syms=SYM5%2CSYM10%2CSYM10&";
		}


		if ($fs_left > 0)	$answ = "restoreAction=$lastActionDB;" . $answer;
		else {
			$answ = "restoreAction=bonuasction;" . $answer;
			$output = "";
			$gameover = "false";
			$restore = "true";
			$gsStack = "basic%2Cbonus";
			$gsCur = "bonus";
			$nesxAct = "bonusaction";
			$answ = "restoreAction=$lastActionDB;" . $answer;

			$output .= "gamestate.bonusid=alan-bonus&";

			$clientAction = "bonusaction";

			$output .= "nextaction=bonusaction&";
			$output .= "nextactiontype=roll&";

			$output .= "bonusgame.coinvalue=0.01&";

			$output .= "bonus.rollsleft=" . $rollsleft . "&";
			$output .= "bonus.board.position=" . $boardposition . "&";
			$output .= "bonus.token=" . $token . "&";

			$output .= "totalbonuswin.cents=" . $bonuswin . "&";
			$output .= "totalbonuswin.coins=" . $bonuswin . "&";
			$output .= "bonuswin.cents=" . ($coinWin * $mysteryMul) . "&";
			$output .= "bonuswin.coins=" . ($coinWin * $mysteryMul) . "&";
		}

		if ($bonusStickyDisabled == "true") {
			$answ .= "bonusStickyDisabled=$bonusStickyDisabled;";
			$bonusStickyDisabled = "aftertrue";
		}
		if ($bonusWildreelsDisabled == "true") {
			$answ .= "bonusWildreelsDisabled=$bonusWildreelsDisabled;";
			$bonusWildreelsDisabled = "aftertrue";
		}
		if ($bonusShuffleDisabled == "true") {
			$answ .= "bonusShuffleDisabled=$bonusShuffleDisabled;";
			$bonusShuffleDisabled = "aftertrue";
		}
		if ($bonusRandomwildsDisabled == "true") {
			$answ .= "bonusRandomwildsDisabled=$bonusRandomwildsDisabled;";
			$bonusRandomwildsDisabled = "aftertrue";
		}
	} elseif ($rollsleft > 0 and ($lastActionDB == "aftershuffle" or $lastActionDB == "shuffle" or $lastActionDB == "sticky" or $lastActionDB == "respin" or $lastActionDB == "lastrespin")) {
		$answ = "restoreAction=bonuasction;" . $answer;
		$output = "";
		$gameover = "false";
		$restore = "true";
		$gsStack = "basic%2Cbonus";
		$gsCur = "bonus";
		$nesxAct = "bonusaction";
		$answ = "restoreAction=$lastActionDB;" . $answer;

		$output .= "gamestate.bonusid=alan-bonus&";

		$clientAction = "bonusaction";

		$output .= "nextaction=bonusaction&";
		$output .= "nextactiontype=roll&";

		$output .= "bonusgame.coinvalue=0.01&";

		$output .= "bonus.rollsleft=" . $rollsleft . "&";
		$output .= "bonus.board.position=" . $boardposition . "&";
		$output .= "bonus.token=" . $token . "&";

		$output .= "totalbonuswin.cents=" . $bonuswin . "&";
		$output .= "totalbonuswin.coins=" . $bonuswin . "&";
		$output .= "bonuswin.cents=" . ($coinWin * $mysteryMul) . "&";
		$output .= "bonuswin.coins=" . ($coinWin * $mysteryMul) . "&";
	}

	$table_locked = 1;
}


$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";








//$output="";


$output .= "confirmBetMessageEnabled=false&";
$output .= "gameEventSetters.enabled=false&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "iframeEnabled=false&";
$output .= "nearwinallowed=true&";
//$output.="restore=false&";

$output .= "clientaction=$clientAction&";
//$output.="clientaction=bonus&";

$output .= "nextclientrs=$clientRS&";
//$output.="nextclientrs=basic&";


$output .= "rs.i0.id=basic&";
/*
$output.="feature.sticky.active=false&";
$output.="feature.wildreels.active=false&";
$output.="feature.shuffle.active=false&";
$output.="feature.randomwilds.active=false&";
*/
$output .= "feature.randomwilds.active=$randomwildsActive&";
$output .= "feature.sticky.active=$stickyActive&";
$output .= "feature.shuffle.active=$shuffleActive&";
$output .= "feature.wildreels.active=$wildreelsActive&";

$output .= "game.win.cents=0&";
$output .= "totalwin.cents=0&";
$output .= "wavecount=1&";
$output .= "game.win.coins=0&";
$output .= "totalwin.coins=0&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
$output .= "game.win.amount=0&";
$output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";

if (!isset($_Social) or $_Social == '')    $output .= "denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100%2C200&";
else {
	$output .= "denomination.all=1";
	if ($_Social['denomLevel'] > 0) $output .= "%2C2";
	if ($_Social['denomLevel'] > 1) $output .= "%2C5";
	if ($_Social['denomLevel'] > 2) $output .= "%2C10";
	if ($_Social['denomLevel'] > 3) $output .= "%2C20";
	if ($_Social['denomLevel'] > 4) $output .= "%2C50";
	if ($_Social['denomLevel'] > 5) $output .= "%2C100";
	if ($_Social['denomLevel'] > 6) $output .= "%2C200";
	$output .= "&";
	if ($_Social['denomLevel'] == 0) $denomDB = "1";
	if ($_Social['denomLevel'] == 1) $denomDB = "2";
	if ($_Social['denomLevel'] == 2) $denomDB = "5";
	if ($_Social['denomLevel'] == 3) $denomDB = "10";
	if ($_Social['denomLevel'] == 4) $denomDB = "20";
	if ($_Social['denomLevel'] == 5) $denomDB = "50";
	if ($_Social['denomLevel'] == 6) $denomDB = "100";
	if ($_Social['denomLevel'] == 7) $denomDB = "200";
}
$output .= "denomination.standard=" . $denomDB . "&";
$output .= "betlevel.standard=10&";

/*

if(!isset($_Social)) $output.="denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100%2C200&";
    else{
	    $output.= "denomination.all=1";
	    if($_Social['denomLevel']>0) $output.= "%2C2";
	    if($_Social['denomLevel']>1) $output.= "%2C5";
	    if($_Social['denomLevel']>2) $output.= "%2C10";
	    if($_Social['denomLevel']>3) $output.= "%2C20";
	    if($_Social['denomLevel']>4) $output.= "%2C50";
	    if($_Social['denomLevel']>5) $output.= "%2C100";
	    if($_Social['denomLevel']>6) $output.= "%2C200";
	    $output.="&";
	}
*/
//$output.="denomination.standard=1&";

$output .= "historybutton=false&";
$output .= "g4mode=false&";
$output .= "multiplier=1&";
$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "&";
$output .= "playercurrencyiso=EUR&";
$output .= "playercurrency=%26%23x20AC%3B&";
$output .= "playforfun=false&";
$output .= "jackpotcurrencyiso=EUR&";
$output .= "gameover=true&";
$output .= "isJackpotWin=false&";
$output .= "jackpotcurrency=%26%23x20AC%3B&";
$output .= "rs.i2.id=respin&";
$output .= "rs.i1.id=freespin&";

$output .= "rs.i0.r.i0.syms=SYM9%2CSYM9%2CSYM10&";
$output .= "rs.i0.r.i1.syms=SYM8%2CSYM8%2CSYM0%2CSYM7&";
$output .= "rs.i0.r.i2.syms=SYM6%2CSYM6%2CSYM7%2CSYM7%2CSYM9&";
$output .= "rs.i0.r.i3.syms=SYM8%2CSYM8%2CSYM10%2CSYM10&";
$output .= "rs.i0.r.i4.syms=SYM4%2CSYM4%2CSYM9&";


$output .= "rs.i1.r.i0.syms=SYM6%2CSYM6%2CSYM7&";
$output .= "rs.i1.r.i1.syms=SYM4%2CSYM4%2CSYM7%2CSYM7&";
$output .= "rs.i1.r.i2.syms=SYM7%2CSYM7%2CSYM6%2CSYM6%2CSYM5&";
$output .= "rs.i1.r.i3.syms=SYM4%2CSYM4%2CSYM8%2CSYM8&";
$output .= "rs.i1.r.i4.syms=SYM8%2CSYM8%2CSYM7&";


$output .= "rs.i2.r.i0.syms=SYM7&";
$output .= "rs.i2.r.i1.syms=SYM7&";
$output .= "rs.i2.r.i2.syms=SYM7&";
$output .= "rs.i2.r.i3.syms=SYM11&";
$output .= "rs.i2.r.i4.syms=SYM7&";
$output .= "rs.i2.r.i5.syms=SYM7&";
$output .= "rs.i2.r.i6.syms=SYM11&";
$output .= "rs.i2.r.i7.syms=SYM11&";
$output .= "rs.i2.r.i8.syms=SYM7&";
$output .= "rs.i2.r.i9.syms=SYM11&";
$output .= "rs.i2.r.i10.syms=SYM7&";
$output .= "rs.i2.r.i11.syms=SYM11&";
$output .= "rs.i2.r.i12.syms=SYM11&";
$output .= "rs.i2.r.i13.syms=SYM7&";
$output .= "rs.i2.r.i14.syms=SYM7&";
$output .= "rs.i2.r.i15.syms=SYM11&";
$output .= "rs.i2.r.i16.syms=SYM11&";
$output .= "rs.i2.r.i17.syms=SYM7&";
$output .= "rs.i2.r.i18.syms=SYM11&";



$output .= "rs.i0.r.i0.pos=0&";
$output .= "rs.i0.r.i1.pos=1&";
$output .= "rs.i0.r.i2.pos=5&";
$output .= "rs.i0.r.i3.pos=2&";
$output .= "rs.i0.r.i4.pos=0&";

$output .= "rs.i1.r.i0.pos=0&";
$output .= "rs.i1.r.i1.pos=0&";
$output .= "rs.i1.r.i2.pos=0&";
$output .= "rs.i1.r.i3.pos=0&";
$output .= "rs.i1.r.i4.pos=0&";

$output .= "rs.i2.r.i0.pos=0&";
$output .= "rs.i2.r.i1.pos=0&";
$output .= "rs.i2.r.i2.pos=0&";
$output .= "rs.i2.r.i3.pos=0&";
$output .= "rs.i2.r.i4.pos=0&";
$output .= "rs.i2.r.i5.pos=0&";
$output .= "rs.i2.r.i6.pos=0&";
$output .= "rs.i2.r.i7.pos=0&";
$output .= "rs.i2.r.i8.pos=0&";
$output .= "rs.i2.r.i9.pos=0&";
$output .= "rs.i2.r.i10.pos=0&";
$output .= "rs.i2.r.i11.pos=0&";
$output .= "rs.i2.r.i12.pos=0&";
$output .= "rs.i2.r.i13.pos=0&";
$output .= "rs.i2.r.i14.pos=0&";
$output .= "rs.i2.r.i15.pos=0&";
$output .= "rs.i2.r.i16.pos=0&";
$output .= "rs.i2.r.i17.pos=0&";
$output .= "rs.i2.r.i18.pos=0&";



$output .= "rs.i0.r.i0.hold=false&";
$output .= "rs.i0.r.i1.hold=false&";
$output .= "rs.i0.r.i2.hold=false&";
$output .= "rs.i0.r.i3.hold=false&";
$output .= "rs.i0.r.i4.hold=false&";


$output .= "rs.i1.r.i0.hold=false&";
$output .= "rs.i1.r.i1.hold=false&";
$output .= "rs.i1.r.i2.hold=false&";
$output .= "rs.i1.r.i3.hold=false&";
$output .= "rs.i1.r.i4.hold=false&";


$output .= "rs.i2.r.i0.hold=false&";
$output .= "rs.i2.r.i1.hold=false&";
$output .= "rs.i2.r.i2.hold=false&";
$output .= "rs.i2.r.i3.hold=false&";
$output .= "rs.i2.r.i4.hold=false&";
$output .= "rs.i2.r.i5.hold=false&";
$output .= "rs.i2.r.i6.hold=false&";
$output .= "rs.i2.r.i7.hold=false&";
$output .= "rs.i2.r.i8.hold=false&";
$output .= "rs.i2.r.i9.hold=false&";
$output .= "rs.i2.r.i10.hold=false&";
$output .= "rs.i2.r.i11.hold=false&";
$output .= "rs.i2.r.i12.hold=false&";
$output .= "rs.i2.r.i13.hold=false&";
$output .= "rs.i2.r.i14.hold=false&";
$output .= "rs.i2.r.i15.hold=false&";
$output .= "rs.i2.r.i16.hold=false&";
$output .= "rs.i2.r.i17.hold=false&";
$output .= "rs.i2.r.i18.hold=false&";




$output .= "bl.i0.line=0%2C0%2C0%2C0%2C0&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.i0.coins=10&";
$output .= "bl.i0.id=0&";







$output .= "bl.i16.reelset=ALL&";
$output .= "bl.i8.line=0%2C1%2C2%2C1%2C1&";
$output .= "bl.i35.reelset=ALL&";
$output .= "bl.i8.coins=0&";
$output .= "bl.i23.id=23&";
$output .= "bl.i15.coins=0&";
$output .= "bl.i2.line=0%2C0%2C1%2C1%2C0&";
$output .= "bl.i12.id=12&";
$output .= "bl.i29.id=29&";
$output .= "bl.i4.id=4&";
$output .= "bl.i7.coins=0&";
$output .= "bl.i6.reelset=ALL&";
$output .= "bl.i20.line=1%2C2%2C2%2C2%2C1&";
$output .= "bl.i20.reelset=ALL&";
$output .= "bl.i14.reelset=ALL&";
$output .= "bl.i32.reelset=ALL&";
$output .= "bl.i6.coins=0&";
$output .= "bl.i17.reelset=ALL&";
$output .= "bl.i15.id=15&";
$output .= "bl.i21.id=21&";
$output .= "bl.i23.reelset=ALL&";
$output .= "bl.i33.coins=0&";
$output .= "bl.i10.line=0%2C1%2C2%2C2%2C2&";
$output .= "bl.i20.coins=0&";
$output .= "bl.i18.coins=0&";
$output .= "bl.i10.id=10&";
$output .= "bl.i3.reelset=ALL&";
$output .= "bl.i4.line=0%2C1%2C1%2C0%2C0&";
$output .= "bl.i13.coins=0&";
$output .= "bl.i26.reelset=ALL&";
$output .= "bl.i24.line=1%2C2%2C3%2C3%2C2&";
$output .= "bl.i27.id=27&";
$output .= "bl.i2.id=2&";
$output .= "bl.i28.line=2%2C2%2C2%2C2%2C2&";
$output .= "bl.i22.line=1%2C2%2C3%2C2%2C1&";
$output .= "bl.i3.id=3&";
$output .= "bl.i12.coins=0&";
$output .= "bl.i8.reelset=ALL&";
$output .= "bl.i16.id=16&";
$output .= "bl.i5.coins=0&";
$output .= "bl.i8.id=8&";
$output .= "bl.i33.id=33&";
$output .= "bl.i22.id=22&";
$output .= "bl.i6.line=0%2C1%2C1%2C1%2C1&";
$output .= "bl.i12.line=1%2C1%2C1%2C1%2C0&";

$output .= "bl.i29.reelset=ALL&";
$output .= "bl.i34.line=2%2C3%2C3%2C3%2C2&";
$output .= "bl.i31.line=2%2C2%2C3%2C3%2C2&";
$output .= "bl.i34.coins=0&";
$output .= "bl.i27.coins=0&";
$output .= "bl.i34.reelset=ALL&";
$output .= "bl.i30.reelset=ALL&";
$output .= "bl.i1.id=1&";
$output .= "bl.i33.line=2%2C3%2C3%2C2%2C2&";
$output .= "bl.i25.id=25&";
$output .= "bl.i32.line=2%2C3%2C3%2C2%2C1&";
$output .= "bl.i31.id=31&";
$output .= "bl.i14.id=14&";
$output .= "bl.i19.line=1%2C2%2C2%2C1%2C1&";
$output .= "bl.i12.reelset=ALL&";
$output .= "bl.i6.id=6&";
$output .= "bl.i2.coins=0&";
$output .= "bl.i21.reelset=ALL&";
$output .= "bl.i20.id=20&";
$output .= "bl.i33.reelset=ALL&";
$output .= "bl.i24.coins=0&";
$output .= "bl.i5.reelset=ALL&";
$output .= "bl.i32.coins=0&";
$output .= "bl.i19.coins=0&";
$output .= "bl.i18.reelset=ALL&";
$output .= "bl.i7.id=7&";
$output .= "bl.i1.coins=0&";
$output .= "bl.i32.id=32&";
$output .= "bl.i14.line=1%2C1%2C2%2C1%2C0&";
$output .= "bl.i25.coins=0&";
$output .= "bl.i13.line=1%2C1%2C1%2C1%2C1&";
$output .= "bl.i24.reelset=ALL&";

$output .= "bl.i2.reelset=ALL&";
$output .= "bl.i31.coins=0&";
$output .= "bl.i26.coins=0&";
$output .= "bl.i27.reelset=ALL&";
$output .= "bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29%2C30%2C31%2C32%2C33%2C34%2C35&";
$output .= "bl.i29.line=2%2C2%2C3%2C2%2C1&";
$output .= "bl.i23.line=1%2C2%2C3%2C2%2C2&";
$output .= "bl.i26.id=26&";
$output .= "bl.i15.reelset=ALL&";
$output .= "bl.i11.line=1%2C1%2C1%2C0%2C0&";
$output .= "bl.i30.id=30&";
$output .= "bl.i25.line=2%2C2%2C2%2C1%2C0&";
$output .= "bl.i5.id=5&";
$output .= "bl.i3.coins=0&";
$output .= "bl.i10.coins=0&";
$output .= "bl.i18.id=18&";
$output .= "bl.i30.coins=0&";
$output .= "bl.i5.line=0%2C1%2C1%2C1%2C0&";
$output .= "bl.i28.coins=0&";
$output .= "bl.i27.line=2%2C2%2C2%2C2%2C1&";
$output .= "bl.i7.line=0%2C1%2C2%2C1%2C0&";
$output .= "bl.i35.id=35&";
$output .= "bl.i16.coins=0&";
$output .= "bl.i9.coins=0&";
$output .= "bl.i30.line=2%2C2%2C3%2C2%2C2&";
$output .= "bl.i7.reelset=ALL&";
$output .= "bl.i24.id=24&";
$output .= "bl.i22.coins=0&";
$output .= "bl.i29.coins=0&";
$output .= "bl.i31.reelset=ALL&";
$output .= "bl.i13.id=13&";
$output .= "bl.i9.line=0%2C1%2C2%2C2%2C1&";
$output .= "bl.i35.coins=0&";
$output .= "bl.i10.reelset=ALL&";
$output .= "bl.i25.reelset=ALL&";
$output .= "bl.i23.coins=0&";
$output .= "bl.i11.coins=0&";
$output .= "bl.i22.reelset=ALL&";
$output .= "bl.i13.reelset=ALL&";

$output .= "bl.i15.line=1%2C1%2C2%2C1%2C1&";
$output .= "bl.i19.id=19&";
$output .= "bl.i3.line=0%2C0%2C1%2C1%2C1&";
$output .= "bl.i4.reelset=ALL&";
$output .= "bl.i4.coins=0&";
$output .= "bl.i18.line=1%2C2%2C2%2C1%2C0&";
$output .= "bl.i34.id=34&";
$output .= "bl.i9.id=9&";
$output .= "bl.i17.line=1%2C1%2C2%2C2%2C2&";
$output .= "bl.i11.id=11&";
$output .= "bl.i9.reelset=ALL&";
$output .= "bl.i28.id=28&";
$output .= "bl.i17.coins=0&";
$output .= "bl.i19.reelset=ALL&";
$output .= "bl.i11.reelset=ALL&";
$output .= "bl.i16.line=1%2C1%2C2%2C2%2C1&";
$output .= "bl.i21.line=1%2C2%2C2%2C2%2C2&";
$output .= "bl.i35.line=2%2C3%2C4%2C3%2C2&";
$output .= "bl.i1.reelset=ALL&";
$output .= "bl.i28.reelset=ALL&";
$output .= "bl.i21.coins=0&";
$output .= "bl.i1.line=0%2C0%2C1%2C0%2C0&";
$output .= "bl.i17.id=17&";
$output .= "bl.i14.coins=0&";
$output .= "bl.i26.line=2%2C2%2C2%2C1%2C1&";
