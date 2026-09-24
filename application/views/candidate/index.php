<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header d-flex justify-content-between">
            <h1><i class="fas fa-users mr-2 text-primary"></i> <?php echo __t('candidate_registry', 'Candidate Pairs Registry'); ?></h1>
            <div class="section-header-breadcrumb">
              <?php if ($this->session->userdata('role') === 'admin'): ?>
                <a href="<?php echo base_url(); ?>candidate/create" class="btn btn-primary btn-icon icon-left">
                  <i class="fas fa-plus"></i> <?php echo __t('add_candidate_title', 'Add New Candidate Pair'); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>

          <!-- Flash Messages -->
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <i class="fas fa-check-circle mr-1"></i> <?php echo $this->session->flashdata('success'); ?>
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

          <!-- Candidate Cards Row -->
          <div class="row">
            <?php if (!empty($candidates)): ?>
              <?php foreach ($candidates as $c): ?>
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                  <div class="card card-primary w-100 shadow-sm border" style="border-top-color: <?php echo $c->color ?: '#6777ef'; ?> !important; border-top-width: 4px !important;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <span class="badge badge-pill text-white px-3 py-2 font-weight-bold" style="background-color: <?php echo $c->color ?: '#6777ef'; ?>; font-size: 14px;">
                        <?php echo __t('ballot_no_upper', 'BALLOT NO.'); ?> 0<?php echo $c->candidate_number; ?>
                      </span>
                      <span class="badge badge-light border font-weight-bold">
                        <?php echo $c->total_votes; ?> <?php echo __t('votes', 'Votes'); ?> (<?php echo $c->percentage; ?>%)
                      </span>
                    </div>

                    <div class="card-body text-center pb-2">
                      <div class="avatar-item mb-3">
                        <?php 
                          $photo_file = !empty($c->photo) ? $c->photo : 'candidate-1.png';
                          $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                        ?>
                        <img src="<?php echo $photo_src; ?>" alt="Candidate Photo" class="img-fluid rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                      </div>

                      <h5 class="font-weight-bold text-dark mb-1"><?php echo $c->chairman_name; ?></h5>
                      <p class="text-muted font-weight-600 mb-2"><?php echo __t('chairman', 'Chairman Candidate'); ?></p>
                      
                      <div class="py-1 px-3 bg-light rounded d-inline-block mb-3">
                        <span class="text-dark font-weight-bold">&amp; <?php echo $c->vice_chairman_name; ?></span>
                        <div class="small text-muted"><?php echo __t('vice_chairman', 'Vice Chairman Candidate'); ?></div>
                      </div>

                      <div class="text-left mt-2">
                        <h6 class="font-weight-bold text-muted small text-uppercase"><?php echo __t('main_vision', 'Main Vision:'); ?></h6>
                        <p class="text-muted small mb-0" style="min-height: 48px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                          <?php echo nl2br(htmlspecialchars($c->vision)); ?>
                        </p>
                      </div>
                    </div>

                    <div class="card-footer bg-whitesmoke text-center border-top">
                      <div class="btn-group w-100" role="group">
                        <a href="<?php echo base_url(); ?>candidate/detail/<?php echo $c->id; ?>" class="btn btn-outline-info btn-sm">
                          <i class="fas fa-eye"></i> <?php echo __t('detail', 'Details'); ?>
                        </a>
                        <?php if ($this->session->userdata('role') === 'admin'): ?>
                          <a href="<?php echo base_url(); ?>candidate/edit/<?php echo $c->id; ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i> <?php echo __t('edit', 'Edit'); ?>
                          </a>
                          <a href="<?php echo base_url(); ?>candidate/delete/<?php echo $c->id; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?php echo sprintf(__t('confirm_delete_candidate', 'Are you sure you want to delete candidate #%s? Associated votes will also be deleted.'), $c->candidate_number); ?>');">
                            <i class="fas fa-trash"></i> <?php echo __t('delete', 'Delete'); ?>
                          </a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12">
                <div class="card">
                  <div class="card-body text-center py-5">
                    <i class="fas fa-users-slash text-muted mb-3" style="font-size: 48px;"></i>
                    <h4><?php echo __t('no_candidates_yet', 'No Candidate Data Available'); ?></h4>
                    <p class="text-muted"><?php echo __t('no_candidates_desc', 'Please add your first candidate pair to start the election.'); ?></p>
                    <a href="<?php echo base_url(); ?>candidate/create" class="btn btn-primary"><?php echo __t('add_candidate_title', 'Add Candidate'); ?></a>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <!-- Table Summary of Candidates -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-table mr-2 text-primary"></i> <?php echo __t('candidate_recap_table', 'Candidate Recap Table'); ?></h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                      <thead>
                        <tr>
                          <th style="width: 80px;"><?php echo __t('ballot_no', 'Ballot No.'); ?></th>
                          <th><?php echo __t('photo', 'Photo'); ?></th>
                          <th><?php echo __t('candidate_pairs', 'Candidate Pairs'); ?></th>
                          <th><?php echo __t('theme_color', 'Theme Color'); ?></th>
                          <th><?php echo __t('votes_acquired', 'Votes Acquired'); ?></th>
                          <th><?php echo __t('percentage', 'Percentage'); ?></th>
                          <th style="width: 180px;"><?php echo __t('action', 'Action'); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($candidates)): ?>
                          <?php foreach ($candidates as $c): ?>
                            <tr>
                              <td class="text-center font-weight-bold">
                                <span class="badge badge-pill text-white" style="background-color: <?php echo $c->color ?: '#6777ef'; ?>;">
                                  #<?php echo $c->candidate_number; ?>
                                </span>
                              </td>
                              <td>
                                <?php 
                                  $photo_file = !empty($c->photo) ? $c->photo : 'candidate-1.png';
                                  $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                                ?>
                                <img src="<?php echo $photo_src; ?>" class="rounded-circle border" width="40" height="40" style="object-fit: cover;">
                              </td>
                              <td>
                                <div class="font-weight-bold text-dark"><?php echo $c->chairman_name; ?></div>
                                <div class="text-muted small">&amp; <?php echo $c->vice_chairman_name; ?></div>
                              </td>
                              <td>
                                <span class="badge text-white" style="background-color: <?php echo $c->color ?: '#6777ef'; ?>;">
                                  <?php echo $c->color ?: '#6777ef'; ?>
                                </span>
                              </td>
                              <td class="font-weight-bold text-primary"><?php echo $c->total_votes; ?> <?php echo __t('votes', 'votes'); ?></td>
                              <td>
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar" style="width: <?php echo $c->percentage; ?>%; background-color: <?php echo $c->color ?: '#6777ef'; ?>;"></div>
                                </div>
                                <small class="text-muted font-weight-600"><?php echo $c->percentage; ?>%</small>
                              </td>
                              <td>
                                <a href="<?php echo base_url(); ?>candidate/detail/<?php echo $c->id; ?>" class="btn btn-sm btn-info" title="<?php echo __t('detail', 'Details'); ?>"><i class="fas fa-eye"></i></a>
                                <?php if ($this->session->userdata('role') === 'admin'): ?>
                                  <a href="<?php echo base_url(); ?>candidate/edit/<?php echo $c->id; ?>" class="btn btn-sm btn-warning" title="<?php echo __t('edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                                  <a href="<?php echo base_url(); ?>candidate/delete/<?php echo $c->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('<?php echo sprintf(__t('confirm_delete_candidate', 'Are you sure you want to delete candidate #%s? Associated votes will also be deleted.'), $c->candidate_number); ?>');" title="<?php echo __t('delete', 'Delete'); ?>"><i class="fas fa-trash"></i></a>
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>

<?php $this->load->view('dist/_partials/footer'); ?>
