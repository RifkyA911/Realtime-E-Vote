<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <div class="section-header-back">
              <a href="<?php echo base_url(); ?>voter" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1><?php echo __t('add_voter_title', 'Add New Voter (DPT)'); ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo __t('home', 'Home'); ?></a></div>
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>voter"><?php echo __t('menu_voters', 'Voters'); ?></a></div>
              <div class="breadcrumb-item active"><?php echo __t('add', 'Add'); ?></div>
            </div>
          </div>

          <!-- Alert Errors -->
          <?php if (validation_errors()): ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <?php echo validation_errors('<div><i class="fas fa-exclamation-circle mr-1"></i> ', '</div>'); ?>
              </div>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
              <div class="card card-primary">
                <div class="card-header">
                  <h4><i class="fas fa-user-plus mr-2 text-primary"></i> <?php echo __t('voter_form', 'Voter Registration Form'); ?></h4>
                </div>
                <div class="card-body">
                  <?php echo form_open('voter/store'); ?>

                    <div class="form-group">
                      <label for="voter_code"><?php echo __t('voter_code', 'Voter Code / Student ID'); ?> <span class="text-danger">*</span></label>
                      <input type="text" id="voter_code" name="voter_code" class="form-control text-uppercase" placeholder="<?php echo __t('example_voter_code', 'e.g., VTR-2026-016 or 21010123'); ?>" value="<?php echo set_value('voter_code'); ?>" required>
                      <small class="form-text text-muted"><?php echo __t('voter_code_desc', 'Unique identifier code (Student/Member ID).'); ?></small>
                    </div>

                    <div class="form-group">
                      <label for="card_uid"><?php echo __t('card_uid', 'Card UID (RFID / NFC)'); ?> <span class="text-muted"><?php echo __t('card_uid_optional', '(Optional for Tap Card Login)'); ?></span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" id="card_uid" name="card_uid" class="form-control" placeholder="<?php echo __t('card_uid_placeholder', 'Tap ID card on reader or enter UID (e.g. 0001002016)'); ?>" value="<?php echo set_value('card_uid'); ?>">
                      </div>
                      <small class="form-text text-muted"><?php echo __t('card_uid_desc', 'Unique RFID UID for fast tap card authentication (USB Reader / NFC).'); ?></small>
                    </div>

                    <div class="form-group">
                      <label for="name"><?php echo __t('voter_name', 'Full Name'); ?> <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo __t('example_voter_name', 'e.g., Alex Johnson'); ?>" value="<?php echo set_value('name'); ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="gender"><?php echo __t('gender', 'Gender'); ?> <span class="text-danger">*</span></label>
                      <select id="gender" name="gender" class="form-control" required>
                        <option value="L" <?php echo set_select('gender', 'L', TRUE); ?>><?php echo __t('gender_m', 'Male (M)'); ?></option>
                        <option value="P" <?php echo set_select('gender', 'P'); ?>><?php echo __t('gender_f', 'Female (F)'); ?></option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="class_or_dept"><?php echo __t('class_or_dept', 'Class / Major / Unit'); ?> <span class="text-danger">*</span></label>
                      <input type="text" id="class_or_dept" name="class_or_dept" class="form-control" placeholder="<?php echo __t('example_class_or_dept', 'e.g., Computer Science A / Class of 2024'); ?>" value="<?php echo set_value('class_or_dept'); ?>" required>
                    </div>

                    <div class="form-group text-right mb-0">
                      <a href="<?php echo base_url(); ?>voter" class="btn btn-secondary mr-2"><?php echo __t('cancel', 'Cancel'); ?></a>
                      <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> <?php echo __t('save_voter', 'Save Voter'); ?>
                      </button>
                    </div>

                  <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>

<?php $this->load->view('dist/_partials/footer'); ?>
