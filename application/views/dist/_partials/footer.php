<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
      <footer class="main-footer">
        <div class="footer-left">
          <strong>Simple E-Vote</strong> &bull; <?php echo __t('app_tagline', 'Modern E-Voting System with Tap ID Card (RFID/NFC) Feature'); ?>
        </div>
        <div class="footer-right">
          <a href="<?php echo base_url(); ?>docs" class="text-primary font-weight-600"><i class="fas fa-book mr-1"></i> <?php echo __t('menu_docs', 'System Documentation'); ?></a>
        </div>
      </footer>
    </div>
  </div>

<?php $this->load->view('dist/_partials/js'); ?>