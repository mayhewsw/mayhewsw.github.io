<!DOCTYPE html>
<!-- saved from url=(0037)http://getbootstrap.com/css/#overview -->
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    
    <title>
      
      Woot a tutorial
      
    </title>
    
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet" />
    
    <!-- Documentation extras -->
    <link href="../css/docs.css" rel="stylesheet" />
    
    <!-- <link rel="stylesheet" href="http://yandex.st/highlightjs/7.3/styles/tomorrow-night-eighties.min.css"> -->
    <link rel="stylesheet" href="http://yandex.st/highlightjs/7.4/styles/monokai.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    
    <script src="http://yandex.st/highlightjs/7.4/highlight.min.js"></script>
    
     <?php 

        function putcode($fname, $ext){
           $dir = "sample_tutorial/"; 
           $f = $fname;
           $fshort = basename($f, $ext);
           include 'codeinclude.php';
        }
     ?>    
    
    <style>
      
      .bs-sidebar .nav > .active > a,
      .bs-sidebar .nav > .active:hover > a,
      .bs-sidebar .nav > .active:focus > a {
      font-weight: bold;
      color: #148900;
      background-color: transparent;
      border-right: 1px solid #148900;
      }
      
      a {
      color: #159300;
      }
      
      a:hover,
      a:focus {
      color: #148900;  
      }
      
      
    </style>
    
  </head>
  <body data-spy="scroll" data-target=".bs-sidebar">
    
    <div class="navbar navbar-default">
      <div class="container">
        
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
          <a class="navbar-brand" href="../index.php">Stephen Mayhew</a>
        </div> <!-- end navbar-header -->
        
        <div class="navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <li><a href="../index.php">Home</a></li>
          </ul>
          
        </div><!-- end navbar-collapse -->        
      </div> <!-- end container -->
    </div> <!-- end navbar -->
    

    
    
    <!-- Docs page layout -->
    <div class="bs-header">
      <div class="container">
        <h1>Sample Tutorial</h1>
        <p>How to do a tutorial!</p>
      </div> <!-- end container -->
    </div> <!-- end bs-header  -->
    
    <div class="container bs-docs-container">
      <div class="row">
        <div class="col-lg-3">
          <div class="bs-sidebar affix-top">
            <ul class="nav bs-sidenav">              
              <li class="active">
                <a href="#overview">Palindromes</a>
              </li>
              <li class="">
                <a href="#run">Prime Numbers</a>
              </li>

              
            </ul>
          </div> <!-- end bs-sidebar  -->
        </div> <!-- End col-lg-3 -->
        <div class="col-lg-9">
          <!-- Global Bootstrap settings
               ================================================== -->
          <div class="bs-docs-section">
            <div class="page-header">
              <h2 id="overview">Overview</h2>
            </div>
            blah blah blah.
          </div>
          
          
          <!-- First Step  ==================================== -->
          <div class="bs-docs-section">
            <div class="page-header">
              <h2 id="run">Runner</h2>
            </div>
            
            <p>Description of first step!</p>
            
            <?php putcode("Runner.java", ".java"); ?>

          </div> <!-- end bs-docs-section  -->

          <!-- First Step  ==================================== -->
          <div class="bs-docs-section">
            <div class="page-header">
              <h2 id="sinf">SimpleInference</h2>
            </div>
            
            <p>Description of first step!</p>
            
            <?php putcode("SimpleInference.java", ".java"); ?>

          </div> <!-- end bs-docs-section  -->

        </div> <!-- end col-lg-9 -->
      </div> <!-- End row -->
    </div> <!-- end container  -->
    
    <!-- Footer
         ================================================== -->
    <footer class="bs-footer">
      <p> (Originally) Designed and built with all the love in the world by <a href="http://twitter.com/mdo" target="_blank">@mdo</a> and <a href="http://twitter.com/fat" target="_blank">@fat</a>.</p>
      <p>Shamelessly stolen (in accordance with the posted license) by <a href="http://twitter.com/mayhewsw" target="_blank">@mayhewsw</a>.</p>
      <p>Code licensed under <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>, documentation under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
    </footer>
    
    <!-- JS and analytics only. -->
    <!-- Bootstrap core JavaScript
         ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/myjs.js"></script>
    
    
    <!-- This controls the scrolling affix thing. -->
    <!-- <script src="http://platform.twitter.com/widgets.js"></script> -->
    <script src="../js/holder.js"></script>
    <script src="../js/application.js"></script>
    
    <script type="text/javascript">
      
      function refresh() {
      var $spy = $(document.body).scrollspy('refresh');
      }
      
      $(".collapse").on("hidden.bs.collapse", function (){
      refresh();
      });
      $(".collapse").on("shown.bs.collapse", function (){
      refresh();
      });
      
      $(document).ready(function() {
      $("pre code").each(function(i, e) {hljs.highlightBlock(e)});
      });
      
      
    </script>
    
  </body>
</html>
