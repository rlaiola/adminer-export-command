<?php
/**
 * Adminer Export Command Plugin
 * 
 * Adds an 'Export' fieldset to the SQL editor, allowing users to download 
 * the current query as a .sql, .js, or .txt file depending on the DB driver.
 * 
 * @author rlaiola
 * @license Apache-2.0
 */
class AdminerExportCommand {
    /**
     * Add export fieldset to SQL command page
     * 
     * @param string $query Current SQL query
     * @return bool
     */
    function selectQuery($query, $start, $failed = false) {
        if ($_GET["sql"] !== null) {
            // Check if export was requested
            if (isset($_POST["export_command"])) {
                $this->exportCommand($_POST["query"]);
                return true;
            }
        }
        return false;
    }
    
    /**
     * Add export fieldset after the query form
     * 
     * @param string $id Fieldset identifier
     */
    function fieldset($id) {
        if ($id == "sql") {
            echo "<fieldset>";
            echo "<legend>" . 'Export' . "</legend>";
            echo "<div>";
            echo "<label><input type='radio' name='export_format' value='sql' checked> SQL (.sql)</label> ";
            echo "<label><input type='radio' name='export_format' value='js'> JavaScript (.js)</label> ";
            echo "<label><input type='radio' name='export_format' value='txt'> Text (.txt)</label>";
            echo "</div>";
            echo "<div style='margin-top: 10px;'>";
            echo "<input type='submit' name='export_command' value='Export Command'>";
            echo "</div>";
            echo "</fieldset>";
        }
    }
    
    /**
     * Export the SQL command as a downloadable file
     * 
     * @param string $query SQL query to export
     */
    private function exportCommand($query) {
        // Validate export format
        $allowedFormats = array("sql", "js", "txt");
        $format = isset($_POST["export_format"]) ? $_POST["export_format"] : "sql";
        if (!in_array($format, $allowedFormats, true)) {
            $format = "sql"; // Default to SQL if invalid format provided
        }
        
        // Sanitize driver parameter
        $driver = isset($_GET["driver"]) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET["driver"]) : "server";
        if (empty($driver)) {
            $driver = "server";
        }
        
        // Validate and sanitize query
        if (empty($query) || !is_string($query)) {
            $query = "-- No query provided";
        }
        
        // Determine file extension and MIME type based on format and driver
        $extension = $format;
        $mimeType = $this->getMimeType($format);
        
        // Generate safe filename (RFC 6266 compliant)
        $timestamp = date("Y-m-d_His");
        $filename = "query_" . $timestamp . "." . $extension;
        // Ensure filename only contains safe characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Prepare content based on format
        $content = $this->prepareContent($query, $format, $driver);
        
        // Send headers for download
        header("Content-Type: " . $mimeType);
        header("Content-Disposition: attachment; filename=\"" . addslashes($filename) . "\"");
        header("Content-Length: " . strlen($content));
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("X-Content-Type-Options: nosniff");
        
        echo $content;
        exit;
    }
    
    /**
     * Get MIME type for the export format
     * 
     * @param string $format Export format (sql, js, txt)
     * @return string MIME type
     */
    private function getMimeType($format) {
        $mimeTypes = array(
            "sql" => "application/sql",
            "js" => "application/javascript",
            "txt" => "text/plain"
        );
        
        return isset($mimeTypes[$format]) ? $mimeTypes[$format] : "text/plain";
    }
    
    /**
     * Prepare content for export based on format and driver
     * 
     * @param string $query SQL query
     * @param string $format Export format (sql, js, txt)
     * @param string $driver Database driver
     * @return string Formatted content
     */
    private function prepareContent($query, $format, $driver) {
        // Escape special characters in driver name for output
        $driver = htmlspecialchars($driver, ENT_QUOTES, 'UTF-8');
        
        if ($format == "sql") {
            // Add SQL comment with metadata
            $content = "-- Exported from Adminer\n";
            $content .= "-- Date: " . date("Y-m-d H:i:s") . "\n";
            $content .= "-- Database driver: " . $driver . "\n\n";
            $content .= $query;
            
            // Ensure query ends with semicolon
            if (!preg_match('/;\s*$/', $query)) {
                $content .= ";";
            }
            $content .= "\n";
            
        } elseif ($format == "js") {
            // Wrap query in JavaScript variable or function
            $content = "// Exported from Adminer\n";
            $content .= "// Date: " . date("Y-m-d H:i:s") . "\n";
            $content .= "// Database driver: " . $driver . "\n\n";
            $content .= "const sqlQuery = `\n";
            $content .= $query;
            $content .= "\n`;\n\n";
            $content .= "// Execute this query using your preferred database library\n";
            $content .= "// Example: db.query(sqlQuery);\n";
            
        } else {
            // Plain text format
            $content = "Exported from Adminer\n";
            $content .= "Date: " . date("Y-m-d H:i:s") . "\n";
            $content .= "Database driver: " . $driver . "\n";
            $content .= "===========================================\n\n";
            $content .= $query . "\n";
        }
        
        return $content;
    }
}
