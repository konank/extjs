Ext.define('App.view.Viewport', {
    extend: 'Ext.container.Viewport',
    layout: 'border',
    items: [
        {
            itemId: 'nav',
            xtype: 'treepanel',
            title: 'Navigation',
            margins: '5 0 5 5',
            region: 'west',
            width: 200,
            root: {
                expanded: true,
                children: [
                    { text: "Tab 1", panel: 'TabFirst', leaf: true },
                    { text: "Tab 2", panel: 'TabSecond', leaf: true },
                    { text: "Tab 3", panel: 'TabThird', leaf: true }
                ]
            }
        },
        {
            itemId: 'tabs',
            xtype: 'tabpanel',
            region: 'center',
            margins: '5 5 5 5'
        }
    ]
});