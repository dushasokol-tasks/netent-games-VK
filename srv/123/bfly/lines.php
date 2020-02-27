<?
if ($lastAction == "respin") $reelset = "respin";

if (!isset($reelset)) $reelset = "basic";


if ($lastAction == "respin" and isset($makeStack)) {
	$symbols[$makeStack][0] = 3;
	$symbols[$makeStack][1] = 3;
	$symbols[$makeStack][2] = 3;
	$symbols[$makeStack][3] = 3;
}

$symbolsOverlayed = $symbols;

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
}


if ($lastAction == 'respin' or $lastAction == 'freespin') {
	$trs = 0;
	foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
		if ($symbols[$e][$e1] == 3 and $old_BF[$e][$e1] !== 1) {
			for ($i = 0; $i < 5; $i++) {
				if ($old_BF[$i][$e1] !== 1) {
					$trans[$trs] = $e . "," . $e1 . "_" . $i . "," . $e1;
					$wilds .= $i . "," . $e1 . "_";
					$old_BF[$i][$e1] = 1;
					$trs++;
					break;
				}
			}
			if ($lastAction == 'freespin') $symbols[$e][$e1] = 12;
		}
	}

	if ($lastAction == 'respin') {
		if ($trs == 0) {
			$lastAction = 'lastrespin';
			foreach ($old_BF as $e => $v)  foreach ($v as $e1 => $v1) {
				$symbols[$e][$e1] = 3;
				$symbolsOverlayed[$e][$e1] = 3;
			}
		} else {
			$wilds .= $wildsDB;
		}
	} else {
		$wilds .= $wildsDB;
		foreach ($old_BF as $e => $v)  foreach ($v as $e1 => $v1)    $symbols[$e][$e1] = 3;
	}
}

$linePatterns[0] = "0_0_0_0_0"; //1
$linePatterns[1] = "1_1_1_1_1"; //2
$linePatterns[2] = "2_2_2_2_2"; //3
$linePatterns[3] = "3_3_3_3_3"; //4
$linePatterns[4] = "0_1_2_1_0"; //5
$linePatterns[5] = "1_2_3_2_1"; //6
$linePatterns[6] = "3_2_1_2_3"; //7
$linePatterns[7] = "2_1_0_1_2"; //8
$linePatterns[8] = "0_1_2_2_2"; //9
$linePatterns[9] = "1_2_3_3_3"; //10

$linePatterns[10] = "3_2_1_1_1"; //11
$linePatterns[11] = "2_1_0_0_0"; //12
$linePatterns[12] = "0_1_0_1_0"; //13
$linePatterns[13] = "1_2_1_2_1"; //14
$linePatterns[14] = "2_3_2_3_2"; //15
$linePatterns[15] = "3_2_3_2_3"; //16
$linePatterns[16] = "2_1_2_1_2"; //17
$linePatterns[17] = "1_0_1_0_1"; //18
$linePatterns[18] = "0_1_0_0_0"; //19
$linePatterns[19] = "1_2_1_1_1"; //20

$linePatterns[20] = "2_3_2_2_2"; //21
$linePatterns[21] = "3_2_3_3_3"; //22
$linePatterns[22] = "2_1_2_2_2"; //23
$linePatterns[23] = "1_0_1_1_1"; //24
$linePatterns[24] = "0_0_0_1_2"; //25
$linePatterns[25] = "1_1_1_2_3"; //26
$linePatterns[26] = "3_3_3_2_1"; //27
$linePatterns[27] = "2_2_2_1_0"; //28
$linePatterns[28] = "0_1_1_1_0"; //29
$linePatterns[29] = "1_2_2_2_1"; //30

$linePatterns[30] = "2_3_3_3_2"; //31
$linePatterns[31] = "3_2_2_2_3"; //32
$linePatterns[32] = "2_1_1_1_2"; //33
$linePatterns[33] = "1_2_2_2_1"; //34
$linePatterns[34] = "0_1_1_0_1"; //35
$linePatterns[35] = "1_2_2_1_2"; //36
$linePatterns[36] = "2_3_3_2_3"; //37
$linePatterns[37] = "3_2_3_3_2"; //38
$linePatterns[38] = "2_1_2_2_1"; //39
$linePatterns[39] = "1_0_1_1_0"; //40

/*
$linn=5;
$testS=explode("_",$linePatterns[($linn-1)]);
$symbols[0][$testS[0]]=8;
$symbols[1][$testS[1]]=8;
$symbols[2][$testS[2]]=8;
$symbols[3][$testS[3]]=8;
$symbols[4][$testS[4]]=8;
*/




for ($i = 0; $i < 40; $i++) {
	$logger = '';
	$linePattern = explode("_", $linePatterns[$i]);
	$is_wild = "";
	$symbs[$i] = 0;

	for ($j = 0; $j < 5; $j++) {
		if ($extrawild[$j][$linePattern[$j]] == 1) $is_wild = "_1";
		elseif ($symbs[$i] == 0) $symbs[$i] = $symbols[$j][$linePattern[$j]];
	}
	if ($symbs[$i] == 0) $symbs[$i] = 3;

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
					}
				}
				$win[$i] .= $is_wild;
			}
		}
	}

	////////////////////fixme full line of wilds
	/*
    if($symbols[0][$linePattern[0]]==1 and $symbols[1][$linePattern[1]]==1 and $symbols[2][$linePattern[2]]==1)
	{

	    if($symbols[3][$linePattern[3]]==1 and $symbols[4][$linePattern[4]]==1)
	    {
		{
		    $linewin[$i]=$lineWinMarix[5][3]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2].";3,".$linePattern[3].";4,".$linePattern[4]; $logger="5xWLD=".$linewin[$i];}
		    $symbOverlays[$i]=1;
		}
	    }

	    elseif($symbols[3][$linePattern[3]]==1)
	    {
		{
		    $linewin[$i]=$lineWinMarix[4][3]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2].";3,".$linePattern[3]; $logger="4xWLD=".$linewin[$i];}
		    $symbOverlays[$i]=1;
		}
	    }
	    else
	    {
		{
		    $linewin[$i]=$lineWinMarix[3][3]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2]; $logger="3xWLD=".$linewin[$i];}
		    $symbOverlays[$i]=1;
		}
	    }
	}	
*/

	if ($symbs[$i] == 12) unset($win[$i]);

	if ($logger != '') $symb_combs .= $logger . ";";
}

foreach ($linewin as $v) {
	$total_win += $v;
}

$total_winCents = $total_win * $denomDB;

if ($lastAction == 'spin' and $total_win > 0) {
	$lastAction = "trigger";
	$reelset = "trigger";
} elseif ($lastAction == 'respin') {
	$total_winCents = 0;
	$total_win = 0;
	unset($win);
}
