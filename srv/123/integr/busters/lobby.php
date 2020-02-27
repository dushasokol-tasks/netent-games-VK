<?


if ($_Social['activeBuster'] != '') {
	$busterActive = explode(":", $_Social['activeBuster']);
	if ($busterActive[0] != '' and $busterActive[0] != 0 and $busterActive[1] != '' and $busterActive[1] != 0) {
		if ($busterActive[1] > 0 and ($busterActive[0] == 9 or $busterActive[0] == 10)) {
			if ($busterActive[0] == 9) {

				if ($lastAction != 'bonusaction' and $lastAction != 'initbonus' and $lastAction != 'startbonus') {
					$_Social['activeBuster'] = '';
				} else {
					if ($lastAction != 'startbonus') {
						$busterActive[1]--;
					}
					unset($reel[5]);
					unset($reel[6]);
					unset($reel[8]);
					unset($reel[9]);
					$reel[5] = array(
						"0" => "ARROW",
						"1" => "ARROW",
						"2" => "ARROW",
						"3" => "ARROW",
						"4" => "ARROW",
						"5" => "60",
						"6" => "ARROW",
						"7" => "ARROW",
						"8" => "ARROW",
						"9" => "ARROW",
						"10" => "ARROW",
						"11" => "90",
						"12" => "ARROW",
						"13" => "ARROW",
						"14" => "ARROW",
						"15" => "60",
						"16" => "ARROW",
						"17" => "90",
						"18" => "ARROW",
						"19" => "ARROW",
						"20" => "ARROW",
						"21" => "ARROW",
						"22" => "ARROW",
						"23" => "ARROW",
						"24" => "ARROW",
						"25" => "60",
						"26" => "ARROW",
						"27" => "ARROW",
						"28" => "ARROW",
						"29" => "ARROW",
						"30" => "ARROW",
						"31" => "ARROW",
						"32" => "ARROW",
						"33" => "ARROW",
						"34" => "ARROW",
						"35" => "60"
					);

					$reel[6] = array(
						"0" => "ARROW",
						"1" => "ARROW",
						"2" => "ARROW",
						"3" => "ARROW",
						"4" => "ARROW",
						"5" => "60",
						"6" => "RAPID_JACKPOT",
						"7" => "ARROW",
						"8" => "ARROW",
						"9" => "ARROW",
						"10" => "ARROW",
						"11" => "90",
						"12" => "ARROW",
						"13" => "ARROW",
						"14" => "RAPID_JACKPOT",
						"15" => "60",
						"16" => "ARROW",
						"17" => "90",
						"18" => "ARROW",
						"19" => "ARROW",
						"20" => "ARROW",
						"21" => "ARROW",
						"22" => "ARROW",
						"23" => "ARROW",
					);

					$reel[8] = $reel[5];
					$reel[9] = $reel[6];
				}
			}

			if ($busterActive[1] > 0 and $_Social['activeBuster'] != '') {
				$_Social['activeBuster'] = $busterActive[0] . ":" . $busterActive[1];
			} else $_Social['activeBuster'] = '';
		}
	} else $_Social['activeBuster'] = '';
}
