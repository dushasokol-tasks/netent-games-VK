<?

foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 1) $extrawild[$e][$e1] = 1;
	if ($lastAction == 'respin') if ($symbols[$e][$e1] == 0) {
		$smb = floor(rand(5, 9));
		$symbols[$e][$e1] = $smb;
		$symbolsOverlayed[$e][$e1] = $smb;
	}
}

$symbolsOverlayed = $symbols;

$pHaze = -1;

if ($symbols[0][0] == 1 or $symbols[0][1] == 1 or $symbols[0][2] == 1) {

	//    echo "!!!".$reel[7][0]."<br>";

	if (!isset($isPHaze))
		if (rand(0, 1000) < ($reel[7][0])) {
			$isPHaze = 1;
		} else $isPHaze = 0;

	//    $isPHaze=floor(rand(0,1));
	//$isPHaze=1;
	if ($isPHaze == 1) {
		if ($symbols[0][0] == 1) {
			$pHaze = 0;
		}
		if ($symbols[0][1] == 1) {
			$pHaze = 1;
		}
		if ($symbols[0][2] == 1) {
			$pHaze = 2;
		}
		$_Events['601'] = 1;
	}
}

if ($pHaze != -1 and $lastAction = "spin") $lastAction = "pHaze";


if ($lastAction == "pHaze") foreach ($symbols as $e => $v)  foreach ($v as $e1 => $v1) {
	if ($symbols[$e][$e1] == 10 or $symbols[$e][$e1] == 11 or $symbols[$e][$e1] == 12 or $symbols[$e][$e1] == 13 or $symbols[$e][$e1] == 14) {
		$extrawild[$e][$e1] = 1;
	}
	if ($symbols[$e][$e1] == 0) {
		$smb = floor(rand(5, 9));
		$symbols[$e][$e1] = $smb;
		$symbolsOverlayed[$e][$e1] = $smb;
	}
}

if ($fgType == "FS1") {

	if ($fs_left > 0) {
		$j = $fs_left;
		$k = $j - 1;
		if ($k < 0) $k = 0;
		if ($j < 0) $j = 0;
		if ($j > 4) $j = 4;
		for ($i = 0; $i < 3; $i++) {
			$symbolsOverlayed[$k][$i] = 1;
			$symbolsOverlayed[$j][$i] = 1;
			$extrawild[$j][$i] = 1;
			$extrawild[$k][$i] = 1;
		}
	} else {
		for ($i = 0; $i < 3; $i++) {
			$extrawild[0][$i] = 1;
		}
	}
}
if ($fgType == "FS2") {

	$reel[0] = $reel[6];
	$reel[1] = $reel[7];
	$reel[2] = $reel[8];


	for ($i = 0; $i < 3; $i++) {
		$length = (count($reel[$i]) - 1);
		$pos = round(rand(0, $length));

		$symbols[$i][0] = $reel[$i][$pos];
		if ($pos == $length) {
			$symbols[$i][1] = $reel[$i][0];
			$symbols[$i][2] = $reel[$i][1];
		} elseif ($pos == ($length - 1)) {
			$symbols[$i][1] = $reel[$i][$length];
			$symbols[$i][2] = $reel[$i][0];
		} else {
			$symbols[$i][1] = $reel[$i][$pos + 1];
			$symbols[$i][2] = $reel[$i][$pos + 2];
		}
	}
	$symbolsOverlayed[0] = $symbols[0];
	$symbolsOverlayed[1] = $symbols[1];
	$symbolsOverlayed[2] = $symbols[2];

	if ($fs_left > 0) {
		for ($i = 0; $i < 5; $i++)
			for ($j = 0; $j < 3; $j++) {
				if ($symbols[$i][$j] == 10 or $symbols[$i][$j] == 11 or $symbols[$i][$j] == 12 or $symbols[$i][$j] == 13 or $symbols[$i][$j] == 14) {
					$extrawild[$i][$j] = 1;
					$symbols[$i][$j] = 1;
				}
			}
	}
}

if ($fgType == "FS3") {

	$length = (count($reel[5]) - 1);
	$pos = round(rand(0, $length));

	$guitarchord = $reel[5][$pos];

	if ($guitarchord == "a") {
		$symbols[1][1] = 1;
		$symbols[2][1] = 1;
		$symbols[3][1] = 1;
		$extrawild[1][1] = 1;
		$extrawild[2][1] = 1;
		$extrawild[3][1] = 1;
	}
	if ($guitarchord == "e") {
		$symbols[0][1] = 1;
		$symbols[1][1] = 1;
		$symbols[2][0] = 1;
		$extrawild[0][1] = 1;
		$extrawild[1][1] = 1;
		$extrawild[2][1] = 1;
	}
	if ($guitarchord == "e7") {
		$symbols[0][1] = 1;
		$symbols[1][0] = 1;
		$symbols[2][1] = 1;
		$symbols[3][2] = 1;
		$extrawild[0][1] = 1;
		$extrawild[1][0] = 1;
		$extrawild[2][1] = 1;
		$extrawild[3][2] = 1;
	}
	if ($guitarchord == "c") {
		$symbols[1][2] = 1;
		$symbols[2][1] = 1;
		$symbols[4][0] = 1;
		$extrawild[1][2] = 1;
		$extrawild[2][1] = 1;
		$extrawild[4][0] = 1;
	}
	if ($guitarchord == "ds") {
		$symbols[0][0] = 1;
		$symbols[2][0] = 1;
		$symbols[3][1] = 1;
		$symbols[4][0] = 1;
		$extrawild[0][0] = 1;
		$extrawild[2][0] = 1;
		$extrawild[3][1] = 1;
		$extrawild[4][0] = 1;
	}
	if ($guitarchord == "d") {
		$symbols[2][0] = 1;
		$symbols[3][1] = 1;
		$symbols[4][0] = 1;
		$extrawild[2][0] = 1;
		$extrawild[3][1] = 1;
		$extrawild[4][0] = 1;
	}
	if ($guitarchord == "powerchord") {
		$symbols[0][0] = 1;
		$symbols[1][2] = 1;
		$symbols[2][2] = 1;
		$symbols[3][1] = 1;
		$symbols[4][0] = 1;
		$extrawild[0][0] = 1;
		$extrawild[1][2] = 1;
		$extrawild[2][2] = 1;
		$extrawild[3][1] = 1;
		$extrawild[4][0] = 1;
	}
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


/*
$linn=1;

$testS=explode("_",$linePatterns[($linn-1)]);

$symbols[0][$testS[0]]=9;
$symbols[1][$testS[1]]=9;
$symbols[2][$testS[2]]=9;
$symbols[3][$testS[3]]=9;
$symbols[4][$testS[4]]=9;
*/


for ($i = 0; $i < 20; $i++) {
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
	if ($symbs[$i] == 0) $symbs[$i] = 1;

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



	if ($logger != '') $symb_combs .= $logger . ";";
}


foreach ($linewin as $v) {
	$total_win += $v;
}

$total_winCents = $total_win * $denomDB;
