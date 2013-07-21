<?
/* * *******************************************************************************
 * El contenido de este archivo esta sujeto a la Public License Version 1.1.2
 * The Original Code is:  Eslendy Espinel Silva
 * The Initial Developer of the Original Code is Eslendy Espinel Silva.
 * Portions created by Eslendy Espinel Silva.
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 * ****************************************************************************** */
//Carga Archivo de vigilancia de las sessiones 
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

//@ini_set('display_errors', 0);


require("vigia.php");
//var_dump($_REQUEST);
//error_reporting(E_ALL & ~E_NOTICE);

try {
//carge de archivos de configuracion basicos
require("libphp/config.inc.php");
require("libphp/mysql.php");

require($_SERVER['DOCUMENT_ROOT'] . 'xng/lib/bootstrap.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Austra - Admin template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- end: Meta -->

        <!-- start: CSS -->
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/bootstrap/css/bootstrap-responsive.css">   
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/font-awesome/font-awesome.html">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" type="text/css" href='/templates/austra/assets/lib/fullcalendar/fullcalendar.print.css' media='print'>
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/jasny/bootstrap-fileupload.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/pnotify/jquery.pnotify.default.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/pnotify/jquery.pnotify.default.icons.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/todo/css/base.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/lib/todo/css/app.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/css/icheckcss.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/css/masonry.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/css/wizard.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/css/bootstrap-wysihtml5.css" >
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/css/jquery.spellchecker.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/css/slider.css">
        <link rel="stylesheet" type="text/css" href="/templates/austra/assets/css/style.css">
        <!-- end: CSS -->

        <!-- start: JS -->
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="/templates/austra/assets/js/jquery-1.9.1.js"></script>
        <script src="/templates/austra/assets/lib/bootstrap/js/bootstrap.js"></script>
        <script src="/templates/austra/assets/lib/fullcalendar/fullcalendar.min.js"></script>
        <script src="/templates/austra/assets/lib/pnotify/jquery.pnotify.min.js"></script>
        <script src="/templates/austra/assets/lib/jasny/bootstrap-fileupload.js"></script>
        <script src="/templates/austra/assets/lib/jasny/bootstrap-inputmask.js"></script>
        <script src="/templates/austra/assets/lib/jasny/bootstrap-typeahead.js"></script>   
        <script src="/templates/austra/assets/lib/justgage/justgage.1.0.1.js"></script>
        <script src="/templates/austra/assets/lib/justgage/raphael.2.1.0.min.js"></script> 
        <script src="/templates/austra/assets/lib/flot/jquery.flot.js"></script>
        <script src="/templates/austra/assets/lib/flot/excanvas.js"></script>
        <script src="/templates/austra/assets/lib/flot/jquery.flot.pie.js"></script>
        <script src="/templates/austra/assets/lib/flot/jquery.flot.stack.js"></script>
        <script src="/templates/austra/assets/js/responsive-tables.js"></script>
        <script src="/templates/austra/assets/js/jquery.sparkline.js"></script>
        <script src="/templates/austra/assets/js/bootstrap-slider.js"></script>
        <script src="/templates/austra/assets/js/icheckdemo.js"></script>
        <script src="/templates/austra/assets/js/charts.js"></script>
        <script src="/templates/austra/assets/js/date.js"></script>
        <script src="/templates/austra/assets/js/daterangepicker.js"></script>   
        <script src="/templates/austra/assets/js/jquery.icheck.js"></script>    
        <script src="/templates/austra/assets/js/wizard.js"></script>
        <script src="/templates/austra/assets/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="/templates/austra/assets/js/wysihtml5-0.3.0.js"></script>
        <script src="/templates/austra/assets/js/bootstrap-wysihtml5.js"></script>
        <script src="/templates/austra/assets/js/prettyprint.js"></script>
        <script src="/templates/austra/assets/js/jquery.spellchecker.js"></script>
        <script src="/templates/austra/assets/js/parsley.js"></script>
        <script src="/templates/austra/assets/js/jquery.masonry.min.js"></script>
        <script src="/templates/austra/assets/js/custom.js"></script>
        <script src="<? echo $SERVER_NAME; ?>js/jGeneral.js" type="text/javascript"></script>
        <!-- end: JS -->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="http://www.mickael-girault.fr/preview/assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.html">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.html">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.html">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.html">

        <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
        <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
        <!--[if IE 8 ]> <body class="ie ie8 "> 
        <style type="text/css">
            .navbar form.search input,.sidebar-nav form.search input,.sidebar-label,.thumb-account{border: none;}
            .thumb-account span {width: 2px;}
            .sidebar-nav .form-inline { display: none;}
        </style>
        <![endif]-->

        <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->

        <!--[if gte IE 9]>
         <style type="text/css">.gradient {filter: none;}</style>
        <![endif]-->

    </head><!--end: head -->
    <?
    require("menu/clases/menu_class.php");
    $menu = new menu($conexion['local']);
    ?>
    <body> 

        <div class="navbar">
            <div class="navbar-inner">

                <ul class="nav pull-right">

                    <li>
                        <form action="#" class="search form-inline">
                            <input type="text" placeholder="Search...">
                            <button class="search-submit btn-search" value="" type="submit"><i class="icon-search"></i></button>                        
                        </form>                        

                    </li>

                    <li class="dropdown header-border">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="email-notify"><i class="icon-envelope-alt"></i><span class="email-alert"><i class="icon-circle"></i> </span></span>
                        </a>

                        <ul class="dropdown-menu block-dark messages">
                            <li class="view-all"><a href="#">View all messages</a></li>   
                            <li><a href="#">
                                    <div class="avatar"><img height="45" width="45" src="/templates/austra/assets/images/face-1.jpg" alt="Your profile"></div>
                                    <div class="info">Antonio Heide <span class="timer">36 min</span></div>    
                                    <div class="message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem necessitatibus.</div>
                                </a>
                            </li>
                            <li><a href="#">
                                    <div class="avatar"><img height="45" width="45" src="/templates/austra/assets/images/face-2.jpg" alt="Your profile"></div>
                                    <div class="info">Melissa Evans <span class="timer">52 min</span></div>    
                                    <div class="message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis optio ad placeat incidunt iste non enim nisi quae culpa.</div>
                                </a>
                            </li>                                               
                        </ul>
                    </li>   

                    <li class="dropdown header-border">
                        <a href="#" role="button" class="dropdown-toggle " data-toggle="dropdown">
                            <div class="notify">7</div>
                        </a>

                        <ul class="dropdown-menu block-dark messages msg-notify">
                            <li class="view-all"><a href="#">View all notifications</a></li>   
                            <li><a href="#"><div><i class="icon-comment"></i>  new comment <span class="timer">2 min</span></div></a>                        
                            <li><a href="#"><div><i class="icon-twitter"></i>  new follower <span class="timer">6 min</span></div></a> 
                            <li><a href="#"><div><i class="icon-thumbs-up"></i> new like <span class="timer">9 min</span></div></a>                        
                            <li><a href="#"><div><i class="icon-twitter"></i>  new follower <span class="timer">25 min</span></div></a> 
                            <li><a href="#"><div><i class="icon-user"></i>  new registration <span class="timer">32 min</span></div></a>                        
                            <li><a href="#"><div><i class="icon-comment"></i>  new comment <span class="timer">2 hours</span></div></a>     
                            <li><a href="#"><div><i class="icon-map-marker"></i>  new localization <span class="timer">Yesterday</span></div></a>     
                        </ul>
                    </li>                                   

                    <li class="dropdown header-border">
                        <a href="#" role="button" class="dropdown-toggle " data-toggle="dropdown">
                            <div class="thumb-account">
                                <img height="20" width="20" src="/templates/austra/assets/images/timeline-team.jpg" alt="Your profile">
                                <span><i class="icon-caret-down"></i></span>
                            </div>
                        </a>

                        <ul class="dropdown-menu block-dark account">
                            <li class="first"><a tabindex="-1" href="#"><i class="icon-user"></i> Your profile</a></li>
                            <li class="first"><a tabindex="-1" href="#"><i class="icon-cogs"></i> Settings</a></li>
                            <li><a tabindex="-1" href="sign-out.html"><i class="icon-signin"></i> Log in</a></li>
                            <li class="last notify-disabled"><a tabindex="-1" href="sign-in.html"><i class="icon-signout"></i> Logout</a></li>
                        </ul>
                    </li>


                </ul>
                <a class="brand" href="/"><span class="title">Faktury</span> <span class="logo"></span></a>
            </div>
        </div><!-- navbar --> 


        <div data-offset-top="360" data-spy="affix" class="sidebar-nav affix">
            <form class="search form-inline">
                <input type="text" placeholder="Search...">
                <button class="search-submit btn-search" value="" type="submit"><i class="icon-search"></i></button>                        
            </form>    

            <div class="sidebar-avatar">
                <img src="/templates/austra/assets/images/team-1.jpg" alt="avatar" class="thumbnail-avatar">
                <a href="#"><div class="sidebar-avatar-message"><div class="notify notify-message"><i class="icon-envelope"></i></div></div></a>
                <a href="#"><div class="sidebar-avatar-notify"><div class="notify ">7</div></div></a>
            </div>


            <a data-toggle="collapse" data-target=".nav-collapse" class="btn-sidebar">
                <span class="notify navigation span12"><i class="icon-reorder"></i> Navigation <span class="pull-right label sidebar-label label-danger"><i class="icon-angle-down"></i> </span></span>
            </a>


            <div class="nav-collapse subnav-collapse collapse ">
                
                
                <? echo $menu->make_menu($_SESSION['perfil'], 0); ?>
               

            </div>



        </div><!-- sidebar --> 

        <div class="content">

            <div class="header">
                <div class="stats">
                    <div class="stat-box notify-disabled">
                        <i class="icon-group"></i>
                        <span class="count badge">44</span>
                        <span class="stat-text">Users</span>
                    </div>
                    <div class="stat-box notify-disabled">
                        <i class="icon-shopping-cart"></i>
                        <span class="count badge badge-success">56</span>
                        <span class="stat-text">Orders </span>
                    </div>
                    <div class="stat-box notify-disabled">
                        <i class="icon-calendar"></i>
                        <span class="count badge badge-info">6</span>
                        <span class="stat-text">Metting </span>
                    </div>
                    <div class="stat-box notify-disabled">
                        <i class="icon-wrench"></i>
                        <span class="count badge badge-important">23</span>
                        <span class="stat-text">Tickets </span>
                    </div>
                    <div class="stat-box notify-disabled">
                        <i class="icon-download-alt"></i>
                        <span class="count badge badge-warning">15</span>
                        <span class="stat-text">Requests </span>
                    </div>                                                                   

                </div>

                <h1 class="page-title">Tables</h1>
            </div><!-- header --> 

            <ul class="breadcrumb">
                <li><a href="#">Home</a> <span class="divider"><i class="icon-chevron-right"></i></span></li>
                <li><a href="#">Forms</a> <span class="divider"><i class="icon-chevron-right"></i></span></li>
                <li class="active">Tables</li>
            </ul><!-- breadcrumb -->           



            <div class="wrapper-content">
                <div class="container-fluid">
                    <div class="row-fluid">

                        <div class="alert alert-info">
                            <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
                            <strong>Note :</strong> Add <span class="label label-info">.responsive</span> table to small device.
                        </div>    
                        
                        <div id="menu_secundario" class="pull-left span11">
                            <? echo $menu->menu_lateral($_SESSION['perfil'], ($_GET['c'])); ?>
                        </div>

                        <div class="row-fluid">
                            <div class="block  block-head-btn span12 unstyled-modal">
                                <div class="block-heading">

                                    <span class="pull-right">
                                        <button data-toggle="modal" class="btn btn-primary" href="#myModal1"><i class="icon-cog"></i></button>
                                    </span>

                                    <div aria-hidden="true" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1" class="modal hide fade" id="myModal1" style="display: none;">
                                        <div class="modal-header modal-default">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                                            <h3 id="myModalLabel1">Setting</h3>
                                        </div>
                                        <div class="modal-body">

                                            <form action="#" class="inbox-form">

                                                <table class="responsive table">  
                                                    <tbody>
                                                        <tr>
                                                            <td class="td-check"><input type="checkbox"></td>
                                                            <td class="td-star">Lorem ipsum dolor sit amet, consectetur adipisicing elit!</td>
                                                        </tr> 
                                                        <tr>
                                                            <td class="td-check"><input type="checkbox"></td>
                                                            <td class="td-star">Similique cumque officia voluptates provident recusandae.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-check"><input type="checkbox"></td>
                                                            <td class="td-star">Ullam laudantium consectetur at voluptas mollitia saepe in quas provident.</td>
                                                        </tr> 
                                                    </tbody>
                                                </table>                           

                                            </form> 

                                        </div>
                                        <div class="modal-footer">
                                            <button aria-hidden="true" data-dismiss="modal" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>  

                                    <a href="#collapse-table-search-dark" data-toggle="collapse">Table</a>
                                </div>
                                
                                <div id="collapse-table-search-dark" class="collapse in">

                                    <div class="table-option clearfix">

                                        <span class="pull-left keywords">
                                            <form action="#" class="form-inline">
                                                <input name="q" class="table-form" type="text"  placeholder="Keywords: Ruby, Rails, Django" >
                                                <button type="submit" class="btn btn-primary"> <i class="icon-search icon-white"></i></button>
                                            </form>
                                        </span>
                                        <span class="pull-right">
                                            <button class="btn btn-danger"><i class="icon-chevron-left"></i></button>
                                            <button class="btn btn-danger"><i class="icon-chevron-right"></i></button>
                                        </span>


                                    </div>

                                    <div id="cuerpo">
                                        <?
                                        // var_dump($_REQUEST);
                                        if (isset($_GET['c']) && !empty($_GET['c']) && ($_GET['c']) != 'index.php') {
                                            include(($_GET['c']));
                                        }
                                        ?>
                                    </div>
                                  


                                </div>
                            </div>


                        </div>  


<?/*
                        <div class="row-fluid">
                            <div class="block  span6">
                                <div class="block-heading">
                                    <span class="block-icon pull-right">
                                        <a href="#" class="demo-cancel-click" rel="tooltip" title="Export"><i class="icon-external-link"></i></a>
                                    </span>

                                    <a href="#collapse-table-2" data-toggle="collapse">Table</a>
                                </div>
                                <div id="collapse-table-2" class="collapse in">

                                    <table class="responsive table">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Date registered</th>
                                                <th>Location</th>
                                                <th>Status</th>                                          
                                            </tr>
                                        </thead>   
                                        <tbody>
                                            <tr>
                                                <td>Wyatt Prescott</td>
                                                <td class="center">2013/03/01</td>
                                                <td class="center">Austin</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Taylor Barrett</td>
                                                <td class="center">2013/02/01</td>
                                                <td class="center">London</td>
                                                <td class="center">
                                                    <span class="label label-important">Banned</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Janet Parker</td>
                                                <td class="center">2013/04/01</td>
                                                <td class="center">New York</td>
                                                <td class="center">
                                                    <span class="label label-disabled">Inactive</span>
                                                </td>                                        
                                            </tr>
                                            <tr>
                                                <td>Roberta Hansen</td>
                                                <td class="center">2013/07/01</td>
                                                <td class="center">Boston</td>
                                                <td class="center">
                                                    <span class="label label-warning">Pending</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Marvin Lawson</td>
                                                <td class="center">2013/09/01</td>
                                                <td class="center">Seatle</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                        
                                            </tr>                                   
                                        </tbody>
                                    </table>

                                    <div class="pagination pagination-centered">
                                        <ul>
                                            <li><a href="#">Prev</a></li>
                                            <li class="active">
                                                <a href="#">1</a>
                                            </li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">Next</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <div class="block  span6">
                                <div class="block-heading">
                                    <span class="block-icon pull-right">
                                        <a href="#" class="demo-cancel-click" rel="tooltip" title="Export"><i class="icon-external-link"></i></a>
                                    </span>

                                    <a href="#collapse-striped" data-toggle="collapse">Table-striped </a>
                                </div>
                                <div id="collapse-striped" class="collapse in">

                                    <table class="responsive table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Date registered</th>
                                                <th>Location</th>
                                                <th>Status</th>                                          
                                            </tr>
                                        </thead>   
                                        <tbody>
                                            <tr>
                                                <td>Wyatt Prescott</td>
                                                <td class="center">2013/03/01</td>
                                                <td class="center">Austin</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Taylor Barrett</td>
                                                <td class="center">2013/02/01</td>
                                                <td class="center">London</td>
                                                <td class="center">
                                                    <span class="label label-important">Banned</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Janet Parker</td>
                                                <td class="center">2013/04/01</td>
                                                <td class="center">New York</td>
                                                <td class="center">
                                                    <span class="label label-disabled">Inactive</span>
                                                </td>                                        
                                            </tr>
                                            <tr>
                                                <td>Roberta Hansen</td>
                                                <td class="center">2013/07/01</td>
                                                <td class="center">Boston</td>
                                                <td class="center">
                                                    <span class="label label-warning">Pending</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Marvin Lawson</td>
                                                <td class="center">2013/09/01</td>
                                                <td class="center">Seatle</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                        
                                            </tr>                                   
                                        </tbody>
                                    </table>

                                    <div class="pagination pagination-centered">
                                        <ul>
                                            <li><a href="#">Prev</a></li>
                                            <li class="active">
                                                <a href="#">1</a>
                                            </li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">Next</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>              




*/?>

                    </div>
                </div>
            </div><!-- wrapper-content -->     


        </div><!-- content -->   

        <div class="clearfix">  </div> 

        <div class="content content-dark">

            <div class="wrapper-content">
                <div class="container-fluid">


                    <div class="alert alert-info">
                        <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
                        <strong>Note :</strong> Add <span class="label label-info">.content-dark</span> and <span class="label label-info">.block-dark</span> to set the dark theme.
                    </div>    

                    <div class="row-fluid">

                        <div class="row-fluid">
                            <div class="block block-dark block-head-btn span12 unstyled-modal">
                                <div class="block-heading">

                                    <span class="pull-right">
                                        <button data-toggle="modal" class="btn btn-primary" href="#myModal2"><i class="icon-cog"></i></button>
                                    </span>

                                    <div aria-hidden="true" aria-labelledby="myModalLabel2" role="dialog" tabindex="-1" class="modal hide fade" id="myModal2" style="display: none;">
                                        <div class="modal-header modal-default">
                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                                            <h3 id="myModalLabel2">Setting</h3>
                                        </div>
                                        <div class="modal-body">

                                            <form action="#" class="inbox-form">

                                                <table class="responsive table">  
                                                    <tbody>
                                                        <tr>
                                                            <td class="td-check"><input type="checkbox"></td>
                                                            <td class="td-star">Lorem ipsum dolor sit amet, consectetur adipisicing elit!</td>
                                                        </tr> 
                                                        <tr>
                                                            <td class="td-check"><input type="checkbox"></td>
                                                            <td class="td-star">Similique cumque officia voluptates provident recusandae.</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-check"><input type="checkbox"></td>
                                                            <td class="td-star">Ullam laudantium consectetur at voluptas mollitia saepe in quas provident.</td>
                                                        </tr> 
                                                    </tbody>
                                                </table>                           

                                            </form> 

                                        </div>
                                        <div class="modal-footer">
                                            <button aria-hidden="true" data-dismiss="modal" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>  

                                    <a href="#collapse-table-search" data-toggle="collapse">Table</a>
                                </div>
                                <div id="collapse-table-search" class="collapse in">

                                    <div class="table-option clearfix">

                                        <span class="pull-left">
                                            <form action="#" class="form-inline form-dark" >
                                                <input name="q" class="table-form" type="text"  placeholder="Keywords: Ruby, Rails, Django" >
                                                <button type="submit" class="btn btn-primary"> <i class="icon-search icon-white"></i></button>
                                            </form>
                                        </span>
                                        <span class="pull-right">
                                            <button class="btn btn-danger"><i class="icon-chevron-left"></i></button>
                                            <button class="btn btn-danger"><i class="icon-chevron-right"></i></button>
                                        </span>


                                    </div>


                                    <table class="responsive table">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Date registered</th>
                                                <th>Location</th>
                                                <th>Status</th>                                          
                                            </tr>
                                        </thead>   
                                        <tbody>
                                            <tr>
                                                <td>Wyatt Prescott</td>
                                                <td class="center">2013/03/01</td>
                                                <td class="center">Austin</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Taylor Barrett</td>
                                                <td class="center">2013/02/01</td>
                                                <td class="center">London</td>
                                                <td class="center">
                                                    <span class="label label-important">Banned</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Janet Parker</td>
                                                <td class="center">2013/04/01</td>
                                                <td class="center">New York</td>
                                                <td class="center">
                                                    <span class="label label-disabled">Inactive</span>
                                                </td>                                        
                                            </tr>
                                            <tr>
                                                <td>Roberta Hansen</td>
                                                <td class="center">2013/07/01</td>
                                                <td class="center">Boston</td>
                                                <td class="center">
                                                    <span class="label label-warning">Pending</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Marvin Lawson</td>
                                                <td class="center">2013/09/01</td>
                                                <td class="center">Seatle</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                        
                                            </tr>  
                                            <tr>
                                                <td>Taylor Barrett</td>
                                                <td class="center">2013/02/01</td>
                                                <td class="center">London</td>
                                                <td class="center">
                                                    <span class="label label-important">Banned</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Janet Parker</td>
                                                <td class="center">2013/04/01</td>
                                                <td class="center">New York</td>
                                                <td class="center">
                                                    <span class="label label-disabled">Inactive</span>
                                                </td>                                        
                                            </tr>
                                            <tr>
                                                <td>Roberta Hansen</td>
                                                <td class="center">2013/07/01</td>
                                                <td class="center">Boston</td>
                                                <td class="center">
                                                    <span class="label label-warning">Pending</span>
                                                </td>                                       
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>


                        </div>  



                        <div class="row-fluid">
                            <div class="block block-dark span6">
                                <div class="block-heading">
                                    <span class="block-icon pull-right">
                                        <a href="#" class="demo-cancel-click" rel="tooltip" title="Export"><i class="icon-external-link"></i></a>
                                    </span>

                                    <a href="#collapse-table" data-toggle="collapse">Table</a>
                                </div>
                                <div id="collapse-table" class="collapse in">

                                    <table class="responsive table">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Date registered</th>
                                                <th>Location</th>
                                                <th>Status</th>                                          
                                            </tr>
                                        </thead>   
                                        <tbody>
                                            <tr>
                                                <td>Wyatt Prescott</td>
                                                <td class="center">2013/03/01</td>
                                                <td class="center">Austin</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Taylor Barrett</td>
                                                <td class="center">2013/02/01</td>
                                                <td class="center">London</td>
                                                <td class="center">
                                                    <span class="label label-important">Banned</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Janet Parker</td>
                                                <td class="center">2013/04/01</td>
                                                <td class="center">New York</td>
                                                <td class="center">
                                                    <span class="label label-disabled">Inactive</span>
                                                </td>                                        
                                            </tr>
                                            <tr>
                                                <td>Roberta Hansen</td>
                                                <td class="center">2013/07/01</td>
                                                <td class="center">Boston</td>
                                                <td class="center">
                                                    <span class="label label-warning">Pending</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Marvin Lawson</td>
                                                <td class="center">2013/09/01</td>
                                                <td class="center">Seatle</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                        
                                            </tr>                                   
                                        </tbody>
                                    </table>

                                    <div class="pagination pagination-centered">
                                        <ul>
                                            <li><a href="#">Prev</a></li>
                                            <li class="active">
                                                <a href="#">1</a>
                                            </li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">Next</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <div class="block block-dark  span6">
                                <div class="block-heading">
                                    <span class="block-icon pull-right">
                                        <a href="#" class="demo-cancel-click" rel="tooltip" title="Export"><i class="icon-external-link"></i></a>
                                    </span>

                                    <a href="#collapse-striped-2" data-toggle="collapse">Table-striped </a>
                                </div>
                                <div id="collapse-striped-2" class="collapse in">

                                    <table class="responsive table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Date registered</th>
                                                <th>Location</th>
                                                <th>Status</th>                                          
                                            </tr>
                                        </thead>   
                                        <tbody>
                                            <tr>
                                                <td>Wyatt Prescott</td>
                                                <td class="center">2013/03/01</td>
                                                <td class="center">Austin</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Taylor Barrett</td>
                                                <td class="center">2013/02/01</td>
                                                <td class="center">London</td>
                                                <td class="center">
                                                    <span class="label label-important">Banned</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Janet Parker</td>
                                                <td class="center">2013/04/01</td>
                                                <td class="center">New York</td>
                                                <td class="center">
                                                    <span class="label label-disabled">Inactive</span>
                                                </td>                                        
                                            </tr>
                                            <tr>
                                                <td>Roberta Hansen</td>
                                                <td class="center">2013/07/01</td>
                                                <td class="center">Boston</td>
                                                <td class="center">
                                                    <span class="label label-warning">Pending</span>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Marvin Lawson</td>
                                                <td class="center">2013/09/01</td>
                                                <td class="center">Seatle</td>
                                                <td class="center">
                                                    <span class="label label-success">Active</span>
                                                </td>                                        
                                            </tr>                                   
                                        </tbody>
                                    </table>

                                    <div class="pagination pagination-centered">
                                        <ul>
                                            <li><a href="#">Prev</a></li>
                                            <li class="active">
                                                <a href="#">1</a>
                                            </li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">Next</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>              






                    </div>
                </div>
            </div><!-- wrapper-content -->     


        </div><!-- content -->    

        <footer>
            <div class="clearfix">
                <p class="pull-left"><a class="notify-disabled" href="#"><i class="icon-chevron-up"></i></a></p>
                <p class="pull-right">&copy; 2013 <a href="http://mickael-girault.fr/" target="_blank">Bootstrap Trooper</a></p>
            </div>
        </footer><!-- footer -->     


        <script type="text/javascript">
            //tooltip
            $("[rel=tooltip]").tooltip();
            $(function() {
                $('.demo-cancel-click').click(function() {
                    return false;
                });
            });
        </script>	 

        <script type="text/javascript">
            //tab
            $('#myTab a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            })
        </script> 	

    </body>
    <?PHP
    } catch (Exception $e) {
        //impresion de excepciones
        echo $e->getMessage();
    }
    ?>
    <script type="text/javascript">var init =<?php echo json_encode(Page::loadVars()) ?></script>   
</html>