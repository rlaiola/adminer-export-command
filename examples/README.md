# Examples

This directory contains practical examples for using the AdminerExportCommand plugin.

## Files

### plugin.php
An example plugin loader file that demonstrates how to integrate AdminerExportCommand with Adminer. This file shows the proper directory structure and initialization code needed to enable the plugin.

**Usage**: Copy this file to your Adminer installation directory and access it instead of `adminer.php` directly.

### Example Export Files

The following files demonstrate the output format for each export type:

#### example_export.sql
Shows how a SQL query is exported in `.sql` format with:
- Metadata comments (export date, database driver)
- Properly formatted SQL
- Semicolon termination

**Use case**: Sharing SQL queries, creating backups, version control

#### example_export.js
Shows how a SQL query is exported in `.js` format with:
- JavaScript comments with metadata
- Query wrapped in a const variable
- Usage examples for popular Node.js database libraries (mysql2, pg)

**Use case**: Integration with Node.js applications, JavaScript-based tools

#### example_export.txt
Shows how a SQL query is exported in `.txt` format with:
- Plain text metadata
- Clear visual separator
- Easy-to-read formatting

**Use case**: Documentation, email sharing, plain text editors

## Quick Start

1. **Download Adminer**: Get the latest version from https://www.adminer.org/

2. **Get the plugin base class**: Download from https://raw.githubusercontent.com/vrana/adminer/master/plugins/plugin.php

3. **Set up directory structure**:
   ```
   your-directory/
   ├── plugin.php (from this examples folder)
   ├── adminer.php
   └── plugins/
       ├── plugin.php (Adminer's base class)
       └── AdminerExportCommand.php (from repository root)
   ```

4. **Access Adminer**: Navigate to `plugin.php` in your browser (e.g., `http://localhost/plugin.php`)

5. **Use the Export feature**:
   - Go to "SQL command"
   - Write your query
   - Select export format (SQL, JS, or TXT)
   - Click "Export Command"

## Sample Query

All example export files use the following sample query:

```sql
SELECT 
    u.id,
    u.username,
    u.email,
    u.created_at,
    COUNT(o.id) as order_count,
    SUM(o.total) as total_spent
FROM 
    users u
LEFT JOIN 
    orders o ON u.id = o.user_id
WHERE 
    u.active = 1
    AND u.created_at >= '2024-01-01'
GROUP BY 
    u.id, u.username, u.email, u.created_at
HAVING 
    COUNT(o.id) > 0
ORDER BY 
    total_spent DESC
LIMIT 100
```

This query demonstrates:
- Multiple table joins
- Aggregation functions
- WHERE clause filtering
- GROUP BY and HAVING clauses
- Result ordering and limiting

## Integration Examples

### Using Exported SQL in MySQL

```bash
mysql -u username -p database_name < example_export.sql
```

### Using Exported JavaScript in Node.js

```javascript
// Import the exported query
const { sqlQuery } = require('./example_export.js');

// Use with your database connection
const results = await db.query(sqlQuery);
console.log(results);
```

### Using Exported Text in Documentation

Simply copy and paste the content from the `.txt` file into your documentation, wikis, or markdown files.

## Advanced Usage

### Custom Plugin Combinations

You can combine AdminerExportCommand with other Adminer plugins:

```php
function adminer_object() {
    include_once "./plugins/plugin.php";
    include_once "./plugins/AdminerExportCommand.php";
    include_once "./plugins/AdminerTheme.php";
    include_once "./plugins/AdminerLoginServers.php";
    
    return new AdminerPlugin(array(
        new AdminerExportCommand(),
        new AdminerTheme("default"),
        new AdminerLoginServers(['localhost', 'production.server.com']),
    ));
}

include "./adminer.php";
```

## Troubleshooting

### Plugin not appearing
- Verify directory structure matches the example
- Check that `plugin.php` (Adminer's base class) is in the plugins directory
- Ensure PHP has read permissions on all files

### Export not working
- Check browser console for JavaScript errors
- Verify PHP has permission to send headers (no output before the plugin)
- Ensure you're accessing via `plugin.php` not `adminer.php` directly

### Wrong format exported
- Verify the radio button selection before clicking Export
- Check browser's download settings

## Additional Resources

- [Adminer Documentation](https://www.adminer.org/)
- [Adminer Plugins Guide](https://www.adminer.org/en/plugins/)
- [Plugin Development](https://www.adminer.org/en/extension/)
