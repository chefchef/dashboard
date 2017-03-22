define(['backbone', 'WidgetInstance/models/widgetInstanceModel'], function(Backbone, WidgetInstanceModel, WidgetInstanceView) {
    var WidgetInstanceCollection = Backbone.Collection.extend({
        model : WidgetInstanceModel,
        initialize: function(options) {
            console.log('init widget instances collection');
            return this.fetch({
                url : '/api/dashboard/'+ options.idDashboard + '/instanceWidget',
                success : function() {
                    console.log('success widget instances collection');
                },
                error : function() {
                    console.log('error widget instances collection');
                }
            });
        },
        sincronize : function(positionDashboard, isAdmin, idWidgetInstance) {
            this.each(function (widgetInstanceModel) {

                if (typeof idWidgetInstance === "undefined" || idWidgetInstance === widgetInstanceModel.get('id')) {
                    widgetInstanceModel.sincronize(positionDashboard, isAdmin);
                }


            }, this);
        }
    });

    return WidgetInstanceCollection;
});