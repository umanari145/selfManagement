<?php

define('DB_HOST','localhost');
define('DB_NAME','self_management');
define('DB_USER','root');
define('DB_PASS','');
define('DB_TYPE','mysql');
define('PREFIX','dtb_');


define('URL', 'http://localhost/framework/');
define('TOP_DIR','C:/xampp/');
define('ROOT_DIR', TOP_DIR .'htdocs/');
define('PROJECT_DIR', ROOT_DIR.'framework/');
define('CLASS_FILENAME', PROJECT_DIR . 'require_class.php');
define('CLASS_DIR', PROJECT_DIR . 'class/');
define('MODEL_DIR', PROJECT_DIR . 'model/');
define('CONTROOL_DIR', PROJECT_DIR.'controller/');
define('SMARTY_DIR' , TOP_DIR.'Smarty/libs/' );
define('SMARTY_FILENAME' , 'Smarty.class.php' );
define('JS_DIR' , URL.'js/');
define('CSS_DIR' , URL.'css/' );
define('TEMP_DIR' , PROJECT_DIR .'template/' );
define('CACHE_DIR' , PROJECT_DIR. 'template_c/' );
define('ERROR_CHECK_TYPE', 'PHP');

define('VIEW_ITEM_PER_PAGE',5);
define('MAX_PAGER_LINK_NUM',10);


?>
