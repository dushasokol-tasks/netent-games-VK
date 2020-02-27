<?
$ajaxAction = 1;
if (isset($_POST['action']) and isset($_POST['id'])) $_GET['id'] = $_POST['id'];

include('games/lobby/lib/common2.php');

echo '{"graduse":' . $init_str . ',';

echo '"worldInfo":' . $worldInfo . '}';

/*
//$temp=explode(':',$_POST['action']);
//if($temp[0]=='usebuster')
//{
///check buster correction here

echo '{"current": "basic", "stack": "basic", "level": 10, "exp": 9.5, "endExp": 10,';
echo '"safeFullTime": 9300, "safeTime": 2100, "wheelFullTime": "3599", "wheelTime": "3200",';
//echo '"questreward": "zxzxz", "quest1": "qqqq1", "quest2": "qqqq2", "quest3": "qqqq3",';
echo '"questreward": "z1212",';
echo '"message": "Активация бустера",';
//echo '"quest1": [{"status":2},{"descr":"чячяч"}],';
echo '"quest1":[{"status":1},{"descr":"4"},{"item3":10},{"item4":12}],';
echo '"quest2":[{"status":2},{"descr":"4"},{"item3":10},{"item4":12}],';
echo '"quest3":[{"status":3},{"descr":"4"},{"item3":10},{"item4":12}],';
echo '"busters":[{"item1":2},{"item2":4},{"item3":10},{"item4":12}]}';
*/

//}


