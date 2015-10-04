<?php

/** クラスファイルを読み込む **/
function autoload_classes( $class ) {
    include CLASS_DIR . $class . '.php';
}

spl_autoload_register('autoload_classes');

