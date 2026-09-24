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
            <li class="menu-header"><?php echo __t('menu_main', 'Menu Utama E-Vote'); ?></li>
            <li class="<?php echo ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo base_url(); ?>dashboard">
                <i class="fas fa-chart-pie"></i> <span><?php echo __t('menu_dashboard', 'Dashboard & Real Count'); ?></span>
              </a>
            </li>
            <li class="<?php echo ($this->uri->segment(1) == 'vote') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo base_url(); ?>vote">
                <i class="fas fa-person-booth"></i> <span><?php echo __t('menu_booth', 'Bilik Suara (Voting)'); ?></span>
              </a>
            </li>
            <li class="<?php echo ($this->uri->segment(1) == 'candidate') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo base_url(); ?>candidate">
                <i class="fas fa-users"></i> <span><?php echo __t('menu_candidates', 'Data Kandidat'); ?></span>
              </a>
            </li>

            <?php if ($user_role === 'admin'): ?>
              <li class="<?php echo ($this->uri->segment(1) == 'voter') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url(); ?>voter">
                  <i class="fas fa-address-book"></i> <span><?php echo __t('menu_voters', 'Data Pemilih (DPT)'); ?></span>
                </a>
              </li>
              <li>
                <a class="nav-link" href="<?php echo base_url(); ?>dashboard/print_rekap" target="_blank">
                  <i class="fas fa-print"></i> <span><?php echo __t('menu_print_recap', 'Cetak Berita Acara'); ?></span>
                </a>
              </li>
              <li class="dropdown <?php echo ($this->uri->segment(1) == 'migrate') ? 'active' : ''; ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i> <span><?php echo __t('menu_database', 'Database & Seed'); ?></span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?php echo base_url(); ?>migrate/seed" onclick="return confirm('Jalankan migrasi ulang dan reset ke data awal?');">Re-Seed Database</a></li>
                  <li><a class="nav-link text-warning" href="<?php echo base_url(); ?>migrate/reset" onclick="return confirm('Kosongkan semua suara yang sudah masuk?');">Reset Suara Saja</a></li>
                </ul>
              </li>
            <?php endif; ?>

            <li class="<?php echo ($this->uri->segment(1) == 'docs') ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo base_url(); ?>docs" target="_blank">
                <i class="fas fa-book"></i> <span><?php echo __t('menu_docs', 'Dokumentasi Sistem'); ?></span>
              </a>
            </li>

            <li class="menu-header"><?php echo __t('menu_account', 'Pengaturan Akun'); ?></li>
            <li>
              <a class="nav-link text-danger" href="<?php echo base_url(); ?>auth/logout" onclick="return confirm('Apakah Anda yakin ingin logout?');">
                <i class="fas fa-sign-out-alt"></i> <span><?php echo __t('menu_logout', 'Logout'); ?></span>
              </a>
            </li>
          </ul>
        </aside>
      </div>
