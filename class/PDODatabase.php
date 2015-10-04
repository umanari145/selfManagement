<?php

/**
 * 各種DB 
 * 
 * 主に DB処理
 *
 * @package Database
 * @author LOCKON CO.,LTD.
 * @version $Id:self.php 15532 2007-08-31 14:39:46Z nanasess $
 */
class PDODatabase{

        var $dbh     = NULL;
        var $db_host = "";
        var $db_user = "";
        var $db_pass = "";
        var $db_name = "";
        var $db_type = "";

        public function __construct( $db_host, $db_user, $db_pass, $db_name, $db_type )
        {
            $this->dbh  = &$this->connectDB( $db_host, $db_user, $db_pass, $db_name, $db_type );
            $this->db_host = $db_host;
            $this->db_user = $db_user;
            $this->db_pass = $db_pass;
            $this->db_name = $db_name;
            $this->db_type = $db_type;
        }

        private function &connectDB( $db_host, $db_user, $db_pass, $db_name, $db_type)
        {

        	try{
                switch( $db_type )
                {
                case 'mysql':
                    $dsn = 'mysql:host='.$db_host.';dbname='.$db_name;
            		$dbh = new PDO($dsn,$db_user,$db_pass);
                    $dbh->query('SET NAMES utf8');
                    break;

                case 'pgsql':
                    $dsn = 'pgsql:dbname='.$db_name.' host=' . $db_host .' port=5432';
            		$dbh = new PDO($dsn,$db_user,$db_pass);
                    break;
            	}
        	}
        	catch(PDOException $e)
        	{
                var_dump($e->getMessage());
                exit;
        	}
            	
            return $dbh;
        }

        public function select( $table, $column ='', $where = '', $arrVal = array(), $sqlOption=array())
        {

            $sql = $this->setSQL( 'select', $table, $where, $column, $sqlOption);

            $stmt = $this->dbh->prepare($sql);
            
            $stmt->execute($arrVal);
            
            //データを連想配列に格納
            $data = array();
            while($result = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                array_push($data , $result);
            }


            return $data;
        }

        public function count( $table, $where='', $arrVal=array())
        {
            $sql = $this->setSQL('count',$table, $where );
            $stmt = $this->dbh->prepare($sql);

            $stmt->execute($arrVal);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return intval($result['NUM']);
        }

        private function setSQL( $type,$table,$where='',$column='', $sqlOption=array())
        {

            switch( $type )
            {
            case 'select':
                $columnKey =( $column !=='') ? $column : "*" ; 
                break;

            case 'count':
                $columnKey = 'COUNT(*) AS NUM ';
                break;
            }

            $other ='';

            if( $sqlOption !== array() )
            {
                $limit  = ( isset( $sqlOption['limit'])) ? $sqlOption['limit']:'';
                $offset = ( isset( $sqlOption['offset'])) ? $sqlOption['offset'] . " , " :'';

              if( $limit !== '' ) $other .=' LIMIT ' . $offset . $limit; 
            }


            $whereSQL = ( $where !== '' )?' WHERE  ' . $where :'';

            //sql文の作成
            $sql = " SELECT "
                 .      $columnKey 
                 . " FROM "
                 .      $table
                 .      $whereSQL
                 .      $other;
            
            return $sql;
        } 


        public function insert($table, $insData=array() )
        {
           
            list( $preSt, $insDataVal, $columns) = $this->makePreparedStatement( 'insert', $insData, $table );
            
            $sql = " INSERT INTO " . $table . " (" 
                 .      $columns 
                 . ") VALUES (" 
                 .      $preSt 
                 . ") " ;

            $stmt = $this->dbh->prepare( $sql );
            $res = $stmt->execute($insDataVal);

            return $res;
        }

        public function update($table ,$insData = array() ,$where, $arrWhereVal=array())
        {
            list( $preSt, $insDataVal) = $this->makePreparedStatement( 'update', $insData, $table );
            
            //sql文の作成
            $sql = " UPDATE "
                 .      $table
                 . " SET "
                 .      $preSt
                 . " WHERE "
                 .      $where ;
            
            $updateData = array_merge($insDataVal,$arrWhereVal);
            $stmt = $this->dbh->prepare( $sql );
            $res = $stmt->execute($updateData);
            
            return $res ;
        }

        public function makePreparedStatement( $mode, $insData, $table )
        {
           
            if( !empty($insData) )
            {
                
                $arrColumnNames = $this->getColumnNameArray($table);
                
                foreach( $insData as $key => $val )
                {
                    if( in_array( $key, $arrColumnNames ) !== true )
                    {
                        unset( $insData[$key]);
                    }
                }

                $insDataKey =array_keys($insData);
                $insDataVal = array_values($insData);
                $preCnt = count( $insDataKey );
                
                switch( $mode )
                {
                case 'insert':

                    $columns = implode(",",$insDataKey);
                    $arrPreSt =array_fill( 0, $preCnt,'?');
                    $preSt =implode(",",$arrPreSt);
                    
                        
                    if( in_array(  'create_dt', $arrColumnNames) === true )
                    {
                        $columns .=' , create_dt , update_dt ';
                        $preSt .= ' , NOW() , NOW()';
                    }
                    
                    return array($preSt, $insDataVal, $columns);

                    break;
                case 'update':
                    
                    for( $i=0;$i < $preCnt; $i++ )
                    {
                        $arrPreSt[$i] = $insDataKey[$i] ." =? ";
                    }
                    
                    $preSt =implode(",",$arrPreSt);
                        
                    if( in_array(  'update_dt', $arrColumnNames) === true )
                    {
                        $preSt .= ', update_dt = NOW() ';
                    }

                    return array($preSt, $insDataVal);
                 
                    break;
                }

            }
            else
            {
                return false;
            }
        
        }

        public function getColumnNameArray( $table )
        {
            $stmt = $this->dbh->query("SELECT * FROM " . $table . " LIMIT 0");

            $arrColumnNames = array();

            for ($i = 0; $i < $stmt->columnCount(); $i++) {
                $meta = $stmt->getColumnMeta($i);
                $arrColumnNames[] = $meta['name'];
            }

            return $arrColumnNames;
        }

        public function getLastId()
        {
            return $this->dbh->lastInsertId();;
        }
    }

?>
