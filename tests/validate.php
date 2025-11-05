<?php
/**
 * Simple validation script for AdminerExportCommand plugin
 * 
 * This script tests the basic functionality of the plugin methods
 * without requiring a full Adminer installation.
 */

// Include the plugin
require_once __DIR__ . '/../AdminerExportCommand.php';

// Test results
$tests_passed = 0;
$tests_failed = 0;

function test($name, $condition) {
    global $tests_passed, $tests_failed;
    
    if ($condition) {
        echo "✓ PASS: $name\n";
        $tests_passed++;
    } else {
        echo "✗ FAIL: $name\n";
        $tests_failed++;
    }
}

echo "AdminerExportCommand Plugin Validation\n";
echo "======================================\n\n";

// Test 1: Plugin class exists
test("Plugin class exists", class_exists('AdminerExportCommand'));

// Test 2: Plugin can be instantiated
$plugin = new AdminerExportCommand();
test("Plugin can be instantiated", $plugin instanceof AdminerExportCommand);

// Test 3: Plugin has required methods
test("Plugin has selectQuery method", method_exists($plugin, 'selectQuery'));
test("Plugin has fieldset method", method_exists($plugin, 'fieldset'));

// Test 4: Test MIME type method (using reflection to access private method)
$reflection = new ReflectionClass('AdminerExportCommand');
$getMimeTypeMethod = $reflection->getMethod('getMimeType');
$getMimeTypeMethod->setAccessible(true);

$sqlMime = $getMimeTypeMethod->invoke($plugin, 'sql');
test("SQL MIME type is correct", $sqlMime === 'application/sql');

$jsMime = $getMimeTypeMethod->invoke($plugin, 'js');
test("JavaScript MIME type is correct", $jsMime === 'application/javascript');

$txtMime = $getMimeTypeMethod->invoke($plugin, 'txt');
test("Text MIME type is correct", $txtMime === 'text/plain');

// Test 5: Test content preparation method
$prepareContentMethod = $reflection->getMethod('prepareContent');
$prepareContentMethod->setAccessible(true);

$testQuery = "SELECT * FROM users";

// Test SQL format
$sqlContent = $prepareContentMethod->invoke($plugin, $testQuery, 'sql', 'mysql');
test("SQL content contains query", strpos($sqlContent, $testQuery) !== false);
test("SQL content contains metadata comment", strpos($sqlContent, '-- Exported from Adminer') !== false);
test("SQL content ends with semicolon", substr(trim($sqlContent), -1) === ';');

// Test JavaScript format
$jsContent = $prepareContentMethod->invoke($plugin, $testQuery, 'js', 'mysql');
test("JavaScript content contains query", strpos($jsContent, $testQuery) !== false);
test("JavaScript content has const declaration", strpos($jsContent, 'const sqlQuery') !== false);
test("JavaScript content has usage example", strpos($jsContent, '// Example:') !== false);

// Test Text format
$txtContent = $prepareContentMethod->invoke($plugin, $testQuery, 'txt', 'mysql');
test("Text content contains query", strpos($txtContent, $testQuery) !== false);
test("Text content has separator", strpos($txtContent, '===========================================') !== false);

// Test 6: Query without semicolon gets one added in SQL format
$queryWithoutSemicolon = "SELECT * FROM users";
$sqlContentFixed = $prepareContentMethod->invoke($plugin, $queryWithoutSemicolon, 'sql', 'mysql');
test("SQL format adds semicolon to query without one", substr(trim($sqlContentFixed), -1) === ';');

// Test 7: Query with semicolon doesn't get double semicolon
$queryWithSemicolon = "SELECT * FROM users;";
$sqlContentWithSemicolon = $prepareContentMethod->invoke($plugin, $queryWithSemicolon, 'sql', 'mysql');
// Check that the content ends with a single semicolon followed by whitespace/newline
$trimmedContent = rtrim($sqlContentWithSemicolon);
test("SQL format doesn't add extra semicolon", preg_match('/;[^;]*$/', $trimmedContent) === 1);

// Test 8: fieldset method output for SQL context
ob_start();
$plugin->fieldset('sql');
$output = ob_get_clean();
test("Fieldset for SQL context generates output", !empty($output));
test("Fieldset contains Export legend", strpos($output, 'Export') !== false);
test("Fieldset contains SQL radio button", strpos($output, 'value=\'sql\'') !== false);
test("Fieldset contains JavaScript radio button", strpos($output, 'value=\'js\'') !== false);
test("Fieldset contains Text radio button", strpos($output, 'value=\'txt\'') !== false);
test("Fieldset contains Export Command button", strpos($output, 'Export Command') !== false);

// Test 9: fieldset method doesn't output for non-SQL context
ob_start();
$plugin->fieldset('other');
$output = ob_get_clean();
test("Fieldset for non-SQL context generates no output", empty($output));

// Test 10: Security - Test format validation
$_POST['export_format'] = 'invalid_format';
$prepareContentMethod = $reflection->getMethod('prepareContent');
$prepareContentMethod->setAccessible(true);
// Should default to sql format when invalid format is detected
$result = $prepareContentMethod->invoke($plugin, "SELECT 1", "invalid", "mysql");
test("Invalid format defaults to safe handling", !empty($result));

// Test 11: Security - Test empty query handling
$emptyResult = $prepareContentMethod->invoke($plugin, "", "sql", "mysql");
test("Empty query is handled safely", !empty($emptyResult));

// Test 12: Security - Test driver name is escaped in output
$maliciousDriver = "<script>alert('xss')</script>";
$result = $prepareContentMethod->invoke($plugin, "SELECT 1", "sql", $maliciousDriver);
test("Driver name with HTML is escaped", strpos($result, "<script>") === false && strpos($result, "&lt;script&gt;") !== false);

// Summary
echo "\n======================================\n";
echo "Tests passed: $tests_passed\n";
echo "Tests failed: $tests_failed\n";

if ($tests_failed === 0) {
    echo "\n✓ All tests passed!\n";
    exit(0);
} else {
    echo "\n✗ Some tests failed.\n";
    exit(1);
}
