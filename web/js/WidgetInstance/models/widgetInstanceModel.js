define(['backbone', 'jquery', 'WidgetInstance/views/widgetInstanceView', 'jqueryconfirm'], function(Backbone, jQuery, WidgetInstanceView, Confirm) {
    var WidgetInstance = Backbone.Model.extend({
        defaults: {
            id: 0,
            idWidget : 0,
            idDashboard: 0,
        },
        view : {},
        initialize: function () {
            console.log('widget instance init');
        },
        hasView : function ()  {
            return Object.keys(this.view).length != 0;
        },
        setView : function(view) {
            this.view = view;
        },
        getView : function() {
            return this.view;
        },
        sincronize: function(positionDashboard, isAdmin) {
            if (!this.hasView()) {
                this.setView(new WidgetInstanceView(this, positionDashboard, isAdmin));
            }

            this.view.sincronize();
        },
        destroyWidget : function() {
            var that = this;
            jQuery.confirm({
                title: '¡¡ Remove this widget !!',
                content: '¿Would you remove this widget forever?',
                confirm: function(){
                    that.destroy({
                        url: "/api/dashboard/" + that.get('idDashboard') + "/instanceWidget/" + that.get('id'),
                        success: function() {

                        },
                        error: function(xhr, status) {
                            jQuery.dialog({
                                title: 'Error code : ' + status.status,
                                content: 'Is not possible to delete this widget. Please try in a few minutes or ' +
                                'report us this issue.',
                            });
                        }
                    });
                },
                cancel: function(){}
            });
        },
    });

    return WidgetInstance;
});