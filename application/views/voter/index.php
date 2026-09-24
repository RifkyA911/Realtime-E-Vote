<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header d-flex justify-content-between">
            <h1><i class="fas fa-address-book mr-2 text-primary"></i> <?php echo __t('voter_list', 'Data Pemilih Tetap (DPT)'); ?></h1>
            <div class="section-header-breadcrumb">
              <a href="<?php echo base_url(); ?>voter/create" class="btn btn-primary btn-icon icon-left mr-2">
                <i class="fas fa-user-plus"></i> <?php echo __t('add_voter', 'Tambah Pemilih Baru'); ?>
              </a>
              <a href="<?php echo base_url(); ?>voter/reset_all" class="btn btn-outline-danger btn-icon icon-left" onclick="return confirm('<?php echo addslashes(__t('confirm_reset_votes', 'PERINGATAN: Ini akan mereset status memilih SEMUA pemilih dan mengosongkan suara yang sudah masuk. Lanjutkan?')); ?>');">
                <i class="fas fa-undo"></i> <?php echo __t('reset_all', 'Reset Semua Suara'); ?>
              </a>
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

          <!-- Mini Stat Cards -->
          <div class="row">
            <div class="col-md-4">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary shadow-primary">
                  <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Pemilih (DPT)</h4>
                  </div>
                  <div class="card-body">
                    <?php echo number_format($total_voters); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success shadow-success">
                  <i class="fas fa-check-double"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Sudah Memberi Suara</h4>
                  </div>
                  <div class="card-body">
                    <?php echo number_format($total_voted); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning shadow-warning">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Belum Memberi Suara</h4>
                  </div>
                  <div class="card-body">
                    <?php echo number_format($total_unvoted); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Voter Table Card -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-list mr-2 text-primary"></i> Daftar Pemilih Terdaftar</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-voters">
                      <thead>
                        <tr>
                          <th style="width: 40px;">#</th>
                          <th>Kode / NIM / NIS</th>
                          <th>UID Kartu (RFID)</th>
                          <th>Nama Lengkap</th>
                          <th>L/P</th>
                          <th>Kelas / Jurusan</th>
                          <th>Status Memilih</th>
                          <th>Waktu Mencoblos</th>
                          <th style="width: 150px;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($voters)): ?>
                          <?php $no = 1; foreach ($voters as $v): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><span class="badge badge-light border font-weight-bold text-dark"><?php echo $v->voter_code; ?></span></td>
                              <td>
                                <?php if (!empty($v->card_uid)): ?>
                                  <code class="text-primary font-weight-bold"><i class="fas fa-id-card mr-1"></i><?php echo $v->card_uid; ?></code>
                                <?php else: ?>
                                  <span class="text-muted small">-</span>
                                <?php endif; ?>
                              </td>
                              <td class="font-weight-bold text-dark"><?php echo $v->name; ?></td>
                              <td>
                                <?php if ($v->gender == 'L'): ?>
                                  <span class="badge badge-info"><i class="fas fa-mars mr-1"></i> L</span>
                                <?php else: ?>
                                  <span class="badge badge-danger"><i class="fas fa-venus mr-1"></i> P</span>
                                <?php endif; ?>
                              </td>
                              <td><?php echo $v->class_or_dept; ?></td>
                              <td>
                                <?php if ($v->has_voted == 1): ?>
                                  <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Sudah Memilih</span>
                                <?php else: ?>
                                  <span class="badge badge-warning"><i class="fas fa-hourglass-half mr-1"></i> Belum Memilih</span>
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php if ($v->has_voted == 1 && !empty($v->voted_at)): ?>
                                  <small class="text-muted"><i class="far fa-clock mr-1"></i> <?php echo date('d M Y, H:i', strtotime($v->voted_at)); ?></small>
                                <?php else: ?>
                                  <span class="text-muted small">-</span>
                                <?php endif; ?>
                              </td>
                              <td>
                                <div class="btn-group" role="group">
                                  <?php if ($v->has_voted == 1): ?>
                                    <a href="<?php echo base_url(); ?>voter/reset_status/<?php echo $v->id; ?>" class="btn btn-sm btn-outline-warning" title="Reset Status Memilih" onclick="return confirm('Reset status memilih untuk <?php echo $v->name; ?>?');">
                                      <i class="fas fa-redo"></i>
                                    </a>
                                  <?php else: ?>
                                    <a href="<?php echo base_url(); ?>vote?code=<?php echo $v->voter_code; ?>" class="btn btn-sm btn-outline-success" title="Coblos Sekarang">
                                      <i class="fas fa-vote-yea"></i>
                                    </a>
                                  <?php endif; ?>
                                  <a href="<?php echo base_url(); ?>voter/edit/<?php echo $v->id; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="<?php echo base_url(); ?>voter/delete/<?php echo $v->id; ?>" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Hapus pemilih <?php echo $v->name; ?>?');">
                                    <i class="fas fa-trash"></i>
                                  </a>
                                </div>
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

<script>
$(document).ready(function() {
  if ($.fn.DataTable) {
    $('#table-voters').DataTable({
      "pageLength": 10,
      "language": {
        "search": "Cari Pemilih:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Tidak ada data pemilih yang sesuai",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ pemilih",
        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 pemilih",
        "infoFiltered": "(disaring dari _MAX_ total data)",
        "paginate": {
          "first": "Awal",
          "last": "Akhir",
          "next": "Berikutnya",
          "previous": "Sebelumnya"
        }
      }
    });
  }
});
</script>
