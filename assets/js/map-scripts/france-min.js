﻿var frjsconfig={"frjs1":{"hover":"ALSACE, CHAMPAGNE-ARDENNE ET LORRAINE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs2":{"hover":"<b><u>AQUITAINE, LIMOUSIN ET POITOU-CHARENTES</u></b><br>Write any text and load images<br><img src='assets/images/example.png'>","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#f1ffc8","overColor":"#d9ff66","downColor":"#cae9af","active":!0},"frjs3":{"hover":"<b><u>AUVERGNE ET RHÔNE-ALPES</u></b><br><span style='color: #bcbcbc;'>Street Address:</span><br>&nbsp;321 Example, Address 54321<br><span style='color: #bcbcbc;'>Telephone:</span><br>&nbsp;(256) 555-4321 / (256) 555-1234","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#d7f57a","overColor":"#beef2a","downColor":"#cae9af","active":!0},"frjs4":{"hover":"<b><u>BOURGOGNE ET FRANCHE-COMTÉ</u></b><br><span style='color: #999;'>*Click to open a webpage*</span>","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#f1ffc8","overColor":"#d9ff66","downColor":"#cae9af","active":!0},"frjs5":{"hover":"<b><u>BRETAGNE</u></b><br><span style='color: #999;'>Click to open a modal window!</span><br><span style='color: #ff6666;'><b>Modal Window Option is Compatible<br> with Bootstrap Only.</b></span>","url":"#mymodal","target":"modal","upColor":"#edff66","overColor":"#cbe600","downColor":"#cae9af","active":!0},"frjs6":{"hover":"CENTRE-VAL-DE-LOIRE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#E0E2E2","overColor":"#ECFFB3","downColor":"#cae9af","active":!1},"frjs7":{"hover":"CORSE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs8":{"hover":"ILE DE FRANCE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs9":{"hover":"LANGUEDOC-ROUSSILION ET MIDI PYRÉNÉES","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs10":{"hover":"NORD-PAS-DE-CALAIS ET PICARDIE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs11":{"hover":"NORMANDIE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs12":{"hover":"PAYS DE LA LOIRE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs13":{"hover":"<b><u>PROVENCE-ALPES-CÔTE D&rsquo;AZUR</u></b><br>Write any text and load images<br><img src='assets/images/example.png'>","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#f1ffc8","overColor":"#d9ff66","downColor":"#cae9af","active":!0},"frjs14":{"hover":"FRENCH GUIANA","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs15":{"hover":"GUADELOUPE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs16":{"hover":"MARTINIQUE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs17":{"hover":"MAYOTTE","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#FFFFF3","overColor":"#ECFFB3","downColor":"#cae9af","active":!0},"frjs18":{"hover":"RÉUNION","url":"https://www.html5interactivemaps.com/","target":"same_window","upColor":"#E0E2E2","overColor":"#ECFFB3","downColor":"#cae9af","active":!1},"general":{"borderColor":"#9CA8B6","visibleNames":"#adadad"}};function isTouchEnabled(){return(("ontouchstart" in window)||(navigator.MaxTouchPoints>0)||(navigator.msMaxTouchPoints>0))}jQuery(function(){jQuery("path[id^=frjs]").each(function(i,e){fraddEvent(jQuery(e).attr("id"))})});function fraddEvent(id,relationId){var _obj=jQuery("#"+id);var arr=id.split("");var _Textobj=jQuery("#"+id+","+"#frjsvn"+arr.slice(4).join(""));jQuery("#"+["visnames"]).attr({"fill":frjsconfig.general.visibleNames});_obj.attr({"fill":frjsconfig[id].upColor,"stroke":frjsconfig.general.borderColor});_Textobj.attr({"cursor":"default"});if(frjsconfig[id].active===!0){_Textobj.attr({"cursor":"pointer"});_Textobj.hover(function(){jQuery("#jstip").show().html(frjsconfig[id].hover);_obj.css({"fill":frjsconfig[id].overColor})},function(){jQuery("#jstip").hide();jQuery("#"+id).css({"fill":frjsconfig[id].upColor})});if(frjsconfig[id].target!=="none"){_Textobj.mousedown(function(){jQuery("#"+id).css({"fill":frjsconfig[id].downColor})})}_Textobj.mouseup(function(){jQuery("#"+id).css({"fill":frjsconfig[id].overColor});if(frjsconfig[id].target==="new_window"){window.open(frjsconfig[id].url)}else if(frjsconfig[id].target==="same_window"){window.parent.location.href=frjsconfig[id].url}else if(frjsconfig[id].target==="modal"){jQuery(frjsconfig[id].url).modal("show")}});_Textobj.mousemove(function(e){var x=e.pageX+10,y=e.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#jstip").css({left:x,top:y})});if(isTouchEnabled()){_Textobj.on("touchstart",function(e){var touch=e.originalEvent.touches[0];var x=touch.pageX+10,y=touch.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#"+id).css({"fill":frjsconfig[id].downColor});jQuery("#jstip").show().html(frjsconfig[id].hover);jQuery("#jstip").css({left:x,top:y})});_Textobj.on("touchend",function(){jQuery("#"+id).css({"fill":frjsconfig[id].upColor});if(frjsconfig[id].target==="new_window"){window.open(frjsconfig[id].url)}else if(frjsconfig[id].target==="same_window"){window.parent.location.href=frjsconfig[id].url}else if(frjsconfig[id].target==="modal"){jQuery(frjsconfig[id].url).modal("show")}})}}}var pins_config={"pins":[{"shape":"square","hover":"<b><u>PARIS</u></b><br>Write any text and load images<br><img src='assets/images/example.png'>","pos_X":329,"pos_Y":160,"size":18,"outline":"#000080","upColor":"#1a1aff","overColor":"#66d9ff","url":"https://www.html5interactivemaps.com/","target":"new_window","active":!0},{"shape":"circle","hover":"<b><u>NANTES</u></b><br><span style='color: #bcbcbc;'>Street Address:</span><br>&nbsp;321 Example, Address 54321<br><span style='color: #bcbcbc;'>Telephone:</span><br>&nbsp;(256) 555-4321 / (256) 555-1234","pos_X":146,"pos_Y":263,"size":20,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"<b><u>LYON</u></b><br><span style='color: #999;'>Click to open a modal window!</span><br><span style='color: #ff6666;'><b>Modal Window Option is Compatible<br> with Bootstrap Only.</b></span>","pos_X":436,"pos_Y":379,"size":16,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"#mymodal","target":"modal","active":!0},{"shape":"circle","hover":"<b><u>TOULOUSE</u></b><br><span style='color: #999;'>*Click to open a webpage*</span>","pos_X":292,"pos_Y":513,"size":14,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"MONTPELLIER","pos_X":401,"pos_Y":512,"size":14,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK6","pos_X":20,"pos_Y":250,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK7","pos_X":20,"pos_Y":300,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK8","pos_X":20,"pos_Y":350,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK9","pos_X":20,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK10","pos_X":50,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK11","pos_X":100,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK12","pos_X":150,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK13","pos_X":200,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK14","pos_X":250,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0},{"shape":"circle","hover":"BLANK15","pos_X":300,"pos_Y":400,"size":0,"outline":"#660000","upColor":"#e60000","overColor":"#ffd480","url":"https://www.html5interactivemaps.com/","target":"same_window","active":!0}]};function isTouchEnabled(){return(("ontouchstart" in window)||(navigator.MaxTouchPoints>0)||(navigator.msMaxTouchPoints>0))}jQuery(function(){var pins_len=pins_config.pins.length;if(pins_len>0){var xmlns="http://www.w3.org/2000/svg";var tsvg_obj=document.getElementById("frjspins");var svg_circle,svg_rect;for(var i=0;i<pins_len;i++){if(pins_config.pins[i].shape==="circle"){svg_circle=document.createElementNS(xmlns,"circle");svg_circle.setAttributeNS(null,"cx",pins_config.pins[i].pos_X+1);svg_circle.setAttributeNS(null,"cy",pins_config.pins[i].pos_Y+1);svg_circle.setAttributeNS(null,"r",pins_config.pins[i].size/2);svg_circle.setAttributeNS(null,"fill","rgba(0, 0, 0, 0.5)");tsvg_obj.appendChild(svg_circle);svg_circle=document.createElementNS(xmlns,"circle");svg_circle.setAttributeNS(null,"cx",pins_config.pins[i].pos_X);svg_circle.setAttributeNS(null,"cy",pins_config.pins[i].pos_Y);svg_circle.setAttributeNS(null,"r",pins_config.pins[i].size/2);svg_circle.setAttributeNS(null,"fill",pins_config.pins[i].upColor);svg_circle.setAttributeNS(null,"stroke",pins_config.pins[i].outline);svg_circle.setAttributeNS(null,"stroke-width",1);svg_circle.setAttributeNS(null,"id","frjspins_"+i);tsvg_obj.appendChild(svg_circle);frjsAddEvent(i)}else if(pins_config.pins[i].shape==="square"){svg_rect=document.createElementNS(xmlns,"rect");svg_rect.setAttributeNS(null,"x",pins_config.pins[i].pos_X-pins_config.pins[i].size/2+1);svg_rect.setAttributeNS(null,"y",pins_config.pins[i].pos_Y-pins_config.pins[i].size/2+1);svg_rect.setAttributeNS(null,"width",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"height",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"fill","rgba(0, 0, 0, 0.5)");tsvg_obj.appendChild(svg_rect);svg_rect=document.createElementNS(xmlns,"rect");svg_rect.setAttributeNS(null,"x",pins_config.pins[i].pos_X-pins_config.pins[i].size/2);svg_rect.setAttributeNS(null,"y",pins_config.pins[i].pos_Y-pins_config.pins[i].size/2);svg_rect.setAttributeNS(null,"width",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"height",pins_config.pins[i].size);svg_rect.setAttributeNS(null,"fill",pins_config.pins[i].upColor);svg_rect.setAttributeNS(null,"stroke",pins_config.pins[i].outline);svg_rect.setAttributeNS(null,"stroke-width",1);svg_rect.setAttributeNS(null,"id","frjspins_"+i);tsvg_obj.appendChild(svg_rect);frjsAddEvent(i)}}}});function frjsAddEvent(id){var obj=jQuery("#frjspins_"+id);if(pins_config.pins[id].active===!0){obj.attr({"cursor":"pointer"});obj.hover(function(){jQuery("#jstip").show().html(pins_config.pins[id].hover);obj.css({"fill":pins_config.pins[id].overColor})},function(){jQuery("#jstip").hide();obj.css({"fill":pins_config.pins[id].upColor})});obj.mouseup(function(){obj.css({"fill":pins_config.pins[id].overColor});if(pins_config.pins[id].target==="new_window"){window.open(pins_config.pins[id].url)}else if(pins_config.pins[id].target==="same_window"){window.parent.location.href=pins_config.pins[id].url}else if(pins_config.pins[id].target==="modal"){jQuery(pins_config.pins[id].url).modal("show")}});obj.mousemove(function(e){var x=e.pageX+10,y=e.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#jstip").css({left:x,top:y})});if(isTouchEnabled()){obj.on("touchstart",function(e){var touch=e.originalEvent.touches[0];var x=touch.pageX+10,y=touch.pageY+15;var tipw=jQuery("#jstip").outerWidth(),tiph=jQuery("#jstip").outerHeight(),x=(x+tipw>jQuery(document).scrollLeft()+jQuery(window).width())?x-tipw-(20*2):x;y=(y+tiph>jQuery(document).scrollTop()+jQuery(window).height())?jQuery(document).scrollTop()+jQuery(window).height()-tiph-10:y;jQuery("#jstip").show().html(pins_config.pins[id].hover);jQuery("#jstip").css({left:x,top:y})});obj.on("touchend",function(){jQuery("#"+id).css({"fill":pins_config.pins[id].upColor});if(pins_config.pins[id].target==="new_window"){window.open(pins_config.pins[id].url)}else if(pins_config.pins[id].target==="same_window"){window.parent.location.href=pins_config.pins[id].url}else if(pins_config.pins[id].target==="modal"){jQuery(pins_config.pins[id].url).modal("show")}})}}}