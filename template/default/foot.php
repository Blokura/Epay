<?php
if(!defined('IN_CRONLITE'))exit();
?>

<div class="address">
<footer>
<div class="container">
<div class="row">
<div class="col-xs-12 col-md-8 col-lg-9">
<ul class="porduct">
<h4>产品</h4>
<li><a href="agreement.html" target="_blank">服务条款</a></li>
<li><a href="doc.html" target="_blank">开发文档</a></li>
</ul>
<ul class="price">
<h4>关于我们</h4>
<li><?php echo $conf['sitename']?>是<?php echo $conf['orgname']?>旗下的免签约支付产品</li>
</ul>
<ul class="about"style="width: 40%;padding-left: 22px;">
<h4>联系我们</h4>
<li><strong>QQ:</strong><a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['kfqq']?>&Site=pay&Menu=yes" target="_blank"><?php echo $conf['kfqq']?></a></li>
<li><strong>Email:</strong><a href="mailto:<?php echo $conf['email']?>"><?php echo $conf['email']?></a></li>
</ul>
</div>

</div>
<div class="xinxi">
<p><?php echo $conf['sitename']?>&nbsp;&nbsp;&copy;2020&nbsp;All Rights Reserved.&nbsp;&nbsp;<?php echo $conf['footer']?></p>
</div>
<script type="text/javascript">
        if('ontouchend' in document.body &amp;&amp; $(window).width() < 996){
          $('.col-xs-12 .h2').css('text-align','center');
        }
      </script>
</div>
</footer>
</div>
</div>
</body>
</html> 