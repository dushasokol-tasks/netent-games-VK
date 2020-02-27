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
					$temp[0] = 1;
					$temp[1] = 4;
					$temp[2] = 5;
					$temp[3] = 3;
					$temp[4] = 4;
					$temp[5] = 1;
					$temp[6] = 1;
					$temp[7] = 4;
					$temp[8] = 5;
					$temp[9] = 3;
					$temp[10] = 5;
					$temp[11] = 1;
					for ($j = 0; $j < 3; $j++) {
						$symbols[0][$j] = $temp[$pos];
						$symbols[2][$j] = $temp[$pos];
						$symbols[4][$j] = $temp[$pos];
					}
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 10));
							}
						}
					$symbols[0][1] = 0;
					$symbols[2][1] = 0;
					$symbols[4][1] = 0;
					$bonusSymbCount = 3;
					$buster7 = 'ok';
				} elseif ($_GET['action'] == "initfreespin") {
					$buster7 = 'ok';
					$busterActive[1]--;
				}
			}

			if ($busterActive[0] == 8) {
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

					$temp = round(rand(3, 5));
					$symbols[0][0] = $temp;
					$symbols[0][1] = $temp;
					$symbols[0][2] = $temp;
					for ($i = 1; $i < 5; $i++) {
						$temp = round(rand(3, 5));
						$temp2 = round(rand(0, 2));
						$symbols[$i][$temp2] = $temp;
						$temp = round(rand(3, 5));
						$temp2 = round(rand(0, 2));
						$symbols[$i][$temp2] = $temp;
					}
				}
			}

			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$buster10 = 'ok';
					$busterActive[1]--;
				}
			}



			if ($busterActive[0] == 11) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 10 or $symbols[$tReel][$tRow] == 11 or $symbols[$tReel][$tRow] == 12) {
								$symbols[$tReel][$tRow] = round(rand(3, 8));
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
