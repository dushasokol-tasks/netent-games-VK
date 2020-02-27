<?

$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";

if ($lastActionDB == "initfreespin") {
    $gameover = "false";
    $restore = "true";
    $output .= "current.rs.i0=basic2&";
    $gsStack = "basic%2Cbonus";
    $gsCur = "bonus";
    $nesxAct = "bonusaction";
    $answ = "restoreAction=bonusaction;wildStcks=" . $wildsDB . ";";

    $output .= "selectionsMade=&nextactiontype=pickbonus&availableSelections=15&gamestate.bonusid=pickwin&";

    $table_locked = 1;
}


if ($lastActionDB == "bonusaction") {
    $gameover = "false";
    $restore = "true";
    $output .= "current.rs.i0=basic2&";
    $gsStack = "basic%2Cbonus";
    $gsCur = "bonus";
    $nesxAct = "bonusaction";
    $answ = "restoreAction=bonusaction;wildStcks=" . $wildsDB . ";";

    $selectionInfo = explode("%2C", $wildsDB);
    foreach ($selectionInfo as $e => $v)
        if ($v != '') {
            if ($v == "COINWIN") $COINwinSymbs++;
            if ($v == "FS1") $FS1winSymbs++;
            if ($v == "FS2") $FS2winSymbs++;
            if ($v == "FS3") $FS3winSymbs++;
        }

    $overallSymbs = 14 - ($COINwinSymbs + $FS1winSymbs + $FS2winSymbs + $FS3winSymbs);

    $output .= "selectionsMade=$wildsDB&nextactiontype=pickbonus&availableSelections=$overallSymbs&gamestate.bonusid=pickwin&";

    $table_locked = 1;
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

    $multiplier = 1;


    $output .= "freespins.total=" . $fs_total . "&";
    $output .= "freespins.left=" . $fs_left . "&";


    $output .= "freespins.multiplier=1&";
    $output .= "freespins.initial=0&";

    $output .= "gamestate.history=basic%2Crespin%2Cfreespin&";
    $output .= "freespins.denomination=1.000&";
    $output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";

    $output .= "clientaction=freespin&";
    $output .= "freespins.wavecount=1&";

    $output .= "freespins.betlevel=1&";
    $output .= "gamestate.stack=basic%2Cfreespin&";

    $output .= "freespins.win.coins=0&";
    $output .= "freespins.win.cents=0&";
    $output .= "freespins.totalwin.coins=0&";
    $output .= "freespins.totalwin.cents=0&";

    if ($fgType == "FS1") {
        $output .= "last.rs=FS1&"; //
        $output .= "freespinfeature=FS1&";
        $output .= "rs.i0.id=FS1&"; //
        $output .= "current.rs.i0=FS1&"; //
        $output .= "nextactiontype=pickbonus&";
        $output .= "previous.rs.i0=FS1&";
    }
    if ($fgType == "FS2") {
        $output .= "last.rs=FS2_" . $num2 . "&";
        $output .= "freespinfeature=FS2&";
        $output .= "rs.i0.id=FS2_" . $num2 . "&";
        $output .= "current.rs.i0=FS2_" . $num2 . "&";
        $output .= "nextactiontype=pickbonus&";
        $output .= "previous.rs.i0=FS2_" . $num2 . "&";
    }

    if ($fgType == "FS3") {
        $output .= "last.rs=FS3_" . $num2 . "&";
        $output .= "freespinfeature=FS3&";
        $output .= "rs.i0.id=FS3_2&";
        $output .= "current.rs.i0=FS3_" . $num2 . "";
        $output .= "nextactiontype=pickbonus&";
        $output .= "previous.rs.i0=FS3_" . $num2 . "&";
        $output .= "guitarchord=" . $guitarchord . "&";
    }

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









$output .= "rs.i11.r.i2.syms=SYM11%2CSYM12%2CSYM13&bl.i13.coins=1&bl.i3.coins=1&rs.i3.r.i1.pos=0&rs.i8.r.i2.hold=false&rs.i12.r.i4.hold=false&rs.i5.r.i0.syms=SYM5%2CSYM5%2CSYM5&bl.i5.id=5&rs.i3.id=FS1&bl.i11.id=11&rs.i6.r.i0.pos=0&rs.i13.r.i4.hold=false&bl.i12.coins=1&rs.i12.r.i1.pos=0&bl.i6.id=6&rs.i6.r.i1.syms=SYM3%2CSYM12%2CSYM14&rs.i8.r.i4.hold=false&rs.i9.r.i0.hold=false&rs.i4.r.i4.pos=0&rs.i11.r.i4.syms=SYM11%2CSYM12%2CSYM13&rs.i6.r.i4.pos=0&rs.i9.r.i2.pos=0&rs.i0.r.i2.hold=false&bl.i15.line=0%2C1%2C1%2C1%2C0&rs.i8.id=FS2_2&rs.i0.r.i4.pos=0&rs.i13.id=RED_GUITAR_FIRST_RESPIN3&rs.i9.id=FS3_1&rs.i12.r.i4.syms=SYM5%2CSYM8%2CSYM3&rs.i7.id=FS2_1&bl.i19.reelset=ALL&rs.i11.r.i0.pos=0&bl.i4.coins=1&rs.i0.r.i0.syms=SYM7%2CSYM7%2CSYM7&bl.i5.coins=1&rs.i11.r.i0.hold=false&rs.i10.r.i2.hold=false&rs.i11.r.i1.syms=SYM11%2CSYM12%2CSYM13&rs.i5.r.i0.pos=0&bl.i3.reelset=ALL&bl.i14.coins=1&rs.i5.r.i3.pos=0&rs.i8.r.i0.syms=SYM4%2CSYM4%2CSYM4&rs.i1.r.i3.syms=SYM9%2CSYM8%2CSYM7&rs.i9.r.i4.pos=0&rs.i4.r.i1.syms=SYM10%2CSYM8%2CSYM5&bl.i14.id=14&rs.i7.r.i2.pos=0&bl.i9.line=1%2C0%2C1%2C0%2C1&rs.i9.r.i1.pos=0&rs.i10.r.i2.syms=SYM7%2CSYM10%2CSYM11&rs.i10.r.i1.syms=SYM12%2CSYM13%2CSYM8&bl.i17.reelset=ALL&bl.i12.id=12&rs.i6.r.i2.pos=0&rs.i13.r.i4.pos=0&rs.i13.r.i1.pos=0&bl.i10.coins=1&rs.i13.r.i4.syms=SYM11%2CSYM12%2CSYM13&rs.i8.r.i4.syms=SYM8%2CSYM13%2CSYM9&rs.i10.id=FS3_2&bl.i5.reelset=ALL&bl.i18.line=2%2C0%2C2%2C0%2C2&rs.i1.r.i4.hold=false&rs.i8.r.i2.syms=SYM9%2CSYM5%2CSYM5&rs.i6.id=RED_GUITAR_FIRST_RESPIN2&bl.i8.coins=1&rs.i6.r.i1.pos=0&bl.i6.coins=1&multiplier=1&bl.i14.reelset=ALL&rs.i11.r.i0.syms=SYM3%2CSYM3%2CSYM3&gameover=true&rs.i0.r.i3.hold=false&rs.i2.r.i2.pos=0&bl.i4.line=2%2C1%2C0%2C1%2C2&bl.i5.line=0%2C0%2C1%2C0%2C0&bl.i1.line=0%2C0%2C0%2C0%2C0&bl.i6.line=2%2C2%2C1%2C2%2C2&bl.i4.id=4&rs.i3.r.i0.hold=false&rs.i10.r.i4.hold=false&rs.i7.r.i3.syms=SYM7%2CSYM7%2CSYM12&rs.i9.r.i2.syms=SYM5%2CSYM5%2CSYM5&rs.i2.r.i3.pos=0&rs.i5.id=RED_GUITAR3&rs.i4.r.i0.syms=SYM5%2CSYM5%2CSYM5&rs.i10.r.i2.pos=0&bl.i4.reelset=ALL&rs.i5.r.i3.syms=SYM8%2CSYM8%2CSYM6&rs.i2.r.i2.hold=false&rs.i1.id=basic3&bl.i1.reelset=ALL&rs.i11.r.i2.hold=false&rs.i6.r.i0.hold=false&rs.i12.r.i0.syms=SYM13%2CSYM14%2CSYM4&bl.i19.id=19&rs.i13.r.i0.syms=SYM11%2CSYM12%2CSYM13&rs.i8.r.i3.pos=0&rs.i1.r.i2.hold=false&rs.i2.r.i0.hold=false&rs.i5.r.i3.hold=false&rs.i5.r.i1.hold=false&bl.i18.id=18&rs.i3.r.i2.syms=SYM10%2CSYM6%2CSYM6&bl.i0.coins=1&bl.i17.id=17&rs.i3.r.i2.pos=0&rs.i12.r.i1.syms=SYM9%2CSYM13%2CSYM6&game.win.amount=null&bl.i15.id=15&rs.i13.r.i2.syms=SYM11%2CSYM12%2CSYM13&bl.i15.reelset=ALL&rs.i3.r.i0.syms=SYM7%2CSYM7%2CSYM9&rs.i2.r.i4.hold=false&rs.i3.r.i4.pos=0&rs.i3.r.i1.hold=false&rs.i8.r.i1.hold=false&bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&rs.i9.r.i1.hold=false&rs.i1.r.i0.pos=0&rs.i12.r.i0.hold=false&rs.i6.r.i1.hold=false&rs.i4.r.i1.pos=0&rs.i1.r.i1.syms=SYM9%2CSYM13%2CSYM6&bl.i19.line=0%2C2%2C2%2C2%2C0&jackpotcurrency=%26%23x20AC%3B&bl.i6.reelset=ALL&rs.i5.r.i1.syms=SYM10%2CSYM8%2CSYM5&bl.i10.reelset=ALL&rs.i7.r.i0.pos=0&autoplayLossLimitEnabled=false&rs.i13.r.i2.pos=0&rs.i2.r.i4.syms=SYM5%2CSYM8%2CSYM3&nearwinallowed=true&rs.i9.r.i4.hold=false&rs.i3.r.i4.hold=false&bl.i16.reelset=ALL&rs.i12.r.i2.hold=false&bl.i9.coins=1&rs.i9.r.i0.syms=SYM7%2CSYM6%2CSYM4&rs.i10.r.i3.syms=SYM13%2CSYM14%2CSYM8&rs.i1.r.i1.pos=0&rs.i11.r.i4.pos=0&rs.i5.r.i4.hold=false&rs.i12.r.i3.syms=SYM9%2CSYM8%2CSYM7&rs.i7.r.i4.pos=0&bl.i18.coins=1&totalwin.coins=0&rs.i2.r.i0.pos=0&bl.i15.coins=1&rs.i10.r.i1.hold=false&rs.i0.r.i1.syms=SYM11%2CSYM12%2CSYM13&bl.i0.line=1%2C1%2C1%2C1%2C1&rs.i13.r.i1.hold=false&bl.i1.id=1&rs.i5.r.i2.pos=0&rs.i4.r.i3.hold=false&rs.i13.r.i3.pos=0&bl.i13.line=1%2C1%2C0%2C1%2C1&rs.i0.r.i1.pos=0&rs.i4.r.i3.pos=0&rs.i4.r.i0.hold=false&rs.i11.r.i3.pos=0&rs.i7.r.i4.hold=false&rs.i1.r.i0.hold=false&rs.i0.r.i3.pos=0&rs.i10.r.i1.pos=0&gameEventSetters.enabled=false&rs.i8.r.i0.hold=false&rs.i9.r.i4.syms=SYM5%2CSYM9%2CSYM7&bl.i12.reelset=ALL&rs.i10.r.i4.pos=0&rs.i3.r.i3.syms=SYM9%2CSYM6%2CSYM13&rs.i1.r.i4.pos=0&rs.i2.r.i1.syms=SYM9%2CSYM13%2CSYM6&rs.i5.r.i4.syms=SYM6%2CSYM3%2CSYM3&rs.i1.r.i4.syms=SYM5%2CSYM8%2CSYM3&rs.i13.r.i3.hold=false&rs.i7.r.i4.syms=SYM5%2CSYM9%2CSYM7&rs.i7.r.i1.syms=SYM8%2CSYM13%2CSYM5&rs.i7.r.i1.hold=false&bl.i19.coins=1&rs.i8.r.i4.pos=0&rs.i0.r.i2.syms=SYM11%2CSYM12%2CSYM13&confirmBetMessageEnabled=false&rs.i1.r.i2.pos=0&rs.i7.r.i2.syms=SYM5%2CSYM5%2CSYM5&rs.i2.id=basic2&bl.i3.line=0%2C1%2C2%2C1%2C0&rs.i0.r.i4.hold=false&rs.i9.r.i0.pos=0&game.win.cents=0&rs.i2.r.i1.hold=false&bl.i17.line=0%2C2%2C0%2C2%2C0&bl.i13.id=13&rs.i12.r.i0.pos=0&rs.i1.r.i2.syms=SYM13%2CSYM8%2CSYM1&rs.i4.r.i2.pos=0&rs.i13.r.i1.syms=SYM11%2CSYM12%2CSYM13&rs.i4.r.i2.hold=false&";

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
$output .= "denomination.standard=" . $denomDB . "&";
$output .= "betlevel.standard=10&";



$output .= "rs.i8.r.i1.pos=0&rs.i3.r.i2.hold=false&rs.i8.r.i1.syms=SYM3%2CSYM3%2CSYM3&rs.i0.r.i0.pos=0&clientaction=init&rs.i7.r.i1.pos=0&rs.i1.r.i3.hold=false&rs.i2.r.i1.pos=0&rs.i10.r.i3.pos=0&bl.i16.id=16&rs.i9.r.i1.syms=SYM8%2CSYM13%2CSYM5&rs.i0.r.i4.syms=SYM11%2CSYM12%2CSYM13&rs.i2.r.i3.syms=SYM9%2CSYM8%2CSYM7&playercurrencyiso=EUR&historybutton=false&rs.i7.r.i0.syms=SYM7%2CSYM6%2CSYM4&bl.i1.coins=1&bl.i8.reelset=ALL&rs.i6.r.i3.syms=SYM11%2CSYM12%2CSYM13&rs.i9.r.i3.syms=SYM7%2CSYM7%2CSYM12&rs.i6.r.i4.syms=SYM11%2CSYM12%2CSYM13&rs.i1.r.i3.pos=0&rs.i1.r.i0.syms=SYM6%2CSYM8%2CSYM5&rs.i0.r.i1.hold=false&rs.i11.r.i1.pos=0&rs.i6.r.i3.pos=0&rs.i10.r.i0.hold=false&rs.i5.r.i4.pos=0&rs.i10.r.i3.hold=false&rs.i13.r.i3.syms=SYM11%2CSYM12%2CSYM13&bl.i7.line=1%2C2%2C2%2C2%2C1&game.win.coins=0&bl.i14.line=1%2C1%2C2%2C1%2C1&rs.i7.r.i2.hold=false&rs.i4.r.i1.hold=false&rs.i4.r.i4.hold=false&rs.i13.r.i2.hold=false&rs.i11.r.i3.syms=SYM11%2CSYM12%2CSYM13&rs.i3.r.i1.syms=SYM11%2CSYM7%2CSYM12&rs.i9.r.i3.hold=false&rs.i8.r.i3.hold=false&rs.i0.r.i2.pos=0&rs.i10.r.i4.syms=SYM10%2CSYM9%2CSYM9&totalwin.cents=0&rs.i5.r.i2.hold=false&betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&bl.i7.reelset=ALL&bl.i2.coins=1&bl.i10.id=10&rs.i9.r.i3.pos=0&rs.i4.r.i2.syms=SYM6%2CSYM6%2CSYM6&rs.i11.r.i1.hold=false&rs.i12.r.i3.pos=0&rs.i11.id=RED_GUITAR_FIRST_RESPIN&bl.i11.line=0%2C1%2C0%2C1%2C0&rs.i6.r.i2.syms=SYM11%2CSYM12%2CSYM13&bl.i8.line=1%2C0%2C0%2C0%2C1&rs.i2.r.i2.syms=SYM13%2CSYM8%2CSYM1&rs.i2.r.i4.pos=0&rs.i11.r.i4.hold=false&wavecount=1&bl.i8.id=8&bl.i7.coins=1&bl.i17.coins=1&rs.i6.r.i0.syms=SYM11%2CSYM12%2CSYM13&rs.i12.r.i3.hold=false&rs.i13.r.i0.hold=false&rs.i6.r.i2.hold=false&rs.i2.r.i0.syms=SYM6%2CSYM8%2CSYM5&bl.i2.reelset=ALL&rs.i5.r.i0.hold=false&rs.i7.r.i3.hold=false&rs.i0.r.i0.hold=false&rs.i11.r.i3.hold=false&bl.i10.line=1%2C2%2C1%2C2%2C1&rs.i13.r.i0.pos=0&rs.i3.r.i3.pos=0&rs.i0.r.i3.syms=SYM11%2CSYM12%2CSYM13&rs.i3.r.i4.syms=SYM7%2CSYM8%2CSYM8&bl.i9.reelset=ALL&rs.i12.r.i4.pos=0&bl.i0.id=0&";
$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "bl.i11.coins=1&rs.i11.r.i2.pos=0&bl.i16.coins=1&bl.i11.reelset=ALL&bl.i3.id=3&bl.i2.id=2&isJackpotWin=false&bl.i12.line=2%2C1%2C2%2C1%2C2&jackpotcurrencyiso=EUR&rs.i4.r.i0.pos=0&rs.i6.r.i3.hold=false&rs.i7.r.i3.pos=0&playercurrency=%26%23x20AC%3B&bl.i2.line=2%2C2%2C2%2C2%2C2&rs.i6.r.i4.hold=false&rs.i5.r.i2.syms=SYM6%2CSYM6%2CSYM6&g4mode=false&bl.i18.reelset=ALL&bl.i7.id=7&rs.i12.r.i1.hold=false&rs.i4.id=RED_GUITAR2&rs.i8.r.i3.syms=SYM9%2CSYM9%2CSYM14&rs.i5.r.i1.pos=0&rs.i3.r.i0.pos=0&bl.i9.id=9&bl.i0.reelset=ALL&rs.i1.r.i1.hold=false&bl.i16.line=2%2C1%2C1%2C1%2C2&rs.i4.r.i3.syms=SYM8%2CSYM8%2CSYM6&rs.i0.id=RED_GUITAR4&rs.i2.r.i3.hold=false&iframeEnabled=false&playforfun=false&rs.i12.r.i2.syms=SYM7%2CSYM13%2CSYM8&rs.i12.id=basic&rs.i8.r.i2.pos=0&rs.i10.r.i0.syms=SYM7%2CSYM13%2CSYM5&rs.i4.r.i4.syms=SYM6%2CSYM3%2CSYM3&rs.i7.r.i0.hold=false&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&bl.i13.reelset=ALL&rs.i3.r.i3.hold=false&rs.i8.r.i0.pos=0&rs.i10.r.i0.pos=0&rs.i12.r.i2.pos=0&rs.i9.r.i2.hold=false&";
