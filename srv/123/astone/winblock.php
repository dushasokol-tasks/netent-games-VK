<?

//	hasColossal: 0 - no colossal, -1 - already explosed colossal in this drop, 1 - colossal anwhere exept -1 floor, 2 - in -1 floor in 'drop1'

///$lastSy='';$explode_colossal=0;$dropColossal=0;$isNotDrop=0;



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

for ($i = 0; $i < 20; $i++) {
	$logger = '';
	$linePattern = explode("_", $linePatterns[$i]);
	$is_wild = "";
	$symbs[$i] = 0;

	for ($j = 0; $j < 5; $j++) {
		if ($extrawild[$j][$linePattern[$j]] == 1) $is_wild = "_1";
		elseif ($symbs[$i] == 0) $symbs[$i] = $symbols[$j][$linePattern[$j]];
		if ($symbs[$i] == 12) continue 2;
	}
	if ($symbs[$i] == 0) $symbs[$i] = 3;
	$symbOverlays[$i] = 3;


	if ($symbols[0][$linePattern[0]] == $symbs[$i] or $extrawild[0][$linePattern[0]] == 1) {
		if ($symbols[1][$linePattern[1]] == $symbs[$i] or $extrawild[1][$linePattern[1]] == 1) {
			$linewin[$i] = 0;
			$linewin[$i] = $lineWinMarix[2][$symbs[$i]] * $betDB * $crushMul;
			if ($linewin[$i] != 0) {
				$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1];
				$logger = '2xSYM' . $symbs[$i] . "=" . $linewin[$i];
			}
			if ($extrawild[1][$linePattern[1]] != 1) $symbOverlays[$i] = $symbols[1][$linePattern[1]];


			if ($symbols[2][$linePattern[2]] == $symbs[$i] or $extrawild[2][$linePattern[2]] == 1) {
				$linewin[$i] = 0;
				$linewin[$i] = $lineWinMarix[3][$symbs[$i]] * $betDB * $crushMul;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = '3xSYM' . $symbs[$i] . "=" . $linewin[$i];
				}
				if ($extrawild[2][$linePattern[2]] != 1) $symbOverlays[$i] = $symbols[2][$linePattern[2]];
				$symbolsShifted[0][$linePattern[0]] = 0;
				$symbolsShifted[1][$linePattern[1]] = 0;
				$symbolsShifted[2][$linePattern[2]] = 0;
				if ($colossal[0][$linePattern[0]] == 1) {
					$explode_colossal = 1;
					$colossal[0][$linePattern[0]] = 2;
				}
				if ($colossal[1][$linePattern[1]] == 1) {
					$explode_colossal = 1;
					$colossal[1][$linePattern[1]] = 2;
				}
				if ($colossal[2][$linePattern[2]] == 1) {
					$explode_colossal = 1;
					$colossal[2][$linePattern[2]] = 2;
				}

				if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB * $crushMul;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
						$logger = '4xSYM' . $symbs[$i] . "=" . $linewin[$i];
					}
					if ($extrawild[3][$linePattern[3]] != 1) $symbOverlays[$i] = $symbols[3][$linePattern[3]];
					$symbolsShifted[3][$linePattern[3]] = 0;
					if ($colossal[3][$linePattern[3]] == 1) {
						$explode_colossal = 1;
						$colossal[3][$linePattern[3]] = 2;
					}

					if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB * $crushMul;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
							$logger = '5xSYM' . $symbs[$i] . "=" . $linewin[$i];
						}
						if ($extrawild[4][$linePattern[4]] != 1) $symbOverlays[$i] = $symbols[4][$linePattern[4]];
						$symbolsShifted[4][$linePattern[4]] = 0;
						if ($colossal[4][$linePattern[4]] == 1) {
							$explode_colossal = 1;
							$colossal[4][$linePattern[4]] = 2;
						}
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

$symsShiftedDB = '';

if ($symb_combs != '') $symb_combs = "crushMul=" . $crushMul . ";" . $symb_combs;

if ($colossalSym != 1) {
	for ($i = 0; $i < 5; $i++)
		for ($j = 0; $j < 3; $j++)
			if ($colossal[$i][$j] == 2) $colossal[$i][$j] = 1;
} elseif ($colossalSym == 1) {
	for ($i = 0; $i < 5; $i++)
		for ($j = 0; $j < 3; $j++)
			if ($colossal[$i][$j] == 2) $colossal[$i][$j] = 1;
			elseif ($colossal[$i][$j] == 1) $colossal[$i][$j] = 2;
}
