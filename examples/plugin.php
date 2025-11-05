<?php
/**
 * Example Plugin Loader for Adminer with AdminerExportCommand
 * 
 * This file demonstrates how to load Adminer with the Export Command plugin.
 * Place this file in your web root and access it instead of adminer.php directly.
 * 
 * Directory structure:
 * /
 * ├── plugin.php (this file)
 * ├── adminer.php
 * └── plugins/
 *     ├── plugin.php (Adminer's base plugin class)
 *     └── AdminerExportCommand.php
 */

function adminer_object() {
    // Load Adminer's plugin base class
    // Download from: https://raw.githubusercontent.com/vrana/adminer/master/plugins/plugin.php
    include_once "./plugins/plugin.php";
    
    // Load the Export Command plugin
    include_once "./plugins/AdminerExportCommand.php";
    
    // You can add more plugins here
    // include_once "./plugins/AnotherPlugin.php";
    
    // Initialize and return plugin configuration
    return new AdminerPlugin(array(
        // Enable the Export Command plugin
        new AdminerExportCommand(),
        
        // Add more plugins here as needed
        // new AnotherPlugin(),
    ));
}

// Include the main Adminer file
// Download Adminer from: https://www.adminer.org/
include "./adminer.php";
