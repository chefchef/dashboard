define(['backbone'], function(Backbone) {
    var WidgetInstanceData = Backbone.Model.extend({
        initialize: function () {
            console.log('widget instance data init');
        },
        defaults: {
            id: 0,
            data: [],
            sizeX: 0,
            sizeY: 0,
            positionX: 0,
            positionY: 0
        },
        load : function (idDashboard, idWidgetInstance) {

            if (window.location.hostname == '192.168.33.10') {
               var timeout = 10000;
            } else {
               var timeout = 1000;
            }

            return this.fetch({
                contentType: "application/json",
                timeout : timeout,
                url: "/api/dashboard/" + idDashboard + "/instanceWidget/" + idWidgetInstance + '/data',
                success: function (modelData) {
                    console.log(modelData);
                    console.log('success widget data info load : ');
                },
                error : function() {}
            });
        }
    });

    return WidgetInstanceData;
});