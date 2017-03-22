require.config({
    paths: {
        jquery: 'lib/jquery/dist/jquery.min',
        underscore: 'lib/underscore/underscore-min',
        backbone: 'lib/backbone/backbone-min',
        jqueryui: 'lib/jquery-ui/jquery-ui.min',
        jqueryconfirm: 'lib/jquery-confirm2/js/jquery-confirm',
        socketio: '//cdn.socket.io/socket.io-1.3.7',
    },
    shim: {
        underscore: {
            exports: '_',
        },
        backbone: {
            exports: 'Backbone',
            deps: ['jquery', 'underscore'],
        },
        'socketio': {
            exports: 'io'
        }
    },
    deps: ['jquery', 'underscore'],
});
require(['jquery',
        'Dashboard/views/dashboardView',
        'WidgetInstance/collection/WidgetInstancesModelCollection',
        'socketio'],
    function ($, DashboardView, WidgetInstancesModelCollection, io) {

        const ipDevel = '192.168.33.10';
        const ipProd = 'www.dashboarduoc.net';

        var DashboardMain = function () {

            return {
                init: function () {
                    this.initDashboardView();
                    this.dashboardView.empty();
                    this.WidgetInstancesModelCollection = this.initWidgetInstancesCollection();
                    this.initEventsWidgetInstancesModelCollection();
                },
                initDashboardView: function () {
                    this.dashboardView = new DashboardView();
                },
                initWidgetInstancesCollection: function () {
                    return new WidgetInstancesModelCollection({
                        'idDashboard': this.dashboardView.getIdDashboard()
                    });
                },
                empty : function() {
                    $(this.el).empty();
                },
                initEventsWidgetInstancesModelCollection: function () {
                    this.WidgetInstancesModelCollection.on("sync", function () {
                        this.WidgetInstancesModelCollection.each(function (widgetInstanceModel) {
                            this.dashboardView.createDivs(widgetInstanceModel);
                        }, this);
                        this.sincronize();
                    }, this);

                    this.WidgetInstancesModelCollection.on("reset", function () {
                        this.init();
                    }, this);
                },
                sincronize : function(idWidgetInstance) {
                    this.WidgetInstancesModelCollection.sincronize(
                        this.dashboardView.position(),
                        this.dashboardView.isAdmin(),
                        idWidgetInstance
                    );
                },
                reload : function() {
                    this.WidgetInstancesModelCollection.reset();
                },
                sync : function() {
                    this.WidgetInstancesModelCollection.trigger('sync');
                }
            };
        };

        if(window.location.hostname == '192.168.33.10') {
            var ip = ipDevel;
        } else {
            var ip = ipProd;
        }

        var dashboardmain = new DashboardMain();
        dashboardmain.init();

        var io = io.connect('ws://'+ip+':3001', {
            'transports': ['websocket', 'polling']
        });

        io.on('connect', function(){

            $('#socketStats').addClass('progress-bar-success');

            io.on('message', function(data){

                switch(data.action) {
                    case 'reloadDashboard' :
                        dashboardmain.reload();
                        break;
                    case 'syncronize' :
                         dashboardmain.sync();
                        break;
                    default :
                        console.log('message sync '+data.message);
                        dashboardmain.sincronize(data.message);
                }

            })

            io.on('close', function(){});
        });

        io.on('reconnect', function() {
            $('#socketStats').removeClass('progress-bar-danger');
            $('#socketStats').addClass('progress-bar-success');
        });

        io.on('disconnect', function(){
            $('#socketStats').addClass('progress-bar-danger');
        });
    }
);
