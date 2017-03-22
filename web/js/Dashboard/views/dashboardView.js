define(['backbone', 'jquery'], function(backbone, $, WidgetInstancesModelCollection) {
    var DashboardView = Backbone.View.extend({
        el : '#droppable',
        initialize : function() {
            this.idDashboard = $(this.el).data('id');
        },
        createDivs : function(widgetInstance) {
            if($("#widget_" + widgetInstance.id).length == 0) {
                $(this.el).append("<div id='widget_" + widgetInstance.id + "' data-id='" + widgetInstance.id + "'></div>");

                console.log('create div ' + widgetInstance.id);
            }
        },
        empty : function() {
            $(this.el).empty();
        },
        getIdDashboard : function() {
            return this.idDashboard;
        },
        position : function() {
            return $(this.el).position();
        },
        isAdmin : function() {
            return $(this.el).data('admin') == '1';
        }
    });

    return DashboardView;
});