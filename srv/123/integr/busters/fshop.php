<?
if ($_Social['activeBuster'] != '') {
	$busterActive = explode(":", $_Social['activeBuster']);
	if ($busterActive[0] != '' and $busterActive[0] != 0 and $busterActive[1] != '' and $busterActive[1] != 0) {
		if ($busterActive[1] > 0 and ($busterActive[0] == 6 or $busterActive[0] == 7 or $busterActive[0] == 8 or
			$busterActive[0] == 10 or $busterActive[0] == 11 or $busterActive[0] == 12)) {
			if ($busterActive[0] == 6) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					if ($bonusSymbCount > 0) {
						foreach ($symbols as $tReel => $t)
							foreach ($t as $tRow => $e) {
								if ($symbols[$tReel][$tRow] == 0) {
									$symbols[$tReel][$tRow] = round(rand(3, 10));
								}
							}
						$bonusSymbCount = 0;
					}
					$pos = round(rand(0, 11));
					$temp[0] = 3;
					$temp[1] = 4;
					$temp[2] = 5;
					$temp[3] = 6;
					$temp[4] = 7;
					$temp[5] = 6;
					$temp[6] = 3;
					$temp[7] = 4;
					$temp[8] = 5;
					$temp[9] = 6;
					$temp[10] = 7;
					$temp[11] = 7;
					for ($j = 0; $j < 3; $j++) {
						$symbols[0][$j] = $temp[$pos];
						$symbols[2][$j] = $temp[$pos];
						$symbols[4][$j] = $temp[$pos];
					}
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					if ($bonusSymbCount > 0) {
						foreach ($symbols as $tReel => $t)
							foreach ($t as $tRow => $e) {
								if ($symbols[$tReel][$tRow] == 0) {
									$symbols[$tReel][$tRow] = round(rand(3, 10));
								}
							}
						$bonusSymbCount = 0;
					}
					$pos = round(rand(0, 11));
					$temp[0] = 7;
					$temp[1] = 4;
					$temp[2] = 5;
					$temp[3] = 6;
					$temp[4] = 7;
					$temp[5] = 4;
					$temp[6] = 6;
					$temp[7] = 4;
					$temp[8] = 5;
					$temp[9] = 6;
					$temp[10] = 7;
					$temp[11] = 5; {
						$symbols[0][0] = $temp[$pos];
						$symbols[1][0] = $temp[$pos];
						$symbols[2][0] = $temp[$pos];
						$symbols[1][1] = $temp[$pos];
						$symbols[3][1] = $temp[$pos];
						$symbols[0][2] = $temp[$pos];
						$symbols[1][2] = $temp[$pos];
						$symbols[2][2] = $temp[$pos];
					}
				}
			}

			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;

					$temp = round(rand(4, 7));
					$temp2 = round(rand(0, 2));
					for ($i = 0; $i < 5; $i++) {
						$symbols[$i][$temp2] = $temp;
					}
				}
			}

			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					$buster10 = 'ok';
				}
			}



			if ($busterActive[0] == 11) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 8 or $symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 10 or $symbols[$tReel][$tRow] == 11 or $symbols[$tReel][$tRow] == 12) {
								$symbols[$tReel][$tRow] = round(rand(4, 7));
							}
						}
					$busterActive[1]--;
				}
			}

			if ($busterActive[0] == 12) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
				}
				$buster12 = 'ok';
			}


			if ($busterActive[1] > 0 and $_Social['activeBuster'] != '') {
				$_Social['activeBuster'] = $busterActive[0] . ":" . $busterActive[1];
			} else $_Social['activeBuster'] = '';
		}
	} else $_Social['activeBuster'] = '';
}
