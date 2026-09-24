<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lang extends CI_Controller {

	public function switch_lang($lang = 'en') {
		$target_lang = in_array(strtolower($lang), array('id', 'indonesian')) ? 'id' : 'en';
		$this->session->set_userdata('site_lang', $target_lang);

		$referrer = $this->input->server('HTTP_REFERER');
		if (!empty($referrer) && strpos($referrer, base_url()) === 0) {
			redirect($referrer);
		} else {
			redirect('dashboard');
		}
	}
}
