# Contributing to Adminer Export Command

Thank you for your interest in contributing to the Adminer Export Command plugin! We welcome contributions from the community.

## How to Contribute

### Reporting Bugs

If you find a bug, please open an issue with:
- A clear, descriptive title
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- Your environment (PHP version, Adminer version, database driver)
- Screenshots if applicable

### Suggesting Enhancements

We welcome feature requests! Please open an issue with:
- A clear, descriptive title
- Detailed description of the proposed feature
- Use cases that would benefit from this feature
- Any relevant examples or mockups

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Make your changes**:
   - Follow the existing code style
   - Add comments for complex logic
   - Test your changes with multiple database drivers
3. **Update documentation**:
   - Update README.md if you add features
   - Add examples if applicable
   - Update comments in code
4. **Test thoroughly**:
   - Test with different PHP versions (5.6, 7.x, 8.x)
   - Test with different database drivers (MySQL, PostgreSQL, SQLite, etc.)
   - Test all export formats (.sql, .js, .txt)
5. **Commit your changes**:
   - Use clear, descriptive commit messages
   - Reference any related issues
6. **Submit a pull request**

## Code Style Guidelines

- Use 4 spaces for indentation (no tabs)
- Follow PSR-12 coding standards where applicable
- Add PHPDoc comments for all methods
- Keep methods focused and single-purpose
- Use descriptive variable names

### Example:

```php
/**
 * Export the SQL command as a downloadable file
 * 
 * @param string $query SQL query to export
 * @return void
 */
private function exportCommand($query) {
    // Implementation
}
```

## Testing

Before submitting a PR, please test:

1. **All export formats**: .sql, .js, .txt
2. **Different queries**: Simple SELECT, complex JOINs, INSERT, UPDATE, DELETE
3. **Multiple database drivers**: At least MySQL and one other (PostgreSQL, SQLite, etc.)
4. **Edge cases**: 
   - Very long queries
   - Queries with special characters
   - Queries without semicolons
   - Empty queries

## Development Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/rlaiola/adminer-export-command.git
   cd adminer-export-command
   ```

2. Set up a local Adminer instance:
   ```bash
   # Download Adminer
   wget https://www.adminer.org/latest.php -O adminer.php
   
   # Download plugin base class
   mkdir plugins
   wget https://raw.githubusercontent.com/vrana/adminer/master/plugins/plugin.php -O plugins/plugin.php
   
   # Copy the plugin
   cp AdminerExportCommand.php plugins/
   
   # Copy the example loader
   cp examples/plugin.php .
   ```

3. Start a local PHP server:
   ```bash
   php -S localhost:8000
   ```

4. Access Adminer at `http://localhost:8000/plugin.php`

## Code Review Process

All pull requests will be reviewed by maintainers. We'll check for:
- Code quality and style
- Functionality and correctness
- Documentation completeness
- Test coverage
- Backward compatibility

## Community Guidelines

- Be respectful and constructive
- Help others when you can
- Follow the [Code of Conduct](CODE_OF_CONDUCT.md)

## License

By contributing, you agree that your contributions will be licensed under the Apache License 2.0.

## Questions?

Feel free to open an issue for any questions about contributing!
