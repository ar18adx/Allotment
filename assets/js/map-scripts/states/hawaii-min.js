﻿var ushijsconfig={"ushijs1":{"hover":"HAWAII","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"ushijs2":{"hover":"<b><u>HONOLULU</u></b><br>Write any text and load images<br><img src='../assets/images/example.png'>","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#f1ffc8","overColor":"#d9ff66","downColor":"#cae9af","active":!0},"ushijs3":{"hover":"<b><u>KALAWAO</u></b><br><span style='color: #bcbcbc;'>Street Address:</span><br>&nbsp;321 Example, Address 54321<br><span style='color: #bcbcbc;'>Telephone:</span><br>&nbsp;(256) 555-4321 / (256) 555-1234","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#d7f57a","overColor":"#beef2a","downColor":"#cae9af","active":!0},"ushijs4":{"hover":"<b><u>KAUAʻI</u></b><br><span style='color: #999;'>*Click to open a webpage*</span>","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#f1ffc8","overColor":"#d9ff66","downColor":"#cae9af","active":!0},"ushijs5":{"hover":"<b><u>MAUI</u></b><br><span style='color: #999;'>Click to open a modal window!</span><br><span style='color: #ff6666;'><b>Modal Window Option is Compatible<br> with Bootstrap Only.</b></span>","url":"#mymodal","target":"modal","upColor":"#edff66","overColor":"#cbe600","downColor":"#cae9af","active":!0},"general":{"borderColor":"#9CA8B6","visibleNames":"#adadad"}};function isTouchEnabled(){return(("ontouchstart" in window)||(navigator.MaxTouchPoints>0)||(navigator.msMaxTouchPoints>0))}jQuery(function(){jQuery("path[id^=ushijs]").each(function(i,e){ushiaddEvent(jQuery(e).attr("id"))})});function ushiaddEvent(id,relationId){var _obj=jQuery("#"+id);var arr=id.split("");var _Textobj=jQuery("#"+id+","+"#ushijsvn"+arr.slice(6).join(""));jQuery("#"+["visnames"]).attr({"fill":ushijsconfig.general.visibleNames});_obj.attr({"fill":ushijsconfig[id].upColor,"stroke":ushijsconfig.general.borderColor});_Textobj.attr({"cursor":"default"});if(ushijsconfig[id].active===!0){_Textobj.attr({"cursor":"pointer"});_Textobj.hover(function(){jQuery("#jstip").show().html(ushijsconfig[id].hover);_obj.css({"fill":ushijsconfig[id].overColor})},function(){jQuery("#jstip").hide();jQuery("#"+id).css({"fill":ushijsconfig[id].upColor})});if(ushijsconfig[id].target!=="none"){_Textobj.mousedown(function(){jQuery("#"+id).css({"fill":ushijsconfig[id].downColor})})}_Textobj.mouseup(function(){jQuery("#"+id).css({"fill":ushijsconfig[id].overColor});if(ushijsconfig[id].target==="new_window"){window.open(ushijsconfig[id].url)}else if(ushijsconfig[id].target==="same_window"){window.parent.location.href=ushijsconfig[id].url}else if(ushijsconfig[id].target==="modal"){jQuery(ushijsconfig[id].url).modal("show")}});_Textobj.mousemove(function(e){var x=e.pageX+10,y=e.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#jstip").css({left:x,top:y})});if(isTouchEnabled()){_Textobj.on("touchstart",function(e){var touch=e.originalEvent.touches[0];var x=touch.pageX+10,y=touch.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#"+id).css({"fill":ushijsconfig[id].downColor});jQuery("#jstip").show().html(ushijsconfig[id].hover);jQuery("#jstip").css({left:x,top:y})});_Textobj.on("touchend",function(){jQuery("#"+id).css({"fill":ushijsconfig[id].upColor});if(ushijsconfig[id].target==="new_window"){window.open(ushijsconfig[id].url)}else if(ushijsconfig[id].target==="same_window"){window.parent.location.href=ushijsconfig[id].url}else if(ushijsconfig[id].target==="modal"){jQuery(ushijsconfig[id].url).modal("show")}})}}}var pins_config={"pins":[{"shape":"square","hover":"<b><u>HONOLULU</u></b><br>Write any text and load images<br><img src='../assets/images/example.png'>","pos_X":290,"pos_Y":147,"size":18,"outline":"#000080","upColor":"#1a1aff","overColor":"#66d9ff","url":"https://www.html5interactivemaps.com/","target":"new_window","active":!0},{"shape":"circle","hover":"<b><u>HILO</u></b><br><span style='color: #bcbcbc;'>Street Address:</span><br>&nbsp;321 Example, Address 54321<br><span style='color: #bcbcbc;'>Telephone:</span><br>&nbsp;(256) 555-4321 / (256) 555-1234","pos_X":638,"pos_Y":389,"size":20,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"<b><u>KAPPA</u></b><br><span style='color: #999;'>Click to open a modal window!</span><br><span style='color: #ff6666;'><b>Modal Window Option is Compatible<br> with Bootstrap Only.</b></span>","pos_X":129,"pos_Y":48,"size":16,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"#mymodal","target":"modal","active":!0},{"shape":"circle","hover":"<b><u>BLANK4</u></b><br><span style='color: #999;'>*Click to open a webpage*</span>","pos_X":20,"pos_Y":150,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK5","pos_X":20,"pos_Y":200,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK6","pos_X":20,"pos_Y":250,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK7","pos_X":20,"pos_Y":300,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK8","pos_X":20,"pos_Y":350,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK9","pos_X":20,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK10","pos_X":50,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK11","pos_X":100,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK12","pos_X":150,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK13","pos_X":200,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK14","pos_X":250,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK15","pos_X":300,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0}]};function isTouchEnabled(){return(("ontouchstart" in window)||(navigator.MaxTouchPoints>0)||(navigator.msMaxTouchPoints>0))}jQuery(function(){var pins_len=pins_config.pins.length;if(pins_len>0){var xmlns="http://www.w3.org/2000/svg";var tsvg_obj=document.getElementById("ushijspins");var svg_circle,svg_rect;for(var i=0;i<pins_len;i++){if(pins_config.pins[i].shape==="circle"){svg_circle=document.createElementNS(xmlns,"circle");svg_circle.setAttributeNS(null,"cx",pins_config.pins[i].pos_X+1);svg_circle.setAttributeNS(null,"cy",pins_config.pins[i].pos_Y+1);svg_circle.setAttributeNS(null,"r",pins_config.pins[i].size/2);svg_circle.setAttributeNS(null,"fill","rgba(0, 0, 0, 0.5)");tsvg_obj.appendChild(svg_circle);svg_circle=document.createElementNS(xmlns,"circle");svg_circle.setAttributeNS(null,"cx",pins_config.pins[i].pos_X);svg_circle.setAttributeNS(null,"cy",pins_config.pins[i].pos_Y);svg_circle.setAttributeNS(null,"r",pins_config.pins[i].size/2);svg_circle.setAttributeNS(null,"fill",pins_config.pins[i].upColor);svg_circle.setAttributeNS(null,"stroke",pins_config.pins[i].outline);svg_circle.setAttributeNS(null,"stroke-width",1);svg_circle.setAttributeNS(null,"id","ushijspins_"+i);tsvg_obj.appendChild(svg_circle);ushijsAddEvent(i)}else if(pins_config.pins[i].shape==="square"){svg_rect=document.createElementNS(xmlns,"rect");svg_rect.setAttributeNS(null,"x",pins_config.pins[i].pos_X-pins_config.pins[i].size/2+1);svg_rect.setAttributeNS(null,"y",pins_config.pins[i].pos_Y-pins_config.pins[i].size/2+1);svg_rect.setAttributeNS(null,"width",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"height",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"fill","rgba(0, 0, 0, 0.5)");tsvg_obj.appendChild(svg_rect);svg_rect=document.createElementNS(xmlns,"rect");svg_rect.setAttributeNS(null,"x",pins_config.pins[i].pos_X-pins_config.pins[i].size/2);svg_rect.setAttributeNS(null,"y",pins_config.pins[i].pos_Y-pins_config.pins[i].size/2);svg_rect.setAttributeNS(null,"width",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"height",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"fill",pins_config.pins[i].upColor);svg_rect.setAttributeNS(null,"stroke",pins_config.pins[i].outline);svg_rect.setAttributeNS(null,"stroke-width",1);svg_rect.setAttributeNS(null,"id","ushijspins_"+i);tsvg_obj.appendChild(svg_rect);ushijsAddEvent(i)}}}});function ushijsAddEvent(id){var obj=jQuery("#ushijspins_"+id);if(pins_config.pins[id].active===!0){obj.attr({"cursor":"pointer"});obj.hover(function(){jQuery("#jstip").show().html(pins_config.pins[id].hover);obj.css({"fill":pins_config.pins[id].overColor})},function(){jQuery("#jstip").hide();obj.css({"fill":pins_config.pins[id].upColor})});obj.mouseup(function(){obj.css({"fill":pins_config.pins[id].overColor});if(pins_config.pins[id].target==="new_window"){window.open(pins_config.pins[id].url)}else if(pins_config.pins[id].target==="same_window"){window.parent.location.href=pins_config.pins[id].url}else if(pins_config.pins[id].target==="modal"){jQuery(pins_config.pins[id].url).modal("show")}});obj.mousemove(function(e){var x=e.pageX+10,y=e.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#jstip").css({left:x,top:y})});if(isTouchEnabled()){obj.on("touchstart",function(e){var touch=e.originalEvent.touches[0];var x=touch.pageX+10,y=touch.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#jstip").show().html(pins_config.pins[id].hover);jQuery("#jstip").css({left:x,top:y})});obj.on("touchend",function(){jQuery("#"+id).css({"fill":pins_config.pins[id].upColor});if(pins_config.pins[id].target==="new_window"){window.open(pins_config.pins[id].url)}else if(pins_config.pins[id].target==="same_window"){window.parent.location.href=pins_config.pins[id].url}else if(pins_config.pins[id].target==="modal"){jQuery(pins_config.pins[id].url).modal("show")}})}}}