<?php 
header("Content-type:text/html;charset=utf-8");
//exit('升级中...');
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>企业名称测字，公司名称测吉凶</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://v3.bootcss.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="http://v3.bootcss.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://v3.bootcss.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .jumbotron .btn{
            font-size: 14px;
            padding: 6px 20px 6px 20px;
        }
        th{ text-align: center}
    </style>
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <h3 class="text-muted">企业名称测字，公司名称测吉凶</h3>
      </div>

      <div class="jumbotron">
        <p>
            <div class="form-inline">
              <div class="form-group">
                <input type="text" size="35" class="form-control" id="text" placeholder="输入要测的公司名">
              </div>
              <button type="button" class="btn btn-primary" id="btn">测算</button>
            </div>
        </p>
        
        <div id="res">  
        </div>
        <p><hr /></p>
        <p style="text-align:left; font-size:14px; line-height:1.3em;">一个吉祥如意的公司名字是迈向成功的第一步，好的商号名称是公司财富的源泉，昭示着灿烂辉煌的前景，利用三藏算命大全的免费公司名字测算系统立即查询测算店铺名字，公司商号的名称蕴含信息。</p>
      </div>

      <div class="row marketing">
        <div class="col-lg-6">
          <h4>基于五格三才算法</h4>
          <p>测名打分系统是结合了周易测名，按名字笔划的三才吉凶测试名字好坏的方法，具有一定的准确性和参考价值。</p>
        </div>

        <div class="col-lg-6">
          <h4>仅支持汉字</h4>
          <p>可以测试企业名称、商标名称、产品名称、网站名称、小区名称等行业名称，输入必须为中文，不支持英文和数字。</p>
        </div>
      </div>

      <footer class="footer">
        <p>&copy; Xizhi.com 2016</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://v3.bootcss.com/assets/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript">
    //测算
    function cesuan() {
      $(this).attr("disabled", true);
      companyname = $('#text').val();
      $.ajax({
        type: "GET",
        url: "/cezi/src/worker.php?words="+companyname,
        dataType: "JSON",
        success: function(data){
          if (data.status) {
            var charlist = '';
            for(var p in data.content.list){
              charlist += '<tr><td>'+data.content.list[p].char+'</td><td>'+data.content.list[p].big5+'</td><td>'+data.content.list[p].pinyin+'</td><td>'+data.content.list[p].bihua+'</td></tr>';
            }
            $('#btn').removeAttr("disabled"); 
            $('#res').html('<div class="panel panel-default"><div class="panel-heading">测算结果</div><table class="table"><thead><tr><th>字</th><th>繁体</th><th>拼音</th><th>笔画</th></tr></thead><tbody>'+charlist+'<tr><td>数理值：</td><td colspan="3">'+data.content.shuli+'</td></tr><tr><td>吉凶：</td><td colspan="3">'+data.content.pizhu.jx+'</td></tr><tr><td>解释：</td><td colspan="3">'+data.content.pizhu.yili+'</td></tr></tbody></table></div>');
          } else {
            $('#btn').removeAttr("disabled"); 
            $('#res').html('<font color="red">'+data.error+'</font>');
          }
        }
      });
    }
    $(document).ready(function(){
      //响应鼠标事件
      $("#btn").click(function(){
        cesuan();
      });
      //响应键盘回车事件
      $('input:text:first').focus();
        var $inp = $('input');
        $inp.keypress(function (e) {
          var key = e.which; //e.which是按键的值 
          if (key == 13) { 
            cesuan();
          }
      });
    });
    </script>
  </body>
</html>
