<?
$oldSSID = "7866220237";
$arg_str = '';

foreach ($_GET as $e => $v) {
	$text = '';
	if ($e == 'sessid') $text = "sessid=DEMO-" . $oldSSID . "-EUR";
	elseif ($e == 'bet_betlevel') $text = "bet.betlevel=$v";
	elseif ($e == 'bet_denomination') $text = "bet.denomination=$v";
	elseif ($e == 'bet_betlines') $text = "bet.betlines=$v";
	elseif ($e == 'freespin_selected') $text = "freespin.selected=$v";
	else $text = "$e=$v";

	if ($arg_str == '') $arg_str = $text;
	else $arg_str .= "&" . $text;
}

$base_url = "netent-game.casinomodule.com/servlet/";
$param_url = "CasinoGameServlet;jsession=DEMO-" . $oldSSID . "-EUR?";

//if($_GET['action']="init" or $_GET['action']="paytable")$param_url="CasinoGameServlet;jsession=DEMO-".$oldSSID."-EUR?action=".$_GET['action']."&sessid=DEMO-".$oldSSID."-EUR&gameId=".$_GET['gameId']."&wantsreels=true&wantsfreerounds=true&freeroundmode=false&no-cache=".$_GET['no-cache'];
//else $param_url="CasinoGameServlet;jsession=DEMO-".$oldSSID."-EUR?action=".$_GET['action']."&sessid=DEMO-".$oldSSID."-EUR&gameId=".$_GET['gameId']."&wantsreels=true&wantsfreerounds=true&freeroundmode=false&bet.betlevel=".$_GET['bet_betlevel']."&bet.denomination=".$_GET['bet_denomination']."&bet.betlines=".$_GET['bet_betlines']."&no-cache=".$_GET['no-cache'];

//    $uri='https://'.$base_url.$param_url;

$uri = 'https://' . $base_url . $param_url . $arg_str;

$answerNE = file_get_contents($uri);

$args = explode("&", $answerNE);

foreach ($args as $e => $v) {
	$temp = explode("=", $v);
	$varsNE[$temp[0]] = $temp[1];
}

$old_credit = $credit;

foreach ($varsNE as $e => $v) {
	if ($e == 'gameover') $gameover = $v;

	if ($e == 'game.win.amount') {
		//	    $total_win=$v*100;
		$total_win = $v;
		//	    $real_win=$total_win*$denomDB*0.01;
	}


	//	$relay_output.=$e."=".$v."&";
}

if ($gameover == 'true') {
	$spincost = $betDB * $linesDB * $denomDB * 0.1;


	if ($_GET['action'] == 'freespin') $spincost = 0;
	if ($_GET['action'] == 'bonusaction') $spincost = 0;
	if ($_GET['action'] == 'init') $spincost = 0;
	if ($_GET['action'] == 'paytable') $spincost = 0;

	$credit /= 100;
	$real_win = $total_win;
	$credit -= $spincost;
	$credit += $real_win;
	$creditDB = $credit * 100;
	$credit *= 100;
	echo "tw=$total_win&";
	echo "rw=$real_win&";
}


foreach ($varsNE as $e => $v) {
	if ($e == 'playforfun') $v = 'false';
	if ($e == 'credit') {
		$old_NEcredit = $v;
		$v = $credit;
	}

	$relay_output .= $e . "=" . $v . "&";
}
