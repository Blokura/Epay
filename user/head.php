<?php
@header('Content-Type: text/html; charset=UTF-8');
if($userrow['status']==0){
	sysmsg('你的商户由于违反相关法律法规与《<a href="/?mod=agreement">"'.$conf['sitename'].'用户协议</a>》，已被禁用！');
}
switch($conf['user_style']){
	case 1: $style=['bg-black','bg-black','bg-white']; break;
	case 2: $style=['bg-dark','bg-white','bg-dark']; break;
	case 3: $style=['bg-dark','bg-dark','bg-light']; break;
	case 4: $style=['bg-info','bg-info','bg-black']; break;
	case 5: $style=['bg-info','bg-info','bg-white']; break;
	case 6: $style=['bg-primary','bg-primary','bg-dark']; break;
	case 7: $style=['bg-primary','bg-primary','bg-white']; break;
	default: $style=['bg-black','bg-white','bg-black']; break;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8" />
  <title><?php echo $title?> | <?php echo $conf['sitename']?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="stylesheet" href="//cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="//cdn.staticfile.org/animate.css/3.5.2/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="//cdn.staticfile.org/simple-line-icons/2.4.1/css/simple-line-icons.min.css" type="text/css" />
  <link rel="stylesheet" href="./assets/css/font.css" type="text/css" />
  <link rel="stylesheet" href="./assets/css/app.css" type="text/css" />

</head>
<body>
<div class="app app-header-fixed  ">
  <!-- header -->
  <header id="header" class="app-header navbar" role="menu">
          <!-- navbar header -->
      <div class="navbar-header <?php echo $style[0]?>">
        <button class="pull-right visible-xs dk" ui-toggle="show" target=".navbar-collapse">
          <i class="glyphicon glyphicon-cog"></i>
        </button>
        <button class="pull-right visible-xs" ui-toggle="off-screen" target=".app-aside" ui-scroll="app">
          <i class="glyphicon glyphicon-align-justify"></i>
        </button>
        <!-- brand -->
        <a href="./" class="navbar-brand text-lt">
          <i class="fa fa-btc"></i>
          <span class="hidden-folded m-l-xs"><?php echo $conf['sitename']?></span>
        </a>
        <!-- / brand -->
      </div>
      <!-- / navbar header -->

      <!-- navbar collapse -->
      <div class="collapse pos-rlt navbar-collapse box-shadow <?php echo $style[1]?>">
        <!-- buttons -->
        <div class="nav navbar-nav hidden-xs">
          <a href="#" class="btn no-shadow navbar-btn" ui-toggle="app-aside-folded" target=".app">
            <i class="fa fa-dedent fa-fw text"></i>
            <i class="fa fa-indent fa-fw text-active"></i>
          </a>
        </div>
        <!-- / buttons -->

        <!-- nabar right -->
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
              <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                <img src="<?php echo ($userrow['qq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'assets/img/user.png'?>">
                <i class="on md b-white bottom"></i>
              </span>
              <span class="hidden-sm hidden-md" style="text-transform:uppercase;"><?php echo $uid?></span> <b class="caret"></b>
            </a>
            <!-- dropdown -->
            <ul class="dropdown-menu animated fadeInRight w">
              <li>
                <a href="index.php">
                  <span>用户中心</span>
                </a>
              </li>
              <li>
                <a href="userinfo.php?mod=info">
                  <span>修改资料</span>
                </a>
              </li>
			  <li>
                <a href="userinfo.php?mod=account">
                  <span>修改密码</span>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a ui-sref="access.signin" href="login.php?logout">退出登录</a>
              </li>
            </ul>
            <!-- / dropdown -->
          </li>
        </ul>
        <!-- / navbar right -->
      </div>
      <!-- / navbar collapse -->
  </header>
  <!-- / header -->
  <!-- aside -->
  <aside id="aside" class="app-aside hidden-xs <?php echo $style[2]?>">
      <div class="aside-wrap">
        <div class="navi-wrap">

          <!-- nav -->
          <nav ui-nav class="navi clearfix">
            <ul class="nav">
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>导航</span>
              </li>
              <li class="<?php echo checkIfActive('index,')?>">
                <a href="./">
                  <i class="glyphicon glyphicon-home icon text-primary-dker"></i>
				  <b class="label bg-info pull-right">N</b>
                  <span class="font-bold">用户中心</span>
                </a>
              </li>
              <li class="<?php echo checkIfActive('userinfo,editinfo,certificate')?>">
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-leaf icon text-success-lter"></i>
                  <span>个人资料</span>
                </a>
                <ul class="nav nav-sub dk">
				  <li>
                    <a href="userinfo.php?mod=api">
                      <span>API信息</span>
                    </a>
                  </li>
                  <li>
                    <a href="editinfo.php">
                      <span>修改资料</span>
                    </a>
                  </li>
				  <li>
                    <a href="userinfo.php?mod=account">
                      <span>修改密码</span>
                    </a>
                  </li>
				  <?php if($conf['cert_channel']){?>
				  <li>
                    <a href="certificate.php">
                      <span>实名认证</span>
                    </a>
                  </li>
				  <?php }?>
                </ul>
              </li>
              <li class="line dk"></li>
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>查询</span>
              </li>
			  <li class="<?php echo checkIfActive('order')?>">
                <a href="order.php">
                  <i class="glyphicon glyphicon-list-alt"></i>
                  <span>订单记录</span>
                </a>
              </li>
			  <li class="<?php echo checkIfActive('settle')?>">
                <a href="settle.php">
                  <i class="glyphicon glyphicon-check"></i>
                  <span>结算记录</span>
                </a>
              </li>
			  <li class="<?php echo checkIfActive('record')?>">
                <a href="record.php">
                  <i class="glyphicon glyphicon-calendar"></i>
                  <span>资金明细</span>
                </a>
              </li>
			  <?php if($conf['settle_open']==2||$conf['settle_open']==3){?>
			  <li class="<?php echo checkIfActive('apply')?>">
                <a href="apply.php">
                  <i class="glyphicon glyphicon-edit"></i>
                  <span>申请提现</span>
                </a>
              </li>
			  <?php }?>
			  <?php if($conf['recharge']==1){?>
			  <li class="<?php echo checkIfActive('recharge')?>">
                <a href="recharge.php">
                  <i class="glyphicon glyphicon-yen"></i>
                  <span>余额充值</span>
                </a>
              </li>
			  <?php }?>
			  <?php if($conf['group_buy']==1){?>
			  <li class="<?php echo checkIfActive('groupbuy')?>">
                <a href="groupbuy.php">
                  <i class="glyphicon glyphicon-shopping-cart"></i>
                  <span>购买会员</span>
                </a>
              </li>
			  <?php }?>
              <li class="line dk hidden-folded"></li>

              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">          
                <span>其他</span>
              </li>
			  <?php if($conf['onecode']==1){?>
              <li class="<?php echo checkIfActive('onecode')?>">
                <a href="onecode.php">
                  <i class="fa fa-qrcode fa-fw"></i>
                  <span>一码支付</span>
                </a>
              </li>
			  <?php }?>
              <li>
                <a href="/doc.html" target="_blank">
                  <i class="fa fa-book"></i>
                  <span>开发文档</span>
                </a>
              </li>
			  <?php if(!empty($conf['qqqun'])){?>
              <li>
                <a href="<?php echo $conf['qqqun']?>" target="blank">
                  <i class="fa fa-qq"></i>
                  <span>产品QQ群</span>
                </a>
              </li>
			  <?php }?>
			  <?php if(!empty($conf['appurl'])){?>
              <li>
                <a href="<?php echo $conf['appurl']?>" target="blank">
                  <i class="fa fa-android"></i>
                  <span>APP下载</span>
                </a>
              </li>
			  <?php }?>
            </ul>
          </nav>
          <!-- nav -->

          <!-- aside footer -->
          <div class="wrapper m-t">
            <div class="text-center-folded">
              <span class="pull-right pull-none-folded">60%</span>
              <span class="hidden-folded">Milestone</span>
            </div>
            <div class="progress progress-xxs m-t-sm dk">
              <div class="progress-bar progress-bar-info" style="width: 60%;">
              </div>
            </div>
            <div class="text-center-folded">
              <span class="pull-right pull-none-folded">35%</span>
              <span class="hidden-folded">Release</span>
            </div>
            <div class="progress progress-xxs m-t-sm dk">
              <div class="progress-bar progress-bar-primary" style="width: 35%;">
              </div>
            </div>
          </div>
          <!-- / aside footer -->
        </div>
      </div>
  </aside>
  <!-- / aside -->
  <!-- content -->