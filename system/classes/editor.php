<?php
namespace YAWK {
    /**
     * @brief  Load editor settings, required javascript and html markup
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2019 Daniel Retzl http://www.yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0/
     * @details  Load summernote editor + codemirror + settings
     */
    class editor
    {
        /**
         * @brief load the editor and set it's settings
         * @param object $db Database object
         * @return array|bool
         */
        static function getEditor($db)
        {
            $editorSettings = \YAWK\settings::getEditorSettings($db, 14);
            self::loadJavascript($editorSettings);
            self::setEditorSettings($editorSettings);
            return null;
        }

        /**
         * @brief load all required javascript and css files
         * @param array $editorSettings the editor theme
         */
        static function loadJavascript($editorSettings)
        {   // returns the JS include HTML
            echo  "<!-- include codemirror) -->
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"../system/engines/codemirror/codemirror.min.css\">
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"../system/engines/codemirror/themes/".$editorSettings['editorTheme'].".css\">
                    <link rel=\"stylesheet\" type=\"text/css\" href=\"../system/engines/codemirror/show-hint.min.css\">
                    <script type=\"text/javascript\" src=\"../system/engines/codemirror/codemirror-compressed.js\"></script>
                    
                    <!-- SUMMERNOTE -->
                    <link href=\"../system/engines/summernote/dist/summernote.css\" rel=\"stylesheet\">
                    <script src=\"../system/engines/summernote/dist/summernote.min.js\"></script>
                    <script src=\"../system/engines/summernote/dist/summernote-cleaner.js\"></script>
                    <script src=\"../system/engines/summernote/dist/summernote-image-attributes.js\"></script>
                    <script src=\"../system/engines/summernote/dist/summernote-floats-bs.js\"></script>";
        }

        /**
         * @brief output a html script area with all editor options
         * @param $editorSettings
         */
        static function setEditorSettings($editorSettings)
        {   // returns the editor HTML
            echo "
<script type=\"text/javascript\">
    function saveHotkey() {
        // simply disables save event for chrome
        $(window).keypress(function (event) {
            if (!(event.which === 115 && (navigator.platform.match(\"Mac\") ? event.metaKey : event.ctrlKey)) && !(event.which == 19)) return true;
            event.preventDefault();
            formmodified=0; // do not warn user, just save.
            return false;
        });
        // used to process the cmd+s and ctrl+s events
        $(document).keydown(function (event) {
            if (event.which === 83 && (navigator.platform.match(\"Mac\") ? event.metaKey : event.ctrlKey)) {
                event.preventDefault();
                $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                formmodified=0; // do not warn user, just save.
                // save(event);
                return false;
            }
        });
    }
    saveHotkey();
$(document).ready(function() {
    // textarea that will be transformed into editor
    var editor = ('textarea#summernote');
    var savebutton = ('#savebutton');
    var savebuttonIcon = ('#savebuttonIcon');
    // ok, lets go...
    // we need to check if user clicked on save button
        $( \"#savebutton\" ).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
            // to save, even if the editor is currently opened in code view
            // we need to check if codeview is currently active:
            if ($(editor).summernote('codeview.isActivated')) {
                // if so, turn it off.
                $(editor).summernote('codeview.deactivate');
            }
            // to display images in frontend correctly, we need to change the path of every image.
            // to do that, the current value of textarea will be read into var text and search/replaced
            // and written back into the textarea. utf-8 encoding/decoding happens in php, before saving into db.
            // get the value of summernote textarea
            var text = $(editor).val();
            // search for <img> tags and revert src ../ to set correct path for frontend
            var frontend = text.replace(/<img src=\\\"..\/media/g,\"<img src=\\\"media\");
            // put the new string back into <textarea>
            $(editor).val(frontend); // to make sure that saving works
        });

    // BEFORE SUMMERNOTE loads: 3 important lines of code!
    // to display images in backend correctly, we need to change the path of every image.
    // procedure is the same as above (see #savebutton.click)
    // get the value of summernote textarea
    var text = $(editor).val();
    // search for <img> tags and update src ../ to get images viewed in summernote
    var backend = text.replace(/<img src=\\\"media/g,\"<img src=\\\"../media\");
    // put the new string back into <textarea>
    $(editor).val(backend); // set new value into textarea

    // INIT SUMMERNOTE EDITOR
    $('#summernote').summernote({    // set editor itself
        height: $editorSettings[editorHeight],                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true,                 // set focus to editable area after initializing summernote
        dialogsInBody: true,

        // popover tooltips
        popover: {
            image: [
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                /* ['float', ['floatLeft', 'floatRight', 'floatNone']], // those are the old regular float buttons */
                ['floatBS', ['floatBSLeft', 'floatBSNone', 'floatBSRight']],    // bootstrap class buttons (float/pull)
                ['custom', ['imageAttributes', 'imageShape']], // forked plugin: image-attributes.js
                ['remove', ['removeMedia']]
            ]
        },
        // language for plugin image-attributes.js
        lang: 'de-DE',
        
        // powerup the codeview with codemirror theme
        codemirror: { // codemirror options
            theme: '$editorSettings[editorTheme]',                       // codeview theme
            lineNumbers: $editorSettings[editorLineNumbers],             // display lineNumbers true|false
            undoDepth: $editorSettings[editorUndoDepth],                 // how many undo steps should be saved? (default: 200)
            smartIndent: $editorSettings[editorSmartIndent],             // better indent
            indentUnit: $editorSettings[editorIndentUnit],               // how many spaces auto indent? (default: 2)
            scrollbarStyle: null,                                                         // styling of the scrollbars
            matchBrackets: $editorSettings[editorMatchBrackets],         // highlight corresponding brackets
            autoCloseBrackets: $editorSettings[editorCloseBrackets],      // auto insert close brackets
            autoCloseTags: $editorSettings[editorCloseTags],             // auto insert close tags after opening
            value: \"<html>\\n  \" + document.documentElement.innerHTML + \"\\n</html>\",       // all html
            mode: \"htmlmixed\",                                                            // editor mode
            matchTags: {bothTags: $editorSettings[editorMatchTags] },     // hightlight matching tags: both
            extraKeys: {\"Ctrl-J\": \"toMatchingTag\", \"Ctrl-Space\": \"autocomplete\"},         // press ctrl-j to jump to next matching tab
            styleActiveLine: $editorSettings[editorActiveLine]           // highlight the active line (where the cursor is)
        },

        // plugin: summernote-cleaner.js
        // this allows to copy/paste from word, browsers etc.
        cleaner: { // does the job well: no messy code anymore!
            action: \"both\", // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
            newline: \"<br>\" // Summernote's default is to use '<p><br></p>'

            // silent mode:
            // from my pov it is not necessary to notify the user about the code cleaning process.
            // it throws just a useless, annoying bubble everytime you hit the save button.
            // BUT: if you need this notification, you can enable it by uncommenting the following 3 lines
            // notTime:2400,                                            // Time to display notifications.
            // notStyle:'position:absolute;bottom:0;left:2px',          // Position of notification
            // icon:'<i class=\"note-icon\">[Your Button]</i>'            // Display an icon
        }
    }); // end summernote
    
    
}); // end document ready
</script>";
        }


        /**
         *
         * @brief output a html script area with all editor options
         * @param $editorSettings
         */
        static function setEditorSettingsForCustomHtmlWidget($editorSettings)
        {   // returns the editor HTML
            echo "
<script type=\"text/javascript\">

$(document).ready(function() {

    // textarea that will be transformed into editor
    var editor = ('textarea#customHtmlCode');
    // ok, lets go...
    
    // we need to check if user clicked on save button
        $( \"#savebutton\" ).click(function() {
            // to save, even if the editor is currently opened in code view
            // we need to check if codeview is currently active:
            if ($(editor).summernote('codeview.isActivated')) {
                // if so, turn it off.
                $(editor).summernote('codeview.deactivate');
            }
            // to display images in frontend correctly, we need to change the path of every image.
            // to do that, the current value of textarea will be read into var text and search/replaced
            // and written back into the textarea. utf-8 encoding/decoding happens in php, before saving into db.
            // get the value of summernote textarea
            var text = $(editor).val();
            // search for <img> tags and revert src ../ to set correct path for frontend
            var frontend = text.replace(/<img src=\\\"..\/media/g,\"<img src=\\\"media\");
            // put the new string back into <textarea>
            $(editor).val(frontend); // to make sure that saving works
        });
    // BEFORE SUMMERNOTE loads: 3 important lines of code!
    // to display images in backend correctly, we need to change the path of every image.
    // procedure is the same as above (see #savebutton.click)
    // get the value of summernote textarea
    var text = $(editor).val();
    // search for <img> tags and update src ../ to get images viewed in summernote
    var backend = text.replace(/<img src=\\\"media/g,\"<img src=\\\"../media\");
    // put the new string back into <textarea>
    $(editor).val(backend); // set new value into textarea
    
    $(editor).on('summernote.init', function() {
    // toggle editor to codeview
    $(editor).summernote('codeview.toggle');
    });
    
    // INIT SUMMERNOTE EDITOR
    $(editor).summernote({    // set editor itself
        height: $editorSettings[editorHeight],                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true,                 // set focus to editable area after initializing summernote

     
        // language for plugin image-attributes.js
        lang: 'de-DE',
        
        // powerup the codeview with codemirror theme
        codemirror: { // codemirror options
            theme: '$editorSettings[editorTheme]',                       // codeview theme
            lineNumbers: $editorSettings[editorLineNumbers],             // display lineNumbers true|false
            undoDepth: $editorSettings[editorUndoDepth],                 // how many undo steps should be saved? (default: 200)
            smartIndent: $editorSettings[editorSmartIndent],             // better indent
            indentUnit: $editorSettings[editorIndentUnit],               // how many spaces auto indent? (default: 2)
            scrollbarStyle: null,                                                         // styling of the scrollbars
            matchBrackets: $editorSettings[editorMatchBrackets],         // highlight corresponding brackets
            autoCloseBrackets: $editorSettings[editorCloseBrackets],      // auto insert close brackets
            autoCloseTags: $editorSettings[editorCloseTags],             // auto insert close tags after opening
            value: \"<html>\\n  \" + document.documentElement.innerHTML + \"\\n</html>\",       // all html
            mode: \"htmlmixed\",                                                            // editor mode
            matchTags: {bothTags: $editorSettings[editorMatchTags] },     // hightlight matching tags: both
            extraKeys: {\"Ctrl-J\": \"toMatchingTag\", \"Ctrl-Space\": \"autocomplete\"},         // press ctrl-j to jump to next matching tab
            styleActiveLine: $editorSettings[editorActiveLine]           // highlight the active line (where the cursor is)
        },

        // plugin: summernote-cleaner.js
        // this allows to copy/paste from word, browsers etc.
        cleaner: { // does the job well: no messy code anymore!
            action: \"both\", // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
            newline: \"<br>\" // Summernote's default is to use '<p><br></p>'

            // silent mode:
            // from my pov it is not necessary to notify the user about the code cleaning process.
            // it throws just a useless, annoying bubble everytime you hit the save button.
            // BUT: if you need this notification, you can enable it by uncommenting the following 3 lines
            // notTime:2400,                                            // Time to display notifications.
            // notStyle:'position:absolute;bottom:0;left:2px',          // Position of notification
            // icon:'<i class=\"note-icon\">[Your Button]</i>'            // Display an icon
        }
    }); // end summernote
        
}); // end document ready
</script>";
        }

        /**
         *
         * @brief outputs a html script area with all editor options
         * @param $editorSettings
         */
        static function setEditorSettingsForReplyBox($editorSettings)
        {   // returns the editor HTML
            echo "
<script type=\"text/javascript\">
    function saveHotkey() {
        // simply disables save event for chrome
        $(window).keypress(function (event) {
            if (!(event.which === 115 && (navigator.platform.match(\"Mac\") ? event.metaKey : event.ctrlKey)) && !(event.which == 19)) return true;
            event.preventDefault();
            formmodified=0; // do not warn user, just save.
            return false;
        });
        // used to process the cmd+s and ctrl+s events
        $(document).keydown(function (event) {
            if (event.which === 83 && (navigator.platform.match(\"Mac\") ? event.metaKey : event.ctrlKey)) {
                event.preventDefault();
                $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                formmodified=0; // do not warn user, just save.
                // save(event);
                return false;
            }
        });
    }
    saveHotkey();
$(document).ready(function() {
    // textarea that will be transformed into editor
    var editor = ('textarea#replyTextArea');
    var savebutton = ('#savebutton');
    var savebuttonIcon = ('#savebuttonIcon');
    // ok, lets go...
    // we need to check if user clicked on save button
        $( \"#savebutton\" ).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
            // to save, even if the editor is currently opened in code view
            // we need to check if codeview is currently active:
            if ($(editor).summernote('codeview.isActivated')) {
                // if so, turn it off.
                $(editor).summernote('codeview.deactivate');
            }
            // to display images in frontend correctly, we need to change the path of every image.
            // to do that, the current value of textarea will be read into var text and search/replaced
            // and written back into the textarea. utf-8 encoding/decoding happens in php, before saving into db.
            // get the value of summernote textarea
            var text = $(editor).val();
            // search for <img> tags and revert src ../ to set correct path for frontend
            var frontend = text.replace(/<img src=\\\"..\/media/g,\"<img src=\\\"media\");
            // put the new string back into <textarea>
            $(editor).val(frontend); // to make sure that saving works
        });

    // BEFORE SUMMERNOTE loads: 3 important lines of code!
    // to display images in backend correctly, we need to change the path of every image.
    // procedure is the same as above (see #savebutton.click)
    // get the value of summernote textarea
    var text = $(editor).val();
    // search for <img> tags and update src ../ to get images viewed in summernote
    var backend = text.replace(/<img src=\\\"media/g,\"<img src=\\\"../media\");
    // put the new string back into <textarea>
    $(editor).val(backend); // set new value into textarea

    // INIT SUMMERNOTE EDITOR
    $('#summernote').summernote({    // set editor itself
        height: $editorSettings[editorHeight],                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true,                 // set focus to editable area after initializing summernote
        dialogsInBody: true,

        // popover tooltips
        popover: {
            image: [
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                /* ['float', ['floatLeft', 'floatRight', 'floatNone']], // those are the old regular float buttons */
                ['floatBS', ['floatBSLeft', 'floatBSNone', 'floatBSRight']],    // bootstrap class buttons (float/pull)
                ['custom', ['imageAttributes', 'imageShape']], // forked plugin: image-attributes.js
                ['remove', ['removeMedia']]
            ]
        },
        // language for plugin image-attributes.js
        lang: 'de-DE',
        
        // powerup the codeview with codemirror theme
        codemirror: { // codemirror options
            theme: '$editorSettings[editorTheme]',                       // codeview theme
            lineNumbers: $editorSettings[editorLineNumbers],             // display lineNumbers true|false
            undoDepth: $editorSettings[editorUndoDepth],                 // how many undo steps should be saved? (default: 200)
            smartIndent: $editorSettings[editorSmartIndent],             // better indent
            indentUnit: $editorSettings[editorIndentUnit],               // how many spaces auto indent? (default: 2)
            scrollbarStyle: null,                                                         // styling of the scrollbars
            matchBrackets: $editorSettings[editorMatchBrackets],         // highlight corresponding brackets
            autoCloseBrackets: $editorSettings[editorCloseBrackets],      // auto insert close brackets
            autoCloseTags: $editorSettings[editorCloseTags],             // auto insert close tags after opening
            value: \"<html>\\n  \" + document.documentElement.innerHTML + \"\\n</html>\",       // all html
            mode: \"htmlmixed\",                                                            // editor mode
            matchTags: {bothTags: $editorSettings[editorMatchTags] },     // hightlight matching tags: both
            extraKeys: {\"Ctrl-J\": \"toMatchingTag\", \"Ctrl-Space\": \"autocomplete\"},         // press ctrl-j to jump to next matching tab
            styleActiveLine: $editorSettings[editorActiveLine]           // highlight the active line (where the cursor is)
        },

        // plugin: summernote-cleaner.js
        // this allows to copy/paste from word, browsers etc.
        cleaner: { // does the job well: no messy code anymore!
            action: \"both\", // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
            newline: \"<br>\" // Summernote's default is to use '<p><br></p>'

            // silent mode:
            // from my pov it is not necessary to notify the user about the code cleaning process.
            // it throws just a useless, annoying bubble everytime you hit the save button.
            // BUT: if you need this notification, you can enable it by uncommenting the following 3 lines
            // notTime:2400,                                            // Time to display notifications.
            // notStyle:'position:absolute;bottom:0;left:2px',          // Position of notification
            // icon:'<i class=\"note-icon\">[Your Button]</i>'            // Display an icon
        }
    }); // end summernote
    
    
}); // end document ready
</script>";
        }

    } // end class editor
} // end namespace

