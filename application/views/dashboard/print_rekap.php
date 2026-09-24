<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $title; ?> | Simple E-Vote</title>
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css">
  
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #212529;
    }
    .print-container {
      max-width: 900px;
      margin: 30px auto;
      background: #fff;
      padding: 40px 50px;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .kop-surat {
      border-bottom: 3px double #1a1a1a;
      padding-bottom: 18px;
      margin-bottom: 25px;
    }
    .kop-logo {
      width: 75px;
      height: 75px;
      object-fit: contain;
    }
    .badge-winner {
      background-color: #28a745;
      color: #fff;
      font-size: 11px;
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: bold;
    }
    .table-rekap th {
      background-color: #f1f3f5 !important;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 12px;
      letter-spacing: 0.5px;
    }
    .ttd-box {
      margin-top: 40px;
    }
    .ttd-line {
      border-bottom: 1px solid #333;
      width: 80%;
      margin: 65px auto 5px auto;
    }
    @media print {
      body {
        background-color: #fff !important;
      }
      .no-print {
        display: none !important;
      }
      .print-container {
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        max-width: 100% !important;
        border-radius: 0 !important;
      }
      .table-rekap th {
        background-color: #eaeaea !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      .badge-winner {
        border: 1px solid #28a745;
        color: #28a745 !important;
        background: transparent !important;
      }
      @page {
        size: A4 portrait;
        margin: 15mm;
      }
    }
  </style>
</head>
<body>

  <!-- Floating Print Controls (Hidden on Print) -->
  <div class="container my-3 no-print">
    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm border">
      <div>
        <a href="<?php echo base_url(); ?>dashboard" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left mr-1"></i> <?php echo __t('back_to_dashboard', 'Back to Dashboard'); ?>
        </a>
      </div>
      <div class="text-muted small">
        <i class="fas fa-info-circle mr-1 text-primary"></i> <?php echo __t('print_pdf_hint', 'You can print directly or save as a PDF document.'); ?>
      </div>
      <div>
        <button onclick="window.print()" class="btn btn-primary font-weight-bold shadow-sm px-4">
          <i class="fas fa-print mr-1"></i> <?php echo __t('print_save_pdf', 'Print / Save PDF'); ?>
        </button>
      </div>
    </div>
  </div>

  <div class="print-container">
    
    <!-- KOP RESMI -->
    <div class="kop-surat">
      <div class="row align-items-center">
        <div class="col-2 text-center">
          <div style="width: 70px; height: 70px; border-radius: 50%; background: #6777ef; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 32px;">
            <i class="fas fa-vote-yea"></i>
          </div>
        </div>
        <div class="col-10 text-center">
          <h5 class="mb-0 font-weight-bold text-uppercase" style="letter-spacing: 1px;"><?php echo __t('committee_title', 'ELECTRONIC VOTING COMMITTEE (E-VOTING)'); ?></h5>
          <h4 class="mb-1 font-weight-bold text-uppercase text-primary" style="letter-spacing: 1.5px;"><?php echo __t('kpu_title', 'GENERAL ELECTIONS COMMISSION (KPU)'); ?></h4>
          <p class="mb-0 small text-muted"><?php echo __t('system_tagline_doc', 'Integrated Digital Election Administration System with Real Count & RFID Card Support'); ?></p>
        </div>
      </div>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="text-center mb-4">
      <h5 class="font-weight-bold mb-1 text-uppercase" style="text-decoration: underline;"><?php echo __t('minutes_doc_title', 'OFFICIAL MINUTES OF ELECTION VOTE RECAPITULATION'); ?></h5>
      <div class="font-weight-bold text-muted small"><?php echo __t('number_label', 'Number'); ?>: <?php echo $doc_number; ?></div>
    </div>

    <p class="text-justify" style="line-height: 1.6;">
      <?php echo sprintf(__t('minutes_intro_text', 'On this day, %s, recapitulation of electronic vote tally data (Real Count E-Voting) for the General Election was officially executed with the following detailed records:'), '<strong>' . $print_date . '</strong>'); ?>
    </p>

    <!-- BAGIAN 1: STATISTIK PARTISIPASI -->
    <div class="mb-4">
      <h6 class="font-weight-bold text-dark border-bottom pb-1 mb-2">
        <i class="fas fa-chart-pie text-primary mr-1"></i> I. <?php echo __t('dpt_participation_data', 'VOTER PARTICIPATION DATA (DPT)'); ?>
      </h6>
      <table class="table table-bordered table-sm table-rekap mb-0">
        <thead>
          <tr>
            <th width="8%" class="text-center"><?php echo __t('no', 'No'); ?></th>
            <th><?php echo __t('participation_description', 'Voter Participation Breakdown'); ?></th>
            <th width="20%" class="text-center"><?php echo __t('count_label', 'Count'); ?></th>
            <th width="20%" class="text-center"><?php echo __t('percentage', 'Percentage'); ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center font-weight-bold">1</td>
            <td><?php echo __t('total_registered_dpt', 'Total Registered Voters (DPT)'); ?></td>
            <td class="text-center font-weight-bold"><?php echo number_format($total_voters); ?> <?php echo __t('people_unit', 'People'); ?></td>
            <td class="text-center">100%</td>
          </tr>
          <tr>
            <td class="text-center font-weight-bold">2</td>
            <td><?php echo __t('valid_votes_received', 'Valid Votes Received / Voters Who Cast Ballots'); ?></td>
            <td class="text-center font-weight-bold text-success"><?php echo number_format($total_voted); ?> <?php echo __t('votes', 'Votes'); ?></td>
            <td class="text-center font-weight-bold text-success"><?php echo $participation_rate; ?>%</td>
          </tr>
          <tr>
            <td class="text-center font-weight-bold">3</td>
            <td><?php echo __t('unvoted_voters_label', 'Voters Not Voted / Abstentions'); ?></td>
            <td class="text-center font-weight-bold text-danger"><?php echo number_format($total_unvoted); ?> <?php echo __t('people_unit', 'People'); ?></td>
            <td class="text-center font-weight-bold text-danger"><?php echo round(100 - $participation_rate, 1); ?>%</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- BAGIAN 2: PEROLEHAN SUARA KANDIDAT -->
    <div class="mb-4">
      <h6 class="font-weight-bold text-dark border-bottom pb-1 mb-2">
        <i class="fas fa-users text-primary mr-1"></i> II. <?php echo __t('candidates_vote_tally', 'CANDIDATE PAIRS VOTE TALLY RESULTS'); ?>
      </h6>
      <table class="table table-bordered table-sm table-rekap mb-0">
        <thead>
          <tr>
            <th width="8%" class="text-center"><?php echo __t('ballot_no', 'Ballot No.'); ?></th>
            <th><?php echo __t('candidate_pair_header', 'Candidate Pairs (Chairman & Vice)'); ?></th>
            <th width="20%" class="text-center"><?php echo __t('votes_acquired', 'Votes Acquired'); ?></th>
            <th width="15%" class="text-center"><?php echo __t('percentage', 'Percentage'); ?></th>
            <th width="20%" class="text-center"><?php echo __t('rank_and_status', 'Rank & Status'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($candidates)): ?>
            <?php 
              $rank_map = array();
              $curr_rank = 1;
              foreach ($ranked_candidates as $rc) {
                $rank_map[$rc->id] = $curr_rank++;
              }
            ?>
            <?php foreach ($candidates as $c): ?>
              <?php 
                $rank = isset($rank_map[$c->id]) ? $rank_map[$c->id] : '-';
                $is_lead = ($winner && $winner->id == $c->id && $c->total_votes > 0);
              ?>
              <tr <?php echo $is_lead ? 'style="background-color: #f8fff9;"' : ''; ?>>
                <td class="text-center font-weight-bold" style="font-size: 15px;">
                  <span class="badge text-white" style="background-color: <?php echo $c->color ?: '#6777ef'; ?>; font-size: 13px;">
                    #<?php echo $c->candidate_number; ?>
                  </span>
                </td>
                <td>
                  <div class="font-weight-bold text-dark"><?php echo $c->chairman_name; ?></div>
                  <div class="small text-muted">&amp; <?php echo $c->vice_chairman_name; ?></div>
                </td>
                <td class="text-center font-weight-bold" style="font-size: 14px;">
                  <?php echo number_format($c->total_votes); ?> <?php echo __t('votes', 'Votes'); ?>
                </td>
                <td class="text-center font-weight-bold">
                  <?php echo $c->percentage; ?>%
                </td>
                <td class="text-center">
                  <?php if ($is_lead): ?>
                    <span class="badge-winner"><i class="fas fa-trophy mr-1"></i> <?php echo __t('winner_badge', 'ELECTED (Rank 1)'); ?></span>
                  <?php else: ?>
                    <span class="badge badge-light border text-muted"><?php echo __t('rank_label', 'Rank'); ?> <?php echo $rank; ?></span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center py-3 text-muted"><?php echo __t('no_candidate_data', 'No candidate data available.'); ?></td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- BAGIAN 3: CATATAN & KESIMPULAN -->
    <div class="mb-4 p-3 bg-light rounded border">
      <h6 class="font-weight-bold mb-1 text-dark">
        <i class="fas fa-check-circle text-success mr-1"></i> <?php echo __t('legal_certification_title', 'CERTIFICATION & RATIFICATION'); ?>
      </h6>
      <p class="small mb-0 text-muted" style="line-height: 1.6;">
        <?php echo __t('legal_certification_desc', 'Based on the digital recapitulation results above, all incoming votes have been authenticated via system encryption and unique voter identity cards (NFC/RFID Card UID).'); ?>
        <?php if ($winner && $winner->total_votes > 0): ?>
          <?php echo sprintf(__t('winner_declaration_text', 'Hereby Candidate Pair #%s (%s & %s) is officially declared to have secured the plurality of votes with %s votes (%s%%).'), $winner->candidate_number, $winner->chairman_name, $winner->vice_chairman_name, number_format($winner->total_votes), $winner->percentage); ?>
        <?php endif; ?>
        <?php echo __t('minutes_closing_text', 'Thus, this Official Record is formalized and ratified to be used in according legal capacity.'); ?>
      </p>
    </div>

    <!-- BAGIAN 4: TANDA TANGAN SAKSI DAN PANITIA -->
    <div class="ttd-box">
      <div class="row text-center">
        <!-- Saksi-Saksi -->
        <div class="col-4">
          <div class="small font-weight-bold text-muted mb-1"><?php echo sprintf(__t('witness_candidate_label', 'Witness Candidate #%s'), '1'); ?></div>
          <div class="ttd-line"></div>
          <div class="small font-weight-bold">( ........................................ )</div>
        </div>
        <div class="col-4">
          <div class="small font-weight-bold text-muted mb-1"><?php echo sprintf(__t('witness_candidate_label', 'Witness Candidate #%s'), '2'); ?></div>
          <div class="ttd-line"></div>
          <div class="small font-weight-bold">( ........................................ )</div>
        </div>
        <div class="col-4">
          <div class="small font-weight-bold text-muted mb-1"><?php echo sprintf(__t('witness_candidate_label', 'Witness Candidate #%s'), '3'); ?></div>
          <div class="ttd-line"></div>
          <div class="small font-weight-bold">( ........................................ )</div>
        </div>
      </div>

      <div class="row text-center mt-4 pt-2">
        <div class="col-6">
          <div class="small font-weight-bold text-muted mb-1"><?php echo __t('election_secretary', 'Election Committee Secretary'); ?></div>
          <div class="ttd-line"></div>
          <div class="small font-weight-bold">( ........................................ )</div>
        </div>
        <div class="col-6">
          <div class="small font-weight-bold text-muted mb-1"><?php echo __t('election_chairman', 'Election Committee Chairman / KPU'); ?></div>
          <div class="ttd-line"></div>
          <div class="small font-weight-bold">( <?php echo $this->session->userdata('name'); ?> )</div>
        </div>
      </div>
    </div>

    <div class="text-center mt-5 pt-3 border-top small text-muted">
      <?php echo sprintf(__t('auto_printed_footer', 'Automatically generated by Simple E-Vote System on %s | Server ID: %s'), date('d M Y, H:i:s'), md5(base_url())); ?>
    </div>

  </div>

  <?php if ($this->input->get('autoprint') == '1'): ?>
    <script>
      window.onload = function() {
        window.print();
      };
    </script>
  <?php endif; ?>

</body>
</html>
