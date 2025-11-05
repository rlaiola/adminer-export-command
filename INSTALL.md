# Quick Installation Guide

Get the Adminer Export Command plugin up and running in minutes!

## Prerequisites

- Web server with PHP 5.6 or higher
- Adminer 4.0 or higher
- Basic knowledge of PHP and Adminer

## Installation Steps

### Step 1: Download Required Files

Download the following files:

1. **Adminer** (if you don't have it):
   ```bash
   wget https://www.adminer.org/latest.php -O adminer.php
   ```

2. **Adminer Plugin Base Class**:
   ```bash
   mkdir plugins
   wget https://raw.githubusercontent.com/vrana/adminer/master/plugins/plugin.php -O plugins/plugin.php
   ```

3. **AdminerExportCommand Plugin**:
   - Download `AdminerExportCommand.php` from this repository
   - Place it in the `plugins/` directory

### Step 2: Create Plugin Loader

Create a file named `plugin.php` in your web directory with this content:

```php
<?php
function adminer_object() {
    include_once "./plugins/plugin.php";
    include_once "./plugins/AdminerExportCommand.php";
    
    return new AdminerPlugin(array(
        new AdminerExportCommand(),
    ));
}

include "./adminer.php";
?>
```

### Step 3: Verify Directory Structure

Your directory should look like this:

```
your-web-directory/
├── plugin.php          (your loader file)
├── adminer.php         (Adminer core)
└── plugins/
    ├── plugin.php      (Adminer's plugin base)
    └── AdminerExportCommand.php
```

### Step 4: Access Adminer

Open your browser and navigate to:
```
http://your-server/path/to/plugin.php
```

**Important**: Access `plugin.php`, NOT `adminer.php` directly!

### Step 5: Test the Plugin

1. Log in to your database
2. Go to "SQL command"
3. You should see an "Export" fieldset below the query textarea
4. Write a query and test the export functionality

## Quick Test

Try this simple query:

```sql
SELECT * FROM information_schema.tables LIMIT 10
```

Then:
1. Select "SQL (.sql)" format
2. Click "Export Command"
3. A file should download with your query

## Troubleshooting

### Plugin not showing?

**Check 1**: Are you accessing `plugin.php` or `adminer.php`?
- ✅ Use: `http://localhost/plugin.php`
- ❌ Don't use: `http://localhost/adminer.php`

**Check 2**: Verify file paths in `plugin.php`
- Paths should be relative to where `plugin.php` is located
- Use `./plugins/` not `plugins/` if they're in the same directory

**Check 3**: Check file permissions
```bash
chmod 644 plugin.php
chmod 644 plugins/*.php
```

**Check 4**: Enable error reporting
Add to the top of `plugin.php`:
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Export button doesn't work?

**Check 1**: Look at browser console for JavaScript errors

**Check 2**: Verify PHP can send headers
- Make sure there's no output before the plugin code
- Check for BOM (Byte Order Mark) in PHP files

**Check 3**: Check browser download settings
- Some browsers block automatic downloads
- Check your downloads folder

### Wrong format downloaded?

**Check**: Make sure you selected the correct radio button before clicking Export

## Alternative: Single-File Installation

If you prefer, you can integrate the plugin directly:

```php
<?php
// Include the plugin class directly
class AdminerExportCommand {
    // ... (copy the entire class here)
}

function adminer_object() {
    return new AdminerPlugin(array(
        new AdminerExportCommand(),
    ));
}

include "./adminer.php";
?>
```

## Next Steps

- Read the full [README.md](README.md) for detailed documentation
- Check the [examples/](examples/) directory for practical examples
- See [CONTRIBUTING.md](CONTRIBUTING.md) if you want to contribute

## Need Help?

- Open an issue on GitHub
- Check the [Adminer documentation](https://www.adminer.org/)
- Review the examples in the `examples/` directory

## Success!

If everything works, you should be able to:
- ✅ See the Export fieldset on the SQL command page
- ✅ Select different export formats
- ✅ Download queries as .sql, .js, or .txt files
- ✅ See proper metadata in exported files

Happy querying! 🎉
