# Quick Reference

Quick reference guide for the AdminerExportCommand plugin.

## Installation (30 seconds)

```bash
# 1. Download required files
wget https://www.adminer.org/latest.php -O adminer.php
mkdir plugins
wget https://raw.githubusercontent.com/vrana/adminer/master/plugins/plugin.php -O plugins/plugin.php

# 2. Copy plugin
cp AdminerExportCommand.php plugins/

# 3. Create loader (save as plugin.php)
# See examples/plugin.php for the code

# 4. Access
# http://localhost/plugin.php
```

## Usage (3 steps)

1. **Go to SQL command** page in Adminer
2. **Select format**: SQL, JavaScript, or Text
3. **Click** "Export Command" button

## Export Formats

| Format | Extension | Use Case |
|--------|-----------|----------|
| SQL | `.sql` | Database scripts, backups |
| JavaScript | `.js` | Node.js apps, web development |
| Text | `.txt` | Documentation, sharing |

## File Output

All exports include:
- ✓ Original query
- ✓ Export timestamp
- ✓ Database driver info
- ✓ Format-specific enhancements

**Filename format**: `query_YYYY-MM-DD_HHmmss.ext`

## Example Output

### SQL
```sql
-- Exported from Adminer
-- Date: 2025-11-05 14:30:22
-- Database driver: mysql

SELECT * FROM users;
```

### JavaScript
```javascript
const sqlQuery = `
SELECT * FROM users
`;
// Example: db.query(sqlQuery);
```

### Text
```
Exported from Adminer
Date: 2025-11-05 14:30:22
Database driver: mysql
===========================================

SELECT * FROM users
```

## Common Commands

```bash
# Test installation
php tests/validate.php

# Check PHP syntax
php -l AdminerExportCommand.php

# View plugin info
php -r "require 'AdminerExportCommand.php'; print_r(get_class_methods('AdminerExportCommand'));"
```

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Plugin not showing | Access via `plugin.php`, not `adminer.php` |
| Export not working | Check browser console for errors |
| Wrong file format | Verify radio button selection |
| Permission denied | Check PHP file permissions: `chmod 644` |

## Requirements

- ✓ PHP 5.6+ (7.x, 8.x recommended)
- ✓ Adminer 4.0+
- ✓ No additional dependencies

## Directory Structure

```
your-directory/
├── plugin.php                    # Your loader
├── adminer.php                   # Adminer core
└── plugins/
    ├── plugin.php                # Adminer plugin base
    └── AdminerExportCommand.php  # This plugin
```

## Plugin Methods

| Method | Purpose |
|--------|---------|
| `selectQuery()` | Handles export request |
| `fieldset()` | Renders export UI |
| `exportCommand()` | Generates download |
| `getMimeType()` | Returns MIME type |
| `prepareContent()` | Formats output |

## Configuration

No configuration needed! The plugin works out of the box.

Optional customization points (requires code editing):
- Filename prefix (default: `query_`)
- Date format (default: `Y-m-d_His`)
- Export formats (default: sql, js, txt)
- Metadata fields

## Links

- **Full Documentation**: [README.md](README.md)
- **Installation Guide**: [INSTALL.md](INSTALL.md)
- **Examples**: [examples/README.md](examples/README.md)
- **Visual Guide**: [VISUAL_GUIDE.md](VISUAL_GUIDE.md)
- **Tests**: [tests/README.md](tests/README.md)
- **Contributing**: [CONTRIBUTING.md](CONTRIBUTING.md)
- **Changelog**: [CHANGELOG.md](CHANGELOG.md)

## License

Apache License 2.0 - See [LICENSE](LICENSE)

## Support

- 🐛 **Bug Reports**: Open an issue on GitHub
- 💡 **Feature Requests**: Open an issue on GitHub
- 📖 **Documentation**: Read the guides in this repo
- 🤝 **Contributing**: See [CONTRIBUTING.md](CONTRIBUTING.md)

## Credits

Created by rlaiola for the Adminer community.
