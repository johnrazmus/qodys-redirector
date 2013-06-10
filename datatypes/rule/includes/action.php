<?php ob_start(); ?>
<?php header("Content-type:text/javascript"); ?>
var oldBody = document.body.innerHTML;

function show()
{
	redirector_already_triggered = 1;
	StoreInDatabase();
	
	//setTimeout( function()
	//{
		TriggerRedirect();
		
	//}, 50 );
	
	var the_cookie_name = "already_went";
	
	if( redirector_cookie_scope == 'global' )
	{
		
	}
	else
	{
		the_cookie_name = the_cookie_name + redirector_rule_id;
	}
	
	Cookie.set(the_cookie_name, 'yes');
}

function RedirectorCanGo()
{
	if( redirector_enabled != 'yes' )
		return false;
	
	if( redirector_redirect_url == '' )
		return false;
	
	if( redirector_already_triggered == 1 )
		return false;
	
	var the_cookie_name = "already_went";
	
	if( redirector_cookie_scope == 'global' )
	{
		
	}
	else
	{
		the_cookie_name = the_cookie_name + redirector_rule_id;
	}
	
	if( Cookie.get(the_cookie_name) && redirector_redirect_again != 'yes' )
		return false;
	
	return true;
}

function RedirectorTriggerPopup()
{
	var new_window = null;
	
	// from http://swip.codylindley.com
	var settings = {
		centerBrowser:1, // center window over browser window? {1 (YES) or 0 (NO)}. overrides top and left
		centerScreen:0, // center window over entire screen? {1 (YES) or 0 (NO)}. overrides top and left
		height: redirector_popup_height, // sets the height in pixels of the window.
		left:0, // left position when the window appears.
		location:0, // determines whether the address bar is displayed {1 (YES) or 0 (NO)}.
		menubar:0, // determines whether the menu bar is displayed {1 (YES) or 0 (NO)}.
		resizable:0, // whether the window can be resized {1 (YES) or 0 (NO)}. Can also be overloaded using resizable.
		scrollbars:0, // determines whether scrollbars appear on the window {1 (YES) or 0 (NO)}.
		status:0, // whether a status line appears at the bottom of the window {1 (YES) or 0 (NO)}.
		width: redirector_popup_width, // sets the width in pixels of the window.
		windowName:null, // name of window set from the name attribute of the element that invokes the click
		windowURL: redirector_redirect_url, // url used for the popup
		top:0, // top position when the window appears.
		toolbar:0 // determines whether a toolbar (includes the forward and back buttons) is displayed {1 (YES) or 0 (NO)}.
	};
	
	var windowFeatures =    'height=' + settings.height +
							',width=' + settings.width +
							',toolbar=' + settings.toolbar +
							',scrollbars=' + settings.scrollbars +
							',status=' + settings.status + 
							',resizable=' + settings.resizable +
							',location=' + settings.location +
							',menuBar=' + settings.menubar;

	var centeredY,centeredX;

	if(settings.centerBrowser){
			
		if ($.browser.msie) {//hacked together for IE browsers
			centeredY = (window.screenTop - 120) + ((((document.documentElement.clientHeight + 120)/2) - (settings.height/2)));
			centeredX = window.screenLeft + ((((document.body.offsetWidth + 20)/2) - (settings.width/2)));
		}else{
			centeredY = window.screenY + (((window.outerHeight/2) - (settings.height/2)));
			centeredX = window.screenX + (((window.outerWidth/2) - (settings.width/2)));
		}
		new_window = window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
	}else if(settings.centerScreen){
		centeredY = (screen.height - settings.height)/2;
		centeredX = (screen.width - settings.width)/2;
		new_window = window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + centeredX +',top=' + centeredY).focus();
	}else{
		new_window = window.open(settings.windowURL, settings.windowName, windowFeatures+',left=' + settings.left +',top=' + settings.top).focus();	
	}
	
	return new_window;
}

function RedirectorTriggerPopunder()
{
	 /* use jQuery as container for more convenience */
    (function($) {
        /**
         * Create a popunder
         *
         * @param  sUrl Url to open as popunder
         *
         * @return jQuery
         */
        $.popunder = function(sUrl) {
            var bSimple = $.browser.msie,
                run = function() {
                    $.popunderHelper.open(sUrl, bSimple);
                };
            (bSimple) ? run() : window.setTimeout(run, 1);
            return $;
        };
        
        /* several helper functions */
        $.popunderHelper = {
            /**
             * Helper to create a (optionally) random value with prefix
             *
             * @param  string name
             * @param  boolean rand
             *
             * @return string
             */
            rand: function(name, rand) {
                var p = (name) ? name : 'pu_';
                return p + (rand === false ? '' : Math.floor(89999999*Math.random()+10000000));
            },
            
            /**
             * Open the popunder
             *
             * @param  string sUrl The URL to open
             * @param  boolean bSimple Use the simple popunder
             *
             * @return boolean
             */
            open: function(sUrl, bSimple) {
                var _parent = self,
                    sToolbar = (!$.browser.webkit && (!$.browser.mozilla || parseInt($.browser.version, 10) < 12)) ? 'yes' : 'no',
                    sOptions,
                    popunder;
                
                if (top != self) {
                    try {
                        if (top.document.location.toString()) {
                            _parent = top;
                        }
                    }
                    catch(err) { }
                }
        
				if ($.browser.msie) {//hacked together for IE browsers
					centeredY = (window.screenTop - 120) + ((((document.documentElement.clientHeight + 120)/2) - (redirector_popunder_height/2)));
					centeredX = window.screenLeft + ((((document.body.offsetWidth + 20)/2) - (redirector_popunder_width/2)));
				}else{
					centeredY = window.screenY + (((window.outerHeight/2) - (redirector_popunder_height/2)));
					centeredX = window.screenX + (((window.outerWidth/2) - (redirector_popunder_width/2)));
				}
		
                /* popunder options */
                sOptions = 'toolbar=' + sToolbar + ',scrollbars=yes,location=yes,statusbar=yes,menubar=no,resizable=1,width=' + redirector_popunder_width;
                sOptions += ',height=' + redirector_popunder_height + ',screenX=0,screenY=0,left=' + centeredX +',top=' + centeredY;
        
                /* create pop-up from parent context */
                popunder = _parent.window.open(sUrl, $.popunderHelper.rand(), sOptions);
                if (popunder) {
                    popunder.blur();
                    if (bSimple) {
                        /* classic popunder, used for ie*/
                        window.focus();
                        try { opener.window.focus(); }
                        catch (err) { }
                    }
                    else {
                        /* popunder for e.g. ff4+, chrome */
                        popunder.init = function(e) {
                            with (e) {
                                (function() {
                                    if (typeof window.mozPaintCount != 'undefined' || typeof navigator.webkitGetUserMedia === "function") {
                                        var x = window.open('about:blank');
                                        x.close();
                                    }
        
                                    try { opener.window.focus(); }
                                    catch (err) { }
                                })();
                            }
                        };
                        popunder.params = {
                            url: sUrl
                        };
                        popunder.init(popunder);
                    }
                }
                
                return true;
            }
        };
    })(jQuery);
	
	jQuery.popunder( redirector_redirect_url );
}

function TriggerRedirect()
{ 
	if( redirector_action_type == 'redirect' )
	{
		window.location = redirector_redirect_url;
		//window.open( url );
	}
	else if( redirector_action_type == 'alert' )
	{
		var answer = confirm( redirector_alert_text );
		
		if( answer )
		{
			if( redirector_alert_ok_action == 'url_type' )
			{
				window.location = redirector_redirect_url;
			}
			else if( redirector_alert_ok_action == 'url' && redirector_alert_ok_action_destination_url != '' )
			{
				window.location = redirector_alert_ok_action_destination_url;
			}
			else
			{
				// redirector_alert_ok_action == 'stay'
			}
		}
		else
		{
			if( redirector_alert_cancel_action == 'url_type' )
			{
				window.location = redirector_redirect_url;
			}
			else if( redirector_alert_cancel_action == 'url' && redirector_alert_cancel_action_destination_url != '' )
			{
				window.location = redirector_alert_cancel_action_destination_url;
			}
			else
			{
				// redirector_alert_cancel_action == 'stay'
			}
		}
	}
	/*else if( redirector_action_type == 'tab' )
	{
		//jQuery('#qody_fake_click').click();
		var window_features = "toolbar=1,location=1,directories=1,status=1,menubar=1,scrollbars=1,resizable=1";
		window.open( redirector_redirect_url, '', window_features );
		//window.focus();
	}*/
	else if( redirector_action_type == 'popup' )
	{
		RedirectorTriggerPopup();
		
		//var window_features = "width=" + redirector_popup_width + ",height=" + redirector_popup_height + ",scrollbars=1,resizable=1,toolbar=1,location=1,menubar=1,status=1,directories=0";
		
		//second_window = window.open( redirector_redirect_url, '', window_features )
		//second_window.blur()
		
		//window.focus()
	}
	else if( redirector_action_type == 'popunder' )
	{
		RedirectorTriggerPopunder();
		//jQuery.popunder( redirector_redirect_url );
		
		//var second_window = RedirectorTriggerPopup();
		
		//var window_features = "width=" + redirector_popup_width + ",height=" + redirector_popup_height + ",scrollbars=1,resizable=1,toolbar=1,location=1,menubar=1,status=1,directories=0";
		
		//second_window = window.open( redirector_redirect_url, '', window_features )
		//second_window.blur()
		
		//second_window.blur()
		//window.focus()
	}
	else if( redirector_action_type == 'modal' )
	{
		if( jQuery('#qody_modal') )
		{
			jQuery('#qody_modal').modal({
				backdrop: true,
				keyboard: true
			}).css({
				width: redirector_modal_width + '%',
				height: redirector_modal_height + '%',
				'margin-left': function () {
					return -(jQuery(this).width()/2);
				},
				'margin-top': function () {
					return -(jQuery(this).height()/2);
				}
			});
		}
	}
}

function StoreInDatabase()
{
	//var delay = ;
	
	jQuery.ajax({
		type: "GET",
		url: redirector_log_url,
		data: {
			redirect_url: redirector_redirect_url,
			post_id: redirector_post_id,
			is_remote: redirector_is_remote,
			ref: redirector_referrer
		},
		
	});
}

var Cookie = {

	set : function(name, value, days)
	{
		if( days == undefined )
		{
			days = 30;
		}
	
		var date = new Date();
		date.setTime(date.getTime() + (days * redirector_redirect_wait_period));
	
		document.cookie = name + "=" + value + "; expires=" + date.toGMTString() + "; path=/";
	},
	
	get : function(name)
	{
		var results = document.cookie.match(
			new RegExp("(?:^|; )" + name + "=" + "(.*?)(?:$|;)")
		);
	
		if (results && results.length > 1) return results[1];
			return undefined;
	},
	
	clear : function(name)
	{
		setCookie(name, "", -1);
	}
};


var Move = {

   delay : 1,

   previousX : null,
   previousY : null,

   movements : new Array(),

   box : null,
   coast : true,

   initX : null,
   initY : null,

   realX : null,
   realY : null,

   isMoving : false,

   init : function(name) {
	  Move.reset();
      Move.box = document.getElementById(name);
      Move.find();
   },


   clear : function() {
      Move.onMoveEnd = null;

      document.onmousedown = null;
      document.onmouseup = null;
      document.onmousemove = Cursor.getCursor;

   },

   find : function() {

      if (Move.realX == null) {
         Move.realX = parseInt(Move.box.style.left);
         Move.initX = Move.realX;
      }
      if (Move.realY == null) {
         Move.realY = parseInt(Move.box.style.top);
         Move.initY = Move.realY;
      }
   },
   
   getVerticalScroll : function() {
      if (window.pageYOffset) return parseInt(window.pageYOffset);
      return document.body.scrollTop;
   },
   
   getHorizontalScroll : function() {
      if (window.pageXOffset) return parseInt(window.pageXOffset);
      return document.body.scrollLeft;
   },

   screenTop : function() {
      return Move.getVerticalScroll();
   },
   
   screenLeft : function() {
      return Move.getHorizontalScroll();
   },

};

var Cursor = {
   x : null,
   y : null,

   lastX : null,
   lastY : null,

   archive : function() {
	   Cursor.lastX = Cursor.x;
	   Cursor.lastY = Cursor.y;
   },

   getCursor : function(e) {
      var e = e ? e:event;

      if (e != undefined && e.pageX && e.pageY) {
		   Cursor.archive();
         Cursor.x = parseInt(e.pageX);
         Cursor.y = parseInt(e.pageY);
      }
      else if (e && e.clientX && e.clientY) {
         Cursor.archive();
         Cursor.x = parseInt(e.clientX + document.body.scrollLeft);
         Cursor.y = parseInt(e.clientY + document.body.scrollTop);
      }
   }
};

function GetWindowWidth()
{
	if (document.body && document.body.offsetWidth) {
	 winW = document.body.offsetWidth;
	 winH = document.body.offsetHeight;
	}
	if (document.compatMode=='CSS1Compat' &&
		document.documentElement &&
		document.documentElement.offsetWidth ) {
	 winW = document.documentElement.offsetWidth;
	 winH = document.documentElement.offsetHeight;
	}
	if (window.innerWidth && window.innerHeight) {
	 winW = window.innerWidth;
	 winH = window.innerHeight;
	}
	
	return winW;
}

function handleMove(mouseEvent) {
	Cursor.getCursor(mouseEvent);
	
	var distanceFromTop = Cursor.y - Move.screenTop();
	var distanceFromLeft = Cursor.x - Move.screenLeft();
	
	var windowWidth = GetWindowWidth();
	
	//alert( "Width: " + windowWidth );
	//alert( "distanceFromTop: " + distanceFromTop + " padding " + redirector_redirect_padding );
	
	if( redirector_redirect_type == 'instant' )
	{
		document.onmousemove = null;
		show();
	}
	else
	{	
		var test_one = 1;
   
		if( redirector_mouse_direction == 'up' )
			test_one = Cursor.y < Cursor.lastY;
		else if( redirector_mouse_direction == 'down' )
			test_one = Cursor.y > Cursor.lastY;
			
		var test_two = 1;
		
		if( redirector_redirect_left_margin > 0 )
			test_two = Cursor.x > redirector_redirect_left_margin;
		
		var test_three = 1;
		
		if( redirector_redirect_right_margin > 0 )
			test_three = Cursor.x < ( windowWidth - redirector_redirect_right_margin );
			
		if( test_one && test_two && test_three && distanceFromTop <= redirector_redirect_padding )
		{
		  document.onmousemove = null;
		  show();
		}
	}
}

if( RedirectorCanGo() )
{
	jQuery(document).ready( function() {
		
		if( redirector_is_remote == 'yes' )
		{
			setTimeout(function() {
			
				jQuery("body").mouseleave(function(e) {
					
					show();
					
				});
				
			}, (redirector_redirect_delay * 1000 + 50) );
		
		}
		else
		{
			if( redirector_action_trigger_type == 'load' )
			{
				show();
			}
			else if( redirector_action_trigger_type == 'click' )
			{
				var original_redirect_url = redirector_redirect_url;
				var click_triggered_already = -1;
				
				jQuery('a').click( function(e) {
					
					if( click_triggered_already == 1 )
						return;
					
					var good_to_go = true;
					
					var clicked_url = jQuery(this).attr('href');
					
					if( redirector_click_trigger_specifics != '' )
					{
						var bits = redirector_click_trigger_specifics.split(',');
						var found_match = false;
						
						for( var i = 0; i < bits.length; i++ )
						{
							var search_result = (clicked_url + '').indexOf( bits[i], 0 );
							
							if( search_result === -1 )
							{
								good_to_go = false;
							}
							else
							{
								good_to_go = true;
								break;
							}
						}
					}
					
					if( redirector_click_trigger_exclusions != '' )
					{
						var bits = redirector_click_trigger_exclusions.split(',');
						var found_match = false;
						
						for( var i = 0; i < bits.length; i++ )
						{
							var search_result = (clicked_url + '').indexOf( bits[i], 0 );
							
							if( search_result === -1 )
							{
								good_to_go = true;
							}
							else
							{
								good_to_go = false;
								break;
							}
						}
					}
					
					if( good_to_go )
					{
						click_triggered_already = 1;
						
						e.preventDefault();
						
						redirector_redirect_url = original_redirect_url.replace('@@@qrdip@@@', clicked_url );
						
						if( jQuery('.the_qody_modal_iframe' ) )
							jQuery('.the_qody_modal_iframe').attr( 'src', redirector_redirect_url );
						
						show();
					}
				
				} );
			}
			else
			{
				setTimeout(function() {
					document.onmouseover = handleMove;
				}, (redirector_redirect_delay * 1000 + 50) );
			}
		}
	} );
}
<?php
$buffer = ob_get_contents();
ob_end_clean();

//echo $qodys_redirector->FW()->JavascriptCompress( $buffer );
echo $buffer;
?>