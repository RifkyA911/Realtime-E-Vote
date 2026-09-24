<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['app_name']            = 'Simple E-Vote';
$lang['app_tagline']         = 'Modern E-Voting System with Tap ID Card (RFID/NFC) Feature';
$lang['app_description']     = 'A modern electronic voting application featuring password-free Tap ID Card login bypass (RFID/NFC), real-time live count tracking, and official election report generation.';

// Nav & Menu
$lang['menu_main']           = 'Main Menu';
$lang['menu_dashboard']      = 'Dashboard & Live Count';
$lang['menu_booth']          = 'Voting Booth';
$lang['menu_candidates']     = 'Candidates Data';
$lang['menu_voters']         = 'Voters Registry (DPT)';
$lang['menu_print_recap']    = 'Print Election Minutes';
$lang['menu_database']       = 'Database & Seed';
$lang['menu_docs']           = 'System Documentation';
$lang['menu_account']        = 'Account Settings';
$lang['menu_logout']         = 'Logout';
$lang['logged_in_as']        = 'Logged in as';
$lang['reseed_db']           = 'Re-Seed Database';
$lang['reset_votes_only']    = 'Reset Votes Only';

// Confirmations
$lang['confirm_reseed']      = 'Re-run migration and reset database to initial seed data?';
$lang['confirm_reset_votes'] = 'Clear and truncate all votes that have been cast?';
$lang['confirm_logout']      = 'Are you sure you want to log out?';

// Auth & Login
$lang['login_title']         = 'Sign In to E-Voting System';
$lang['tab_tap_card']        = 'Tap ID Card / RFID';
$lang['tab_password']        = 'Username & Password';
$lang['scanner_status_ready']= 'Tap your ID Card on the Scanner';
$lang['scanner_desc']        = 'Place your RFID / NFC card on the card reader or use your mobile device NFC sensor.';
$lang['scanner_waiting']     = 'Waiting for card tap...';
$lang['scanner_card_detected'] = 'Card Detected! Verifying identity...';
$lang['btn_login']           = 'Sign In Now';
$lang['username']            = 'Username / Voter Code';
$lang['password']            = 'Password';
$lang['remember_me']         = 'Remember Me';

// Dashboard & Stats
$lang['stat_total_dpt']      = 'Total Voters';
$lang['stat_voted']          = 'Votes Counted';
$lang['stat_unvoted']        = 'Not Voted Yet';
$lang['stat_participation']  = 'Participation';
$lang['hero_title']          = 'Online E-Voting System';
$lang['hero_subtitle']       = 'Cast your vote honestly, fairly, transparently, and in real time.';
$lang['enter_booth']         = 'Enter Voting Booth';
$lang['live_count_on']       = 'LIVE COUNT ON';
$lang['live_count_paused']   = 'LIVE PAUSED';
$lang['btn_pause']           = 'Pause';
$lang['btn_resume']          = 'Resume';
$lang['btn_refresh']         = 'Refresh';
$lang['last_update']         = 'Last Updated';
$lang['vote_chart_title']    = 'Real Count Vote Breakdown Chart';
$lang['candidate_pairs']     = 'Candidate Pairs';
$lang['view_all']            = 'View All';
$lang['vision_mission']      = 'Vision & Mission';
$lang['recent_votes_title']  = 'Latest Incoming Votes Log';
$lang['verified']            = 'Verified';

// Booth / Bilik Suara
$lang['booth_title']         = 'Electronic Voting Booth';
$lang['btn_vote_this']       = 'Vote This Candidate';
$lang['confirm_vote']        = 'Confirm Your Vote';
$lang['already_voted_title'] = 'Vote Has Been Cast';
$lang['already_voted_desc']  = 'You have already cast your vote in this election. Thank you for your participation!';
$lang['select_candidate']    = 'Select Candidate Pair';
$lang['selected_voter']      = 'Verified Voter Identity';

// Candidates CRUD
$lang['candidate_list']      = 'Candidate Pairs Registry';
$lang['add_candidate']       = 'Add New Candidate';
$lang['edit_candidate']      = 'Edit Candidate Pair';
$lang['candidate_number']    = 'Ballot Number';
$lang['chairman']            = 'Chairman Candidate';
$lang['vice_chairman']       = 'Vice-Chairman Candidate';
$lang['vision']              = 'Vision';
$lang['mission']             = 'Mission';
$lang['theme_color']         = 'Candidate Theme Color';
$lang['photo']               = 'Candidate Photo';

// Voters DPT CRUD
$lang['voter_list']          = 'Registered Voters (DPT)';
$lang['add_voter']           = 'Add New Voter';
$lang['edit_voter']          = 'Edit Voter Details';
$lang['voter_code']          = 'Voter Code / Student ID';
$lang['voter_name']          = 'Full Name';
$lang['gender']              = 'Gender';
$lang['class_or_dept']       = 'Class / Major / Unit';
$lang['card_uid']            = 'Card UID (RFID / NFC)';
$lang['has_voted']           = 'Has Voted';
$lang['not_voted']           = 'Not Voted';
$lang['reset_status']        = 'Reset Status';
$lang['reset_all']           = 'Reset All Votes';

// Common
$lang['save']                = 'Save';
$lang['cancel']              = 'Cancel';
$lang['edit']                = 'Edit';
$lang['delete']              = 'Delete';
$lang['detail']              = 'Details';
$lang['back']                = 'Back';
$lang['status']              = 'Status';
$lang['action']              = 'Action';
$lang['language']            = 'Language';
$lang['home']                = 'Home';
