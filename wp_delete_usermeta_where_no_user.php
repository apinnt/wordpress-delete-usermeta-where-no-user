<?php

/* 
 * 2019
 * Used to check if user exists for the usermeta data. If it doesn't, find all usermeta with that ID and delete it
 * WordPress only
 * 
 */


error_reporting(E_ALL);
ini_set('display_errors', 1);


/** The name of the database for WordPress */
define('DB_NAME', 'DB');
/** MySQL database username */
define('DB_USER', 'user');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'host');

///DB connection
global $mysqli;
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$mysqli->set_charset("utf8");


$get_data = $mysqli->query("SELECT DISTINCT user_id FROM usermeta ORDER BY umeta_id ASC");

$delete_data = true;

while($data = $get_data->fetch_array()) {
    $check_user_table = $mysqli->query("SELECT ID FROM users WHERE ID='".$data['user_id']."'");
    $exists = $check_user_table->num_rows;
    ///if no records
    if ($exists == '0') {
        if ($delete_data == true) {
            $delete_data_query = $mysqli->query("DELETE FROM usermeta WHERE user_id='".$data['user_id']."'");
        }
        print 'Delete '.$data['user_id'].'<br />';
    } else {
        print 'No delete '.$data['user_id'].'<br />';
    }
}
