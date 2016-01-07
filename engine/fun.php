<?php
	//工具类
	function validate($case,$str){
		switch ($case) {
			case 'name':
				return preg_match('/^[\x{4e00}-\x{9fa5}]{2,4}$/u',$str);
				break;
			case 'email':
				return preg_match('/^[\da-zA-Z_]{5,}@[a-z\d]+\.(com|cn|net)$/',$str);
				break;
			case 'pass':
				return preg_match('/^[a-zA-Z0-9_#%$@.]{8,20}$/', $str);
				break;
			case 'phone':
				return preg_match('/^1[34578]\d{9}$/',$str);
			case 'code':
				return preg_match('/^[\da-z]{4}$/', $str);
				break;
			case 'sms':
				return preg_match('/^\d{6}$/',$str);
				break;
			default:
				return false;
				break;
		}
	}
	function isMobil(){
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		return preg_match('/(iphone|android|mobil)/',$agent);
	}
	function logs($str){
		$file = fopen(LOGS.format(timenow(),'_').'.txt','a');
		if (flock($file, LOCK_EX)){      //加写锁
	        // fputs($file,$string);        //写文件
	        fwrite($file,$str."--".timenow()."\n");
	        flock($file, LOCK_UN);       //解锁
    	}
		fclose($file);
	}
	function getIP(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		$ip = $_SERVER['REMOTE_ADDR'];
		else
		$ip = "unknown";
		return $ip;
	}
	//通过程序而不是表单提交post请求
	function phppost($url,$data=''){

		$post='';
		$row = parse_url($url);
		$host = $row['host'];
		$port = $row['port'] ? $row['port']:80;
		$file = $row['path'];
		while (list($k,$v) = each($data)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.0\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;		
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}
	function createOrderNum(){
		$mtime =  microtime();
		$arr = explode(' ',$mtime);
		return $arr[1].$arr[0]*10e8;
	}
	function sendSmscode($mobile,$str){
		$uid = '57141';		//用户账号
		$pwd = 'd6m574';		//密码
		$content = $str.'，请不要把验证码泄露给其他人。如非本人操作，可不用理会。【阿依达商贸】';		//内容
		//即时发送
		return sendSMS($uid,$pwd,$mobile,$content);
	}
	function createSmscode($digits=6){

		$digits = (int)$digits;
		$code = "";
		for($i = 0;$i<$digits;$i++){
			$code = $code.rand(0,9);
		}
		return $code;
	}
	function getMethodList($dir){
		$dirs = scandir($dir);
		$class = array();
		$result = array();
		foreach ($dirs as $key => $value) {
			if($value == '.' || $value == '..') continue;
			try{
				require_once($dir.'/'.$value);
				$classname = basename($dir.'/'.$value,'.php');
				$class[] = $classname;
				if(!preg_match('/^_/', $classname)){
					
				}
			}catch(Exception $e){}
		}
		foreach($class as $key => $value){
			$clazz = 'Controller'.ucfirst($value);
			$methods = get_class_methods($clazz);
			$result[] = $value;
			foreach($methods as $k => $v){
				if(!preg_match('/^_/',$v)){
					$result[] = $value.'/'.$v;
				}
			}
		}
		return $result;
	}
	function setHint($str,$express="good"){
		switch ($express) {
			case 'good':
				setcookie('idawatch',"<span class='good'>".$str."</span>",time()+2);
				break;
			case 'bad':
				setcookie('idawatch',"<span class='bad'>".$str."</span>",time()+2);
				break;
			default:
				return false;
				break;
		}
	}
	function getHint(){
		$cookie = $_COOKIE['idawatch'];
		if(empty($cookie)){
			return '';
		}else{
			clearHint();
			return $cookie;
		}
	}
	function clearHint(){
		setcookie('idawatch','',-3600*10);
	}
	function format($time,$place="/"){
		return date('Y'.$place.'m'.$place.'d',strtotime($time));
	}
	function timenow(){
		return date('Y-m-d H:i:s');
	}
	function randCode($num){
		$str = "abcdefghijklmnopqrstuvwxyz0123456789";//36
		$ret = "";
		for($i = 0;$i<$num;$i++){
			$ret = $ret.substr($str,rand(0,35),1);
		}
		return $ret;
	}
	function randImgName($num=20){
		return uniqid().randCode($num);
	}
    /*生成二维码函数
    *@param $url 二维码指向的地址
    *@param $name 生成图片的名称
    *@param $dir 生成图片的路径
    *@param $logo logo的绝对路径（包含图片名）
    *@param $level 生成图片的大小（缩放倍数）
    *exaple:createQcode('http://www.baidu.com','qrcode','dog.png',"D://wamp/www/qcode",7);
    */
    function createQcode($url,$name,$logo,$dir,$size){
        $errorCorrectionLevel = 'L';//容错级别 
        //生成二维码图片
        $imgname = $dir.'/'.$name.'.png';
        $logoname = $name.'logo.png';
        $logo = $dir.'/'.$logo;
        QRcode::png($url,$imgname,$errorCorrectionLevel, $size, 2); 
        // $logo = $name.'logo.png';//准备好的logo图片
        $QR = $imgname;//已经生成的原始二维码图 
          
        if ($logo !== FALSE){
            $QR = imagecreatefromstring(file_get_contents($QR)); 
            $logo = imagecreatefromstring(file_get_contents($logo)); 
            $QR_width = imagesx($QR);//二维码图片宽度 
            $QR_height = imagesy($QR);//二维码图片高度 
            $logo_width = imagesx($logo);//logo图片宽度 
            $logo_height = imagesy($logo);//logo图片高度 
            $logo_qr_width = $QR_width / 5; 
            $scale = $logo_width/$logo_qr_width; 
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2; 
            //重新组合图片并调整大小 
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,  
            $logo_qr_height, $logo_width, $logo_height);
        } 
        //输出图片到指定路径
        return imagepng($QR,$dir.'/'.$logoname);
        // echo '<img src="'.$logoname.'"/>';
    }

	function imagecropper($source_path,$target_width,$target_height=null){
		
	    $source_info   = getimagesize($source_path);
	    $source_width  = $source_info[0];
	    $source_height = $source_info[1];
	    $source_mime   = $source_info['mime'];
	    $source_ratio  = $source_height / $source_width;

	    if(empty($target_height)){
	        $target_height = $source_height/($source_width/$target_width);
	    }
	    $target_ratio  = $target_height / $target_width;

	    // 源图过高
	    if ($source_ratio > $target_ratio)
	    {
	        $cropped_width  = $source_width;
	        $cropped_height = $source_width * $target_ratio;
	        $source_x = 0;
	        $source_y = ($source_height - $cropped_height) / 2;
	    }
	    // 源图过宽
	    elseif ($source_ratio < $target_ratio)
	    {
	        $cropped_width  = $source_height / $target_ratio;
	        $cropped_height = $source_height;
	        $source_x = ($source_width - $cropped_width) / 2;
	        $source_y = 0;
	    }
	    // 源图适中
	    else
	    {
	        $cropped_width  = $source_width;
	        $cropped_height = $source_height;
	        $source_x = 0;
	        $source_y = 0;
	    }

	    switch ($source_mime)
	    {
	        case 'image/gif':
	            $source_image = imagecreatefromgif($source_path);
	            break;

	        case 'image/jpeg':
	            $source_image = imagecreatefromjpeg($source_path);
	            break;

	        case 'image/png':
	            $source_image = imagecreatefrompng($source_path);
	            break;

	        default:
	            return false;
	            break;
	    }

	    $target_image  = imagecreatetruecolor($target_width, $target_height);
	    $cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

	    // 裁剪
	    imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height); 
	    // 缩放
	    imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);

	    $filename = basename($source_path);
	    $dotpos = strrpos($filename,'.');
	    $target_name = substr($filename,0,$dotpos).$target_width."x".$target_width.substr($filename, $dotpos);
	    return imagejpeg($target_image,dirname($source_path)."/".$target_name,100);
	}
?>