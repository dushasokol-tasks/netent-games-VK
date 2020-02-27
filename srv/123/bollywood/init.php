<?
$totalWinsDB = 0;
$total_win = 0;

$table_locked = 0;
$gsStack = "basic";
$gsCur = "basic";
$nesxAct = "spin";

$restore = "false";

if ($lastActionDB == "freespin" or $lastActionDB == "initfreespin" or $lastActionDB == "addfreespin" or $lastActionDB == "startfreespin") {

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

	$output .= "freespins.betlines=0%2C1%2C2%2C3%2C4%2C5%2C6%2C7%2C8&";

	$table_locked = 1;
}

$output .= "restore=" . $restore . "&";

$output .= "gamestate.stack=$gsStack&";
$output .= "nextaction=$nesxAct&";
$output .= "gamestate.current=$gsCur&";

/*
if($lastRsDB=='')
{
    $lastRsDB="rs.i0.r.i0.syms=SYM4%2CSYM4%2CSYM4&rs.i0.r.i1.syms=SYM4%2CSYM4%2CSYM4&rs.i0.r.i2.syms=SYM9%2CSYM9%2CSYM9&rs.i0.r.i3.syms=SYM4%2CSYM4%2CSYM4&rs.i0.r.i4.syms=SYM4%2CSYM4%2CSYM4&";
}

$output.=$lastRsDB;
*/

/////////////////////////parser
/*
$str=explode('&',$output);
sort($str);
foreach($str as $e=>$v)
echo '$output.= "'.$v.'&";<br>';
*/
////////////////////////

$output .= "autoplay=10,25,50,75,100,250,500,750,1000&";
$output .= "autoplayLossLimitEnabled=false&";
$output .= "betlevel.all=1,2,3,4,5,6,7,8,9,10&";
//$output.= "betlevel.standard=1&";
$output .= "bl.i0.coins=1&";
$output .= "bl.i0.id=0&";
$output .= "bl.i0.line=1,1,1,1,1&";
$output .= "bl.i0.reelset=ALL&";
$output .= "bl.i1.coins=1&";
$output .= "bl.i1.id=1&";
$output .= "bl.i1.line=0,0,0,0,0&";
$output .= "bl.i1.reelset=ALL&";
$output .= "bl.i2.coins=1&";
$output .= "bl.i2.id=2&";
$output .= "bl.i2.line=2,2,2,2,2&";
$output .= "bl.i2.reelset=ALL&";
$output .= "bl.i3.coins=1&";
$output .= "bl.i3.id=3&";
$output .= "bl.i3.line=0,1,2,1,0&";
$output .= "bl.i3.reelset=ALL&";
$output .= "bl.i4.coins=1&";
$output .= "bl.i4.id=4&";
$output .= "bl.i4.line=2,1,0,1,2&";
$output .= "bl.i4.reelset=ALL&";
$output .= "bl.i5.coins=1&";
$output .= "bl.i5.id=5&";
$output .= "bl.i5.line=0,0,1,0,0&";
$output .= "bl.i5.reelset=ALL&";
$output .= "bl.i6.coins=1&";
$output .= "bl.i6.id=6&";
$output .= "bl.i6.line=2,2,1,2,2&";
$output .= "bl.i6.reelset=ALL&";
$output .= "bl.i7.coins=1&";
$output .= "bl.i7.id=7&";
$output .= "bl.i7.line=1,2,2,2,1&";
$output .= "bl.i7.reelset=ALL&";
$output .= "bl.i8.coins=1&";
$output .= "bl.i8.id=8&";
$output .= "bl.i8.line=1,0,0,0,1&";
$output .= "bl.i8.reelset=ALL&";
$output .= "bl.standard=0,1,2,3,4,5,6,7,8&";
$output .= "clientaction=init&";
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

$output .= "betlevel.standard=10&";
$output .= "denomination.standard=" . $denomDB . "&";

$output .= "bet.betlevel=10&";
$output .= "bet.denomination=" . $denomDB . "&";

$output .= "gameEventSetters.enabled=false&";
$output .= "gamesoundurl=https://" . $soundURL . "/&";
$output .= "nearwinallowed=true&";
$output .= "playforfun=false&";
$output .= "rs.i0.id=freespin&";
$output .= "rs.i0.r.i0.hold=false&";
$output .= "rs.i0.r.i0.pos=0&";
$output .= "rs.i0.r.i0.syms=SYM12,SYM12,SYM12&";
$output .= "rs.i0.r.i1.hold=false&";
$output .= "rs.i0.r.i1.pos=0&";
$output .= "rs.i0.r.i1.syms=SYM9,SYM9,SYM9&";
$output .= "rs.i0.r.i2.hold=false&";
$output .= "rs.i0.r.i2.pos=0&";
$output .= "rs.i0.r.i2.syms=SYM3,SYM3,SYM3&";
$output .= "rs.i0.r.i3.hold=false&";
$output .= "rs.i0.r.i3.pos=0&";
$output .= "rs.i0.r.i3.syms=SYM3,SYM3,SYM3&";
$output .= "rs.i0.r.i4.hold=false&";
$output .= "rs.i0.r.i4.pos=0&";
$output .= "rs.i0.r.i4.syms=SYM11,SYM11,SYM11&";
$output .= "rs.i1.id=basic&";
$output .= "rs.i1.r.i0.hold=false&";
$output .= "rs.i1.r.i0.pos=72&";
$output .= "rs.i1.r.i0.syms=SYM7,SYM8,SYM8&";
$output .= "rs.i1.r.i1.hold=false&";
$output .= "rs.i1.r.i1.pos=48&";
$output .= "rs.i1.r.i1.syms=SYM5,SYM12,SYM12&";
$output .= "rs.i1.r.i2.hold=false&";
$output .= "rs.i1.r.i2.pos=45&";
$output .= "rs.i1.r.i2.syms=SYM11,SYM0,SYM3&";
$output .= "rs.i1.r.i3.hold=false&";
$output .= "rs.i1.r.i3.pos=21&";
$output .= "rs.i1.r.i3.syms=SYM9,SYM9,SYM4&";
$output .= "rs.i1.r.i4.hold=false&";
$output .= "rs.i1.r.i4.pos=32&";
$output .= "rs.i1.r.i4.syms=SYM10,SYM10,SYM6&";
$output .= "staticsharedurl=https://" . $staticSharedURL . "/gameclient_html/devicedetection/current&";
