<?
if ($_Social['activeBuster'] != '') {
	$busterActive = explode(":", $_Social['activeBuster']);
	if ($busterActive[0] != '' and $busterActive[0] != 0 and $busterActive[1] != '' and $busterActive[1] != 0) {
		if ($busterActive[1] > 0 and ($busterActive[0] == 6 or $busterActive[0] == 7 or $busterActive[0] == 8 or
			$busterActive[0] == 10 or $busterActive[0] == 11 or $busterActive[0] == 12)) {
			if ($busterActive[0] == 6) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					/*
	$colossalSym='0';
	$colossalSize='0';
	$colossalFinalX='0';
	$colossalX='0';
	$colossalFinalY='0';
	$colossalY='0';
	$hasColossal=0;
*/
					$pos = round(rand(0, 11));
					$temp[0] = 3;
					$temp[1] = 4;
					$temp[2] = 5;
					$temp[3] = 6;
					$temp[4] = 7;
					$temp[5] = 6;
					$temp[6] = 7;
					$temp[7] = 6;
					$temp[8] = 5;
					$temp[9] = 6;
					$temp[10] = 7;
					$temp[11] = 7;
					if ($hasColossal != 0) $colossalSym = $temp[$pos];
					for ($j = 0; $j < 3; $j++) {
						$symbols[0][$j] = $temp[$pos];
						$symbols[1][$j] = $temp[$pos];
						$symbols[2][$j] = $temp[$pos];
					}
				}
			}

			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					$colossalMainGameSymbol = 12;
					$colossalMainGameSize = 3;
					$startFS = 1;
					$colossalX = round(rand(1, 2));
					$colossalY = round(rand(-2, 2));
					$colossalSym = $colossalMainGameSymbol;
					$colossalSize = $colossalMainGameSize;
					$colossalFinalX = $colossalX;
					$colossalFinalY = $colossalY;
					$hasColossal = 1;
				}
				$buster7 = 'ok';
			}

			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					$colossalMainGameSymbol = 12;
					$colossalMainGameSize = 3;
					$startFS = 1;
					$colossalX = round(rand(1, 2));
					$colossalY = round(rand(-2, 2));
					$colossalSym = $colossalMainGameSymbol;
					$colossalSize = $colossalMainGameSize;
					$colossalFinalX = $colossalX;
					$colossalFinalY = $colossalY;
					$hasColossal = 1;
				}
				$buster8 = 'ok';
			}

			if ($busterActive[0] == 10) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
				}
				if ($lastAction != 'freespin') $buster10 = 'ok';
			}



			if ($busterActive[0] == 11) {
				if (($lastAction == 'spin')) // and $_GET['action']=="spin") or $lastAction=='drop' or $lastAction=='drop1' or $lastAction=='lastdrop')
				{

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 8 or $symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 10) {
								$symbols[$tReel][$tRow] = round(rand(3, 7));
							}
						}
					if ($lastAction == 'spin' and $_GET['action'] == "spin")	$busterActive[1]--;
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
