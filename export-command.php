<?php

//========================================================================
// Copyright Universidade Federal do Espirito Santo (Ufes)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.
//
// This program is released under license GNU GPL v3+ license.
//
//========================================================================

/**
 * Plugin to export current sql command as a file
 * @author Rodrigo Laiola Guimaraes, https://www.rodrigolaiola.com/
 */
class AdminerExportCommand extends Adminer\Plugin
{

    /** @var string */
    private $defaultDriver;
    /** @var string */
    private $extension;
    
    public function __construct($defaultDriver = 'mysql')
    {
        $this->defaultDriver = $defaultDriver;
    }

    public function head()
    {
        $sql = filter_input(INPUT_GET, 'sql');
        if (!isset($sql)) {
            return;
        }

        // Map driver to appropriate file extension (simplified)
        $driver = $this->defaultDriver;
        $map = [
            'sqlite'    => 'sql',
            'sqlite2'   => 'sql',
            'pgsql'     => 'sql',
            'firebird'  => 'sql',
            'oracle'    => 'sql',
            'simpledb'  => 'txt',
            'elastic'   => 'json',
            'mysql'     => 'sql',
            'mongo'     => 'js',
            'mssql'     => 'sql',
        ];
        $ext = isset($map[$driver]) ? $map[$driver] : 'sql'; // Default file extension (.sql)
        $this->extension = $ext;

        ?>
    
        <script<?php echo Adminer\nonce(); ?> type="text/javascript">
            function domReady(fn) {
                document.addEventListener("DOMContentLoaded", fn);
                if (document.readyState === "interactive" || document.readyState === "complete") {
                    fn();
                }
            }

            domReady(() => {
                const form = document.querySelector('#form');
                const textarea = form?.querySelector('textarea[name="query"]');
                if (!form || !textarea) return;

                // Create fieldset for export command
                const exportCmdFS = document.createElement("fieldset");
                exportCmdFS.setAttribute('id', 'export-fs');
                exportCmdFS.innerHTML = 
                    `<?php
                    $adminer_export = Adminer\get_settings("adminer_import");
                    $dump_output = Adminer\adminer()->dumpOutput();
                    unset($dump_output["gz"]);
                    $dump_format = Adminer\adminer()->dumpFormat();
                    unset($dump_format["csv"]);
                    unset($dump_format["csv;"]);
                    unset($dump_format["tsv"]);
                    unset($dump_format["json"]);
                    echo "<legend><a id='export-link' href='#'>" . Adminer\lang('Export') . "</a></legend>"
                        . "<div id='export-div' class='hidden'>\n"
                        . Adminer\html_select("output-cmd", $dump_output, $adminer_export["output"]) . " "
                        . Adminer\html_select("format-cmd", $dump_format, $adminer_export["format"]) . " "
                        . "<input type='button' name='export-cmd-bt' value='" . Adminer\lang('Export') . "'>\n"
                        . "</div>\n";
                    ?>`;

                const exportCommand = (e) => {
                    e.preventDefault(); // ← Prevent default form submission
                    e.stopPropagation(); // ← Optional: prevent bubbling up if needed

                    let commandContent = '';
                    // CodeMirror attaches its instance to the textarea wrapper via `.CodeMirror`
                    if (textarea && textarea.nextSibling && textarea.nextSibling.CodeMirror) {
                        const cm = textarea.nextSibling.CodeMirror;
                        commandContent = cm.getValue();
                    }
                    else {
                        // Fallback to plain textarea if CodeMirror is not used
                        commandContent = textarea.value;
                    }

                    const out = document.querySelector('select[name="output-cmd"] option:checked');
                    if (!out || out.value == 'text') {
                        const win = window.open();
                        win.document.write("<pre><div>" + commandContent + "</div></pre>");
                        win.document.close();
                    }
                    else {    
                        const now = new Date();
                        const pad = n => n.toString().padStart(2, '0');
                        const formattedDate = now.getFullYear().toString()
                            + pad(now.getMonth() + 1)
                            + pad(now.getDate())
                            + "_"
                            + pad(now.getHours())
                            + pad(now.getMinutes())
                            + pad(now.getSeconds());

                        const ext = "<?php echo $this->extension ?>";
                        const filename = `query_${formattedDate}.${ext}`;

                        const blob = new Blob([commandContent], { type: 'text/plain;charset=utf-8' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    }
                };

                form.appendChild(exportCmdFS);

                document.querySelector('#export-link').addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default link behavior
                    document.querySelector('#export-div').classList.toggle('hidden');
                });

                document.querySelector('select[name="output-cmd"]').value = "file";
                document.querySelector('input[name="export-cmd-bt"]').addEventListener('click', exportCommand);
            });
        </script>
            <?php
    }
}
