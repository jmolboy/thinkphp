<?php
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
namespace Lib\Extension\Think;

use Think\Upload;
class AppUpload extends Upload {

    /**
     * 按照选定范围尺寸处理图片
     * @param  array  $rule     规则
     * @param  string $filename 原文件名
     * @return string           文件或目录名称
     */
    public function imagecutbyselected($type,$path,$sizelist){
        $x1 = $_POST['x1'];//客户端选择区域左上角x轴坐标
        $y1 = $_POST['y1'];//客户端选择区域左上角y轴坐标
        $x2 = $_POST['x2'];//客户端选择区 的宽
        $y2 = $_POST['y2'];//客户端选择区 的高
        $w = $_POST['w'];//客户端选择区 的高
        $h = $_POST['h'];//客户端选择区 的高
        $images_conf=C('IMAGE_CONF');
        $sitepath=$images_conf['path'];
        $url=$images_conf['url'];
        $path=str_replace($url, '', $path);
        $src = $sitepath.$path;//图片的路径
        ini_set("memory_limit", "200M");
        // 获取源图的扩展名宽高
        list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($src);
        if($sr_type){
            //获取后缀名
            $ext = image_type_to_extension($sr_type,false);
        } else {
            echo "-1";
            exit;
        }
        
        $basename=basename($src,'.jpg');
        $path=dirname($src);
        $path=str_replace('imagesorg/', 'images/', $path);
        $this->checkFilePath($path);
        foreach ($sizelist as $key=>$detail){
			$big_w = $detail['width'];
			$big_h = $detail['height'];
			
			if($key=='original'){
				$big_name	    =	$path.'/'.$basename.'_big.jpg';		// 大图
			}else{
				$big_name	    =	$path.'/'.$basename.'_small.jpg';		//小图
			}
			$func	=	(strtolower($ext) != 'jpg')?'imagecreatefrom'.$ext:'imagecreatefromjpeg';
			$img_r	=	call_user_func($func,$src);
			
			$dst_r	=	ImageCreateTrueColor( $big_w, $big_h );
			$back	=	ImageColorAllocate( $dst_r, 255, 255, 255 );
			ImageFilledRectangle( $dst_r, 0, 0, $big_w, $big_h, $back );
			ImageCopyResampled( $dst_r, $img_r, 0, 0, $x1, $y1, $big_w, $big_h, $w, $h );
			
			imagejpeg($dst_r,$big_name);  // 生成大图
			
			ImageDestroy($dst_r);
			ImageDestroy($img_r);
			if($key=='original'){
				$res=array("url"=>$url,"path"=>str_replace($sitepath, '', $big_name));
			}
		}
		return $res;
    }
    private function checkFilePath($path){
    	if(empty($path)){
    		return false;
    	}
    	if(!file_exists($path)){
    		$ret=mkdir($path,0777,true);
    		if(!$ret){
    			return false;
    		}
    	}
    	return true;
    }
    /**
     * 按标准生成缩略图
     * @param unknown_type $img
     * @param unknown_type $standard
     * @return boolean|multitype:mixed NULL
     */
    public function thumbnailImageFromOrg($path, $standard){
    	$images_conf=C('IMAGE_CONF');
        $sitepath=$images_conf['path'];
        $url=$images_conf['url'];
        $path=str_replace($url, '', $path);
        $src = $sitepath.$path;//图片的路径
        ini_set("memory_limit", "200M");
    	// 获取源图的扩展名宽高
    	list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($src);
    	if ($sr_type) {
    		//获取后缀名
    		$ext = image_type_to_extension($sr_type, false);
    	} else {
    		echo "-1";
    		return false;
    	}
    	$width=1000;
    	$height=1000;
    	if($sr_w>$sr_h){
    		$height=($standard*$sr_h)/$sr_w;
    	}else{
    		$width=($standard*$sr_w)/$sr_h;
    	}
    	$basename = pathinfo($src);
    	$path = dirname($src);
    	$path=str_replace('imagesorg/', 'images/', $path);
    	$this->checkFilePath($path);
    	$big_name	    =	$path.'/'.$basename['filename'].'_thumb.jpg';		//小图
    	$res = array();
    
    	$func = ($ext != 'jpg') ? 'imagecreatefrom' . $ext : 'imagecreatefromjpeg';
    	$im = call_user_func($func, $src);
    	$tn = imagecreatetruecolor($width, $height);
    	imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $sr_w, $sr_h); //复制图像并改变大小
    	imagejpeg($tn, $big_name); // 输出图像
    	imagedestroy($tn);
    	$res = array("url" => $url, "path" => str_replace($url, '', $big_name));
    	return $res;
    }
	public function thumbImage($path,$width,$height){
		$images_conf=C('IMAGE_CONF');
		$sitepath=$images_conf['path'];
		$url=$images_conf['url'];
		$path=str_replace($url, '', $path);
		$src = $sitepath.$path;//图片的路径
		ini_set("memory_limit", "200M");
		// 获取源图的扩展名宽高
		list($sr_w, $sr_h, $sr_type, $sr_attr) = @getimagesize($src);
		if ($sr_type) {
			//获取后缀名
			$ext = image_type_to_extension($sr_type, false);
		} else {
			echo "-1";
			return false;
		}
		$basename = pathinfo($src);
		$path = dirname($src);
		$path=str_replace('imagesorg/', 'images/', $path);
		$this->checkFilePath($path);
		$big_name	    =	$path.'/'.$basename['filename'].'_thumb.jpg';		//小图
		$res = array();

		$func = ($ext != 'jpg') ? 'imagecreatefrom' . $ext : 'imagecreatefromjpeg';
		$im = call_user_func($func, $src);
		$tn = imagecreatetruecolor($width, $height);
		imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $sr_w, $sr_h); //复制图像并改变大小
		imagejpeg($tn, $big_name); // 输出图像
		imagedestroy($tn);
		$res = array("url" => $url, "path" => str_replace($sitepath, '/', $big_name));
		return $res;
	}

}
