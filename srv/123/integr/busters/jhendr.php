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
									$symbols[$tReel][$tRow] = round(rand(3, 14));
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
					$temp[5] = 8;
					$temp[6] = 9;
					$temp[7] = 3;
					$temp[8] = 4;
					$temp[9] = 5;
					$temp[10] = 6;
					$temp[11] = 7;
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
								$symbols[$tReel][$tRow] = round(rand(3, 10));
							}
						}
					$symbols[2][1] = 0;
					$symbols[3][1] = 0;
					$symbols[4][1] = 0;
					$bonusSymbCount = 3;
				} elseif ($FS1winSymbs > 2) {
					$busterActive[1]--;

					$symb_combs .= " bActive=" . $busterActive[1] . ";FS1winSymbs=$FS1winSymbs;";
				}
				$buster7 = 'ok';
			}


			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 13));
							}
						}

					if ($redGuitarSymbCount > 1  and $lastActionDB !== 'respin') {
						for ($i = 0; $i < 5; $i++) {
							$x = round(rand(0, 4));
							$y = round(rand(0, 2));
							$symbols[$x][$y] = 3;
						}

						$wilds = '';
						foreach ($symbols as $tReel => $t)
							foreach ($t as $tRow => $e) {
								if ($symbols[$tReel][$tRow] == 3) {
									$redGuitarSymbCount++;
									$wilds .= $tReel . "," . $tRow . "_";
								}
							}
						if ($redGuitarSymbCount > $redGuitar and $lastActionDB != "initfreespin" and $lastActionDB != "freespin") {
							$lastAction = "respin";
						}	//////////////////////////////////////
					} else {
						$symbols[0][1] = 1;
						$isPHaze = 1;
					}
				}
			}

			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
				}
				$buster10 = 'ok';
			}


			if ($busterActive[0] == 11) {
				if (($lastAction == 'spin' or $lastAction == "random_wilds_spin" or $lastAction == "cluster_spin") and $_GET['action'] == "spin") {
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 13 or $symbols[$tReel][$tRow] == 14 or $symbols[$tReel][$tRow] == 10 or $symbols[$tReel][$tRow] == 11 or $symbols[$tReel][$tRow] == 12) {
								$symbols[$tReel][$tRow] = round(rand(3, 9));
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
