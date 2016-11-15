<?php

namespace Home\Logic;
use Think\Exception;

class TestLogic extends \Lib\Com\Logic\AppLogic
{
	public function Test()
	{
		throw new Exception('just a test function');
	}

}