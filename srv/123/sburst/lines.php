<?
$symbolsOverlayed = $symbols;

if ($lastAction == "respin") {
	for ($i = 1; $i < 4; $i++) {
		if ($wildReels[$i] == 1) {
			$extrawild[$i][0] = 1;
			$extrawild[$i][1] = 1;
			$extrawild[$i][2] = 1;
			$symb_combs .= "new_reel=" . $i . ";";
		}
	}


	if ($wildsDB == "") {
		$lastAction = "stackSpin1";
	} elseif ($wildsDB != "" and ($lastActionDB == "stackSpin")) {
		$temp = explode('_', $wildsDB);
		foreach ($temp as $e) if ($e != '') {
			$temp2 = explode(',', $e);
			$extrawildDB[$temp2[0]][$temp2[1]] = 1;
			$extraWildOnReel[$temp2[0]] = 1;
		}

		for ($i = 1; $i < 4; $i++) {
			for ($j = 0; $j < 4; $j++)    if ($extrawild[$i][$j] == 1 and $extraWildOnReel[$i] == 0) {
				$lastAction = "stackSpin";
				$symb_combs .= "old_reel=" . $i . ";";
			}
		}

		foreach ($extrawildDB as $tReel => $t)
			foreach ($t as $tRow => $e) {
				if ($extrawild[$tReel][$tRow] == 0) $extrawild[$tReel][$tRow] = $extrawildDB[$tReel][$tRow];
			}
	} else {

		foreach ($extrawildDB as $tReel => $t)
			foreach ($t as $tRow => $e) {
				if ($symbols[$tReel][$tRow] == 1) {
					$symbols[$tReel][$tRow] = 9;
					$symbolsOverlayed[$tReel][$tRow] = 9;
				}
			}
	}

	foreach ($extrawild as $e => $v) {
		foreach ($v as $e1 => $v1) {
			if ($extrawild[$e][$e1] == 1) {
				$symbols[$e][$e1] = 1;
				if ($lastAction == "respin")    $symbolsOverlayed[$e][$e1] = 1;
			}
			if ($lastAction == "stackSpin" or $lastAction == "stackSpin1") $wilds .= $e . "," . $e1 . "_";
		}
	}


	for ($i = 1; $i < 4; $i++) {
		if ($extrawild[$i][0] == 1) $rls = $rls . $i;
		if ($extraWildOnReel[$i] == 1) $old_rls = $old_rls . $i;
	}
}

//	    if($lastAction=="spin") $symbolsOverlayed=$symbols;

//echo $lastAction."<br>";

/*
$extrawild[0][0]=1;
$extrawild[0][1]=1;
$extrawild[0][2]=1;

$extrawild[4][0]=1;
$extrawild[4][1]=1;
$extrawild[4][2]=1;
*/

//$symbols[0][0]=7;$symbols[0][1]=1;$symbols[0][2]=7;
//$symbols[1][0]=6;$symbols[1][1]=7;$symbols[1][2]=6;
//$symbols[2][0]=6;$symbols[2][1]=7;$symbols[2][2]=6;
/*
$symbols[0][0]=1;
$symbols[1][0]=1;

$symbols[0][0]=0;
$symbols[1][0]=0;
//$symbols[2][0]=0;
//$symbols[3][0]=0;
$symbols[4][0]=0;
*/
//$symbolsOverlayed[0][1]=5;



//$overlaySym=$symbols[0][1];
//$overlaySym="3";

//if($lastAction!="symbol_transform")



//$extrawild[1][1]=1;
//$extrawild[1][2]=1;
/*
    foreach($extrawild as $e => $v)  foreach ($v as $e1 => $v1)
	{
	    if($extrawild[$e][$e1]==1) $symbols[$e][$e1]=1;
	}
*/


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

/*
$linn=1;

$testS=explode("_",$linePatterns[($linn-1)]);

$symbols[0][$testS[0]]=9;
$symbols[1][$testS[1]]=9;
$symbols[2][$testS[2]]=9;
$symbols[3][$testS[3]]=9;
$symbols[4][$testS[4]]=9;
*/

//////////////////  RIGHT

for ($i = 0; $i < 10; $i++) {
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
	$symbOverlays[$i] = $symbols[0][$linePattern[0]];

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
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB * 2;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
							$logger = '!DBL!5xSYM' . $symbs[$i] . "=" . $linewin[$i];
						}
						if ($extrawild[4][$linePattern[4]] != 1) $symbOverlays[$i] = $symbols[4][$linePattern[4]];
					}
				}

				$win[$i] .= $is_wild;
			}
		}
	}
	/*
    if($symbols[0][$linePattern[0]]==1 and $symbols[1][$linePattern[1]]==1 and $symbols[2][$linePattern[2]]==1)
	{

	    if($symbols[3][$linePattern[3]]==1 and $symbols[4][$linePattern[4]]==1)
	    {
		if(($lineWinMarix[5][1]*$betDB)>$linewin[$i])
		{
	    
		    $linewin[$i]=$lineWinMarix[5][1]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2].";3,".$linePattern[3].";4,".$linePattern[4]; $logger="5xWLD=".$linewin[$i];}
		}
	    }

	    elseif($symbols[3][$linePattern[3]]==1)
	    {
	    	if(($lineWinMarix[4][1]*$betDB)>$linewin[$i])
		{
		    $linewin[$i]=$lineWinMarix[4][1]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2].";3,".$linePattern[3]; $logger="4xWLD=".$linewin[$i];}
		}
	    }
	    else
	    {
	    	if(($lineWinMarix[3][1]*$betDB)>$linewin[$i])
		{
		    $linewin[$i]=$lineWinMarix[3][1]*$betDB;
		    if($linewin[$i]!=0){$win[$i]=$linewin[$i]."_0,".$linePattern[0].";1,".$linePattern[1].";2,".$linePattern[2]; $logger="3xWLD=".$linewin[$i];}
		}
	    }

	}	
*/
	if ($logger != '') $symb_combs .= $logger . ";";
}


////////////////////  LEFT

for ($i = 0; $i < 10; $i++) {
	$logger = '';
	$oldwin = 0;
	if ($win[$i] == '') {
		$linePattern = explode("_", $linePatterns[$i]);
		$is_wild = "";
		$symbs[$i] = 0;
		for ($j = 4; $j > 0; $j--) {
			if ($extrawild[$j][$linePattern[$j]] == 1) $is_wild = "_1";
			elseif ($symbs[$i] == 0) $symbs[$i] = $symbols[$j][$linePattern[$j]];
		}
		if ($symbs[$i] == 0) $symbs[$i] = 1;
		$symbOverlays[$i] = $symbols[4][$linePattern[4]];

		if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
			if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
				$linewin[$i] = 0;
				$linewin[$i] = $lineWinMarix[2][$symbs[$i]] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_4," . $linePattern[4] . ";3," . $linePattern[3];
					$logger = '2xSYMr' . $symbs[$i] . "=" . $linewin[$i];
				}
				if ($extrawild[4][$linePattern[4]] != 1) $symbOverlays[$i] = $symbols[4][$linePattern[4]];

				if ($symbols[2][$linePattern[2]] == $symbs[$i] or $extrawild[2][$linePattern[2]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[3][$symbs[$i]] * $betDB;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_4," . $linePattern[4] . ";3," . $linePattern[3] . ";2," . $linePattern[2];
						$logger = '3xSYMr' . $symbs[$i] . "=" . $linewin[$i];
					}
					if ($extrawild[2][$linePattern[2]] != 1) $symbOverlays[$i] = $symbols[2][$linePattern[2]];

					if ($symbols[1][$linePattern[1]] == $symbs[$i] or $extrawild[1][$linePattern[1]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_4," . $linePattern[4] . ";3," . $linePattern[3] . ";2," . $linePattern[2] . ";1," . $linePattern[1];
							$logger = '4xSYMr' . $symbs[$i] . "=" . $linewin[$i];
						}
						if ($extrawild[1][$linePattern[1]] != 1) $symbOverlays[$i] = $symbols[1][$linePattern[1]];

						if ($symbols[0][$linePattern[0]] == $symbs[$i] or $extrawild[0][$linePattern[0]] == 1) {
							$linewin[$i] = 0;
							$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB;
							if ($linewin[$i] != 0) {
								$win[$i] = $linewin[$i] . "_4," . $linePattern[4] . ";3," . $linePattern[3] . ";2," . $linePattern[2] . ";1," . $linePattern[1] . ";0," . $linePattern[0];
								$logger = '5xSYMr' . $symbs[$i] . "=" . $linewin[$i];
							}
							if ($extrawild[0][$linePattern[0]] != 1) $symbOverlays[$i] = $symbols[0][$linePattern[0]];
						}
					}

					$win[$i] .= $is_wild;
				}
			}
		}
	}
	if ($logger != '') $symb_combs .= $logger . ";";
}


//for($i=0;$i<10;$i++)echo $symbOverlays[$i].";";
//echo "<br>";

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
