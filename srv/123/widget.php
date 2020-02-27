<?

if ($_Social['free_rounds'] > 0 and $widgetOn != 0) {
	$freerounds = $_Features['tillFS'] - $today_ts;
	if ($freerounds > 0) $freerounds = 2;
} else $freerounds = 1; ////???

if (isset($freeRoundsLeft) and $_GET['action'] == 'init') unset($freeRoundsLeft);


if (($_Social['free_rounds'] > 0 and $widgetOn == 1 and $freerounds <= 0) or (isset($freeRoundsLeft) and $freeRoundsLeft > 0)) {
	$widgetReady = 1;
	if (!isset($freeRoundsLeft) and $_GET['action'] == 'init') {
		$freeRoundsLeft = $_Social['free_rounds'];
		$social_logger .= "start widget $freeRoundsLeft;";
	}
}

if ($widgetReady == 1) {
	$output .= 'freeRoundWidgetEnabled=true&';
	$output .= 'bonusProgramId=1&';

	if (!isset($freeRoundsWin)) {
		for ($i = 1; $i < 6; $i++) {
			$temp = round(rand(1, ($freeRoundsLeft + 3)));
			$sections[$i] = $temp;
		}
		$sections[0] = $freeRoundsLeft;

		// shuffle($sections);

		foreach ($sections as $e => $v) {
			if ($v == $freeRoundsLeft) $indexToShow = $e + 1;
		}

		//if($_GET['sessid']!='VK10637772')$sections[5]=5;

		$widgetReel .= 'freeRoundWidgetSections={"sections":[{"index": 1,"numberOfFreeRounds": ' . $sections[0] . '},{"index": 2,"numberOfFreeRounds": ' . $sections[1] . '},
 {"index": 3,"numberOfFreeRounds": ' . $sections[2] . '}, {"index": 4,"numberOfFreeRounds": ' . $sections[3] . '}, {"index": 5,"numberOfFreeRounds": ' . $sections[4] . '},
 {"index": 6, "numberOfFreeRounds": ' . $sections[5] . '}]}&';

		$answ .= "indexToShow=" . $indexToShow . ";";
	}


	if ($_GET['action'] == 'widgetspin') {
		$output = '';
		$lastAction = 'widgetspin';
		$output .= 'numberOfFreeRounds=' . $freeRoundsLeft . '&indexToShow=' . $indexToShow . '&';
		$answ .= "freeRoundsLeft=" . $freeRoundsLeft . ";";
	} else
 if ($_GET['action'] == 'init' and $lastActionDB == 'widgetspin') {
		$output = '';
		$lastAction = 'freeroundsinit';
		$output .= "freeRoundsLeft=$freeRoundsLeft&";
		$answ .= "freeRoundsLeft=$freeRoundsLeft;";
		$output .= 'bonusInfo={"externalReferenceID":"1","bonusID":"1","bonusType":"freeRound"}&';
		$symb_combs .= "started freerounds: " . $_Social['free_rounds'];
		$_Social['free_rounds'] = 0;
	} elseif ($freeRoundsLeft > 0 and $_GET['action'] != 'init') {
		$betDB = 1;
		$denomDB = 100;
		$symb_combs .= "freeround: " . $freeRoundsLeft . "; ";
	}

	//if($_GET['sessid']=='VK10637772'){
	/*
$output.='numberOfFreeRounds=5&indexToShow=6&';

 $widgetReel='freeRoundWidgetSections={"sections":[{"index": 1,"numberOfFreeRounds": '.$sections[0].'},{"index": 2,"numberOfFreeRounds": '.$sections[1].'},
 {"index": 3,"numberOfFreeRounds": '.$sections[2].'}, {"index": 4,"numberOfFreeRounds": '.$sections[3].'}, {"index": 5,"numberOfFreeRounds": '.$sections[4].'},
 {"index": 6, "numberOfFreeRounds": 5}]}&';
*/
	//}
	//else
	$output .= 'freeRoundWidgetGameId=free_rounds_widget-midsommar&';
	//$output.='freeRoundWidgetGameId=free_rounds_widget-scudamore&';
	//$output.='freeRoundWidgetGameId=free_rounds_widget-chinese-new-year&';
	//$output.='freeRoundWidgetGameId=free_rounds_widget-jinglespin&';

	$output .= $widgetReel;
}
