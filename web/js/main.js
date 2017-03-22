require.config({
  paths: {
    jquery: 'lib/jquery/dist/jquery',
    underscore: 'lib/underscore-amd/underscore',
    backbone: 'lib/backbone-amd/backbone',
    jqueryui: 'lib/jquery-ui/jquery-ui',
  },
  shim: {
    underscore: {
      exports: '_',
    },
    backbone: {
      exports: 'Backbone',
      deps: ['jquery', 'underscore'],
    },
  },
  deps: ['jquery', 'underscore'],
});

require(['views/app'], function(AppView) {
  new AppView;
});
