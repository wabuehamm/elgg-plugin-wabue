define(function(require) {
    var elgg = require("elgg");
    var Plugin = require("elgg/Plugin");
    var ckeditor = require('wabue/ckeditor');

    return new Plugin({
        init: function () {
            elgg.register_hook_handler("config", "ckeditor", ckeditor.config);
        }
    });
});