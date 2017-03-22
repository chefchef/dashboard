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

require(['jquery', 'Dashboard/collection/DashboardCollection'], function (JQuery, DashboardCollection) {

    var DashboardCollection = new DashboardCollection;

});
