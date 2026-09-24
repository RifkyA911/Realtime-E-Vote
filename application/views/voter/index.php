<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header d-flex justify-content-between">
            <h1><i class="fas fa-address-book mr-2 text-primary"></i> <?php echo __t('voter_registry', 'Registered Voters (DPT)'); ?></h1>
            <div class="section-header-breadcrumb">
              <a href="<?php echo base_url(); ?>voter/create" class="btn btn-primary btn-icon icon-left mr-2">
                <i class="fas fa-user-plus"></i> <?php echo __t('add_voter_title', 'Add New Voter (DPT)'); ?>
              </a>
              <a href="<?php echo base_url(); ?>voter/reset_all" class="btn btn-outline-danger btn-icon icon-left" onclick="return confirm('<?php echo addslashes(__t('confirm_reset_all', 'WARNING: This will reset voting status for ALL voters and clear all cast ballots. Proceed?')); ?>');">
                <i class="fas fa-undo"></i> <?php echo __t('reset_all_votes', 'Reset All Votes'); ?>
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
                    <h4><?php echo __t('stat_total_voters', 'Total Registered Voters'); ?></h4>
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
                    <h4><?php echo __t('stat_voted_count', 'Voters Who Voted'); ?></h4>
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
                    <h4><?php echo __t('stat_unvoted_count', 'Voters Not Voted'); ?></h4>
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
                  <h4><i class="fas fa-list mr-2 text-primary"></i> <?php echo __t('registered_voters_list', 'Registered Voters List'); ?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-voters">
                      <thead>
                        <tr>
                          <th style="width: 40px;">#</th>
                          <th><?php echo __t('voter_code', 'Voter Code / Student ID'); ?></th>
                          <th><?php echo __t('card_uid', 'Card UID (RFID / NFC)'); ?></th>
                          <th><?php echo __t('voter_name', 'Full Name'); ?></th>
                          <th><?php echo __t('gender', 'Gender'); ?></th>
                          <th><?php echo __t('class_or_dept', 'Class / Major / Unit'); ?></th>
                          <th><?php echo __t('status', 'Status'); ?></th>
                          <th><?php echo __t('vote_time', 'Vote Timestamp'); ?></th>
                          <th style="width: 150px;"><?php echo __t('action', 'Action'); ?></th>
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
                                  <span class="badge badge-info"><i class="fas fa-mars mr-1"></i> M</span>
                                <?php else: ?>
                                  <span class="badge badge-danger"><i class="fas fa-venus mr-1"></i> F</span>
                                <?php endif; ?>
                              </td>
                              <td><?php echo $v->class_or_dept; ?></td>
                              <td>
                                <?php if ($v->has_voted == 1): ?>
                                  <span class="badge badge-success"><i class="fas fa-check mr-1"></i> <?php echo __t('status_has_voted', 'Has Voted'); ?></span>
                                <?php else: ?>
                                  <span class="badge badge-warning"><i class="fas fa-hourglass-half mr-1"></i> <?php echo __t('status_not_voted', 'Not Voted'); ?></span>
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
                                    <a href="<?php echo base_url(); ?>voter/reset_status/<?php echo $v->id; ?>" class="btn btn-sm btn-outline-warning" title="<?php echo __t('reset_vote_status', 'Reset Voting Status'); ?>" onclick="return confirm('<?php echo sprintf(__t('confirm_reset_status', 'Reset voting status for %s?'), addslashes($v->name)); ?>');">
                                      <i class="fas fa-redo"></i>
                                    </a>
                                  <?php else: ?>
                                    <a href="<?php echo base_url(); ?>vote?code=<?php echo $v->voter_code; ?>" class="btn btn-sm btn-outline-success" title="<?php echo __t('vote_now', 'Vote Now'); ?>">
                                      <i class="fas fa-vote-yea"></i>
                                    </a>
                                  <?php endif; ?>
                                  <a href="<?php echo base_url(); ?>voter/edit/<?php echo $v->id; ?>" class="btn btn-sm btn-outline-primary" title="<?php echo __t('edit', 'Edit'); ?>">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                  <a href="<?php echo base_url(); ?>voter/delete/<?php echo $v->id; ?>" class="btn btn-sm btn-outline-danger" title="<?php echo __t('delete', 'Delete'); ?>" onclick="return confirm('<?php echo sprintf(__t('confirm_delete_voter', 'Delete voter %s?'), addslashes($v->name)); ?>');">
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
        "search": "<?php echo __t('search_voters', 'Search Voters:'); ?>",
        "lengthMenu": "<?php echo __t('show_entries', 'Show _MENU_ entries per page'); ?>",
        "zeroRecords": "<?php echo __t('zero_records', 'No matching voter records found'); ?>",
        "info": "<?php echo __t('info_showing', 'Showing _START_ to _END_ of _TOTAL_ voters'); ?>",
        "infoEmpty": "<?php echo __t('info_empty', 'Showing 0 to 0 of 0 voters'); ?>",
        "infoFiltered": "<?php echo __t('info_filtered', '(filtered from _MAX_ total records)'); ?>",
        "paginate": {
          "first": "<?php echo __t('first', 'First'); ?>",
          "last": "<?php echo __t('last', 'Last'); ?>",
          "next": "<?php echo __t('next', 'Next'); ?>",
          "previous": "<?php echo __t('previous', 'Previous'); ?>"
        }
      }
    });
  }
});
</script>
