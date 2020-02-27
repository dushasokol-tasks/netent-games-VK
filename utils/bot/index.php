<?
header('Access-Control-Allow-Origin: *');

$data = '';
$data_fs = '';
$started_cred = -10000;
$freegames = 0;
$win_freegames = 0;

$bnsInits = 0;
$fryInits = 0;
$fsInits = 0;
$bnsEnds = 0;

//    $bonuswin=0;
$fswin = 0;
$coinwin = 0;

$mirror = 0;

$symb_trans = 0;
$symb_over = 0;

include('../../srv/dbConnect.php');
$output = '';
$link = mysql_connect($db_host, $db_user, $db_pass);

$query = "select * from ns.logs4 order by id;";

$res = mysql_query($query);

$fs_arm = 10;
$table_step = 10;

while ($result = mysql_fetch_assoc($res)) {
	if ($started_cred == -10000) $started_cred = $result['credit_old'];
	$ending_cred = $result['new_cred'];
	$is_fs = $started_cred / 100;

	if (substr($result['action'], 0, 7) == 'mirror2') {
		$mirror++;
		//	    $is_fs=($started_cred/100)+(50*$fs_arm);
	} elseif (substr($result['action'], 0, 6) == 'mirror') {
		$mirror++;
		//	    $is_fs=($started_cred/100)+(50*$fs_arm);
	}

	if (substr($result['action'], 0, 6) == 'bonus_') {
		$bnsInits++;
		//	    $is_fs=($started_cred/100)+(50*$fs_arm);
	}
	if (substr($result['action'], 0, 6) == 'fairy_') {
		$fryInits++;
	}

	if (substr($result['action'], 0, 8) == 'symbol_t') {
		$symb_trans++;
		$is_fs = ($started_cred / 100) - (2 * $fs_arm);
	}
	if (substr($result['action'], 0, 8) == 'symbol_o') {
		$symb_over++;
		$is_fs = ($started_cred / 100) - (1 * $fs_arm);

		//	    if(substr($result['action'],19,1)==';') $is_fs=($started_cred/100)-(substr($result['action'],17,2)*$fs_arm);
		//	    elseif(substr($result['action'],18,1)==';') $is_fs=($started_cred/100)-(substr($result['action'],17,1)*$fs_arm);

	}

	if (substr($result['action'], 0, 5) == 'endbo') {
		$bnsEnds++;
		$is_fs = ($started_cred / 100) + (3 * $fs_arm);
		//	    $is_fs=($started_cred/100)+(10*$fs_arm);
	}

	if (substr($result['action'], 0, 4) == 'daze') {
		$coinwin++;
		$is_fs = ($started_cred / 100) + (1 * $fs_arm);
	}

	if (substr($result['action'], 0, 6) == 'startf') {
		$fsInits++;
		$is_fs = ($started_cred / 100) + (2 * $fs_arm);

		//	    $is_fs=($started_cred/100)+(10*$fs_arm);
	}

	if (substr($result['action'], 0, 5) == 'frees') {
		$fswin += $result['win'];
	}
	/*
	if(substr($result['action'],0,4)=='resp')
	{
	    $fswin+=$result['win'];
	}

	if(substr($result['action'],0,5)=='lastr')
	{
	    $fswin+=$result['win'];
	}
*/



	//	if(substr($result['symbs'],0,4)=='COIN')$is_fs=$started_cred/100+30;

	//	if($data_fs=='')	$data_fs="[".$result['id'].",".$is_fs."]";
	//	else		$data_fs.=",[".$result['id'].",".$is_fs."]";
	//	if($result['id']%$table_step==0 or $is_fs!=($started_cred/100))
	if ($result['id'] % $table_step == 0) {
		if ($data == '')	$data = "[" . $result['id'] . "," . ($result['new_cred'] / 100) . "," . $is_fs . "]";
		else		$data .= ",[" . $result['id'] . "," . ($result['new_cred'] / 100) . "," . $is_fs . "]";
	}

	$lastId = $result['id'];
}
//echo $data;

$bnsEnds /= 2;

echo "BNS:" . $bnsInits . "; FairyItits:" . $fryInits . "<br> FS:" . $fsInits . "/ " . $fswin . "; BO:" . $bnsEnds . "; DAZZLE:" . $coinwin . "<br> ST:" . $symb_trans . "; SO:" . $symb_over;

echo "<br><br>MIRR:" . $mirror . ";";

$query = "select * from ns.common where sessionId='364';";
$res = mysql_query($query);
$result = mysql_fetch_assoc($res);
$betted_full = $result['betted_full'];
$winned_full = $result['winned_full'];

mysql_close($link);

//echo $started_cred;
$percent = $ending_cred / $started_cred * 100;

echo '
  <script type="text/javascript" src="loader.js"></script>
  <div id="chart_div" style="height:600px;"></div>
';

echo "
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'Dogs');
      data.addColumn('number', 'Cats');

      data.addRows([ ";

echo $data;
echo "
      ]);

      var options = {
        hAxis: {
          title: '" . $lastId . " spins, $bnsInits / $bnsEnds BONUS inits/ends (" . $fsInits . " fs count)'
        },
        vAxis: {
          title: '" . $percent . " %CR (" . $betted_full . "," . $winned_full . " TP " . round($winned_full / $betted_full * 100, 2) . " %)'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }

</script>

";
