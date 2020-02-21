<?php
namespace lib;

/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

/*
 * @brief QC类，api外部对象，调用接口全部依赖于此对象
 * */

class QC{
    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    function __construct($QC_config){
        $this->appid = $QC_config["appid"];
        $this->appkey = $QC_config["appkey"];
        $this->callback = $QC_config['callback'];
    }

    public function qq_login(){
		$state = md5(uniqid(rand(), TRUE));
        $_SESSION['Oauth_state'] = $state;

        //-------构造请求参数列表
        $keysArr = array(
            "response_type" => "code",
            "client_id" => $this->appid,
            "redirect_uri" => $this->callback,
            "state" => $state
        );

        $login_url =  self::GET_AUTH_CODE_URL.'?'.http_build_query($keysArr);

        header("Location:$login_url");
    }

    public function qq_callback(){
		if($_GET['state'] != $_SESSION['Oauth_state']){
            sysmsg("<h2>The state does not match. You may be a victim of CSRF.</h2>");
        }
        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $this->appid,
            "redirect_uri" => $this->callback,
            "client_secret" => $this->appkey,
            "code" => $_GET['code']
        );

        //------构造请求access_token的url
        $token_url = self::GET_ACCESS_TOKEN_URL.'?'.http_build_query($keysArr);
        $response = $this->get_curl($token_url);

        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
				sysmsg('<h3>error:</h3>'.$msg->error.'<h3>msg  :</h3>'.$msg->error_description);
			}
        }

        $params = array();
        parse_str($response, $params);

        return $params["access_token"];

    }

    public function get_openid($access_token){

        //-------请求参数列表
        $keysArr = array(
            "access_token" => $access_token
        );

        $graph_url = self::GET_OPENID_URL.'?'.http_build_query($keysArr);
        $response = $this->get_curl($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
			sysmsg('<h3>error:</h3>'.$msg->error.'<h3>msg  :</h3>'.$msg->error_description);
        }

        //------记录openid
        return $user->openid;
    }

	public function get_curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.5 Mobile Safari/533.1');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
}
