<?php
namespace Lib\Com\Model;
use Think\Model;
class AppReadModel extends Model
{
    protected $Model=null;

    public function __construct(){
        parent::__construct();
        if(!empty($this->trueTableName)){
            $this->Model=M($this->trueTableName,'',$this->connection);
        }
    }

    protected function getmodel(){
        if(empty($this->Model)){
            new \Lib\Extension\Think\AppException(L('_FRAME_MODEL_ISNULL_'));
        }
        return $this->Model;
    }

    public function getListByCondition($condition=array(),$order=''){
        return $this->Model->where($condition)->order($order)->select();
    }

	public function getFindByCondition($condition=array(),$fields=''){
		return $this->Model->field($fields)->where($condition)->find();
	}

    public function getListFieldByCondition($fields,$condition){
        return $this->Model->field($fields)->where($condition)->select();
    }

    public function doAdd($data){
        return $this->Model->add($data);
    }

    public function doDelete($condition=array()){
        return $this->Model->where($condition)->delete();
    }

	public function doDeleteById($id){
		return $this->Model->delete($id);
	}
    public function doUpdate($where,$data){
        return $this->Model->where($where)->save($data);
    }

    public function updateById($id,$data){
        $where=array('id'=>$id);
        return $this->doUpdate($where,$data);
    }
    public function sqlqurey($sql){
    	return $this->Model->query($sql);
    }
}
