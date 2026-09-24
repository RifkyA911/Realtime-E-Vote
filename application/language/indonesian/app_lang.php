<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['app_name']            = 'Simple E-Vote';
$lang['app_tagline']         = 'Sistem E-Voting Modern dengan Fitur Tap ID Card (RFID/NFC)';
$lang['app_description']     = 'Aplikasi pemilihan elektronik modern yang mendukung bypass login menggunakan kartu identitas (RFID/NFC), penghitungan suara real-time, dan berita acara resmi.';

// Nav & Menu
$lang['menu_main']           = 'Menu Utama E-Vote';
$lang['menu_dashboard']      = 'Dashboard & Real Count';
$lang['menu_booth']          = 'Bilik Suara (Voting)';
$lang['menu_candidates']     = 'Data Kandidat';
$lang['menu_voters']         = 'Data Pemilih (DPT)';
$lang['menu_print_recap']    = 'Cetak Berita Acara';
$lang['menu_database']       = 'Database & Seed';
$lang['menu_docs']           = 'Dokumentasi Sistem';
$lang['menu_account']        = 'Pengaturan Akun';
$lang['menu_logout']         = 'Logout';
$lang['logged_in_as']        = 'Masuk sebagai';
$lang['reseed_db']           = 'Re-Seed Database';
$lang['reset_votes_only']    = 'Reset Suara Saja';

// Confirmations
$lang['confirm_reseed']      = 'Jalankan migrasi ulang dan reset ke data awal?';
$lang['confirm_reset_votes'] = 'Kosongkan semua suara yang sudah masuk?';
$lang['confirm_logout']      = 'Apakah Anda yakin ingin logout?';

// Auth & Login
$lang['login_title']         = 'Masuk ke Sistem E-Voting';
$lang['tab_tap_card']        = 'Tap ID Card / RFID';
$lang['tab_password']        = 'Username & Password';
$lang['scanner_status_ready']= 'Tempelkan Kartu ID Anda ke Scanner';
$lang['scanner_ready']       = 'Reader Siap Mendeteksi';
$lang['scanner_desc']        = 'Dekatkan kartu RFID / NFC pada reader atau gunakan sensor NFC ponsel.';
$lang['scanner_waiting']     = 'Menunggu kartu ditempelkan...';
$lang['scanner_card_detected'] = 'Kartu Terdeteksi! Memverifikasi identitas...';
$lang['scanner_auto_detect_note'] = 'Reader otomatis mendeteksi saat kartu ditempelkan (UID 10-Digit / Hex Mifare).';
$lang['tap_card_placeholder']= 'Tap kartu atau ketik UID di sini...';
$lang['enable_phone_nfc']    = 'Aktifkan Scan NFC Bawaan HP (Web NFC)';
$lang['simulation_title']    = 'Simulasi Tap Kartu Uji Coba:';
$lang['one_click_tap']       = '1-Klik Tap';
$lang['card_voter']          = 'Kartu Pemilih:';
$lang['card_admin']          = 'Kartu Admin:';
$lang['card_unregistered']   = 'Kartu Tidak Terdaftar';
$lang['testing_error']       = 'Uji Error';
$lang['demo_account_title']  = 'Akun Demo Password:';
$lang['btn_login']           = 'Masuk Sekarang';
$lang['btn_enter']           = 'Masuk';
$lang['username']            = 'Username / Kode Pemilih';
$lang['password']            = 'Password';
$lang['remember_me']         = 'Ingat Saya';
$lang['admin']               = 'Administrator';
$lang['voter']               = 'Pemilih';
$lang['user']                = 'Pengguna';
$lang['admin_docs_link']     = 'Dokumentasi Sistem (Admin)';
$lang['verifying_card']      = 'Memverifikasi Kartu...';
$lang['card_verified']       = 'Kartu Terverifikasi!';
$lang['redirecting']         = 'Mengalihkan ke halaman tujuan...';
$lang['access_denied']       = 'Akses Ditolak!';
$lang['reader_instruction_box'] = 'Dekatkan kartu pemilih ke reader USB / NFC untuk langsung masuk ke Bilik Suara tanpa password.';
$lang['connection_error']    = 'Terjadi kendala koneksi ke server. Silakan coba lagi!';

// Dashboard & Stats
$lang['dashboard_title']      = 'Dashboard Real Count E-Vote';
$lang['stat_total_dpt']       = 'Total DPT';
$lang['stat_voted']           = 'Suara Masuk';
$lang['stat_unvoted']         = 'Belum Memilih';
$lang['stat_participation']   = 'Partisipasi';
$lang['hero_title']           = 'Sistem E-Voting Pemilihan Online';
$lang['hero_subtitle']        = 'Gunakan hak suara secara jujur, adil, transparan, dan real-time.';
$lang['enter_booth']          = 'Masuk ke Bilik Suara';
$lang['live_count_on']        = 'LIVE COUNT ON';
$lang['live_count_paused']    = 'LIVE DIJEDA';
$lang['btn_pause']            = 'Jeda';
$lang['btn_resume']           = 'Lanjutkan';
$lang['btn_refresh']          = 'Refresh';
$lang['last_updated']         = 'Update Terakhir';
$lang['realtime_verified_system'] = 'Sistem Real-Time & Terverifikasi';
$lang['vote_chart_title']     = 'Grafik Real Count Perolehan Suara';
$lang['candidate_pairs']      = 'Pasangan Calon';
$lang['view_all']             = 'Lihat Semua';
$lang['vision_mission']       = 'Visi & Misi';
$lang['recent_votes_title']   = 'Log Suara Masuk Terbaru';
$lang['verified']             = 'Terverifikasi';
$lang['no_votes_yet']         = 'Belum Ada Suara Masuk';
$lang['start_voting_prompt']  = 'Silakan mulai lakukan pencoblosan melalui Bilik Suara.';
$lang['vote_percentage']      = 'Persentase Perolehan Suara:';
$lang['votes']                = 'suara';
$lang['total_votes_label']    = 'Jumlah Suara';
$lang['candidate_choice']     = 'Pilihan Paslon';
$lang['no_recent_votes']      = 'Belum ada aktivitas suara yang masuk.';
$lang['candidate_pair']       = 'Paslon';

// Table Headers
$lang['th_no']                = '#';
$lang['th_time']              = 'Waktu Vote';
$lang['th_voter_code']        = 'Kode Pemilih';
$lang['th_voter_name']        = 'Nama Pemilih';
$lang['th_dept']              = 'Kelas / Jurusan';
$lang['th_candidate_choice']  = 'Pilihan Paslon';
$lang['th_status']            = 'Status';
$lang['th_action']            = 'Aksi';
$lang['th_card_uid']          = 'UID Kartu (RFID)';
$lang['th_full_name']         = 'Nama Lengkap';
$lang['th_gender']            = 'L/P';
$lang['th_vote_status']       = 'Status Memilih';
$lang['th_voted_at']          = 'Waktu Mencoblos';

// Booth / Bilik Suara
$lang['booth_title']          = 'Bilik Suara (E-Voting Booth)';
$lang['voted_confirmation_title'] = 'Anda Telah Menggunakan Hak Suara';
$lang['voter_verified_title'] = 'Identitas Pemilih Terverifikasi';
$lang['voter_verified_desc']  = 'Data Anda telah terdaftar resmi dalam DPT. Silakan pilih calon pemimpin di bawah ini.';
$lang['registered_in_dpt']    = 'Terdaftar di DPT';
$lang['status_has_voted']     = 'Sudah Memilih';
$lang['status_not_voted']     = 'Belum Memilih';
$lang['step1_admin_title']    = 'Langkah 1: Pilih / Verifikasi Identitas Pemilih';
$lang['step1_admin_desc']     = 'Pilih salah satu pemilih yang belum menggunakan hak suara untuk simulasi pencoblosan langsung.';
$lang['unvoted_count_badge']  = 'Pemilih Belum Memilih';
$lang['select_voter_label']   = 'Pilih Pemilih dari Daftar DPT:';
$lang['select_voter_placeholder'] = '-- Silakan Pilih Pemilih yang Belum Memilih --';
$lang['unvoted_only_note']    = 'Daftar ini hanya menampilkan pemilih dengan status Belum Memilih.';
$lang['select_voter_warning'] = 'Pilih pemilih di samping terlebih dahulu sebelum mencoblos!';
$lang['step2_ballot_title']   = 'Langkah 2: Surat Suara Elektronik';
$lang['step2_ballot_desc']    = 'Tentukan pilihan Anda pada salah satu pasangan calon di bawah ini:';
$lang['btn_vote_this']        = 'COBLOS PASLON';
$lang['confirm_vote_title']   = 'Konfirmasi Pencoblosan';
$lang['confirm_vote_subtitle']= 'Apakah Anda yakin dengan pilihan ini?';
$lang['vote_irreversible_note'] = 'Setelah dikonfirmasi, hak suara Anda akan tercatat dan tidak dapat diubah kembali.';
$lang['btn_confirm_vote']     = 'Ya, Coblos Sekarang!';
$lang['btn_cancel']           = 'Batal';
$lang['voter_not_selected_title'] = 'Pemilih Belum Dipilih!';
$lang['voter_not_selected_msg']   = 'Silakan pilih nama pemilih pada kotak Langkah 1 di atas terlebih dahulu.';
$lang['btn_understand']       = 'Mengerti';

// Candidates CRUD
$lang['candidate_registry']   = 'Data Pasangan Calon (Kandidat)';
$lang['add_candidate_title']  = 'Tambah Pasangan Calon Baru';
$lang['edit_candidate_title'] = 'Edit Data Pasangan Calon';
$lang['candidate_profile_title'] = 'Profil Lengkap Pasangan Calon';
$lang['candidate_form']       = 'Formulir Pendaftaran Pasangan Calon';
$lang['ballot_number']        = 'Nomor Urut';
$lang['ballot_no']            = 'No. Urut';
$lang['ballot_no_upper']      = 'NO. URUT';
$lang['chairman']             = 'Calon Ketua';
$lang['vice_chairman']        = 'Calon Wakil Ketua';
$lang['vision']               = 'Visi';
$lang['mission']              = 'Misi';
$lang['theme_color']          = 'Warna Identitas Paslon';
$lang['photo']                = 'Foto Paslon';
$lang['official_ballot_no']   = 'Nomor urut resmi pasangan calon.';
$lang['color_badge_desc']     = 'Warna badge & grafik chart.';
$lang['photo_desc']           = 'Format: JPG/PNG, maks 3MB.';
$lang['main_vision']          = 'Visi Utama:';
$lang['no_candidates_yet']    = 'Belum Ada Data Pasangan Calon';
$lang['no_candidates_desc']   = 'Silakan tambahkan data pasangan calon pertama untuk memulai pemilihan.';
$lang['candidate_recap_table']= 'Tabel Rekap Data Kandidat';
$lang['votes_acquired']       = 'Perolehan Suara';
$lang['percentage']           = 'Persentase';
$lang['confirm_delete_candidate'] = 'Apakah Anda yakin ingin menghapus kandidat no. urut %s? Suara terkait juga akan dihapus.';
$lang['save_candidate']       = 'Simpan Kandidat';
$lang['save_changes']         = 'Simpan Perubahan';

// Voters DPT CRUD
$lang['voter_registry']       = 'Data Pemilih Tetap (DPT)';
$lang['add_voter_title']      = 'Tambah Pemilih Baru (DPT)';
$lang['edit_voter_title']     = 'Edit Data Pemilih';
$lang['voter_form']           = 'Formulir Data Pemilih';
$lang['voter_code']           = 'Kode Pemilih / NIM / NIS';
$lang['voter_name']           = 'Nama Lengkap';
$lang['gender']               = 'Jenis Kelamin';
$lang['gender_m']             = 'Laki-laki (L)';
$lang['gender_f']             = 'Perempuan (P)';
$lang['class_or_dept']        = 'Kelas / Jurusan / Unit';
$lang['card_uid']             = 'UID Kartu (RFID / NFC)';
$lang['card_uid_optional']    = '(Opsional untuk Login Tap)';
$lang['voter_code_desc']      = 'Kode unik identifikasi pemilih.';
$lang['card_uid_desc']        = 'ID kartu unik untuk login cepat dengan sistem tempel kartu (RFID Reader USB/NFC).';
$lang['save_voter']           = 'Simpan Pemilih';
$lang['voting_rights_status'] = 'Status Hak Suara:';
$lang['reset_all_votes']      = 'Reset Semua Suara';
$lang['confirm_reset_all']    = 'PERINGATAN: Ini akan mereset status memilih SEMUA pemilih dan mengosongkan suara yang sudah masuk. Lanjutkan?';
$lang['registered_voters_list'] = 'Daftar Pemilih Terdaftar';
$lang['search_voters']        = 'Cari Pemilih:';

// Print Recap & Docs
$lang['print_recap_title']    = 'Berita Acara & Rekapitulasi Hasil Penghitungan Suara E-Voting';
$lang['back_to_dashboard']    = 'Kembali ke Dashboard';
$lang['print_pdf_hint']       = 'Anda dapat mencetak langsung atau simpan sebagai dokumen PDF.';
$lang['print_save_pdf']       = 'Cetak / Simpan PDF';
$lang['committee_title']      = 'PANITIA PEMILIHAN SUARA ELEKTRONIK (E-VOTING)';
$lang['kpu_title']            = 'KOMISI PEMILIHAN UMUM (KPU)';
$lang['system_tagline_doc']   = 'Sistem Administrasi Pemilihan Digital Terpadu Berbasis Real Count & Kartu RFID';
$lang['minutes_doc_title']    = 'BERITA ACARA REKAPITULASI HASIL PENGHITUNGAN SUARA';
$lang['winner_badge']         = 'PEMENANG / TERPILIH';
$lang['runner_up']            = 'RUNNER UP';
$lang['docs_title']           = 'Dokumentasi Sistem & Arsitektur &mdash; Simple E-Vote';

// Flash & System Messages
$lang['msg_login_required']   = 'Silakan login terlebih dahulu untuk mengakses sistem E-Voting.';
$lang['msg_admin_required']   = 'Akses ditolak! Fitur ini hanya dapat diakses oleh Administrator.';
$lang['msg_welcome_role']     = 'Selamat datang, %s! Anda login sebagai %s.';
$lang['msg_invalid_credentials'] = 'Username atau password tidak sesuai. Silakan periksa kembali!';
$lang['msg_already_logged_in']= 'Anda sudah dalam keadaan login.';
$lang['msg_tap_card_prompt']  = 'Silakan tempelkan kartu ID / RFID Anda!';
$lang['msg_card_verified_welcome'] = 'Kartu ID Terverifikasi! Selamat datang, %s (%s).';
$lang['msg_card_unregistered']= 'Kartu ID (%s) tidak terdaftar di sistem E-Voting!';
$lang['msg_select_candidate_required'] = 'Silakan tentukan pasangan calon yang ingin dicoblos.';
$lang['msg_invalid_voter']    = 'Data pemilih tidak valid.';
$lang['msg_voter_already_voted'] = 'Pemilih %s (%s) sudah menggunakan hak suaranya sebelumnya.';
$lang['msg_invalid_candidate']= 'Kandidat yang dipilih tidak valid.';
$lang['msg_vote_cast_success']= 'Selamat! Hak suara pemilih %s telah berhasil digunakan untuk mencoblos Paslon No. %s!';
$lang['msg_vote_error']       = 'Terjadi kesalahan sistem saat merekam suara. Silakan coba lagi.';
$lang['msg_candidate_added']  = 'Pasangan calon no. urut %s berhasil ditambahkan!';
$lang['msg_candidate_updated']= 'Data kandidat berhasil diperbarui!';
$lang['msg_candidate_deleted']= 'Kandidat no. urut %s (%s) berhasil dihapus.';
$lang['msg_candidate_not_found'] = 'Data kandidat tidak ditemukan.';
$lang['msg_candidate_number_taken'] = 'Nomor urut %s sudah dipakai kandidat lain.';
$lang['msg_photo_upload_error'] = 'Gagal upload foto: ';
$lang['msg_voter_added']      = 'Pemilih %s (%s) berhasil didaftarkan!';
$lang['msg_voter_updated']    = 'Data pemilih berhasil diperbarui!';
$lang['msg_voter_deleted']    = 'Pemilih %s berhasil dihapus.';
$lang['msg_voter_not_found']  = 'Data pemilih tidak ditemukan.';
$lang['msg_voter_code_taken'] = 'Kode pemilih %s sudah digunakan oleh pemilih lain.';
$lang['msg_card_uid_taken']   = 'UID Kartu %s sudah dipakai oleh pemilih lain.';
$lang['msg_voter_status_reset'] = 'Status pemilih %s telah di-reset menjadi Belum Memilih.';
$lang['msg_all_votes_reset']  = 'Semua data suara berhasil di-reset! Semua pemilih kembali berstatus Belum Memilih.';

// Validation rules
$lang['field_required']       = '%s wajib diisi.';
$lang['field_numeric']        = '%s harus berupa angka.';
$lang['field_unique_candidate'] = '%s sudah digunakan oleh pasangan calon lain.';
$lang['field_unique_voter']   = '%s sudah terdaftar di sistem.';

// Common
$lang['save']                 = 'Simpan';
$lang['cancel']               = 'Batal';
$lang['edit']                 = 'Edit';
$lang['delete']               = 'Hapus';
$lang['detail']               = 'Detail';
$lang['back']                 = 'Kembali';
$lang['status']               = 'Status';
$lang['action']               = 'Aksi';
$lang['language']             = 'Bahasa';
$lang['home']                 = 'Beranda';
$lang['success']              = 'Berhasil!';
$lang['close']                = 'Tutup';

// WebSocket & Real-time Live Preview
$lang['ws_connected']         = 'WebSocket: Siaran Langsung (Live)';
$lang['ws_polling_fallback']  = 'Fallback Polling (Aktif)';
$lang['ws_connecting']        = 'Menghubungkan WebSocket...';
$lang['ws_disconnected']      = 'WebSocket Terputus';
$lang['live_preview_title']   = 'Preview Persentase & Perolehan Suara';
$lang['live_preview_desc']    = 'Preview perolehan suara paslon terupdate realtime via WebSocket';
$lang['turnout_rate']         = 'Tingkat Partisipasi Pemilih';
$lang['total_ballots_cast']   = 'Total Suara Masuk';
$lang['view_full_dashboard']  = 'Buka Dashboard Live Count Lengkap';
$lang['ws_stream_card_title'] = 'Mesin Siaran Real-Time WebSocket';
$lang['ws_server_url']        = 'URL Server';
$lang['ws_mode']              = 'Mode Siaran';
$lang['ws_last_event']        = 'Event Siaran Terakhir';
$lang['ws_test_trigger']      = 'Uji Siaran Push';
$lang['ws_engine_badge']      = 'Engine Native RFC 6455';

