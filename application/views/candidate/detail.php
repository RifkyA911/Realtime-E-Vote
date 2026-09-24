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
            <h1><?php echo __t('candidate_profile_title', 'Candidate Profile'); ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo __t('home', 'Home'); ?></a></div>
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>candidate"><?php echo __t('menu_candidates', 'Candidates'); ?></a></div>
              <div class="breadcrumb-item active"><?php echo __t('detail', 'Details'); ?></div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-md-5 col-lg-4">
              <div class="card card-primary text-center">
                <div class="card-header justify-content-center">
                  <span class="badge badge-pill text-white px-3 py-2 font-weight-bold" style="background-color: <?php echo $candidate->color ?: '#6777ef'; ?>; font-size: 15px;">
                    <?php echo __t('ballot_no_upper', 'BALLOT NO.'); ?> 0<?php echo $candidate->candidate_number; ?>
                  </span>
                </div>
                <div class="card-body">
                  <?php 
                    $photo_file = !empty($candidate->photo) ? $candidate->photo : 'candidate-1.png';
                    $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                  ?>
                  <img src="<?php echo $photo_src; ?>" alt="Foto" class="rounded-circle shadow mb-3" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #fff;">
                  
                  <h4 class="font-weight-bold mb-1 text-dark"><?php echo $candidate->chairman_name; ?></h4>
                  <div class="text-primary font-weight-bold mb-2"><?php echo __t('chairman', 'Chairman Candidate'); ?></div>

                  <div class="border-top pt-2 mt-2">
                    <h5 class="font-weight-bold mb-1 text-dark"><?php echo $candidate->vice_chairman_name; ?></h5>
                    <div class="text-muted small"><?php echo __t('vice_chairman', 'Vice Chairman Candidate'); ?></div>
                  </div>

                  <div class="mt-4 pt-3 border-top">
                    <?php if ($this->session->userdata('role') === 'admin'): ?>
                      <a href="<?php echo base_url(); ?>candidate/edit/<?php echo $candidate->id; ?>" class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit mr-1"></i> <?php echo __t('edit', 'Edit'); ?>
                      </a>
                    <?php endif; ?>
                    <a href="<?php echo base_url(); ?>vote" class="btn btn-primary btn-sm">
                      <i class="fas fa-vote-yea mr-1"></i> <?php echo __t('btn_vote_this', 'VOTE PAIR'); ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-7 col-lg-8">
              <!-- Vision Card -->
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-bullseye text-primary mr-2"></i> <?php echo __t('vision', 'Vision'); ?></h4>
                </div>
                <div class="card-body">
                  <blockquote class="blockquote mb-0 p-3 bg-light rounded" style="border-left: 5px solid <?php echo $candidate->color ?: '#6777ef'; ?>;">
                    <p class="font-weight-600 mb-0 text-dark" style="font-size: 16px; line-height: 1.7;">
                      "<?php echo nl2br(htmlspecialchars($candidate->vision)); ?>"
                    </p>
                  </blockquote>
                </div>
              </div>

              <!-- Mission Card -->
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-tasks text-success mr-2"></i> <?php echo __t('mission', 'Mission'); ?></h4>
                </div>
                <div class="card-body">
                  <div style="font-size: 15px; line-height: 1.8;" class="text-dark">
                    <?php echo nl2br(htmlspecialchars($candidate->mission)); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>

<?php $this->load->view('dist/_partials/footer'); ?>
