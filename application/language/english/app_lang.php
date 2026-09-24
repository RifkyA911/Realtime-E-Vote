<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['app_name']            = 'Simple E-Vote';
$lang['app_tagline']         = 'Modern E-Voting System with Tap ID Card (RFID/NFC) Feature';
$lang['app_description']     = 'A modern electronic voting application featuring password-free Tap ID Card login bypass (RFID/NFC), real-time live count tracking, and official election report generation.';

// Nav & Menu
$lang['menu_main']           = 'Main Menu';
$lang['menu_dashboard']      = 'Dashboard & Live Count';
$lang['menu_booth']          = 'Voting Booth';
$lang['menu_candidates']     = 'Candidates';
$lang['menu_voters']         = 'Voters Registry (DPT)';
$lang['menu_print_recap']    = 'Print Official Recap';
$lang['menu_database']       = 'Database & Reset';
$lang['menu_docs']           = 'System Documentation';
$lang['menu_account']        = 'Account Settings';
$lang['menu_logout']         = 'Logout';
$lang['logged_in_as']        = 'Signed in as';
$lang['reseed_db']           = 'Re-Seed Database';
$lang['reset_votes_only']    = 'Reset Votes Only';

// Confirmations
$lang['confirm_reseed']      = 'Reset and re-seed database to initial demo state?';
$lang['confirm_reset_votes'] = 'Clear all cast ballots and reset voter statuses?';
$lang['confirm_logout']      = 'Are you sure you want to log out?';

// Auth & Login
$lang['login_title']         = 'Sign In to Simple E-Vote';
$lang['tab_tap_card']        = 'Tap ID Card / RFID';
$lang['tab_password']        = 'Username & Password';
$lang['scanner_status_ready']= 'Tap your ID Card on the Scanner';
$lang['scanner_ready']       = 'Reader Ready to Detect';
$lang['scanner_desc']        = 'Place your RFID / NFC card on the card reader or use your mobile device NFC sensor.';
$lang['scanner_waiting']     = 'Waiting for card tap...';
$lang['scanner_card_detected'] = 'Card Detected! Verifying identity...';
$lang['scanner_auto_detect_note'] = 'Reader automatically detects when card is tapped (10-Digit UID / Hex Mifare).';
$lang['tap_card_placeholder']= 'Tap card or enter Card UID here...';
$lang['enable_phone_nfc']    = 'Enable Native Phone NFC Scan (Web NFC)';
$lang['simulation_title']    = 'Demo Card Tap Simulation:';
$lang['one_click_tap']       = '1-Click Tap';
$lang['card_voter']          = 'Voter Card:';
$lang['card_admin']          = 'Admin Card:';
$lang['card_unregistered']   = 'Unregistered Card';
$lang['testing_error']       = 'Testing Error';
$lang['demo_account_title']  = 'Demo Password Accounts:';
$lang['btn_login']           = 'Sign In Now';
$lang['btn_enter']           = 'Enter';
$lang['username']            = 'Username / Voter Code';
$lang['password']            = 'Password';
$lang['remember_me']         = 'Remember Me';
$lang['admin']               = 'Administrator';
$lang['voter']               = 'Voter';
$lang['user']                = 'User';
$lang['admin_docs_link']     = 'System Documentation (Admin)';
$lang['verifying_card']      = 'Verifying Card...';
$lang['card_verified']       = 'Card Verified!';
$lang['redirecting']         = 'Redirecting to destination page...';
$lang['access_denied']       = 'Access Denied!';
$lang['reader_instruction_box'] = 'Hold voter card near USB reader / NFC sensor to enter Voting Booth directly without password.';
$lang['connection_error']    = 'Server connection error. Please try again!';

// Dashboard & Stats
$lang['dashboard_title']      = 'Real-Time Live Count &bull; Simple E-Vote';
$lang['stat_total_dpt']       = 'Total Voters (DPT)';
$lang['stat_voted']           = 'Ballots Cast';
$lang['stat_unvoted']         = 'Not Voted';
$lang['stat_participation']   = 'Participation';
$lang['hero_title']           = 'Modern Online E-Voting System';
$lang['hero_subtitle']        = 'Cast your vote honestly, fairly, transparently, and in real time.';
$lang['enter_booth']          = 'Enter Voting Booth';
$lang['live_count_on']        = 'LIVE COUNT ON';
$lang['live_count_paused']    = 'LIVE PAUSED';
$lang['btn_pause']            = 'Pause';
$lang['btn_resume']           = 'Resume';
$lang['btn_refresh']          = 'Refresh';
$lang['last_updated']         = 'Last Updated';
$lang['realtime_verified_system'] = 'Real-Time & Verified System';
$lang['vote_chart_title']     = 'Real Count Vote Breakdown Chart';
$lang['candidate_pairs']      = 'Candidate Pairs';
$lang['view_all']             = 'View All';
$lang['vision_mission']       = 'Vision & Mission';
$lang['recent_votes_title']   = 'Latest Incoming Votes Log';
$lang['verified']             = 'Verified';
$lang['no_votes_yet']         = 'No Ballots Cast Yet';
$lang['start_voting_prompt']  = 'Please start voting in the Voting Booth.';
$lang['vote_percentage']      = 'Vote Percentage Breakdown:';
$lang['votes']                = 'votes';
$lang['total_votes_label']    = 'Total Votes';
$lang['candidate_choice']     = 'Candidate Choice';
$lang['no_recent_votes']      = 'No vote activity recorded yet.';
$lang['candidate_pair']       = 'Pair';

// Table Headers
$lang['th_no']                = '#';
$lang['th_time']              = 'Vote Time';
$lang['th_voter_code']        = 'Voter Code';
$lang['th_voter_name']        = 'Voter Name';
$lang['th_dept']              = 'Class / Department';
$lang['th_candidate_choice']  = 'Candidate Choice';
$lang['th_status']            = 'Status';
$lang['th_action']            = 'Action';
$lang['th_card_uid']          = 'Card UID (RFID)';
$lang['th_full_name']         = 'Full Name';
$lang['th_gender']            = 'Gender';
$lang['th_vote_status']       = 'Vote Status';
$lang['th_voted_at']          = 'Voted At';

// Booth / Bilik Suara
$lang['booth_title']          = 'Electronic Voting Booth';
$lang['voted_confirmation_title'] = 'You Have Cast Your Vote';
$lang['voter_verified_title'] = 'Verified Voter Identity';
$lang['voter_verified_desc']  = 'Your identity has been verified in the DPT. Please cast your ballot below.';
$lang['registered_in_dpt']    = 'Registered in DPT';
$lang['status_has_voted']     = 'Has Voted';
$lang['status_not_voted']     = 'Not Voted';
$lang['step1_admin_title']    = 'Step 1: Select / Verify Voter Identity';
$lang['step1_admin_desc']     = 'Select a voter who has not yet voted for live voting simulation.';
$lang['unvoted_count_badge']  = 'Voters Not Voted';
$lang['select_voter_label']   = 'Select Voter from DPT Registry:';
$lang['select_voter_placeholder'] = '-- Please Select an Unvoted Voter --';
$lang['unvoted_only_note']    = 'This list only shows voters with Not Voted status.';
$lang['select_voter_warning'] = 'Please select a voter on the left panel before casting a vote!';
$lang['step2_ballot_title']   = 'Step 2: Electronic Ballot Paper';
$lang['step2_ballot_desc']    = 'Cast your vote for one of the candidate pairs below:';
$lang['btn_vote_this']        = 'VOTE PAIR';
$lang['confirm_vote_title']   = 'Ballot Confirmation';
$lang['confirm_vote_subtitle']= 'Are you sure about your selection?';
$lang['vote_irreversible_note'] = 'Once confirmed, your ballot will be officially cast and cannot be changed.';
$lang['btn_confirm_vote']     = 'Yes, Cast Vote Now!';
$lang['btn_cancel']           = 'Cancel';
$lang['voter_not_selected_title'] = 'Voter Not Selected!';
$lang['voter_not_selected_msg']   = 'Please select a registered voter in Step 1 before casting a ballot.';
$lang['btn_understand']       = 'Understood';

// Candidates CRUD
$lang['candidate_registry']   = 'Candidate Pairs Registry';
$lang['add_candidate_title']  = 'Add New Candidate Pair';
$lang['edit_candidate_title'] = 'Edit Candidate Pair';
$lang['candidate_profile_title'] = 'Candidate Profile';
$lang['candidate_form']       = 'Candidate Registration Form';
$lang['ballot_number']        = 'Ballot Number';
$lang['ballot_no']            = 'Ballot No.';
$lang['ballot_no_upper']      = 'BALLOT NO.';
$lang['chairman']             = 'Chairman Candidate';
$lang['vice_chairman']        = 'Vice Chairman Candidate';
$lang['vision']               = 'Vision';
$lang['mission']              = 'Mission';
$lang['theme_color']          = 'Theme Color';
$lang['photo']                = 'Candidate Photo';
$lang['official_ballot_no']   = 'Official ballot number.';
$lang['color_badge_desc']     = 'Theme color for badge and chart.';
$lang['photo_desc']           = 'Format: JPG/PNG, max 3MB.';
$lang['main_vision']          = 'Main Vision:';
$lang['no_candidates_yet']    = 'No Candidate Data Available';
$lang['no_candidates_desc']   = 'Please add your first candidate pair to start the election.';
$lang['candidate_recap_table']= 'Candidate Recap Table';
$lang['votes_acquired']       = 'Votes Acquired';
$lang['percentage']           = 'Percentage';
$lang['confirm_delete_candidate'] = 'Are you sure you want to delete candidate #%s? Associated votes will also be deleted.';
$lang['save_candidate']       = 'Save Candidate';
$lang['save_changes']         = 'Save Changes';

// Voters DPT CRUD
$lang['voter_registry']       = 'Registered Voters (DPT)';
$lang['add_voter_title']      = 'Add New Voter (DPT)';
$lang['edit_voter_title']     = 'Edit Voter Details';
$lang['voter_form']           = 'Voter Registration Form';
$lang['voter_code']           = 'Voter Code / Student ID';
$lang['voter_name']           = 'Full Name';
$lang['gender']               = 'Gender';
$lang['gender_m']             = 'Male (M)';
$lang['gender_f']             = 'Female (F)';
$lang['class_or_dept']        = 'Class / Major / Unit';
$lang['card_uid']             = 'Card UID (RFID / NFC)';
$lang['card_uid_optional']    = '(Optional for Tap Card Login)';
$lang['voter_code_desc']      = 'Unique identifier code (Student/Member ID).';
$lang['card_uid_desc']        = 'Unique RFID UID for fast tap card authentication (USB Reader / NFC).';
$lang['save_voter']           = 'Save Voter';
$lang['voting_rights_status'] = 'Voting Rights Status:';
$lang['reset_all_votes']      = 'Reset All Votes';
$lang['confirm_reset_all']    = 'WARNING: This will reset voting status for ALL voters and clear all cast ballots. Proceed?';
$lang['registered_voters_list'] = 'Registered Voters List';
$lang['search_voters']        = 'Search Voters:';

// Print Recap & Docs
$lang['print_recap_title']    = 'Official Election Minutes & Vote Recapitulation';
$lang['back_to_dashboard']    = 'Back to Dashboard';
$lang['print_pdf_hint']       = 'You can print directly or save as a PDF document.';
$lang['print_save_pdf']       = 'Print / Save PDF';
$lang['committee_title']      = 'ELECTRONIC VOTING COMMITTEE (E-VOTING)';
$lang['kpu_title']            = 'GENERAL ELECTIONS COMMISSION (KPU)';
$lang['system_tagline_doc']   = 'Integrated Digital Election Administration System with Real Count & RFID Card Support';
$lang['minutes_doc_title']    = 'OFFICIAL MINUTES OF ELECTION VOTE RECAPITULATION';
$lang['winner_badge']         = 'WINNER / ELECTED';
$lang['runner_up']            = 'RUNNER UP';
$lang['docs_title']           = 'System Architecture & Documentation &mdash; Simple E-Vote';

// Flash & System Messages
$lang['msg_login_required']   = 'Please sign in to access the E-Voting system.';
$lang['msg_admin_required']   = 'Access denied! This feature is restricted to Administrators.';
$lang['msg_welcome_role']     = 'Welcome, %s! Signed in as %s.';
$lang['msg_invalid_credentials'] = 'Invalid username or password. Please verify your credentials!';
$lang['msg_already_logged_in']= 'You are already signed in.';
$lang['msg_tap_card_prompt']  = 'Please tap your ID card on the reader!';
$lang['msg_card_verified_welcome'] = 'Card ID Verified! Welcome, %s (%s).';
$lang['msg_card_unregistered']= 'Card ID (%s) is not registered in the E-Voting system!';
$lang['msg_select_candidate_required'] = 'Please select a candidate pair to cast your ballot.';
$lang['msg_invalid_voter']    = 'Invalid voter record.';
$lang['msg_voter_already_voted'] = 'Voter %s (%s) has already cast a ballot.';
$lang['msg_invalid_candidate']= 'Invalid candidate selected.';
$lang['msg_vote_cast_success']= 'Success! Vote for voter %s has been securely cast for Candidate Pair #%s!';
$lang['msg_vote_error']       = 'A system error occurred while recording the vote. Please try again.';
$lang['msg_candidate_added']  = 'Candidate pair #%s has been successfully registered!';
$lang['msg_candidate_updated']= 'Candidate details updated successfully!';
$lang['msg_candidate_deleted']= 'Candidate #%s (%s) has been successfully deleted.';
$lang['msg_candidate_not_found'] = 'Candidate record not found.';
$lang['msg_candidate_number_taken'] = 'Ballot number #%s is already used by another candidate.';
$lang['msg_photo_upload_error'] = 'Photo upload failed: ';
$lang['msg_voter_added']      = 'Voter %s (%s) has been successfully registered!';
$lang['msg_voter_updated']    = 'Voter details updated successfully!';
$lang['msg_voter_deleted']    = 'Voter %s has been successfully deleted.';
$lang['msg_voter_not_found']  = 'Voter record not found.';
$lang['msg_voter_code_taken'] = 'Voter code %s is already assigned to another voter.';
$lang['msg_card_uid_taken']   = 'Card UID %s is already assigned to another voter.';
$lang['msg_voter_status_reset'] = 'Voting status for %s has been reset to Not Voted.';
$lang['msg_all_votes_reset']  = 'All voting records have been cleared! All voters are now set to Not Voted.';

// Validation rules
$lang['field_required']       = '%s is required.';
$lang['field_numeric']        = '%s must be a valid number.';
$lang['field_unique_candidate'] = '%s is already taken by another candidate.';
$lang['field_unique_voter']   = '%s is already registered in the system.';

// Common
$lang['save']                 = 'Save';
$lang['cancel']               = 'Cancel';
$lang['edit']                 = 'Edit';
$lang['delete']               = 'Delete';
$lang['detail']               = 'Details';
$lang['back']                 = 'Back';
$lang['status']               = 'Status';
$lang['action']               = 'Action';
$lang['language']             = 'Language';
$lang['home']                 = 'Home';
$lang['success']              = 'Success!';
$lang['close']                = 'Close';

// WebSocket & Real-time Live Preview
$lang['ws_connected']         = 'WebSocket: Live Push';
$lang['ws_polling_fallback']  = 'Polling Fallback (Active)';
$lang['ws_connecting']        = 'Connecting WebSocket...';
$lang['ws_disconnected']      = 'WebSocket Disconnected';
$lang['live_preview_title']   = 'Live Vote Standings & Percentage';
$lang['live_preview_desc']    = 'Real-time candidate standings preview updated via WebSocket';
$lang['turnout_rate']         = 'Voter Turnout Rate';
$lang['total_ballots_cast']   = 'Ballots Cast';
$lang['view_full_dashboard']  = 'Open Full Live Count Dashboard';
$lang['ws_stream_card_title'] = 'WebSocket Real-Time Stream Engine';
$lang['ws_server_url']        = 'Server URL';
$lang['ws_mode']              = 'Broadcast Mode';
$lang['ws_last_event']        = 'Last Broadcast Event';
$lang['ws_test_trigger']      = 'Test Push Broadcast';
$lang['ws_engine_badge']      = 'RFC 6455 Native Engine';

