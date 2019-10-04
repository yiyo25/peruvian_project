<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '172.16.1.4';
$db['default']['username'] = 'cco_test';
$db['default']['password'] = 'peruvian2825';
$db['default']['database'] = 'db_cco';
$db['default']['dbdriver'] = 'mssql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


$db['pasarela']['hostname'] = "localhost";
$db['pasarela']['username'] = "userweb";
$db['pasarela']['password'] = "#Peru*31x";
$db['pasarela']['database'] = "db_pasarela";
$db['pasarela']['dbdriver'] = "mysqli";
$db['pasarela']['dbprefix'] = "";
$db['pasarela']['pconnect'] = TRUE;
$db['pasarela']['db_debug'] = FALSE;
$db['pasarela']['cache_on'] = FALSE;
$db['pasarela']['cachedir'] = "";
$db['pasarela']['char_set'] = "utf8";
$db['pasarela']['dbcollat'] = "utf8_general_ci";
$db['pasarela']['swap_pre'] = "";
$db['pasarela']['autoinit'] = TRUE;
$db['pasarela']['stricton'] = FALSE;



$db['db_admin']['hostname'] = "localhost";
$db['db_admin']['username'] = "userweb";
$db['db_admin']['password'] = "#Peru*31x";
$db['db_admin']['database'] = "db_admin";
$db['db_admin']['dbdriver'] = "mysqli";
$db['db_admin']['dbprefix'] = "";
$db['db_admin']['pconnect'] = TRUE;
$db['db_admin']['db_debug'] = FALSE;
$db['db_admin']['cache_on'] = FALSE;
$db['db_admin']['cachedir'] = "";
$db['db_admin']['char_set'] = "utf8";
$db['db_admin']['dbcollat'] = "utf8_general_ci";
$db['db_admin']['swap_pre'] = "";
$db['db_admin']['autoinit'] = TRUE;
$db['db_admin']['stricton'] = FALSE;


$db['db_admin2']['hostname'] = "localhost";
$db['db_admin2']['username'] = "userweb";
$db['db_admin2']['password'] = "#Peru*31x";
$db['db_admin2']['database'] = "db_admin2";
$db['db_admin2']['dbdriver'] = "mysqli";
$db['db_admin2']['dbprefix'] = "";
$db['db_admin2']['pconnect'] = TRUE;
$db['db_admin2']['db_debug'] = FALSE;
$db['db_admin2']['cache_on'] = FALSE;
$db['db_admin2']['cachedir'] = "";
$db['db_admin2']['char_set'] = "utf8";
$db['db_admin2']['dbcollat'] = "utf8_general_ci";
$db['db_admin2']['swap_pre'] = "";
$db['db_admin2']['autoinit'] = TRUE;
$db['db_admin2']['stricton'] = FALSE;



/* End of file database.php */
/* Location: ./application/config/database.php */