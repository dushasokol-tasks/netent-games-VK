<?

$reelset = "basic";

//line matches

$symbolsOverlayed = $symbols; {
	$length = (count($reel[5]) - 1);
	$pos = round(rand(0, $length));
	if ($buster8 == '')     $wildsCount = $reel[5][$pos];

	//echo  $wildsCount;

	$symb_combs .= "wilds=" . $wildsCount . ";";

	for ($i = 0; $i < $wildsCount; $i++) {
		$reelForWild = 4;
		if (rand(0, 1000) < $reel[6][0])    	$reelForWild = 0;
		elseif (rand(0, 1000) < $reel[6][1])    	$reelForWild = 1;
		elseif (rand(0, 1000) < $reel[6][2])    	$reelForWild = 2;
		elseif (rand(0, 1000) < $reel[6][3])    	$reelForWild = 3;

		$y = round(rand(0, 2));
		if ($extrawild[$reelForWild][$y] != 1) {
			$symbols[$reelForWild][$y] = 1;
			$extrawild[$reelForWild][$y] = 1;
			$symb_combs .= " #" . $reelForWild . "," . $y . ";";
		} elseif ($extrawild[$reelForWild][2] != 1) {
			$symbols[$reelForWild][2] = 1;
			$extrawild[$reelForWild][2] = 1;
			$symb_combs .= " #" . $reelForWild . ",2;";
		} elseif ($extrawild[$reelForWild][1] != 1) {
			$symbols[$reelForWild][1] = 1;
			$extrawild[$reelForWild][1] = 1;
			$symb_combs .= " #" . $reelForWild . ",1;";
		} elseif ($extrawild[$reelForWild][0] != 1) {
			$symbols[$reelForWild][0] = 1;
			$extrawild[$reelForWild][0] = 1;
			$symb_combs .= " #" . $reelForWild . ",0;";
		}
	}
}

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
}

$linePatterns[0] = "1_1_1_1_1"; //1
$linePatterns[1] = "0_0_0_0_0"; //2
$linePatterns[2] = "2_2_2_2_2"; //3
$linePatterns[3] = "0_1_2_1_0"; //4
$linePatterns[4] = "2_1_0_1_2"; //5
$linePatterns[5] = "0_0_1_0_0"; //6
$linePatterns[6] = "2_2_1_2_2"; //7
$linePatterns[7] = "1_2_2_2_1"; //8
$linePatterns[8] = "1_0_0_0_1"; //9

for ($i = 0; $i < 9; $i++) {
	$logger = '';
	$oldwin = 0;
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


	if ($symbols[0][$linePattern[0]] == 1 and $symbols[1][$linePattern[1]] == 1 and $symbols[2][$linePattern[2]] == 1) {

		if ($symbols[3][$linePattern[3]] == 1 and $symbols[4][$linePattern[4]] == 1) { {
				$linewin[$i] = $lineWinMarix[5][3] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3] . ";4," . $linePattern[4];
					$logger = "5xWLD=" . $linewin[$i];
				}
				$symbOverlays[$i] = 1;
			}
		} elseif ($symbols[3][$linePattern[3]] == 1) { {
				$linewin[$i] = $lineWinMarix[4][3] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2] . ";3," . $linePattern[3];
					$logger = "4xWLD=" . $linewin[$i];
				}
				$symbOverlays[$i] = 1;
			}
		} else { {
				$linewin[$i] = $lineWinMarix[3][3] * $betDB;
				if ($linewin[$i] != 0) {
					$win[$i] = $linewin[$i] . "_0," . $linePattern[0] . ";1," . $linePattern[1] . ";2," . $linePattern[2];
					$logger = "3xWLD=" . $linewin[$i];
				}
				$symbOverlays[$i] = 1;
			}
		}
	}


	if ($logger != '') $symb_combs .= $logger . ";";
}

foreach ($linewin as $v) {
	$total_win += $v;
}

$total_winCents = $total_win * $denomDB;
