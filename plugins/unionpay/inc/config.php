<?php
//威富通配置文件
define("PAY_API_APPID", $channel['appid']);
define("PAY_API_KEY", $channel['appkey']);
class Config{
    private $cfg = array(
        'url'=>'https://qra.95516.com/pay/gateway',/*支付请求接口地址，无需更改 */
        'mchId'=>PAY_API_APPID,/* 测试商户号 */
        'key'=>PAY_API_KEY,  /* 测试密钥 */
        'version'=>'2.0',
        'sign_type'=>'MD5'
       );
    
    public function C($cfgName){
        return $this->cfg[$cfgName];
    }
}
?>