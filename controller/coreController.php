<?php

/**
 * @author matsumoto norio
 *
 */
class coreController{

	public $smarty       = NULL;
    public $main_template_filename='';

	//設定の読み込み
	public  function __construct()
	{
		 //必要ファイルの読み込み
         require_once( SMARTY_DIR . SMARTY_FILENAME );
         require_once( CLASS_FILENAME );

         $this->smarty = new Smarty();
         
         $this->main_template_filename='main.tpl';
         
         //キャッシュディレクトリ、コンパイルディレクトリの読み込み
         $this->smarty->template_dir = TEMP_DIR;
         $this->smarty->compile_dir  = CACHE_DIR;
         // $this->smarty->debugging = true;

    }

    public function index()
    {
        $this->smarty->assign( 'controller', $this->controller );
    }

    public function regist()
    {
        $this->model->setParam( $_POST );
        $this->smarty->assign( 'controller', $this->controller );
        $this->smarty->assign( 'method', $this->method );
    }

    public function view( $id ='')
    {
        $this->smarty->assign( 'controller', $this->controller );
    }

    public function edit( $id ='')
    {
        $this->smarty->assign( 'controller', $this->controller ); 
        $this->smarty->assign( 'method', $this->method );
    }

    public function delete()
    {
    
    }

    
    public function getMode()
    {
        $mode ='';
        if( isset( $_POST['mode']) && $_POST['mode'] !== '')
        {
             $mode = $_POST['mode'];
        }
             return $mode;
    }

    /**
    * 
    * 投稿があるかいなか
    * @return boolean 投稿があるか否か
    */
	public function is_post()
	{
		return ( isset( $_POST['mode']) === true )?true:false;
	}
    
    
	//ビュー側に変数を渡す
	public function render( $template ='' )
	{
         $this->template_filename = ( $template !== '' )? $template : $this->action;
         $this->smarty->assign( 'template', $this->template_filename .'.tpl');
         $this->smarty->display( $this->main_template_filename );
	}
}
?>
