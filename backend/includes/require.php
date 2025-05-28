<?php
# file: require.php
# effect: https://localhost/require.php
# incorporate the MySQL connection script;
# 'include' not as good as 'require' in this case
require ('connect_db.php');

# display MYSQL version and host
if(mysqli_ping($dbc)) {
  echo 'MySQL Server' . mysqli_get_server_info($dbc) .
       ' on ' . mysqli_get_host_info($dbc);
}

mysqli_close($dbc);