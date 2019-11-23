define(function(require) {
    let elgg = require("elgg");
    let Plugin = require("elgg/Plugin");
    let wabueCkeditor = require('wabueCkeditor');

    return new Plugin({
        init: function () {
            elgg.register_hook_handler("config", "ckeditor", wabueCkeditor.config);
        }
    });
});