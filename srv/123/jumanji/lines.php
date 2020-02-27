<?
$wilds = '';
$rndRls;
$rlsStr = '';
$remaps = ''; //$oldWilds='';$newWilds='';
$nextAction = '';


$syms_before = "<br>syms orig%%*<br>";
for ($j = 0; $j < 5; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_before .= "[" . $symbols[$i][$j] . "]\t\t\t\t";
	}
	$syms_before .= "<br>";
}


if ($lastAction == "respin" or $fs_type == "sticky") {
	$oldRls = explode(',', $wildsDB);
	//    $wildsCount=count($oldRls);
	foreach ($oldRls as $oldRlNum => $oldRl) {
		if ($oldRl != '') {
			$oldSyms = explode(':', $oldRl);

			$symbols[$oldSyms[0]][$oldSyms[1]] = 1;
		}
	}
}

if ($lastAction == 'respin' or $lastAction == 'sticky') {

	if ($remapsDB != "") $oldSymbs = explode("_", $remapsDB);

	$remap = 0;
	for ($i = 0; $i < 5; $i++)
		for ($j = 0; $j < 5; $j++) {
			$lines_to_write[$i][$j] = "-1";
			$symbsRemap[$i][$j] = $remap;

			if ($oldSymbs[$remap] != "-1" and $remapsDB != "") {
				$symbols[$i][$j] = $oldSymbs[$remap];
				$symbolsOverlayed[$i][$j] = $oldSymbs[$remap];
				$oldSymbols[$i][$j] = $oldSymbs[$remap];
			}

			$remap++;
		}
}

$symbolsOverlayed = $symbols;


if ($lastAction == "randomwilds") {
	$k = round(rand(0, 5));
	for ($p = 0; $p < ($k + 4); $p++) {
		$i = round(rand(0, 2));
		$j = round(rand(0, 4));
		//			$wildsCount++;
		//			if($wildsCount<10)
		$extrawild[$j][$i] = 1;
	}
}



if ($lastAction == "wildreels") {
	$length = (count($reel[6]) - 1);

	for ($i = 0; $i < 2; $i++) {
		$pos1 = round(rand(0, $length));
		$j = $reel[6][$pos1];
		$rndRls[$j] = 1;
		if ($j == 0 or $j == 4) {
			$extrawild[$j][0] = 1;
			$extrawild[$j][1] = 1;
			$extrawild[$j][2] = 1;
		} elseif ($j == 1 or $j == 3) {
			$extrawild[$j][0] = 1;
			$extrawild[$j][1] = 1;
			$extrawild[$j][2] = 1;
			$extrawild[$j][3] = 1;
		} else {
			$extrawild[$j][0] = 1;
			$extrawild[$j][1] = 1;
			$extrawild[$j][2] = 1;
			$extrawild[$j][3] = 1;
			$extrawild[$j][4] = 1;
		}
	}

	foreach ($rndRls as $e => $v) if ($v == 1) if ($rlsStr == '') $rlsStr .= $e;
	else $rlsStr .= "," . $e;

	$output .= "feature.wildreels.reels=" . $rlsStr . "&";
}

if ($lastAction == "randomwilds" or $lastAction == "wildreels")	$overlaySym = 1;



foreach ($extrawild as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($extrawild[$e][$e1] == 1) $symbols[$e][$e1] = 1;
}

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) {
		$extrawild[$e][$e1] = 1;
		//		    $output.=$e.",".$e1.";";
	}
}


//line matches
$linePatterns[0] = "0_0_0_0_0"; //1
$linePatterns[1] = "0_0_1_0_0"; //2
$linePatterns[2] = "0_0_1_1_0"; //3
$linePatterns[3] = "0_0_1_1_1"; //4
$linePatterns[4] = "0_1_1_0_0"; //5
$linePatterns[5] = "0_1_1_1_0"; //6
$linePatterns[6] = "0_1_1_1_1"; //7
$linePatterns[7] = "0_1_2_1_0"; //8
$linePatterns[8] = "0_1_2_1_1"; //9
$linePatterns[9] = "0_1_2_2_1"; //10

$linePatterns[10] = "0_1_2_2_2"; //11
$linePatterns[11] = "1_1_1_0_0"; //12
$linePatterns[12] = "1_1_1_1_0"; //13
$linePatterns[13] = "1_1_1_1_1"; //14
$linePatterns[14] = "1_1_2_1_0"; //15
$linePatterns[15] = "1_1_2_1_1"; //16
$linePatterns[16] = "1_1_2_2_1"; //17
$linePatterns[17] = "1_1_2_2_2"; //18
$linePatterns[18] = "1_2_2_1_0"; //19
$linePatterns[19] = "1_2_2_1_1"; //20

$linePatterns[20] = "1_2_2_2_1"; //21
$linePatterns[21] = "1_2_2_2_2"; //22
$linePatterns[22] = "1_2_3_2_1"; //23
$linePatterns[23] = "1_2_3_2_2"; //24
$linePatterns[24] = "1_2_3_3_2"; //25
$linePatterns[25] = "2_2_2_1_0"; //26
$linePatterns[26] = "2_2_2_1_1"; //27
$linePatterns[27] = "2_2_2_2_1"; //28
$linePatterns[28] = "2_2_2_2_2"; //29
$linePatterns[29] = "2_2_3_2_1"; //30

$linePatterns[30] = "2_2_3_2_2"; //31
$linePatterns[31] = "2_2_3_3_2"; //32
$linePatterns[32] = "2_3_3_2_1"; //33
$linePatterns[33] = "2_3_3_2_2"; //34
$linePatterns[34] = "2_3_3_3_2"; //35
$linePatterns[35] = "2_3_4_3_2"; //36

/*
$linn=36;

$testS=explode("_",$linePatterns[($linn-1)]);

$symbols[0][$testS[0]]=8;
$symbols[1][$testS[1]]=8;
$symbols[2][$testS[2]]=8;
$symbols[3][$testS[3]]=8;
$symbols[4][$testS[4]]=8;
*/

//////////////////  RIGHT

for ($i = 0; $i < 36; $i++) {
	$logger = '';
	$oldwin = 0;
	$linePattern = explode("_", $linePatterns[$i]);
	$is_wild = "";
	$symbs[$i] = 0;

	//    if($extrawild[0][1]==1) $is_wild="_1";elseif($symbs[0]==0) $symbs[0]=$symbols[0][1];////////////////////////////////////????????????????????????????????

	for ($j = 0; $j < 5; $j++) {
		if ($extrawild[$j][$linePattern[$j]] == 1) $is_wild = "_1";
		elseif ($symbs[$i] == 0) $symbs[$i] = $symbols[$j][$linePattern[$j]];
	}
	if ($symbs[$i] == 0) $symbs[$i] = 3;
	$symbOverlays[$i] = 3;

	if ($symbols[0][$linePattern[0]] == $symbs[$i] or $extrawild[0][$linePattern[0]] == 1) {
		if ($symbols[1][$linePattern[1]] == $symbs[$i] or $extrawild[1][$linePattern[1]] == 1) {
			$linewin[$i] = 0;
			$linewin[$i] = $lineWinMarix[2][$symbs[$i]] * $betDB;
			if ($linewin[$i] != 0) {
				$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1];
				$logger = '2xSYM' . $symbs[$i] . "=" . $linewin[$i];
			}
			if ($extrawild[1][$linePattern[1]] != 1) {
				$symbOverlays[$i] = $symbols[1][$linePattern[1]];
			}

			if ($symbols[2][$linePattern[2]] == $symbs[$i] or $extrawild[2][$linePattern[2]] == 1) {
				$linewin[$i] = 0;
				$linewin[$i] = $lineWinMarix[3][$symbs[$i]] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = '3xSYM' . $symbs[$i] . "=" . $linewin[$i];
				}
				if ($extrawild[2][$linePattern[2]] != 1) {
					$symbOverlays[$i] = $symbols[2][$linePattern[2]];
				}
				$lines_to_write[0][$linePattern[0]] = "1";
				$lines_to_write[1][$linePattern[1]] = "1";
				$lines_to_write[2][$linePattern[2]] = "1";

				if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
						$logger = '4xSYM' . $symbs[$i] . "=" . $linewin[$i];
					}
					if ($extrawild[3][$linePattern[3]] != 1) {
						$symbOverlays[$i] = $symbols[3][$linePattern[3]];
					}
					$lines_to_write[0][$linePattern[0]] = "1";
					$lines_to_write[1][$linePattern[1]] = "1";
					$lines_to_write[2][$linePattern[2]] = "1";
					$lines_to_write[3][$linePattern[3]] = "1";

					if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
							$logger = '5xSYM' . $symbs[$i] . "=" . $linewin[$i];
						}
						if ($extrawild[4][$linePattern[4]] != 1) {
							$symbOverlays[$i] = $symbols[4][$linePattern[4]];
						}
						$lines_to_write[0][$linePattern[0]] = "1";
						$lines_to_write[1][$linePattern[1]] = "1";
						$lines_to_write[2][$linePattern[2]] = "1";
						$lines_to_write[3][$linePattern[3]] = "1";
						$lines_to_write[4][$linePattern[4]] = "1";
					}
				}
				$win[$i] .= $is_wild;
			}
		}
	}

	if ($logger != '') $symb_combs .= $logger . ";";
}

foreach ($linewin as $v) {
	$total_win += $v;
}

$total_winCents = $total_win * $denomDB;



for ($i = 0; $i < 5; $i++) {
	for ($j = 0; $j < 5; $j++) {
		$symsLast2DB .= $symbols[$i][$j] . ",";
	}
	$symsLast2DB .= "_";
}


$syms_after = "<br>syms orig%%*<br>";
for ($j = 0; $j < 5; $j++) {
	for ($i = 0; $i < 5; $i++) {
		$syms_after .= "[" . $symbols[$i][$j] . "]\t\t\t\t";
	}
	$syms_after .= "<br>";
}


////// respin generator


if ($stickyFlag == 1 or $fs_type == "sticky") {
	if ($total_win != 0) {
		if ($lastAction == 'spin') {
			$lastAction = "sticky";
			$respinNum = 1;
		} elseif ($lastAction == 'freespin' and $fs_type == "sticky") {
			$lastAction = "sticky";
			$respinNum = 1;
		} elseif ($lastAction == 'respin') $respinNum++;
	} elseif ($fs_type == "sticky") $lastAction = "freespin";
}

if ($shuffleFlag == 1)
	if ($total_win == 0) {
		if ($lastAction != "aftershuffle") {
			for ($i = 0; $i < 5; $i++)
				for ($j = 0; $j < 5; $j++) {
					if (isset($symbols[$i][$j])) $aviableSymbols[$symbols[$i][$j]]++;
				}

			foreach ($aviableSymbols as $oldRlNum => $oldRl)
				if ($oldRl > 3) {
					$lastAction = "shuffle";
				}
		}
	}






if (($lastAction == 'freespin' and $fs_type == "sticky") or $lastAction == "sticky" or $lastAction == "respin") {
	if ($lastAction == "freespin" and $fs_type == "sticky") {
		$nextAction = 'freespin';
		for ($i = 0; $i < 5; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($symbols[$i][$j] == 1) {
					if ($wilds == '') $wilds = $i . ":" . $j;
					else $wilds .= "," . $i . ":" . $j;
				}
			}
		}
	} else {
		$full_reel = 1;
		for ($i = 0; $i < 5; $i++)
			for ($j = 0; $j < 5; $j++)

				if ($lines_to_write[$i][$j] == "1") {
					$remaps .= $symbols[$i][$j] . "_";
					if ($symbols[$i][$j] != $oldSymbols[$i][$j]) $saveToNewSpin = 1;
					$holdSymbs[$i][$j] = "1";
					if ($symbols[$i][$j] != 1) if ($stickyPositions == '') $stickyPositions = $i . ":" . $j;
					else $stickyPositions .= "," . $i . ":" . $j;
				} else {
					$remaps .= "-1_";
					$full_reel = 0;
				}

		if ($full_reel == 1) {
			$remaps = "";
			for ($i = 0; $i < 5; $i++) for ($j = 0; $j < 5; $j++) $holdSymbs[$i][$j] = "0";
		} else {
			if ($saveToNewSpin == 0) {
				$remaps = "";
				for ($i = 0; $i < 5; $i++) for ($j = 0; $j < 5; $j++) $holdSymbs[$i][$j] = "0";
				$lastAction = 'lastrespin';
			}

			for ($i = 0; $i < 5; $i++) {
				for ($j = 0; $j < 5; $j++) {
					if ($symbols[$i][$j] == 1) {
						if ($wilds == '') $wilds = $i . ":" . $j;
						else $wilds .= "," . $i . ":" . $j;
					}
				}
			}
		}
	}
} else {
	$remaps = "";
	$wilds = '';
	for ($i = 0; $i < 5; $i++) for ($j = 0; $j < 5; $j++) $holdSymbs[$i][$j] = "0";
}


if ($lastAction == 'respin') {
	unset($lines_to_write[0][3]);
	unset($lines_to_write[0][4]);
	unset($lines_to_write[1][4]);
	unset($lines_to_write[3][4]);
	unset($lines_to_write[4][3]);
	unset($lines_to_write[4][4]);
	$endRespin = 1;
	for ($i = 0; $i < 5; $i++)
		for ($j = 0; $j < 5; $j++) if ($lines_to_write[$i][$j] != '1' and isset($lines_to_write[$i][$j])) $endRespin = 0;
	if ($endRespin == 1) $lastAction = 'lastrespin';
}









if ($lastAction == "randomwilds") {
	for ($i = 0; $i < 5; $i++)
		for ($j = 0; $j < 5; $j++)
			if ($symbols[$i][$j] == 1) {
				if ($wilds == '') $wilds = $i . ":" . $j;
				else $wilds .= "," . $i . ":" . $j;
			}
}


//echo $wilds."<br>";




/*

if($lastAction=='respin' or $lastAction=='sticky')
{
    $symWin=0;	//$stickyPositions=$stickyPositionsDB;
    $stickyPositions='';
    $newRespinSymbsCount=0;

    if(!isset($respinSym))foreach($symLineWin as $e=>$v)if($v!=0) {$respinSyms[$v]=$v;echo $v."<br>";}


    foreach($respinSyms as $e=>$respinSym)
    if(isset($respinSym) and $respinSym!=0)
    {
//    if($lastAction!='respin'){$lastAction="sticky";$respinNum=1;}
//    else $respinNum++;
    for($i=0;$i<5;$i++)
	{
	for($j=0;$j<5;$j++)
	    {
		if($symbols[$i][$j]==1)
		{
		    $newWildSymbsCount++;
		    if($wilds=='')$wilds=$i.":".$j;else $wilds.=",".$i.":".$j;
		}

		if($symbols[$i][$j]==$respinSym)
		{
		    $newRespinSymbsCount++;
		    if($stickyPositions=='')$stickyPositions=$i.":".$j;else $stickyPositions.=",".$i.":".$j;
		}
*/
/*
		if($symbols[$i][$j]==1 or $symbols[$i][$j]==$respinSym)
		{
		    if($stickyPositions=='')$stickyPositions=$i.":".$j;else $stickyPositions.=",".$i.":".$j;
		    if($symbols[$i][$j]==$respinSym) $newRespinSymbsCount++;
		    if($symbols[$i][$j]==1) $newWildSymbsCount++;
		}
*/

/*
	    }
	}
    }
//    if(!isset($newWildSymbsCount))$newWildSymbsCount=0;
    if(($newWildSymbsCount==$wildSymbsCount) and ($newRespinSymbsCount==$respinSymbsCount))$lastAction='lastrespin';
}

*/




//echo "respinSymbsCount: $respinSymbsCount ; wildSymbsCount: $wildSymbsCount ; newRespinSymbsCount: $newRespinSymbsCount ; newWildSymbsCount: $newWildSymbsCount ;<br>";
//echo "sticky: $respinSym<br>";
//echo "remapsDB: $remapsDB<br>";
//echo "stickyPOS: $stickyPositions<br>";

//echo $syms_before;

//echo $syms_after;
