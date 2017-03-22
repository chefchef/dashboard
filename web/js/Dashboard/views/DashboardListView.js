define(['backbone', 'jquery', 'underscore'], function (Backbone, $, _) {

    var view = Backbone.View.extend({
        widgetInstanceTemplate: _.template($('#template_dashboards').html()),
        model: '',
        initialize: function (model) {
            console.log(model);
            this.render(model)
        },
        render: function (model) {

            widgetHtml = this.widgetInstanceTemplate({model: model.toJSON()});
            $("#container_dashboards_ul").append(widgetHtml);
        }
    });

    return view;

});