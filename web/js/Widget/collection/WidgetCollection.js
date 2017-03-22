define(['backbone', 'jquery', 'Widget/views/WidgetView','jqueryui'], function(Backbone, $, WidgetView) {
    var WidgetsCollection = Backbone.Collection.extend({
        initialize: function() {
            console.log('init widget collection');
            var that = this;
            this.collection = this.fetch({
                    url : '/api/widgets',
                    success : function(collectionViews) {
                        that.render(collectionViews);
                    }
                }
            );
        },
        render : function(collectionViews) {
            $('#widgetsCount').text(collectionViews.length);
            collectionViews.each(function (widgetModel) {
                var widgetView = new WidgetView(widgetModel);
            });

            if ($('.draggable').length > 0) {
                $('.draggable').draggable({
                    revert: "valid",
                    cursor: "move",
                    opacity: 0.7,
                    helper: "clone"
                });
            }

            if ($('#droppable').length > 0) {
                $('#droppable').droppable({
                    drop: function (event, ui) {
                        console.log('widget in dashboard in position : ');

                        var idDashboard = $('#droppable').data('id');
                        var idWidget = ui.draggable.data('id');


                        var dashboardPosition = $('#droppable').position();

                        var positionX = ui.position.left - dashboardPosition.left;
                        var positionY = ui.position.top - dashboardPosition.top;

                        console.log('position' + positionX + ' ' + positionY);

                        var promise = new $.Deferred();

                        $.ajax({
                            url: '/api/dashboard/' + idDashboard + '/instanceWidget',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                'idWidget': idWidget
                            },
                            success: function (json) {
                                console.log(json);
                                promise.resolve(json);
                            },
                            error: function (xhr, status) {
                                console.log('Error' + status);
                                promise.reject();
                            }
                        });

                        promise.done(function (json) {
                            var idWidgetInstance = json.id;
                            console.log(idWidgetInstance);
                            console.log("Update position");
                            $.ajax({
                                url: '/api/dashboard/' + idDashboard + '/instanceWidget/' + idWidgetInstance + '/position',
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
                        });


                        $(".resizable").resizable();
                        var position = $(".positionable").position();
                        console.log(position);
                    }
                });
            }
        }
    });

    return WidgetsCollection;
});