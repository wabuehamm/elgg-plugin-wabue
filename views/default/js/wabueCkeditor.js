define(function(require) {
    function getStringArray(dataObject, dataKey) {
        if (dataObject[dataKey]) {
            if (typeof(dataObject[dataKey]) === 'string') {
                return dataObject[dataKey].split(/,/)
            }
            return dataObject[dataKey]
        } else {
            return []
        }
    }
    return {
        config: function (hook, type, params, returnValue) {
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
            ]
            returnValue.extraPlugins = getStringArray(returnValue, 'extraPlugins').concat(['emoji', 'contents'])
            returnValue.removePlugins = ['image']
            returnValue.removeButtons = 'Source'
            return returnValue
        }
    }
});