<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header', array('title' => $title));
?>
<style>
@keyframes pulse-ring {
  0% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(103, 119, 239, 0.7); }
  70% { transform: scale(1.04); box-shadow: 0 0 0 15px rgba(103, 119, 239, 0); }
  100% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(103, 119, 239, 0); }
}
@keyframes pulse-success {
  0% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(71, 195, 99, 0.7); }
  70% { transform: scale(1.06); box-shadow: 0 0 0 20px rgba(71, 195, 99, 0); }
  100% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(71, 195, 99, 0); }
}
.scanner-box {
  background: linear-gradient(145deg, #f8faff 0%, #edf2f9 100%);
  border: 2px dashed #6777ef;
  border-radius: 16px;
  padding: 30px 20px;
  text-align: center;
  position: relative;
  transition: all 0.3s ease;
  cursor: pointer;
}
.scanner-box:hover {
  background: #f0f4ff;
  border-color: #394eea;
}
.scanner-box.scanning {
  border-color: #47c363;
  background: #f4fff7;
}
.scanner-icon-circle {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  background: #ffffff;
  color: #6777ef;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 42px;
  box-shadow: 0 6px 18px rgba(103, 119, 239, 0.2);
  margin-bottom: 16px;
  animation: pulse-ring 2.5s infinite;
  transition: all 0.3s ease;
}
.scanner-box.scanning .scanner-icon-circle {
  background: #47c363;
  color: #ffffff;
  animation: pulse-success 1.5s infinite;
}
.nav-pills .nav-link.active {
  background-color: #6777ef;
  box-shadow: 0 2px 6px #acb5f6;
}
</style>

<body>
  <div id="app">
    <section class="section">
      <div class="container-fluid px-3 px-md-5 mt-4 mb-5" style="max-width: 1360px;">
        
        <!-- Top Header & Language Switcher -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap pb-2 border-bottom">
          <div class="login-brand text-left mb-2 mb-md-0">
            <h2 class="text-primary font-weight-bold mb-0">
              <i class="fas fa-vote-yea mr-2"></i> Simple E-Vote
            </h2>
            <p class="text-muted small mb-0"><?php echo __t('app_tagline', 'Modern E-Voting System with Tap ID Card (RFID/NFC) Feature'); ?></p>
          </div>
          <div class="dropdown">
            <a href="#" data-toggle="dropdown" class="badge badge-light border text-dark font-weight-bold dropdown-toggle py-2 px-3 shadow-sm">
              <i class="fas fa-globe mr-1"></i> <?php echo (current_lang() === 'id') ? 'Indonesia (ID)' : 'English (EN)'; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-sm">
              <a href="<?php echo base_url('lang/switch/en'); ?>" class="dropdown-item small <?php echo (current_lang() !== 'id') ? 'font-weight-bold text-primary' : ''; ?>">
                <span class="mr-2">🇬🇧</span> English <?php echo (current_lang() !== 'id') ? '✓' : ''; ?>
              </a>
              <a href="<?php echo base_url('lang/switch/id'); ?>" class="dropdown-item small <?php echo (current_lang() === 'id') ? 'font-weight-bold text-primary' : ''; ?>">
                <span class="mr-2">🇮🇩</span> Bahasa Indonesia <?php echo (current_lang() === 'id') ? '✓' : ''; ?>
              </a>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- Left Column: Login Card -->
          <div class="col-12 col-lg-7 col-xl-7 mb-4">

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

            <?php if (validation_errors()): ?>
              <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                  <button class="close" data-dismiss="alert"><span>&times;</span></button>
                  <?php echo validation_errors('<div><i class="fas fa-exclamation-circle mr-1"></i> ', '</div>'); ?>
                </div>
              </div>
            <?php endif; ?>

            <div class="card card-primary shadow-sm">
              <div class="card-header p-2">
                <ul class="nav nav-pills nav-fill w-100" id="loginTabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active font-weight-bold py-2" id="rfid-tab" data-toggle="tab" href="#tab-rfid" role="tab" aria-selected="true">
                      <i class="fas fa-id-card mr-1"></i> <?php echo __t('tab_tap_card', 'Tap ID Card / RFID'); ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link font-weight-bold py-2" id="password-tab" data-toggle="tab" href="#tab-password" role="tab" aria-selected="false">
                      <i class="fas fa-key mr-1"></i> <?php echo __t('tab_password', 'Username & Password'); ?>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="card-body">
                <div class="tab-content" id="loginTabContent">
                  
                  <!-- ============================================== -->
                  <!-- TAB 1: TAP ID CARD / RFID SCANNER (BYPASS)     -->
                  <!-- ============================================== -->
                  <div class="tab-pane fade show active" id="tab-rfid" role="tabpanel" aria-labelledby="rfid-tab">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <span class="badge badge-success px-3 py-1 font-weight-bold">
                        <i class="fas fa-circle text-white mr-1" style="font-size: 8px;"></i> <?php echo __t('scanner_ready', 'Reader Ready to Detect'); ?>
                      </span>
                      <small class="text-muted"><i class="fas fa-keyboard mr-1"></i> Keyboard Wedge / NFC Active</small>
                    </div>

                    <!-- Scanner Interactive Box -->
                    <div class="scanner-box" id="scannerZone" onclick="$('#rfidInput').focus()">
                      <div class="scanner-icon-circle" id="scannerIcon">
                        <i class="fas fa-id-card"></i>
                      </div>
                      <h5 class="text-dark font-weight-bold mb-1" id="scannerStatusTitle"><?php echo __t('scanner_status_ready', 'Tap your ID Card on the Scanner'); ?></h5>
                      <p class="text-muted small mb-3" id="scannerStatusDesc">
                        <?php echo __t('scanner_desc', 'Place your RFID / NFC card on the card reader or use your mobile device NFC sensor.'); ?>
                      </p>

                      <!-- Input Field for Scanner (Supports auto-entry from USB RFID reader) -->
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white border-primary"><i class="fas fa-barcode text-primary"></i></span>
                        </div>
                        <input type="text" id="rfidInput" class="form-control form-control-lg text-center font-weight-bold border-primary" 
                               placeholder="<?php echo __t('tap_card_placeholder', 'Tap card or enter Card UID here...'); ?>" 
                               autocomplete="off" autofocus>
                        <div class="input-group-append">
                          <button class="btn btn-primary font-weight-bold px-3" type="button" onclick="submitManualTap()">
                            <i class="fas fa-arrow-right"></i> <?php echo __t('btn_enter', 'Enter'); ?>
                          </button>
                        </div>
                      </div>

                      <div id="scanFeedback" class="small text-muted mt-2">
                        <i class="fas fa-info-circle mr-1"></i> <?php echo __t('scanner_auto_detect_note', 'Reader automatically detects when card is tapped (10-Digit UID / Hex Mifare).'); ?>
                      </div>
                    </div>

                    <!-- Web NFC Reader Button (for Android Chrome / Web NFC supported devices) -->
                    <div class="mt-3 text-center" id="nfcSupportSection" style="display: none;">
                      <button type="button" class="btn btn-outline-info btn-block btn-sm py-2 font-weight-bold" id="btnStartWebNfc">
                        <i class="fas fa-broadcast-tower mr-1"></i> <?php echo __t('enable_phone_nfc', 'Enable Native Phone NFC Scan (Web NFC)'); ?>
                      </button>
                    </div>

                    <!-- Demo Card Tapping Simulation -->
                    <div class="mt-4 pt-3 border-top">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="font-weight-bold text-muted small text-uppercase">
                          <i class="fas fa-magic mr-1"></i> <?php echo __t('simulation_title', 'Demo Card Tap Simulation:'); ?>
                        </span>
                        <span class="badge badge-light border"><?php echo __t('one_click_tap', '1-Click Tap'); ?></span>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 mb-2">
                          <button type="button" class="btn btn-outline-primary btn-sm btn-block text-left p-2 shadow-none" 
                                  onclick="simulateTap('0001002009', 'Irfan Hakim')">
                            <div class="font-weight-bold text-primary"><i class="fas fa-id-badge mr-1"></i> <?php echo __t('card_voter', 'Voter Card:'); ?> Irfan Hakim</div>
                            <small class="text-muted">UID: <code>0001002009</code> (<?php echo __t('status_not_voted', 'Not Voted'); ?>)</small>
                          </button>
                        </div>
                        <div class="col-md-6 mb-2">
                          <button type="button" class="btn btn-outline-success btn-sm btn-block text-left p-2 shadow-none" 
                                  onclick="simulateTap('0001002010', 'Jessica Tan')">
                            <div class="font-weight-bold text-success"><i class="fas fa-id-badge mr-1"></i> <?php echo __t('card_voter', 'Voter Card:'); ?> Jessica Tan</div>
                            <small class="text-muted">UID: <code>0001002010</code> (<?php echo __t('status_not_voted', 'Not Voted'); ?>)</small>
                          </button>
                        </div>
                        <div class="col-md-6 mb-2">
                          <button type="button" class="btn btn-outline-warning btn-sm btn-block text-left p-2 shadow-none" 
                                  onclick="simulateTap('0000000001', 'Admin E-Vote')">
                            <div class="font-weight-bold text-dark"><i class="fas fa-shield-alt mr-1"></i> <?php echo __t('card_admin', 'Admin Card:'); ?> Administrator</div>
                            <small class="text-muted">UID: <code>0000000001</code> (Full CRUD)</small>
                          </button>
                        </div>
                        <div class="col-md-6 mb-2">
                          <button type="button" class="btn btn-outline-danger btn-sm btn-block text-left p-2 shadow-none" 
                                  onclick="simulateTap('9999999999', 'Kartu Tidak Terdaftar')">
                            <div class="font-weight-bold text-danger"><i class="fas fa-times-circle mr-1"></i> <?php echo __t('card_unregistered', 'Unregistered Card'); ?></div>
                            <small class="text-muted">UID: <code>9999999999</code> (<?php echo __t('testing_error', 'Testing Error'); ?>)</small>
                          </button>
                        </div>
                      </div>
                    </div>


                  </div>

                  <!-- ============================================== -->
                  <!-- TAB 2: MANUAL LOGIN (USERNAME & PASSWORD)      -->
                  <!-- ============================================== -->
                  <div class="tab-pane fade" id="tab-password" role="tabpanel" aria-labelledby="password-tab">
                    
                    <?php echo form_open('auth/authenticate', array('class' => 'needs-validation')); ?>
                      <div class="form-group">
                        <label for="username"><?php echo __t('username', 'Username / Voter Code'); ?> <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                          </div>
                          <input id="username" type="text" class="form-control" name="username" placeholder="<?php echo __t('username', 'Enter admin username or voter code'); ?>" value="<?php echo set_value('username'); ?>" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="password" class="control-label"><?php echo __t('password', 'Password'); ?> <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                          </div>
                          <input id="password" type="password" class="form-control" name="password" placeholder="<?php echo __t('password', 'Enter password'); ?>" required>
                        </div>
                      </div>

                      <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block font-weight-bold shadow-sm">
                          <i class="fas fa-sign-in-alt mr-1"></i> <?php echo __t('btn_login', 'Sign In Now'); ?>
                        </button>
                      </div>
                    <?php echo form_close(); ?>

                    <!-- Demo Account Helpers -->
                    <div class="mt-4 pt-3 border-top">
                      <h6 class="font-weight-bold text-muted small text-uppercase mb-2">
                        <i class="fas fa-key mr-1"></i> <?php echo __t('demo_account_title', 'Demo Password Accounts:'); ?>
                      </h6>
                      <div class="row">
                        <div class="col-md-6 mb-2">
                          <button type="button" class="btn btn-outline-primary btn-sm btn-block text-left py-2" onclick="fillCreds('admin', 'admin123')">
                            <div class="font-weight-bold"><i class="fas fa-user-shield mr-1"></i> <?php echo __t('admin', 'Admin'); ?></div>
                            <small class="text-muted">User: <code>admin</code> | Pass: <code>admin123</code></small>
                          </button>
                          <a href="<?php echo base_url('docs'); ?>" target="_blank" class="badge badge-light border text-primary mt-1 d-inline-block font-weight-bold py-1 px-2" title="<?php echo __t('admin_docs_link', 'System Documentation (Admin)'); ?>">
                            <i class="fas fa-book-open mr-1"></i> <?php echo __t('menu_docs', 'System Documentation'); ?> (Admin) &rarr;
                          </a>
                        </div>
                        <div class="col-md-6 mb-2">
                          <button type="button" class="btn btn-outline-success btn-sm btn-block text-left py-2" onclick="fillCreds('VTR-2026-009', 'voter123')">
                            <div class="font-weight-bold"><i class="fas fa-user-check mr-1"></i> <?php echo __t('voter', 'Voter'); ?></div>
                            <small class="text-muted">User: <code>VTR-2026-009</code> | Pass: <code>voter123</code></small>
                          </button>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>
              </div>
            </div> <!-- End Left Column Card -->
          </div> <!-- End col-lg-7 Left Column -->

          <!-- Right Column: Real-time Live Vote Percentage Preview Card -->
          <div class="col-12 col-lg-5 col-xl-5 mb-4">
            <div class="card card-primary shadow-sm h-100">
              <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 font-weight-bold text-dark">
                  <i class="fas fa-chart-pie mr-2 text-primary"></i> <?php echo __t('live_preview_title', 'Live Vote Standings & Percentage'); ?>
                </h5>
                <span id="preview-ws-badge" class="badge badge-success px-2 py-1 shadow-sm" style="font-size: 11px;">
                  <i class="fas fa-bolt mr-1"></i> <span id="preview-ws-text"><?php echo __t('ws_connected', 'WebSocket: Live Push'); ?></span>
                </span>
              </div>
              <div class="card-body p-3">
                <!-- Turnout Summary Box -->
                <div class="p-3 bg-light rounded border mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="font-weight-bold text-muted small text-uppercase">
                      <i class="fas fa-users mr-1 text-primary"></i> <?php echo __t('turnout_rate', 'Voter Turnout Rate'); ?>
                    </span>
                    <span class="badge badge-primary font-weight-bold px-2 py-1" id="preview-turnout-rate" style="font-size: 13px;">
                      <?php echo isset($participation_rate) ? $participation_rate : 0; ?>%
                    </span>
                  </div>
                  <div class="progress" style="height: 10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="preview-turnout-bar" role="progressbar" style="width: <?php echo isset($participation_rate) ? $participation_rate : 0; ?>%;"></div>
                  </div>
                  <div class="d-flex justify-content-between text-muted small mt-2">
                    <span><?php echo __t('total_ballots_cast', 'Ballots Cast'); ?>: <strong class="text-dark" id="preview-voted-count"><?php echo isset($total_voted) ? number_format($total_voted) : 0; ?></strong></span>
                    <span><?php echo __t('registered_in_dpt', 'Total DPT'); ?>: <strong class="text-dark" id="preview-voters-count"><?php echo isset($total_voters) ? number_format($total_voters) : 0; ?></strong></span>
                  </div>
                </div>

                <!-- Candidates List -->
                <h6 class="font-weight-bold text-muted small text-uppercase mb-2">
                  <i class="fas fa-trophy mr-1 text-warning"></i> <?php echo __t('candidate_registry', 'Candidate Pairs'); ?>:
                </h6>
                <div id="preview-candidate-container">
                  <?php if (!empty($candidates)): ?>
                    <?php foreach ($candidates as $c): ?>
                      <?php 
                        $photo_file = !empty($c->photo) ? $c->photo : 'candidate-1.png';
                        $photo_src = base_url() . 'assets/uploads/candidates/' . $photo_file;
                        $theme_col = $c->color ?: '#6777ef';
                      ?>
                      <div class="card mb-2 border shadow-sm" id="preview-cand-card-<?php echo $c->id; ?>" style="border-left: 4px solid <?php echo $theme_col; ?> !important;">
                        <div class="card-body p-2 d-flex align-items-center">
                          <div class="mr-2 position-relative">
                            <img src="<?php echo $photo_src; ?>" class="rounded-circle border" width="46" height="46" style="object-fit: cover;">
                            <span class="badge badge-pill text-white position-absolute" style="background-color: <?php echo $theme_col; ?>; bottom: -4px; right: -4px; font-size: 10px; padding: 2px 5px;">
                              #0<?php echo $c->candidate_number; ?>
                            </span>
                          </div>
                          <div class="flex-grow-1 ml-1" style="min-width: 0;">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="font-weight-bold text-dark text-truncate" style="max-width: 170px;" title="<?php echo htmlspecialchars($c->chairman_name . ' & ' . $c->vice_chairman_name); ?>">
                                <?php echo $c->chairman_name; ?> &amp; <?php echo $c->vice_chairman_name; ?>
                              </div>
                              <div class="text-right">
                                <span class="font-weight-bold" id="preview-cand-pct-<?php echo $c->id; ?>" style="color: <?php echo $theme_col; ?>; font-size: 15px;">
                                  <?php echo $c->percentage; ?>%
                                </span>
                              </div>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mb-1">
                              <span><?php echo __t('candidate_pair', 'Candidate Pair'); ?> 0<?php echo $c->candidate_number; ?></span>
                              <span id="preview-cand-votes-<?php echo $c->id; ?>"><?php echo number_format($c->total_votes); ?> <?php echo __t('votes', 'votes'); ?></span>
                            </div>
                            <div class="progress" style="height: 6px;">
                              <div class="progress-bar" id="preview-cand-bar-<?php echo $c->id; ?>" style="width: <?php echo $c->percentage; ?>%; background-color: <?php echo $theme_col; ?>;"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="text-center py-3 text-muted small">
                      <?php echo __t('no_candidates_yet', 'No candidate data available'); ?>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Live indicator footer -->
                <div class="mt-3 pt-2 border-top text-center">
                  <div class="text-muted small mb-2">
                    <i class="far fa-clock mr-1"></i> <?php echo __t('last_updated', 'Last Updated'); ?>: <strong id="preview-last-updated"><?php echo date('H:i:s'); ?></strong>
                  </div>
                  <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-primary btn-sm btn-block font-weight-bold">
                    <i class="fas fa-chart-bar mr-1"></i> <?php echo __t('view_full_dashboard', 'Open Full Live Count Dashboard'); ?> &rarr;
                  </a>
                </div>
              </div>
            </div>
          </div> <!-- End Right Column -->
        </div>

        <div class="simple-footer text-center text-muted mt-3">
          <strong>Simple E-Vote</strong> &bull; <?php echo __t('app_tagline', 'Modern E-Voting System with Tap ID Card (RFID/NFC) Feature'); ?>
          <div class="mt-1">
            <a href="<?php echo base_url('docs'); ?>" target="_blank" class="small text-primary"><i class="fas fa-book mr-1"></i> <?php echo __t('menu_docs', 'System Documentation'); ?></a>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('dist/_partials/js'); ?>

<script>
// =========================================================================
// 1. WEB AUDIO API - HARDWARE RFID SCANNER BEEP EMULATION
// =========================================================================
function playBeep(type) {
  try {
    var AudioCtx = window.AudioContext || window.webkitAudioContext;
    if (!AudioCtx) return;
    var ctx = new AudioCtx();

    if (type === 'success') {
      // Pleasant double chime: C6 (1046Hz) then E6 (1318Hz)
      var osc1 = ctx.createOscillator();
      var gain1 = ctx.createGain();
      osc1.type = 'sine';
      osc1.frequency.setValueAtTime(1046.50, ctx.currentTime);
      gain1.gain.setValueAtTime(0.2, ctx.currentTime);
      gain1.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.12);
      osc1.connect(gain1);
      gain1.connect(ctx.destination);
      osc1.start(ctx.currentTime);
      osc1.stop(ctx.currentTime + 0.12);

      var osc2 = ctx.createOscillator();
      var gain2 = ctx.createGain();
      osc2.type = 'sine';
      osc2.frequency.setValueAtTime(1318.51, ctx.currentTime + 0.10);
      gain2.gain.setValueAtTime(0.2, ctx.currentTime + 0.10);
      gain2.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.25);
      osc2.connect(gain2);
      gain2.connect(ctx.destination);
      osc2.start(ctx.currentTime + 0.10);
      osc2.stop(ctx.currentTime + 0.25);
    } else {
      // Error buzz: 200Hz sawtooth
      var osc = ctx.createOscillator();
      var gain = ctx.createGain();
      osc.type = 'sawtooth';
      osc.frequency.setValueAtTime(200, ctx.currentTime);
      gain.gain.setValueAtTime(0.3, ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.35);
      osc.connect(gain);
      gain.connect(ctx.destination);
      osc.start(ctx.currentTime);
      osc.stop(ctx.currentTime + 0.35);
    }
  } catch (e) {
    // Audio playback blocked or not supported
  }
}

// =========================================================================
// 2. HEXTODES CONVERTER (Little Endian to 10-digit decimal ala absensi_gebyar)
// =========================================================================
function hextodes(hexStr) {
  var clean = hexStr.replace(/[^0-9a-fA-F]/g, '');
  if (clean.length === 8) {
    // Little-endian byte reverse: [6..7] + [4..5] + [2..3] + [0..1]
    var rev = clean.substring(6, 8) + clean.substring(4, 6) + clean.substring(2, 4) + clean.substring(0, 2);
    var dec = parseInt(rev, 16);
    if (!isNaN(dec)) {
      var decStr = dec.toString();
      while (decStr.length < 10) {
        decStr = '0' + decStr;
      }
      return decStr;
    }
  }
  return hexStr;
}

// =========================================================================
// 3. SUBMIT CARD TAP FUNCTION
// =========================================================================
var isProcessingTap = false;

function submitCardTap(cardUid) {
  cardUid = $.trim(cardUid);
  if (!cardUid || isProcessingTap) return;

  isProcessingTap = true;

  // Visual feedback on scanner box
  $('#scannerZone').addClass('scanning');
  $('#scannerIcon').html('<i class="fas fa-spinner fa-spin"></i>');
  $('#scannerStatusTitle').text('<?php echo addslashes(__t("verifying_card", "Verifying Card...")); ?>');
  $('#scannerStatusDesc').html('UID: <strong class="text-primary font-monospace">' + cardUid + '</strong>');
  $('#rfidInput').prop('disabled', true);

  $.ajax({
    url: '<?php echo base_url("auth/tap_card"); ?>',
    type: 'POST',
    dataType: 'json',
    data: { card_uid: cardUid },
    success: function(res) {
      if (res.status === 'success') {
        playBeep('success');
        $('#scannerIcon').html('<i class="fas fa-check"></i>');
        $('#scannerStatusTitle').html('<span class="text-success"><i class="fas fa-check-circle mr-1"></i> <?php echo addslashes(__t("card_verified", "Card Verified!")); ?></span>');
        $('#scannerStatusDesc').html('<strong>' + res.name + '</strong><br><span class="text-muted small"><?php echo addslashes(__t("redirecting", "Redirecting to destination page...")); ?></span>');

        if (typeof iziToast !== 'undefined') {
          iziToast.success({
            title: '<?php echo addslashes(__t("success", "Success!")); ?>',
            message: res.message,
            position: 'topCenter',
            timeout: 2000
          });
        }

        setTimeout(function() {
          window.location.href = res.redirect;
        }, 800);
      } else {
        playBeep('error');
        resetScannerUI(res.message);
      }
    },
    error: function() {
      playBeep('error');
      resetScannerUI('<?php echo addslashes(__t("connection_error", "Server connection error. Please try again!")); ?>');
    }
  });
}

function resetScannerUI(errorMessage) {
  isProcessingTap = false;
  $('#scannerZone').removeClass('scanning');
  $('#scannerIcon').html('<i class="fas fa-id-card"></i>');
  $('#scannerStatusTitle').text('<?php echo addslashes(__t("scanner_status_ready", "Tap your ID Card on the Scanner")); ?>');
  $('#scannerStatusDesc').text('<?php echo addslashes(__t("reader_instruction_box", "Hold voter card near USB reader / NFC sensor to enter Voting Booth directly without password.")); ?>');
  $('#rfidInput').prop('disabled', false).val('').focus();

  if (errorMessage) {
    if (typeof swal !== 'undefined') {
      swal({
        title: '<?php echo addslashes(__t("access_denied", "Access Denied!")); ?>',
        text: errorMessage,
        icon: 'error',
        button: '<?php echo addslashes(__t("close", "Close")); ?>'
      }).then(function() {
        $('#rfidInput').focus();
      });
    } else {
      alert(errorMessage);
      $('#rfidInput').focus();
    }
  }
}

function submitManualTap() {
  var val = $('#rfidInput').val();
  if (!val) {
    $('#rfidInput').focus();
    return;
  }
  submitCardTap(val);
}

function simulateTap(cardUid, name) {
  $('#rfidInput').val(cardUid);
  submitCardTap(cardUid);
}

function fillCreds(u, p) {
  $('#username').val(u);
  $('#password').val(p);
  $('#username').focus();
}

// =========================================================================
// 4. GLOBAL KEYBOARD WEDGE SCANNER LISTENER (USB RFID / Barcode Readers)
// =========================================================================
$(document).ready(function() {
  $('#rfidInput').focus();

  // Handle enter key on #rfidInput
  $('#rfidInput').on('keydown', function(e) {
    if (e.which === 13) {
      e.preventDefault();
      submitManualTap();
    }
  });

  // Global listener for hardware USB RFID reader (emulates rapid keystrokes + Enter)
  var scanBuffer = '';
  var lastKeyTime = 0;

  $(document).on('keypress', function(e) {
    // If typing in normal password tab and input is focused, don't hijack unless fast scan
    var activeInput = document.activeElement;
    var isInsidePasswordForm = (activeInput && (activeInput.id === 'username' || activeInput.id === 'password'));

    var now = new Date().getTime();
    var diff = now - lastKeyTime;
    lastKeyTime = now;

    if (e.which === 13) { // Enter key sent by RFID reader at the end
      if (scanBuffer.length >= 4) {
        e.preventDefault();
        var capturedUid = scanBuffer;
        scanBuffer = '';
        $('#rfid-tab').tab('show');
        $('#rfidInput').val(capturedUid);
        submitCardTap(capturedUid);
        return;
      }
      scanBuffer = '';
      return;
    }

    var char = String.fromCharCode(e.which);

    // If characters arrive rapidly (< 80ms interval), it's a hardware scanner
    if (diff > 80 && !isInsidePasswordForm) {
      scanBuffer = '';
    }

    if (!isInsidePasswordForm || diff <= 80) {
      scanBuffer += char;
    }
  });

  // Keep focus on rfidInput when switching to rfid tab
  $('#rfid-tab').on('shown.bs.tab', function() {
    $('#rfidInput').focus();
  });

  // =========================================================================
  // 5. WEB NFC API INTEGRATION (For Chrome on Android & NFC-supported devices)
  // =========================================================================
  if ('NDEFReader' in window) {
    $('#nfcSupportSection').show();
    $('#btnStartWebNfc').on('click', async function() {
      try {
        const ndef = new NDEFReader();
        await ndef.scan();
        $('#scannerStatusTitle').text('NFC Reader Aktif! Tempelkan HP ke Kartu...');
        $('#scannerStatusDesc').text('Tempelkan kartu ID di bagian belakang ponsel Anda.');
        $('#scannerZone').addClass('scanning');

        ndef.onreading = event => {
          var serial = event.serialNumber;
          // Apply hextodes conversion if 4-byte NFC UID
          var convertedUid = hextodes(serial);
          $('#rfidInput').val(convertedUid);
          submitCardTap(convertedUid);
        };

        ndef.onreadingerror = () => {
          playBeep('error');
          alert('Gagal membaca kartu NFC. Pastikan kartu didekatkan dengan stabil.');
        };

      } catch (error) {
        console.warn('NFC scan failed:', error);
        alert('NFC is not available or permission denied.');
      }
    });
  }

  // =========================================================================
  // 6. REAL-TIME WEBSOCKET & POLLING PREVIEW ENGINE
  // =========================================================================
  var wsPreview = null;
  var wsPreviewReconnectTimer = null;
  var fallbackPollInterval = null;

  function initPreviewWebSocket() {
    var wsHost = window.location.hostname || 'localhost';
    var wsUrl = 'ws://' + wsHost + ':8088';

    try {
      wsPreview = new WebSocket(wsUrl);

      wsPreview.onopen = function() {
        $('#preview-ws-badge').removeClass('badge-light badge-info badge-danger').addClass('badge-success');
        $('#preview-ws-text').html('<?php echo addslashes(__t("ws_connected", "WebSocket: Live Push")); ?>');
        if (fallbackPollInterval) {
          clearInterval(fallbackPollInterval);
          fallbackPollInterval = null;
        }
      };

      wsPreview.onmessage = function(event) {
        try {
          var data = JSON.parse(event.data);
          if (data && (data.type === 'live_stats' || data.candidates)) {
            updateLivePreviewUI(data);
          }
        } catch (err) {}
      };

      wsPreview.onclose = function() {
        handlePreviewWsFallback();
      };

      wsPreview.onerror = function() {
        handlePreviewWsFallback();
      };
    } catch (e) {
      handlePreviewWsFallback();
    }
  }

  function handlePreviewWsFallback() {
    $('#preview-ws-badge').removeClass('badge-success badge-danger').addClass('badge-info');
    $('#preview-ws-text').html('<?php echo addslashes(__t("ws_polling_fallback", "Polling Fallback")); ?>');

    if (!fallbackPollInterval) {
      fallbackPollInterval = setInterval(fetchPreviewStatsAjax, 4000);
    }

    if (!wsPreviewReconnectTimer) {
      wsPreviewReconnectTimer = setTimeout(function() {
        wsPreviewReconnectTimer = null;
        initPreviewWebSocket();
      }, 10000);
    }
  }

  function fetchPreviewStatsAjax() {
    $.ajax({
      url: '<?php echo base_url("auth/live_stats"); ?>',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        if (data && data.status === 'success') {
          updateLivePreviewUI(data);
        }
      }
    });
  }

  function updateLivePreviewUI(data) {
    if (data.participation_rate !== undefined) {
      $('#preview-turnout-rate').text(data.participation_rate + '%');
      $('#preview-turnout-bar').css('width', data.participation_rate + '%');
    }
    if (data.total_voted !== undefined) {
      $('#preview-voted-count').text(Number(data.total_voted).toLocaleString());
    }
    if (data.total_voters !== undefined) {
      $('#preview-voters-count').text(Number(data.total_voters).toLocaleString());
    }

    if (data.candidates && data.candidates.length) {
      data.candidates.forEach(function(c) {
        var pctEl = $('#preview-cand-pct-' + c.id);
        var barEl = $('#preview-cand-bar-' + c.id);
        var votesEl = $('#preview-cand-votes-' + c.id);

        if (pctEl.length) pctEl.text(c.percentage + '%');
        if (barEl.length) barEl.css('width', c.percentage + '%');
        if (votesEl.length) votesEl.text(Number(c.total_votes).toLocaleString() + ' <?php echo addslashes(__t("votes", "votes")); ?>');
      });
    }

    var now = new Date();
    var timeStr = ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2) + ':' + ('0' + now.getSeconds()).slice(-2);
    $('#preview-last-updated').text(timeStr);
  }

  // Start WebSocket client for preview card
  initPreviewWebSocket();
});
</script>
</body>
</html>
