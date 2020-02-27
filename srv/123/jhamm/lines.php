<?
//$extrawild[0][1]=1;//	$extrawild[2][1]=1;	$extrawild[4][1]=1;	$extrawild[3][1]=1; $extrawild[1][1]=1;
//$extrawild[4][1]=1;
//$symbols[0][1]=0;	$symbols[1][1]=0;	$symbols[2][1]=0;	$symbols[3][1]=0;	$symbols[4][1]=0;

if ($wildsDB != "") $oldSymbs = explode("_", $wildsDB);

$remap = 0;
for ($i = 0; $i < 5; $i++)
	for ($j = 0; $j < 3; $j++) {
		$lines_to_write[$i][$j] = "-1";
		$symbsRemap[$i][$j] = $remap;

		if ($oldSymbs[$remap] != "-1" and $wildsDB != "") {
			$symbols[$i][$j] = $oldSymbs[$remap];
			$symbolsOverlayed[$i][$j] = $oldSymbs[$remap];
			$oldSymbols[$i][$j] = $oldSymbs[$remap];
		}

		$remap++;
	}

$fsSymbsCount = 0;
foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
	if ($symbols[$e][$e1] == 0) $fsSymbsCount++;
}
if ($fsSymbsCount > 2) foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 0) {
		$lines_to_write[$e][$e1] = "1";
	}
}

//if($lastAction=="freespin") foreach($lineWinMarix as $setNum => $set) {foreach($set as $elemNum => $element) echo $element.",";echo "<br>";}
if ($lastAction == "freespin") foreach ($lineWinMarix as $setNum => $set) {
	foreach ($set as $elemNum => $element) $lineWinMarix[$setNum][$elemNum] *= 3;
}
//if($lastAction=="freespin") foreach($lineWinMarix as $setNum => $set) {foreach($set as $elemNum => $element) echo $element.",";echo "<br>";}

//echo $lastAction."<br>";

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
$linePatterns[17] = "2_0_1_2_0"; //18
$linePatterns[18] = "1_0_2_1_2"; //19
$linePatterns[19] = "0_2_0_2_0"; //20
$linePatterns[20] = "2_0_2_0_2"; //21
$linePatterns[21] = "0_2_2_2_0"; //22
$linePatterns[22] = "2_0_0_0_2"; //23
$linePatterns[23] = "0_0_2_0_0"; //24
$linePatterns[24] = "2_2_0_2_2"; //25

/*
$linn=25;

$testS=explode("_",$linePatterns[($linn-1)]);

$symbols[0][$testS[0]]=9;
$symbols[1][$testS[1]]=9;
$symbols[2][$testS[2]]=9;
$symbols[3][$testS[3]]=9;
$symbols[4][$testS[4]]=9;
*/

//$output.= "<br><br>";

for ($i = 0; $i < 25; $i++)
//for($i=0;$i<1;$i++)
{
	$logger = '';
	$linePattern = explode("_", $linePatterns[$i]);
	$is_wild = "";
	$symbs[$i] = 0;
	if ($extrawild[0][1] == 1) $is_wild = "_1";
	elseif ($symbs[0] == 0) $symbs[0] = $symbols[0][1];

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

			if ($symbols[2][$linePattern[2]] == $symbs[$i] or $extrawild[2][$linePattern[2]] == 1) {
				$linewin[$i] = 0;
				$linewin[$i] = $lineWinMarix[3][$symbs[$i]] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_" . $symbsRemap[0][$linePattern[0]] . ",0;" . $symbsRemap[1][$linePattern[1]] . ",0;" . $symbsRemap[2][$linePattern[2]] . ",0";
					$logger = '3xSYM' . $symbs[$i] . "=" . $linewin[$i];
					$lines_to_write[0][$linePattern[0]] = "1";
					$lines_to_write[1][$linePattern[1]] = "1";
					$lines_to_write[2][$linePattern[2]] = "1";
				}

				if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_" . $symbsRemap[0][$linePattern[0]] . ",0;" . $symbsRemap[1][$linePattern[1]] . ",0;" . $symbsRemap[2][$linePattern[2]] . ",0;" . $symbsRemap[3][$linePattern[3]] . ",0";
						$logger = '4xSYM' . $symbs[$i] . "=" . $linewin[$i];
						$lines_to_write[0][$linePattern[0]] = "1";
						$lines_to_write[1][$linePattern[1]] = "1";
						$lines_to_write[2][$linePattern[2]] = "1";
						$lines_to_write[3][$linePattern[3]] = "1";
					}

					if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_" . $symbsRemap[0][$linePattern[0]] . ",0;" . $symbsRemap[1][$linePattern[1]] . ",0;" . $symbsRemap[2][$linePattern[2]] . ",0;" . $symbsRemap[3][$linePattern[3]] . ",0;" . $symbsRemap[4][$linePattern[4]] . ",0";
							$logger = '5xSYM' . $symbs[$i] . "=" . $linewin[$i];
							$lines_to_write[0][$linePattern[0]] = "1";
							$lines_to_write[1][$linePattern[1]] = "1";
							$lines_to_write[2][$linePattern[2]] = "1";
							$lines_to_write[3][$linePattern[3]] = "1";
							$lines_to_write[4][$linePattern[4]] = "1";
						}
					}
				}

				$win[$i] .= $is_wild;
			}
		}
	}
	if ($logger != '')	$symb_combs .= $logger . ";";
	/*
if($logger!='')
    {

	$t=explode('x',$logger);

	if($is_wild=='')
		{
		    if($lastActionDB=="freespin")
		    {
			$t2=explode('_',$win[$i]);
			$symb_combs.=$t[0]."BNSxSYM".$symbs[$i]."=".($linewin[$i]*2).";";
			$win[$i]=($t2[0]*2)."_".$t2[1];
			$linewin[$i]*=2;
		    }
		    else 
		    {
			$symb_combs.=$logger.";";
//			$symb_combs.="!".$linewin[$i]."!";
		    }
		}
	else

		{
		    $t2=explode('_',$win[$i]);
		    if($lastActionDB=="freespin")
		    {
			$symb_combs.=$t[0]."BNSWLDxSYM".$symbs[$i]."=".($linewin[$i]*4).";";
			$win[$i]=($t2[0]*4)."_".$t2[1]."_1;";
			$linewin[$i]*=4;
		    }
		    else
		    {
			$symb_combs.=$t[0]."WILDxSYM".$symbs[$i]."=".($linewin[$i]*2).";";
			$win[$i]=($t2[0]*2)."_".$t2[1]."_1;";
			$linewin[$i]*=2;
		    }
		}
    }
*/
}

//$symb_combs.=" fs=".$fs_by_line;

foreach ($linewin as $v) {
	$total_win += $v;
}



$total_winCents = $total_win * $denomDB;

$full_reel = 1;
for ($i = 0; $i < 5; $i++)
	for ($j = 0; $j < 3; $j++)

		if ($lines_to_write[$i][$j] == "1") {
			$wilds .= $symbols[$i][$j] . "_";
			if ($symbols[$i][$j] != $oldSymbols[$i][$j]) $saveToNewSpin = 1;
			$holdSymbs[$i][$j] = "1";
		} else {
			$wilds .= "-1_";
			$full_reel = 0;
		}



if ($full_reel == 1) {
	$wilds = "";
	for ($i = 0; $i < 5; $i++) for ($j = 0; $j < 3; $j++) $holdSymbs[$i][$j] = "0";
} else {
	if ($saveToNewSpin == 0) {
		$wilds = "";
		for ($i = 0; $i < 5; $i++) for ($j = 0; $j < 3; $j++) $holdSymbs[$i][$j] = "0";
	} else {
		$lastAction = "respin";
		$total_win = 0;
		unset($win);
	}
}

$symb_combs .= " tw=" . $total_win;
