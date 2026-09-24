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
            <h1>Edit Data Pemilih</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></div>
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>voter">Pemilih</a></div>
              <div class="breadcrumb-item active">Edit</div>
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
                  <h4><i class="fas fa-user-edit mr-2 text-primary"></i> Edit Data: <?php echo $voter->name; ?></h4>
                </div>
                <div class="card-body">
                  <?php echo form_open('voter/update/' . $voter->id); ?>

                    <div class="form-group">
                      <label for="voter_code">Kode Pemilih / NIM / NIS <span class="text-danger">*</span></label>
                      <input type="text" id="voter_code" name="voter_code" class="form-control text-uppercase" value="<?php echo set_value('voter_code', $voter->voter_code); ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="card_uid">UID Kartu ID / RFID / NFC <span class="text-muted">(Opsional untuk Login Tap)</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" id="card_uid" name="card_uid" class="form-control" placeholder="Tempelkan kartu ke reader atau ketik UID (Contoh: 0001002016)" value="<?php echo set_value('card_uid', $voter->card_uid); ?>">
                      </div>
                      <small class="form-text text-muted">ID kartu unik untuk login cepat dengan sistem tempel kartu (RFID Reader USB/NFC).</small>
                    </div>

                    <div class="form-group">
                      <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" class="form-control" value="<?php echo set_value('name', $voter->name); ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                      <select id="gender" name="gender" class="form-control" required>
                        <option value="L" <?php echo set_select('gender', 'L', $voter->gender == 'L'); ?>>Laki-laki (L)</option>
                        <option value="P" <?php echo set_select('gender', 'P', $voter->gender == 'P'); ?>>Perempuan (P)</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="class_or_dept">Kelas / Jurusan / Unit <span class="text-danger">*</span></label>
                      <input type="text" id="class_or_dept" name="class_or_dept" class="form-control" value="<?php echo set_value('class_or_dept', $voter->class_or_dept); ?>" required>
                    </div>

                    <div class="form-group">
                      <label>Status Hak Suara:</label>
                      <div>
                        <?php if ($voter->has_voted == 1): ?>
                          <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Sudah Memilih (<?php echo date('d M Y, H:i', strtotime($voter->voted_at)); ?>)</span>
                        <?php else: ?>
                          <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Belum Memilih</span>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="form-group text-right mb-0">
                      <a href="<?php echo base_url(); ?>voter" class="btn btn-secondary mr-2">Batal</a>
                      <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
