<?

require_once "../common.php";
seterr();
dbinit();

$myQueryText = "SELECT * FROM rep_departments WHERE dialy_min!=0";

$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

while ($rep_dept = @mysql_fetch_array($q)) {
  $rep_dept['trans_min_quant'] += round(rand(0, 5));
  $a = "UPDATE rep_departments SET dialy='" . $rep_dept['dialy_min'] . "', trans_num='" . $rep_dept['trans_min_quant'] . "', steps='" . $rep_dept['steps_min'] . "' WHERE  id='" . $rep_dept['id'] . "';";
  mysql_query($a);
}

include('dialy_crdDelta.php');
include('dialy_gomoList.php');
include('dialy_suspectLogs.php');
include('dialy_crtBalls.php');
