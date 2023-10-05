
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<a class="navbar-brand" href="index.php">Welcome!</a>-->
        </div>
        <div id="navbar" class="collapse navbar-collapse pull-left">
        
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
              <?php if(!isset($_SESSION['email'])): ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <!--<li><a href="recover.php">Recover</a></li>-->
             <?php else: ?>
            <li><a href="admin.php">admin</a></li>
            <li><a href="logout.php">logout</a></li>
              <?php endif;?>
          </ul>
        </div><!--/.nav-collapse -->
        <div id="navbar" class="collapse navbar-collapse pull-right">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <form class="example" action="action_page.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
            </form>
             </div>
            
      </div>
</nav>
