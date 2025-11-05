# Tests

This directory contains validation tests for the AdminerExportCommand plugin.

## Running Tests

To run the validation tests, execute:

```bash
php tests/validate.php
```

## Test Coverage

The validation script (`validate.php`) tests:

1. **Class Structure**
   - Plugin class exists
   - Plugin can be instantiated
   - Required methods are present

2. **MIME Type Handling**
   - SQL format returns `application/sql`
   - JavaScript format returns `application/javascript`
   - Text format returns `text/plain`

3. **Content Preparation**
   - SQL format includes query and metadata
   - SQL format adds semicolon when missing
   - SQL format doesn't add duplicate semicolons
   - JavaScript format includes query wrapped in const
   - JavaScript format includes usage examples
   - Text format includes query with visual separators

4. **UI Integration**
   - Fieldset renders for SQL context
   - Fieldset includes all three format options
   - Fieldset includes Export button
   - Fieldset doesn't render for non-SQL contexts

## Expected Output

When all tests pass, you should see:

```
AdminerExportCommand Plugin Validation
======================================

✓ PASS: Plugin class exists
✓ PASS: Plugin can be instantiated
...
✓ PASS: Fieldset for non-SQL context generates no output

======================================
Tests passed: 24
Tests failed: 0

✓ All tests passed!
```

## Requirements

- PHP 5.6 or higher (for reflection support)
- No additional dependencies required

## Notes

These are unit tests that verify the plugin's core functionality without requiring:
- A full Adminer installation
- A database connection
- A web server

For integration testing with Adminer, see the examples in the `examples/` directory.
