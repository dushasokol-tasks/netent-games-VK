<?
//if($lastAction=="respin")$reelset="respin";

if (!isset($reelset)) $reelset = "basic";

$symbolsOverlayed = $symbols;

if ($lastAction == "daze" and isset($makeStack)) {
	//echo "MS=$makeStack";
	foreach ($makeStack as $e => $v) {
		if (isset($symbols[$e][0])) $symbols[$e][0] = 1;
		if (isset($symbols[$e][1])) $symbols[$e][1] = 1;
		if (isset($symbols[$e][2])) $symbols[$e][2] = 1;
		if (isset($symbols[$e][3])) $symbols[$e][3] = 1;
		if (isset($symbols[$e][4])) $symbols[$e][4] = 1;
		/*
	 if(isset($symbols[$makeStack][0]))$symbols[$makeStack][0]=1;
	 if(isset($symbols[$makeStack][1]))$symbols[$makeStack][1]=1;
	 if(isset($symbols[$makeStack][2]))$symbols[$makeStack][2]=1;
	 if(isset($symbols[$makeStack][3]))$symbols[$makeStack][3]=1;
	 if(isset($symbols[$makeStack][4]))$symbols[$makeStack][4]=1;
*/
	}
}


foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
}

/*
if($lastAction=='respin' or $lastAction=='freespin')
{
 $trs=0;
 foreach($symbols as $e => $v)  foreach ($v as $e1 => $v1)
    {
    if($symbols[$e][$e1]==3 and $old_BF[$e][$e1]!==1)
	{
	    for($i=0;$i<5;$i++)
	    {
		if($old_BF[$i][$e1]!==1)
		{
		    $trans[$trs]=$e.",".$e1."_".$i.",".$e1;
		    $wilds.=$i.",".$e1."_";
		    $old_BF[$i][$e1]=1;
		    $trs++;
		    break;
		}
	    }
	if($lastAction=='freespin') $symbols[$e][$e1]=12;
	}
    }

 if($lastAction=='respin')
 {
    if($trs==0)
    {
	$lastAction='lastrespin';
	foreach($old_BF as $e => $v)  foreach ($v as $e1 => $v1)
	    {
		$symbols[$e][$e1]=3;
		$symbolsOverlayed[$e][$e1]=3;
	    }
    }
    else {$wilds.=$wildsDB;}
 }
 else
 {
	$wilds.=$wildsDB;
	foreach($old_BF as $e => $v)  foreach ($v as $e1 => $v1)    $symbols[$e][$e1]=3;
 }
}
*/

$linePatterns[0] = "0_0_0_0_0"; //1
$linePatterns[1] = "0_0_0_0_1"; //2
$linePatterns[2] = "0_0_0_1_1"; //3
$linePatterns[3] = "0_0_0_1_2"; //4
$linePatterns[4] = "0_0_1_0_0"; //5
$linePatterns[5] = "0_0_1_0_1"; //6
$linePatterns[6] = "0_0_1_1_1"; //7
$linePatterns[7] = "0_0_1_1_2"; //8
$linePatterns[8] = "0_0_1_2_2"; //9
$linePatterns[9] = "0_0_1_2_3"; //10
$linePatterns[10] = "0_1_1_0_0"; //11
$linePatterns[11] = "0_1_1_0_1"; //12
$linePatterns[12] = "0_1_1_1_1"; //13

$linePatterns[13] = "0_1_1_1_2"; //14
$linePatterns[14] = "0_1_1_2_2"; //15
$linePatterns[15] = "0_1_1_2_3"; //16
$linePatterns[16] = "0_1_2_1_1"; //17
$linePatterns[17] = "0_1_2_1_2"; //18
$linePatterns[18] = "0_1_2_2_2"; //19
$linePatterns[19] = "0_1_2_2_3"; //20
$linePatterns[20] = "0_1_2_3_3"; //21
$linePatterns[21] = "0_1_2_3_4"; //22
$linePatterns[22] = "1_0_0_0_0"; //23
$linePatterns[23] = "1_0_0_0_1"; //24
$linePatterns[24] = "1_0_0_1_1"; //25
$linePatterns[25] = "1_0_0_1_2"; //26

$linePatterns[26] = "1_0_1_0_0"; //27
$linePatterns[27] = "1_0_1_0_1"; //28
$linePatterns[28] = "1_0_1_1_1"; //29
$linePatterns[29] = "1_0_1_1_2"; //30
$linePatterns[30] = "1_0_1_2_2"; //31
$linePatterns[31] = "1_0_1_2_3"; //32
$linePatterns[32] = "1_1_1_0_0"; //33
$linePatterns[33] = "1_1_1_0_1"; //34
$linePatterns[34] = "1_1_1_1_1"; //35
$linePatterns[35] = "1_1_1_1_2"; //36
$linePatterns[36] = "1_1_1_2_2"; //37
$linePatterns[37] = "1_1_1_2_3"; //38
$linePatterns[38] = "1_1_2_1_1"; //39

$linePatterns[39] = "1_1_2_1_2"; //40
$linePatterns[40] = "1_1_2_2_2"; //41
$linePatterns[41] = "1_1_2_2_3"; //42
$linePatterns[42] = "1_1_2_3_3"; //43
$linePatterns[43] = "1_1_2_3_4"; //44
$linePatterns[44] = "1_2_2_1_1"; //45
$linePatterns[45] = "1_2_2_1_2"; //46
$linePatterns[46] = "1_2_2_2_2"; //47
$linePatterns[47] = "1_2_2_2_3"; //48
$linePatterns[48] = "1_2_2_3_3"; //49
$linePatterns[49] = "1_2_2_3_4"; //50
$linePatterns[50] = "1_2_3_2_2"; //51
$linePatterns[51] = "1_2_3_2_3"; //52

$linePatterns[52] = "1_2_3_3_3"; //53
$linePatterns[53] = "1_2_3_3_4"; //54
$linePatterns[54] = "2_1_1_0_0"; //55
$linePatterns[55] = "2_1_1_0_1"; //56
$linePatterns[56] = "2_1_1_1_1"; //57
$linePatterns[57] = "2_1_1_1_2"; //58
$linePatterns[58] = "2_1_1_2_2"; //59
$linePatterns[59] = "2_1_1_2_3"; //60
$linePatterns[60] = "2_1_2_1_1"; //61
$linePatterns[61] = "2_1_2_1_2"; //62
$linePatterns[62] = "2_1_2_2_2"; //63
$linePatterns[63] = "2_1_2_2_3"; //64
$linePatterns[64] = "2_1_2_3_3"; //65

$linePatterns[65] = "2_1_2_3_4"; //66
$linePatterns[66] = "2_2_2_1_1"; //67
$linePatterns[67] = "2_2_2_1_2"; //68
$linePatterns[68] = "2_2_2_2_2"; //69
$linePatterns[69] = "2_2_2_2_3"; //70
$linePatterns[70] = "2_2_2_3_3"; //71
$linePatterns[71] = "2_2_2_3_4"; //72
$linePatterns[72] = "2_2_3_2_2"; //73
$linePatterns[73] = "2_2_3_2_3"; //74
$linePatterns[74] = "2_2_3_3_3"; //75
$linePatterns[75] = "2_2_3_3_4"; //76

/*
$linn=5;
$testS=explode("_",$linePatterns[($linn-1)]);
$symbols[0][$testS[0]]=8;
$symbols[1][$testS[1]]=8;
$symbols[2][$testS[2]]=8;
$symbols[3][$testS[3]]=8;
$symbols[4][$testS[4]]=8;
*/




for ($i = 0; $i < 76; $i++) {
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

/*
if($lastAction=='spin' and $total_win>0) 
    {
	$lastAction="trigger";
	$reelset="trigger";
    }
elseif($lastAction=='respin')
    {
	$total_winCents=0;$total_win=0;unset($win);
    }
*/
