<?php
  include_once("inlog_logica.php");
  // if page requested by submitting login form
  // then we keep the same login flow 
  if( isset($_REQUEST["login"]) && isset($_REQUEST["password"]) ){
    $user_exist = get_user_by_login_and_password($_REQUEST["login"], $_REQUEST["password"]);
 
    // if user exist on database
    if( $user_exist ){ 
      // then create a session for the user whithin your application 
      // and redirect him back to the profile or dashboard page or something :)
      $_SESSION["user_connected"] = true;
      redirect_to("http://www.mlwebdesign.be");
    }     
  }
 
  // else, if login page request by clicking a provider button
  elseif( isset($_REQUEST["provider"]) ){ 
    // the selected provider
    $provider_name = $_REQUEST["provider"];
 
    try{
      // initialize Hybrid_Auth with a given file
      $hybridauth = new Hybrid_Auth( $config );
 
      // try to authenticate with the selected provider
      $adapter = $hybridauth->authenticate( $provider_name );
 
      // then grab the user profile 
      $user_profile = $adapter->getUserProfile();
    }
    catch( Exception $e ){
      echo "Error: please try again!";
      echo "Original error message: " . $e->getMessage();
    }
 
    # and that's it!
    # beyond that, its up to you sign-in the user if he already exist on your database
    # or sign-up the user if not.
    # the following pseudocode is provided only as an example:
 
    $user_exist = get_user_by_provider_and_id($provider_name, $user_profile->identifier);
 
    // if user exist on database, then same as before
    if( $user_exist ){ 
      $_SESSION["user_connected"] = true;
      redirect_to("http://www.mlwebdesign.be");
    } 
 
    // if not, create a new one on database
    else{ 
      create_new_hybridauth_user(
        $provider_name,
        $user_profile->identifier, 
        $user_profile->email, 
        $user_profile->firstName, 
        $user_profile->lastName, 
        generate_password() 
      ); 
 
      // flag user as connected whithin your application and redirect him to home page
      $_SESSION["user_connected"] = true;
      redirect_to("http://www.mlwebdesign.be");
    }
  }    
?><html>
<head>
  <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="http://sscol.jebal.comuv.com/css/font.css">
  <link rel="stylesheet" href="css/stylesheet.css" type="text/css" /> 
</head>
<body>
  <nav>
    <?php if(isset($_SESSION['loggedin'])): ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="inlog.php">Login</a>
    <?php endif; ?>
  </nav>
  <div class="login">
  <h1>Login here.</h1>
  <p>Control your digital restaurant</p>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="input">
      <div class="blockinput">
        <input type="text" placeholder="Username" name="name">
      </div>
      <div class="blockinput">
       <input type="password" placeholder="Password" name="loginpassword">
      </div>
    </div>
    <input type="submit" name="btnlogin" id="btnlogin" value="login" />
  </form> 
  </div>

  <div class="Register">
  <h1>Get your account.</h1>
  <p>This will be an amazing experience</p>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="input">
      <div class="blockinput">
       <input type="text" placeholder="Username" name="username">
      </div>
      <div class="blockinput">
       <input type="mail" placeholder="Email" name="email">
      </div>
      <div class="blockinput">
        <input type="password" placeholder="Password" name="password">
      </div>
      <div class="select">
          <select class="enlarge" name="functie" id="functie">
            <option value="houder">Restauranthouder</option>
            <option value="klant">Klant</option>
          </select>
      </div>
    </div>
    <input type="submit" name="btnregister" id="btnregister" value="register" />
    <div class="facebookbutton">
     <a href="inlog.php?provider=facebook">submit</a>
    </div>
  </form> 
  </div>
</body>
</html>