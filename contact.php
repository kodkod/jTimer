<?php
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>jTimer - Contact Me</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="jTimer is the easiest way to track your timer on projects and clients. It uses Javascript LocalStorage and can work Offline. All you need is a browser">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/colorbox.css" rel="stylesheet" />
    <!-- <link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'> -->
    <style type="text/css">
      body {
      	font-family: 'Raleway', sans-serif;
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!-- <link rel="shortcut icon" href="../assets/ico/favicon.ico"> -->
  </head>

  <body>
	<a id='forkme' href="https://github.com/you"><img style="position: absolute; top: 40px; left: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_left_orange_ff7600.png" alt="Fork me on GitHub"></a>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/">jTimer</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="/">Home</a></li>
              <li><a href="/about">About</a></li>
              <li class="active"><a href="/contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Actions <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li class="nav-header">Account Related</li>
                  <li><a id='reset_account' href="#reset">Reset Account</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Reporting</li>
                  <li><a href="#export">Export</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
		
      <sction class="content">
      	<h1>Contact Me</h1>
      	<p>This website was developed by Etai Koren from kodkod.org.</p>
      	<p>You can find more information on <a href='http://kodkod.org'>kodkod.org</a></p>
      	<p>You can also fill in this form and it will send me an email</p>
      	
      </sction>
	<hr>

      <footer>
        <p>&copy; kodkod.org 2012</p>
      </footer>

    </div> <!-- /container -->
    
    <!-- hidden dialog boxes -->
    <div style='display:none'>
		<div id='start_tracking_dialog' style='padding:20px; background:#fff; text-align: center;'>
		    <form onsubmit="return process_tracking()">
			    <legend>Start Tracking</legend>
			    <label for='client_name'>Client Name</label>
			    <input type="text" placeholder="Client Name" id='client_name' name='client_name' required="required" autocomplete="off" list="clients_list">
			    <datalist id="clients_list">
			    </datalist>
			    <br />
			    <button type="submit" class="btn">Start Tracking</button>
		    </form>
		</div>
	</div>
	<div style='display:none'>
		<div id='stop_tracking_dialog' style='padding:20px; background:#fff; text-align: center;'>
		    <form onsubmit="return process_stop_tracking()">
			    <legend>Stop Tracking</legend>
			    <label for='client_name'>Client Name</label>
			    <input type="text" placeholder="Client Name" id='client_name' name='client_name' required="required" autocomplete="off" list="clients_list">
			    <datalist id="clients_list">
			    </datalist>
			    <label for='task_notes'>Task Notes</label>
			    <textarea placeholder="Task Notes" id='task_notes' name='task_notes'></textarea>
			    <br />
			    <button type="submit" class="btn">Stop Tracking</button>
		    </form>
		</div>
	</div>
	<div style='display:none'>
		<div id='new_client_dialog' style='padding:20px; background:#fff; text-align: center;'>
		    <form onsubmit="return process_client()">
			    <legend>New Client</legend>
			    <label for='client_name'>Client Name</label>
			    <input type="text" placeholder="Client Name" id='client_name' name='client_name' required="required">
			    <label for='client_desc'>Client Description</label>
			    <textarea placeholder="Client Name" id='client_desc' name='client_desc'></textarea>
			    <br />
			    <button type="submit" class="btn">Add Client</button>
		    </form>
		</div>
	</div>
	<!-- /hidden dialog boxes -->
		

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-1.8.2.min.js"></script>
    <script src="/js/jquery.colorbox-min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/jtimer.js"></script>

    <script type="text/javascript">
    
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-35247202-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>    
  </body>
</html>