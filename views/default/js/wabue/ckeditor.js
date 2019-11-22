define(function(require) {
    return {
        config: (hook, type, params, returnValue) => {
            returnValue.toolbar = null
            returnValue.toolbarGroups = [
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                { name: 'forms', groups: [ 'forms' ] },
                { name: 'tools', groups: [ 'tools' ] },
                '/',
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'about', groups: [ 'about' ] }
            ]
            if (returnValue.extraPlugins) {
                if (typeof(returnValue.extraPlugins) === 'string') {
                    returnValue.extraPlugins = [returnValue.extraPlugins]
                } 
            } else {
                returnValue.extraPlugins = []
            }
            returnValue.extraPlugins.push('emoji', 'toc')
            return returnValue
        }
    }
});