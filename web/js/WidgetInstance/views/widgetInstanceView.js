define(['backbone', 'jquery', 'underscore', 'WidgetInstance/models/widgetInstanceModel',
    'WidgetInstance/models/widgetInstanceDataModel',
    'jqueryui'], function (Backbone, $, _, WidgetInstanceModel, WidgetInstanceDataModel) {

    var view = Backbone.View.extend({
        widgetInstanceTemplate: _.template($('#template_widget_instance').html()),
        initialize: function(model, positionDashboard, isAdmin) {
            this.model = model;
            this.model.setView(this);

            this.idDashboard = model.get('idDashboard');
            this.idWidgetInstance = model.get('id');
            this.el = '#widget_' + this.idWidgetInstance;
            this.positionDashboard = positionDashboard;
            this.isAdmin = isAdmin;

            this.modeldata = new WidgetInstanceDataModel();
            this.modeldata.on("change", this.render, this);

            console.log('Init view '+ this.idWidgetInstance);
        },
        sincronize : function() {
            this.modeldata.load(this.idDashboard, this.idWidgetInstance);
        } ,
        removeView : function() {
            $(this.el).fadeOut("slow", function() {
                this.remove();
            });
        },
        render: function (modelData) {
            console.log('render');
            var widgetDataTemplate = _.template(this.model.get('tpl'));
            widgetDataHtml = widgetDataTemplate({data: modelData.get('data')});

            $(this.el).html(this.widgetInstanceTemplate({
                model: this.model.toJSON(), widgetinstance: widgetDataHtml,
                modelData : modelData.toJSON()
            }));

            this.positionWidgetInstance(this.positionDashboard, modelData);

            if (this.isAdmin) {
                this.resize();
                this.dragabble();
                this.optionsWidget();
            }
        },
        positionWidgetInstance: function(dashboardPosition, modelData) {
            $(this.el).width(modelData.get('sizeX'));
            $(this.el).height(modelData.get('sizeY'));

            var left = dashboardPosition.left + modelData.get('positionX');
            var top = dashboardPosition.top + modelData.get('positionY');

            $(this.el).css({
                position: "absolute",
                top: top + "px",
                left: left + "px"
            });
        },
        resize: function () {
            var that = this;
            $(this.el).resizable(
                {
                    containment: "#dashboard-wrapper",
                    helper: "ui-resizable-helper",
                    ghost: true,
                    animate: true,
                    maxHeight: 400,
                    maxWidth: 500,
                    minHeight: 100,
                    minWidth: 100,
                    autoHide: true,
                    stop: function (event, ui) {
                        var sizeX = ui.size.width;
                        var sizeY = ui.size.height;

                        $.ajax({
                            url: '/api/dashboard/' + that.idDashboard + '/instanceWidget/' + that.id + '/size',
                            type: 'PATCH',
                            dataType: 'json',
                            data: {
                                'sizeX': sizeX,
                                'sizeY': sizeY
                            },
                            success: function (json) {
                                console.log(json);
                            },
                            error: function (xhr, status) {
                                console.log('Error' + status);
                            }
                        });
                    }
                }
            );
        },
        dragabble: function () {
            var that = this;
            $(this.el).draggable({
                containment: "#dashboard-wrapper",
                scroll: false,
                opacity: 0.35,
                stop: function(event, ui) {
                    var dashboardPosition = $('#droppable').position();

                    var positionX =  ui.position.left - dashboardPosition.left;
                    var positionY =  ui.position.top - dashboardPosition.top;

                    console.log('position' +positionX+' '+positionY);

                    $.ajax({
                        url: '/api/dashboard/' + that.idDashboard + '/instanceWidget/' + that.id+'/position',
                        type: 'PATCH',
                        dataType: 'json',
                        data: {
                            'positionX': positionX,
                            'positionY': positionY
                        },
                        success: function (json) {
                            console.log(json);
                        },
                        error: function (xhr, status) {
                            console.log('Error' + status);
                        }
                    });
                }
            });
        },
        optionsWidget : function()
        {
            var that = this;
            $(this.el).find('#destroyWidget').click(function(e) {
                e.preventDefault();
                that.destroyWidget(this.model);
            });
        },
        destroyWidget : function() {
            this.listenTo(this.model, "destroy", this.removeView);
            this.model.destroyWidget();
        },
    });

    return view;

});