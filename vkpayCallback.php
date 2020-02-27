<?php
header("Content-Type: application/json; encoding=utf-8");

$secret_key = 'appKeyHere'; // Защищенный ключ приложения 

$input = $_POST;

// Проверка подписи 
$sig = $input['sig'];
unset($input['sig']);
ksort($input);
$str = '';
foreach ($input as $k => $v) {
	$str .= $k . '=' . $v;
}

if ($sig != md5($str . $secret_key)) {
	$response['error'] = array(
		'error_code' => 10,
		'error_msg' => 'Несовпадение вычисленной и переданной подписи запроса.',
		'critical' => true
	);
} else {
	// Подпись правильная 
	include('srv/dbConnect.php');
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$DB1 = "ns";
	$DB2 = "ns";
	@mysql_query("set names 'utf8'");
	switch ($input['notification_type']) {

		case 'get_item':
			// Получение информации о товаре в тестовом режиме 
			$item = $input['item'];

			$myQueryText = "SELECT * FROM $DB2.social_purchases";
			$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
			while ($temp = mysql_fetch_assoc($q)) {
				$_Purchases[$temp['id']] = $temp;
			}
			$no_good = 1;
			foreach ($_Purchases as $e => $v) {
				$type = $v['type'];
				if ($v['type'] == 'game') $type = $v['type'] . $v['id'];
				elseif ($v['type'] == 'item') $type = $v['type'] . $v['id'];
				elseif ($v['type'] == 'buster') $type = $v['type'] . $v['id'];

				if ($item == $type) {
					$response['response'] = array(
						'item_id' => $v['id'],
						'title' => $v['title'],
						'photo_url' => 'https://ermak.xyz/games/lobby/images/icons/' . $v['img'],
						'price' => $v['costVK']
					);
					$no_good = 0;
				}
			}

			if ($no_good == 1) {
				$response['error'] = array(
					'error_code' => 20,
					'error_msg' => 'Товара не существует.',
					'critical' => true
				);
			}
			//    mysql_close($link);

			break;

		case 'get_item_test':
			// Получение информации о товаре в тестовом режиме 
			$item = $input['item'];

			$myQueryText = "SELECT * FROM $DB2.social_purchases";
			$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
			while ($temp = mysql_fetch_assoc($q)) {
				$_Purchases[$temp['id']] = $temp;
			}
			$no_good = 1;
			foreach ($_Purchases as $e => $v) {
				$type = $v['type'];
				if ($v['type'] == 'game') $type = $v['type'] . $v['id'];
				elseif ($v['type'] == 'item') $type = $v['type'] . $v['id'];
				elseif ($v['type'] == 'buster') $type = $v['type'] . $v['id'];

				if ($item == $type) {
					$response['response'] = array(
						'item_id' => $v['id'],
						'title' => $v['title'],
						'photo_url' => 'https://ermak.xyz/games/lobby/images/icons/' . $v['img'],
						'price' => $v['costVK']
					);
					$no_good = 0;
				}
			}

			if ($no_good == 1) {
				$response['error'] = array(
					'error_code' => 20,
					'error_msg' => 'Товара не существует.',
					'critical' => true
				);
			}
			//    mysql_close($link);

			break;

		case 'order_status_change':
			// Изменение статуса заказа в тестовом режиме 
			if ($input['status'] == 'chargeable') {

				$order_id = intval($input['order_id']);
				$summ = intval($input['item_price']);
				$item_id = intval($input['item_id']);
				$receiver_id = intval($input['receiver_id']);
				foreach ($input as $e => $v) $text .= $e . " => " . $v . "; ";


				//     $myQueryText="INSERT INTO `$DB2`.`social_orders` 	(`id`, 		`platform`, 	`text`, 		`summ`,      	`status`)
				//     VALUES 						('$order_id', 	'VK',		'$text',		'$summ',		'ok' 	);";
				$myQueryText = "INSERT INTO `$DB2`.`social_orders` 	(`id`, 		`platform`, 	`ts`,		`user_id`, 	`text`, 	`summ`, 	`status`)
     VALUES 						('$order_id', 	'VK',		'" . time() . "',	'$receiver_id',	'$text',	'$summ',	'ok' 	);";
				$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

				if (!$q) {
					$response['error'] = array(
						'error_code' => 100,
						'error_msg' => 'Что-то с базой.',
						'critical' => true
					);
				} else {
					$myQueryText = "SELECT * FROM $DB2.social_purchases where id=$item_id";
					$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
					$temp = mysql_fetch_assoc($q);
					if ($temp['type'] == 'item') { {
							//		$query="UPDATE $DB1.social_terminals set credit=credit+".$temp['effect']." where id='VK".$receiver_id."';";
							$query = "UPDATE $DB2.social_terminals set credit=credit+" . $temp['effect'] . " where id='VK" . $receiver_id . "';";
							$result = mysql_query($query);
							if ($temp['id'] == '1001') {
								$myQueryText = "SELECT * FROM $DB2.social_main where id='VK" . $receiver_id . "'";
								$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
								$_Social = mysql_fetch_assoc($q);

								$busters_str = '';
								for ($i = 1; $i <= 5; $i++)
									$add_buster[$i] = round(rand(6, 12));
								$temp = explode(',', $_Social['inventory']);
								foreach ($temp as $e => $v) if ($v != '') {
									$temp2 = explode(':', $v);
									for ($i = 1; $i <= 5; $i++)
										if ($temp2[0] == $add_buster[$i]) $temp2[1]++;
									if ($busters_str == '') $busters_str = $temp2[0] . ':' . $temp2[1];
									else $busters_str .= ',' . $temp2[0] . ':' . $temp2[1];
								}
								$query = "UPDATE $DB2.social_main set inventory='" . $busters_str . "' where id='VK" . $receiver_id . "';";
								$result = mysql_query($query);
							}
						}
					} elseif ($temp['type'] == 'cashback') {

						$myQueryText = "SELECT * FROM $DB2.social_main where id='VK" . $receiver_id . "';";
						$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
						$_Social = mysql_fetch_assoc($q);

						$query = "UPDATE $DB2.social_main set cashBack='0' where id='VK" . $receiver_id . "';";
						$result = mysql_query($query);

						$query = "UPDATE $DB2.social_terminals set credit=credit+" . $_Social['cashBack'] . " where id='VK" . $receiver_id . "';";
						$result = mysql_query($query);
					} elseif ($temp['type'] == 'game') {
						$query = "UPDATE $DB2.social_main set avaiableGames=avaiableGames+1 where id='VK" . $receiver_id . "';";
						$result = mysql_query($query);
					} elseif ($temp['type'] == 'buster') {
						$myQueryText = "SELECT * FROM $DB2.social_main where id='VK" . $receiver_id . "';";
						$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
						$_Social = mysql_fetch_assoc($q);

						$temp = explode(':', $temp['effect']);
						$add_buster = $temp[0];
						$add_quant = $temp[1];

						$busters_str = '';
						$temp = explode(',', $_Social['inventory']);
						foreach ($temp as $e => $v) if ($v != '') {
							$temp2 = explode(':', $v);
							if ($temp2[0] == $add_buster) $temp2[1] += $add_quant;
							if ($busters_str == '') $busters_str = $temp2[0] . ':' . $temp2[1];
							else $busters_str .= ',' . $temp2[0] . ':' . $temp2[1];
						}
						$query = "UPDATE $DB2.social_main set inventory='" . $busters_str . "' where id='VK" . $receiver_id . "';";
						$result = mysql_query($query);
					}

					$app_order_id = 'VK' . $order_id; // Тут фактического заказа может не быть - тестовый режим. 
					$response['response'] = array(
						'order_id' => $order_id,
						'app_order_id' => $app_order_id,
					);
				}
			} else {
				$response['error'] = array(
					'error_code' => 100,
					'error_msg' => 'Передано непонятно что вместо chargeable.',
					'critical' => true
				);
			}
			break;

		case 'order_status_change_test':
			// Изменение статуса заказа в тестовом режиме 
			if ($input['status'] == 'chargeable') {

				$order_id = intval($input['order_id']);
				$summ = intval($input['item_price']);
				$item_id = intval($input['item_id']);
				$receiver_id = intval($input['receiver_id']);
				foreach ($input as $e => $v) $text .= $e . " => " . $v . "; ";


				$myQueryText = "INSERT INTO `$DB2`.`social_orders` 	(`id`, 		`platform`, 	`ts`,		`user_id`, 	`text`, 	`summ`, 	`status`)
     VALUES 						('$order_id', 	'VK',		'" . time() . "',	'$receiver_id',	'$text',	'$summ',	'ok' 	);";
				$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());

				if (!$q) {
					$response['error'] = array(
						'error_code' => 100,
						'error_msg' => 'Что-то с базой.',
						'critical' => true
					);
				} else {
					$myQueryText = "SELECT * FROM $DB2.social_purchases where id=$item_id";
					$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
					$temp = mysql_fetch_assoc($q);
					if ($temp['type'] == 'item') { {
							//		$query="UPDATE $DB1.social_terminals set credit=credit+".$temp['effect']." where id='".$receiver_id."';";
							$query = "UPDATE $DB2.social_terminals set credit=credit+" . $temp['effect'] . " where id='VK" . $receiver_id . "';";
							$result = mysql_query($query);
							if ($temp['id'] == '1001') {
								$myQueryText = "SELECT * FROM $DB2.social_main where id=$receiver_id";
								$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
								$_Social = mysql_fetch_assoc($q);

								$busters_str = '';
								for ($i = 1; $i <= 5; $i++)
									$add_buster[$i] = round(rand(6, 12));
								$temp = explode(',', $_Social['inventory']);
								foreach ($temp as $e => $v) if ($v != '') {
									$temp2 = explode(':', $v);
									for ($i = 1; $i <= 5; $i++)
										if ($temp2[0] == $add_buster[$i]) $temp2[1]++;
									if ($busters_str == '') $busters_str = $temp2[0] . ':' . $temp2[1];
									else $busters_str .= ',' . $temp2[0] . ':' . $temp2[1];
								}
								$query = "UPDATE $DB2.social_main set inventory='" . $busters_str . "' where id='" . $receiver_id . "';";
								$result = mysql_query($query);
							}
						}
					} elseif ($temp['type'] == 'cashback') {

						$myQueryText = "SELECT * FROM $DB2.social_main where id=$receiver_id";
						$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
						$_Social = mysql_fetch_assoc($q);

						$query = "UPDATE $DB2.social_main set cashBack='0' where id='" . $receiver_id . "';";
						$result = mysql_query($query);

						$query = "UPDATE $DB1.social_terminals set credit=credit+" . $_Social['cashBack'] . " where id='" . $receiver_id . "';";
						$result = mysql_query($query);
					} elseif ($temp['type'] == 'game') {
						$query = "UPDATE $DB2.social_main set avaiableGames=avaiableGames+1 where id='" . $receiver_id . "';";
						$result = mysql_query($query);
					} elseif ($temp['type'] == 'buster') {
						$myQueryText = "SELECT * FROM $DB2.social_main where id=$receiver_id";
						$q = @mysql_query($myQueryText) or die("mysql_query: " . mysql_error());
						$_Social = mysql_fetch_assoc($q);

						$temp = explode(':', $temp['effect']);
						$add_buster = $temp[0];
						$add_quant = $temp[1];

						$busters_str = '';
						$temp = explode(',', $_Social['inventory']);
						foreach ($temp as $e => $v) if ($v != '') {
							$temp2 = explode(':', $v);
							if ($temp2[0] == $add_buster) $temp2[1] += $add_quant;
							if ($busters_str == '') $busters_str = $temp2[0] . ':' . $temp2[1];
							else $busters_str .= ',' . $temp2[0] . ':' . $temp2[1];
						}
						$query = "UPDATE $DB2.social_main set inventory='" . $busters_str . "' where id='" . $receiver_id . "';";
						$result = mysql_query($query);
					}

					$app_order_id = 'VK' . $order_id; // Тут фактического заказа может не быть - тестовый режим. 
					$response['response'] = array(
						'order_id' => $order_id,
						'app_order_id' => $app_order_id,
					);
				}
			} else {
				$response['error'] = array(
					'error_code' => 100,
					'error_msg' => 'Передано непонятно что вместо chargeable.',
					'critical' => true
				);
			}
			break;
	}
	mysql_close($link);
}

echo json_encode($response);
