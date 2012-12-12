Ext.Loader.setConfig({ enabled: true });
    Ext.application({
        name: 'App',
        appFolder: 'public/app',
        autoCreateViewport: true,
        controllers: ['Main'],
        launch: function () {
           
        }
});