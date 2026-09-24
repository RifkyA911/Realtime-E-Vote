<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header d-flex justify-content-between">
            <h1><i class="fas fa-users mr-2 text-primary"></i> Data Pasangan Calon (Kandidat)</h1>
            <div class="section-header-breadcrumb">
              <?php if ($this->session->userdata('role') === 'admin'): ?>
                <a href="<?php echo base_url(); ?>candidate/create" class="btn btn-primary btn-icon icon-left">
                  <i class="fas fa-plus"></i> Tambah Kandidat Baru
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
                        NO. URUT 0<?php echo $c->candidate_number; ?>
                      </span>
                      <span class="badge badge-light border font-weight-bold">
                        <?php echo $c->total_votes; ?> Suara (<?php echo $c->percentage; ?>%)
                      </span>
                    </div>

                    <div class="card-body text-center pb-2">
                      <div class="avatar-item mb-3">
                        <?php 
                          $photo_file = !empty($c->photo) ? $c->photo : 'candidate-1.png';
                          $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                        ?>
                        <img src="<?php echo $photo_src; ?>" alt="Foto Kandidat" class="img-fluid rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                      </div>

                      <h5 class="font-weight-bold text-dark mb-1"><?php echo $c->chairman_name; ?></h5>
                      <p class="text-muted font-weight-600 mb-2">Calon Ketua</p>
                      
                      <div class="py-1 px-3 bg-light rounded d-inline-block mb-3">
                        <span class="text-dark font-weight-bold">&amp; <?php echo $c->vice_chairman_name; ?></span>
                        <div class="small text-muted">Calon Wakil Ketua</div>
                      </div>

                      <div class="text-left mt-2">
                        <h6 class="font-weight-bold text-muted small text-uppercase">Visi Utama:</h6>
                        <p class="text-muted small mb-0" style="min-height: 48px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                          <?php echo nl2br(htmlspecialchars($c->vision)); ?>
                        </p>
                      </div>
                    </div>

                    <div class="card-footer bg-whitesmoke text-center border-top">
                      <div class="btn-group w-100" role="group">
                        <a href="<?php echo base_url(); ?>candidate/detail/<?php echo $c->id; ?>" class="btn btn-outline-info btn-sm">
                          <i class="fas fa-eye"></i> Detail
                        </a>
                        <?php if ($this->session->userdata('role') === 'admin'): ?>
                          <a href="<?php echo base_url(); ?>candidate/edit/<?php echo $c->id; ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          <a href="<?php echo base_url(); ?>candidate/delete/<?php echo $c->id; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kandidat no. urut <?php echo $c->candidate_number; ?>? Suara terkait juga akan dihapus.');">
                            <i class="fas fa-trash"></i> Hapus
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
                    <h4>Belum Ada Data Pasangan Calon</h4>
                    <p class="text-muted">Silakan tambahkan data pasangan calon pertama untuk memulai pemilihan.</p>
                    <a href="<?php echo base_url(); ?>candidate/create" class="btn btn-primary">Tambah Kandidat</a>
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
                  <h4><i class="fas fa-table mr-2 text-primary"></i> Tabel Rekap Data Kandidat</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                      <thead>
                        <tr>
                          <th style="width: 80px;">No. Urut</th>
                          <th>Foto</th>
                          <th>Calon Ketua &amp; Wakil</th>
                          <th>Warna Tema</th>
                          <th>Perolehan Suara</th>
                          <th>Persentase</th>
                          <th style="width: 180px;">Aksi</th>
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
                              <td class="font-weight-bold text-primary"><?php echo $c->total_votes; ?> suara</td>
                              <td>
                                <div class="progress" style="height: 8px;">
                                  <div class="progress-bar" style="width: <?php echo $c->percentage; ?>%; background-color: <?php echo $c->color ?: '#6777ef'; ?>;"></div>
                                </div>
                                <small class="text-muted font-weight-600"><?php echo $c->percentage; ?>%</small>
                              </td>
                              <td>
                                <a href="<?php echo base_url(); ?>candidate/detail/<?php echo $c->id; ?>" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                <?php if ($this->session->userdata('role') === 'admin'): ?>
                                  <a href="<?php echo base_url(); ?>candidate/edit/<?php echo $c->id; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                  <a href="<?php echo base_url(); ?>candidate/delete/<?php echo $c->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kandidat ini?');" title="Hapus"><i class="fas fa-trash"></i></a>
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
