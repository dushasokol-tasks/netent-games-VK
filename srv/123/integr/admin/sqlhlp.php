<?

function dbinit()
{
  global $db_user;
  global $db_pass;
  global $db_host;
  global $db_name;

  @mysql_pconnect($db_host, $db_user, $db_pass) or die("mysql_connect: " . mysql_error());
  @mysql_select_db($db_name) or die("mysql_select_db: " . mysql_error());
  #@mysql_query('SET NAMES cp1251'); # UTF-8
  @mysql_query("set names 'utf8'");
}


function getUserData($id, &$user)
{
  $res = false;
  $q = @mysql_query("SELECT * FROM users WHERE id='$id'") or die("mysql_query: " . mysql_error());
  if (1 == @mysql_num_rows($q)) {
    $user = @mysql_fetch_array($q);
    $res = true;
  }
  return $res;
}


function getSubadminClubs($subId, &$clubs_data)
{
  global $EOWNER;
  global $ENOT_RECYCLED;
  $subadminOwners = array();
  getSubadminOwners($subId, $subadminOwners);
  for ($c = 0; $c < count($subadminOwners); ++$c) {
    $v = $subadminOwners[$c];
    $ownId = $v["id"];
    $ownerClubs = array();
    getOwnerClubs($ownId, $ownerClubs);
    for ($i = 0; $i < count($ownerClubs); $i++) {
      $v1 = $ownerClubs[$i];
      array_push($clubs_data, $v1);
    }
  }
}


function getOwnerClubs($ownId, &$clubs_data)
{
  global $ENOT_RECYCLED;
  $q1 = mysql_query("SELECT * FROM clubs WHERE owner_id='$ownId' AND recycle='$ENOT_RECYCLED'")
    or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < mysql_num_rows($q1); $c++) {
    $f1 = mysql_fetch_array($q1);
    array_push($clubs_data, $f1);
  }
}


function getAllClubs(&$clubs_data)
{
  global $ENOT_RECYCLED;
  $q1 = mysql_query("SELECT * FROM clubs WHERE recycle='$ENOT_RECYCLED'")
    or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < mysql_num_rows($q1); $c++) {
    $f1 = mysql_fetch_array($q1);
    array_push($clubs_data, $f1);
  }
}


function getAllOwners(&$owners)
{
  global $EOWNER;
  global $ENOT_RECYCLED;
  $q = @mysql_query("SELECT * FROM users WHERE priv='$EOWNER' AND recycle='$ENOT_RECYCLED' ORDER BY login ASC") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($owners, $f);
  }
}


function getAllSubadmins(&$subadmins)
{
  global $ESUBADMIN;
  global $ENOT_RECYCLED;
  $q = @mysql_query("SELECT * FROM users WHERE priv='$ESUBADMIN' AND recycle='$ENOT_RECYCLED' ORDER BY login ASC") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($subadmins, $f);
  }
}


function getSubadminUsers($subadminId, &$users)
{
  global $ENOT_RECYCLED;
  global $EOWNER;

  # Get owners under subadmin
  getSubadminOwners($subadminId, $users);

  /*
  # Get owner users
  for ($i = 0; $i < count($owners); ++$i)
  {
    $v = $owners[$i];
    array_push($users, $v);
    
    $ownUsers = array();
    getOwnerUsers($v["id"], $ownUsers);
    {
      for ($j = 0; $j < count($ownUsers); ++$j)
      {
        $v1 = $ownUsers[$j];
        array_push($users, $v1);
      }
    }
  }
  */
}

function getOwnerUsers($ownerId, &$users)
{
  global $ENOT_RECYCLED;
  $q = @mysql_query("SELECT * FROM users WHERE owner_id='$ownerId' AND recycle='$ENOT_RECYCLED' ORDER BY login ASC") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($users, $f);
  }
}


function getAllUsers(&$users)
{
  global $ENOT_RECYCLED;
  $q = @mysql_query("SELECT * FROM users WHERE recycle='$ENOT_RECYCLED'") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    if ($f["priv"] != 0) {
      # Don't push admin
      array_push($users, $f);
    }
  }
}


function getUser($id, &$user)
{
  $res = false;
  $q = @mysql_query("SELECT * FROM users WHERE id='$id'") or die("mysql_query: " . mysql_error());
  if (1 == @mysql_num_rows($q)) {
    $user = @mysql_fetch_array($q);
    $res = true;
  }
  return $res;
}



function getClubTerminals($clubId, &$terminals)
{
  $q1 = mysql_query("SELECT * FROM terminals WHERE club_id='$clubId'")
    or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < mysql_num_rows($q1); $c++) {
    $f1 = mysql_fetch_array($q1);
    array_push($terminals, $f1);
  }
}


function getTerminalData($hwid, &$terminalData)
{
  $hwidHash = getHwidHash($hwid);
  $q = @mysql_query("SELECT * FROM terminals WHERE hwidhash='$hwidHash'");
  if (@mysql_num_rows($q) == 0) {
    # Terminal not found by hash. Try search by hwid
    $q = @mysql_query("SELECT * FROM terminals WHERE hwid='$hwid'");
    if (@mysql_num_rows($q) == 0) {
      return false;
    }
  }
  $terminalData = @mysql_fetch_array($q); // Return value
  return true;
}


function getTerminalDataById($id, &$terminalData)
{
  $q = @mysql_query("SELECT * FROM terminals WHERE id='$id'");
  if (@mysql_num_rows($q) == 0) {
    return false;
  }
  $terminalData = @mysql_fetch_array($q); // Return value
  return true;
}


function setTerminalDataById($id, $td)
{
  $gameset = $td["gameset"];
  $client_version = $td["client_version"];
  $club_id = $td["club_id"];
  $hwid    = $td["hwid"];
  $name    = $td["name"];
  $attrib  = $td["attrib"];
  $recycle = $td["recycle"];
  $hwidhash = $td["hwidhash"];
  $total_in = $td["total_in"];
  $total_out = $td["total_out"];
  $short_in = $td["short_in"];
  $short_out = $td["short_out"];
  $credit  = $td["credit"];
  $status  = $td["status"];
  $access_time = $td["access_time"];
  $settings = $td["settings"];

  @mysql_query("UPDATE birjadb.terminals SET gameset='$gameset', client_version='$client_version' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.terminals SET settings='$settings' club_id='$club_id' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.terminals SET hwid='$hwid', name='$name' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.terminals SET attrib='$attrib', recycle='$recycle' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.terminals SET hwidhash='$hwidhash', total_in='$total_in' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.terminals SET total_out='$total_out', short_in='$short_in' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.terminals SET short_out='$short_out', credit='$credit' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.terminals SET status='$status', access_time='$access_time' WHERE id='$id'");

  //echo "<br>UPDATE birjadb.terminals SET short_out='$short_out', credit='$credit' WHERE id='$id'";

  return true;
}


function setTerminalData($id, $td)
{
  return setTerminalDataById($id, $td);
}


function updateTerminalAccessTime($id)
{
  $curTime = time();
  @mysql_query("UPDATE terminals SET access_time='$curTime' WHERE id='$id'");
}


function updateTerminalStat($id, $credit)
{
  @mysql_query("UPDATE terminals SET credit='$credit' WHERE id='$id'");
}


# Club
function getClubData($id, &$clubData)
{
  //echo "SELECT * FROM birjadb.clubs WHERE id='$id'";
  $q = @mysql_query("SELECT * FROM birjadb.clubs WHERE id='$id'");
  if (@mysql_num_rows($q) == 0) {
    return false;
  }
  $clubData = @mysql_fetch_array($q); // Return value
  return true;
}


function setClubData($id, $d)
{
  $owner_id = $d["owner_id"];
  $total_in = $d["total_in"];
  $total_out = $d["total_out"];
  $short_in = $d["short_in"];
  $short_out = $d["short_out"];
  $name    = $d["name"];
  $attrib  = $d["attrib"];
  $ipaddr  = $d["ipaddr"];
  $deposit = $d["deposit"];
  $use_deposit = $d["use_deposit"];
  $recycle = $d["recycle"];
  $manager_id = $d["manager_id"];
  $last_oper_ts = $d["last_oper_ts"];

  @mysql_query("UPDATE birjadb.clubs SET owner_id='$owner_id', total_in='$total_in' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.clubs SET total_out='$total_out', short_in='$short_in' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.clubs SET short_out='$short_out', name='$name' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.clubs SET attrib='$attrib', ipaddr='$ipaddr' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.clubs SET deposit='$deposit' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.clubs SET recycle='$recycle', manager_id='$manager_id' WHERE id='$id'");
  @mysql_query("UPDATE birjadb.clubs SET last_oper_ts='$last_oper_ts' WHERE id='$id'");
  return true;
}


function markSrvCommand($id)
{
  @mysql_query("UPDATE srvcmd SET sended='1' WHERE id='$id'");
}


function getTerminalSrvCommands($termId, &$res)
{
  $q = @mysql_query("SELECT * FROM srvcmd WHERE term_id='$termId' AND sended='0'");
  for ($i = 0; $i < @mysql_num_rows($q); ++$i) {
    $f = @mysql_fetch_array($q);
    array_push($res, $f);
  }
}


function insertSrvCmd($termid, $cmd, $params)
{
  $prms = urlencode($params);
  $ts = time();
  $query_str = "INSERT INTO srvcmd (cmd, params, term_id, timestamp) VALUES ('$cmd', '$prms', '$termid', '$ts')";
  $q = @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());
}


function getSrvCmd($id, &$data)
{
  //    echo "SELECT * FROM birjadb.srvcmd WHERE id='$id'";
  $q = @mysql_query("SELECT * FROM birjadb.srvcmd WHERE id='$id'");
  if (@mysql_num_rows($q) == 0) {
    return false;
  }
  $data = @mysql_fetch_array($q); // Return value
  return true;
}


function delSrvCmd($id)
{
  $query_str = "DELETE FROM birjadb.srvcmd WHERE id='$id'";
  @mysql_query($query_str);
}


function getClubDataExt($clubId, &$data)
{
  $res = false;
  if (getClubData($clubId, $clubData)) {
    # Get owner login
    $ownerId = $clubData["owner_id"];
    getUserData($ownerId, $ownerData);
    $data["owner_login"] = $ownerData["login"];

    # Get subadmin login 
    $subadminId = $ownerData["subadmin_id"];
    getUserData($subadminId, $subadminData);

    $data["subadmin_login"] = $subadminData["login"];
    $res = true;
  }
  return $res;
}


function getSubadminOwners($subadminId, &$users)
{
  global $EOWNER;
  global $ENOT_RECYCLED;
  $q = @mysql_query("SELECT * FROM users WHERE subadmin_id='$subadminId' AND recycle='$ENOT_RECYCLED' AND priv='$EOWNER' ORDER BY login ASC") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($users, $f);
  }
}


function getSubadminRecycledClubs($subId, &$clubs_data)
{
  global $EOWNER;

  # Get subadmin owners
  $owners = array();
  getSubadminOwners($subId, $owners);

  for ($i = 0; $i < count($owners); ++$i) {
    $v = $owners[$i];
    $ownId = $v["id"];
    $clubs = array();
    getOwnerRecycledClubs($ownId, $clubs);

    for ($j = 0; $j < count($clubs); ++$j) {
      $v1 = $clubs[$j];
      array_push($clubs_data, $v1);
    }
  }
}


function getSubadminRecycledUsers($user_id, &$user_data)
{
  global $ERECYCLED;

  $q = @mysql_query("SELECT * FROM users WHERE recycle='$ERECYCLED' AND subadmin_id='$user_id'") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);

    $f["priv_str"] = priv2str($f["priv"]);
    array_push($user_data, $f);
  }
}


function getOwnerRecycledClubs($ownId, &$clubs_data)
{
  global $ERECYCLED;

  $q1 = mysql_query("SELECT * FROM clubs WHERE owner_id='$ownId' AND recycle='$ERECYCLED'")
    or die("mysql_query: " . mysql_error());

  for ($c = 0; $c < mysql_num_rows($q1); $c++) {
    $f1 = mysql_fetch_array($q1);
    getClubDataExt($f1["id"], $clubData);
    $f1["owner_login"]    = $clubData["owner_login"];
    $f1["subadmin_login"] = $clubData["subadmin_login"];
    array_push($clubs_data, $f1);
  }
}


function getOwnerRecycledUsers($ownId, &$clubs_data)
{
  global $ERECYCLED;

  $q = @mysql_query("SELECT * FROM users WHERE recycle='$ERECYCLED' AND owner_id='$ownId'") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);

    $f["priv_str"] = priv2str($f["priv"]);
    array_push($users, $f);
  }
}


function getAdminRecycledClubs(&$clubs_data)
{
  global $ERECYCLED;

  $q1 = @mysql_query("SELECT * FROM clubs WHERE recycle='$ERECYCLED' ORDER BY name ASC")
    or die("mysql_query: " . mysql_error());

  for ($c = 0; $c < @mysql_num_rows($q1); $c++) {
    $f1 = @mysql_fetch_array($q1);
    getClubDataExt($f1["id"], $clubData);
    $f1["owner_login"]    = $clubData["owner_login"];
    $f1["subadmin_login"] = $clubData["subadmin_login"];
    array_push($clubs_data, $f1);
  }
}


function getAdminRecycledUsers(&$users)
{
  global $ERECYCLED;

  $q = @mysql_query("SELECT * FROM users WHERE recycle='$ERECYCLED'") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    $f["priv_str"] = priv2str($f["priv"]);
    array_push($users, $f);
  }
}


function setUserData($id, $d)
{
  $login    = $d["login"];
  $pass     = $d["pass"];
  $priv     = $d["priv"];
  $subadmin_id = $d["subadmin_id"];
  $attrib   = $d["attrib"];
  $club_id  = $d["club_id"];
  $owner_id = $d["owner_id"];
  $full_name = $d["full_name"];
  $recycle  = $d["recycle"];
  $last_login_time = $d["last_login_time"];
  $settings = $d["settings"];
  $bank     = $d["bank"];

  @mysql_query("UPDATE users SET login='$login', pass='$pass' WHERE id='$id'");
  @mysql_query("UPDATE users SET priv='$priv', subadmin_id='$subadmin_id' WHERE id='$id'");
  @mysql_query("UPDATE users SET attrib='$attrib', club_id='$club_id' WHERE id='$id'");
  @mysql_query("UPDATE users SET owner_id='$owner_id', full_name='$full_name' WHERE id='$id'");
  @mysql_query("UPDATE users SET recycle='$recycle', last_login_time='$last_login_time' WHERE id='$id'");
  @mysql_query("UPDATE users SET settings='$settings', bank='$bank' WHERE id='$id'");
  return true;
}


function getManagerClubs($managerId, &$clubs_data)
{
  global $ENOT_RECYCLED;
  $q1 = @mysql_query("SELECT * FROM clubs WHERE manager_id='$managerId' AND recycle='$ENOT_RECYCLED'")
    or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < @mysql_num_rows($q1); $c++) {
    $f1 = @mysql_fetch_array($q1);
    array_push($clubs_data, $f1);
  }
}


function getOwnerCashiers($ownerId, &$users)
{
  global $ECASHIER;
  global $ENOT_RECYCLED;
  $q = @mysql_query("SELECT * FROM users WHERE priv='$ECASHIER' AND owner_id='$ownerId' AND recycle='$ENOT_RECYCLED' ORDER BY login ASC")
    or die("mysql_query: " . mysql_error());

  for ($c = 0; $c < mysql_num_rows($q); $c++) {
    $f = mysql_fetch_array($q);
    array_push($users, $f);
  }
}


function getOwnerManagers($ownerId, &$users)
{
  global $EMANAGER;
  global $ENOT_RECYCLED;
  $q = @mysql_query("SELECT * FROM users WHERE priv='$EMANAGER' AND owner_id='$ownerId' AND recycle='$ENOT_RECYCLED' ORDER BY login ASC")
    or die("mysql_query: " . mysql_error());

  for ($c = 0; $c < mysql_num_rows($q); $c++) {
    $f = mysql_fetch_array($q);
    array_push($users, $f);
  }
}

function moveTerminalsToRecycle($targ_id, $flag)
{
  $query_str = "UPDATE terminals SET recycle='$flag' WHERE club_id='$targ_id'";
  $q = @mysql_query($query_str);
}


function deleteClubFromDb($targ_id)
{
  # Delete club terminals
  $query_str = "DELETE FROM terminals WHERE club_id='$targ_id'";
  $q = @mysql_query($query_str);

  # Delete club
  $query_str = "DELETE FROM clubs WHERE id='$targ_id'";
  $q = @mysql_query($query_str);
}


function setClubAttrib($targ_id, $targ_attrib)
{
  $query_str = "UPDATE clubs SET attrib='$targ_attrib' WHERE id='$targ_id'";
  $q = @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());

  $query_str = "UPDATE terminals SET attrib='$targ_attrib' WHERE club_id='$targ_id'";
  $q = @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());
}


function createClub($name, $owner_id)
{
  $query_str = "INSERT INTO clubs (name, owner_id, use_deposit) VALUES ('$name', '$owner_id', '1')";
  $q = @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());
  $clubId  = @mysql_insert_id();
  return $clubId;
}


function getUserByLogin($login)
{
  $q = mysql_query("SELECT * FROM users WHERE login='$login'");
  if (mysql_num_rows($q) != 0) {
    return true;
  }
  return false;
}


function createTerminal($ClubId, $hwid, $name)
{
  $sett = "icredit_limit=0;irisk_limit=0;ipercent=0;ibonus_rate=0;gstrategy=0;gcredit_limit=10000;gjackpot_limit=10000;gdouble_limit=10000;g1=1;g2=2;g3=3;g4=4;g5=5;g6=6;g7=7;g8=8;g9=9;g10=10";

  $hwidHash = getHwidHash($hwid);
  $qstr = "INSERT INTO terminals (club_id, hwid, name, settings, hwidhash) VALUES ('$ClubId','$hwid','$name', '$sett', '$hwidHash')";
  $q = @mysql_query($qstr) or die('mysql_query error: ' . mysql_error());
}


function deleteTerminalFromDb($term_id)
{
  $query_str = "DELETE FROM terminals WHERE id='$term_id'";
  $q = @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());
}


function deleteUserFromDb($targ_id)
{
  $query_str = "DELETE FROM users WHERE id='$targ_id'";
  $q = @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());
}


function getAllTerminals(&$terminals)
{
  $q = @mysql_query("SELECT * FROM terminals") or die("mysql_query: " . mysql_error());
  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($terminals, $f);
  }
}


function checkForUserRights($targId)
{
  $user_id   = Session2Id();
  $user_enum = Session2UserEnum();
  if ($user_enum == $GLOBALS["ESUBADMIN"]) {
    # Is $targId under subadmin?
    $subadminUsers = array(); # owners,managers,cashiers under subadmin
    getSubadminUsers($user_id, $subadminUsers);
    getSubadminRecycledUsers($user_id, $subadminUsers);
    if (!isIdValueInArray($targId, $subadminUsers)) {
      KillSess();
    }
    return;
  }

  if ($user_enum == $GLOBALS["EOWNER"]) {
    # Is $targId under owner?
    $ownerUsers = array(); # managers,cashiers under owner
    getOwnerUsers($user_id, $ownerUsers);
    getOwnerRecycledUsers($user_id, $ownerUsers);
    if (!isIdValueInArray($targId, $ownerUsers)) {
      KillSess();
    }
    return;
  }

  if ($user_enum == $GLOBALS["EMANAGER"]) {
    # Is $targId under manager?
    KillSess();
  }

  if ($user_enum == $GLOBALS["ECASHIER"]) {
    # Is $targId under cashier?
    KillSess();
  }
}


function checkForClubRights($targId)
{
  $user_id   = Session2Id();
  $user_enum = Session2UserEnum();
  if ($user_enum == $GLOBALS["ESUBADMIN"]) {
    # Is $targId under subadmin?
    $subadminClubs = array();
    getSubadminClubs($user_id, $subadminClubs);
    getSubadminRecycledClubs($user_id, $subadminClubs);
    if (!isIdValueInArray($targId, $subadminClubs)) {
      KillSess();
    }
    return;
  }

  if ($user_enum == $GLOBALS["EOWNER"]) {
    # Is $targId under owner?
    $ownerClubs = array();
    getOwnerClubs($user_id, $ownerClubs);
    getOwnerRecycledClubs($user_id, $ownerClubs);
    if (!isIdValueInArray($targId, $ownerClubs)) {
      KillSess();
    }
    return;
  }

  if ($user_enum == $GLOBALS["EMANAGER"]) {
    # Is $targId under manager?
    KillSess();
  }

  if ($user_enum == $GLOBALS["ECASHIER"]) {
    # Is $targId under cashier?
    KillSess();
  }
}


# TODO:
# function checkForTerminalRights($targId)


function checkStockCirrularBuffer($companyId)
{
  global $STOCK_POINTS;

  $q = @mysql_query("SELECT * FROM stocks WHERE company_id='$companyId' ORDER BY id ASC");
  $linesCnt = @mysql_num_rows($q);
  if ($linesCnt > ($STOCK_POINTS - 1)) {
    # Delete first lines
    $linesForDeleteCount = 1 + $linesCnt - $STOCK_POINTS;

    # Get line id's for delete
    $lines = array();
    for ($i = 0; $i < $linesForDeleteCount; ++$i) {
      $f = @mysql_fetch_array($q);
      array_push($lines, $f);
    }

    # Delete lines
    for ($i = 0; $i < count($lines); ++$i) {
      $id = $lines[$i]["id"];
      $q = @mysql_query("DELETE FROM stocks WHERE id='$id'");
    }
  }
}


function saveStock($v)
{
  $companyId = $v["companyId"];
  $lastVal   = $v["last"];      # from xml
  $status    = $v["status"];    # from xml
  $sysTime   = $v["sysTimestamp"]; # from xml

  if ($status == "T") {
    # Trading in progress
    # Check for already saved value by time
    $q = @mysql_query("SELECT * FROM stocks WHERE company_id='$companyId' AND system_time='$sysTime'");
    if (@mysql_num_rows($q) == 0) {
      # Value are not saved. Save it in cirrular buffer
      checkStockCirrularBuffer($companyId);
      # Insert new line
      $qstr = "INSERT INTO stocks (company_id, last_val, system_time) VALUES ('$companyId','$lastVal','$sysTime')";
      $q = @mysql_query($qstr);
    }
  } else {
    # Tradings are closed
    # Get last line in db, if empty get from xml
    $q = @mysql_query("SELECT * FROM stocks WHERE company_id='$companyId' ORDER BY id DESC LIMIT 0, 1");
    if (@mysql_num_rows($q)) {
      $f = @mysql_fetch_array($q);
      $lastVal = $f["last_val"];
      $sysTime = $f["system_time"];
    }

    # Get server time in Moscow TZ
    $dt = date('Y-m-d H:i:s');
    $sysTime = strtotime($dt);

    # Generate
    $sign = rand(0, 1);
    $randVal = rand(1000, 2000); # Percents of value
    $addVal = $lastVal / $randVal;
    if ($sign == 0) {
      $lastVal += $addVal;
    } else {
      $lastVal -= $addVal;
    }
    # Value are not saved. Save it in cirrular buffer
    checkStockCirrularBuffer($companyId);
    # Insert new line
    $qstr = "INSERT INTO stocks (company_id, last_val, system_time) VALUES ('$companyId','$lastVal','$sysTime')";
    $q = @mysql_query($qstr);
  }
}


function saveStockRtsi($v)
{
  # Xml values
  $companyId = $v["companyId"];
  $lastVal   = $v["currentValue"];
  $sysTime   = $v["sysTimestamp"];


  $q = @mysql_query("SELECT * FROM stocks WHERE company_id='$companyId' AND system_time='$sysTime'");
  if (@mysql_num_rows($q) == 0) {
    # Value are not saved. Save it in cirrular buffer
    checkStockCirrularBuffer($companyId);
    # Insert new line
    $qstr = "INSERT INTO stocks (company_id, last_val, system_time) VALUES ('$companyId','$lastVal','$sysTime')";
    $q = @mysql_query($qstr);
  } else {
    # Generate value. 
    # Warning: not call frequently
    # Tradings are closed
    # Get last line in db, if empty get from xml
    $q = @mysql_query("SELECT * FROM stocks WHERE company_id='$companyId' ORDER BY id DESC LIMIT 0, 1");
    if (@mysql_num_rows($q)) {
      $f = @mysql_fetch_array($q);
      $lastVal = $f["last_val"];
      $sysTime = $f["system_time"];
    }

    # Get server time in Moscow TZ
    $dt = date('Y-m-d H:i:s');
    $sysTime = strtotime($dt);

    # Generate
    $sign = rand(0, 1);
    $randVal = rand(1000, 2000); # Percents of value
    $addVal = $lastVal / $randVal;
    if ($sign == 0) {
      $lastVal += $addVal;
    } else {
      $lastVal -= $addVal;
    }
    # Value are not saved. Save it in cirrular buffer
    checkStockCirrularBuffer($companyId);
    # Insert new line
    $qstr = "INSERT INTO stocks (company_id, last_val, system_time) VALUES ('$companyId','$lastVal','$sysTime')";
    $q = @mysql_query($qstr);
  }
}



function getCompanyStocks($companyId, &$stocks)
{
  $q = @mysql_query("SELECT * FROM stocks WHERE company_id='$companyId' ORDER BY id ASC");
  for ($i = 0; $i < @mysql_num_rows($q); ++$i) {
    $f = @mysql_fetch_array($q);
    array_push($stocks, $f);
  }
}


function getClubCashLog($clubId, &$cashLog)
{
  # Get total rows count with club_id
  $totalRows = getCashLogRows($clubId);

  # Get offset in rows
  $viewOffset = getCashLogViewOffset($totalRows);


  $q = @mysql_query("SELECT * FROM cashlog WHERE club_id='$clubId' ORDER BY id ASC LIMIT $viewOffset,$totalRows")
    or die("mysql_query: " . mysql_error());

  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($cashLog, $f);
  }
}


function getClubDayCashLog(
  $clubId,
  &$cashLog,
  $dayStartTimstamp,
  $dayEndTimstamp,
  $offs,
  $cnt,
  &$totalRows
) {
  $q = @mysql_query("SELECT * FROM cashlog WHERE (club_id='$clubId') AND (timestamp >= $dayStartTimstamp) AND (timestamp < $dayEndTimstamp) ORDER BY id ASC LIMIT $offs,$cnt")
    or die("mysql_query: " . mysql_error());

  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($cashLog, $f);
  }


  $q = @mysql_query("SELECT COUNT(*) FROM cashlog WHERE (club_id='$clubId') AND (timestamp >= $dayStartTimstamp) AND (timestamp < $dayEndTimstamp)")
    or die("mysql_query: " . mysql_error());
  $row = mysql_fetch_row($q);
  $totalRows = $row[0];
}


function writeToCashLog($clubId, $msg)
{
  $tm = time();
  $query_str = "INSERT INTO birjadb.cashlog (timestamp, club_id, msg) VALUES ('$tm', '$clubId', '$msg')";
  $q = @mysql_query($query_str);
}


function getCashLogRows($clubId)
{
  # Get total rows count with club_id
  $q = @mysql_query("SELECT COUNT(*) FROM cashlog WHERE club_id='$clubId'")
    or die("mysql_query: " . mysql_error());
  $row = mysql_fetch_row($q);
  $totalRows = $row[0];
  return $totalRows;
}


function getCashLogViewOffset($totalRows)
{
  global $CLUBLOG_LINES_TOTAL_VIEW;
  $viewOffset = $totalRows - $CLUBLOG_LINES_TOTAL_VIEW;
  if ($viewOffset < 0) {
    $viewOffset = 0;
  }
  return $viewOffset;
}


function reduceCashLog($clubId)
{
  global $CLUBLOG_LINES_TOTAL_VIEW;
  global $CLUBLOG_LINES_REMOVE_LIMIT;

  # Get total rows count with club_id
  $totalRows = getCashLogRows($clubId);

  # Get offset in rows
  $viewOffset = getCashLogViewOffset($totalRows);

  if ($totalRows > $CLUBLOG_LINES_REMOVE_LIMIT) {
    # Get row id
    $q = @mysql_query("SELECT * FROM cashlog WHERE club_id='$clubId' LIMIT $viewOffset,1")
      or die("mysql_query: " . mysql_error());
    $f = @mysql_fetch_array($q);
    $removeId = $f["id"];

    # Remove rows with id < viewOffset
    $q = @mysql_query("DELETE FROM cashlog WHERE club_id='$clubId' AND (id < $removeId)");
  }
}


function writeToCashLog1($clubId, $msg, $tm)
{
  #reduceCashLog($clubId);

  # Insert new row
  $query_str = "INSERT INTO birjadb.cashlog (timestamp, club_id, msg) VALUES ('$tm', '$clubId', '$msg')";
  $q = @mysql_query($query_str);
}


function reduceTerminalLog($termId)
{
  global $TERMLOG_LINES_TOTAL_VIEW;
  global $TERMLOG_LINES_REMOVE_LIMIT;

  # Get total rows count with termId
  $q = @mysql_query("SELECT COUNT(*) FROM termlog WHERE term_id='$termId'")
    or die("mysql_query: " . mysql_error());
  $row = mysql_fetch_row($q);
  $totalRows = $row[0];

  # Get offset in rows
  $viewOffset = $totalRows - $TERMLOG_LINES_TOTAL_VIEW;
  if ($viewOffset < 0) {
    $viewOffset = 0;
  }

  if ($totalRows > $TERMLOG_LINES_REMOVE_LIMIT) {
    # Get row id
    $q = @mysql_query("SELECT * FROM termlog WHERE term_id='$termId' LIMIT $viewOffset,1")
      or die("mysql_query: " . mysql_error());
    $f = @mysql_fetch_array($q);
    $removeId = $f["id"];

    # Remove rows with id < viewOffset
    $q = @mysql_query("DELETE FROM termlog WHERE term_id='$termId' AND (id < $removeId)");
  }
}

function writeToTerminalLog($termId, $msg, $tm)
{
  #reduceTerminalLog($termId);

  $query_str = "INSERT INTO termlog (timestamp, term_id, msg) VALUES ('$tm', '$termId', '$msg')";
  $q = @mysql_query($query_str);
}




function getTerminalLogRows($termId)
{
  # Get total rows count with term_id
  $q = @mysql_query("SELECT COUNT(*) FROM termlog WHERE term_id='$termId'")
    or die("mysql_query: " . mysql_error());
  $row = mysql_fetch_row($q);
  $totalRows = $row[0];
  return $totalRows;
}


function getTerminalLogViewOffset($totalRows)
{
  global $TERMLOG_LINES_TOTAL_VIEW;
  $viewOffset = $totalRows - $TERMLOG_LINES_TOTAL_VIEW;
  if ($viewOffset < 0) {
    $viewOffset = 0;
  }
  return $viewOffset;
}


function getTerminalCashLog($termId, &$termLog, $offs, $cnt, &$totalRows1)
{
  # Get total rows count of terminal
  $totalRows = getTerminalLogRows($termId);

  # Get offset in rows
  $viewOffset = getTerminalLogViewOffset($totalRows);

  # Viewable rows
  $totalRows1 = $totalRows - $viewOffset;

  $newOffs = $viewOffset + $offs;
  $q = @mysql_query("SELECT * FROM termlog WHERE term_id='$termId' ORDER BY id ASC LIMIT $newOffs,$cnt")
    or die("mysql_query: " . mysql_error());

  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    array_push($termLog, $f);
  }
}

function isTerminalBanned($termData)
{
  $result = false;
  if ($termData["attrib"] != 0) {
    $result = true;
  }
  return $result;
}


function writeToDepositLog($userId, $msg, $tm)
{
  $query_str = "INSERT INTO depositlog (user_id, created_ts, operation) VALUES ('$userId', '$tm', '$msg')";
  $q = @mysql_query($query_str);
}


function getAdminId()
{
  $q = mysql_query("SELECT * FROM users WHERE login='admin'");
  $f = @mysql_fetch_array($q);
  return $f["id"];
}


function getClubUsers($clubData, &$out)
{
  $out["owner_id"] = $clubData["owner_id"];

  $ownerData;
  getUserData($out["owner_id"], $ownerData);

  $out["subadmin_id"] = $ownerData["subadmin_id"];

  # Get 'admin' id
  $q = mysql_query("SELECT * FROM users WHERE login='admin'");
  $f = @mysql_fetch_array($q);
  $out["admin_id"] = getAdminId();
}


function writeDepositLog($clubId, $msg)
{
  $clubData;
  if (getClubData($clubId, $clubData)) {
    $tm = time();
    $ud;
    getClubUsers($clubData, $ud);
    writeToDepositLog($ud["admin_id"], $msg, $tm);
    writeToDepositLog($ud["subadmin_id"], $msg, $tm);
    writeToDepositLog($ud["owner_id"], $msg, $tm);
  }
}


function writeToLegalityLog($email, $date, $term_id)
{
  $tm = time();
  $query_str = "INSERT INTO legalitylog (created_ts, email, date, term_id) VALUES ('$tm', '$email', '$date', '$term_id')";
  $q = @mysql_query($query_str);
}


function getCsvParam($param, $src)
{
  $params = explode(";", $src); //search XXX;YYY;ZZZ
  for ($i = 0; $i < count($params); $i++) {
    $str = explode("=", $params[$i]); //search a=1
    if ($str[0] == $param) {
      $cmd = trim($str[1]);
      return $cmd;
    }
  }
  return ""; //Not found
}


function calculateCash($clubId, $t0, $t1, &$in, &$out)
{
  $q = @mysql_query("SELECT * FROM cashlog WHERE club_id='$clubId' AND timestamp >= $t0 AND timestamp <= $t1")
    or die("mysql_query: " . mysql_error());

  $in = 0;
  $out = 0;
  for ($c = 0; $c < @mysql_num_rows($q); $c++) {
    $f = @mysql_fetch_array($q);
    $msg = $f["msg"];
    $oper = getCsvParam("oper", $msg);
    if ($oper == "addcredit") {
      $in += intval(getCsvParam("addval", $msg));
    }
    if ($oper == "paycredit") {
      $out += intval(getCsvParam("payval", $msg));
    }
  }
}
