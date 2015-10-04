<?php
require_once('coreController.php');

/**
 * @author matsumoto norio
 *
 */
class selfManagementController extends coreController{

	//親属性の継承
	public function __construct()
	{
        parent::__construct();

        //親には書けないのでここに書く
        $this->model = new selfManagementModel( 'selfManagement');
		$objMaster = new masterData();
        $this->smarty->assign( 'arrTaskContents', $objMaster->getMasterData('mtb_task_contents') );
		$this->smarty->assign( 'arrRoutingContents',$objMaster->getMasterData('mtb_checked_routing_contents'));
	}

    public function index()
    {
        parent::index();
                
        if( isset($this->id) && $this->id !=='' )
        {
            $page_no = $this->id;
            $this->model->objFormParam->setValue('page_no', $page_no );
        }
        
        $arrDailyReports = $this->model->getSelfManagementList( 'dtb_daily_report','*','',array() );

		$this->smarty->assign( 'arrDailyReports' , $arrDailyReports );
        $this->smarty->assign( 'arrPagenavi' , $this->model->objPage->arrPagenavi );
        $this->smarty->assign( 'current_page_message' , $this->model->objPage->current_page_message );
      	$this->render(__FUNCTION__);

    }

    public function view( $id = '')
    {
        parent::view();
        $id = $this->id;
        $arrData = $this->model->getMemberDetail('dtb_member','*','member_id= ?' ,array( $id ));
        $this->model->setParam( $arrData[0]);
        $this->smarty->assign( 'arrForm', $this->model->getFormItemList() );
        $this->render(__FUNCTION__);

    }

    public function regist()
    {
        parent::regist();

        switch( $this->getMode() )
        {
        case 'confirm':
        	$arrErr = $this->model->checkError();
            
            if( $arrErr === array() )
            {
				$this->model->registSelfManagement();
				$this->render('complete');
            }
			else
            {
                $this->smarty->assign( 'arrForm', $this->model->getFormItemList() );
                $this->smarty->assign( 'arrErr' ,$arrErr );
                $this->render(__FUNCTION__);
            }
            break;
        case 'back':
        default:
            $this->smarty->assign( 'arrForm', $this->model->getFormItemList() );
            $this->render(__FUNCTION__);
            break;
        }

    }
    
    public function edit( $id ='')
    {
        parent::edit();
        $id = $this->id;
        $arrData = $this->model->getMemberDetail('dtb_member','*','member_id= ?' ,array( $id ));
        $this->model->setParam( $arrData[0]);
        $this->smarty->assign( 'arrForm', $this->model->getFormItemList() );
        $this->render('regist');
    }

    public function delete( $id ='')
    {
        $id = $this->id;
        $res = $this->model->deleteItem( 'dtb_member', 'member_id = ? ',array($id ));
        echo ($res === true )? 'success' : 'failed';
    }

}

?>
