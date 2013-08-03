<?php 
/**
* Used in admin page headers to constantly check the plugins status while administrator logged in 
*/
function csv2post_diagnostics_constant_adminside(){
    if(is_admin() && current_user_can( 'manage_options' )){
        
        // we won't run diagnostics during any POST processing
        // we won't run diagnostics during any GET processing
        if((!isset($_POST) || !$_POST) && !isset($_GET['csv2postprocsub'])){

            ###########################################################################################
            #                              PEFORM EXTENSION DIAGNOSTICS                               #
            ###########################################################################################
            if(WTG_C2P_EXTENSIONS != 'disable' && file_exists(WP_CONTENT_DIR . '/csv2postextensions')){
                $current_extension_name = 'df1'; 
                if(csv2post_extension_activation_status($current_extension_name) == 3){
                    if(file_exists(WP_CONTENT_DIR . '/csv2postextensions/'.$current_extension_name.'/functions/diagnostics.php')){
                        
                        require_once(WP_CONTENT_DIR . '/csv2postextensions/'.$current_extension_name.'/functions/diagnostics.php');            
                    }
                }
            }
     
            ###########################################################################################
            #                                PEFORM CORE DIAGNOSTICS                                  #
            ###########################################################################################                    
            // core database tables
            global $csv2post_tables_array;# core tables
            csv2post_diagnostics_databasecomparison_alertonly($csv2post_tables_array);
        }   
    }
}

/**
* Uses database table arrays to check if any installed tables have not been updated yet 
*/
function csv2post_diagnostics_databasecomparison_alertonly($expected_tables_array){
    if(is_array($expected_tables_array)){
        // loop through plugins tables
        foreach($expected_tables_array['tables'] as $key => $table){
            
            if(!$table['required'] && !csv2post_WP_SQL_does_table_exist($table['name'])){
                return false;
            }
                                            
            // is table required and exist?
            if($table['required'] && !csv2post_WP_SQL_does_table_exist($table['name'])){
                csv2post_n('Database Table Missing','CSV 2 POST diagnostic
                indicates a required database table is missing. This must be dealt with before the
                plugin is used. The table name is <strong>' . $table['name'] .'</strong> and you can install it manually
                on the plugins installation screens. WebTechGlobal is happy to help you.','error','Small',array());
                return false;    
            }
 
            ###############################################
            #               COLUMN COMPARISON             #
            ###############################################            
            $installed_table_array = csv2post_WP_SQL_get_tablecolumns($table['name'],true,true);

            foreach($table['columns'] as $something => $somethingelse){
                $column_found = false;
 
                foreach($installed_table_array as $installedCol){
                    if($installedCol == $something){
                        $column_found = true;
                    }
                }
                
                if(!$column_found){
                    csv2post_n('Database Update Required','The database table named <strong>'.$table['name'].'</strong> needs to be updated. A column
                    named <strong>'.$something.'</strong> must be added to it. This is a requirement in the latest version of the plugin. You can
                    perform this update on the installation screens.','error','Small');
                    return false;
                }
            }

            ###############################################
            #               PRECISE COMPARISON            #
            ###############################################   
            $installed_table_array = csv2post_WP_SQL_get_tablecolumns($table['name'],true);
                     
            // loop through the current tables array of columns
            foreach($installed_table_array as $key => $column){
                
                $columnName = $column[0];

                // Type
                // remove "unsigned" first,we are not checking for that right now
                $installed_column = str_replace(' unsigned','',$column[1]);# example: int(10) unsigned
                if($installed_column != $table['columns'][$columnName]['type']){
                    csv2post_n('Database Table Update Required','The plugins database table named <strong>'.$table['name'].'</strong>
                    needs to be updated. The column type for column named <strong>' . $columnName .'</strong> does not
                    match the current version of files installed. Please use the installation tools provided
                    to update the table manually. Seek support from WebTechGlobal if unsure.','error','Small');
                    return false;      
                }
               
                // Null (mysql returns NO or YES but the CREATE query requires NOT NULL or no value at all)
                if($column[2] == 'NO' && $table['columns'][$columnName]['null'] != 'NOT NULL'
                || $column[2] == 'YES' && $table['columns'][$columnName]['null'] != ''){ 
                    csv2post_n('Database Table Update Required','The plugins database table named <strong>'.$table['name'].'</strong>
                    needs to be updated. The "null" setting for column named <strong>' . $columnName .'</strong> does not
                    match the current version of files installed. Please use the installation tools provided
                    to update the table manually. Seek support from WebTechGlobal if unsure.','error','Small');
                    return false;  
                }

                // Key - $column[3] - this wont change after database design so no check required
 
                // Default
                if(!$column[4] && $table['columns'][$columnName]['default'] != 'NULL' && $table['columns'][$columnName]['default'] != '' && $column[3] != 'PRI'){ 
                    csv2post_n('Database Table Update Required','The plugins database table named <strong>'.$table['name'].'</strong>
                    needs to be updated. The "default" value setting for column named <strong>' . $columnName .'</strong> does not
                    match the current version of files installed. Please use the installation tools provided
                    to update the table manually. Seek support from WebTechGlobal if unsure.','error','Small'); 
                    return false; 
                }
                
                // Extra - installed returns lowercase while CREATE table query has uppercase
                $installed = strtolower($column[5]);
                $expected = strtolower($table['columns'][$columnName]['extra']);
                if($installed != $expected){ 
                    csv2post_n('Database Table Update Required','The plugins database table named <strong>'.$table['name'].'</strong>
                    needs to be updated. Configuration for the column named <strong>' . $columnName .'</strong> does not
                    match the current version of files installed. Please use the installation tools provided
                    to update the table manually. Seek support from WebTechGlobal if unsure.','error','Small');
                    return false;  
                }             
            }
        }
    }     
}
?>
