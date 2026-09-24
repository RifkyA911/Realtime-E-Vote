<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('__t')) {
	/**
	 * Translate language key with optional fallback text
	 */
	function __t($line, $default = null) {
		$ci =& get_instance();
		$translation = $ci->lang->line($line);
		if ($translation !== FALSE && $translation !== '') {
			return $translation;
		}
		return ($default !== null) ? $default : $line;
	}
}

if (!function_exists('current_lang')) {
	/**
	 * Get active language code ('id' or 'en')
	 */
	function current_lang() {
		$ci =& get_instance();
		return $ci->session->userdata('site_lang') ?: 'id';
	}
}

if (!function_exists('current_lang_name')) {
	/**
	 * Get readable active language name
	 */
	function current_lang_name() {
		return (current_lang() === 'en') ? 'English' : 'Bahasa Indonesia';
	}
}
