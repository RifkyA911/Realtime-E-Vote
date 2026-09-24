<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header d-flex justify-content-between align-items-center flex-wrap">
            <div>
              <h1><i class="fas fa-chart-pie mr-2 text-primary"></i> Simple E-Vote &mdash; <?php echo __t('menu_dashboard', 'Dashboard & Live Count'); ?></h1>
            </div>
            
            <!-- Real-Time Live Count Controls & Cetak Rekap -->
            <div class="d-flex align-items-center flex-wrap mt-2 mt-md-0">
              <!-- WebSocket Indicator Badge -->
              <div class="mr-2 mb-1">
                <span id="ws-indicator-badge" class="badge badge-light border text-muted px-3 py-2 d-inline-flex align-items-center shadow-sm" style="font-size: 12px;">
                  <i class="fas fa-satellite-dish mr-1 text-primary" id="ws-indicator-icon"></i>
                  <span id="ws-indicator-text"><?php echo __t('ws_connecting', 'Connecting WebSocket...'); ?></span>
                </span>
              </div>

              <!-- Live Indicator Badge -->
              <div class="mr-2 mb-1">
                <span id="live-indicator-badge" class="badge badge-success px-3 py-2 d-inline-flex align-items-center shadow-sm" style="font-size: 12px;">
                  <span class="live-pulse-dot" id="live-pulse"></span>
                  <span id="live-status-text"><?php echo __t('live_count_on', 'LIVE COUNT ON'); ?></span>
                  <span class="text-white-50 ml-1 small" id="live-timer-text">(4s)</span>
                </span>
              </div>

              <!-- Toggle Auto-Refresh -->
              <button id="btn-toggle-live" class="btn btn-sm btn-outline-secondary mr-2 mb-1 shadow-sm" title="<?php echo __t('btn_pause', 'Pause'); ?>">
                <i class="fas fa-pause mr-1" id="btn-toggle-icon"></i> <span id="btn-toggle-text"><?php echo __t('btn_pause', 'Pause'); ?></span>
              </button>

              <!-- Manual Refresh -->
              <button id="btn-manual-refresh" class="btn btn-sm btn-outline-primary mr-2 mb-1 shadow-sm" title="<?php echo __t('btn_refresh', 'Refresh'); ?>">
                <i class="fas fa-sync-alt mr-1"></i> <?php echo __t('btn_refresh', 'Refresh'); ?>
              </button>

              <!-- Cetak Berita Acara & Rekapitulasi Suara -->
              <a href="<?php echo base_url('dashboard/print_rekap'); ?>" target="_blank" class="btn btn-sm btn-danger font-weight-bold shadow-sm mb-1">
                <i class="fas fa-print mr-1"></i> <?php echo __t('menu_print_recap', 'Print Official Recap'); ?>
              </a>
            </div>
          </div>

          <!-- Flash Messages -->
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible show fade shadow-sm">
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <i class="fas fa-check-circle mr-1"></i> <?php echo $this->session->flashdata('success'); ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible show fade shadow-sm">
              <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <i class="fas fa-exclamation-triangle mr-1"></i> <?php echo $this->session->flashdata('error'); ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Last Updated Bar -->
          <div class="d-flex justify-content-between align-items-center mb-3 text-muted small px-1">
            <div>
              <i class="fas fa-clock mr-1 text-primary"></i> <?php echo __t('last_updated', 'Last Updated'); ?>: <strong id="last-update-time" class="text-dark"><?php echo date('H:i:s'); ?></strong>
            </div>
            <div>
              <span class="badge badge-light border"><i class="fas fa-shield-alt text-success mr-1"></i> <?php echo __t('realtime_verified_system', 'Real-Time & Verified System'); ?></span>
            </div>
          </div>

          <!-- Hero Action Banner -->
          <div class="row">
            <div class="col-12">
              <div class="hero bg-primary text-white mb-4 rounded shadow-sm" style="padding: 22px 28px;">
                <div class="hero-inner d-flex justify-content-between align-items-center flex-wrap">
                  <div>
                    <h2 class="text-white mb-1"><i class="fas fa-person-booth mr-2"></i> Simple E-Vote &bull; <?php echo __t('hero_title', 'Modern Online E-Voting System'); ?></h2>
                    <p class="lead mb-0 text-white-50"><?php echo __t('hero_subtitle', 'Cast your vote honestly, fairly, transparently, and in real time.'); ?> <span class="badge badge-light text-primary font-weight-bold ml-1"><i class="fas fa-id-card mr-1"></i> Tap ID Card Ready</span></p>
                  </div>
                  <div class="mt-3 mt-md-0">
                    <a href="<?php echo base_url(); ?>vote" class="btn btn-warning btn-lg font-weight-bold shadow">
                      <i class="fas fa-vote-yea mr-2"></i> <?php echo __t('enter_booth', 'Enter Voting Booth'); ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 4 Stat Cards -->
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-primary shadow-primary">
                  <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?php echo __t('stat_total_dpt', 'Total Voters (DPT)'); ?></h4>
                  </div>
                  <div class="card-body" id="stat-total-voters">
                    <?php echo number_format($total_voters); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-success shadow-success">
                  <i class="fas fa-vote-yea"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?php echo __t('stat_voted', 'Ballots Cast'); ?></h4>
                  </div>
                  <div class="card-body" id="stat-total-voted">
                    <?php echo number_format($total_voted); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-warning shadow-warning">
                  <i class="fas fa-user-clock"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?php echo __t('stat_unvoted', 'Not Voted'); ?></h4>
                  </div>
                  <div class="card-body" id="stat-total-unvoted">
                    <?php echo number_format($total_unvoted); ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 shadow-sm">
                <div class="card-icon bg-info shadow-info">
                  <i class="fas fa-percentage"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4><?php echo __t('stat_participation', 'Participation'); ?></h4>
                  </div>
                  <div class="card-body" id="stat-participation-rate">
                    <?php echo $participation_rate; ?>%
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Real Count Visual Breakdown -->
          <div class="row">
            <!-- Chart Column -->
            <div class="col-lg-7 col-md-12">
              <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4><i class="fas fa-chart-bar mr-2 text-primary"></i> <?php echo __t('vote_chart_title', 'Real Count Vote Breakdown Chart'); ?></h4>
                  <span class="badge badge-primary font-weight-bold" id="badge-chart-voted"><?php echo $total_voted; ?> <?php echo __t('stat_voted', 'Ballots Cast'); ?></span>
                </div>
                <div class="card-body">
                  <div id="chart-wrapper">
                    <?php if ($total_voted > 0): ?>
                      <canvas id="voteChart" height="150"></canvas>
                    <?php else: ?>
                      <div id="chart-empty-state" class="empty-state" data-height="250">
                        <div class="empty-state-icon bg-light text-muted">
                          <i class="fas fa-inbox"></i>
                        </div>
                        <h2><?php echo __t('no_votes_yet', 'No Ballots Cast Yet'); ?></h2>
                        <p class="lead"><?php echo __t('start_voting_prompt', 'Please start voting in the Voting Booth.'); ?></p>
                        <a href="<?php echo base_url(); ?>vote" class="btn btn-primary mt-4"><?php echo __t('enter_booth', 'Enter Voting Booth'); ?></a>
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="mt-4">
                    <h6 class="font-weight-bold text-muted mb-3"><i class="fas fa-tasks mr-1"></i> <?php echo __t('vote_percentage', 'Vote Percentage Breakdown:'); ?></h6>
                    <div id="candidate-progress-container">
                      <?php foreach ($candidates as $c): ?>
                        <div class="mb-3 candidate-progress-item" data-candidate-id="<?php echo $c->id; ?>">
                          <div class="d-flex justify-content-between font-weight-600 mb-1">
                            <span>
                              <span class="badge badge-sm text-white mr-1" style="background-color: <?php echo $c->color ?: '#6777ef'; ?>;">
                                #<?php echo $c->candidate_number; ?>
                              </span>
                              <?php echo $c->chairman_name; ?> &amp; <?php echo $c->vice_chairman_name; ?>
                            </span>
                            <span class="text-primary font-weight-bold" id="progress-text-<?php echo $c->id; ?>">
                              <?php echo $c->total_votes; ?> <?php echo __t('votes', 'votes'); ?> (<?php echo $c->percentage; ?>%)
                            </span>
                          </div>
                          <div class="progress" style="height: 12px; border-radius: 6px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                                 id="progress-bar-<?php echo $c->id; ?>"
                                 style="width: <?php echo $c->percentage; ?>%; background-color: <?php echo $c->color ?: '#6777ef'; ?>;" 
                                 aria-valuenow="<?php echo $c->percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Candidate Quick Cards -->
            <div class="col-lg-5 col-md-12">
              <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4><i class="fas fa-users mr-2 text-primary"></i> <?php echo __t('candidate_pairs', 'Candidate Pairs'); ?></h4>
                  <a href="<?php echo base_url(); ?>candidate" class="btn btn-sm btn-outline-primary"><?php echo __t('view_all', 'View All'); ?></a>
                </div>
                <div class="card-body p-0">
                  <div class="list-group list-group-flush" id="candidate-cards-container">
                    <?php foreach ($candidates as $c): ?>
                      <div class="list-group-item d-flex align-items-center justify-content-between py-3 candidate-card-item" data-candidate-id="<?php echo $c->id; ?>">
                        <div class="d-flex align-items-center">
                          <div class="position-relative mr-3">
                            <?php 
                              $photo_file = !empty($c->photo) ? $c->photo : 'candidate-1.png';
                              $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                            ?>
                            <img src="<?php echo $photo_src; ?>" alt="Foto" class="rounded-circle border shadow-sm" width="55" height="55" style="object-fit: cover;">
                            <span class="badge badge-pill badge-primary position-absolute" style="top: -5px; right: -5px; font-size: 11px; background-color: <?php echo $c->color ?: '#6777ef'; ?>;">
                              <?php echo $c->candidate_number; ?>
                            </span>
                          </div>
                          <div>
                            <div class="font-weight-bold text-dark" style="font-size: 15px;">
                              <?php echo $c->chairman_name; ?>
                            </div>
                            <div class="text-muted small">
                              &amp; <?php echo $c->vice_chairman_name; ?>
                            </div>
                            <div class="mt-1">
                              <a href="<?php echo base_url(); ?>candidate/detail/<?php echo $c->id; ?>" class="small font-weight-600 text-info">
                                <i class="fas fa-info-circle mr-1"></i> <?php echo __t('vision_mission', 'Vision & Mission'); ?>
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="text-right">
                          <h4 class="mb-0 font-weight-bold text-primary" id="cand-vote-score-<?php echo $c->id; ?>"><?php echo $c->total_votes; ?></h4>
                          <span class="badge badge-light border font-weight-bold" id="cand-vote-perc-<?php echo $c->id; ?>"><?php echo $c->percentage; ?>%</span>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
          <!-- WebSocket Real-Time Stream Engine Card -->
          <div class="row">
            <div class="col-12">
              <div class="card shadow-sm border" style="border-left: 5px solid #6777ef !important;">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                  <h4 class="mb-0">
                    <i class="fas fa-satellite-dish mr-2 text-primary"></i> <?php echo __t('ws_stream_card_title', 'WebSocket Real-Time Stream Engine'); ?>
                  </h4>
                  <div>
                    <span class="badge badge-primary px-3 py-1 font-weight-bold mr-2">
                      <i class="fas fa-microchip mr-1"></i> <?php echo __t('ws_engine_badge', 'RFC 6455 Native Engine'); ?>
                    </span>
                    <span id="ws-panel-badge" class="badge badge-success px-3 py-1 font-weight-bold">
                      <i class="fas fa-bolt mr-1"></i> <span id="ws-panel-text"><?php echo __t('ws_connected', 'WebSocket: Live Push'); ?></span>
                    </span>
                  </div>
                </div>
                <div class="card-body py-3">
                  <div class="row align-items-center">
                    <div class="col-md-3 col-6 mb-2">
                      <small class="text-muted d-block text-uppercase font-weight-bold"><?php echo __t('ws_server_url', 'Server URL'); ?>:</small>
                      <code class="text-primary font-weight-bold" id="ws-panel-url">ws://localhost:8088</code>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                      <small class="text-muted d-block text-uppercase font-weight-bold"><?php echo __t('ws_mode', 'Broadcast Mode'); ?>:</small>
                      <strong class="text-dark"><i class="fas fa-sync-alt mr-1 text-success"></i> Real-Time Event Push</strong>
                    </div>
                    <div class="col-md-3 col-6 mb-2">
                      <small class="text-muted d-block text-uppercase font-weight-bold"><?php echo __t('ws_last_event', 'Last Broadcast Event'); ?>:</small>
                      <span class="font-weight-bold text-dark" id="ws-last-event-time"><?php echo date('H:i:s'); ?></span>
                    </div>
                    <div class="col-md-3 col-6 mb-2 text-md-right">
                      <small class="text-muted d-block text-uppercase font-weight-bold">Packets Received:</small>
                      <span class="badge badge-dark font-weight-bold px-3 py-1" id="ws-packet-counter" style="font-size: 13px;">0 packets</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Votes Table -->
          <div class="row">
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4><i class="fas fa-history mr-2 text-primary"></i> <?php echo __t('recent_votes_title', 'Latest Incoming Votes Log'); ?></h4>
                  <?php if ($this->session->userdata('role') === 'admin'): ?>
                    <a href="<?php echo base_url(); ?>voter" class="btn btn-sm btn-primary"><?php echo __t('menu_voters', 'Voters Registry (DPT)'); ?></a>
                  <?php endif; ?>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                      <thead>
                        <tr>
                          <th><?php echo __t('th_no', '#'); ?></th>
                          <th><?php echo __t('th_time', 'Vote Time'); ?></th>
                          <th><?php echo __t('th_voter_code', 'Voter Code'); ?></th>
                          <th><?php echo __t('th_voter_name', 'Voter Name'); ?></th>
                          <th><?php echo __t('th_dept', 'Class / Department'); ?></th>
                          <th><?php echo __t('th_candidate_choice', 'Candidate Choice'); ?></th>
                          <th><?php echo __t('th_status', 'Status'); ?></th>
                        </tr>
                      </thead>
                      <tbody id="recent-votes-tbody">
                        <?php if (!empty($recent_votes)): ?>
                          <?php $no = 1; foreach ($recent_votes as $rv): ?>
                            <tr data-vote-id="<?php echo $rv->id; ?>">
                              <td><?php echo $no++; ?></td>
                              <td><i class="far fa-clock text-muted mr-1"></i> <?php echo date('d M Y, H:i', strtotime($rv->voted_at)); ?></td>
                              <td><span class="badge badge-light border font-weight-bold"><?php echo $rv->voter_code; ?></span></td>
                              <td class="font-weight-bold text-dark"><?php echo $rv->voter_name; ?></td>
                              <td><?php echo $rv->class_or_dept; ?></td>
                              <td>
                                <span class="badge text-white font-weight-bold" style="background-color: <?php echo $rv->color ?: '#6777ef'; ?>;">
                                  <?php echo __t('candidate_pair', 'Pair'); ?> #<?php echo $rv->candidate_number; ?>: <?php echo $rv->chairman_name; ?>
                                </span>
                              </td>
                              <td><span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> <?php echo __t('verified', 'Verified'); ?></span></td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr id="empty-recent-row">
                            <td colspan="7" class="text-center text-muted py-4"><?php echo __t('no_recent_votes', 'No vote activity recorded yet.'); ?></td>
                          </tr>
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

<style>
@keyframes livePulse {
  0% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.8); }
  70% { transform: scale(1.1); box-shadow: 0 0 0 7px rgba(40, 167, 69, 0); }
  100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}
.live-pulse-dot {
  width: 9px;
  height: 9px;
  background-color: #28a745;
  border-radius: 50%;
  display: inline-block;
  margin-right: 6px;
  animation: livePulse 1.6s infinite;
}
.live-paused-dot {
  width: 9px;
  height: 9px;
  background-color: #ffc107;
  border-radius: 50%;
  display: inline-block;
  margin-right: 6px;
  animation: none !important;
}
.vote-row-new {
  animation: highlightNewRow 2s ease-out;
}
@keyframes highlightNewRow {
  0% { background-color: #d4edda !important; }
  100% { background-color: transparent !important; }
}
</style>

<!-- Page Script for Chart.js & Real-time Live Count Auto-Refresh -->
<script>
$(document).ready(function() {
  let voteChart = null;
  let isLiveActive = true;
  let pollInterval = 4000; // 4 seconds
  let pollTimer = null;
  let lastVoteId = <?php echo (!empty($recent_votes)) ? (int)$recent_votes[0]->id : 0; ?>;

  // Initialize Chart if element exists and there are votes
  function initChart(labels, data, colors) {
    var ctx = document.getElementById("voteChart");
    if (!ctx) return;

    voteChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: '<?php echo addslashes(__t("total_votes_label", "Total Votes")); ?>',
          data: data,
          backgroundColor: colors,
          borderWidth: 1,
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        animation: {
          duration: 600
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              stepSize: 1
            }
          }]
        }
      }
    });
  }

  <?php if ($total_voted > 0): ?>
    var initLabels = [
      <?php foreach ($candidates as $c): ?>
        "<?php echo addslashes(__t('candidate_pair', 'Pair')); ?> #<?php echo $c->candidate_number; ?> (<?php echo addslashes($c->chairman_name); ?>)",
      <?php endforeach; ?>
    ];
    var initVotes = [
      <?php foreach ($candidates as $c): ?>
        <?php echo $c->total_votes; ?>,
      <?php endforeach; ?>
    ];
    var initColors = [
      <?php foreach ($candidates as $c): ?>
        "<?php echo $c->color ?: '#6777ef'; ?>",
      <?php endforeach; ?>
    ];
    initChart(initLabels, initVotes, initColors);
  <?php endif; ?>

  // Function to update all DOM elements from Live Stats JSON
  function updateDashboardUI(res) {
    // 1. Update 4 Stat Cards
    $('#stat-total-voters').text(res.total_voters);
    $('#stat-total-voted').text(res.total_voted);
    $('#stat-total-unvoted').text(res.total_unvoted);
    $('#stat-participation-rate').text(res.participation_rate + '%');
    $('#badge-chart-voted').text(res.total_voted + ' ' + '<?php echo addslashes(__t("stat_voted", "Ballots Cast")); ?>');
    $('#last-update-time').text(res.server_time);

    // 2. Update or Build Chart
    var labels = [];
    var votes = [];
    var colors = [];

    res.candidates.forEach(function(c) {
      labels.push("<?php echo addslashes(__t('candidate_pair', 'Pair')); ?> #" + c.candidate_number + " (" + c.chairman_name + ")");
      votes.push(c.total_votes);
      colors.push(c.color);
    });

    if (res.total_voted_raw > 0) {
      if (!voteChart) {
        // If chart didn't exist before, replace empty state
        $('#chart-wrapper').html('<canvas id="voteChart" height="150"></canvas>');
        initChart(labels, votes, colors);
      } else {
        // Smoothly update existing chart
        voteChart.data.labels = labels;
        voteChart.data.datasets[0].data = votes;
        voteChart.update();
      }
    }

    // 3. Update Candidate Progress Bars & Quick Cards
    res.candidates.forEach(function(c) {
      // Progress Bar
      $('#progress-bar-' + c.id).css('width', c.percentage + '%').attr('aria-valuenow', c.percentage);
      $('#progress-text-' + c.id).text(c.total_votes + ' <?php echo addslashes(__t("votes", "votes")); ?> (' + c.percentage + '%)');

      // Quick Card
      $('#cand-vote-score-' + c.id).text(c.total_votes);
      $('#cand-vote-perc-' + c.id).text(c.percentage + '%');
    });

    // 4. Update Recent Votes Table
    if (res.recent_votes && res.recent_votes.length > 0) {
      var latestId = res.recent_votes[0].id;
      var hasNewVote = (latestId > lastVoteId);

      var rowsHtml = '';
      var no = 1;
      res.recent_votes.forEach(function(rv) {
        var isNewClass = (hasNewVote && rv.id > lastVoteId) ? 'vote-row-new' : '';
        rowsHtml += '<tr data-vote-id="' + rv.id + '" class="' + isNewClass + '">';
        rowsHtml += '<td>' + (no++) + '</td>';
        rowsHtml += '<td><i class="far fa-clock text-muted mr-1"></i> ' + rv.formatted_time + '</td>';
        rowsHtml += '<td><span class="badge badge-light border font-weight-bold">' + rv.voter_code + '</span></td>';
        rowsHtml += '<td class="font-weight-bold text-dark">' + rv.voter_name + '</td>';
        rowsHtml += '<td>' + rv.class_or_dept + '</td>';
        rowsHtml += '<td><span class="badge text-white font-weight-bold" style="background-color: ' + rv.color + ';"><?php echo addslashes(__t("candidate_pair", "Pair")); ?> #' + rv.candidate_number + ': ' + rv.chairman_name + '</span></td>';
        rowsHtml += '<td><span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> <?php echo addslashes(__t("verified", "Verified")); ?></span></td>';
        rowsHtml += '</tr>';
      });

      $('#recent-votes-tbody').html(rowsHtml);
      lastVoteId = latestId;
    }
  }

  // Polling AJAX call
  function fetchLiveStats(isManual) {
    if (isManual) {
      $('#btn-manual-refresh i').addClass('fa-spin');
    }

    $.ajax({
      url: '<?php echo base_url(); ?>dashboard/live_stats',
      type: 'GET',
      dataType: 'json',
      cache: false,
      success: function(res) {
        if (res && res.status === 'success') {
          updateDashboardUI(res);
        }
      },
      error: function() {
        console.warn('Live count polling failed.');
      },
      complete: function() {
        if (isManual) {
          setTimeout(function() {
            $('#btn-manual-refresh i').removeClass('fa-spin');
          }, 400);
        }
      }
    });
  }

  // Schedule auto-polling
  function startPolling() {
    stopPolling();
    pollTimer = setInterval(function() {
      if (isLiveActive) {
        fetchLiveStats(false);
      }
    }, pollInterval);
  }

  function stopPolling() {
    if (pollTimer) {
      clearInterval(pollTimer);
      pollTimer = null;
    }
  }

  // Start polling immediately
  startPolling();

  // Toggle Live Count Button
  $('#btn-toggle-live').on('click', function() {
    isLiveActive = !isLiveActive;
    if (isLiveActive) {
      $('#live-indicator-badge').removeClass('badge-warning').addClass('badge-success');
      $('#live-pulse').removeClass('live-paused-dot').addClass('live-pulse-dot');
      $('#live-status-text').text('<?php echo addslashes(__t("live_count_on", "LIVE COUNT ON")); ?>');
      $('#live-timer-text').show();
      $('#btn-toggle-icon').removeClass('fa-play').addClass('fa-pause');
      $('#btn-toggle-text').text('<?php echo addslashes(__t("btn_pause", "Pause")); ?>');
      fetchLiveStats(true);
    } else {
      $('#live-indicator-badge').removeClass('badge-success').addClass('badge-warning');
      $('#live-pulse').removeClass('live-pulse-dot').addClass('live-paused-dot');
      $('#live-status-text').text('<?php echo addslashes(__t("live_count_paused", "LIVE PAUSED")); ?>');
      $('#live-timer-text').hide();
      $('#btn-toggle-icon').removeClass('fa-pause').addClass('fa-play');
      $('#btn-toggle-text').text('<?php echo addslashes(__t("btn_resume", "Resume")); ?>');
    }
  });

  // Manual Refresh Button Click
  $('#btn-manual-refresh').on('click', function() {
    fetchLiveStats(true);
  });

  // =========================================================================
  // WEBSOCKET REAL-TIME CLIENT (RFC 6455)
  // =========================================================================
  var ws = null;
  var wsReconnectTimer = null;
  var wsPacketCount = 0;
  var wsHost = window.location.hostname || 'localhost';
  var wsUrl = 'ws://' + wsHost + ':8088';

  $('#ws-panel-url').text(wsUrl);

  function initDashboardWebSocket() {
    try {
      ws = new WebSocket(wsUrl);

      ws.onopen = function() {
        $('#ws-indicator-badge').removeClass('badge-light badge-info badge-danger').addClass('badge-success');
        $('#ws-indicator-text').text('<?php echo addslashes(__t("ws_connected", "WebSocket: Live Push")); ?>');
        $('#ws-panel-badge').removeClass('badge-secondary badge-info badge-danger').addClass('badge-success');
        $('#ws-panel-text').text('<?php echo addslashes(__t("ws_connected", "WebSocket: Live Push")); ?>');
      };

      ws.onmessage = function(event) {
        if (!isLiveActive) return;

        try {
          var data = JSON.parse(event.data);
          if (data && (data.type === 'live_stats' || data.candidates)) {
            wsPacketCount++;
            $('#ws-packet-counter').text(wsPacketCount + ' packets');
            var now = new Date();
            var timeStr = ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2) + ':' + ('0' + now.getSeconds()).slice(-2);
            $('#ws-last-event-time').text(timeStr);

            if (data.recent_votes) {
              data.recent_votes.forEach(function(rv) {
                if (!rv.formatted_time && rv.voted_at) {
                  rv.formatted_time = rv.voted_at;
                }
              });
            }

            updateDashboardUI(data);
          }
        } catch (err) {}
      };

      ws.onclose = function() {
        handleWsDisconnect();
      };

      ws.onerror = function() {
        handleWsDisconnect();
      };
    } catch (e) {
      handleWsDisconnect();
    }
  }

  function handleWsDisconnect() {
    $('#ws-indicator-badge').removeClass('badge-success badge-danger').addClass('badge-info');
    $('#ws-indicator-text').text('<?php echo addslashes(__t("ws_polling_fallback", "Polling Fallback (Active)")); ?>');
    $('#ws-panel-badge').removeClass('badge-success badge-danger').addClass('badge-info');
    $('#ws-panel-text').text('<?php echo addslashes(__t("ws_polling_fallback", "Polling Fallback (Active)")); ?>');

    if (!wsReconnectTimer) {
      wsReconnectTimer = setTimeout(function() {
        wsReconnectTimer = null;
        initDashboardWebSocket();
      }, 10000);
    }
  }

  // Initialize WebSocket connection
  initDashboardWebSocket();
});
</script>
