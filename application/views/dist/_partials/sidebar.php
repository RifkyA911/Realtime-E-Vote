<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$user_role = $this->session->userdata('role');
?>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?php echo base_url(); ?>dashboard"><i class="fas fa-vote-yea text-primary mr-1"></i> Simple E-Vote</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo base_url(); ?>dashboard">SEV</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header"><?php echo __t('menu_main', 'Main Menu'); ?></li>
            <li class="<?php echo ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo base_url(); ?>dashboard">
                <i class="fas fa-chart-pie"></i> <span><?php echo __t('menu_dashboard', 'Dashboard & Live Count'); ?></span>
              </a>
            </li>
            <li class="<?php echo ($this->uri->segment(1) == 'vote') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo base_url(); ?>vote">
                <i class="fas fa-person-booth"></i> <span><?php echo __t('menu_booth', 'Voting Booth'); ?></span>
              </a>
            </li>
            <li class="<?php echo ($this->uri->segment(1) == 'candidate') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo base_url(); ?>candidate">
                <i class="fas fa-users"></i> <span><?php echo __t('menu_candidates', 'Candidates'); ?></span>
              </a>
            </li>

            <?php if ($user_role === 'admin'): ?>
              <li class="<?php echo ($this->uri->segment(1) == 'voter') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url(); ?>voter">
                  <i class="fas fa-address-book"></i> <span><?php echo __t('menu_voters', 'Voters Registry (DPT)'); ?></span>
                </a>
              </li>
              <li>
                <a class="nav-link" href="<?php echo base_url(); ?>dashboard/print_rekap" target="_blank">
                  <i class="fas fa-print"></i> <span><?php echo __t('menu_print_recap', 'Print Official Recap'); ?></span>
                </a>
              </li>
              <li class="dropdown <?php echo ($this->uri->segment(1) == 'migrate') ? 'active' : ''; ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i> <span><?php echo __t('menu_database', 'Database & Reset'); ?></span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?php echo base_url(); ?>migrate/seed" onclick="return confirm('<?php echo addslashes(__t('confirm_reseed', 'Reset and re-seed database to initial demo state?')); ?>');"><?php echo __t('reseed_db', 'Re-Seed Database'); ?></a></li>
                  <li><a class="nav-link text-warning" href="<?php echo base_url(); ?>migrate/reset" onclick="return confirm('<?php echo addslashes(__t('confirm_reset_votes', 'Clear all cast ballots and reset voter statuses?')); ?>');"><?php echo __t('reset_votes_only', 'Reset Votes Only'); ?></a></li>
                </ul>
              </li>
            <?php endif; ?>

            <li class="menu-header"><?php echo __t('menu_account', 'Account Settings'); ?></li>
            <li>
              <a class="nav-link text-danger" href="<?php echo base_url(); ?>auth/logout" onclick="return confirm('<?php echo addslashes(__t('confirm_logout', 'Are you sure you want to log out?')); ?>');">
                <i class="fas fa-sign-out-alt"></i> <span><?php echo __t('menu_logout', 'Logout'); ?></span>
              </a>
            </li>
          </ul>
        </aside>
      </div>
