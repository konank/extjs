<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/extjs/resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/extjs/plugin/portal.css" />

    <!-- GC -->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/weather/jquery.zweatherfeed.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/weather/jquery.zweatherfeed.css" />
    
    <script type="text/javascript" src="<?php echo base_url() ?>public/weather/cuaca.js"></script>
    <script type="text/javascript">
    $(function() {
        
            weatherGeocode('<?php echo $lokasi; ?>','weatherList');
    //        initialize();
    });
    </script>-->
    <script type="text/javascript" src="<?php echo base_url() ?>public/extjs/plugin/ext.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/extjs/plugin/all-classes.js"></script>

    <!-- shared example code -->

    <!-- portal classes --><!--
    <script type="text/javascript" src="classes/Portlet.js"></script>
    <script type="text/javascript" src="classes/PortalColumn.js"></script>
    <script type="text/javascript" src="classes/PortalPanel.js"></script>
    <script type="text/javascript" src="classes/PortalDropZone.js"></script>

     example portlets
    <script type="text/javascript" src="classes/GridPortlet.js"></script>
    <script type="text/javascript" src="classes/ChartPortlet.js"></script>

     app
    -->
    <!--<script type="text/javascript" src="<?php echo base_url() ?>public/extjs/plugin/portal.js"></script>-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/extjs/ux/RowActions.css" />
    <script type="text/javascript" src="<?php echo base_url() ?>public/extjs/ux/RowActions.js"></script>
    <script type="text/javascript">
    
        
    /* -------------------------------CREATE MODEL-------------------------*/
        Ext.define('DataCustomer',{
            extend : 'Ext.data.Model',
            fields : ['id','no_ktp','nama','alamat','gender','no_telfon','total_booking'],
        })
        
        /* -------------------------------CREATE STORE-------------------------*/
        var store = Ext.create('Ext.data.Store', {
            pageSize: 10,
            model: 'DataCustomer',
            remoteSort: true,
            proxy: {
                type: 'ajax',
                url : '<?php echo base_url() ?>dashboard/getalldata',
                reader: {
                    root: 'customer',
                    totalProperty: 'totalCount'
                },
                // sends single sort as multi parameter
                simpleSortMode: true
            },
        });
        
        /* -------------------------------CREATE GRID -------------------------*/
        
        var grid = Ext.create('Ext.grid.Panel', {
            store : store,
            
            columns : [
                {header : 'No identitas' , dataIndex: 'no_ktp',flex:0.5},
                {header : 'Nama', dataIndex : 'nama',flex: 0.7},
                //{header : 'Alamat', dataIndex : 'alamat',flex: 1.3},
                {header : 'Gender', dataIndex : 'gender',flex: 0.6},
                {header : 'Nomor telepon', dataIndex : 'no_telfon',flex: 0.6},
                {header : 'Jumlah bermain', dataIndex : 'total_booking',flex: 0.6,renderer : getTotalBermain},           
                
            ],
            id : 'gridData',
            
        })
        store.loadPage(1);
        function getTotalBermain(val){
            if(val == '' || val == 'NULL' || val == null){
                return 0;
            }     else {
                return val;
            }
        }
        
         var pieChart = new Ext.Panel({
            iconCls:'chart',
            frame:true,
            width:550,
            height:342,
             layout:'fit',
             items: {
                xtype: 'component',
                autoEl: {
                    tag: 'iframe',
                    style: 'height: 100%; width: 100%; border: none',
                    src: 'sample'
                }
            },
        });
        
Ext.define('Ext.app.Portal', {

    extend: 'Ext.container.Viewport',
    //requires: [ 'Ext.diag.layout.ContextItem', 'Ext.diag.layout.Context' ],
    uses: ['Ext.app.PortalPanel', 'Ext.app.PortalColumn', 'Ext.app.GridPortlet'],

    getTools: function(){
        return [{
            xtype: 'tool',
            type: 'gear',
            handler: function(e, target, panelHeader, tool){
                var portlet = panelHeader.ownerCt;
                portlet.setLoading('Loading...');
                Ext.defer(function() {
                    portlet.setLoading(false);
                }, 2000);
            }
        }];
    },

    initComponent: function(){
        var content = '<div class="portlet-content"></div>';
        //var content = '<div class="portlet-content">'+Ext.example.shortBogusMarkup+'</div>';
        
        Ext.apply(this, {
            id: 'app-viewport',
            layout: {
                type: 'border',
                padding: '0 5 5 5' // pad the layout from the window edges
            },
            items: [
            {
                xtype: 'container',
                region: 'center',
                layout: 'border',
                
                items: [
                {
                    id: 'app-portal',
                    xtype: 'portalpanel',
                    region: 'center',
                    
                    items: [
                   // {
//                        id: 'col-1',
//                        maxWidth : 200,
//                        items: [
//                        
//                        {
//                            id: 'portlet-3',
//                            title: 'Welcome message',
//                            tools: this.getTools(),
//                            width : 200,
//                            html: '<div class="portlet-content">Selamat datang <strong><?php echo strtoupper($this->session->userdata('username')) ?></strong> di Halaman administrator</div>',
//                            listeners: {
//                                'close': Ext.bind(this.onPortletClose, this)
//                            }
//                        },
//                        //{
////                            id: 'portlet-2',
////                            title: 'Portlet 2',
////                            tools: this.getTools(),
////                            html: content,
////                            listeners: {
////                                'close': Ext.bind(this.onPortletClose, this)
////                            }
////                        }
//                        ]
//                    }
                    {
                        id: 'col-2',
                        minWidth : 450,
                        items: [
                        {
                            id: 'portlet-1',
                            title: '10 Customer yang sering bermain',
                            tools: this.getTools(),
                            items: [grid],
                            
                            listeners: {
                                'close': Ext.bind(this.onPortletClose, this)
                            }
                        }
                        ]
                    },{
                        id: 'col-3',
                        minWidth : 500,
                        items: [{
                            id: 'portlet-4',
                            title: 'Grafik',
                            
                            tools: this.getTools(),
                            items: [pieChart],
                            
                            listeners: {
                                'close': Ext.bind(this.onPortletClose, this)
                            }
                        }]
                    }]
                }]
            }]
        });
        this.callParent(arguments);
    },

    onPortletClose: function(portlet) {
        this.showMsg('"' + portlet.title + '" was removed');
    },

    showMsg: function(msg) {
        var el = Ext.get('app-msg'),
            msgId = Ext.id();

        this.msgId = msgId;
        el.update(msg).show();

        Ext.defer(this.clearMsg, 3000, this, [msgId]);
    },

    clearMsg: function(msgId) {
        if (msgId === this.msgId) {
            Ext.get('app-msg').hide();
        }
    }
});
    </script>
    <script type="text/javascript">
        Ext.Loader.setPath('Ext.app', '<?php echo base_url() ?>public/extjs/plugin/classes');

        Ext.onReady(function(){
            Ext.create('Ext.app.Portal');
            
        });
    </script>
</head>
<body>
    <span id="app-msg" style="display:none;"></span>
    
</body>
</html>
