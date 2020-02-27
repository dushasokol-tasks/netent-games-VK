<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";

if ($lastActionDB == "respin") {
    $gameover = "false";
    $restore = "true";
    $output .= "current.rs.i0=respin&next.rs=respin&wildstacks.respin=$wildsDB&";
    $gsStack = "basic%2Crespin";
    $gsCur = "respin";
    $nesxAct = "respin";
    $answ = "restoreAction=respin;wildStcks=" . $wildsDB . ";";
    $table_locked = 1;
}


if ($lastActionDB == "bonus_feature_pick") {
    $restore = "true";

    $gsStack = "basic%2Cbonus_feature_pick";
    $gsCur = "basic";
    $nesxAct = "bonus_feature_pick";

    $answ = "restoreAction=bonus_feature_pick;";

    $output .= "rs.i0.nearwin=4&";

    $output .= "bws.i0.pos.i0=0%2C0&";
    $output .= "bws.i0.pos.i1=2%2C0&";
    $output .= "bws.i0.pos.i2=4%2C0&";

    $output .= "current.rs.i0=basic_0&";
    $output .= "next.rs=basic_0&";
    $output .= "gamestate.history=basic&";

    $table_locked = 1;
}

if ($lastActionDB == "bonusgame" or $lastActionDB == "bonusaction") {
    $bonusInfo = explode(";", $answer);
    foreach ($bonusInfo as $e => $v)
        if ($v != '') {
            $a = explode("=", $v);
            $$a[0] = $a[1];
        }

    $gameover = "false";
    $restore = "true";
    $node_type = "coinwin";

    $totalWinsDB = $bonus_totalwin;
    $total_win = $bonus_totalwin * $denomDB;

    $result = mysql_query("SELECT symbols FROM ns.bonuses where payRate='" . $payRate . "' and type='7' and gameId='" . $gameId . "';");
    $row = mysql_fetch_assoc($result);
    $mapNodes = explode(";", $row['symbols']);
    foreach ($mapNodes as $v => $e) {
        $nodeData = explode("_", $e);
        if ($nodeData[0] != '') {
            $output .= "map.i" . $v . ".next=" . $nodeData[0] . "&";
            $output .= "map.i" . $v . ".coins=" . $nodeData[1] . "&";
            $output .= "map.i" . $v . ".type=" . $nodeData[2] . "&";
            if ($nodeData[3] != '') $output .= "map.i" . $v . ".arrow=" . $nodeData[3] . "&";
        }
    }

    if ($bonus_mult == "2") $curDlbPos = "true";
    else  $curDlbPos = "false";

    $node = explode("_", $mapNodes[$cur_pos]);

    if ($node[2] == 'arrow') {
        $output .= "bonus_game_results.arrow_position.win=2&";
        $output .= "bonus_game_results.arrow_position.id=" . $node[3] . "&";
        $output .= "bonus_game_results.arrow_position.double=" . $curDlbPos . "&";
        $output .= "bonus_game_results.arrow_position.type=coinwin&";
        $output .= "bonus_game_results.current_position.type=arrow&";
        $output .= "nextaction=bonusaction&";
        $output .= "bonus_game_results.gameover=false&";
    } elseif ($node[2] == 'double') {
        $curDlbPos = "true";
        $output .= "bonus_game_results.current_position.type=double&";
        $output .= "bonus_game_results.current_position.id=" . $node[3] . "&";
        $output .= "bonus_game_results.gameover=false&";
        $output .= "nextaction=bonusaction&";
    } else $node[2] = "coinwin";

    $output .= "bonus_game_results.gameover=false&";
    $output .= "bonus_game_results.current_position.type=" . $node[2] . "&";
    $output .= "bonus_game_results.diceroll=0&";
    $output .= "bonus_game_results.current_position.win=0&";
    $output .= "bonus_game_results.current_position.double=" . $curDlbPos . "&";
    $output .= "bonus_game_results.multiplier=" . $bonus_mult . "&";
    $output .= "bonus_game_results.current_position.id=" . $cur_pos . "&";
    $output .= "bonus_game_results.totalwin=" . $bonus_totalwin . "&";

    $output .= "bonuswin.cents=" . $bonus_totalwin . "&";
    $output .= "bonuswin.cents=" . ($bonus_totalwin * $denomDB) . "&";

    $output .= "totalbonuswin.coins=" . $bonus_totalwin . "&";
    $output .= "totalbonuswin.cents=" . ($bonus_totalwin * $denomDB) . "&";


    $output .= "gamestate.history=basic%2Cbonus_feature_pick&";

    $output .= "bonuswin.coins=0&";

    $output .= "bonusgame.coinvalue=0.05&";

    $output .= "clientaction=bonus_feature_pick&";

    $output .= "nextactiontype=pickbonus&";

    $output .= "gamestate.bonusid=grimmbonusgame&";

    $output .= "next.rs=basic_0&";
    $output .= "current.rs.i0=basic_0&";


    $gsStack = "basic%2Cbonus";
    $gsCur = "bonus";
    $nesxAct = "bonusaction";
    $answ .= "restoreAction=bonusaction;" . $answer;
}


if ($lastActionDB == "freespin" or $lastActionDB == "startfreespin") {

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

    $output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C21%2C22%2C23%2C24%2C25%2C26%2C27%2C28%2C29&";

    $table_locked = 1;
}


$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

if ($lastRsDB == '') {
    $lastRsDB = "rs.i0.r.i0.syms=SYM6%2CSYM4%2CSYM12&rs.i0.r.i1.syms=SYM11%2CSYM32%2CSYM32&rs.i0.r.i2.syms=SYM11%2CSYM12%2CSYM1&rs.i0.r.i3.syms=SYM9%2CSYM6%2CSYM8&rs.i0.r.i4.syms=SYM6%2CSYM7%2CSYM32&";
}

$output .= $lastRsDB;





$output .= "iframeEnabled=false&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "gameEventSetters.enabled=false&";
$output .= "confirmBetMessageEnabled=false&";

if (!isset($_Social) or $_Social == '')    $output .= "denomination.all=1%2C2%2C5%2C10%2C20%2C50%2C100&";
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

if (isset($_Social) and $_Social['tutorStep'] != 0 and $_Social['tutorStep'] != 9) $output .= "betlevel.all=10&";
else
    $output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";
$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";

$output .= "betlevel.standard=10&";



$output .= "denomination.standard=" . $denomDB . "&";

//    $output.= "historybutton=false&";
//    $output.= "restore=false&";
$output .= "nearwinallowed=true&";


$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
//    $output.= "g4mode=false&";

//    $output.= "nextaction=spin&";
//    $output.= "multiplier=1&";
//    $output.= "gameover=true&";
$output .= "previous.rs.i0=basic&";
$output .= "current.rs.i0=basic_0&";
$output .= "next.rs=basic_0&";
$output .= "wavecount=1&";
$output .= "last.rs=basic&";


//    $output.= "game.win.amount=null&";


//    $output.= "game.win.cents=0&";
//    $output.= "game.win.coins=0&";

//    $output.= "jackpotcurrency=%26%23x0024%3B&";
//    $output.= "jackpotcurrencyiso=RUR&";
//    $output.= "isJackpotWin=false&";
//    $output.= "playercurrency=%26%23x0024%3B&";
//    $output.= "playercurrencyiso=RUR&";

//    $output.= "totalwin.coins=".$totalWinsDB."&";
//    $output.= "totalwin.cents=".$totalWinsDB."&";
//    $output.= "gamestate.current=basic&";
$output .= "clientaction=init&";
$output .= "playforfun=false&";

$output .= "bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

$output .= "bl.i0.id=0&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.i0.line=1%2C1%2C1%2C1%2C1&";
$output .= "bl.i0.coins=1&";

$output .= "bl.i1.id=1&";
$output .= "bl.i1.reelset=ALL&";
$output .= "bl.i1.line=0%2C0%2C0%2C0%2C0&";
$output .= "bl.i1.coins=1&";

$output .= "bl.i2.id=2&";
$output .= "bl.i2.reelset=ALL&";
$output .= "bl.i2.line=2%2C2%2C2%2C2%2C2&";
$output .= "bl.i2.coins=1&";

$output .= "bl.i3.id=3&";
$output .= "bl.i3.line=0%2C1%2C2%2C1%2C0&";
$output .= "bl.i3.coins=1&";
$output .= "bl.i3.reelset=ALL&";

$output .= "bl.i4.id=4&";
$output .= "bl.i4.reelset=ALL&";
$output .= "bl.i4.line=2%2C1%2C0%2C1%2C2&";
$output .= "bl.i4.coins=1&";

$output .= "bl.i5.id=5&";
$output .= "bl.i5.reelset=ALL&";
$output .= "bl.i5.coins=1&";
$output .= "bl.i5.line=1%2C0%2C1%2C0%2C1&";

$output .= "bl.i6.id=6&";
$output .= "bl.i6.reelset=ALL&";
$output .= "bl.i6.line=1%2C2%2C1%2C2%2C1&";
$output .= "bl.i6.coins=1&";

$output .= "bl.i7.id=7&";
$output .= "bl.i7.reelset=ALL&";
$output .= "bl.i7.line=0%2C1%2C0%2C1%2C0&";
$output .= "bl.i7.coins=1&";

$output .= "bl.i8.id=8&";
$output .= "bl.i8.reelset=ALL&";
$output .= "bl.i8.line=2%2C1%2C2%2C1%2C2&";
$output .= "bl.i8.coins=1&";

$output .= "bl.i9.id=9&";
$output .= "bl.i9.reelset=ALL&";
$output .= "bl.i9.line=0%2C2%2C0%2C2%2C0&";
$output .= "bl.i9.coins=1&";

$output .= "bl.i10.id=10&";
$output .= "bl.i10.reelset=ALL&";
$output .= "bl.i10.line=2%2C0%2C2%2C0%2C2&";
$output .= "bl.i10.coins=1&";

$output .= "bl.i11.id=11&";
$output .= "bl.i11.reelset=ALL&";
$output .= "bl.i11.line=0%2C1%2C1%2C1%2C2&";
$output .= "bl.i11.coins=1&";

$output .= "bl.i12.id=12&";
$output .= "bl.i12.reelset=ALL&";
$output .= "bl.i12.line=2%2C1%2C1%2C1%2C0&";
$output .= "bl.i12.coins=1&";

$output .= "bl.i13.id=13&";
$output .= "bl.i13.reelset=ALL&";
$output .= "bl.i13.line=0%2C0%2C1%2C2%2C2&";
$output .= "bl.i13.coins=1&";

$output .= "bl.i14.coins=1&";
$output .= "bl.i14.id=14&";
$output .= "bl.i14.line=2%2C2%2C1%2C0%2C0&";
$output .= "bl.i14.reelset=ALL&";

$output .= "bl.i15.id=15&";
$output .= "bl.i15.reelset=ALL&";
$output .= "bl.i15.line=0%2C0%2C2%2C0%2C0&";
$output .= "bl.i15.coins=1&";

$output .= "bl.i16.id=16&";
$output .= "bl.i16.reelset=ALL&";
$output .= "bl.i16.line=2%2C2%2C0%2C2%2C2&";
$output .= "bl.i16.coins=1&";

$output .= "bl.i17.id=17&";
$output .= "bl.i17.reelset=ALL&";
$output .= "bl.i17.line=1%2C2%2C1%2C0%2C1&";
$output .= "bl.i17.coins=1&";

$output .= "bl.i18.id=18&";
$output .= "bl.i18.reelset=ALL&";
$output .= "bl.i18.line=1%2C0%2C1%2C2%2C1&";
$output .= "bl.i18.coins=1&";

$output .= "bl.i19.id=19&";
$output .= "bl.i19.reelset=ALL&";
$output .= "bl.i19.line=0%2C1%2C1%2C1%2C1&";
$output .= "bl.i19.coins=1&";

/*
    $output.= "rs.i0.r.i0.syms=SYM6%2CSYM4%2CSYM12&";
    $output.= "rs.i0.r.i1.syms=SYM11%2CSYM32%2CSYM32&";
    $output.= "rs.i0.r.i2.syms=SYM11%2CSYM12%2CSYM1&";
    $output.= "rs.i0.r.i3.syms=SYM9%2CSYM6%2CSYM8&";
    $output.= "rs.i0.r.i4.syms=SYM6%2CSYM7%2CSYM32&";
*/

$output .= "rs.i0.id=basic_respin_0&";
$output .= "rs.i0.r.i0.pos=0&";
$output .= "rs.i0.r.i0.hold=false&";


$output .= "rs.i0.r.i1.pos=0&";
$output .= "rs.i0.r.i1.hold=false&";


$output .= "rs.i0.r.i2.pos=0&";
$output .= "rs.i0.r.i2.hold=false&";


$output .= "rs.i0.r.i3.pos=0&";
$output .= "rs.i0.r.i3.hold=false&";


$output .= "rs.i0.r.i4.pos=0&";
$output .= "rs.i0.r.i4.hold=false&";


$output .= "rs.i1.id=symbol_overlay_0&";

$output .= "rs.i1.r.i0.syms=SYM6%2CSYM7%2CSYM10&";
$output .= "rs.i1.r.i0.pos=0&";
$output .= "rs.i1.r.i0.hold=false&";

$output .= "rs.i1.r.i1.syms=SYM11%2CSYM4%2CSYM6&";
$output .= "rs.i1.r.i1.pos=0&";
$output .= "rs.i1.r.i1.hold=false&";

$output .= "rs.i1.r.i2.syms=SYM8%2CSYM12%2CSYM32&";
$output .= "rs.i1.r.i2.pos=0&";
$output .= "rs.i1.r.i2.hold=false&";

$output .= "rs.i1.r.i3.syms=SYM12%2CSYM8%2CSYM9&";
$output .= "rs.i1.r.i3.pos=0&";
$output .= "rs.i1.r.i3.hold=false&";

$output .= "rs.i1.r.i4.syms=SYM6%2CSYM7%2CSYM32&";
$output .= "rs.i1.r.i4.pos=0&";
$output .= "rs.i1.r.i4.hold=false&";


$output .= "rs.i2.id=basic_0&";

$output .= "rs.i2.r.i0.syms=SYM10%2CSYM12%2CSYM0&";
$output .= "rs.i2.r.i0.pos=0&";
$output .= "rs.i2.r.i0.hold=false&";

$output .= "rs.i2.r.i1.syms=SYM4%2CSYM11%2CSYM32&";
$output .= "rs.i2.r.i1.pos=0&";
$output .= "rs.i2.r.i1.hold=false&";

$output .= "rs.i2.r.i2.syms=SYM9%2CSYM7%2CSYM11&";
$output .= "rs.i2.r.i2.pos=0&";
$output .= "rs.i2.r.i2.hold=false&";

$output .= "rs.i2.r.i3.syms=SYM11%2CSYM6%2CSYM9&";
$output .= "rs.i2.r.i3.pos=0&";
$output .= "rs.i2.r.i3.hold=false&";

$output .= "rs.i2.r.i4.syms=SYM10%2CSYM7%2CSYM11&";
$output .= "rs.i2.r.i4.pos=0&";
$output .= "rs.i2.r.i4.hold=false&";

//$output.= $lastRs;

$output .= "rs.i3.id=random_wild_respin_0&";

$output .= "rs.i3.r.i0.syms=SYM6%2CSYM4%2CSYM12&";
$output .= "rs.i3.r.i0.pos=0&";
$output .= "rs.i3.r.i0.hold=false&";

$output .= "rs.i3.r.i1.syms=SYM11%2CSYM32%2CSYM32&";
$output .= "rs.i3.r.i1.pos=0&";
$output .= "rs.i3.r.i1.hold=false&";

$output .= "rs.i3.r.i2.syms=SYM11%2CSYM12%2CSYM1&";
$output .= "rs.i3.r.i2.pos=0&";
$output .= "rs.i3.r.i2.hold=false&";

$output .= "rs.i3.r.i3.syms=SYM9%2CSYM6%2CSYM8&";
$output .= "rs.i3.r.i3.pos=0&";
$output .= "rs.i3.r.i4.pos=0&";

$output .= "rs.i3.r.i4.syms=SYM6%2CSYM7%2CSYM32&";
$output .= "rs.i3.r.i4.hold=false&";
$output .= "rs.i3.r.i3.hold=false";


$output .= "rs.i4.id=random_wild_0&";

$output .= "rs.i4.r.i0.syms=SYM6%2CSYM4%2CSYM12&";
$output .= "rs.i4.r.i0.pos=0&";
$output .= "rs.i4.r.i0.hold=false&";

$output .= "rs.i4.r.i1.syms=SYM32%2CSYM32%2CSYM32&";
$output .= "rs.i4.r.i1.pos=0&";
$output .= "rs.i4.r.i1.hold=false&";

$output .= "rs.i4.r.i2.syms=SYM4%2CSYM11%2CSYM8&";
$output .= "rs.i4.r.i2.pos=0&";
$output .= "rs.i4.r.i2.hold=false&";

$output .= "rs.i4.r.i3.syms=SYM12%2CSYM11%2CSYM5&";
$output .= "rs.i4.r.i3.pos=0&";
$output .= "rs.i4.r.i3.hold=false&";

$output .= "rs.i4.r.i4.syms=SYM6%2CSYM7%2CSYM32&";
$output .= "rs.i4.r.i4.pos=0&";
$output .= "rs.i4.r.i4.hold=false&";


$output .= "rs.i5.id=freespin_respin_0&";

$output .= "rs.i5.r.i0.syms=SYM11%2CSYM10%2CSYM12&";
$output .= "rs.i5.r.i0.pos=0&";
$output .= "rs.i5.r.i0.hold=false&";

$output .= "rs.i5.r.i1.syms=SYM11%2CSYM32%2CSYM32&";
$output .= "rs.i5.r.i1.pos=0&";
$output .= "rs.i5.r.i1.hold=false&";

$output .= "rs.i5.r.i2.syms=SYM9%2CSYM8%2CSYM4&";
$output .= "rs.i5.r.i2.pos=0&";
$output .= "rs.i5.r.i2.hold=false&";

$output .= "rs.i5.r.i3.syms=SYM12%2CSYM5%2CSYM4&";
$output .= "rs.i5.r.i3.pos=0&";
$output .= "rs.i5.r.i3.hold=false&";

$output .= "rs.i5.r.i4.syms=SYM11%2CSYM4%2CSYM12&";
$output .= "rs.i5.r.i4.pos=0&";
$output .= "rs.i5.r.i4.hold=false&";


$output .= "rs.i6.id=symbol_transform_0&";

$output .= "rs.i6.r.i0.syms=SYM6%2CSYM7%2CSYM10&";
$output .= "rs.i6.r.i0.pos=0&";
$output .= "rs.i6.r.i0.hold=false&";

$output .= "rs.i6.r.i1.syms=SYM11%2CSYM4%2CSYM6&";
$output .= "rs.i6.r.i1.pos=0&";
$output .= "rs.i6.r.i1.hold=false&";

$output .= "rs.i6.r.i2.syms=SYM8%2CSYM12%2CSYM32&";
$output .= "rs.i6.r.i2.pos=0&";
$output .= "rs.i6.r.i2.hold=false&";

$output .= "rs.i6.r.i3.syms=SYM12%2CSYM8%2CSYM9&";
$output .= "rs.i6.r.i3.hold=false&";
$output .= "rs.i6.r.i3.pos=0&";

$output .= "rs.i6.r.i4.syms=SYM6%2CSYM7%2CSYM32&";
$output .= "rs.i6.r.i4.pos=0&";
$output .= "rs.i6.r.i4.hold=false&";


$output .= "rs.i7.id=freespin_0&";

$output .= "rs.i7.r.i0.syms=SYM6%2CSYM7%2CSYM10&";
$output .= "rs.i7.r.i0.pos=0&";
$output .= "rs.i7.r.i0.hold=false&";

$output .= "rs.i7.r.i1.syms=SYM4%2CSYM32%2CSYM32&";
$output .= "rs.i7.r.i1.pos=0&";
$output .= "rs.i7.r.i1.hold=false&";

$output .= "rs.i7.r.i2.syms=SYM11%2CSYM9%2CSYM6&";
$output .= "rs.i7.r.i2.pos=0&";
$output .= "rs.i7.r.i2.hold=false&";

$output .= "rs.i7.r.i3.syms=SYM11%2CSYM6%2CSYM8&";
$output .= "rs.i7.r.i3.hold=false&";
$output .= "rs.i7.r.i3.pos=0&";

$output .= "rs.i7.r.i4.syms=SYM10%2CSYM8%2CSYM0&";
$output .= "rs.i7.r.i4.pos=0&";
$output .= "rs.i7.r.i4.hold=false&";
