<?

if ($_Social['activeBuster'] != '') {
	$busterActive = explode(":", $_Social['activeBuster']);
	if ($busterActive[0] != '' and $busterActive[0] != 0 and $busterActive[1] != '' and $busterActive[1] != 0) {
		if ($busterActive[1] > 0 and ($busterActive[0] == 6 or $busterActive[0] == 7 or $busterActive[0] == 8 or
			$busterActive[0] == 10 or $busterActive[0] == 11 or $busterActive[0] == 12)) {

			if ($busterActive[0] == 6) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					if ($lastActionDB != 'respin') {
						$busterActive[1]--;
						if ($bonusSymbCount > 0) {
							foreach ($symbols as $tReel => $t)
								foreach ($t as $tRow => $e) {
									if ($symbols[$tReel][$tRow] == 0) {
										$symbols[$tReel][$tRow] = round(rand(3, 8));
									}
								}
							$bonusSymbCount = 0;
						}
						$pos = round(rand(0, 5));
						$temp[0] = 3;
						$temp[1] = 3;
						$temp[2] = 4;
						$temp[3] = 4;
						$temp[4] = 5;
						$temp[5] = 5;
						for ($i = 0; $i < 3; $i++)
							for ($j = 0; $j < 3; $j++)
								$symbols[$i][$j] = $temp[$pos];
					}
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					if ($lastActionDB != 'respin') {
						$busterActive[1]--;
						foreach ($symbols as $tReel => $t)
							foreach ($t as $tRow => $e) {
								if ($symbols[$tReel][$tRow] == 0) {
									$symbols[$tReel][$tRow] = round(rand(3, 8));
								}
							}

						$temp = 0;
						$temp2 = round(rand(0, 2));
						$symbols[0][$temp2] = $temp;
						$temp2 = round(rand(0, 2));
						$symbols[2][$temp2] = $temp;
						$temp2 = round(rand(0, 2));
						$symbols[4][$temp2] = $temp;
					}
				}
				$buster7 = 'ok';
			}

			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$buster8 = 'ok';
					if ($lastActionDB != 'respin') {
						$busterActive[1]--;
						foreach ($symbols as $tReel => $t)
							foreach ($t as $tRow => $e) {
								if ($symbols[$tReel][$tRow] == 0) {
									$symbols[$tReel][$tRow] = round(rand(3, 8));
								}
							}
						$temp = 1;
						$symbols[0][1] = $temp;
						$symbols[2][1] = $temp;
						$symbols[4][1] = $temp;
					}
				}
			}

			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					if ($lastActionDB != 'respin') $busterActive[1]--;
				}
				$buster10 = 'ok';
			}

			if ($busterActive[0] == 11) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 6 or $symbols[$tReel][$tRow] == 7 or $symbols[$tReel][$tRow] == 8) {
								$symbols[$tReel][$tRow] = round(rand(3, 5));
							}
						}
					if ($lastActionDB != 'respin') $busterActive[1]--;
				}
			}


			if ($busterActive[0] == 12) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					if ($lastActionDB != 'respin') $busterActive[1]--;
				}
				$buster12 = 'ok';
			}


			if ($busterActive[1] > 0 and $_Social['activeBuster'] != '') {
				$_Social['activeBuster'] = $busterActive[0] . ":" . $busterActive[1];
			} else $_Social['activeBuster'] = '';
		}
	} else $_Social['activeBuster'] = '';
}
