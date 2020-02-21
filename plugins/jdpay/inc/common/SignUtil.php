<?php


include PAY_ROOT.'inc/common/RSAUtils.php';

/**
 * 签名
 *
 *        
 */
class SignUtil {
	
// 	public static $unSignKeyList = array (
// 			"merchantSign",
// 			"version", 
// 			"successCallbackUrl",
// 			"forPayLayerUrl"
// 	);
	public static function signWithoutToHex($params,$unSignKeyList) {
		ksort($params);
  		$sourceSignString = SignUtil::signString ( $params, $unSignKeyList );
  		//echo  "sourceSignString=".htmlspecialchars($sourceSignString)."<br/>";
  		//error_log("=========>sourceSignString:".$sourceSignString, 0);
  		$sha256SourceSignString = hash ( "sha256", $sourceSignString);	
  		//error_log($sha256SourceSignString, 0);
  		//echo "sha256SourceSignString=".htmlspecialchars($sha256SourceSignString)."<br/>";
        return RSAUtils::encryptByPrivateKey ($sha256SourceSignString);
	}
	
	public static function sign($params,$unSignKeyList) {
		ksort($params);
		$sourceSignString = SignUtil::signString ( $params, $unSignKeyList );
		//error_log($sourceSignString, 0);
		$sha256SourceSignString = hash ( "sha256", $sourceSignString);
		//error_log($sha256SourceSignString, 0);
		return RSAUtils::encryptByPrivateKey ($sha256SourceSignString);
	}
	
	public static function signString($data, $unSignKeyList) {
		$linkStr="";
		$isFirst=true;
		ksort($data);
		foreach($data as $key=>$value){
			if($value=="" || in_array($key, $unSignKeyList)) continue;
			$linkStr.=$key."=".$value."&";
		}
		return substr($linkStr,0,-1);
	}
}
