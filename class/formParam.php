<?php

/**
 * パラメーター管理クラス
 *
 * :XXX: addParam と setParam で言う「パラメーター」が用語として競合しているように感じる。(2009/10/17 Seasoft 塚田)
 *
 * @package SC
 * @author LOCKON CO.,LTD.
 */
class formParam
{
    /**
     * 何も入力されていないときに表示する値
     * キーはキー名
     */
    public $arrValue = array();

    /** 表示名 */
    public $disp_name = array();

    /** キー名 */
    public $keyname = array();

    public $convert = array();
    public $arrCheck = array();

    /**
     * 何も入力されていないときに表示する値
     * キーはキー名
     */
    public $arrDefault = array();

    /** DBにそのまま挿入可能か否か */
    public $input_db = array();

    public $html_disp_name = array();

    /**
     * コンストラクタ
     */
    public function __construct()
    {

    }

    /**
     * 前方互換用
     *
     * @deprecated 2.12.0 #1702
     */
    public function initParam()
    {
        $this->disp_name = array();
        $this->keyname = array();
        $this->convert = array();
        $this->arrCheck = array();
        $this->arrDefault = array();
        $this->input_db = array();
    }

    // パラメーターの追加
    public function addParam($disp_name, $keyname, $convert = '', $arrCheck = array(), $default = '', $input_db = true)
    {
        $this->disp_name[] = $disp_name;
        $this->keyname[] = $keyname;
        $this->convert[] = $convert;
        $this->arrCheck[] = $arrCheck;
        // XXX このタイミングで arrValue へ格納するほうがスマートかもしれない。しかし、バリデーションや変換の対象となるので、その良し悪しは気になる。
        $this->arrDefault[$keyname] = $default;
        $this->input_db[] = $input_db;
    }

    // パラメーターの入力
    // $arrVal  :$arrVal['keyname']・・の配列を一致したキーのインスタンスに格納する
    // $seq     :trueの場合、$arrVal[0]~の配列を登録順にインスタンスに格納する
    public function setParam($arrVal, $seq = false)
    {
        if (!is_array($arrVal)) return;
        if (!$seq) {
            foreach ($arrVal as $key => $val) {
                $this->setValue($key, $val);
            }
        } else {
            foreach ($this->keyname as $index => $key) {
                $this->setValue($key, $arrVal[$index]);
            }
        }
    }

    // 画面表示用タイトル生成
    public function setHtmlDispNameArray()
    {
        foreach ($this->keyname as $index => $key) {
            $find = false;
            foreach ($this->arrCheck[$index] as $val) {
                if ($val == 'EXIST_CHECK') {
                    $find = true;
                }
            }

            if ($find) {
                $this->html_disp_name[$index] = $this->disp_name[$index] . '<span class="red">(※ 必須)</span>';
            } else {
                $this->html_disp_name[$index] = $this->disp_name[$index];
            }
            if ($this->arrDefault[$key] != '') {
                $this->html_disp_name[$index] .= ' [省略時初期値: ' . $this->arrDefault[$key] . ']';
            }
            if ($this->input_db[$index] == false) {
                $this->html_disp_name[$index] .= ' [登録・更新不可] ';
            }
        }
    }

    // 画面表示用タイトル取得
    public function getHtmlDispNameArray()
    {
        return $this->html_disp_name;
    }

    // 複数列パラメーターの取得
    public function setParamList($arrVal2d, $keyname)
    {
        // DBの件数を取得する。
        $no = 1;
        foreach ($arrVal2d as $arrVal) {
            $key = $keyname . $no;
            $this->setValue($key, $arrVal[$keyname]);
            $no++;
        }
    }

    public function setDBDate($db_date, $year_key = 'year', $month_key = 'month', $day_key = 'day')
    {
        if (empty($db_date)) {
            return;
        }
        list($y, $m, $d) = preg_split('/[- ]/', $db_date);
        $this->setValue($year_key, $y);
        $this->setValue($month_key, $m);
        $this->setValue($day_key, $d);
    }

    // キーに対応した値をセットする。
    public function setValue($key, $value)
    {
        if (!in_array($key, $this->keyname)) {
            // TODO 警告発生
            return;
        }
        $this->arrValue[$key] = $value;
    }

    public function toLower($key)
    {
        if (isset($this->arrValue[$key])) {
            $this->arrValue[$key] = strtolower($this->arrValue[$key]);
        }
    }

    // エラーチェック
    public function checkError($br = true)
    {
        $arrErr = array();

        foreach ($this->keyname as $index => $key) {
            foreach ($this->arrCheck[$index] as $func) {
                $value = $this->getValue($key);
                switch ($func) {
                    case 'EXIST_CHECK':
                    case 'NUM_CHECK':
                    case 'EMAIL_CHECK':
                    case 'EMAIL_CHAR_CHECK':
                    case 'ALNUM_CHECK':
                    case 'GRAPH_CHECK':
                    case 'KANA_CHECK':
                    case 'URL_CHECK':
                    case 'IP_CHECK':
                    case 'SPTAB_CHECK':
                    case 'ZERO_CHECK':
                    case 'ALPHA_CHECK':
                    case 'ZERO_START':
                    case 'FIND_FILE':
                    case 'NO_SPTAB':
                    case 'DIR_CHECK':
                    case 'DOMAIN_CHECK':
                    case 'FILE_NAME_CHECK':
                    case 'MOBILE_EMAIL_CHECK':
                    case 'MAX_LENGTH_CHECK':
                    case 'MIN_LENGTH_CHECK':
                    case 'NUM_COUNT_CHECK':
                    case 'KANABLANK_CHECK':
                    case 'SELECT_CHECK':
                    case 'FILE_NAME_CHECK_BY_NOUPLOAD':
                    case 'NUM_POINT_CHECK':
                    case 'CHECK_DATE':
                        $this->recursionCheck($this->disp_name[$index], $func,
                            $value, $arrErr, $key);
                        break;
                    // 小文字に変換
                    case 'CHANGE_LOWER':
                        $this->toLower($key);
                        break;
                    // ファイルの存在チェック
                    case 'FILE_EXISTS':
                        if ($value != '' && !file_exists($this->check_dir . $value)) {
                            $arrErr[$key] = '※ ' . $this->disp_name[$index] . 'のファイルが存在しません。<br>';
                        }
                        break;
                    // ダウンロード用ファイルの存在チェック
                    case 'DOWN_FILE_EXISTS':
                        if ($value != '' && !file_exists(DOWN_SAVE_REALDIR . $value)) {
                            $arrErr[$key] = '※ ' . $this->disp_name[$index] . 'のファイルが存在しません。<br>';
                        }
                        break;
                    default:
                        $arrErr[$key] = "※※　エラーチェック形式($func)には対応していません　※※ <br>";
                        break;
                }
            }

            if (isset($arrErr[$key]) && !$br) {
                $arrErr[$key] = preg_replace("/<br(\s+\/)?>/i", '', $arrErr[$key]);
            }
        }

        return $arrErr;
    }

    /**
     * SC_CheckError::doFunc() を再帰的に実行する.
     *
     * 再帰実行した場合は, エラーメッセージを多次元配列で格納する
     *
     * TODO 二次元以上のエラーメッセージへの対応
     *
     * @param  string  $disp_name      表示名
     * @param  string  $func           チェック種別
     * @param  mixed   $value          チェック対象の値. 配列の場合は再帰的にチェックする.
     * @param  array   $arrErr         エラーメッセージを格納する配列
     * @param  string  $error_key      エラーメッセージを格納する配列のキー
     * @param  integer $depth          再帰実行した場合の深度
     * @param  integer $error_last_key エラーメッセージを格納する配列の末端のキー
     * @return void
     */
    public function recursionCheck($disp_name, $func, $value, &$arrErr, $error_key,
       $depth = 0, $error_last_key = null
    ) {
        if (is_array($value)) {
            $depth++;
            foreach ($value as $key => $in) {
                $this->recursionCheck($disp_name, $func, $in, $arrErr, $error_key,
                                    $depth, $key);
            }
        } else {
            $objErr = new checkError(array(($error_last_key ? $error_last_key : $error_key) => $value));
            $objErr->doFunc(array($disp_name, ($error_last_key ? $error_last_key : $error_key)), array($func));
            if (!utility::isBlank($objErr->arrErr)) {
                foreach ($objErr->arrErr as $message) {
                    if (!utility::isBlank($message)) {
                        // 再帰した場合は多次元配列のエラーメッセージを生成
                        $error_var = '$arrErr[$error_key]';
                        for ($i = 0; $i < $depth; $i++) {
                            // FIXME 二次元以上の対応
                            $error_var .= '[' . $error_last_key . ']';
                        }
                        eval($error_var . ' = $message;');
                    }
                }
            }
        }
    }

    /**
     * フォームの入力パラメーターに応じて, 再帰的に mb_convert_kana 関数を実行する.
     *
     * @return void
     * @see mb_convert_kana
     */
    public function convParam()
    {
        foreach ($this->keyname as $index => $key) {
            if (isset($this->arrValue[$key])) {
                $this->recursionConvParam($this->arrValue[$key], $this->convert[$index]);
            }
        }
    }

    /**
     * 再帰的に mb_convert_kana を実行する.
     *
     * @param mixed  $value   変換する値. 配列の場合は再帰的に実行する.
     * @param string $convert mb_convert_kana の変換オプション
     */
    public function recursionConvParam(&$value, $convert)
    {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $this->recursionConvParam($value[$key], $convert);
            }
        } else {
            if ( !utility::isBlank($value) ) {
                //iの場合はint変換
                if( $convert !== 'i' )
                {
                    $value =intval( $value );
                }
                else
                {
                    $value = mb_convert_kana($value, $convert);
                }
            }
        }
    }

    /**
     * 連想配列で返す
     *
     * @param  array $arrKey 対象のキー
     * @return array 連想配列
     */
    public function getHashArray($arrKey = array())
    {
        $arrRet = array();
        foreach ($this->keyname as $keyname) {
            if (empty($arrKey) || in_array($keyname, $arrKey)) {
                $arrRet[$keyname] = $this->getValue($keyname);
            }
        }

        return $arrRet;
    }

    // DB格納用配列の作成
    public function getDbArray()
    {
        $dbArray = array();
        foreach ($this->keyname as $index => $key) {
            if ($this->input_db[$index]) {
                $dbArray[$key] = $this->getValue($key);
            }
        }

        return $dbArray;
    }

    /**
     * 配列の縦横を入れ替えて返す
     *
     * @param  array $arrKey 対象のキー
     * @return array 縦横を入れ替えた配列
     */
    public function getSwapArray($arrKey = array())
    {
        $arrTmp = $this->getHashArray($arrKey);

        return utility::sfSwapArray($arrTmp);
    }

    // 項目名一覧の取得
    public function getTitleArray()
    {
        return $this->disp_name;
    }

    // 項目数を返す
    public function getCount()
    {
        $count = count($this->keyname);

        return $count;
    }

    // フォームに渡す用のパラメーターを返す
    public function getFormParamList()
    {
        $formParamList = array();
        foreach ($this->keyname as $index => $key) {
            // キー名
            $formParamList[$key]['keyname'] = $key;
            // 表示名
            $formParamList[$key]['disp_name'] = $this->disp_name[$index];
            // 入力値
            $formParamList[$key]['value'] = $this->getValue($key);
        }

        return $formParamList;
    }

    /**
     * キー名の一覧を返す
     *
     * @return array キー名の一覧
     */
    public function getKeyList()
    {
        return $this->keyname;
    }

    // キー名と一致した値を返す
    public function getValue($keyname, $default = '')
    {
        $ret = null;
        foreach ($this->keyname as $key) {
            if ($key == $keyname) {
                $ret = isset($this->arrValue[$key]) ? $this->arrValue[$key] : $this->arrDefault[$key];
                break;
            }
        }

        if (is_array($ret)) {
            foreach ($ret as $key => $value) {
                if (utility::isBlank($ret[$key])) {
                    $ret[$key] = $default;
                }
            }
        } else {
            if (utility::isBlank($ret)) {
                $ret = $default;
            }
        }

        return $ret;
    }

    /**
     * @deprecated
     */
    public function splitParamCheckBoxes($keyname)
    {
        foreach ($this->keyname as $key) {
            if ($key == $keyname) {
                if (isset($this->arrValue[$key]) && !is_array($this->arrValue[$key])) {
                    $this->arrValue[$key] = explode('-', $this->arrValue[$key]);
                }
            }
        }
    }

    /**
     * 入力パラメーターの先頭及び末尾にある空白文字を削除する.
     *
     * @param  boolean $has_wide_space 全角空白も削除する場合 true
     * @return void
     */
    public function trimParam($has_wide_space = true)
    {
        foreach ($this->arrValue as &$value) {
            $this->recursionTrim($value, $has_wide_space);
        }
    }

    /**
     * 再帰的に入力パラメーターの先頭及び末尾にある空白文字を削除する.
     *
     * @param  mixed   $value          変換する値. 配列の場合は再帰的に実行する.
     * @param  boolean $has_wide_space 全角空白も削除する場合 true
     * @return void
     */
    public function recursionTrim(&$value, $has_wide_space = true)
    {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $this->recursionTrim($value[$key], $has_wide_space);
            }
        } else {
            if (!utility::isBlank($value)) {
                if ($has_wide_space) {
                    $value = trim(mb_convert_kana( $value , "s"));
                }
                $value = trim($value);
            }
        }
    }

    /**
     * 検索結果引き継ぎ用の連想配列を取得する.
     *
     * 引数で指定した文字列で始まるパラメーター名の入力値を連想配列で取得する.
     *
     * @param  string $prefix パラメーター名の接頭辞
     * @return array  検索結果引き継ぎ用の連想配列.
     */
    public function getSearchArray($prefix = 'search_')
    {
        $arrResults = array();
        foreach ($this->keyname as $key) {
            if (preg_match('/^' . $prefix . '/', $key)) {
                $arrResults[$key] = $this->getValue($key);
            }
        }

        return $arrResults;
    }

    /**
     * 前方互換用
     *
     * 1次キーが添字なのが特徴だったと思われる。
     * @deprecated 2.12.0 必要ならば getFormParamList メソッドに引数を追加するなどで実現可能
     */
    public function getFormDispArray()
    {
        $formDispArray = array();
        foreach ($this->keyname as $index => $key) {
            // キー名
            $formDispArray[$index]['keyname'] = $key;
            // 表示名
            $formDispArray[$index]['disp_name']  = $this->disp_name[$index];
            // 入力値
            $formDispArray[$index]['value'] = $this->getValue($key);
        }

        return $formDispArray;
    }

    /**
     * パラメーターの削除
     *
     * addParamの逆の関数
     */
    public function removeParam($keyname)
    {
        $index = array_search($keyname, $this->keyname);

        if ($index !== FALSE) {
            // 削除
            unset($this->disp_name[$index]);
            unset($this->keyname[$index]);
            unset($this->convert[$index]);
            unset($this->arrCheck[$index]);
            unset($this->arrDefault[$keyname]);
            unset($this->input_db[$index]);

            // 歯抜けになった配列を詰める
            $this->disp_name    = array_merge($this->disp_name);
            $this->keyname      = array_merge($this->keyname);
            $this->convert      = array_merge($this->convert);
            $this->arrCheck     = array_merge($this->arrCheck);
            $this->input_db     = array_merge($this->input_db);
        }
    }

    /**
     * パラメーター定義の上書き
     *
     * @param string $keyname キー名
     * @param string $target  上書きしたい項目名(disp_name,convert等)
     * @param mixed  $value   指定した内容に上書きする
     */
    public function overwriteParam($keyname, $target, $value)
    {
        $index = array_search($keyname, $this->keyname);

        if ($index !== FALSE) {
            $this->{$target}[$index] = $value;
        }
    }
}
