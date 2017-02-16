<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>用户登录</title>
        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <!-- bootstrap & fontawesome必须的css -->
        <link rel="stylesheet" href="/Public/ace/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/Public/font-awesome/css/font-awesome.min.css" />
        <!-- ACE样式-->
        <link rel="stylesheet" href="/Public/ace/css/ace.min.css" />
        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/Public/ace/css/ace-part2.min.css" />
        <![endif]-->

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/Public/ace/css/ace-ie.css" />
        <![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="/Public/others/html5shiv.min.js"></script>
        <script src="/Public/others/respond.min.js"></script>
        <![endif]-->
        <style>
            .error{
                height:20px;
            }
        </style>
    </head>
    <body class="login-layout blur-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-leaf green"></i>
                                    <span class="red">repairMS</span>
                                    <span  class="blue" style="font-family:microsoft yahei" id="id-text2">维修管理平台</span>
                                </h1>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger text-center">
                                                <i class="ace-icon fa fa-coffee green"></i>
                                                用户登录
                                            </h4>

                                            <div class="space-6"></div>
                                            <form class="ajaxForm3" name="login" id="login">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" class="form-control" name="username" id="username" placeholder="用户名" required/>
                                                            <i class="ace-icon fa fa-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" name="pwd" id="pwd" placeholder="输入密码" required/>
                                                            <i class="ace-icon fa fa-lock"></i>
                                                        </span>
                                                    </label>                                                   
                                                    <div id="captcha"></div>
                                                    
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" class="form-control" name="verify" id="verify" placeholder="输入验证码" required/>
                                                            <i class="ace-icon fa fa-sort-alpha-asc"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block text-center">
                                                            <img style='cursor:pointer;' onclick="this.src='<?php echo U('vercode');?>#'+Math.random();" src="<?php echo U('vercode')?>">
                                                        </span>
                                                    </label>
                                                    
                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" class="ace" name='rember'/>
                                                            <span class="lbl"> 记住信息</span>
                                                        </label>
                                                        
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-primary" id='btn'>
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <span class="bigger-110">登录</span>                                                         
                                                        </button>
                                                    </div>
                                                    <div  class="error" id="error"></div>

                                                    <!--<div class="space-4"></div>-->                          
                                                </fieldset>
                                            </form>
                                        </div><!-- /.widget-main -->
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->
                            </div><!-- /.position-relative -->

                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- 基本的js -->
        <!--[if !IE]> -->
        <!--<script src="/Public/others/jquery.min-2.2.1.js"></script>-->
        <!-- <![endif]-->
        <!-- 如果为IE,则引入jq1.12.1 -->
        <!--[if IE]>-->
        <script src="/Public/others/jquery.min-1.12.1.js"></script>
<!--        <![endif]-->
        <!-- jquery.form、layer、yfcmf的js -->
        <script src="/Public/others/bootstrap.min.js"></script>
        <script src="/Public/others/jquery.form.js"></script>
        <script src="/Public/layer/layer_zh-cn.js"></script>
        <script src="/Public/others/maxlength.js"></script>
        <!--<script src="/Public/yfcmf/yfcmf.js"></script>-->
        <!--<script src="http://static.geetest.com/static/tools/gt.js"></script>-->
        <!-- 如果为触屏,则引入jquery.mobile -->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='/Public/others/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        
        <!--ajax登录验证-->
        <script>           
            $("#btn").click(function(){
                
                var form = $("#login");
                var formData = form.serialize();
                
                $.ajax({
                    type:"POST",
                    url:"<?php echo U('ajaxLogin'); ?>",
                    data:formData,
                    dataType:"json",
                    success:function(data){
                        var errorInfo = '<p style="color:red">'+data.info+'</p>'; 
                        var err = "123sak";
                        $("#error").html(errorInfo);                       
                    }
                });
            });           
        </script>
        
    </body>
</html>