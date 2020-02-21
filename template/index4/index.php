<?php
if(!defined('IN_CRONLITE'))exit();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $conf['title']?></title>
  <meta name="keywords" content="<?php echo $conf['keywords']?>">
  <meta name="description" content="<?php echo $conf['description']?>">
  <link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="<?php echo STATIC_ROOT?>css/app.min.css" type="text/css">
  <style type="text/css">.row {margin:0}</style>
</head>
<body>
  <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="./"><?php echo $conf['sitename']?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="./"><?php echo $conf['sitename']; ?></a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="/agreement.html" class="nav-link">
              <span class="nav-link-inner--text">服务条款</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="/doc.html" class="nav-link">
              <span class="nav-link-inner--text">开发文档</span>
            </a>
          </li>
		  <?php if($conf['test_open']==1){?>
		  <li class="nav-item">
			<a href="/user/test.php" class="nav-link">
              <span class="nav-link-inner--text">支付测试</span>
			</a>
          </li>
		  <?php }?>
          <li class="nav-item">
            <a href="/user/login.php" class="nav-link">
              <span class="nav-link-inner--text">商户登录</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="/user/reg.php" class="nav-link">
              <span class="nav-link-inner--text">商户注册</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']; ?>&site=pay&menu=yes" class="nav-link" target="_blank">
              <span class="nav-link-inner--text">联系客服</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-primary pt-5 pb-7">
      <div class="container">
        <div class="header-body">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="pr-5">
                <h1 class="display-2 text-white font-weight-bold mb-0"><?php echo $conf['sitename']?></h1>
                <h2 class="display-4 text-white font-weight-light"><font style="text-transform: uppercase;"><?php echo $_SERVER['HTTP_HOST']?></font>-我们专注的每一面，都是为了给你更好的体验</h2>
                <p class="text-white mt-4"><?php echo $conf['sitename']?>平台,以信誉求市场,以稳定求发展，行业内最安全，简单易用，专业的技术团队，最放心的免签约支付平台。</p>
                <div class="mt-5">
                  <a href="/user/" class="btn btn-neutral my-2">商户中心</a>
                  <a href="/doc.html" class="btn btn-default my-2">开发文档</a>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row pt-5">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow mb-4">
                        <i class="ni ni-active-40"></i>
                      </div>
                      <h5 class="h3">数据统计</h5>
                      <p>后台数据详尽直观，轻松管理查看交易数据统计分析各阶段数据占比。</p>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow mb-4">
                        <i class="ni ni-active-40"></i>
                      </div>
                      <h5 class="h3">快捷支付</h5>
                      <p>节省支付模块系统开发及维护成本，解决技术难点。</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pt-lg-5 pt-4">
                  <div class="card mb-4">
                    <div class="card-body">
                      <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow mb-4">
                        <i class="ni ni-active-40"></i>
                      </div>
                      <h5 class="h3">系统安全</h5>
                      <p>安全稳定的系统保障和专业的技术团队支持。</p>
                    </div>
                  </div>
                  <div class="card mb-4">
                    <div class="card-body">
                      <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow mb-4">
                        <i class="ni ni-active-40"></i>
                      </div>
                      <h5 class="h3">方便快捷</h5>
                      <p>一个操作平台，聚合多种交易渠道。</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <section class="py-6 pb-9 bg-default">
      <div class="row justify-content-center text-center">
        <div class="col-md-6">
          <h2 class="display-3 text-white">你凭什么选择我们？</h3>
            <p class="lead text-white">
              提供多种支付接入方式，方便，简单，快捷，快速集成到，效率高，见效快，费率低。支持全球三大主流结算币种，多元化产品为你提供一站式支付服务。无假期，无账期，365天随时随地提现。
            </p>
        </div>
      </div>
    </section>
    <section class="section section-lg pt-lg-0 mt--7">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape bg-gradient-primary text-white rounded-circle mb-4">
                      <i class="ni ni-check-bold"></i>
                    </div>
                    <h4 class="h3 text-primary text-uppercase">云支付</h4>
                    <p class="description mt-3">支持支付宝、微信、QQ钱包等主流支付渠道，让您拥有PC网页支付、扫码支付、移动HTML5支付。</p>
                    <div>
                      <span class="badge badge-pill badge-primary">支付宝</span>
                      <span class="badge badge-pill badge-primary">微信</span>
                      <span class="badge badge-pill badge-primary">QQ</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape bg-gradient-success text-white rounded-circle mb-4">
                      <i class="ni ni-istanbul"></i>
                    </div>
                    <h4 class="h3 text-success text-uppercase">云钱包</h4>
                    <p class="description mt-3">您的企业网站可以通过<?php echo $conf['sitename']?>为用户提供统一虚拟账户，提升用户支付体验，为拓展增值服务提供基础。</p>
                    <div>
                      <span class="badge badge-pill badge-success">资金统计</span>
                      <span class="badge badge-pill badge-success">订单明细</span>
                      <span class="badge badge-pill badge-success">渠道明细</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape bg-gradient-warning text-white rounded-circle mb-4">
                      <i class="ni ni-planet"></i>
                    </div>
                    <h4 class="h3 text-warning text-uppercase">云结算</h4>
                    <p class="description mt-3">Opao易支付通过简单的页面配置，可以替代复杂繁琐的人工资金结算业务，提高业务实时性，降低错误。</p>
                    <div>
                      <span class="badge badge-pill badge-warning">支付宝</span>
                      <span class="badge badge-pill badge-warning">微信支付</span>
                      <span class="badge badge-pill badge-warning">QQ钱包</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="py-6">
      <div class="container">
        <div class="row row-grid align-items-center">
          <div class="col-md-6 order-md-2">
            <img src="<?php echo STATIC_ROOT?>images/landing-1.jpg" class="img-fluid">
          </div>
          <div class="col-md-6 order-md-1">
            <div class="pr-md-5">
              <h1>聚合钱包，融合支付</h1>
              <p><?php echo $conf['sitename']?>通过简单的页面配置，可以替代复杂繁琐的人工资金结算业务，提高业务实时性，降低错误。</p>
              <ul class="list-unstyled mt-5">
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="ni ni-settings-gear-65"></i>
                      </div>
                    </div>
                    <div>
                      <h4 class="mb-0">长期稳定支付通道</h4>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="ni ni-html5"></i>
                      </div>
                    </div>
                    <div>
                      <h4 class="mb-0">方便快捷账号管理</h4>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="ni ni-satisfied"></i>
                      </div>
                    </div>
                    <div>
                      <h4 class="mb-0">高效实时监控订单</h4>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="py-6">
      <div class="container">
        <div class="row row-grid align-items-center">
          <div class="col-md-6">
            <img src="<?php echo STATIC_ROOT?>images/landing-2.jpg" class="img-fluid">
          </div>
          <div class="col-md-6">
            <div class="pr-md-5">
              <h1>高效技术服务</h1>
              <p>我们提供7X24小时在线服务，对日交易高额用户提供贵宾服务！用最具影响力品牌协助，并全力协助新兴品牌，我们以设计助力众多品牌走向行业领先地位，鼎力相助每一个梦想。</p>
              <a onclick="return confirm('请直奔主题,不要问在不在,节省彼此的时间,懂?')" href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']; ?>&site=qq&menu=yes" class="font-weight-bold text-warning mt-5" target="_blank">联系客服</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="py-6">
      <div class="container">
        <div class="row row-grid align-items-center">
          <div class="col-md-6 order-md-2">
            <img src="<?php echo STATIC_ROOT?>images/landing-3.jpg" class="img-fluid">
          </div>
          <div class="col-md-6 order-md-1">
            <div class="pr-md-5">
              <h1>快速资金回笼</h1>
              <p>一次轻松接入所有支付（QQ钱包，支付宝，微信），省时省心省力， 结算费率低，利润高！对接费率超低，比其它平台更便宜.全天监视订单 和资金安全，正规支付接口！</p>
              <a href="/doc.html" class="font-weight-bold text-info mt-5">了解更多...</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="py-7 section-nucleo-icons bg-white overflow-hidden">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2 class="display-3">展望未来</h2>
            <p class="lead">
              “我们趋行在人生这个亘古的旅途，在坎坷中奔跑，在挫折里涅槃，忧愁缠满全身，痛苦飘洒一地。我们累，却无从止歇；我们苦，却无法回避。”
            </p>
            <div class="btn-wrapper">
              <a href="/user/reg.php" class="btn btn-primary">申请商户</a>
              <a href="/doc.html" target="_blank" class="btn btn-default mt-3 mt-md-0">开发文档</a>
            </div>
          </div>
        </div>
        <div class="blur--hover">
          <a href="/user/agreement.php">
            <div class="icons-container blur-item mt-5">
              <!-- Center -->
              <i class="icon ni ni-diamond"></i>
              <!-- Right 1 -->
              <i class="icon icon-sm ni ni-album-2"></i>
              <i class="icon icon-sm ni ni-app"></i>
              <i class="icon icon-sm ni ni-atom"></i>
              <!-- Right 2 -->
              <i class="icon ni ni-cart"></i>
              <i class="icon ni ni-bell-55"></i>
              <i class="icon ni ni-credit-card"></i>
              <!-- Left 1 -->
              <i class="icon icon-sm ni ni-briefcase-24"></i>
              <i class="icon icon-sm ni ni-building"></i>
              <i class="icon icon-sm ni ni-button-play"></i>
              <!-- Left 2 -->
              <i class="icon ni ni-calendar-grid-58"></i>
              <i class="icon ni ni-camera-compact"></i>
              <i class="icon ni ni-chart-bar-32"></i>
            </div>
            <span class="blur-hidden h5 text-success">每一笔支付都承载着故事，感谢您选择我们</span>
          </a>
        </div>
      </div>
    </section>
  </div>
  <!-- Footer -->
  <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            <?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;&nbsp;2020&nbsp;All Rights Reserved.
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <?php echo $conf['footer']; ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <script src="<?php echo STATIC_ROOT?>js/jquery.min.js"></script>
  <script src="<?php echo STATIC_ROOT?>js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo STATIC_ROOT?>js/js.cookie.js"></script>
  <script src="<?php echo STATIC_ROOT?>js/jquery.scrollbar.min.js"></script>
  <script src="<?php echo STATIC_ROOT?>js/jquery-scrollLock.min.js"></script>
  <script src="<?php echo STATIC_ROOT?>js/jquery.lavalamp.min.js"></script>
  <script src="<?php echo STATIC_ROOT?>js/app.min.js"></script>
</body>
</html>