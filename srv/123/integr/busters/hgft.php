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
					$temp[0] = 4;
					$temp[1] = 3;
					$temp[2] = 4;
					$temp[3] = 5;
					$temp[4] = 3;
					$temp[5] = 3;
					$temp[6] = 3;
					$temp[7] = 3;
					$temp[8] = 4;
					$temp[9] = 5;
					$temp[10] = 3;
					$temp[11] = 5;
					for ($i = 1; $i < 4; $i++)
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
					$symbols[0][1] = 0;
					$symbols[2][1] = 0;
					$symbols[4][1] = 0;
					$bonusSymbCount = 3;
				} elseif ($_GET['action'] == "bonus_feature_pick") {
					$buster7 = 'ok';
					$busterActive[1]--;
				}
			}


			if ($busterActive[0] == 8) {
				if ($lastAction == 'spin' and $_GET['action'] == "spin" and $lastActionDB != "paytable") {
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 0) {
								$symbols[$tReel][$tRow] = round(rand(3, 10));
							}
							if ($symbols[$tReel][$tRow] == 1) {
								$symbols[$tReel][$tRow] = round(rand(3, 10));
							}
						}
					$bonusSymbCount = 0;
					$wildsSymbCount = 0;

					$busterActive[1]--;
					unset($extrawild);
					if ($lastActionDB != "symbol_transform")	$temp = round(rand(0, 1));
					else $temp = round(rand(0, 2));

					if ($temp == 0) {
						$lastAction = "random_wilds";
						$length = (count($reel[7]) - 1);
						$pos = round(rand(0, $length));
						$wldStacks = explode(",", $reel[7][$pos]);
					} elseif ($temp == 1) $lastAction = "symbol_overlay";
					elseif ($temp == 2) $lastAction = "symbol_transform";
				}
			}

			if ($busterActive[0] == 10) {
				if (($lastAction == 'spin' or $lastAction == "random_wilds" or $lastAction == "stackSpin" or $lastAction == "symbol_overlay" or $lastAction == "symbol_transform") and $_GET['action'] == "spin") {
					$busterActive[1]--;
				}
				if ($_GET['action'] == "bonus_feature_pick")	$buster10 = 'ok';
			}

			if ($busterActive[0] == 11) {
				if (($lastAction == 'spin' or $lastAction == "random_wilds" or $lastAction == "stackSpin" or $lastAction == "symbol_overlay") and $_GET['action'] == "spin") {
					foreach ($symbols as $tReel => $t)
						foreach ($t as $tRow => $e) {
							if ($symbols[$tReel][$tRow] == 8 or $symbols[$tReel][$tRow] == 9 or $symbols[$tReel][$tRow] == 6 or $symbols[$tReel][$tRow] == 7) {
								$symbols[$tReel][$tRow] = round(rand(3, 5));
							}
						}
					$busterActive[1]--;
				}
			}


			if ($busterActive[0] == 12) {
				if (($lastAction == 'spin' or $lastAction == "random_wilds" or $lastAction == "stackSpin" or $lastAction == "symbol_transform"  or $lastAction == "symbol_overlay") and $_GET['action'] == "spin") {
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




/*
	    if($busterActive[0]==6)
	    {
		if($lastAction=='spin' and $_GET['action']=="spin")
		    {
			$busterActive[1]--;
			unset($extrawild);
			if($bonusSymbCount>0)
			{
			foreach ($symbols as $tReel => $t)
			    foreach ($t as $tRow => $e)
			    {
			    if($symbols[$tReel][$tRow]==0)
				{
				$symbols[$tReel][$tRow]=round(rand(3,10));
				}
			    }
			$bonusSymbCount=0;
			}
			for($i=0;$i<3;$i++)
			    for($j=0;$j<3;$j++)
				$symbols[$i][$j]=3;
		    }
	    }
*/
