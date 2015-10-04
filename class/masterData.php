<?php
class masterData
{ 
   /** SC_Query インスタンス */
    var $objDb = NULL;

    /** デフォルトのテーブルカラム名 */
    var $columns = array('id', 'name', 'rank' );

    /**
     * マスターデータを取得する.
     *
     * 以下の順序でマスターデータを取得する.
     * 1. MASTER_DATA_REALDIR にマスターデータキャッシュが存在しない場合、
     *    DBからマスターデータを取得して、マスターデータキャッシュを生成する。
     * 2. マスターデータキャッシュを読み込み、変数に格納し返す。
     *
     * 返り値は, key => value 形式の配列である.
     *
     * @:tabnew
     *param string $name マスターデータ名
     * @param array $columns [0] => キー, [1] => 表示文字列, [2] => 表示順
     *                        を表すカラム名を格納した配列
     * @return array マスターデータ
     */
    function __construct( $objDb = null)
    {
    	$this->objDb = new PDODatabase( DB_HOST,DB_USER, DB_PASS, DB_NAME, DB_TYPE);
    }
    
    
    function getMasterData($name, $columns = array()) {

    	$masterData = $this->objDb->select($name);
    	$masterData2 = $this->setMasterArray($masterData);
    	
    	return $masterData2;
    }


//    function getMasterDataTree()
//    {
//    	$this->objDb = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//    	$masterData = $this->objDb->select($name);
//    	$masterData2 = $this->setMasterArrayTree($masterData, $name );
//   
//
//    }

//    public function setMasterArrayTree( $masterData, $name)
//    {
//        $masterData2=array();
//
//        for( $i <0;$i<$depth;$i++)
//        {
//            $arrData = $this->getTree( $arrData, $level);
//        }             
//     
//        return $masterData2;
//    }

//    public function getTree( $arrData , $level )
//    { 
//
//        $arrData2=array();
//            
//        foreach( $arrData as $id => $val)
//        {
//                $arrData2[$val['id']] = $val['name'];
//                $arrChild = $this->objDb->select( $name,'','parent_id=?',array($val['id']) )
//                
//                if( $arrChild !== '' && $arrChild !== array() && $arrChild !== false )
//                {
//                    $arrData2['children'] = $arrChild; 
//                }
//        }
//    }
//
//
    function setMasterArray( $masterData )
    {
    	$masterData2 =array();
    	foreach( $masterData as $id => $val )
    	{
    		$masterData2[$val['id']] = $val['name'];
        }
    	
    	return $masterData2;
    	
    }


}

?>
