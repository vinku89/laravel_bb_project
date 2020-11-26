<nav class="navbar navbar-expand-xl fixed-top navbar-bestbox">
  <div class="container">
    <a class="navbar-brand mr-auto mr-xl-0" href="/">
      <img src="<?php echo url('/');?>/public/website/assets/images/logo.png" class="img-fluid">
    </a>
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
      <span class="navbar-toggler-icon">
      </span>
    </button>
    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav ml-auto">
        <!-- link required -->
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light d-inline-block px-3" href="<?php echo url('/').'/login';?>">Reseller/Agent</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-secondary d-inline-block px-3" href="<?php echo url('/').'/customerLogin';?>">Customer</a>
        </li>
        <li>
            <div class="dropdown">
              <button class="nav-link btn btn-secondary d-inline-block px-3 dropdown-toggle f14 py-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php 
                  if($lang == 'english') echo 'English';
                  else if($lang == 'french') echo 'French';
                  else 'Language';
                ?>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item select_lang" data-language="english">English</a>
                <a class="dropdown-item select_lang" data-language="french">French</a>
              </div>
            </div>
          </li>
      </ul>
    </div>
  </div>
</nav>