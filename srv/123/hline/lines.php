<?
$wilds = '';
$wldstcks == '';

$hotlinesCount = 0;


$extrawildDBcount = 0;

if ($wildsDB != '') {
	$temp = explode(',', $wildsDB);
	foreach ($temp as $e) $wildStacksDB[intval($e)] = 1;
}

foreach ($hotlines as $hLine => $linNum) {
	for ($i = 0; $i <= 4; $i++) {
		$hasReel = 0;

		foreach ($wildStacksDB as $e => $v) //if(empty($e))
			if ($e == $i) $hasReel = 1;

		if ($hasReel == 0) {
			if ($symbols[$i][0] == 1 and $linNum == 0) {
				$wildStack[intval($i)] = 1;
				$overlaySym = 1;
			}
			if ($symbols[$i][1] == 1 and $linNum == 1) {
				$wildStack[intval($i)] = 1;
				$overlaySym = 1;
			}
			if ($symbols[$i][2] == 1 and $linNum == 2) {
				$wildStack[intval($i)] = 1;
				$overlaySym = 1;
			}
		}
	}
	$hotlinesCount++;
}

$symbolsOverlayed = $symbols;


$newStackCount = 0;

foreach ($wildStack as $e => $v) {
	if ($e == 0) {
		$symbols[0][0] = 1;
		$symbols[0][1] = 1;
		$symbols[0][2] = 1;
	}
	if ($e == 1) {
		$symbols[1][0] = 1;
		$symbols[1][1] = 1;
		$symbols[1][2] = 1;
	}
	if ($e == 2) {
		$symbols[2][0] = 1;
		$symbols[2][1] = 1;
		$symbols[2][2] = 1;
	}
	if ($e == 3) {
		$symbols[3][0] = 1;
		$symbols[3][1] = 1;
		$symbols[3][2] = 1;
	}
	if ($e == 4) {
		$symbols[4][0] = 1;
		$symbols[4][1] = 1;
		$symbols[4][2] = 1;
	}

	$hasReel = 0;
	foreach ($wildStacksDB as $e1 => $v1) {
		//		if(empty($e))
		//		if($e==e1)	$hasReel=1;
	}
	if ($hasReel == 0) {
		$newStackCount++;
		if ($wilds == '') $wilds .= $e;
		else $wilds .= "," . $e;
	}
}

if ($newStackCount != 0) {
	if ($lastAction != 'freespin') $lastAction = "respin";
	if ($wildsDB != '') $wilds = $wildsDB . "," . $wilds;
}


//$output.="LADB=$lastActionDB&";

if ($lastAction == "spin" and $lastActionDB == "respin") {
	$wildStForOutput = explode(",", $wildsDB);

	sort($wildStForOutput);
	foreach ($wildStForOutput as $e => $v) {

		if ($wldstcks == '') $wldstcks = $v;
		else $wldstcks .= "," . $v;
	}
	$lastAction = "spin1";
	$overlaySym = 1;
} else {
	$wildStForOutput = explode(",", $wilds);

	sort($wildStForOutput);
	foreach ($wildStForOutput as $e => $v) {
		if ($wldstcks == '') $wldstcks = $v;
		else $wldstcks .= "," . $v;
	}
}


if ($lastAction == "spin1" or $lastAction == "respin" or $lastAction == 'freespin') {
	$temp == explode(",", $wldstcks);
	foreach ($temp as $e => $v) {
		$symbols[$v][0] = 1;
		$symbols[$v][1] = 1;
		$symbols[$v][2] = 1;
	}
	//	if($symbolsOverlayed[$v][0]==1)$symbolsOverlayed[$v][0]=8;
	//	if($symbolsOverlayed[$v][1]==1)$symbolsOverlayed[$v][1]=8;
	//	if($symbolsOverlayed[$v][2]==1)$symbolsOverlayed[$v][2]=8;
}

if ($lastAction == 'freespin' and $wilds == '') $wilds = $wildsDB;

if ($lastAction == 'freespin') {
	$wldstcks = '';
	$wildStForOutput = explode(",", $wilds);
	sort($wildStForOutput);
	foreach ($wildStForOutput as $e => $v) {
		if ($wldstcks == '') $wldstcks = $v;
		else $wldstcks .= "," . $v;
		$wilds = $wldstcks;
	}
	$overlaySym = 1;
	//    $symbolsOverlayed=$symbols;
}

$checkBonusSymbs = '';

if ($lastAction == "spin1")	$checkBonusSymbs = $wildsDB;
if ($lastAction == "respin")	$checkBonusSymbs = $wldstcks;

if ($checkBonusSymbs != '') {
	$temp == explode(",", $wldstcks);
	foreach ($temp as $e => $v) {
		if ($symbolsOverlayed[$v][0] == 0) {
			$symbolsOverlayed[$v][0] = 8;
			$bonusSymbCount--;
		}
		if ($symbolsOverlayed[$v][1] == 0) {
			$symbolsOverlayed[$v][1] = 8;
			$bonusSymbCount--;
		}
		if ($symbolsOverlayed[$v][2] == 0) {
			$symbolsOverlayed[$v][2] = 8;
			$bonusSymbCount--;
		}
	}
}



//}
//else     $symbolsOverlayed=$symbols;

/*
    for($i=0;$i<=4;$i++)
	{
	    if(!is_null($wildStForOutput[$i])) echo $i;
//if(empty($wldstcks))$wldstcks=$i; else $wldstcks=$wldstcks.",".$i;
	}
*/

//echo $newStackCount." ns<br>";

//echo $wilds."-<br>";

//echo $lastAction."<br>";

//    $overlaySym=1;
//    $wildStack[1]=1;
//    $symbols[1][0]=1;
//    $symbols[1][1]=1;
//    $symbols[1][2]=1;



//    foreach($extrawild as $e => $v)  foreach ($v as $e1 => $v1)
//	{
//	    if($extrawild[$e][$e1]==1) $symbols[$e][$e1]=1;
//	}

//	    $output.="ew=";

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) {
		$extrawild[$e][$e1] = 1;
		//		    $output.=$e.",".$e1.";";
	}
}

//	    $output.="&";

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
$linePatterns[27] = "0_1_1_1_2"; //28
$linePatterns[28] = "1_2_2_2_0"; //29
$linePatterns[29] = "2_0_0_0_1"; //30

/*
$linn=1;

$testS=explode("_",$linePatterns[($linn-1)]);

$symbols[0][$testS[0]]=8;
$symbols[1][$testS[1]]=8;
$symbols[2][$testS[2]]=8;
$symbols[3][$testS[3]]=8;
$symbols[4][$testS[4]]=8;
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
	$symbOverlays[$i] = 3;

	if ($symbols[0][$linePattern[0]] == $symbs[$i] or $extrawild[0][$linePattern[0]] == 1) {
		if ($symbols[1][$linePattern[1]] == $symbs[$i] or $extrawild[1][$linePattern[1]] == 1) {
			$linewin[$i] = 0;
			$linewin[$i] = $lineWinMarix[2][$symbs[$i]] * $betDB;
			if ($linewin[$i] != 0) {
				$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1];
				$logger = '2xSYM' . $symbs[$i] . "=" . $linewin[$i];
			}
			if ($extrawild[1][$linePattern[1]] != 1) $symbOverlays[$i] = $symbols[1][$linePattern[1]];
			//	    if($extrawild[1][$linePattern[1]]!=1)$symbOverlays[$i]=$symbs[$i];

			if ($symbols[2][$linePattern[2]] == $symbs[$i] or $extrawild[2][$linePattern[2]] == 1) {
				$linewin[$i] = 0;
				$linewin[$i] = $lineWinMarix[3][$symbs[$i]] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = '3xSYM' . $symbs[$i] . "=" . $linewin[$i];
				}
				if ($extrawild[2][$linePattern[2]] != 1) $symbOverlays[$i] = $symbols[2][$linePattern[2]];
				//		if($extrawild[2][$linePattern[2]]!=1)$symbOverlays[$i]=$symbs[$i];

				if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
						$logger = '4xSYM' . $symbs[$i] . "=" . $linewin[$i];
					}
					if ($extrawild[3][$linePattern[3]] != 1) $symbOverlays[$i] = $symbols[3][$linePattern[3]];
					//		    if($extrawild[3][$linePattern[3]]!=1)$symbOverlays[$i]=$symbs[$i];

					if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
							$logger = '5xSYM' . $symbs[$i] . "=" . $linewin[$i];
						}
						if ($extrawild[4][$linePattern[4]] != 1) $symbOverlays[$i] = $symbols[4][$linePattern[4]];
						//			if($extrawild[4][$linePattern[4]]!=1)$symbOverlays[$i]=$symbs[$i];
					}
				}
				$win[$i] .= $is_wild;
			}
		}
	}
	//


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
