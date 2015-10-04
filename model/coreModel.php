<?php

class coreModel
{
    public $objDb = NULL;
    public $objFormParam = NULL;
    public $objPage = NULL;
    public $prefix = PREFIX;
    public $table ='';

    public function __construct()
    {
         //必須クラスの読み込み
         $this->objDb = new PDODatabase( DB_HOST,DB_USER, DB_PASS, DB_NAME, DB_TYPE);
         $this->objFormParam = new formParam(); 
    }

    public function setTable($modelName )
    {
        $this->table = $this->prefix . $modelName;
    }

    public function getItemCount( $table = '', $where='', $arrVal=array())
    {
       return $this->objDb->count( $table, $where, $arrVal);
    }


    public function getItemList( $table ='', $col='*' , $where='', $arrVal=array(), $sqlOption=array(), $pager_flg=true, $item_num=0)
    {
        //ページャーを実装する場合
        if( $pager_flg === true )
        {
             $page_no = $this->objFormParam->getValue('page_no');
             $objPage = new pageNavi( $page_no , $item_num ,VIEW_ITEM_PER_PAGE ,'',MAX_PAGER_LINK_NUM,'', true);
             $this->objPage = $objPage;
             $sqlOption['limit'] = VIEW_ITEM_PER_PAGE;
             $sqlOption['offset'] = $objPage->start_row;
        }
      
       $arrItems = $this->objDb->select( $table, $col, $where, $arrVal, $sqlOption);
       return ( $arrItems !== false && $arrItems !== '' && $arrItems !== array() )? $arrItems:false;

    }

    public function getItemDetail( $table, $col='*', $where, $arrVal, $sqlOption = array())
    {
       $itemDetail = $this->objDb->select( $table, $col, $where, $arrVal, $sqlOption);
       return ( $itemDetail !== false && $itemDetail !== '' && $itemDetail !== array() )? $itemDetail:false;
    }

    public function registItem( $mode,$table, $sqlVal, $where ='', $arrWhereVal =array() )
    {
        //更新
        switch( $mode )
        {
        case 'insert':
           $res = $this->objDb->insert( $table, $sqlVal );
           break;

        case 'update':
           $res = $this->objDb->update( $table , $sqlVal, $where, $arrWhereVal);
           break;
        }

        return $res;

    }

    public function deleteItem( $table, $where, $arrWhereVal )
    {
        $sqlVal=array('del_flg'=>1);
        $res = $this->objDb->update( $table, $sqlVal, $where, $arrWhereVal);
        
        return $res;
    }

    public function getFormItemList()
    {
        return  $this->objFormParam->getFormParamList();
    
    }

}

?>
