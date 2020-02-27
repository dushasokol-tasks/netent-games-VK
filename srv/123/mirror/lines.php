<?
$newMirrorSym = 0;

if ($lastAction == "respin") {
	$temp = explode('_', $wildsDB);
	foreach ($temp as $e) if ($e != '') {
		$temp2 = explode(',', $e);
		$extrawildDB[$temp2[0]][$temp2[1]] = 1;
	}
	$wilds = '';

	$bnsSmbToOverlaySmb = round(rand(2, 10));
	if ($bnsSmbToOverlaySmb < 5) {
		$bnsSmbToOverlaySmb = $overlaySym;
		$symb_combs .= "chest=SO:" . $bnsSmbToOverlaySmb . ";";
	} elseif ($bnsSmbToOverlaySmb < 8) {
		$bnsSmbToOverlaySmb = 4;
		$symb_combs .= "chest=4;";
	} else {
		$bnsSmbToOverlaySmb = 5;
		$symb_combs .= "chest=5;";
	}

	for ($i = 0; $i < 3; $i++) {
		for ($j = 0; $j < 5; $j++) {
			if ($symbols[$j][$i] == '0') $symbols[$j][$i] = $bnsSmbToOverlaySmb;
		}
	}

	for ($i = 0; $i < 3; $i++) {
		for ($j = 0; $j < 5; $j++) {
			if ($extrawildDB[$j][$i] != 1 and $symbols[$j][$i] == $overlaySym)
				$newMirrorSym++;
		}
	}

	if ($newMirrorSym == 0) {
		$lastAction = "lastrespin";
	}

	for ($i = 0; $i < 3; $i++) {
		for ($j = 0; $j < 5; $j++) {
			if ($extrawildDB[$j][$i] == 1 or $symbols[$j][$i] == $overlaySym) {
				$wilds .= $j . ',' . $i . "_";
				$symbols[$j][$i] = $overlaySym;
			}
		}
	}
}

if ($lastAction != "symbol_transform")	$symbolsOverlayed = $symbols;

if ($lastAction == "mirror") {
	$overlaySym = round(rand(4, 5));
	$y = round(rand(0, 2));
	$symbolsOverlayed[2][$y] = 2;
	$symbols[2][$y] = 2;
}

if ($lastAction == "mirror2") {
	$overlaySym = round(rand(4, 5));
	$symbols[2][1] = 2;
	$symbolsOverlayed[2][1] = 2;
}

if ($lastAction == "mirrorFS") {
	$length = (count($reel[7]) - 1);
	$pos = round(rand(0, $length));
	$combs = explode(",", $reel[7][$pos]);
	$overlaySym = round(rand(4, 5));
	for ($i = 0; $i < 3; $i++) {
		//	echo "comb $i ".$reel[7][$pos]." <br>";
		if ($combs[$i] == 1) {
			$y = round(rand(0, 2));
			$symbolsOverlayed[$i][$y] = 2;
			$symbols[$i][$y] = 2;
		}
	}
}

for ($i = 0; $i < 5; $i++) {
	for ($j = 3; $j < 14; $j++) {
		$symbols_count[$i][$j] = 0;
		if ($symbols[$i][0] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][1] == $j) $symbols_count[$i][$j]++;
		if ($symbols[$i][2] == $j) $symbols_count[$i][$j]++;
	}
}

$syms[0] = $symbols[0][0];
if ($syms[0] != $symbols[0][1]) $syms[1] = $symbols[0][1];
elseif ($syms[0] != $symbols[0][2]) $syms[1] = $symbols[0][2];
if ($syms[1] != $symbols[0][2] and $symbols[0][0] != $symbols[0][2]) $syms[2] = $symbols[0][2];

$line = 0;
for ($i = 0; $i < count($syms); $i++) {
	for ($j = 3; $j < 14; $j++) {
		if ($syms[$i] == $j) {
			if ($symbols_count[0][$j] > 0 and $symbols_count[1][$j] > 0 and $symbols_count[2][$j] > 0 and $symbols_count[3][$j] > 0 and $symbols_count[4][$j] > 0) {
				for ($i0 = 0; $i0 < 3; $i0++)
					for ($i1 = 0; $i1 < 3; $i1++)
						for ($i2 = 0; $i2 < 3; $i2++)
							for ($i3 = 0; $i3 < 3; $i3++)
								for ($i4 = 0; $i4 < 3; $i4++) {
									if ($symbols[0][$i0] == $j and $symbols[1][$i1] == $j and $symbols[2][$i2] == $j and $symbols[3][$i3] == $j and $symbols[4][$i4] == $j) {
										$linewin[$line] = $lineWinMarix[5][$j] * $betDB;
										if ($linewin[$line] != 0) {
											$win[$line] = $linewin[$line] . "_0," . $i0 . ";1," . $i1 . ";2," . $i2 . ";3," . $i3 . ";4," . $i4;
											$logger['5xSYM' . $j . $line] = '5xSYM' . $j . "=" . $linewin[$line];
											$symbOverlays[$line] = $j;
										}
										$line++;
									}
								}
			} elseif ($symbols_count[0][$j] > 0 and $symbols_count[1][$j] > 0 and $symbols_count[2][$j] > 0 and $symbols_count[3][$j] > 0) {
				for ($i0 = 0; $i0 < 3; $i0++)
					for ($i1 = 0; $i1 < 3; $i1++)
						for ($i2 = 0; $i2 < 3; $i2++)
							for ($i3 = 0; $i3 < 3; $i3++) {
								if ($symbols[0][$i0] == $j and $symbols[1][$i1] == $j and $symbols[2][$i2] == $j and $symbols[3][$i3] == $j) {
									$linewin[$line] = $lineWinMarix[4][$j] * $betDB;
									if ($linewin[$line] != 0) {
										$win[$line] = $linewin[$line] . "_0," . $i0 . ";1," . $i1 . ";2," . $i2 . ";3," . $i3;
										$logger['4xSYM' . $j . $line] = '4xSYM' . $j . "=" . $linewin[$line];
										$symbOverlays[$line] = $j;
									}
									$line++;
								}
							}
			} elseif ($symbols_count[0][$j] > 0 and $symbols_count[1][$j] > 0 and $symbols_count[2][$j] > 0) {
				for ($i0 = 0; $i0 < 3; $i0++)
					for ($i1 = 0; $i1 < 3; $i1++)
						for ($i2 = 0; $i2 < 3; $i2++) {
							if ($symbols[0][$i0] == $j and $symbols[1][$i1] == $j and $symbols[2][$i2] == $j) {
								$linewin[$line] = $lineWinMarix[3][$j] * $betDB;
								if ($linewin[$line] != 0) {
									$win[$line] = $linewin[$line] . "_0," . $i0 . ";1," . $i1 . ";2," . $i2;
									$logger['3xSYM' . $j . $line] = '3xSYM' . $j . "=" . $linewin[$line];
									$symbOverlays[$line] = $j;
								}
								$line++;
							}
						}
			} elseif ($symbols_count[0][$j] > 0 and $symbols_count[1][$j] > 0) {
				for ($i0 = 0; $i0 < 3; $i0++)
					for ($i1 = 0; $i1 < 3; $i1++) {
						if ($symbols[0][$i0] == $j and $symbols[1][$i1] == $j) {
							$linewin[$line] = $lineWinMarix[2][$j] * $betDB;
							if ($linewin[$line] != 0) {
								$win[$line] = $linewin[$line] . "_0," . $i0 . ";1," . $i1;
								$logger['2xSYM' . $j . $line] = '2xSYM' . $j . "=" . $linewin[$line];
								$symbOverlays[$line] = $j;
							}
							$line++;
						}
					}
			}
		}
	}
}

if ($lastAction == "respin") {
	unset($win);
	$total_win = 0;
} else {
	foreach ($linewin as $v) {
		$total_win += $v;
	}
	if ($logger != '')
		foreach ($logger as $e => $v) $symb_combs .= $v . ";";
}

$total_winCents = $total_win * $denomDB;
