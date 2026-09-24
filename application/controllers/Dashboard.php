<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Candidate_model');
		$this->load->model('Voter_model');
		$this->load->model('Vote_model');
	}

	public function index() {
		$total_voters   = $this->Voter_model->count_all();
		$total_voted    = $this->Voter_model->count_voted();
		$total_unvoted  = $this->Voter_model->count_unvoted();
		$total_candidates = $this->Candidate_model->count_all();

		$participation_rate = ($total_voters > 0) 
			? round(($total_voted / $total_voters) * 100, 1) 
			: 0;

		$candidates = $this->Candidate_model->get_with_votes_count();
		$recent_votes = $this->Vote_model->get_recent_votes(8);

		$data = array(
			'title'              => 'Dashboard Real Count E-Vote',
			'total_voters'       => $total_voters,
			'total_voted'        => $total_voted,
			'total_unvoted'      => $total_unvoted,
			'total_candidates'   => $total_candidates,
			'participation_rate' => $participation_rate,
			'candidates'         => $candidates,
			'recent_votes'       => $recent_votes
		);

		$this->load->view('dashboard/index', $data);
	}

	/**
	 * AJAX endpoint for Real-Time Live Count Auto-Refresh
	 */
	public function get_live_stats() {
		$total_voters   = $this->Voter_model->count_all();
		$total_voted    = $this->Voter_model->count_voted();
		$total_unvoted  = $this->Voter_model->count_unvoted();
		$total_candidates = $this->Candidate_model->count_all();

		$participation_rate = ($total_voters > 0) 
			? round(($total_voted / $total_voters) * 100, 1) 
			: 0;

		$candidates = $this->Candidate_model->get_with_votes_count();
		$recent_votes = $this->Vote_model->get_recent_votes(8);

		// Format dates and ensure safe HTML output
		$formatted_recent = array();
		foreach ($recent_votes as $rv) {
			$formatted_recent[] = array(
				'id'                 => (int) $rv->id,
				'voted_at'           => $rv->voted_at,
				'formatted_time'     => date('d M Y, H:i', strtotime($rv->voted_at)) . ' WIB',
				'voter_code'         => htmlspecialchars($rv->voter_code),
				'voter_name'         => htmlspecialchars($rv->voter_name),
				'class_or_dept'      => htmlspecialchars($rv->class_or_dept),
				'candidate_number'   => (int) $rv->candidate_number,
				'chairman_name'      => htmlspecialchars($rv->chairman_name),
				'vice_chairman_name' => htmlspecialchars($rv->vice_chairman_name),
				'color'              => $rv->color ?: '#6777ef'
			);
		}

		$candidates_data = array();
		foreach ($candidates as $c) {
			$candidates_data[] = array(
				'id'                 => (int) $c->id,
				'candidate_number'   => (int) $c->candidate_number,
				'chairman_name'      => htmlspecialchars($c->chairman_name),
				'vice_chairman_name' => htmlspecialchars($c->vice_chairman_name),
				'color'              => $c->color ?: '#6777ef',
				'photo'              => $c->photo,
				'total_votes'        => (int) $c->total_votes,
				'percentage'         => (float) $c->percentage
			);
		}

		$response = array(
			'status'             => 'success',
			'total_voters'       => number_format($total_voters),
			'total_voters_raw'   => (int) $total_voters,
			'total_voted'        => number_format($total_voted),
			'total_voted_raw'    => (int) $total_voted,
			'total_unvoted'      => number_format($total_unvoted),
			'total_unvoted_raw'  => (int) $total_unvoted,
			'total_candidates'   => (int) $total_candidates,
			'participation_rate' => $participation_rate,
			'candidates'         => $candidates_data,
			'recent_votes'       => $formatted_recent,
			'server_time'        => date('H:i:s') . ' WIB',
			'server_datetime'    => date('d M Y H:i:s')
		);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	/**
	 * Official Election Recap & Minutes of Vote Count (Berita Acara & Rekapitulasi)
	 */
	public function print_rekap() {
		$total_voters   = $this->Voter_model->count_all();
		$total_voted    = $this->Voter_model->count_voted();
		$total_unvoted  = $this->Voter_model->count_unvoted();
		$total_candidates = $this->Candidate_model->count_all();

		$participation_rate = ($total_voters > 0) 
			? round(($total_voted / $total_voters) * 100, 1) 
			: 0;

		$candidates = $this->Candidate_model->get_with_votes_count();

		// Rank candidates by total_votes descending
		$ranked_candidates = $candidates;
		usort($ranked_candidates, function($a, $b) {
			if ($b->total_votes == $a->total_votes) {
				return $a->candidate_number - $b->candidate_number;
			}
			return $b->total_votes - $a->total_votes;
		});

		$winner = (!empty($ranked_candidates) && $total_voted > 0) ? $ranked_candidates[0] : null;

		$data = array(
			'title'              => 'Berita Acara & Rekapitulasi Hasil Penghitungan Suara E-Voting',
			'doc_number'         => 'BA-EVOTE/' . date('Ymd') . '/001',
			'total_voters'       => $total_voters,
			'total_voted'        => $total_voted,
			'total_unvoted'      => $total_unvoted,
			'total_candidates'   => $total_candidates,
			'participation_rate' => $participation_rate,
			'candidates'         => $candidates,
			'ranked_candidates'  => $ranked_candidates,
			'winner'             => $winner,
			'print_date'         => date('d F Y, H:i') . ' WIB'
		);

		$this->load->view('dashboard/print_rekap', $data);
	}
}
