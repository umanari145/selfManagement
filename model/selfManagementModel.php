<?php

require_once('coreModel.php');

/**
 * @author matsumoto norio
 *
 */
class selfManagementModel extends coreModel{

    function __construct( $modelName )
    {
        parent::__construct();

        $this->setTable( $modelName );
        $this->initParam();
    }

    public function initParam()
    {
        $this->objFormParam->addParam('現在の開始ページNo','page_no','s',array(),1,false);
        $this->objFormParam->addParam('id','id');
        $this->objFormParam->addParam('日報作成日','report_date');
		$this->objFormParam->addParam('ルーティン','checked_routing');		
		$this->objFormParam->addParam('タスク名','task_master_id');
		$this->objFormParam->addParam('作業内容','contents');
		$this->objFormParam->addParam('作業時間','work_time');
		$this->objFormParam->addParam('カロリー','calorie');
		$this->objFormParam->addParam('体重','weight');
		$this->objFormParam->addParam('本日の反省','reflection');		
    }

    public function setParam( $arrData )
    {
        $this->objFormParam->setParam( $arrData );
        $this->objFormParam->trimParam();
    }

    public function getSelfManagementList( $table ='',$col='*' ,$where='', $arrVal=array() ,$sqlOption=array() )
    {
        $SelfManagement_num = $this->getItemCount($table , $where, $arrVal);
                       
        $arrSelfManagement = $this->getItemList( $table, $col, $where, $arrVal, $sqlOption, true, $SelfManagement_num );

        if( $arrSelfManagement !== false )
        {
            return $arrSelfManagement;
        }
        else
        {
            return false;
        }

    }

    public function getSelfManagementDetail( $table, $col='*', $where, $arrVal)
    {
         $SelfManagementDetail = $this->getItemDetail($table, $col, $where, $arrVal);
         
         if( $SelfManagementDetail !== false )
         {
             $this->convParamsFromDB( $SelfManagementDetail );
             return $SelfManagementDetail;
         }
         else
         {
             return false;
         }
         
    }

    public function convParamsFromDB( &$arrParams )
    {
        foreach( $arrParams as $id => $params)
        {
            $arrParams[$id]['skill_language'] =explode("_", $params['skill_language']);
            $date = new DateTime( $params['birth_day']);
            list($arrParams[$id]['birth_year'],$arrParams[$id]['birth_month'], $arrParams[$id]['birth_day']) =explode("-" ,$date->format('Y-n-j'));
        }
    }

    public function checkError()
    {

        $arrErr = $this->objFormParam->checkError();

        $objCheckErr = new CheckError();

        $arrErr2 = $objCheckErr->arrErr;
 
        $arrErr = array_merge( $arrErr, $arrErr2 );

        return $arrErr;
    }


    public function registSelfManagement()
    {
        $arrParams = $this->objFormParam->getDbArray();
		list( $reportParams , $taskParams ) = $this->splitParams( $arrParams );

        //idあればupdateそうでなければinsert
        $mode = (isset( $arrParams['id']) && $arrParams['id'] !== '' ) ? 'update' : 'insert';

        $where ='';
        $arrWhereVal = array();

        switch( $mode )
        {
        case 'update':
            $where =' id = ? ';
            $arrWhereVal = array( $arrParams['id']);
            break;
            case 'insert';
        default:
            break;
        }

        $res1 = $this->registItem( $mode, "dtb_daily_report", $reportParams, $where, $arrWhereVal );
		$report_id = $this->objDb->getLastId();
		
		if( $mode === "insert" ) {
			foreach( $taskParams as $no=>$params){
					$taskParams[$no]["report_id"]= $report_id;
			}
		}

		foreach( $taskParams as $param){
			$res1 = $this->registItem( $mode, "dtb_task_table", $param, $where, $arrWhereVal );
		}
		
		echo ( $res === true )?'success!':'failed!';

    }

	private function splitParams( $arrParams ){
	
		$reportColumns = array( 'report_date','checked_routing','calorie','weight','reflection');		
		$taskColumns = array('task_master_id','contents','work_time');
	
		$reportParams = array();
		$taskParams = array();		
		
		foreach( $arrParams as $fieldName => $val ){
			if( in_array( $fieldName , $reportColumns )){
				$reportParams[$fieldName] = $val;
			}
		
			if( in_array( $fieldName , $taskColumns )){
				$taskParams[$fieldName] = $val;
			}
		}

		$reportParams['checked_routing'] = implode("_",$reportParams['checked_routing']);		
		//縦横の配列を変える
		$taskParams = utility::sfSwapArray( $taskParams);	
		return array( $reportParams , $taskParams );
	}
}
?>
