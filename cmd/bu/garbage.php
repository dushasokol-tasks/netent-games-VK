<?

require_once "../common.php";
seterr();
dbinit();
createGarabageCleanerRow(); # Create if not created yet

echo "Start<br>";

# Get current idx. Get clubs
$garbData;
$res = getGarbageData($garbData);
$idx = $garbData["current_club"];
$list = $garbData["clubslist"];
$clubIndexes = array();
$clubIndexes = explode("-", $list);
echo "IDX=$idx<br>";
for ($i = 0; $i < count($clubIndexes); ++$i) {
  $s = $clubIndexes[$i];
  echo "-->$s<br>";
}


# Process terminal logs in club
$targClubId = $clubIndexes[$idx];
reduceCashLog($targClubId);     # Cash log process
$terminals = array();
getClubTerminals($targClubId, $terminals);
for ($i = 0; $i < count($terminals); ++$i) {
  $termId = $terminals[$i]["id"];
  reduceTerminalLog($termId);   # Terminal log process
}



# Increment idx. Check for club list updating
$idx++; # Next idx
if ($idx >= count($clubIndexes)) {
  $idx = 0;
}
$garbData["current_club"] = $idx;
if (0 == $idx) {
  $garbData["clubslist"] = getClubsListStr();

  echo "Update clubs list<br>";
}

# Save data for next usage
setGarbageData($garbData);
echo "End<br>";
exit();


##############################################################################

function createGarabageCleanerRow()
{
  $garbData;
  $res = getGarbageData($garbData);
  if (false == $res) {
    $s = getClubsListStr();
    $query_str = "INSERT INTO garbagecleaner (clubslist, current_club) VALUES ('$s', '0')";
    @mysql_query($query_str) or die('mysql_query error: ' . mysql_error());
  }
}


function getClubsListStr()
{
  $clubs = array();
  getAllClubs($clubs);

  $res = "";
  for ($i = 0; $i < count($clubs); ++$i) {
    $res = $res . $clubs[$i]["id"];
    $res = $res . "-";
  }
  $res = rtrim($res, "-");
  return $res;
}


function getGarbageData(&$out)
{
  $res = false;
  $q = @mysql_query("SELECT * FROM garbagecleaner") or die("mysql_query: " . mysql_error());
  if (mysql_num_rows($q) != 0) {
    $f = mysql_fetch_array($q);

    $out["current_club"] = $f["current_club"];
    $out["clubslist"]    = $f["clubslist"];
    $res = true;
  }
  return $res;
}


function setGarbageData($data)
{
  $current_club = $data["current_club"];
  $clubslist   = $data["clubslist"];
  @mysql_query("UPDATE garbagecleaner SET current_club='$current_club', clubslist='$clubslist'");
  return true;
}
