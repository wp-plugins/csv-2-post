<?php
/*   Column Array Example Returned From "mysql_query("SHOW COLUMNS FROM..."
        
          array(6) {
            [0]=>
            string(5) "rowid"
            [1]=>
            string(7) "int(11)"
            [2]=>
            string(2) "NO"
            [3]=>
            string(3) "PRI"
            [4]=>
            NULL
            [5]=>
            string(14) "auto_increment"
          }
                  
    +------------+----------+------+-----+---------+----------------+
    | Field      | Type     | Null | Key | Default | Extra          |
    +------------+----------+------+-----+---------+----------------+
    | Id         | int(11)  | NO   | PRI | NULL    | auto_increment |
    | Name       | char(35) | NO   |     |         |                |
    | Country    | char(3)  | NO   | UNI |         |                |
    | District   | char(20) | YES  | MUL |         |                |
    | Population | int(11)  | NO   |     | 0       |                |
    +------------+----------+------+-----+---------+----------------+            
*/
      
$csv2post_tables_array =  array();
##################################################################################
#                               csv2post_log                                     #
##################################################################################        
$csv2post_tables_array['tables']['csv2post_log']['name'] = 'csv2post_log';
$csv2post_tables_array['tables']['csv2post_log']['required'] = false;// required for all installations or not (boolean)
$csv2post_tables_array['tables']['csv2post_log']['usercreated'] = false;// if the table is created as a result of user actions rather than core installation put true
$csv2post_tables_array['tables']['csv2post_log']['version'] = '6.9.6';// used to trigger updates
$csv2post_tables_array['tables']['csv2post_log']['primarykey'] = 'rowid';
$csv2post_tables_array['tables']['csv2post_log']['uniquekey'] = 'rowid';
// csv2post_log - rowid
$csv2post_tables_array['tables']['csv2post_log']['columns']['rowid']['type'] = 'int(11)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['rowid']['null'] = 'NOT NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['rowid']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['rowid']['default'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['rowid']['extra'] = 'AUTO_INCREMENT';
// csv2post_log - outcome
$csv2post_tables_array['tables']['csv2post_log']['columns']['outcome']['type'] = 'tinyint(1)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['outcome']['null'] = 'NOT NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['outcome']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['outcome']['default'] = '1';
$csv2post_tables_array['tables']['csv2post_log']['columns']['outcome']['extra'] = '';
// csv2post_log - timestamp
$csv2post_tables_array['tables']['csv2post_log']['columns']['timestamp']['type'] = 'timestamp';
$csv2post_tables_array['tables']['csv2post_log']['columns']['timestamp']['null'] = 'NOT NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['timestamp']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['timestamp']['default'] = 'CURRENT_TIMESTAMP';
$csv2post_tables_array['tables']['csv2post_log']['columns']['timestamp']['extra'] = '';
// csv2post_log - line
$csv2post_tables_array['tables']['csv2post_log']['columns']['line']['type'] = 'int(11)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['line']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['line']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['line']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['line']['extra'] = '';
// csv2post_log - file
$csv2post_tables_array['tables']['csv2post_log']['columns']['file']['type'] = 'varchar(250)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['file']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['file']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['file']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['file']['extra'] = '';
// csv2post_log - function
$csv2post_tables_array['tables']['csv2post_log']['columns']['function']['type'] = 'varchar(250)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['function']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['function']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['function']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['function']['extra'] = '';
// csv2post_log - sqlresult
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlresult']['type'] = 'blob';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlresult']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlresult']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlresult']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlresult']['extra'] = '';
// csv2post_log - sqlquery
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlquery']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlquery']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlquery']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlquery']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlquery']['extra'] = '';
// csv2post_log - sqlerror
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlerror']['type'] = 'mediumtext';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlerror']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlerror']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlerror']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['sqlerror']['extra'] = '';
// csv2post_log - wordpresserror
$csv2post_tables_array['tables']['csv2post_log']['columns']['wordpresserror']['type'] = 'mediumtext';
$csv2post_tables_array['tables']['csv2post_log']['columns']['wordpresserror']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['wordpresserror']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['wordpresserror']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['wordpresserror']['extra'] = '';
// csv2post_log - screenshoturl
$csv2post_tables_array['tables']['csv2post_log']['columns']['screenshoturl']['type'] = 'varchar(500)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['screenshoturl']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['screenshoturl']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['screenshoturl']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['screenshoturl']['extra'] = '';
// csv2post_log - userscomment
$csv2post_tables_array['tables']['csv2post_log']['columns']['userscomment']['type'] = 'mediumtext';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userscomment']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userscomment']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userscomment']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userscomment']['extra'] = '';
// csv2post_log - page
$csv2post_tables_array['tables']['csv2post_log']['columns']['page']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['page']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['page']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['page']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['page']['extra'] = '';
// csv2post_log - version
$csv2post_tables_array['tables']['csv2post_log']['columns']['version']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['version']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['version']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['version']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['version']['extra'] = '';
// csv2post_log - panelid
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelid']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelid']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelid']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelid']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelid']['extra'] = '';
// csv2post_log - panelname
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelname']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelname']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelname']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelname']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['panelname']['extra'] = '';
// csv2post_log - tabscreenid
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenid']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenid']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenid']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenid']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenid']['extra'] = '';
// csv2post_log - tabscreenname
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenname']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenname']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenname']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenname']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['tabscreenname']['extra'] = '';
// csv2post_log - dump
$csv2post_tables_array['tables']['csv2post_log']['columns']['dump']['type'] = 'longblob';
$csv2post_tables_array['tables']['csv2post_log']['columns']['dump']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['dump']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['dump']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['dump']['extra'] = '';
// csv2post_log - ipaddress
$csv2post_tables_array['tables']['csv2post_log']['columns']['ipaddress']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['ipaddress']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['ipaddress']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['ipaddress']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['ipaddress']['extra'] = '';
// csv2post_log - userid
$csv2post_tables_array['tables']['csv2post_log']['columns']['userid']['type'] = 'int(11)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userid']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userid']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userid']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['userid']['extra'] = '';
// csv2post_log - comment
$csv2post_tables_array['tables']['csv2post_log']['columns']['comment']['type'] = 'mediumtext';
$csv2post_tables_array['tables']['csv2post_log']['columns']['comment']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['comment']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['comment']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['comment']['extra'] = '';
// csv2post_log - type
$csv2post_tables_array['tables']['csv2post_log']['columns']['type']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['type']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['type']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['type']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['type']['extra'] = '';
// csv2post_log - category
$csv2post_tables_array['tables']['csv2post_log']['columns']['category']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['category']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['category']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['category']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['category']['extra'] = '';
// csv2post_log - action
$csv2post_tables_array['tables']['csv2post_log']['columns']['action']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['action']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['action']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['action']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['action']['extra'] = '';
// csv2post_log - priority
$csv2post_tables_array['tables']['csv2post_log']['columns']['priority']['type'] = 'varchar(45)';
$csv2post_tables_array['tables']['csv2post_log']['columns']['priority']['null'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['priority']['key'] = '';
$csv2post_tables_array['tables']['csv2post_log']['columns']['priority']['default'] = 'NULL';
$csv2post_tables_array['tables']['csv2post_log']['columns']['priority']['extra'] = '';
?>