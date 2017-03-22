define(['backbone'], function(Backbone) {
    var Widget = Backbone.Model.extend({
        initialize: function () {
            console.log('widget init');
        },
        defaults: {
            id: 0,
            name: ''
        }
    });

    return Widget;
});