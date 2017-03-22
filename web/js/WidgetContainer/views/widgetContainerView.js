define(['backbone', 'jquery', 'Widget/collection/WidgetCollection'], function(backbone, $, WidgetCollection) {
    var widgetContainerView = Backbone.View.extend({
        el : '#container_widgets',
        initialize : function() {
            this.collection = new WidgetCollection();
        },
        render : function() {
            // this.$el.append('This is a widget container');
        }
    });

    return widgetContainerView;
});