<?php
/**
* When functions interface with WP e-Store we put them in here
*/
class C2P_WPeStore {
    public function is_active()
    {
        if(defined('WP_ESTORE_VERSION') && defined('WP_ESTORE_DB_VERSION') )
        {
            return true;
        }    
        return false;
    }
    
    /**
    * Returns an array of purchased_product_id
    * 
    * @param mixed $by
    * @param mixed $email
    * 
    * @returns OBJECT | false - always a Wordpress $wpdb query result
    */
    public function get_purchased_products($by = 'email', $email = false) 
    {
        $table_exists = C2P_WPDB::does_table_exist(WP_ESTORE_DB_CUSTOMERS_TABLE_NAME);
        if(!$table_exists){return false;}
        
        return C2P_WPDB::selectorderby(WP_ESTORE_DB_CUSTOMERS_TABLE_NAME,"email_address = '$email' AND status = 'Paid'",'purchased_product_id','purchased_product_id');
    } 
    
    /**
    * determine if an email address exists in WP e-Store data as a cutomer
    */
    public function get_customer_id_by_email($email_address)
    {                      
        global $wpdb;
        return C2P_WPDB::get_value('id',$wpdb->prefix . 'wp_eStore_customer_tbl',"email_address = '$email_address'");  
    }
}
?>
