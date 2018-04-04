<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <span class="navbar-brand">Homework Organizer</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li <? if ($active['home']) { ?> class="nav-item active"<? } else {?> class="nav-item" <?}?>>
        <a class="nav-link" href="<?= base_url(); ?>index.php?/Home">Home</a>
      </li>
      <li <? if ($active['assignments']) { ?> class="nav-item active"<? } else {?> class="nav-item" <?}?>>
        <a class="nav-link" href="<?= base_url(); ?>index.php?/Assignments">Assignments</a>
      </li>
      <li <? if ($active['dashboard']) { ?> class="nav-item active"<? } else {?> class="nav-item" <?}?>>
        <a class="nav-link" href="<?= base_url(); ?>index.php?/Dashboard">Shared</a>
      </li>
      <? if ($_SESSION['accesslevel'] == 'admin'){?>
        <li <? if ($active['admin']) { ?> class="nav-item active"<? } else {?> class="nav-item" <?}?>>
          <a class="nav-link" href="<?= base_url(); ?>index.php?/Admin">Admin</a>
        </li>
      <?}?>
      <li <? if ($active['settings']) { ?> class="nav-item active"<? } else {?> class="nav-item" <?}?>>
        <a class="nav-link" href="<?= base_url(); ?>index.php?/Settings">Settings</a>
      </li>
      <? if ($loggedin) { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="themes" aria-expanded="false">
            <?=$_SESSION['username']?><span class="caret"></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="themes">
            <a class="dropdown-item" href="<?= base_url(); ?>index.php?/Login/logout">Logout</a>
          </div>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" href="<?= base_url(); ?>index.php?/Login/logout">Logout</a>
        </li> -->
      <? } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url(); ?>index.php?/Login">Login</a>
        </li>
      <? } ?>
    </ul>
  </div>
</nav>
