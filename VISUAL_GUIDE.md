# Visual Guide

This document provides a visual representation of the AdminerExportCommand plugin interface and functionality.

## Plugin Interface

When the plugin is installed and you navigate to the SQL command page in Adminer, you will see an additional "Export" fieldset below the query textarea.

### UI Elements

```
┌─────────────────────────────────────────────────────────────┐
│ SQL Command                                                  │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ SELECT * FROM users WHERE active = 1                   │ │
│  │                                                        │ │
│  │                                                        │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
│  [Execute]  [History]  [Clear]                              │
│                                                              │
│  ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓  │
│  ┃ Export                                                ┃  │
│  ┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫  │
│  ┃                                                       ┃  │
│  ┃  ◉ SQL (.sql)  ○ JavaScript (.js)  ○ Text (.txt)     ┃  │
│  ┃                                                       ┃  │
│  ┃  [Export Command]                                     ┃  │
│  ┃                                                       ┃  │
│  ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛  │
└─────────────────────────────────────────────────────────────┘
```

### Component Breakdown

1. **Fieldset Title**: "Export"
   - Clearly labeled section for export functionality

2. **Format Selection**: Radio buttons
   - SQL (.sql) - Selected by default
   - JavaScript (.js) - Alternative format
   - Text (.txt) - Plain text format

3. **Export Button**: "Export Command"
   - Triggers the download of the current query

## User Workflow

### Step 1: Write Query
```
User enters SQL query in the main textarea:
┌────────────────────────────────────────────┐
│ SELECT u.id, u.name                        │
│ FROM users u                               │
│ WHERE u.status = 'active'                  │
└────────────────────────────────────────────┘
```

### Step 2: Select Format
```
User chooses export format:
◉ SQL (.sql)
○ JavaScript (.js)
○ Text (.txt)
```

### Step 3: Click Export
```
User clicks: [Export Command]
```

### Step 4: Download File
```
Browser downloads: query_2025-11-05_143022.sql
```

## Export Format Examples

### SQL Export (.sql)

**File**: `query_2025-11-05_143022.sql`

```sql
-- Exported from Adminer
-- Date: 2025-11-05 14:30:22
-- Database driver: mysql

SELECT u.id, u.name
FROM users u
WHERE u.status = 'active';
```

**Features**:
- SQL comments with metadata
- Automatic semicolon termination
- Clean, executable SQL

### JavaScript Export (.js)

**File**: `query_2025-11-05_143022.js`

```javascript
// Exported from Adminer
// Date: 2025-11-05 14:30:22
// Database driver: mysql

const sqlQuery = `
SELECT u.id, u.name
FROM users u
WHERE u.status = 'active'
`;

// Execute this query using your preferred database library
// Example: db.query(sqlQuery);
```

**Features**:
- JavaScript comments with metadata
- ES6 template literal syntax
- Usage examples included

### Text Export (.txt)

**File**: `query_2025-11-05_143022.txt`

```
Exported from Adminer
Date: 2025-11-05 14:30:22
Database driver: mysql
===========================================

SELECT u.id, u.name
FROM users u
WHERE u.status = 'active'
```

**Features**:
- Plain text metadata
- Visual separator line
- Easy to read and share

## Integration Points

### Where the Plugin Appears

The Export fieldset appears **only** on the SQL command page:

```
Adminer Interface
├── Database Structure     (no export fieldset)
├── SQL command            (✓ Export fieldset appears here)
├── Select Table           (no export fieldset)
└── Other pages            (no export fieldset)
```

### Compatible with Other Plugins

The plugin works alongside other Adminer plugins:

```php
// Multiple plugins working together
return new AdminerPlugin(array(
    new AdminerExportCommand(),    // ← Our plugin
    new AdminerTheme("default"),
    new AdminerLoginServers(['localhost']),
));
```

## Browser Compatibility

The plugin works in all modern browsers:

- ✓ Chrome / Edge
- ✓ Firefox
- ✓ Safari
- ✓ Opera
- ✓ Internet Explorer 11+ (with polyfills)

## Accessibility

The interface is keyboard accessible:

- Tab to navigate between radio buttons
- Space to select a format
- Enter on the Export button to download

## Responsive Design

The Export fieldset adapts to different screen sizes:

**Desktop** (wide screen):
```
┌─ Export ─────────────────────────────────────┐
│ ◉ SQL (.sql)  ○ JavaScript (.js)  ○ Text (.txt) │
│ [Export Command]                              │
└───────────────────────────────────────────────┘
```

**Mobile** (narrow screen):
```
┌─ Export ──────┐
│ ◉ SQL (.sql)  │
│ ○ JavaScript  │
│ ○ Text (.txt) │
│ [Export]      │
└───────────────┘
```

## Common Use Cases

### 1. Quick Backup
```
Query → Select SQL → Export → Save to file
```

### 2. Share with Team
```
Query → Select Text → Export → Email/Slack
```

### 3. App Integration
```
Query → Select JavaScript → Export → Use in Node.js app
```

### 4. Documentation
```
Query → Select Text → Export → Add to wiki/docs
```

## Tips for Best Experience

1. **Format Selection**: Choose the format before clicking Export
2. **Filename**: Files are auto-named with timestamp
3. **Download Location**: Check your browser's download folder
4. **Multiple Exports**: You can export the same query in all three formats
5. **Query Editing**: Edit your query and re-export as needed

## Troubleshooting Visual Issues

### Export fieldset not visible?
- Ensure you're on the SQL command page
- Check that the plugin is loaded in plugin.php
- Verify browser console for JavaScript errors

### Format buttons not clickable?
- Check for CSS conflicts with custom themes
- Try disabling other plugins temporarily

### Export button misaligned?
- May be CSS conflict with custom Adminer themes
- Check browser developer tools for layout issues
