<?
$newMirrorSym = 0;
$symbolsOverlayed = $symbols;

if ($lastAction != 'freespin') {
	if ($wavecount == 0) {
		$symbols[0][0] = 15;
		$symbols[0][1] = 15;
		$symbols[0][3] = 15;
		$symbols[0][4] = 15;
		$symbols[1][0] = 15;
		$symbols[1][4] = 15;
		$symbols[3][0] = 15;
		$symbols[3][4] = 15;
		$symbols[4][0] = 15;
		$symbols[4][1] = 15;
		$symbols[4][3] = 15;
		$symbols[4][4] = 15;
	} elseif ($wavecount == 1) {
		$symbols[0][0] = 15;
		$symbols[0][4] = 15;
		$symbols[1][0] = 15;
		$symbols[1][4] = 15;
		$symbols[3][0] = 15;
		$symbols[3][4] = 15;
		$symbols[4][0] = 15;
		$symbols[4][1] = 15;
		$symbols[4][3] = 15;
		$symbols[4][4] = 15;
	} elseif ($wavecount == 2) {
		$symbols[0][0] = 15;
		$symbols[0][4] = 15;
		$symbols[1][0] = 15;
		$symbols[1][4] = 15;
		$symbols[3][0] = 15;
		$symbols[3][4] = 15;
		$symbols[4][0] = 15;
		$symbols[4][4] = 15;
	} elseif ($wavecount == 3) {
		$symbols[0][0] = 15;
		$symbols[0][4] = 15;
		$symbols[3][0] = 15;
		$symbols[3][4] = 15;
		$symbols[4][0] = 15;
		$symbols[4][4] = 15;
	} elseif ($wavecount == 4) {
		$symbols[0][0] = 15;
		$symbols[0][4] = 15;
		$symbols[4][0] = 15;
		$symbols[4][4] = 15;
	} elseif ($wavecount == 5) {
		$symbols[0][0] = 15;
		$symbols[0][4] = 15;
		$symbols[4][0] = 15;
		$symbols[4][4] = 15;
	} elseif ($wavecount == 6) {
		$symbols[4][0] = 15;
		$symbols[4][4] = 15;
	}
}

for ($i = 0; $i < 5; $i++) {
	for ($j = 1; $j < 14; $j++) {
		$symbols_count[$i][$j] = 0;
		if ($symbols[$i][0] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][1] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][2] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][3] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][4] == $j) $symbols_count[$i][$j]++;
	}
}

foreach ($symbols[0] as $e => $v) {
	if ($v != 15) {
		$tempSyms[$v] = 1;
	}
}
$i = 0;
foreach ($tempSyms as $e => $v) {
	$syms[$i] = $e;
	$i++;
}

$d0 = 0;
$d1 = 0;
$d2 = 0;
$d3 = 0;
$d4 = 0;
if ($wavecount == 1) {
	$d0 = 1;
	$reelset = "basic1";
}
if ($wavecount == 2) {
	$d0 = 1;
	$d4 = 1;
	$reelset = "basic2";
}
if ($wavecount == 3) {
	$d0 = 1;
	$d1 = 1;
	$d4 = 1;
	$reelset = "basic3";
}
if ($wavecount == 4) {
	$d0 = 1;
	$d1 = 1;
	$d3 = 1;
	$d4 = 1;
	$reelset = "basic4";
}
if ($wavecount == 5) {
	$d0 = 2;
	$d1 = 1;
	$d3 = 1;
	$d4 = 1;
	$reelset = "basic5";
}
if ($wavecount == 6) {
	$d0 = 2;
	$d1 = 1;
	$d3 = 1;
	$d4 = 2;
}

$line = 0;
for ($i = 0; $i < count($syms); $i++) {
	for ($j = 3; $j < 14; $j++) {
		if ($syms[$i] == $j) {
			if ($symbols_count[0][$j] > 0 and ($symbols_count[1][$j] > 0 or $symbols_count[1][1] > 0) and ($symbols_count[2][$j] > 0 or $symbols_count[2][1] > 0) and ($symbols_count[3][$j] > 0 or $symbols_count[3][1] > 0) and ($symbols_count[4][$j] > 0 or $symbols_count[4][1] > 0)) {
				for ($i0 = 0; $i0 < 5; $i0++)
					for ($i1 = 0; $i1 < 5; $i1++)
						for ($i2 = 0; $i2 < 5; $i2++)
							for ($i3 = 0; $i3 < 5; $i3++)
								for ($i4 = 0; $i4 < 5; $i4++) {
									if ($symbols[0][$i0] == $j and ($symbols[1][$i1] == $j or $symbols[1][$i1] == 1) and ($symbols[2][$i2] == $j or $symbols[2][$i2] == 1) and ($symbols[3][$i3] == $j or $symbols[3][$i3] == 1) and ($symbols[4][$i4] == $j or $symbols[4][$i4] == 1)) {
										$linewin[$line] = $lineWinMarix[5][$j] * $betDB;
										if ($linewin[$line] != 0) {
											$win[$line] = $linewin[$line] . "_0," . ($i0 - 2 + $d0) . ";1," . ($i1 - 1 + $d1) . ";2," . ($i2 + $d2) . ";3," . ($i3 - 1 + $d3) . ";4," . ($i4 - 2 + $d4);
											$logger['5xSYM' . $j . $line] = '5xSYM' . $j . "=" . $linewin[$line];
											$symbOverlays[$line] = $j;
										}
										$line++;
									}
								}
			} elseif ($symbols_count[0][$j] > 0 and ($symbols_count[1][$j] > 0 or $symbols_count[1][1] > 0) and ($symbols_count[2][$j] > 0 or $symbols_count[2][1] > 0) and ($symbols_count[3][$j] > 0 or $symbols_count[3][1] > 0)) {
				for ($i0 = 0; $i0 < 5; $i0++)
					for ($i1 = 0; $i1 < 5; $i1++)
						for ($i2 = 0; $i2 < 5; $i2++)
							for ($i3 = 0; $i3 < 5; $i3++) {
								if ($symbols[0][$i0] == $j and ($symbols[1][$i1] == $j or $symbols[1][$i1] == 1) and ($symbols[2][$i2] == $j or $symbols[2][$i2] == 1) and ($symbols[3][$i3] == $j or $symbols[3][$i3] == 1)) {
									$linewin[$line] = $lineWinMarix[4][$j] * $betDB;
									if ($linewin[$line] != 0) {
										$win[$line] = $linewin[$line] . "_0," . ($i0 - 2 + $d0) . ";1," . ($i1 - 1 + $d1) . ";2," . $i2 . ";3," . ($i3 - 1 + $d3);
										$logger['4xSYM' . $j . $line] = '4xSYM' . $j . "=" . $linewin[$line];
										$symbOverlays[$line] = $j;
									}
									$line++;
								}
							}
			} elseif ($symbols_count[0][$j] > 0 and ($symbols_count[1][$j] > 0 or $symbols_count[1][1] > 0) and ($symbols_count[2][$j] > 0 or $symbols_count[2][1] > 0)) {
				for ($i0 = 0; $i0 < 5; $i0++)
					for ($i1 = 0; $i1 < 5; $i1++)
						for ($i2 = 0; $i2 < 5; $i2++) {
							if ($symbols[0][$i0] == $j and ($symbols[1][$i1] == $j or $symbols[1][$i1] == 1) and ($symbols[2][$i2] == $j or $symbols[2][$i2] == 1)) {
								$linewin[$line] = $lineWinMarix[3][$j] * $betDB;
								if ($linewin[$line] != 0) {
									$win[$line] = $linewin[$line] . "_0," . ($i0 - 2 + $d0) . ";1," . ($i1 - 1 + $d1) . ";2," . $i2;
									$logger['3xSYM' . $j . $line] = '3xSYM' . $j . "=" . $linewin[$line];
									$symbOverlays[$line] = $j;
								}
								$line++;
							}
						}
			}
		}
	}
}
foreach ($linewin as $v) {
	$total_win += $v;
}
if ($logger != '')
	foreach ($logger as $e => $v) $symb_combs .= $v . ";";

if ($lastAction == "respin" or $lastAction == "spin") {
	if ($lastAction == "spin") {
		if ($total_win != 0) {
			$lastAction = "respin";
			$wavecount = 1;
			$reelset = "basic";
		} else $wavecount = 0;
	} elseif ($lastAction == "respin") {
		if ($total_win != 0) {
			$lastAction = "respin";
			$wavecount++;
			if ($wavecount == 6) {
				$lastAction = "initfreespin";
			}
		} else {
			$lastAction = "lastrespin";
			$wavecount = 0;
		}
	}
}

$total_winCents = $total_win * $denomDB;
