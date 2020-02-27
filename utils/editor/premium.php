<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <script type="text/javascript" src="/reports/templ/date/jquery-1.6.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="templ/date/premium.css" </head> <script type="text/javascript">
  setInterval(function(){
  $('blink').each(function(){
  $(this).css('visibility' , $(this).css('visibility') === 'hidden' ? '' : 'hidden')
  });
  }, 250);

  setInterval(function(){
  $('blk').each(function(){
  $(this).css('visibility' , $(this).css('visibility') === 'hidden' ? '' : 'hidden')
  });
  }, 500);

  // setInterval(function(){
  $('#premiums').each(function(){
  $(this).css('visibility' , $(this).css('visibility') === 'hidden' ? '' : 'hidden')
  });
  // }, 500);

  setTimeout('window.location.reload()',<? if ($user['1st'] < 0 or $user['2nd'] < 0 or $user['3rd'] < 0) echo "150000";
                                        else echo "10000"; ?>);
  </script>

  <div class="bkgnd">
    <div id="premiums">
      <table cellspacing=50>
        <tr>
          <td colspan=3>
            <h1>TRADER PREMIUMS:</h1>
          </td>
          <? if ($user['1st'] >= 0) {
            if ($user['1st'] > $user['1potThold']) echo "<tr class='pot'><td><blk>1st</blk></td><td><blk>" . ($user['1st'] / 100) . " RUR</blk></td><td><blk>" . ($user['1potThold'] / 100) . "</blk></td>";
            else echo "<tr><td>1rd</td><td>" . ($user['1st'] / 100) . " RUR</td><td>" . ($user['1potThold'] / 100) . "</td>";
          } else echo "<tr class='win'><td><blink>1st</blink></td><td><blink>" . ($user['1st'] / 100) . " RUR</blink></td><td><blink>" . ($user['1potThold'] / 100) . "</blink></td>"; ?>

          <? if ($user['2nd'] >= 0) {
            if ($user['2nd'] > $user['2potThold']) echo "<tr class='pot'><td><blk>2nd</blk></td><td><blk>" . ($user['2nd'] / 100) . " RUR</blk></td><td><blk>" . ($user['2potThold'] / 100) . "</blk></td>";
            else echo "<tr><td>2nd</td><td>" . ($user['2nd'] / 100) . " RUR</td><td>" . ($user['2potThold'] / 100) . "</td>";
          } else echo "<tr class='win'><td><blink>2nd</blink></td><td><blink>" . ($user['2nd'] / 100) . " RUR</blink></td><td><blink>" . ($user['2potThold'] / 100) . "</blink></td>"; ?>

          <? if ($user['3rd'] >= 0) {
            if ($user['3rd'] > $user['3potThold']) echo "<tr class='pot'><td><blk>3rd</blk></td><td><blk>" . ($user['3rd'] / 100) . " RUR</blk></td><td><blk>" . ($user['3potThold'] / 100) . "</blk></td>";
            else echo "<tr><td>3rd</td><td>" . ($user['3rd'] / 100) . " RUR</td><td>" . ($user['3potThold'] / 100) . "</td>";
          } else echo "<tr class='win'><td><blink>3rd</blink></td><td><blink>" . ($user['3rd'] / 100) . " RUR</blink></td><td><blink>" . ($user['3potThold'] / 100) . "</blink></td>"; ?>

          <?
          if ($user['djp_start_hour'] != 0) {
            if ($user['dialy'] >= 0)
              if ($user['dialy'] == 0) echo "<tr><td>Daily</td><td>" . ($user['dialy'] / 100) . " RUR</td><td>" . ($user['dialy_time']) . "</td>";
              else echo "<tr class='pot'><td><blk>Daily</blk></td><td><blk>" . ($user['dialy'] / 100) . " RUR</blk></td><td><blk>" . ($user['dialy'] / 100) . "</blk></td>";
            else echo "<tr class='win'><td><blink>Daily</blink></td><td><blink>" . ($user['dialy'] / 100) . " RUR</blink></td><td><blink>" . ($user['dialy_time']) . "</blink></td>";
          }
          ?>

          <?
          if ($user['1st'] < 0 or $user['2nd'] < 0 or $user['3rd'] < 0 or $user['dialy'] < 0) echo "<tr><td colspan=3 style='color:red;'><blink><h1>" . $client['firstname'] . " " . $client['patronymic'] . " " . $client['lastname'] . "</h1></blink></td>
    <audio src='jpw.ogg' autoplay></audio>;";
          ?>
    </div>
  </div>