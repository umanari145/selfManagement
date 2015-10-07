<?php

require_once( dirname(__FILE__).'/config.php' );
require_once( dirname(__FILE__).'/require_class.php' );

$param = (isset( $_SERVER['REQUEST_URI'] ) && $_SERVER['REQUEST_URI'] !=='' )? $_SERVER['REQUEST_URI']:false;
$params = array();


if (  $param  !== false ) {
    // パラメーターを / で分割
    $params = explode( '/', $param );
}

// 2番目のパラメーターをコントローラーとして取得
$controller = ( !empty( $params[2] ) ) ? $params[2] : 'index';

// 3番目のパラメータをメソッドとして取得
if( isset( $_POST['method']) )
{
    $methodName =$_POST['method'];
}
else
{
    $methodName = ( !empty( $params[3] ) ) ? $params[3] : 'index';
}

//preg_match_allで拡張子を除いた部分を取得
preg_match_all('/^(.*)\.php$/' , $methodName, $arrMethod );

if( !empty($arrMethod[0]) )  $methodName = $arrMethod[1][0];

// 4番目のパラメータをidとして取得
$id = ( !empty( $params[4] ) ) ? $params[4]:'';

// パラメータより取得したコントローラー名によりクラス振分け
$classFile = $controller .'Controller.php';
$classContoroller = $controller .'Controller';
// モデルも読み込む
$modelFile = $controller.'Model.php';

// クラスファイル読込
if ( !is_file( CONTROOL_DIR . $classFile ) ) {
    echo "this controller does not exist";
    exit;
}

require_once( CONTROOL_DIR . $classFile );

//モデル読み込み
if ( !is_file( MODEL_DIR . $modelFile ) ) {
    echo "b";
    echo "this model does not exist";
    exit;
}
require_once( MODEL_DIR .$modelFile );

// インスタンス化したいクラスを引数で渡す
$c = new ReflectionClass( $classContoroller );

$obj = $c->newInstance();
// メソッドを取得
if ( !$c->hasMethod( $methodName ) ) {
    echo "this method does not exist";
    exit;
}

if( $controller !== '' ) $obj->controller = $controller;
if( $methodName !== '' ) $obj->method = $methodName;
if( $id !== '' ) $obj->id = $id;

$method = $c->getMethod( $methodName );
// メソッドを起動
$method->invoke( $obj );
?>
