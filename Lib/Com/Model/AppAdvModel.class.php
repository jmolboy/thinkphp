<?php
// +----------------------------------------------------------------------
// | Date: 2014.09.22
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://v.yunzhanggui.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: Johnny <guoyou.yang@miot.cn>
// +----------------------------------------------------------------------
// | Description:数据分表策略
// +----------------------------------------------------------------------
namespace Lib\Com\Model;
use Think\Model;
class AppAdvModel extends Model\AdvModel
{
    public $db_tablename='';
    protected $Model=null;
    protected  $initdata=null;
    public function __construct($inidata){
        if(empty($inidata)){
            new \Lib\Extension\Think\AppException(L('_FRAME_MODEL_NO_INITDATA_'));
        }
        $this->initdata=$inidata;
        $this->Model=$this->getDBTable($inidata);
        parent::__construct();
    }

    protected function getDBModel(){
        if(!empty($this->Model)){
            //return $this->Model;
        } 
        $this->Model=$this->getDBTable($this->initdata);
        return $this->Model;
    }

    public function getDBTable($data)
    {
        if(empty($data)){return null;}
        $table=$this->getPartitionTableName($this->initdata);
        $this->db_tablename=$table;
        return M($table);
    }

    public function getListByCondition($condition){
        $this->getDBModel();
        return $this->Model->where($condition)->select();
    }

    public function doAdd($data){
        $this->getDBModel();
        return $this->Model->add($data);
    }

    public function doDelete($condition=array()){
        $this->getDBModel();
        return $this->Model->where($condition)->delete();
    }

    public function doUpdate($where,$data){
        $this->getDBModel();
        return $this->Model->where($where)->save($data);
    }
}
