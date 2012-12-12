
 <script type="text/javascript">
    
    Ext.Loader.setConfig({
        enabled: true
    });
    
    Ext.Loader.setPath('Ext.ux', '<?php echo base_url() ?>public/extjs/ux');
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
                            iconCls : 'user',
                            leaf: true
                        }, {
                            text: 'Groups',
                            panel: 'groups',
                            iconCls : 'usergroup',
                            leaf: true
                        }, {
                            text: 'Roles',
                            panel: 'accessroles',
                            leaf: true
                        },{
                            text: 'Access control',
                            panel: 'acl',
                            iconCls : 'acl',
                            leaf: true
                        },   ]
                    }, {
                        text: 'Master data',
                        expanded: true,
                        children: [{
                            text: 'Customers',
                            panel:'customers',
                            iconCls : 'cust',
                            leaf: true
                        }, {
                            text: 'Lapangan',
                            iconCls : 'field-icon',
                            leaf: true,
                            panel : 'lapangan'
                        }, {
                            text: 'Setting',
                            leaf: true,
                            iconCls : 'setting',
                            panel : 'settings'
                        }]
                    },{
                       text : 'Reservation system',
                       expanded: true,
                       children : [
                        {
                            text :'Booking',
                            panel : 'booking',
                            iconCls : 'view',
                            leaf:true
                        },
                        {
                            text : 'Billing',
                            panel : 'billing',
                            iconCls : 'bill',
                            leaf:true
                        }
                       ]  
                    },{
                       text : 'Report',
                       expanded: true,
                       children : [
                        {
                            text :'Daily report',
                            panel : 'report',
                            iconCls : 'daily',
                            leaf:true
                        },
                        {
                            text :'Monthly report',
                            panel : 'report.monthly',
                            iconCls : 'monthly',
                            leaf:true
                        },
                        {
                            text :'Customer report',
                            panel : 'report.customer',
                            iconCls : 'report-cust',
                            leaf:true
                        },
                        
                        
                       ]  
                    }, {
                        text: 'Logout',
                        id: 'logout',
                        leaf:true,
                        iconCls : 'keluar',
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
                
			     activeTab:0,
                xtype:'tabpanel',
                //plain: true,
                items: [
                //{
//                  title: 'Dashboard',
//                  loader: {
//                        url: '<?php echo base_url() ?>dashboard/homepage',
//                        
//                        contentType: 'html',
//                        loadMask: true,
//
//                    },
//                    listeners: {
//                        activate: function(tab) {
//                            tab.loader.load();
//                        }
//                    }
//                }
                    Ext.create('Ext.ux.IFrame',{
                      src:'<?php echo base_url() ?>dashboard/homepage',
                      title: "Dashboard",
                      
                        shim:true,
                        itemId: id,                                    
                        layout: 'fit',
                        closable: true,
                        loadMask: true,
                        
                    })
                
                ]
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
            var getUrl = id.split('.');
            var controller = getUrl[0];
            var fungsi = getUrl[1];
            
            if(fungsi === undefined){
                var Uri = controller;
            } else {
                var Uri = controller+'/'+fungsi;
            }
            var tab = myTPanel.add(Ext.create('Ext.ux.IFrame',{
                src:Uri,
                title: rec.get('text'),                  
                layout: 'fit',
                closable: true,
                loadMask: true,
                
            })).show();
            myTPanel.setActiveTab(tab);
          
        }
    });
    
    </script>