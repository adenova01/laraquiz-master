
function tinymce_setup_callback(editor)
{   
    editor.settings.toolbar = editor.settings.toolbar+' | tiny_mce_wiris_formulaEditor | tiny_mce_wiris_formulaEditorChemistry';
    editor.settings.external_plugins={'tiny_mce_wiris' : '/vendor/tiny_mce_wiris/plugin.min.js'};
}