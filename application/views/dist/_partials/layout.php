<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
          <div class="text-white d-none d-md-inline-block font-weight-bold">
            <span class="badge badge-light text-primary font-weight-bold shadow-sm">
              <i class="fas fa-id-card mr-1"></i> Simple E-Vote &bull; Tap ID Card Ready
            </span>
          </div>
        </div>

        <ul class="navbar-nav navbar-right align-items-center">
          <!-- Language Switcher Dropdown -->
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg" title="<?php echo __t('language', 'Language'); ?>">
              <i class="fas fa-globe"></i>
              <span class="d-none d-md-inline-block font-weight-bold ml-1 text-uppercase">
                <?php echo (current_lang() === 'id') ? 'ID' : 'EN'; ?>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title"><?php echo __t('language', 'Language'); ?></div>
              <a href="<?php echo base_url('lang/switch/en'); ?>" class="dropdown-item has-icon <?php echo (current_lang() !== 'id') ? 'font-weight-bold text-primary' : ''; ?>">
                <span class="mr-2">🇬🇧</span> English <?php echo (current_lang() !== 'id') ? '<i class="fas fa-check float-right mt-1"></i>' : ''; ?>
              </a>
              <a href="<?php echo base_url('lang/switch/id'); ?>" class="dropdown-item has-icon <?php echo (current_lang() === 'id') ? 'font-weight-bold text-primary' : ''; ?>">
                <span class="mr-2">🇮🇩</span> Bahasa Indonesia <?php echo (current_lang() === 'id') ? '<i class="fas fa-check float-right mt-1"></i>' : ''; ?>
              </a>
            </div>
          </li>

          <!-- User Dropdown Menu -->
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">
              <?php echo $this->session->userdata('name') ?: __t('user', 'User'); ?>
              <span class="badge badge-sm badge-light ml-1 text-uppercase text-dark font-weight-bold" style="font-size: 10px;">
                <?php echo $this->session->userdata('role') ?: 'Guest'; ?>
              </span>
            </div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title"><?php echo __t('logged_in_as', 'Signed in as'); ?>: <?php echo ucfirst($this->session->userdata('role') ?: 'User'); ?></div>
              <a href="<?php echo base_url(); ?>dashboard" class="dropdown-item has-icon">
                <i class="fas fa-chart-pie"></i> <?php echo __t('menu_dashboard', 'Dashboard & Live Count'); ?>
              </a>
              <a href="<?php echo base_url(); ?>vote" class="dropdown-item has-icon">
                <i class="fas fa-person-booth"></i> <?php echo __t('menu_booth', 'Voting Booth'); ?>
              </a>
              <a href="<?php echo base_url(); ?>candidate" class="dropdown-item has-icon">
                <i class="fas fa-users"></i> <?php echo __t('menu_candidates', 'Candidates'); ?>
              </a>
              <?php if ($this->session->userdata('role') === 'admin'): ?>
                <a href="<?php echo base_url(); ?>voter" class="dropdown-item has-icon">
                  <i class="fas fa-address-book"></i> <?php echo __t('menu_voters', 'Voters Registry (DPT)'); ?>
                </a>
              <?php endif; ?>
              <div class="dropdown-divider"></div>
              <a href="<?php echo base_url(); ?>auth/logout" class="dropdown-item has-icon text-danger" onclick="return confirm('<?php echo addslashes(__t('confirm_logout', 'Are you sure you want to log out?')); ?>');">
                <i class="fas fa-sign-out-alt"></i> <?php echo __t('menu_logout', 'Logout'); ?>
              </a>
            </div>
          </li>
        </ul>
      </nav>
