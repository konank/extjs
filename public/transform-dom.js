Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', ''+URL+'public/extjs/ux');

Ext.require([
    'Ext.data.*',
    'Ext.grid.*',
    'Ext.ux.grid.TransformGrid'
]);

Ext.onReady(function(){
    // create the grid
        var grid = Ext.create('Ext.ux.grid.TransformGrid', 'the-tabless', {
            stripeRows: true,
            width:'auto',
            id : 'grid_table',
            cls: 'custom-nya',
            tbar : [
            {
                text : 'Back',
                tooltip : 'Back',
                iconCls :'back',
                handler : function(){
                    window.location=''+URL+'booking';
                }
            },
            {
                text : 'Add data',
                tooltip : 'Back',
                iconCls :'add',
                handler : function(){
                    openWindow('','',id_lapangan);
                }
            }
            ]
        });
        Ext.EventManager.onWindowResize(function () {
            grid.setSize(undefined, undefined);
        });
        grid.render(Ext.getBody());
        
        
});