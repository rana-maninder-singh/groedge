<?php
/**
 * Load and save site config and form submissions.
 * DATA_DIR must be defined by the caller (e.g. __DIR__ . '/../data').
 */
if (!defined('DATA_DIR')) {
    define('DATA_DIR', __DIR__ . '/../data');
}

function get_config() {
    $path = DATA_DIR . '/site-config.json';
    if (!is_file($path)) {
        return get_config_defaults();
    }
    $json = file_get_contents($path);
    $data = json_decode($json);
    if (!is_object($data)) {
        // Fail closed for auth: do not fall back to an empty password hash.
        $fallback = get_config_defaults();
        $fallback->admin_password_hash = '!invalid!';
        return $fallback;
    }
    if (!isset($data->address) || !is_object($data->address)) {
        $data->address = (object) ['company' => '', 'line1' => '', 'line2' => '', 'country' => ''];
    }
    return $data;
}

function get_config_defaults() {
    return json_decode(json_encode([
        'contact_person' => 'Mr. Rajesh Pal',
        'contact_phone' => '+91 98702 55501',
        'contact_phone_raw' => '919870255501',
        'email_contact' => 'rajesh@groedge.in',
        'email_info' => 'info@groedge.in',
        'email_sales' => 'sales@groedge.in',
        'business_hours' => 'Mon-Fri: 9:00 AM - 6:00 PM IST',
        'address' => [
            'company' => 'GroEdge Management Consulting',
            'line1' => '123 Business Plaza, Sector 45',
            'line2' => 'Gurugram, Haryana 122001',
            'country' => 'India'
        ],
        'form_to_email' => 'info@groedge.in',
        'form_bcc' => 'rajesh@groedge.in, sales@groedge.in',
        'admin_password_hash' => ''
    ]));
}

/** Strip CR/LF so values cannot inject mail/HTTP headers. */
function sanitize_header_value($value) {
    return str_replace(["\r", "\n", "\0"], '', (string) $value);
}

function save_config($config) {
    $path = DATA_DIR . '/site-config.json';
    return file_put_contents($path, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

function get_submissions() {
    $path = DATA_DIR . '/submissions.json';
    if (!is_file($path)) {
        return [];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function save_submission($submission) {
    $submissions = get_submissions();
    $submission['id'] = uniqid('', true);
    $submission['submitted_at'] = date('Y-m-d H:i:s');
    array_unshift($submissions, $submission);
    $path = DATA_DIR . '/submissions.json';
    return file_put_contents($path, json_encode($submissions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

/**
 * Projects & achievements data (projects.json).
 * Structure: { "key_achievements": [ {"label":"15+","description":"Years Experience"} ], "projects": [ {"id":"...","title":"...","client":"...","industry":"...","year":"...","description":"...","achievements":["..."]} ] }
 */
function get_projects_data() {
    $path = DATA_DIR . '/projects.json';
    if (!is_file($path)) {
        return [
            'key_achievements' => [],
            'projects' => []
        ];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    if (!is_array($data)) {
        return ['key_achievements' => [], 'projects' => []];
    }
    $data['key_achievements'] = isset($data['key_achievements']) && is_array($data['key_achievements']) ? $data['key_achievements'] : [];
    $data['projects'] = isset($data['projects']) && is_array($data['projects']) ? $data['projects'] : [];
    return $data;
}

function save_projects_data($data) {
    $path = DATA_DIR . '/projects.json';
    return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

/**
 * Services page data (services.json).
 * Structure: page_title, page_intro, intro_paragraph, pillars[], approach_steps[], services[], cta_heading, cta_paragraph
 */
function get_services_data() {
    $path = DATA_DIR . '/services.json';
    if (!is_file($path)) {
        return [
            'page_title' => 'Strategic Consulting Services',
            'page_intro' => 'Our comprehensive suite of consulting services is designed to address the complete spectrum of operational challenges.',
            'intro_paragraph' => '',
            'pillars' => [],
            'approach_steps' => [],
            'services' => [],
            'cta_heading' => 'Which Operational Challenge Should We Address First?',
            'cta_paragraph' => 'Our initial consultation includes a high-level assessment of your operations and identification of priority improvement areas.'
        ];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    if (!is_array($data)) {
        return ['page_title' => '', 'page_intro' => '', 'intro_paragraph' => '', 'pillars' => [], 'approach_steps' => [], 'services' => [], 'cta_heading' => '', 'cta_paragraph' => ''];
    }
    $data['pillars'] = isset($data['pillars']) && is_array($data['pillars']) ? $data['pillars'] : [];
    $data['approach_steps'] = isset($data['approach_steps']) && is_array($data['approach_steps']) ? $data['approach_steps'] : [];
    $data['services'] = isset($data['services']) && is_array($data['services']) ? $data['services'] : [];
    return $data;
}

function save_services_data($data) {
    $path = DATA_DIR . '/services.json';
    return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}
