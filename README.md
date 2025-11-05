# Adminer Export Command

A powerful plugin for [Adminer](https://www.adminer.org/) that enhances the SQL editor by adding an 'Export' fieldset, allowing users to download their current SQL query as a downloadable file in multiple formats (.sql, .js, or .txt) depending on the database driver.

## Features

- **Multiple Export Formats**: Export your SQL queries as:
  - `.sql` - SQL script with metadata comments
  - `.js` - JavaScript file with query wrapped in a constant
  - `.txt` - Plain text file with query and metadata
  
- **Automatic Metadata**: Each export includes:
  - Export timestamp
  - Database driver information
  - Helpful comments and formatting

- **One-Click Export**: Simple interface integrated directly into the SQL command page

- **Format-Specific Handling**: 
  - SQL files include proper semicolon termination
  - JavaScript files provide example usage code
  - Text files have clear, readable formatting

## Installation

### Method 1: Direct Include

1. Download the `AdminerExportCommand.php` file
2. Include it in your Adminer setup using a plugin loader file

Create or modify your `plugin.php`:

```php
<?php
function adminer_object() {
    // Required for plugins
    include_once "./plugins/plugin.php";
    
    // Load the Export Command plugin
    include_once "./plugins/AdminerExportCommand.php";
    
    // Initialize plugins
    return new AdminerPlugin(array(
        new AdminerExportCommand(),
        // Add other plugins here
    ));
}

// Include Adminer
include "./adminer.php";
?>
```

### Method 2: Single File Setup

Place the plugin in your plugins directory structure:

```
your-adminer-directory/
├── adminer.php
├── plugin.php (your loader)
└── plugins/
    ├── plugin.php (Adminer's plugin base class)
    └── AdminerExportCommand.php
```

## Usage

1. **Navigate to SQL Command**: Open Adminer and go to the "SQL command" page
2. **Write Your Query**: Enter your SQL query in the text area
3. **Select Export Format**: In the 'Export' fieldset below the query, choose your desired format:
   - SQL (.sql) - for SQL scripts
   - JavaScript (.js) - for use in Node.js or browser applications  
   - Text (.txt) - for documentation or sharing
4. **Click Export**: Click the "Export Command" button
5. **Download**: Your query will be downloaded with a timestamped filename like `query_2025-11-05_143022.sql`

## Example Exports

### SQL Format (.sql)

When you export a query as SQL, you get:

```sql
-- Exported from Adminer
-- Date: 2025-11-05 14:30:22
-- Database driver: server

SELECT * FROM users WHERE active = 1;
```

### JavaScript Format (.js)

When you export as JavaScript, you get:

```javascript
// Exported from Adminer
// Date: 2025-11-05 14:30:22
// Database driver: mysql

const sqlQuery = `
SELECT * FROM users WHERE active = 1
`;

// Execute this query using your preferred database library
// Example: db.query(sqlQuery);
```

### Text Format (.txt)

When you export as plain text, you get:

```
Exported from Adminer
Date: 2025-11-05 14:30:22
Database driver: server
===========================================

SELECT * FROM users WHERE active = 1
```

## Requirements

- PHP 5.6 or higher
- Adminer 4.0 or higher
- Adminer plugin support enabled

## Configuration

The plugin works out of the box with no configuration needed. It automatically:
- Detects the current database driver
- Generates timestamped filenames
- Applies appropriate MIME types for each format

## Use Cases

- **Backup Queries**: Save frequently used queries for future reference
- **Share SQL**: Export and share queries with team members
- **Documentation**: Generate text exports for documentation purposes
- **Application Integration**: Export as JavaScript for use in Node.js applications
- **Version Control**: Save SQL queries in version control systems

## Compatibility

This plugin is compatible with:
- All Adminer-supported database drivers (MySQL, PostgreSQL, SQLite, MS SQL, Oracle, etc.)
- Adminer versions 4.0 and above
- PHP 5.6, 7.x, and 8.x

## License

This project is licensed under the Apache License 2.0 - see the LICENSE file for details.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For issues, questions, or suggestions, please open an issue on the GitHub repository.

## Author

Created by rlaiola

## Acknowledgments

- Built for the [Adminer](https://www.adminer.org/) database management tool
- Inspired by the need for easy SQL query export functionality
