<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $conf['title']?></title>
  	<meta name="keywords" content="<?php echo $conf['keywords']?>">
	<meta name="description" content="<?php echo $conf['description']?>">	
    <link href="//cdn.staticfile.org/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo STATIC_ROOT?>css/style.css" rel="stylesheet">
    <style>
        *{-webkit-font-smoothing: antialiased;list-style:none;font-family: "Helvetica", "Luxi Sans", "DejaVu Sans", Tahoma, "Hiragino Sans GB", "Microsoft Yahei", sans-serif;}
        a,a:hover{text-decoration:none !important;}

        .login{
            font-size:13px;
            padding:6px 16px;
            border:1px solid #fff;
            border-radius: 3px;
        }
        .login:hover{
            background: #fff;
            color:#61839c;
        }
        .register{
            font-size:13px;
            padding:6px 16px;
            border:0;
        }
        .register:hover{
            color:#61839c;
            background: #fff;
            font-size:13px;
            padding:6px 16px;
            border:0px solid #fff;
            border-radius: 3px;
        }

        h1{font-size:34px;}
        h4{font-size:14px; font-weight: 100; color:#607d8b;}
        .title a{font-weight: 100;text-align: center;}
        .hide{display: none;}
        .menu a{color:#fff;}
        .timeline-horizontal{padding:0 !important;}


        #header:hover {
             -webkit-transform: scale(1.07) rotate(-1deg);
            -moz-transform: scale(1.07) rotate(-1deg);
        }

        #header{
             -webkit-animation-duration: 0.4s;
            -webkit-animation-name: acceleratedReveal;
        }
        #header {
            -webkit-transition: all .15s ease-out;
            -moz-transition: all .15s ease-out;
        }
        .plan-pricing{font-size:28px; font-weight: 100;line-height: 100px;}
    </style>

</head>

<body class="home">

<section class="header" style="height:100%;">

    <div class="header-bg"></div>

    <nav class="navbar menu">
        <div class="container">
            <div class="navbar-header" id="header">
                <a class="navbar-brand" href="index.php"><img width="180" src="assets/img/logo.png" alt="Logo white" /></a>
            </div>
            <div class="menu hidden-xs" style="margin-top:42px;margin-left:140px;">
                <a href="#" class="register" target="_blank">首页</a>
                <?php if($conf['test_open']){?><a href="/user/test.php" class="register contrast">支付演示</a><?php }?>
                <a href="/doc.html" class="register">开放文档</a>
                <a onclick="return confirm('有事直奔主题，谢谢合作！')" href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&site=pay&menu=yes" target="_blank" class="register" style="margin-right:20px;">联系我们</a>
                <a href="/user/" class="login" style="float: right;">开始使用</a>
            </div>
        </div>
        </div>
    </nav>

    <div class="container ">
        <div class="row">
            <div class="spacer30"></div>
            <div class="col-xs-12 col-sm-10 col-md-6 col-md-offset-0 col-lg-6" style="margin-top:40px;">
                <h1 style="line-height:40px;color:white;margin:40px 0;font-size:24px;color:#06a2fe;">每个梦想，都值得灌溉</h1>
                <p style="color:#FFFFFF;opacity: 0.7;font-size:14px;line-height: 2;">
				<?php echo $conf['sitename']?>旨在解决需要使用交易数据流的企业发卡、个人发卡、主机IDC等网站支付需求，提供的一个正规、安全、稳定、可靠、丰富的支付接口 API，
                    帮助开发者等个人主体快速使想法转变为产品原型。让创造价值的人体现价值。</p>
                <div class="spacer5"></div>
                <p style="color:#FFFFFF;opacity: 0.7;font-size:14px;">帮助开发者快速将支付（支付宝，钱包，微信）集成到自己相应产品，效率高，见效快，费率低</p>
                <div class="spacer20"></div>
                <p style="font-family:'Operator Mono';color:#03a9f4;opacity: 0.7;font-size:16px;font-weight: 100;">Make Something Amazing</p>
            </div>


            <div class="col-xs-12 col-sm-8 col-sm-offset-3 col-md-6 col-md-offset-0 col-lg-6 col-lg-offset-0">

                <img src="<?php echo STATIC_ROOT?>picture/bg2.png" style="width:100%; margin-top:80px; opacity: 0.8;">
            </div>

        </div>

    </div>
    <div class="spacer45"></div>
    <div class="spacer45"></div>
</section>

<div class="spacer45"></div>

<div class="container">
    <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">

        
            
                
            
        
        <div class="row">

            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12  text-center" style="padding:50px;">

                <div class="value-icon">
                    <img src="<?php echo STATIC_ROOT?>picture/ssl.svg" alt="Open-Source Software" class="icon-opensource">
                </div>

                <h4 class="team-member-name" style="color:#333333;">安全保证</h4>
                <p class="team-member-title" style="font-size: 14px;">多重账号保护措施安全可靠；业内费率低，维护商户利益，7*24小时全天候服务；</p>
            </div>


            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 text-center" style="padding:50px;">

                <div class="value-icon">
                    <img src="<?php echo STATIC_ROOT?>picture/wechatpay.svg" alt="Open-Source Software" class="icon-opensource">
                </div>
                <h4 class="team-member-name" style="color:#333333;">资金安全</h4>
                <p class="team-member-title" style="font-size: 14px;">只负责交易处理不参与资金清算 保障您的资金安全</p>
                
                
            </div>


            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 text-center" style="padding:50px;">

                <div class="value-icon">
                    <img src="<?php echo STATIC_ROOT?>picture/server.svg" alt="Open-Source Software" class="icon-opensource">
                </div>

                <h4 class="team-member-name" style="color:#333333;">高效服务</h4>
                <p class="team-member-title" style="font-size: 14px;">产品服务灵活组合<br>满足企业 多元化 业务需求</p>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 text-center" style="padding:50px;">
                <div class="value-icon">
                    <img src="<?php echo STATIC_ROOT?>picture/risk.svg" alt="Open-Source Software" class="icon-opensource">
                </div>
                <h4 class="team-member-name" style="color:#333333;">极简使用</h4>
                <p class="team-member-title" style="font-size: 14px;">七行代码，极速完成，支付SDK接入 简洁的操作界面易于使用</p>
            </div>

            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 text-center" style="padding:50px;">
                <div class="value-icon">
                    <img src="<?php echo STATIC_ROOT?>picture/easy.svg" alt="Open-Source Software" class="icon-opensource">
                </div>
                <h4 class="team-member-name" style="color:#333333;">简单易用</h4>
                <p class="team-member-title" style="font-size: 14px;">对于线下收款商户，免开发直接使用。开发者可自行对接使用</p>
            </div>

            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 text-center" style="padding:50px;">
                <div class="value-icon">
                    <img src="<?php echo STATIC_ROOT?>picture/easyapi-logo.svg" alt="Open-Source Software" class="icon-opensource" style="width: 80px;">
                </div>
                <h4 class="team-member-name" style="color:#333333;">完整 API + 开源代码</h4>
                <p class="team-member-title" style="font-size: 14px;">提供完整的 API 和丰富的开源开发包、SDK、DEMO 供接入参考</p>
            </div>
        </div>
    </div>
</div>

<div class="spacer45"></div>
<section class="pricing section text-center" id="pricing">
    <div class="container-fluid" style="background-color: #F2F4F6;	box-shadow: 0 2px 12px 0 rgba(0,0,0,0.09);">

        <div class="container">
            <div class="row" id="price">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <div class="spacer35"></div>
                    <h1>产品价格</h1>
                    <div style="font-size:12px; padding:8px;color:#59A0FF; margin:0 auto; width: 364px;border-radius: 2px;	background-color: #dfecff;box-shadow: 1px 1px 1px rgba(0,0,0,.2);">
                        使用费用 = 订单费率 + 手续费

                    </div>
                </div>
            </div>

            <div class="row plans">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="plan">
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="plan-title">一次性注册费用</p>
                                <img src="<?php echo STATIC_ROOT?>picture/shop2.svg" class="plan-icon" style="width: 120px;">
                                <h2 class="plan-pricing"><?php echo $conf['reg_pay_price']?>元<span>由导演易支付收取注册费用</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="plan">
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="plan-title">三网支付订单费率</p>
                                <img src="<?php echo STATIC_ROOT?>picture/money.svg" class="plan-icon" alt="">
                                <h2 class="plan-pricing">3%<span>由导演易支付官方收取</span></h2>
                                <div style="font-size:12px;color:gray;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="plan">
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="plan-title">站长创业资助</p>
                                <img src="<?php echo STATIC_ROOT?>picture/doudou.svg" class="plan-icon" alt="">
                                <h2 class="plan-pricing">1-2%<span>初创项目有减免机制最低0.8%</span></h2>
                                <div style="font-size:12px;color:gray;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>开通流程</h1>
            <div style="font-size:12px; padding:8px;color:#fff; margin:0 auto; width: 364px;border-radius: 2px;	background-color: #6199f9;box-shadow: 1px 1px 1px rgba(0,0,0,.2);">
                自助开户，开通流程大概需要 3 分钟
            </div>
        </div>
        <style>
            #step span{
                font-size:12px;
                color:#59A0FF;
                background-color:#d9e9fe;
                padding:8px 30px;
                border-radius: 15px;
                margin:0 20px;
            }
        </style>
        <div class="col-md-12 hidden-sm" style="padding:80px 0;text-align: center;" id="step">
            <span>1.填写个人资料</span>
            <a>➤</a>
            <span>2.等待邮箱认证</span>
            <a>➤</a>
            <span>3.付费开通商户</span>
            <a>➤</a>
            <span>4.开始对接使用</span>
        </div>
    </div>
</div>

<div class="spacer10"></div>
<div class="spacer35"></div>

<footer style="padding-top:0;">
    <div class="container">

    </div>
    <div class="address" style="background: #0d3886;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <img src="<?php echo STATIC_ROOT?>picture/logo1.ico" style="width:30px;margin-bottom: 20px; opacity: 0.7;">
                    <address><?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;&nbsp;2020&nbsp;All Rights Reserved.&nbsp;<?php echo $conf['footer']?></address>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>