<?


if ($_Social['activeBuster'] != '') {
	$busterActive = explode(":", $_Social['activeBuster']);
	if ($busterActive[0] != '' and $busterActive[0] != 0 and $busterActive[1] != '' and $busterActive[1] != 0) {
		if ($busterActive[1] > 0 and ($busterActive[0] == 6 or $busterActive[0] == 7 or $busterActive[0] == 8 or
			$busterActive[0] == 10 or $busterActive[0] == 11 or $busterActive[0] == 12)) {
			if ($busterActive[0] == 6) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					unset($extrawild);
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
					$temp[5] = 7;
					$temp[6] = 6;
					$temp[7] = 5;
					$temp[8] = 4;
					$temp[9] = 5;
					$temp[10] = 6;
					$temp[11] = 7;
					for ($i = 0; $i < 5; $i++)
						for ($j = 0; $j < 4; $j += 2)
							$symbols[$i][$j] = $temp[$pos];
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 13));
							}
						}
					$symbols[0][1] = 0;
					$symbols[2][1] = 0;
					$symbols[4][1] = 0;
					$bonusSymbCount = 3;
					$busterActive[1]--;
				}
				$buster7 = 'ok';
			}


			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin" and $lastActionDB != "paytable") {
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 13));
							}
						}
					$bonusSymbCount = 0;

					$busterActive[1]--;
					unset($extrawild);
					$temp = round(rand(0, 1));

					if ($temp == 0) $lastAction = "symbol_overlay";
					elseif ($temp == 1) $lastAction = "symbol_transform";
				}
			}

			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin" and $lastActionDB != 'lastrespin') {
					$busterActive[1]--;
				}
				$buster10 = 'ok';
			}

			if ($busterActive[0] == 11) {

				if (($lastAction == "symbol_transform" or $lastAction == "symbol_overlay" or $lastAction == "spin" or
					$lastAction == "mirror" or $lastAction == "mirror2" or $lastAction == "bonus_feature_pick" or $lastAction == "fairy_pre_bonus") and $_GET['action'] == "spin")
				//		if($lastAction=='spin' and $_GET['action']=="spin" and $lastActionDB!="paytable")
				{
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 8 or $symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 10 or $symbols[$tReel][$tRow] == 11 or $symbols[$tReel][$tRow] == 12 or $symbols[$tReel][$tRow] == 13) {
								$symbols[$tReel][$tRow] = round(rand(3, 7));
							}
						}
					$busterActive[1]--;
				}
			}


			if ($busterActive[0] == 12) {
				//		if(($lastAction=='spin' or $lastAction=="random_wilds" or $lastAction=="stackSpin" or $lastAction=="symbol_transform"  or $lastAction=="symbol_overlay")and $_GET['action']=="spin")
				if (($lastAction == "symbol_transform" or $lastAction == "symbol_overlay" or $lastAction == "spin" or
					$lastAction == "mirror" or $lastAction == "mirror2" or $lastAction == "bonus_feature_pick" or $lastAction == "fairy_pre_bonus") and $_GET['action'] == "spin") {
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
