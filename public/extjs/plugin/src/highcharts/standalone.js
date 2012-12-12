Ext.Loader.setConfig({
  enabled : true,
  disableCaching : true, // For debug only
  paths : {
    'Chart' : ''+base_url+'public/extjs/plugin/src/highcharts/Chart/'
  }
});

Ext.require('Chart.ux.HighChart');

Ext.application({
  name : 'HighChart',
  launch : function() {
    // Using the new ExtJS 4 store
    Ext.define('HighChartData', {
      extend : 'Ext.data.Model',
      fields : [{
        name : 'nama_lapangan',
        type : 'string'
        
      }, {
        name : 'percentage',
        type : 'float'
      }, {
        name : 'percentage',
        type : 'float'
      }]
    });

    var store = new Ext.create('Ext.data.Store', {
      model : 'HighChartData',
      proxy : {
        type : 'ajax',
        url : ''+base_url+'dashboard/jsondatachart',
        reader : {
          type : 'json',
          root : 'rows'
        }
      },
      autoLoad : true
    });


    var Grafik = Ext.create('Ext.Viewport',{
        layout: {
            type: 'fit',
            padding: 5
        },
        items : [{
        xtype : 'highchart',
        id : 'chart',
        defaultSeriesType : 'spline',
        series : [
        {
          type : 'spline',
          dataIndex : 'percentage',
          name : 'Total',
          visible : true
        }],
        store : store,
        xField : 'nama_lapangan',
        chartConfig : {
          chart : {
            marginRight : 130,
            marginBottom : 120,
            zoomType : 'x',
            animation : {
              duration : 1500,
              easing : 'swing'
            }
          },
          title : {
            text : 'Grafik lapangan yang sering digunakan',
            x : -20 //center
          },
          //subtitle : {
//            text : 'Random value',
//            x : -20
//          },
          xAxis : [{
            title : {
              text : 'Nama lapangan',
              margin : 20
            },
            labels : {
              rotation : 270,
              y : 35,
              formatter : function() {
                return this.value;
              }

            }
          }],
          yAxis : {
            title : {
              text : 'Value'
            },
            plotLines : [{
              value : 0,
              width : 1,
              color : '#808080'
            }]
          },
          plotOptions : {
            series : {
              animation : {
                duration : 3000,
                easing : 'swing'
              }
            }
          },
          tooltip : {
            formatter : function() {
              return '<b>' + this.series.name + '</b><br/>' + this.x + ': ' + this.y;
            }

          },
          credits : {
           // href : 'http://andrey',
            text : 'Copyright Andrey derma'
          },
          legend : {
            layout : 'vertical',
            align : 'right',
            verticalAlign : 'top',
            x : -10,
            y : 100,
            borderWidth : 0
          }
        }
      }]
    })
    //var win = Ext.create('Ext.window.Window', {
//      width : 520,
//      closable : false,
//      draggable : false,
//      
//      height : 300,
//      hidden : false,
//      shadow : false,
//      maximizable : true,
//      renderTo : Ext.getBody(),
//      layout : 'fit',
//      
//      
//    });
//    win.show();
  }

});
