<?php
// 0. Select CSV File
$csv2post_eci_array['steps'][0]['name'] = 'Select CSV File';
$csv2post_eci_array['steps'][0]['complete'] = false;
$csv2post_eci_array['steps'][0]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][0]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_0.php';
$csv2post_eci_array['steps'][0]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_0.php';

// 1, User Confirms CSV File Format
$csv2post_eci_array['steps'][1]['name'] = 'Confirm CSV File Format';
$csv2post_eci_array['steps'][1]['complete'] = false;
$csv2post_eci_array['steps'][1]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][1]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_1.php';
$csv2post_eci_array['steps'][1]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_1.php';

// 2. Test CSV File to ensure format is correct by displaying a table and stats
$csv2post_eci_array['steps'][2]['name'] = 'Test CSV File';
$csv2post_eci_array['steps'][2]['complete'] = false;
$csv2post_eci_array['steps'][2]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][2]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_2.php';
$csv2post_eci_array['steps'][2]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_2.php';
              
// 3. Import Data
$csv2post_eci_array['steps'][3]['name'] = 'Import Data';
$csv2post_eci_array['steps'][3]['complete'] = false;
$csv2post_eci_array['steps'][3]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][3]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_3.php';
$csv2post_eci_array['steps'][3]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_3.php';

// 4. Select Content Template
$csv2post_eci_array['steps'][4]['name'] = 'Select Content Template';
$csv2post_eci_array['steps'][4]['complete'] = false;
$csv2post_eci_array['steps'][4]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][4]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_4.php';
$csv2post_eci_array['steps'][4]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_4.php';

// 5. Select Title Template
$csv2post_eci_array['steps'][5]['name'] = 'Select Title Template';
$csv2post_eci_array['steps'][5]['complete'] = false;
$csv2post_eci_array['steps'][5]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][5]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_5.php';
$csv2post_eci_array['steps'][5]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_5.php';

// 6. SEO
$csv2post_eci_array['steps'][6]['name'] = 'SEO';
$csv2post_eci_array['steps'][6]['complete'] = false;
$csv2post_eci_array['steps'][6]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][6]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_6.php';
$csv2post_eci_array['steps'][6]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_6.php';

// 7. Post Types
$csv2post_eci_array['steps'][7]['name'] = 'Post Types';
$csv2post_eci_array['steps'][7]['complete'] = false;
$csv2post_eci_array['steps'][7]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][7]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_7.php';
$csv2post_eci_array['steps'][7]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_7.php';

// 8. Post Dates
$csv2post_eci_array['steps'][8]['name'] = 'Post Dates';
$csv2post_eci_array['steps'][8]['complete'] = false;
$csv2post_eci_array['steps'][8]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][8]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_8.php';
$csv2post_eci_array['steps'][8]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_8.php';

// 9. Custom Fields          
$csv2post_eci_array['steps'][9]['name'] = 'Custom Fields';
$csv2post_eci_array['steps'][9]['complete'] = false;
$csv2post_eci_array['steps'][9]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][9]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_9.php';
$csv2post_eci_array['steps'][9]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_9.php';

// 10. Categories
$csv2post_eci_array['steps'][10]['name'] = 'Categories';
$csv2post_eci_array['steps'][10]['complete'] = false;
$csv2post_eci_array['steps'][10]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][10]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_10.php';
$csv2post_eci_array['steps'][10]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_10.php';

// 11. Post Updating
$csv2post_eci_array['steps'][11]['name'] = 'Post Updating';
$csv2post_eci_array['steps'][11]['complete'] = false;
$csv2post_eci_array['steps'][11]['free'] = false;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][11]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_11.php';
$csv2post_eci_array['steps'][11]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_11.php';

// 12. Images
$csv2post_eci_array['steps'][12]['name'] = 'Images';
$csv2post_eci_array['steps'][12]['complete'] = false;
$csv2post_eci_array['steps'][12]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][12]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_12.php';
$csv2post_eci_array['steps'][12]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_12.php';

// 13. Tags
$csv2post_eci_array['steps'][13]['name'] = 'Tags';
$csv2post_eci_array['steps'][13]['complete'] = false;
$csv2post_eci_array['steps'][13]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][13]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_13.php';
$csv2post_eci_array['steps'][13]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_13.php';

// 14. Text Spinning
$csv2post_eci_array['steps'][14]['name'] = 'Text Spinning';
$csv2post_eci_array['steps'][14]['complete'] = false;
$csv2post_eci_array['steps'][14]['free'] = false;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][14]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_14.php';
$csv2post_eci_array['steps'][14]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_14.php';

// 15. Data Updating
$csv2post_eci_array['steps'][15]['name'] = 'Data Updating';
$csv2post_eci_array['steps'][15]['complete'] = false;
$csv2post_eci_array['steps'][15]['free'] = false;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][15]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_15.php';
$csv2post_eci_array['steps'][15]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_15.php';

// 16. Authors
$csv2post_eci_array['steps'][16]['name'] = 'Authors';
$csv2post_eci_array['steps'][16]['complete'] = false;
$csv2post_eci_array['steps'][16]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][16]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_16.php';
$csv2post_eci_array['steps'][16]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_16.php';

// 17. Theme Support
$csv2post_eci_array['steps'][17]['name'] = 'Theme Support';
$csv2post_eci_array['steps'][17]['complete'] = false;
$csv2post_eci_array['steps'][17]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][17]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_17.php';
$csv2post_eci_array['steps'][17]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_17.php';

// 18. Create Posts
$csv2post_eci_array['steps'][18]['name'] = 'Create Posts';
$csv2post_eci_array['steps'][18]['complete'] = false;// used to decide the step user is on 
$csv2post_eci_array['steps'][18]['free'] = true;// true indicates step is free, false indicates step is in paid edition only
$csv2post_eci_array['steps'][18]['panelurlpaid'] = WTG_C2P_DIR . 'fulledition/panels/easycsvimporter/csv2post_panel_eci_18.php';
$csv2post_eci_array['steps'][18]['panelurlfree'] = WTG_C2P_PANELFOLDER_PATH . 'easycsvimporter/csv2post_panel_eci_18.php';
?>