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
					$pos = round(rand(0, 3));
					$temp[0] = 6;
					$temp[1] = 3;
					$temp[2] = 4;
					$temp[3] = 5;
					for ($i = 0; $i < 3; $i++)
						for ($j = 0; $j < 3; $j++)
							$symbols[$i][$j] = $temp[$pos];
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 11));
							}
						}
					$temp2 = round(rand(0, 2));
					$symbols[0][$temp2] = 0;
					$temp2 = round(rand(0, 2));
					$symbols[1][$temp2] = 0;
					$temp2 = round(rand(0, 2));
					$symbols[2][$temp2] = 0;
					$temp2 = round(rand(0, 2));
					$symbols[3][$temp2] = 0;
					$temp2 = round(rand(0, 2));
					$symbols[4][$temp2] = 0;
				} elseif ($lastAction == 'respin' and $_GET['action'] == "respin") {
					$buster7 = 'ok';
					$busterActive[1]--;
				}
			}

			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 11));
							}
						}
					$temp2 = round(rand(0, 2));
					$symbols[0][$temp2] = 0;
					$temp2 = round(rand(0, 2));
					$symbols[2][$temp2] = 0;
					$temp2 = round(rand(0, 2));
					$symbols[4][$temp2] = 0;
				} elseif ($lastAction == 'respin' and $_GET['action'] == "respin") {
					$buster8 = 'ok';
					$busterActive[1]--;
				}
			}

			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
				}
				if ($lastAction == 'respin' and $_GET['action'] == "respin") {
					$buster10 = 'ok';
				}
			}

			if ($busterActive[0] == 11) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 8 or $symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 10 or $symbols[$tReel][$tRow] == 11) {
								$symbols[$tReel][$tRow] = round(rand(3, 7));
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
