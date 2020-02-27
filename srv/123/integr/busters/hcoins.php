<?
if ($_Social['activeBuster'] != '') {
	$busterActive = explode(":", $_Social['activeBuster']);
	if ($busterActive[0] != '' and $busterActive[0] != 0 and $busterActive[1] != '' and $busterActive[1] != 0) {
		if ($busterActive[1] > 0 and ($busterActive[0] == 6 or $busterActive[0] == 7 or $busterActive[0] == 8 or
			$busterActive[0] == 10 or $busterActive[0] == 11 or $busterActive[0] == 12)) {
			if ($busterActive[0] == 6) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") {
					$busterActive[1]--;
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 12));
							}
						}

					$pos = round(rand(0, 11));
					$temp[0] = 3;
					$temp[1] = 4;
					$temp[2] = 5;
					$temp[3] = 6;
					$temp[4] = 7;
					$temp[5] = 4;
					$temp[6] = 5;
					$temp[7] = 6;
					$temp[8] = 7;
					$temp[9] = 5;
					$temp[10] = 6;
					$temp[11] = 7;
					for ($j = 0; $j < 4; $j++) {
						$symbols[0][$j] = $temp[$pos];
						$symbols[1][$j] = $temp[$pos];
						$symbols[2][$j] = $temp[$pos];
					}
				}
			}
			if ($busterActive[0] == 7) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") // and $lastActionDB!="endfreespin")
				{
					$busterActive[1]--;

					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 12));
							}
						}
					$symbols[0][1] = 0;
					$symbols[2][1] = 0;
					$symbols[4][1] = 0;
				}
			}

			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin") // and $lastActionDB!="paytable")
				{
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 12));
							}
						}
					$busterActive[1]--;
					$buster8 = 'ok';
					$reel[5][0] = 1000;
					$reel[5][1] = 1000;
					$reel[5][2] = 1000;
					$reel[7][0] = 1000;
				}
			}

			/*
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
							if ($symbols[$tReel][$tRow] == 8 or $symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 10 or $symbols[$tReel][$tRow] == 11 or $symbols[$tReel][$tRow] == 12) {
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
