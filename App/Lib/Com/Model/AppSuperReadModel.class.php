<?php
// +----------------------------------------------------------------------
// | Date: 2014.09.22
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://v.yunzhanggui.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: Johnny <guoyou.yang@miot.cn>
// +----------------------------------------------------------------------
// | Description:数据分库策略
// +----------------------------------------------------------------------
namespace Lib\Com\Model;
use Think\Model;
class AppSuperReadModel extends Model
{
    protected $Model=null;
    protected $initdata=null;
    protected $partition;
    public function __construct($inidata){
        if(empty($inidata)){
           E('Model初始化参数为空');
        }
        if(empty($this->trueTableName)){
            E('Model数据表名为空');
        }
        $this->initdata=$inidata;
        $this->_setDBConnection();
        parent::__construct();
        $this->Model=$this->table($this->trueTableName);
    }


    /**
     * 得到分库的的数据库名
     * @access public
     * @param array $data 操作的数据
     * @return string
     */
    public function getPartitionDatabaseSeq($data=array()) {
        // 对数据表进行分区
        if(isset($data[$this->partition['field']])) {
            $field   =  $data[$this->partition['field']];
            switch($this->partition['type']) {
                case 'id':
                    // 按照id范围分库
                    if($this->partition['field']=='ownerid'){
                    	$dbpart=C('DB_PART');
                    	if(!empty($dbpart)){
                    		$seq=$dbpart;
                    	}else{
                    		$seq=$this->_getDBPartNum($field);
                    	}
                    	
                    }else{
                    	$step    =   $this->partition['expr'];
                    	$seq    =   floor($field / $step)+1;
                    }                  
                    break;
                case 'year':
                    // 按照年份分库
                    if(!is_numeric($field)) {
                        $field   =   strtotime($field);
                    }
                    $seq    =   date('Y',$field)-$this->partition['expr']+1;
                    break;
                case 'mod':
                    // 按照id的模数分库
                    $seq    =   ($field % $this->partition['num'])+1;
                    break;
                case 'md5':
                    // 按照md5的序列分库
                    $seq    =   (ord(substr(md5($field),0,1)) % $this->partition['num'])+1;
                    break;
                default :
                    if(function_exists($this->partition['type'])) {
                        // 支持指定函数哈希
                        $fun    =   $this->partition['type'];
                        $seq    =   (ord(substr($fun($field),0,1)) % $this->partition['num'])+1;
                    }else{
                        // 按照字段的首字母的值分表
                        $seq    =   (ord($field{0}) % $this->partition['num'])+1;
                    }
            }
            return $seq;
        }
        else{
            E('Model Partition未设置');
        }
    }
	private function _getDBPartNum($ownerid){
		if($ownerid>0&&$ownerid<=6000){
			return  floor($ownerid/1000)+1;
		}
		if($ownerid>6000&&$ownerid<=20000){
			$field=$ownerid-6000;
			return  floor($field/2000)+6+1;
		}
		if($ownerid>20000){
			$field=$ownerid-20000;
			return  floor($field/4000)+13+1;
		}
	}
    private function _setDBConnection()
    {
        $seq=$this->getPartitionDatabaseSeq($this->initdata);
//         $seq--;
        
        //计算数据库名称
        $seq_name=$seq>0?'_fk'.$seq:'';
        $dbname=C('DB_CONFIG1.db_name').$seq_name;
        
        $_connection=array(
            'db_type'       => C('DB_CONFIG1.db_type'),
            'db_user'       => C('DB_CONFIG1.db_user'),
            'db_pwd'        => C('DB_CONFIG1.db_pwd'),
            'db_host'       => C('DB_CONFIG1.db_host'),
            'db_port'       => C('DB_CONFIG1.db_port'),
            'db_name'       => $dbname,
            'db_charset'    => C('DB_CONFIG1.db_charset')
        );

        //使用不同的数据连接
        $this->connection=$_connection;
    }

    public function getListByCondition($condition=array(),$orderby){
        return $this->Model->where($condition)->order($orderby)->select();
    }
    public function getListFieldByCondition($fields,$condition){
    	return $this->Model->field($fields)->where($condition)->select();
    }
   public function getOneByCondition($condition=array()){
        return $this->Model->where($condition)->find();
    }

    public function doAdd($data){
      return $this->Model->add($data);
    }

    public function doDelete($condition=array()){
        return $this->Model->where($condition)->delete();
    }

    public function doUpdate($where,$data){
        return $this->Model->where($where)->save($data);
    }
    public function getFindByCondition($condition=array(),$fields=''){
    	return $this->Model->field($fields)->where($condition)->find();
    }
    public function updateById($id,$data){
    	$where=array('id'=>$id);
    	return $this->doUpdate($where,$data);
    }
    public function sqlqurey($sql){
    	return $this->Model->query($sql);
    }
    
}
