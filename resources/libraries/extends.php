<?php

$sections = [];   // Store section data
$activeSection = null; // Track active section

// Start capturing content for a section
function startSection(string $name) {
    global $sections, $activeSection;
    $activeSection = $name; 
    ob_start(); // Start output buffering
}

// Stop capturing and save content
function endSection() {
    global $sections, $activeSection;
    
    if ($activeSection === null) {
        throw new Exception("endSection() called without matching startSection()");
    }
    
    $sections[$activeSection] = ob_get_clean();
    $activeSection = null; // Reset active section
}

// Render a section
function yieldSection(string $name) {
    global $sections;
    echo $sections[$name] ?? '';  // Default to empty if not defined
}
function extendLayout($layout, $data=[]) {
    extract($data);
    include ABSPATH.'resources/views/'.$layout.'.php';
}
function asset($path) {
   // Detect HTTP or HTTPS dynamically
   $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
   // Get the base domain (e.g., example.com or localhost)
   $host = $_SERVER['HTTP_HOST'];
   // Detect subfolder dynamically
   $script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
   // Construct the full asset URL
   return $protocol . '://' . $host . rtrim($script_dir, '/') . '/' . ltrim($path, '/');
    
}
//base
function baseUrl($path='') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $script_dir = str_replace('/public', '', $script_dir);
    return $protocol . '://' . $host . rtrim($script_dir, '/') . '/' . ltrim($path, '/');
}
//include function
function includeFile($file) {
    include ABSPATH.'resources/views/'.$file.'.php';
}