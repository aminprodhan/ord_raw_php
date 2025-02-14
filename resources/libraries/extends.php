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
function extendLayout($layout) {
    include ABSPATH.'resources/views/'.$layout.'.php';
}
