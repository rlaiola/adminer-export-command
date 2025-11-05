# Changelog

All notable changes to the Adminer Export Command plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-11-05

### Added
- Initial release of AdminerExportCommand plugin
- Support for exporting SQL queries in three formats:
  - `.sql` - SQL script format with metadata comments
  - `.js` - JavaScript format with query wrapped in const variable
  - `.txt` - Plain text format with clear formatting
- Export fieldset integrated into SQL command page
- Automatic metadata inclusion (timestamp, database driver)
- Format-specific content preparation:
  - SQL: automatic semicolon termination
  - JavaScript: usage examples with popular Node.js libraries
  - Text: clean, readable formatting with visual separators
- Timestamped filename generation (e.g., `query_2025-11-05_143022.sql`)
- Proper MIME type handling for each export format
- Comprehensive documentation in README.md
- Practical examples in `examples/` directory:
  - `plugin.php` - Example plugin loader
  - `example_export.sql` - Sample SQL export
  - `example_export.js` - Sample JavaScript export
  - `example_export.txt` - Sample text export
  - `examples/README.md` - Detailed examples documentation
- Apache License 2.0
- Contributing guidelines in CONTRIBUTING.md

### Features
- One-click export from SQL command page
- Radio button format selection
- Compatible with all Adminer-supported database drivers
- Works with PHP 5.6, 7.x, and 8.x
- No configuration required

### Documentation
- Complete installation instructions
- Usage guide with examples
- Example exports for all three formats
- Integration examples for various use cases
- Troubleshooting section
- Compatibility information

## [Unreleased]

### Planned Features
- Custom filename prefix option
- Option to include database name in filename
- Support for batch query export
- Export query results alongside query
- Custom date format configuration
- Additional export formats (JSON, XML)
- Configurable metadata fields
- Export history/favorites

---

## Version History Summary

- **1.0.0** (2025-11-05): Initial release with core export functionality

## Migration Guide

### From No Plugin to v1.0.0

1. Download `AdminerExportCommand.php`
2. Set up plugin loader as shown in `examples/plugin.php`
3. Access Adminer via your plugin loader file
4. The Export fieldset will automatically appear on the SQL command page

No database changes or configuration required!
