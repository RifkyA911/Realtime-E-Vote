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
            <h1><?php echo __t('edit_voter_title', 'Edit Voter Details'); ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo __t('home', 'Home'); ?></a></div>
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>voter"><?php echo __t('menu_voters', 'Voters'); ?></a></div>
              <div class="breadcrumb-item active"><?php echo __t('edit', 'Edit'); ?></div>
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

          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <i class="fas fa-exclamation-triangle mr-1"></i> <?php echo $this->session->flashdata('error'); ?>
              </div>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
              <div class="card card-primary">
                <div class="card-header">
                  <h4><i class="fas fa-user-edit mr-2 text-primary"></i> <?php echo __t('edit_voter_title', 'Edit Voter Details'); ?>: <?php echo $voter->name; ?></h4>
                </div>
                <div class="card-body">
                  <?php echo form_open('voter/update/' . $voter->id); ?>

                    <div class="form-group">
                      <label for="voter_code"><?php echo __t('voter_code', 'Voter Code / Student ID'); ?> <span class="text-danger">*</span></label>
                      <input type="text" id="voter_code" name="voter_code" class="form-control text-uppercase" value="<?php echo set_value('voter_code', $voter->voter_code); ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="card_uid"><?php echo __t('card_uid', 'Card UID (RFID / NFC)'); ?> <span class="text-muted"><?php echo __t('card_uid_optional', '(Optional for Tap Card Login)'); ?></span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" id="card_uid" name="card_uid" class="form-control" placeholder="<?php echo __t('card_uid_placeholder', 'Tap ID card on reader or enter UID (e.g. 0001002016)'); ?>" value="<?php echo set_value('card_uid', $voter->card_uid); ?>">
                      </div>
                      <small class="form-text text-muted"><?php echo __t('card_uid_desc', 'Unique RFID UID for fast tap card authentication (USB Reader / NFC).'); ?></small>
                    </div>

                    <div class="form-group">
                      <label for="name"><?php echo __t('voter_name', 'Full Name'); ?> <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" class="form-control" value="<?php echo set_value('name', $voter->name); ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="gender"><?php echo __t('gender', 'Gender'); ?> <span class="text-danger">*</span></label>
                      <select id="gender" name="gender" class="form-control" required>
                        <option value="L" <?php echo set_select('gender', 'L', $voter->gender == 'L'); ?>><?php echo __t('gender_m', 'Male (M)'); ?></option>
                        <option value="P" <?php echo set_select('gender', 'P', $voter->gender == 'P'); ?>><?php echo __t('gender_f', 'Female (F)'); ?></option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="class_or_dept"><?php echo __t('class_or_dept', 'Class / Major / Unit'); ?> <span class="text-danger">*</span></label>
                      <input type="text" id="class_or_dept" name="class_or_dept" class="form-control" value="<?php echo set_value('class_or_dept', $voter->class_or_dept); ?>" required>
                    </div>

                    <div class="form-group">
                      <label><?php echo __t('voting_rights_status', 'Voting Rights Status:'); ?></label>
                      <div>
                        <?php if ($voter->has_voted == 1): ?>
                          <span class="badge badge-success"><i class="fas fa-check mr-1"></i> <?php echo __t('status_has_voted', 'Has Voted'); ?> (<?php echo date('d M Y, H:i', strtotime($voter->voted_at)); ?>)</span>
                        <?php else: ?>
                          <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> <?php echo __t('status_not_voted', 'Not Voted'); ?></span>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="form-group text-right mb-0">
                      <a href="<?php echo base_url(); ?>voter" class="btn btn-secondary mr-2"><?php echo __t('cancel', 'Cancel'); ?></a>
                      <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> <?php echo __t('save_changes', 'Save Changes'); ?>
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
