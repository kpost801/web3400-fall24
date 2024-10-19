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
              <span>&nbsp;<?= $siteName ?></span>
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
                <a class="button is-link"> Log in </a>
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
      <!-- BEGIN HERO -->
      <section class="hero is-info">
        <div class="hero-body">
          <p class="title">Hero title</p>
          <p class="subtitle">Hero subtitle</p>
        </div>
      </section>
      <!-- END HERO -->
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