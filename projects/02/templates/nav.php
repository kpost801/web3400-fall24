    <!-- BEGIN PAGE HEADER -->
    <header class="container">
      <!-- BEGIN MAIN NAV -->
      <nav
        class="navbar is-fixed-top is-spaced has-shadow is-light"
        role="navigation"
        aria-label="main navigation"
      >
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-yin-yang"></i>
              </span>
              <span>&nbsp; My PhP Site</span>
            </span>
          </a>
          <a
            role="button"
            class="navbar-burger"
            aria-label="menu"
            aria-expanded="false"
          >
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>
        <div class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item" href="#">Home</a>
            <a class="navbar-item" href="#">About</a>
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="contact.php" class="button is-light">
                  <strong>Contact us</strong>
                </a>
                <!-- BEGIN USER MENU -->
   <?php if (isset($_SESSION['loggedin'])) : ?>
      <div class="navbar-item has-dropdown is-hoverable">
         <a class="button navbar-link">
            <span class="icon">
               <i class="fas fa-user"></i>
            </span>
         </a>
         <div class="navbar-dropdown">
            <a href="profile.php" class="navbar-item">Profile</a>
            <hr class="navbar-divider">
            <a href="logout.php" class="navbar-item">Logout</a>
         </div>
      </div>
   <?php else : ?>
      <a href="login.php" class="button is-link">Login</a>
   <?php endif; ?>
<!-- END USER MENU -->
              </div>
            </div>
          </div>
        </div>
      </nav>
      <!-- END MAIN NAV -->
      <section class="block">
        &nbsp;
        <!-- this adds a little extra space between the nav and the hero -->
      </section>
      <?php if ($_SERVER['PHP_SELF'] == '/index.php') : ?>
  <!-- BEGIN HERO -->
  <section class="hero is-link">
      <div class="hero-body">
          <p class="title">
              Hero title
          </p>
          <p class="subtitle">
              Hero subtitle
          </p>
      </div>
  </section>
  <!-- END HERO -->
<?php endif; ?>
       <!-- Start User Message -->
       <?php if (!empty($_SESSION['messages'])) : ?>
  <section class="notification is-warning">
      <button class="delete"></button>
      <?php echo implode('<br>', $_SESSION['messages']);
            $_SESSION['messages'] = []; // Clear the user responses?>
  </section>
<?php endif; ?>
        <!-- end user message -->
    </header>
    <!-- END PAGE HEADER -->