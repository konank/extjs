<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome administration</title>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/extjs/resources/css/ext-all.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>" />
    
    <script type="text/javascript" src="<?php echo base_url('public/extjs/ext-all.js') ?>"></script>
    <script type="text/javascript">
    
    Ext.Loader.setConfig({
        enabled: true
    });
    
    Ext.Loader.setPath('Ext.ux', 'public/extjs/ux');
    Ext.require(['*','Ext.ux.IFrame',]);
    
    Ext.onReady(function() {
        Ext.QuickTips.init(); //untuk tooltip
        
        Ext.create('Ext.Viewport', {
            layout: {
                type: 'border',
                padding: 5
            },
            defaults: {
                split: true
            },
            items: [{
                region: 'west',
                collapsible: true,
                title: 'Starts at width 30%',
                split: true,
                width: '20%',
                minWidth: 100,
                minHeight: 140,
                
                
                itemId: 'nav',
                xtype: 'treepanel',
                title: 'Menu Navigation',
                margins: '5 0 5 5',
                root: {
                    expanded: true,
                    
                    children: 
                    [{
                        text: 'Usermanagement',
                        expanded: true,
                        children: [{
                            text: 'Manage users',
                            panel: 'manages',
                            leaf: true
                        }, {
                            text: 'Groups',
                            panel: 'groups',
                            leaf: true
                        }, {
                            text: 'Roles',
                            panel: 'accessroles',
                            leaf: true
                        },{
                            text: 'Access control',
                            panel: 'acl',
                            leaf: true
                        },   ]
                    }, {
                        text: 'Menu 2',
                        expanded: true,
                        children: [{
                            text: 'Menu 2.1',
                            panel:'tabTes',
                            leaf: true
                        }, {
                            text: 'Menu 2.2',
                            leaf: true
                        }]
                    }, {
                        text: 'Logout',
                        id: 'logout',
                        leaf:true,
                        icon: '<?php echo base_url() ?>public/icons/minus-circle.png',
                        panel : 'logout'
                    }]
                },
                listeners: {
                    itemclick: function(view,rec) {
                       if (!rec.raw || !rec.raw.panel) return;
                       if(rec.raw.panel == 'logout'){
                            do_logout();
                        } else {
                            loadTab(view,rec);
                            
                        }
                    },
                },
            },{
                itemId: 'tabs',
                id : 'myTPanel',
                layout:'fit',
                border : false,
                region: 'center',
                margins: '5 5 5 5',
                plain: true,
			     activeTab:0,
                xtype:'tabpanel',
                plain: true,
                items: [{
                  title: 'Dashboard',
                  loader: {
                        url: '<?php echo base_url() ?>dashboard/homepage',
                        
                        contentType: 'html',
                        loadMask: true,

                    },
                    listeners: {
                        activate: function(tab) {
                            tab.loader.load();
                        }
                    }
                }]
            }
            
            ]
        });
        
        function do_logout() {
            Ext.Ajax.request({
                url: '<?php echo base_url() ?>dashboard/logout',
                method: 'POST',
                success: function(xhr) {
                    window.location = '<?php echo base_url() ?>login';
                }
            });
        }

        function loadTab(view,rec){
            
                var id = rec.raw.panel;
                var cls = id;
                var myTPanel = Ext.getCmp('myTPanel'); //get id xtype
                //alert(tabs);
                var tab = myTPanel.child('#' + id);
                
                if(tab){
                    myTPanel.setActiveTab(tab);
                } else {
                    createItemTab(view,rec,id);
                }
                
        }
        
        function createItemTab(view,rec,id)
        {
            var myTPanel = Ext.getCmp('myTPanel');
                        
            var tab = myTPanel.add(Ext.create('Ext.ux.IFrame',{
              src:id,
              title: rec.get('text'),
                iconCls: 'tabs',
                shim:true,
                itemId: id,                                    
                layout: 'fit',
                closable: true,
                loadMask: true,
                
            })).show();
            myTPanel.setActiveTab(tab);
          
        }
    });
    
    </script>
</head>
<body>

<div id="grid-example"></div>

</body>
</html>