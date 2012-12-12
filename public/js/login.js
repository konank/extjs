
Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', 'public/extjs/ux');
Ext.require([
    'Ext.form.*',
    'Ext.layout.container.Column',
    'Ext.tab.Panel',
    'Ext.ux.statusbar.StatusBar',
    'Ext.window.MessageBox',
    'Ext.tip.*'
]);

Ext.onReady(function() {

    // 02. Form Login
    var formLogin = new Ext.FormPanel({
		frame: false, border: false, buttonAlign: 'center',
		url: BASE_URL + 'login/auth', method: 'POST', id: 'frmLogin',
		bodyStyle: 'padding:10px 10px 15px 15px;background:#dfe8f6;',
		width: 300, labelWidth: 150,
		items: [{
			xtype: 'textfield',
			fieldLabel: 'Username',
			name: 'username',
			id: 'logUsername',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Password',
			name: 'password',
            id: 'logPassword',
			allowBlank: false,
			inputType: 'password',
            listeners: {
                specialkey: function(field, e){
                    if (e.getKey() == e.ENTER) {
                        fnLogin();
                    }
                }
            },
		}
		],
		buttons: [
			{ text: 'Login', handler: fnLogin },
			{ text: 'Reset', handler: function() {
					formLogin.getForm().reset();
				}
			}
		],
        

	});

function showResultText(btn, text){
        Ext.example.msg('Button Click', 'You clicked the {0} button and entered the text "{1}".', btn, text);
    };
    
    function fnLogin() {
        Ext.getCmp('frmLogin').on({
            beforeaction: function() {      
                if (formLogin.getForm().isValid()) {
                    Ext.getCmp('winLogin').body.mask();
                    Ext.getCmp('sbWinLogin').showBusy();   
                }
            }
        });
        
        formLogin.getForm().submit({
           //waitMsg: 'Please wait, Now processing...',
           
           success: function() {
            
                   //Ext.MessageBox.show({
//                       title: 'Login successfully',
//                       msg: 'Please wait, Initializing...',
//                       progressText: 'Initializing...',
//                       width:300,
//                       progress:true,
//                       wait : true,
//                       waitConfig:{interval:200},
//                       icon :'success-login',
//                       closable:false,
//                       
//                       //animateTarget: 'frmLogin'
//                   });
                         Ext.MessageBox.show({
                            title: 'Login successfully',
                           msg: 'Initializing...',
                           progressText: 'Initializing...',
                           width:300,
                           progress:true,
                           wait:true,
                           icon:'success-login', //custom class in msg-box.html
                //           animateTarget: 'mb7'
                       });
            
                   // this hideous block creates the bogus progress
                   var f = function(v){
                        return function(){
                            if(v == 12){
                                Ext.MessageBox.hide();
                                window.location = BASE_URL+'dashboard';
                            }else{
                                var i = v/11;
                                Ext.MessageBox.updateProgress(i, Math.round(100*i)+'% completed');
                            }
                       };
                   };
                   for(var i = 1; i < 13; i++){
                       setTimeout(f(i), i*500);
                   }     
           },
           failure: function(form, action) {
              // Ext.getCmp('winRegister').body.unmask();
               Ext.getCmp('winLogin').body.unmask();
               if (action.failureType == 'server') {
                if(action.response.responseText == 2){
                    //Ext.MessageBox.alert('Login failed,', 'Invalid username or password, Please try again.');
                    Ext.MessageBox.alert({
                        title:'Login failed',
                        msg:'Invalid username or password, Please try again',
                        icon:'error-icon'
                    });
                     Ext.getCmp('sbWinLogin').setStatus({
                        text: 'User not found',
                        iconCls: 'x-status-error'
                    });
                }
                   // obj = Ext.util.JSON.decode(action.response.responseText);
                   
                } else {
                    if (formLogin.getForm().isValid()) {
                        Ext.getCmp('sbWinLogin').setStatus({
                            text: 'Authentication server is unreachable',
                            iconCls: 'x-status-error'
                        });
                    } else {
                        Ext.getCmp('sbWinLogin').setStatus({
                            text: 'Something error in form !',
                            iconCls: 'x-status-error'
                        });
                    }
                }
           }
        });
    }

    // 02. Window Login
	var winLogin = new Ext.Window({
		title: 'Login',
        id: 'winLogin',
		layout: 'fit',
		width: 350,
		height: 160,
		y: 200,
		resizable: false,
		closable: false,
		items: [formLogin],
        bbar: new Ext.ux.StatusBar({
            text: 'Ready',
            id: 'sbWinLogin'
        })
	});

	winLogin.show();
});