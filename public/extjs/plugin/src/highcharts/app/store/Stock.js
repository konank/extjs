Ext.define('HighCharts.store.Stock', {
  extend : 'Ext.data.Store',
  autoLoad : false,
  model: 'HighCharts.model.Stock',
  proxy : { 
    type: 'ajax',
    url: './data/stock.json',
    reader : {
      type: 'json',
      root: 'rows'
    }
  },
  storeId: 'stock'
});

