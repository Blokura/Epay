<?php
//威富通配置文件
define("PAY_API_APPID", $channel['appid']);
define("PAY_API_KEY", $channel['appkey']);
define("PAY_API_APPSECRET", $channel['appsecret']);
class Config{
    private $cfg = array(
        'url'=>'https://pay.swiftpass.cn/pay/gateway', /*支付接口请求地址 */
        'mchId'=>PAY_API_APPID, /* 商户号，于申请成功后的开户邮件中获取 */
        'version'=>'2.0',
        'sign_type'=>'RSA_1_256',
        'public_rsa_key'=>PAY_API_KEY,   /* RSA验签平台公钥 */
        'private_rsa_key'=>PAY_API_APPSECRET   /* RSA签名私钥 */
       );
    
    public function C($cfgName){
        return $this->cfg[$cfgName];
    }
}
?>