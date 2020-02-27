<?

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";
if ($lastActionDB == "freespin" or $lastActionDB == "respin") {

    $bonusInfo = explode(";", $answer);
    foreach ($bonusInfo as $e => $v)
        if ($v != '') {
            $a = explode("=", $v);
            $$a[0] = $a[1];
        }

    $gameover = "false";
    $restore = "true";

    if ($wildsDB != '') {
        $answ .= "wildStcks=" . $wildsDB . ";";
    }
    $gsStack = "basic%2Cfreespin";
    $gsCur = "freespin";
    $nesxAct = "freespin";
    $answ .= "restoreAction=freespin;" . $answer;


    $multiplier = "1";

    $output .= "gameover=false&";
    $output .= "current.rs.i0=freespin2&";
    $output .= "next.rs=freespin1&";

    $output .= "freespins.total=" . $fs_total . "&";
    $output .= "freespins.left=" . $fs_left . "&";

    $output .= "freespins.multiplier=1&";
    $output .= "freespins.initial=0&";
    $output .= "freespins.totalwin.coins=0&";
    $output .= "gamestate.history=basic%2Crespin%2Cfreespin&";
    $output .= "freespins.denomination=1.000&";
    $output .= "last.rs=freespin2&";
    $output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&";
    $output .= "freespins.win.cents=0&";
    $output .= "clientaction=freespin&";
    $output .= "freespins.wavecount=1&";
    $output .= "freespins.win.coins=0&";
    $output .= "freespins.betlevel=1&";
    $output .= "current.rs.i0=freespin2&";
    $output .= "rs.i0.id=freespin2&";
    $output .= "previous.rs.i0=freespin2&";
    $output .= "freespins.totalwin.cents=0&";

    $table_locked = 1;
}

$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

$lastRsDB = "rs.i3.r.i0.syms=SYM0%2CSYM9%2CSYM11&rs.i3.r.i1.syms=SYM8%2CSYM7%2CSYM10&rs.i3.r.i2.syms=SYM11%2CSYM4%2CSYM3&rs.i3.r.i3.syms=SYM11%2CSYM6%2CSYM8&rs.i3.r.i4.syms=SYM1%2CSYM8%2CSYM9&";
$output .= $lastRsDB;

$output .= "rs.i0.r.i0.syms=SYM10%2CSYM4%2CSYM6&rs.i0.r.i1.syms=SYM11%2CSYM7%2CSYM9&rs.i0.r.i2.syms=SYM7%2CSYM5%2CSYM8&rs.i0.r.i3.syms=SYM7%2CSYM11%2CSYM4&rs.i0.r.i4.syms=SYM6%2CSYM11%2CSYM10&";

$output .= "bl.i13.coins=1&rs.i1.r.i0.hold=false&bl.i3.coins=1&rs.i3.r.i1.pos=14&rs.i0.r.i3.pos=13&gameEventSetters.enabled=false&bl.i12.reelset=ALL&bl.i5.id=5&rs.i3.id=basic&bl.i11.id=11&bl.i12.coins=1&bl.i6.id=6&rs.i1.r.i4.pos=10&rs.i2.r.i1.syms=1%2C2%2C2&rs.i1.r.i4.syms=SYM9%2CSYM5%2CSYM11&bl.i19.coins=1&rs.i0.r.i2.hold=false&confirmBetMessageEnabled=false&bl.i15.line=0%2C1%2C1%2C1%2C0&rs.i1.r.i2.pos=24&rs.i2.id=respin&bl.i3.line=0%2C1%2C2%2C1%2C0&rs.i0.r.i4.hold=false&rs.i0.r.i4.pos=24&rs.i2.r.i1.hold=false&bl.i17.line=0%2C2%2C0%2C2%2C0&bl.i13.id=13&rs.i1.r.i2.syms=SYM10%2CSYM4%2CSYM8&";
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

//$output.= "betlevel.standard=".$betDB."&";


$output .= "rs.i3.r.i2.hold=false&bl.i19.reelset=ALL&bl.i4.coins=1&bl.i5.coins=1&rs.i0.r.i0.pos=5&clientaction=init&rs.i1.r.i3.hold=false&bl.i3.reelset=ALL&rs.i2.r.i1.pos=0&bl.i14.coins=1&bl.i16.id=16&rs.i2.r.i3.syms=1%2C2%2C2&rs.i1.r.i3.syms=SYM11%2CSYM9%2CSYM8&bl.i1.coins=1&bl.i8.reelset=ALL&bl.i14.id=14&bl.i9.line=1%2C0%2C1%2C0%2C1&rs.i1.r.i3.pos=8&bl.i17.reelset=ALL&rs.i1.r.i0.syms=SYM9%2CSYM5%2CSYM6&rs.i0.r.i1.hold=false&";
$output .= "gamesoundurl=https%3A%2F%2F" . $soundURL . "&";
$output .= "bl.i12.id=12&bl.i10.coins=1&bl.i7.line=1%2C2%2C2%2C2%2C1&bl.i14.line=1%2C1%2C2%2C1%2C1&bl.i5.reelset=ALL&bl.i18.line=2%2C0%2C2%2C0%2C2&rs.i1.r.i4.hold=false&rs.i0.r.i2.pos=8&bl.i8.coins=1&bl.i6.coins=1&bl.i14.reelset=ALL&betlevel.all=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10&rs.i0.r.i3.hold=false&bl.i2.coins=1&bl.i7.reelset=ALL&bl.i10.id=10&rs.i2.r.i2.pos=0&bl.i4.line=2%2C1%2C0%2C1%2C2&bl.i5.line=0%2C0%2C1%2C0%2C0&bl.i1.line=0%2C0%2C0%2C0%2C0&bl.i6.line=2%2C2%2C1%2C2%2C2&bl.i4.id=4&rs.i3.r.i0.hold=false&bl.i11.line=0%2C1%2C0%2C1%2C0&rs.i2.r.i3.pos=0&bl.i8.line=1%2C0%2C0%2C0%2C1&rs.i2.r.i4.pos=0&rs.i2.r.i2.syms=1%2C2%2C2&bl.i8.id=8&bl.i7.coins=1&bl.i17.coins=1&bl.i4.reelset=ALL&rs.i2.r.i2.hold=false&rs.i1.id=freespin2&bl.i1.reelset=ALL&rs.i2.r.i0.syms=1%2C2%2C2&bl.i2.reelset=ALL&bl.i19.id=19&rs.i1.r.i2.hold=false&rs.i0.r.i0.hold=false&bl.i10.line=1%2C2%2C1%2C2%2C1&rs.i2.r.i0.hold=false&rs.i3.r.i3.pos=25&bl.i18.id=18&bl.i9.reelset=ALL&bl.i0.coins=1&bl.i0.id=0&autoplay=10%2C25%2C50%2C75%2C100%2C250%2C500%2C750%2C1000&bl.i17.id=17&bl.i11.coins=1&rs.i3.r.i2.pos=208&bl.i15.id=15&bl.i15.reelset=ALL&bl.i16.coins=1&bl.i11.reelset=ALL&rs.i2.r.i4.hold=false&rs.i3.r.i4.pos=147&bl.i3.id=3&bl.i2.id=2&rs.i3.r.i1.hold=false&bl.standard=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19&rs.i1.r.i0.pos=4&bl.i12.line=2%2C1%2C2%2C1%2C2&bl.i19.line=0%2C2%2C2%2C2%2C0&rs.i1.r.i1.syms=SYM7%2CSYM10%2CSYM9&bl.i6.reelset=ALL&bl.i2.line=2%2C2%2C2%2C2%2C2&bl.i10.reelset=ALL&autoplayLossLimitEnabled=false&bl.i18.reelset=ALL&bl.i7.id=7&rs.i2.r.i4.syms=1%2C2%2C2&nearwinallowed=true&rs.i3.r.i4.hold=false&bl.i16.reelset=ALL&rs.i3.r.i0.pos=129&bl.i9.id=9&bl.i9.coins=1&bl.i0.reelset=ALL&rs.i1.r.i1.hold=false&rs.i1.r.i1.pos=6&bl.i16.line=2%2C1%2C1%2C1%2C2&rs.i0.id=freespin1&rs.i2.r.i3.hold=false&iframeEnabled=false&playforfun=false&bl.i18.coins=1&rs.i2.r.i0.pos=0&bl.i15.coins=1&bl.i0.line=1%2C1%2C1%2C1%2C1&";
$output .= "staticsharedurl=https%3A%2F%2F" . $staticSharedURL . "%2Fgameclient_html%2Fdevicedetection%2Fcurrent&";
$output .= "bl.i13.reelset=ALL&rs.i3.r.i3.hold=false&bl.i1.id=1&bl.i13.line=1%2C1%2C0%2C1%2C1&rs.i0.r.i1.pos=6&";
