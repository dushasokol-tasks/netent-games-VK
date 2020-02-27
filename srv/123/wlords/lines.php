<?

if ($lastAction == "freespin" and $winningScatter == 15) {
	$wilds = '';
	foreach ($extrawildDB as $tReel => $t)
		foreach ($t as $tRow => $e) {
			$wildCount++;
			$wilds .= $tReel . "," . $tRow . "_";
			$extrawild[$tReel][$tRow] = 1;
		}
	$overlaySym = 1;
}

$symbolsOverlayed = $symbols;

foreach ($extrawild as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($extrawild[$e][$e1] == 1) $symbols[$e][$e1] = 1;
}


foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
}




//line matches
$linePatterns[0] = "1_1_1_1_1"; //1
$linePatterns[1] = "0_0_0_0_0"; //2
$linePatterns[2] = "2_2_2_2_2"; //3
$linePatterns[3] = "0_1_2_1_0"; //4
$linePatterns[4] = "2_1_0_1_2"; //5
$linePatterns[5] = "0_0_1_0_0"; //6
$linePatterns[6] = "2_2_1_2_2"; //7
$linePatterns[7] = "1_2_2_2_1"; //8
$linePatterns[8] = "1_0_0_0_1"; //9
$linePatterns[9] = "1_0_1_0_1"; //10

$linePatterns[10] = "1_2_1_2_1"; //11
$linePatterns[11] = "0_1_0_1_0"; //12
$linePatterns[12] = "2_1_2_1_2"; //13
$linePatterns[13] = "1_1_0_1_1"; //14
$linePatterns[14] = "1_1_2_1_1"; //15
$linePatterns[15] = "0_1_1_1_0"; //16
$linePatterns[16] = "2_1_1_1_2"; //17
$linePatterns[17] = "0_2_0_2_0"; //18
$linePatterns[18] = "2_0_2_0_2"; //19
$linePatterns[19] = "0_2_2_2_0"; //20

$linePatterns[20] = "2_0_0_0_2"; //21
$linePatterns[21] = "0_0_2_0_0"; //22
$linePatterns[22] = "2_2_0_2_2"; //23
$linePatterns[23] = "0_2_1_2_0"; //24
$linePatterns[24] = "2_0_1_0_2"; //25
$linePatterns[25] = "1_2_0_2_1"; //26
$linePatterns[26] = "1_0_2_0_1"; //27
$linePatterns[27] = "0_0_1_2_2"; //28
$linePatterns[28] = "2_2_1_0_0"; //29
$linePatterns[29] = "0_1_2_2_2"; //30

/*
$linn=30;

$testS=explode("_",$linePatterns[($linn-1)]);

$symbols[0][$testS[0]]=9;
$symbols[1][$testS[1]]=9;
$symbols[2][$testS[2]]=9;
$symbols[3][$testS[3]]=9;
$symbols[4][$testS[4]]=9;
*/

//////////////////  RIGHT

for ($i = 0; $i < 30; $i++) {
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

	if ($symbols[0][$linePattern[0]] == $symbs[$i] or $extrawild[0][$linePattern[0]] == 1) {
		if ($symbols[1][$linePattern[1]] == $symbs[$i] or $extrawild[1][$linePattern[1]] == 1) {
			$linewin[$i] = 0;
			$linewin[$i] = $lineWinMarix[2][$symbs[$i]] * $betDB;
			if ($linewin[$i] != 0) {
				$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1];
				$logger = '2xSYM' . $symbs[$i] . "=" . $linewin[$i];
			}
			if ($extrawild[1][$linePattern[1]] != 1) $symbOverlays[$i] = $symbols[1][$linePattern[1]];

			if ($symbols[2][$linePattern[2]] == $symbs[$i] or $extrawild[2][$linePattern[2]] == 1) {
				$linewin[$i] = 0;
				$linewin[$i] = $lineWinMarix[3][$symbs[$i]] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = '3xSYM' . $symbs[$i] . "=" . $linewin[$i];
				}
				if ($extrawild[2][$linePattern[2]] != 1) $symbOverlays[$i] = $symbols[2][$linePattern[2]];

				if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
						$logger = '4xSYM' . $symbs[$i] . "=" . $linewin[$i];
					}
					if ($extrawild[3][$linePattern[3]] != 1) $symbOverlays[$i] = $symbols[3][$linePattern[3]];

					if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
							$logger = '5xSYM' . $symbs[$i] . "=" . $linewin[$i];
						}
						if ($extrawild[4][$linePattern[4]] != 1) $symbOverlays[$i] = $symbols[4][$linePattern[4]];
					}
				}
				$win[$i] .= $is_wild;
			}
		}
	}
	//


	if ($symbols[0][$linePattern[0]] == 1 and $symbols[1][$linePattern[1]] == 1 and $symbols[2][$linePattern[2]] == 1) {

		if ($symbols[3][$linePattern[3]] == 1 and $symbols[4][$linePattern[4]] == 1) {
			if (($lineWinMarix[5][1] * $betDB) > $linewin[$i]) {

				$linewin[$i] = $lineWinMarix[5][1] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
					$logger = "5xWLD=" . $linewin[$i];
				}
			}
		} elseif ($symbols[3][$linePattern[3]] == 1) {
			if (($lineWinMarix[4][1] * $betDB) > $linewin[$i]) {
				$linewin[$i] = $lineWinMarix[4][1] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
					$logger = "4xWLD=" . $linewin[$i];
				}
			}
		} else {
			if (($lineWinMarix[3][1] * $betDB) > $linewin[$i]) {
				$linewin[$i] = $lineWinMarix[3][1] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = "3xWLD=" . $linewin[$i];
				}
			}
		}
	}


	//

	if ($logger != '') $symb_combs .= $logger . ";";
}

/*
////////////////////  LEFT

for($i=0;$i<10;$i++)
{
$logger='';$oldwin=0;
 if($win[$i]=='')
 {
    $linePattern=explode("_",$linePatterns[$i]);
    $is_wild="";$symbs[$i]=0;
    for($j=4;$j>0;$j--)
    {
	if($extrawild[$j][$linePattern[$j]]==1) $is_wild="_1";elseif($symbs[$i]==0) $symbs[$i]=$symbols[$j][$linePattern[$j]];
    }
    if($symbs[$i]==0) $symbs[$i]=1;

    if($symbols[4][$linePattern[4]]==$symbs[$i] or $extrawild[4][$linePattern[4]]==1)
	{
	if($symbols[3][$linePattern[3]]==$symbs[$i] or $extrawild[3][$linePattern[3]]==1)
	    {
	    $linewin[$i]=0;
	    $linewin[$i]=$lineWinMarix[2][$symbs[$i]]*$betDB;
	    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_4,".$linePattern[4].";3,".$linePattern[3]; $logger='2xSYMr'.$symbs[$i]."=".$linewin[$i];}
	    if($extrawild[4][$linePattern[4]]!=1)$symbOverlays[$i]=$symbols[4][$linePattern[4]];

	    if($symbols[2][$linePattern[2]]==$symbs[$i] or $extrawild[2][$linePattern[2]]==1)
		{
		$linewin[$i]=0;
		$linewin[$i]=$lineWinMarix[3][$symbs[$i]]*$betDB;
		if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_4,".$linePattern[4].";3,".$linePattern[3].";2,".$linePattern[2]; $logger='3xSYMr'.$symbs[$i]."=".$linewin[$i];}
		if($extrawild[2][$linePattern[2]]!=1)$symbOverlays[$i]=$symbols[2][$linePattern[2]];

		if($symbols[1][$linePattern[1]]==$symbs[$i] or $extrawild[1][$linePattern[1]]==1)
		    {
		    $linewin[$i]=0;
		    $linewin[$i]=$lineWinMarix[4][$symbs[$i]]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_4,".$linePattern[4].";3,".$linePattern[3].";2,".$linePattern[2].";1,".$linePattern[1]; $logger='4xSYMr'.$symbs[$i]."=".$linewin[$i];}
		    if($extrawild[1][$linePattern[1]]!=1)$symbOverlays[$i]=$symbols[1][$linePattern[1]];

		    if($symbols[0][$linePattern[0]]==$symbs[$i] or $extrawild[0][$linePattern[0]]==1)
			{
			$linewin[$i]=0;
			$linewin[$i]=$lineWinMarix[5][$symbs[$i]]*$betDB;
		        if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_4,".$linePattern[4].";3,".$linePattern[3].";2,".$linePattern[2].";1,".$linePattern[1].";0,".$linePattern[0]; $logger='5xSYMr'.$symbs[$i]."=".$linewin[$i];}
			if($extrawild[0][$linePattern[0]]!=1)$symbOverlays[$i]=$symbols[0][$linePattern[0]];
			}

		    }

		$win[$i].=$is_wild;
		}
	    }
	}
 }
if($logger!='')$symb_combs.=$logger.";";
}
*/
/*
///////////// MIDDLE


for($i=0;$i<10;$i++)
{
$logger='';$oldwin=0;
 if($win[$i]=='')
 {
    $linePattern=explode("_",$linePatterns[$i]);
    $is_wild="";$symbs[$i]=0;

    if(($extrawild[1][$linePattern[1]]==1) or ($extrawild[3][$linePattern[3]]==1))$is_wild="_1";
    $symbs[$i]=$symbols[2][$linePattern[2]];

    if($symbols[1][$linePattern[1]]==$symbs[$i] or $extrawild[1][$linePattern[1]]==1)
	if($symbols[3][$linePattern[3]]==$symbs[$i] or $extrawild[3][$linePattern[3]]==1)
	{
		    $linewin[$i]=0;
		    $linewin[$i]=$lineWinMarix[3][$symbs[$i]]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_3,".$linePattern[3].";2,".$linePattern[2].";1,".$linePattern[1]; $logger='3xSYMm'.$symbs[$i]."=".$linewin[$i];}
		    $symbOverlays[$i]=$symbols[2][$linePattern[2]];
	}


 }
if($logger!='')$symb_combs.=$logger.";";
}
*/


foreach ($linewin as $v) {
	$total_win += $v;
}

$total_winCents = $total_win * $denomDB;
