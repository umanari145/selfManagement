<?php

/**
 * @author matsumoto norio
 *
 */
class Core{

	public $smarty       = NULL;
	public $objDb        = NULL;
    public $objFormParam = NULL;


	public $main_template_filename='';
    public $template_filname ='';

	//設定の読み込み
	public  function __construct()
	{
		 //必要ファイルの読み込み
         require_once("../config.php");
         require_once( SMARTY_DIR . SMARTY_FILENAME );
         require_once( CLASS_FILENAME );
         
         $this->smarty = new Smarty();
         
         $this->main_template_filename='main.tpl';
         
         //ファイル名の読み込み
         $filename_tmp = explode(".", basename($_SERVER['PHP_SELF']));
         $this->template_filname = $filename_tmp[0];
          
         //キャッシュディレクトリ、コンパイルディレクトリの読み込み
         $this->smarty->template_dir = TEMP_DIR;
         $this->smarty->compile_dir  = CACHE_DIR;
         
         //必須クラスの読み込み
         $this->objDb = new Database( DB_HOST,DB_USER, DB_PASS, DB_NAME);
         $this->objFormParam = new formParam();

    }


    public function index()
    {
    
    }

    public function add()
    {
    }
    
    public function edit()
    {
    
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
	public function render()
	{
		 $arrFom = $this->objFormParam->getFormParamList();
		 if( !empty( $arrFom) ) $this->smarty->assign( 'arrForm', $arrFom);
		 
         $this->smarty->assign( 'template', $this->template_filname .'.tpl');
		 $this->smarty->display( $this->main_template_filename );
	}
}
?>
