<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <div class="section-header-back">
              <a href="<?php echo base_url(); ?>candidate" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1><?php echo __t('edit_candidate_title', 'Edit Candidate Pair'); ?> #<?php echo $candidate->candidate_number; ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo __t('home', 'Home'); ?></a></div>
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>candidate"><?php echo __t('menu_candidates', 'Candidates'); ?></a></div>
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
            <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
              <div class="card card-primary">
                <div class="card-header">
                  <h4><i class="fas fa-user-edit mr-2 text-primary"></i> <?php echo __t('edit_candidate_title', 'Edit Candidate Pair'); ?></h4>
                </div>
                <div class="card-body">
                  <?php echo form_open_multipart('candidate/update/' . $candidate->id); ?>

                    <div class="row">
                      <div class="form-group col-md-4">
                        <label for="candidate_number"><?php echo __t('ballot_number', 'Ballot Number'); ?> <span class="text-danger">*</span></label>
                        <input type="number" id="candidate_number" name="candidate_number" class="form-control" min="1" value="<?php echo set_value('candidate_number', $candidate->candidate_number); ?>" required>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="color"><?php echo __t('theme_color', 'Theme Color'); ?></label>
                        <input type="color" id="color" name="color" class="form-control" style="height: 42px; padding: 2px;" value="<?php echo set_value('color', $candidate->color ?: '#6777ef'); ?>">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="photo"><?php echo __t('change_photo', 'Change Photo'); ?> (<?php echo __t('optional', 'Optional'); ?>)</label>
                        <input type="file" id="photo" name="photo" class="form-control-file mt-1" accept="image/*" onchange="previewImage(this)">
                      </div>
                    </div>

                    <!-- Current Photo & Preview Row -->
                    <div class="row mb-3">
                      <div class="col-6 text-center">
                        <small class="d-block font-weight-bold text-muted mb-1"><?php echo __t('current_photo', 'Current Photo:'); ?></small>
                        <?php 
                          $photo_file = !empty($candidate->photo) ? $candidate->photo : 'candidate-1.png';
                          $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                        ?>
                        <img src="<?php echo $photo_src; ?>" alt="Photo" class="img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                      </div>
                      <div class="col-6 text-center" id="previewContainer">
                        <small class="d-block font-weight-bold text-muted mb-1"><?php echo __t('new_photo_preview', 'New Photo (Preview):'); ?></small>
                        <img id="imgPreview" src="<?php echo $photo_src; ?>" alt="Preview" class="img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="chairman_name"><?php echo __t('chairman', 'Chairman Candidate'); ?> <span class="text-danger">*</span></label>
                        <input type="text" id="chairman_name" name="chairman_name" class="form-control" value="<?php echo set_value('chairman_name', $candidate->chairman_name); ?>" required>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="vice_chairman_name"><?php echo __t('vice_chairman', 'Vice Chairman Candidate'); ?> <span class="text-danger">*</span></label>
                        <input type="text" id="vice_chairman_name" name="vice_chairman_name" class="form-control" value="<?php echo set_value('vice_chairman_name', $candidate->vice_chairman_name); ?>" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="vision"><?php echo __t('vision', 'Vision'); ?> <span class="text-danger">*</span></label>
                      <textarea id="vision" name="vision" class="form-control" style="height: 100px;" required><?php echo set_value('vision', $candidate->vision); ?></textarea>
                    </div>

                    <div class="form-group">
                      <label for="mission"><?php echo __t('mission', 'Mission'); ?> <span class="text-danger">*</span></label>
                      <textarea id="mission" name="mission" class="form-control" style="height: 140px;" required><?php echo set_value('mission', $candidate->mission); ?></textarea>
                    </div>

                    <div class="form-group text-right mb-0">
                      <a href="<?php echo base_url(); ?>candidate" class="btn btn-secondary mr-2"><?php echo __t('cancel', 'Cancel'); ?></a>
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

<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#imgPreview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
