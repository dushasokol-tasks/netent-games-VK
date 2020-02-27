<?
if ($_Social['activeBuster'] != '') {
	$busterActive = explode(":", $_Social['activeBuster']);
	if ($busterActive[0] != '' and $busterActive[0] != 0 and $busterActive[1] != '' and $busterActive[1] != 0) {
		if ($busterActive[1] > 0 and ($busterActive[0] == 6 or $busterActive[0] == 7 or $busterActive[0] == 8 or
			$busterActive[0] == 10 or $busterActive[0] == 11 or $busterActive[0] == 12)) {
			if ($busterActive[0] == 6) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;

					$pos = round(rand(0, 11));
					$temp[0] = 3;
					$temp[1] = 4;
					$temp[2] = 5;
					$temp[3] = 6;
					$temp[4] = 7;
					$temp[5] = 8;
					$temp[6] = 8;
					$temp[7] = 8;
					$temp[8] = 7;
					$temp[9] = 6;
					$temp[10] = 6;
					$temp[11] = 4;
					//			for($j=0;$j<3;$j++)
					{
						$symbols[0][2] = $temp[$pos];
						$symbols[1][2] = $temp[$pos];
						$symbols[2][2] = $temp[$pos];
						$symbols[3][2] = $temp[$pos];
						$symbols[4][2] = $temp[$pos];
					}
				}
			}

			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;

					$pos = round(rand(0, 4));
					$temp[0] = 13;
					$temp[1] = 12;
					$temp[2] = 11;
					$temp[3] = 10;
					$temp[4] = 9; {
						$symbols[0][2] = $temp[$pos];
						$symbols[1][2] = $temp[$pos];
						$symbols[2][2] = $temp[$pos];
					}
				}
				if ($lastActionDB == 'respin' and $_GET['action'] == "respin") {
					$pos = round(rand(0, 4));
					$temp[0] = 13;
					$temp[1] = 12;
					$temp[2] = 11;
					$temp[3] = 10;
					$temp[4] = 9;
					$symbols[0][2] = $temp[$pos];
					$symbols[1][2] = $temp[$pos];
					$symbols[2][2] = $temp[$pos];
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;

					$pos = round(rand(0, 4));
					$temp[0] = 13;
					$temp[1] = 12;
					$temp[2] = 11;
					$temp[3] = 10;
					$temp[4] = 9; {
						$symbols[0][2] = $temp[$pos];
						$symbols[1][2] = $temp[$pos];
						$symbols[2][2] = $temp[$pos];
						$symbols[3][2] = $temp[$pos];
						$symbols[4][2] = $temp[$pos];
					}
				}
				if ($lastActionDB == 'respin' and $_GET['action'] == "respin" and $wavecount < 4) {
					$pos = round(rand(0, 4));
					$temp[0] = 13;
					$temp[1] = 12;
					$temp[2] = 11;
					$temp[3] = 10;
					$temp[4] = 9;
					$symbols[0][2] = $temp[$pos];
					$symbols[1][2] = $temp[$pos];
					$symbols[2][2] = $temp[$pos];
					$symbols[3][2] = $temp[$pos];
					$symbols[4][2] = $temp[$pos];
				}
			}


			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					$buster10 = 'ok';
				}
			}



			if ($busterActive[0] == 11) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin" or ($lastActionDB == 'respin' and $_GET['action'] == "respin")) {

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 10 or $symbols[$tReel][$tRow] == 11 or $symbols[$tReel][$tRow] == 12 or $symbols[$tReel][$tRow] == 13) {
								$symbols[$tReel][$tRow] = round(rand(3, 8));
							}
						}
					if ($lastAction == 'spin' and $_GET['action'] == "spin") $busterActive[1]--;
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
