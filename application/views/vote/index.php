<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><i class="fas fa-person-booth mr-2 text-primary"></i> <?php echo __t('booth_title', 'Electronic Voting Booth'); ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo __t('home', 'Home'); ?></a></div>
              <div class="breadcrumb-item active"><?php echo __t('menu_booth', 'Voting Booth'); ?></div>
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

          <!-- Voter Verification Box -->
          <?php if ($user_role === 'voter'): ?>
            <?php if ($already_voted): ?>
              <div class="row">
                <div class="col-12">
                  <div class="card card-success shadow-sm mb-4">
                    <div class="card-body py-4">
                      <div class="d-flex align-items-center">
                        <div class="mr-4">
                          <span class="badge badge-success p-3 rounded-circle"><i class="fas fa-check-double fa-3x"></i></span>
                        </div>
                        <div>
                          <h4 class="text-success font-weight-bold mb-1"><i class="fas fa-check-circle mr-1"></i> <?php echo __t('voted_confirmation_title', 'You Have Cast Your Vote'); ?></h4>
                          <p class="text-dark mb-1">
                            <?php echo sprintf(__t('msg_voter_already_voted_desc', 'Hello <strong>%s</strong> (Code: <code>%s</code> | %s), thank you for your participation. Your vote was securely recorded at <strong>%s</strong>.'), htmlspecialchars($my_voter->name), htmlspecialchars($my_voter->voter_code), htmlspecialchars($my_voter->class_or_dept), date('d M Y, H:i', strtotime($my_voter->voted_at))); ?>
                          </p>
                          <div class="mt-2">
                            <a href="<?php echo base_url(); ?>dashboard" class="btn btn-primary btn-sm"><i class="fas fa-chart-pie mr-1"></i> <?php echo __t('view_all', 'View Real Count Results'); ?></a>
                            <a href="<?php echo base_url(); ?>candidate" class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-users mr-1"></i> <?php echo __t('menu_candidates', 'View Candidates'); ?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="row">
                <div class="col-12">
                  <div class="card card-hero shadow-sm mb-4">
                    <div class="card-header bg-gradient-primary text-white py-3">
                      <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                          <h4 class="text-white mb-0"><i class="fas fa-id-card mr-2"></i> <?php echo __t('voter_verified_title', 'Verified Voter Identity'); ?></h4>
                          <p class="text-white-50 mb-0 small"><?php echo __t('voter_verified_desc', 'Your identity has been verified in the DPT. Please cast your ballot below.'); ?></p>
                        </div>
                        <div class="mt-2 mt-md-0">
                          <span class="badge badge-success font-weight-bold px-3 py-2" style="font-size: 13px;">
                            <i class="fas fa-user-check mr-1"></i> <?php echo __t('registered_in_dpt', 'Registered in DPT'); ?>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="card-body bg-light">
                      <div class="d-flex align-items-center flex-wrap">
                        <div class="mr-3">
                          <span class="badge badge-success badge-pill p-3"><i class="fas fa-user-check fa-2x"></i></span>
                        </div>
                        <div>
                          <h4 class="mb-0 text-dark font-weight-bold"><?php echo htmlspecialchars($my_voter->name); ?></h4>
                          <div class="text-muted">
                            <?php echo __t('voter_code', 'Voter Code'); ?>: <strong><?php echo htmlspecialchars($my_voter->voter_code); ?></strong> | <?php echo __t('class_or_dept', 'Class / Major'); ?>: <strong><?php echo htmlspecialchars($my_voter->class_or_dept); ?></strong> | <?php echo __t('status', 'Status'); ?>: <span class="badge badge-warning"><?php echo __t('status_not_voted', 'Not Voted'); ?></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          <?php else: ?>
            <!-- Admin Voter Selector Box -->
            <div class="row">
              <div class="col-12">
                <div class="card card-hero shadow-sm mb-4">
                  <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                      <div>
                        <h4 class="text-white mb-0"><i class="fas fa-id-card mr-2"></i> <?php echo __t('step1_admin_title', 'Step 1: Select / Verify Voter Identity'); ?></h4>
                        <p class="text-white-50 mb-0 small"><?php echo __t('step1_admin_desc', 'Select a voter who has not yet voted for live voting simulation.'); ?></p>
                      </div>
                      <div class="mt-2 mt-md-0">
                        <span class="badge badge-warning font-weight-bold px-3 py-2" style="font-size: 13px;">
                          <i class="fas fa-users mr-1"></i> <?php echo $total_unvoted; ?> <?php echo __t('unvoted_count_badge', 'Voters Not Voted'); ?>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="card-body bg-light">
                    <div class="row align-items-center">
                      <div class="col-md-7 mb-3 mb-md-0">
                        <label class="font-weight-bold text-dark mb-1"><?php echo __t('select_voter_label', 'Select Voter from DPT Registry:'); ?></label>
                        <select id="voterSelect" class="form-control" onchange="onVoterChanged(this)">
                          <option value=""><?php echo __t('select_voter_placeholder', '-- Please Select an Unvoted Voter --'); ?></option>
                          <?php if (!empty($unvoted_voters)): ?>
                            <?php foreach ($unvoted_voters as $uv): ?>
                              <?php 
                                $is_sel = ($selected_voter && $selected_voter->id == $uv->id) ? 'selected' : '';
                              ?>
                              <option value="<?php echo $uv->id; ?>" 
                                      data-name="<?php echo htmlspecialchars($uv->name); ?>" 
                                      data-code="<?php echo htmlspecialchars($uv->voter_code); ?>" 
                                      data-dept="<?php echo htmlspecialchars($uv->class_or_dept); ?>" 
                                      <?php echo $is_sel; ?>>
                                [<?php echo $uv->voter_code; ?>] <?php echo $uv->name; ?> - <?php echo $uv->class_or_dept; ?>
                              </option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                        <small class="text-muted d-block mt-1"><?php echo __t('unvoted_only_note', 'This list only shows voters with Not Voted status.'); ?></small>
                      </div>

                      <div class="col-md-5">
                        <!-- Verified Voter Badge Card -->
                        <div id="voterInfoCard" class="card mb-0 border border-success <?php echo empty($selected_voter) ? 'd-none' : ''; ?>" style="background-color: #f6fff9;">
                          <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                              <div class="mr-3">
                                <span class="badge badge-success badge-pill p-2"><i class="fas fa-user-check fa-2x"></i></span>
                              </div>
                              <div>
                                <div class="text-success font-weight-bold small text-uppercase"><i class="fas fa-check-circle mr-1"></i> <?php echo __t('selected_voter', 'Verified Voter Identity'); ?></div>
                                <h5 class="mb-0 text-dark font-weight-bold" id="infoVoterName"><?php echo $selected_voter ? $selected_voter->name : ''; ?></h5>
                                <div class="small text-muted" id="infoVoterDetails">
                                  <?php if ($selected_voter): ?>
                                    ID: <strong><?php echo $selected_voter->voter_code; ?></strong> | <?php echo $selected_voter->class_or_dept; ?>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="voterWarningCard" class="card mb-0 border border-warning <?php echo !empty($selected_voter) ? 'd-none' : ''; ?>" style="background-color: #fffdf5;">
                          <div class="card-body p-3 text-center text-warning font-weight-bold">
                            <i class="fas fa-exclamation-triangle mr-1"></i> <?php echo __t('select_voter_warning', 'Please select a voter on the left panel before casting a vote!'); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- Section 2: Surat Suara / Kandidat Cards -->
          <div class="row">
            <div class="col-12">
              <div class="card mb-3">
                <div class="card-header bg-white border-bottom">
                  <h4 class="text-dark"><i class="fas fa-vote-yea mr-2 text-primary"></i> <?php echo __t('step2_ballot_title', 'Step 2: Electronic Ballot Paper'); ?></h4>
                  <div class="card-header-action text-muted small">
                    <?php echo __t('step2_ballot_desc', 'Cast your vote for one of the candidate pairs below:'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Candidates Grid -->
          <div class="row">
            <?php if (!empty($candidates)): ?>
              <?php foreach ($candidates as $c): ?>
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                  <div class="card card-primary w-100 shadow text-center position-relative" style="border-top-color: <?php echo $c->color ?: '#6777ef'; ?> !important; border-top-width: 5px !important; border-radius: 12px; overflow: hidden;">
                    
                    <!-- Candidate Number Big Circle -->
                    <div class="pt-4 pb-2">
                      <div class="d-inline-flex justify-content-center align-items-center rounded-circle text-white shadow" style="width: 75px; height: 75px; background-color: <?php echo $c->color ?: '#6777ef'; ?>; font-size: 32px; font-weight: 800; border: 4px solid #fff;">
                        0<?php echo $c->candidate_number; ?>
                      </div>
                    </div>

                    <div class="card-body pt-2 pb-3">
                      <!-- Photo -->
                      <div class="mb-3">
                        <?php 
                          $photo_file = !empty($c->photo) ? $c->photo : 'candidate-1.png';
                          $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                        ?>
                        <img src="<?php echo $photo_src; ?>" alt="Foto" class="rounded-circle shadow-sm border" style="width: 130px; height: 130px; object-fit: cover;">
                      </div>

                      <h4 class="font-weight-bold text-dark mb-1" style="font-size: 19px;"><?php echo $c->chairman_name; ?></h4>
                      <p class="text-primary font-weight-bold mb-2"><?php echo __t('chairman', 'Chairman Candidate'); ?></p>

                      <div class="bg-light py-2 px-3 rounded d-inline-block mb-3 border">
                        <span class="font-weight-bold text-dark">&amp; <?php echo $c->vice_chairman_name; ?></span>
                        <div class="small text-muted"><?php echo __t('vice_chairman', 'Vice Chairman Candidate'); ?></div>
                      </div>

                      <div class="text-left mt-2 mb-3 bg-whitesmoke p-3 rounded" style="font-size: 13px;">
                        <strong class="text-muted text-uppercase d-block mb-1"><?php echo __t('vision', 'Vision'); ?>:</strong>
                        <div class="text-muted" style="height: 48px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                          <?php echo htmlspecialchars($c->vision); ?>
                        </div>
                      </div>

                      <button type="button" class="btn btn-outline-info btn-sm btn-block mb-3" data-toggle="modal" data-target="#modalDetail<?php echo $c->id; ?>">
                        <i class="fas fa-info-circle mr-1"></i> <?php echo __t('vision_mission', 'Vision & Mission'); ?>
                      </button>

                      <!-- Big Coblos Button -->
                      <?php if ($already_voted): ?>
                        <button type="button" class="btn btn-lg btn-block btn-secondary disabled shadow-none" disabled style="padding: 12px;">
                          <i class="fas fa-check-circle mr-1"></i> <?php echo __t('status_has_voted', 'Has Voted'); ?>
                        </button>
                      <?php else: ?>
                        <button type="button" class="btn btn-lg btn-block font-weight-bold text-white shadow" 
                                 style="background-color: <?php echo $c->color ?: '#6777ef'; ?>; border: none; padding: 12px;" 
                                 onclick="promptVote(<?php echo $c->id; ?>, <?php echo $c->candidate_number; ?>, '<?php echo addslashes($c->chairman_name . ' & ' . $c->vice_chairman_name); ?>')">
                          <i class="fas fa-stamp mr-1"></i> <?php echo __t('btn_vote_this', 'VOTE PAIR'); ?> 0<?php echo $c->candidate_number; ?>
                        </button>
                      <?php endif; ?>
                    </div>

                  </div>
                </div>

                <!-- Detail Modal for each candidate -->
                <div class="modal fade" id="modalDetail<?php echo $c->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content text-left">
                      <div class="modal-header bg-light">
                        <h5 class="modal-title font-weight-bold text-dark">
                          <span class="badge badge-pill text-white mr-2" style="background-color: <?php echo $c->color ?: '#6777ef'; ?>;">
                            0<?php echo $c->candidate_number; ?>
                          </span>
                          <?php echo $c->chairman_name; ?> &amp; <?php echo $c->vice_chairman_name; ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body p-4">
                        <div class="row align-items-center mb-4">
                          <div class="col-md-3 text-center">
                            <img src="<?php echo $photo_src; ?>" class="rounded-circle border shadow-sm" width="90" height="90" style="object-fit: cover;">
                          </div>
                          <div class="col-md-9">
                            <h4 class="font-weight-bold text-dark mb-0"><?php echo $c->chairman_name; ?></h4>
                            <div class="text-primary font-weight-600 mb-1"><?php echo __t('chairman', 'Chairman Candidate'); ?></div>
                            <h5 class="font-weight-bold text-muted mb-0">&amp; <?php echo $c->vice_chairman_name; ?></h5>
                            <div class="text-muted small"><?php echo __t('vice_chairman', 'Vice Chairman Candidate'); ?></div>
                          </div>
                        </div>

                        <div class="mb-3">
                          <h6 class="font-weight-bold text-primary"><i class="fas fa-bullseye mr-2"></i> <?php echo __t('vision', 'Vision'); ?>:</h6>
                          <div class="p-3 bg-light rounded font-italic text-dark">
                            "<?php echo nl2br(htmlspecialchars($c->vision)); ?>"
                          </div>
                        </div>

                        <div>
                          <h6 class="font-weight-bold text-success"><i class="fas fa-tasks mr-2"></i> <?php echo __t('mission', 'Mission'); ?>:</h6>
                          <div class="p-3 bg-light rounded text-dark" style="line-height: 1.8;">
                            <?php echo nl2br(htmlspecialchars($c->mission)); ?>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer bg-whitesmoke">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo __t('close', 'Close'); ?></button>
                        <?php if (!$already_voted): ?>
                          <button type="button" class="btn btn-primary font-weight-bold" data-dismiss="modal" onclick="promptVote(<?php echo $c->id; ?>, <?php echo $c->candidate_number; ?>, '<?php echo addslashes($c->chairman_name . ' & ' . $c->vice_chairman_name); ?>')">
                            <i class="fas fa-stamp mr-1"></i> <?php echo __t('btn_vote_this', 'VOTE PAIR'); ?>
                          </button>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>

              <?php endforeach; ?>
            <?php endif; ?>
          </div>

        </section>
      </div>

      <!-- Confirmation Vote Modal -->
      <div class="modal fade" id="modalConfirmVote" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-vote-yea mr-2"></i> <?php echo __t('confirm_vote_title', 'Ballot Confirmation'); ?></h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php echo form_open('vote/cast', array('id' => 'formVote')); ?>
              <input type="hidden" name="voter_id" id="postVoterId">
              <input type="hidden" name="candidate_id" id="postCandidateId">

              <div class="modal-body text-center p-4">
                <div class="mb-3">
                  <span class="badge badge-warning badge-pill p-3 text-white" style="font-size: 26px;">
                    <i class="fas fa-check-double"></i>
                  </span>
                </div>
                <h5 class="text-dark font-weight-bold mb-2"><?php echo __t('confirm_vote_subtitle', 'Are you sure about your selection?'); ?></h5>
                
                <div class="p-3 bg-light rounded my-3 text-left border">
                  <div class="mb-2">
                    <small class="text-muted d-block"><?php echo __t('voter', 'Voter'); ?>:</small>
                    <strong class="text-dark" id="modalVoterLabel">-</strong>
                  </div>
                  <div>
                    <small class="text-muted d-block"><?php echo __t('candidate_pair', 'Candidate Pair'); ?>:</small>
                    <strong class="text-primary" id="modalCandidateLabel">-</strong>
                  </div>
                </div>

                <p class="text-muted small mb-0">
                  <i class="fas fa-lock mr-1 text-warning"></i> <?php echo __t('vote_irreversible_note', 'Once confirmed, your ballot will be officially cast and cannot be changed.'); ?>
                </p>
              </div>

              <div class="modal-footer bg-whitesmoke justify-content-center">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal"><?php echo __t('btn_cancel', 'Cancel'); ?></button>
                <button type="submit" class="btn btn-success font-weight-bold px-4">
                  <i class="fas fa-check mr-1"></i> <?php echo __t('btn_confirm_vote', 'Yes, Cast Vote Now!'); ?>
                </button>
              </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>

<?php $this->load->view('dist/_partials/footer'); ?>

<script>
var currentUserRole = "<?php echo $user_role; ?>";
var myVoterId   = "<?php echo ($user_role === 'voter' && $my_voter) ? $my_voter->id : ''; ?>";
var myVoterName = "<?php echo ($user_role === 'voter' && $my_voter) ? addslashes($my_voter->name) : ''; ?>";
var myVoterCode = "<?php echo ($user_role === 'voter' && $my_voter) ? addslashes($my_voter->voter_code) : ''; ?>";

function onVoterChanged(select) {
  var selOption = select.options[select.selectedIndex];
  if (select.value) {
    var name = selOption.getAttribute('data-name');
    var code = selOption.getAttribute('data-code');
    var dept = selOption.getAttribute('data-dept');

    $('#infoVoterName').text(name);
    $('#infoVoterDetails').html('<?php echo __t('voter_code', 'Code'); ?>: <strong>' + code + '</strong> | ' + dept);
    $('#voterInfoCard').removeClass('d-none');
    $('#voterWarningCard').addClass('d-none');
  } else {
    $('#voterInfoCard').addClass('d-none');
    $('#voterWarningCard').removeClass('d-none');
  }
}

function promptVote(candidateId, candidateNumber, candidateNames) {
  var voterId, voterName, voterCode;

  if (currentUserRole === 'voter') {
    voterId   = myVoterId;
    voterName = myVoterName;
    voterCode = myVoterCode;
  } else {
    var voterSelect = document.getElementById('voterSelect');
    if (!voterSelect || !voterSelect.value) {
      if (typeof swal !== 'undefined') {
        swal({
          title: '<?php echo __t('voter_not_selected_title', 'Voter Not Selected!'); ?>',
          text: '<?php echo __t('voter_not_selected_msg', 'Please select a registered voter in Step 1 before casting a ballot.'); ?>',
          icon: 'warning',
          button: '<?php echo __t('btn_understand', 'Understood'); ?>'
        }).then(function() {
          $('html, body').animate({
            scrollTop: $("#voterSelect").offset().top - 120
          }, 500);
          $('#voterSelect').focus();
        });
      } else {
        alert('<?php echo __t('voter_not_selected_msg', 'Please select a registered voter in Step 1 before casting a ballot.'); ?>');
        if (voterSelect) voterSelect.focus();
      }
      return;
    }
    voterId = voterSelect.value;
    var selOption = voterSelect.options[voterSelect.selectedIndex];
    voterName = selOption.getAttribute('data-name');
    voterCode = selOption.getAttribute('data-code');
  }

  $('#postVoterId').val(voterId);
  $('#postCandidateId').val(candidateId);
  $('#modalVoterLabel').text(voterName + ' (' + voterCode + ')');
  $('#modalCandidateLabel').text('#0' + candidateNumber + ' - ' + candidateNames);

  $('#modalConfirmVote').modal('show');
}
</script>
