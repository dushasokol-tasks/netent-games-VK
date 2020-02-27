<?
//echo 'qqq';
$temp = 'ok';
if ($_Social['level'] == 1 and $_Social['tutorStep'] < 5) $_Social['tutorStep']++;
elseif ($_Social['level'] == 2) $_Social['tutorStep']++;
else $temp = '';

if ($_Social['level'] == 2) {
    if ($_Social['tutorStep'] == 6 and $gameId == 999 and $lastAction == 'endfreespin') {
        $_Social['tutorStep'] += 2;
        $temp = 'ok';
    } elseif ($_Social['tutorStep'] == 9 and $gameId == 999 and $lastAction == 'endbonus') {
        $temp = 'ok';
    } elseif ($_Social['tutorStep'] == 10 and $gameId == 999 and $lastAction == 'emptySpin') {
        $temp = 'ok';
    }
}
if ($_Social['tutorStep'] > 8 and $gameId != 999) $temp = '';



if ($temp != '') {
    //echo $_Social['tutorStep']."().()<br>&";
    $query = "SELECT * FROM ns.social_tutor where id=" . $_Social['tutorStep'];
    $result = mysql_query($query);
    $_Tutor = mysql_fetch_assoc($result);

    //$_Social['tutorStep']

    $tutorial_output .= "gamestate.tutormsg=" . $_Tutor['msg'] . "&";
    $tutorial_output .= "gamestate.tutorstep=" . $_Social['tutorStep'] . "&";
}

if ($_Social['tutorStep'] == 9 and $gameId == 999) {
    //    $_Social['tutorStep']=10;
}
if ($_Social['tutorStep'] == 10 and $gameId == 999) {
    $_Social['tutorStep'] = 9;
}


if ($_Social['level'] == 2 and $gameId == 1 and $_Social['tutorStep'] != 2) $_Social['tutorStep']--;

if ($_Social['tutorStep'] > 7 and $gameId != 999) {
    $_Social['tutorStep'] = -2;
}
