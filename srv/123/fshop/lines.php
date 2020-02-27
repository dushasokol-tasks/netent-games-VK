<?

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
}

//$extrawild[0][1]=1;//	$extrawild[2][1]=1;	$extrawild[4][1]=1;	$extrawild[3][1]=1; $extrawild[1][1]=1;
//$extrawild[4][1]=1;
//$symbols[0][1]=3;	$symbols[1][1]=3;	$symbols[2][1]=3;	$symbols[3][1]=3;	$symbols[4][1]=5;

//$symbols[0][0]=4;	$symbols[1][0]=4; $symbols[2][0]=4;


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

//$output.= "<br><br>";

$fs_by_line = 0;

for ($i = 0; $i < 15; $i++) {
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
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = '3xSYM' . $symbs[$i] . "=" . $linewin[$i];
				}

				if ($symbols[3][$linePattern[3]] == $symbs[$i] or $extrawild[3][$linePattern[3]] == 1) {
					$linewin[$i] = 0;
					$linewin[$i] = $lineWinMarix[4][$symbs[$i]] * $betDB;
					if ($linewin[$i] != 0) {
						$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
						$logger = '4xSYM' . $symbs[$i] . "=" . $linewin[$i];
					}

					if ($symbols[4][$linePattern[4]] == $symbs[$i] or $extrawild[4][$linePattern[4]] == 1) {
						$linewin[$i] = 0;
						$linewin[$i] = $lineWinMarix[5][$symbs[$i]] * $betDB;
						if ($linewin[$i] != 0) {
							$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
							$logger = '5xSYM' . $symbs[$i] . "=" . $linewin[$i];
						}
					}
				}

				$win[$i] .= $is_wild;
			}
		}
	}

	if ($logger != '') {

		$t = explode('x', $logger);
		if ($is_wild == '') {
			if ($lastActionDB == "freespin") {
				$t2 = explode('_', $win[$i]);
				$symb_combs .= $t[0] . "BNSxSYM" . $symbs[$i] . "=" . ($linewin[$i] * 2) . ";";
				$win[$i] = ($t2[0] * 2) . "_" . $t2[1];
				$linewin[$i] *= 2;
			} else {
				$symb_combs .= $logger . ";";
				//			$symb_combs.="!".$linewin[$i]."!";
			}
		} else {
			$t2 = explode('_', $win[$i]);
			if ($lastActionDB == "freespin") {
				$symb_combs .= $t[0] . "BNSWLDxSYM" . $symbs[$i] . "=" . ($linewin[$i] * 4) . ";";
				$win[$i] = ($t2[0] * 4) . "_" . $t2[1] . "_1;";
				$linewin[$i] *= 4;
			} else {
				$symb_combs .= $t[0] . "WILDxSYM" . $symbs[$i] . "=" . ($linewin[$i] * 2) . ";";
				$win[$i] = ($t2[0] * 2) . "_" . $t2[1] . "_1;";
				$linewin[$i] *= 2;
			}
		}

		if ($symbs[$i] == 3) {
			if ($t[0] == 2) $fs_by_line += 1;
		}

		if ($symbs[$i] == 3 or $symbs[$i] == 4 or $symbs[$i] == 5 or $symbs[$i] == 6 or $symbs[$i] == 7) {
			if ($t[0] == 3) $fs_by_line += 1;
			if ($t[0] == 4) $fs_by_line += 2;
			if ($t[0] == 5) $fs_by_line += 5;
		}
		if ($lastActionDB == "freespin")
			if ($symbs[$i] == 8 or $symbs[$i] == 9 or $symbs[$i] == 10 or $symbs[$i] == 11 or $symbs[$i] == 12) {
				if ($t[0] == 3) $fs_by_line += 1;
				if ($t[0] == 4) $fs_by_line += 2;
				if ($t[0] == 5) $fs_by_line += 5;
			}
	}
}

$symb_combs .= " fs=" . $fs_by_line;

foreach ($linewin as $v) {
	$total_win += $v;
}

$symb_combs .= " tw=" . $total_win;

$total_winCents = $total_win * $denomDB;
