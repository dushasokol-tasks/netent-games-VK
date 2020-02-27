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
									$symbols[$tReel][$tRow] = round(rand(3, 9));
								}
							}
						$bonusSymbCount = 0;
					}
					$pos = round(rand(0, 11));
					$temp[0] = 3;
					$temp[1] = 4;
					$temp[2] = 3;
					$temp[3] = 4;
					$temp[4] = 4;
					$temp[5] = 4;
					$temp[6] = 3;
					$temp[7] = 4;
					$temp[8] = 3;
					$temp[9] = 4;
					$temp[10] = 4;
					$temp[11] = 4;
					for ($j = 0; $j < 3; $j++) {
						$symbols[2][$j] = $temp[$pos];
						$symbols[3][$j] = $temp[$pos];
						$symbols[4][$j] = $temp[$pos];
					}
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;


					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 1) {
								$symbols[$tReel][$tRow] = round(rand(3, 9));
							}
						}
					unset($extrawild);
					unset($wildReels);
					$wildsSymbCount = 3;
					$symbols[1][1] = 1;
					$symbols[2][1] = 1;
					$symbols[3][1] = 1;
					$extrawild[1][1] = 1;
					$extrawild[2][1] = 1;
					$extrawild[3][1] = 1;
					$wildReels[1] = 1;
					$wildReels[2] = 1;
					$wildReels[3] = 1;
				}
			}


			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;


					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 1) {
								$symbols[$tReel][$tRow] = round(rand(3, 9));
							}
						}
					unset($extrawild);
					unset($wildReels);
					$wildsSymbCount = 1;
					$symbols[2][1] = 1;
					$extrawild[2][1] = 1;
					$wildReels[2] = 1;
				}
			}
			/*
///not use in SB
	    if($busterActive[0]==10)
	    {
		if($lastAction=='spin' and $_GET['action']=="spin")
		    {
			$busterActive[1]--;
			$buster10='ok';
		    }
	    }
*/
			if ($busterActive[0] == 11) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 8) {
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
