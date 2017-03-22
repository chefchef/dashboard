define(['backbone', 'jquery', 'Dashboard/views/DashboardListView'], function (Backbone, $, DashboardListView) {
    var dashboardCollection = Backbone.Collection.extend({
        initialize: function () {
            console.log('init dashboard collection');
            var that = this;
            var idUser = $('#container_dashboards').data('iduser');
            this.collection = this.fetch({
                    url: '/api/user/'+idUser+'/dashboards',
                    success: function (collectionViews) {
                        console.log(collectionViews);
                        that.render(collectionViews);
                    }
                }
            );
        },
        render : function(collectionViews) {
            $('#dashboardsCount').text(collectionViews.length);
            collectionViews.each(function (dashboardModel) {
                var dashboardView = new DashboardListView(dashboardModel);
            });
        }
    });

    return dashboardCollection;
});