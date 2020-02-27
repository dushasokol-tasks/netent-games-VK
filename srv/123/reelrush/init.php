<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";

$wavecount = 0;

if ($lastActionDB == "respin") {
    $bonusInfo = explode(";", $answer);
    foreach ($bonusInfo as $e => $v)
        if ($v != '') {
            $a = explode("=", $v);
            $$a[0] = $a[1];
        }

    $restore = "true";
    $gameover = "false";

    $gsStack = "basic";
    $gsCur = "basic";
    $nesxAct = "respin";

    $answ = "restoreAction=respin;";

    $output .= "current.rs.i0=basic&";
    $output .= "next.rs=basic&";
    $output .= "gamestate.history=basic&";

    $table_locked = 1;
}

if ($lastActionDB == "freespin" or $lastActionDB == "startfreespin" or $lastActionDB == "initfreespin") {
    $fs_multiplier = 1;
    $fs_initial = 8;

    $bonusInfo = explode(";", $answer);
    foreach ($bonusInfo as $e => $v)
        if ($v != '') {
            $a = explode("=", $v);
            $$a[0] = $a[1];
        }

    $fs_total = $fs_left + $fs_played;

    $gameover = "false";
    $restore = "true";
    $output .= "current.rs.i0=freespin&next.rs=freespin&";

    $gsStack = "basic%2Cfreespin";
    $gsCur = "freespin";
    $nesxAct = "freespin";
    $answ .= "restoreAction=freespin;" . $answer;

    $totalWinsDB = $fs_totalwin;

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

$output .= "playforfun=false&";

$output .= "clientaction=init&";

$output .= "betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&";


if (!isset($_Social) or $_Social == '')    $output .= "denomination.all=1%2C2%2C5%2C10%2C20%2C50&";
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




$output .= "rs.i0.id=basic5&";
$output .= "rs.i1.id=basic4&";
$output .= "rs.i2.id=basic3&";
$output .= "rs.i3.id=freespin&";
$output .= "rs.i4.id=basic2&";
$output .= "rs.i5.id=basic1&";
$output .= "rs.i6.id=basic&";

$output .= "bl.i0.id=0&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.standard=0&";
$output .= "bl.i0.coins=50&";
$output .= "bl.i0.line=0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4%2C0%2F1%2F2%2F3%2F4&";

$output .= "rs.i0.r.i0.syms=SYM4%2CSYM4%2CSYM5%2CSYM5%2CSYM9&rs.i0.r.i1.syms=SYM11%2CSYM11%2CSYM4%2CSYM4%2CSYM12&rs.i0.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&rs.i0.r.i3.syms=SYM11%2CSYM8%2CSYM8%2CSYM12%2CSYM12&rs.i0.r.i4.syms=SYM9%2CSYM5%2CSYM5%2CSYM12%2CSYM12&";
$output .= "rs.i1.r.i0.syms=SYM12%2CSYM4%2CSYM4%2CSYM5%2CSYM5&rs.i1.r.i1.syms=SYM11%2CSYM11%2CSYM4%2CSYM4%2CSYM12&rs.i1.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&rs.i1.r.i3.syms=SYM11%2CSYM8%2CSYM8%2CSYM12%2CSYM12&rs.i1.r.i4.syms=SYM9%2CSYM5%2CSYM5%2CSYM12%2CSYM12&";
$output .= "rs.i2.r.i0.syms=SYM12%2CSYM4%2CSYM4%2CSYM5%2CSYM5&rs.i2.r.i1.syms=SYM11%2CSYM11%2CSYM4%2CSYM4%2CSYM12&rs.i2.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&rs.i2.r.i3.syms=SYM11%2CSYM11%2CSYM8%2CSYM8%2CSYM12&rs.i2.r.i4.syms=SYM9%2CSYM5%2CSYM5%2CSYM12%2CSYM12&";
$output .= "rs.i3.r.i0.syms=SYM4%2CSYM4%2CSYM5%2CSYM5%2CSYM9&rs.i3.r.i1.syms=SYM11%2CSYM11%2CSYM4%2CSYM4%2CSYM12&rs.i3.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&rs.i3.r.i3.syms=SYM11%2CSYM8%2CSYM8%2CSYM12%2CSYM12&rs.i3.r.i4.syms=SYM5%2CSYM5%2CSYM12%2CSYM12%2CSYM3&";
$output .= "rs.i4.r.i0.syms=SYM12%2CSYM4%2CSYM4%2CSYM5%2CSYM5&rs.i4.r.i1.syms=SYM9%2CSYM11%2CSYM11%2CSYM4%2CSYM4&rs.i4.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&rs.i4.r.i3.syms=SYM11%2CSYM11%2CSYM8%2CSYM8%2CSYM12&rs.i4.r.i4.syms=SYM9%2CSYM5%2CSYM5%2CSYM12%2CSYM12&";
$output .= "rs.i5.r.i0.syms=SYM12%2CSYM4%2CSYM4%2CSYM5%2CSYM5&rs.i5.r.i1.syms=SYM9%2CSYM11%2CSYM11%2CSYM4%2CSYM4&rs.i5.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&rs.i5.r.i3.syms=SYM11%2CSYM11%2CSYM8%2CSYM8%2CSYM12&rs.i5.r.i4.syms=SYM9%2CSYM9%2CSYM5%2CSYM5%2CSYM12&";
$output .= "rs.i6.r.i0.syms=SYM12%2CSYM12%2CSYM4%2CSYM4%2CSYM5&rs.i6.r.i1.syms=SYM9%2CSYM11%2CSYM11%2CSYM4%2CSYM4&rs.i6.r.i2.syms=SYM3%2CSYM9%2CSYM9%2CSYM10%2CSYM10&rs.i6.r.i3.syms=SYM11%2CSYM11%2CSYM8%2CSYM8%2CSYM12&rs.i6.r.i4.syms=SYM9%2CSYM9%2CSYM5%2CSYM5%2CSYM12&";

$output .= "rs.i0.r.i0.hold=false&rs.i0.r.i1.hold=false&rs.i0.r.i2.hold=false&rs.i0.r.i3.hold=false&rs.i0.r.i4.hold=false&";
$output .= "rs.i1.r.i0.hold=false&rs.i1.r.i1.hold=false&rs.i1.r.i2.hold=false&rs.i1.r.i3.hold=false&rs.i1.r.i4.hold=false&";
$output .= "rs.i2.r.i0.hold=false&rs.i2.r.i1.hold=false&rs.i2.r.i2.hold=false&rs.i2.r.i3.hold=false&rs.i2.r.i4.hold=false&";
$output .= "rs.i3.r.i0.hold=false&rs.i3.r.i1.hold=false&rs.i3.r.i2.hold=false&rs.i3.r.i3.hold=false&rs.i3.r.i4.hold=false&";
$output .= "rs.i4.r.i0.hold=false&rs.i4.r.i1.hold=false&rs.i4.r.i2.hold=false&rs.i4.r.i3.hold=false&rs.i4.r.i4.hold=false&";
$output .= "rs.i5.r.i0.hold=false&rs.i5.r.i1.hold=false&rs.i5.r.i2.hold=false&rs.i5.r.i3.hold=false&rs.i5.r.i4.hold=false&";
$output .= "rs.i6.r.i0.hold=false&rs.i6.r.i1.hold=false&rs.i6.r.i2.hold=false&rs.i6.r.i3.hold=false&rs.i6.r.i4.hold=false&";

$output .= "gameEventSetters.enabled=false&";
$output .= "nearwinallowed=true&";
$output .= "casinoID=netent&";
$output .= "confirmBetMessageEnabled=false&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "%2F&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
