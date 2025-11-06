# Adminer Export Command Plugin

A plugin for [Adminer](https://www.adminer.org/) that adds functionality to export SQL commands as downloadable files directly from the SQL command editor interface.

## Overview

When working with databases through Adminer, users often need to save their SQL queries for documentation, sharing with team members, or version control. While Adminer provides excellent database management capabilities, it lacks a straightforward way to export the current SQL command being edited.

This plugin solves that problem by adding an "Export" link/button to the SQL command editor, allowing users to:

- Download their SQL queries as files with appropriate extensions (`.sql`, `.js`, `.json`, etc.) based on the database driver
- Open queries in a new browser window for quick viewing
- Automatically timestamp exported files for better organization
- Preserve their work for future reference or sharing

## Features

- **Smart File Extensions**: Automatically determines the correct file extension based on the database driver (MySQL, PostgreSQL, MongoDB, Elasticsearch, etc.)
- **Multiple Output Options**: Export to file or view in browser window
- **Timestamp Support**: Downloaded files are automatically named with timestamps (e.g., `query_20250131_143025.sql`)
- **CodeMirror Integration**: Seamlessly works with Adminer's CodeMirror editor
- **Lightweight**: Minimal footprint with no external dependencies

## Installation

## Usage

## How To Contribute

If you would like to help contribute, please see [CONTRIBUTING](https://github.com/rlaiola/adminer-export-command/blob/main/CONTRIBUTING.md).

Before submitting a PR consider checking your code with Super-Linter:

```sh
docker run --rm \
           -e ACTIONS_RUNNER_DEBUG=true \
           -e RUN_LOCAL=true \
           --env-file ".github/super-linter.env" \
           -v "$PWD":/tmp/lint \
           ghcr.io/super-linter/super-linter:latest
```

## License

Copyright Universidade Federal do Espirito Santo (Ufes)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <https://www.gnu.org/licenses/>.

This program is released under license GNU GPL v3+ license.

## Support

Please report any issues with _adminer-export-command_ at [https://github.com/rlaiola/adminer-export-command/issues](https://github.com/rlaiola/adminer-export-command/issues)
