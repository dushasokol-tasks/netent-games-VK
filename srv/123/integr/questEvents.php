<?
$achieve_complete = 0;
if (isset($_Events[$temp3[1]]) and $_Events[$temp3[1]] == 1) {

	$achieve_complete = 1;

	//echo "dd=QE&";
} elseif ($temp3[1] == '101') {
	if ($gameId == '1') if ($real_win > 9.99) $achieve_complete = 1;
} elseif ($temp3[1] == '201') {
	if ($gameId == '2') if ($real_win > 9.99) $achieve_complete = 1;
} elseif ($temp3[1] == '301') {
	if ($gameId == '3') if ($real_win > 9.99) $achieve_complete = 1;
} elseif ($temp3[1] == '401') {
	if ($gameId == '4') if ($real_win > 9.99) $achieve_complete = 1;
}
