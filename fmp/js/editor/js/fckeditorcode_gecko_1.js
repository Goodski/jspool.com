/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2004 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * This file has been compacted for best loading performance.
 * 
 * Version: 2.0 Beta 1
 * Created: 2004-06-01 00:25:31
 */
var FCKDebug=new Object();if (FCKConfig.Debug){FCKDebug.Output=function(message, color){if (! FCKConfig.Debug) return;if (message !=null && isNaN( message )){message=message.replace(/</g, "&lt;");};if (!this.DebugWindow || this.DebugWindow.closed){this.DebugWindow=window.open('fckdebug.html', 'FCKeditorDebug', 'menubar=no,scrollbars=no,resizable=yes,location=no,toolbar=no,width=600,height=500', true);};if (this.DebugWindow.Output){this.DebugWindow.Output(message, color);};};}else{FCKDebug.Output=function() {};};var FCKTools=new Object();FCKTools.GetLinkedFieldValue=function(){return FCK.LinkedField.value;};FCKTools.SetLinkedFieldValue=function(value){FCK.LinkedField.value=value;};FCKTools.AttachToLinkedFieldFormSubmit=function(functionPointer){var oForm=FCK.LinkedField.form;if (!oForm) return;if (FCKBrowserInfo.IsIE) oForm.attachEvent("onsubmit", functionPointer);else oForm.addEventListener('submit', functionPointer, true);if (! oForm.updateFCKEditor) oForm.updateFCKEditor=new Array();oForm.updateFCKEditor[oForm.updateFCKEditor.length]=functionPointer;if (! oForm.originalSubmit){oForm.originalSubmit=oForm.submit;oForm.submit=function(){if (this.updateFCKEditor){for (var i=0 ; i < this.updateFCKEditor.length ; i++) this.updateFCKEditor[i]();};this.originalSubmit();};};};FCKTools.AddSelectOption=function(targetDocument, selectElement, optionText, optionValue){var oOption=targetDocument.createElement("OPTION");oOption.text=optionText;oOption.value=optionValue;selectElement.options.add(oOption);return oOption;};FCKTools.RemoveAllSelectOptions=function(selectElement){for (var i=selectElement.options.length - 1 ; i >=0 ; i--){selectElement.options.remove(i);};};FCKTools.SelectNoCase=function(selectElement, value, defaultValue){var sNoCaseValue=value.toString().toLowerCase();for (var i=0 ; i < selectElement.options.length ; i++){if (sNoCaseValue==selectElement.options[i].value.toLowerCase()){selectElement.selectedIndex=i;return;};};if (defaultValue !=null ) FCKTools.SelectNoCase( selectElement, defaultValue);};FCKTools.HTMLEncode=function(text){text=text.replace(/&/g, "&amp;");text=text.replace(/"/g, "&quot;");text=text.replace(/</g, "&lt;");text=text.replace(/>/g, "&gt;");text=text.replace(/'/g, "&#146;");return text;};FCKTools.GetResultingArray=function(arraySource, separator){switch (typeof( arraySource )){case "string" : return arraySource.split(separator);case "function" : return separator();default : if (isArray( arraySource )) return arraySource;else return new Array();};};FCKTools.AppendStyleSheet=function(documentElement, cssFileUrl){var e=documentElement.createElement('LINK');e.rel='stylesheet';e.type='text/css';e.href=cssFileUrl;documentElement.getElementsByTagName("HEAD").item(0).appendChild( e);};FCKTools.ClearElementAttributes=function(element){for (var i=0 ; i < element.attributes.length ; i++){element.removeAttribute(element.attributes[i].name, 0);};};FCKTools.GetAllChildrenIds=function(parentElement){var aIds=new Array();var fGetIds=function(parent){for (var i=0 ; i < parent.childNodes.length ; i++){var sId=parent.childNodes[i].id;if (sId && sId.length > 0) aIds[ aIds.length ]=sId;fGetIds(parent.childNodes[i]);};};fGetIds(parentElement);return aIds;};var FCKLanguageManager=new Object();FCKLanguageManager.AvailableLanguages={'ar'	: 'Arabic', 'en'	: 'English', 'it'	: 'Italian'};FCKLanguageManager.GetActiveLanguage=function(){if (FCKConfig.AutoDetectLanguage){var sUserLang=navigator.language ? navigator.language.toLowerCase() : navigator.userLanguage.toLowerCase();FCKDebug.Output('Navigator Language = ' + sUserLang);if (sUserLang.length >=5){sUserLang=sUserLang.substr(0,5);if (this.AvailableLanguages[sUserLang]) return sUserLang;};if (sUserLang.length >=2){sUserLang=sUserLang.substr(0,2);if (this.AvailableLanguages[sUserLang]) return sUserLang;};};return FCKConfig.DefaultLanguage;};FCKLanguageManager.TranslateElements=function(targetDocument, tag, propertyToSet){var aInputs=targetDocument.getElementsByTagName(tag);for (var i=0 ; i < aInputs.length ; i++){if (aInputs[i].attributes['fckLang']){var s=FCKLang[ aInputs[i].attributes["fckLang"].value ];eval('aInputs[i].' + propertyToSet + ' = s');};};};FCKLanguageManager.TranslatePage=function(targetDocument){this.TranslateElements(targetDocument, 'INPUT', 'value');this.TranslateElements(targetDocument, 'SPAN', 'innerHTML');this.TranslateElements(targetDocument, 'OPTION', 'innerHTML');};FCKLanguageManager.ActiveLanguage=new Object();FCKLanguageManager.ActiveLanguage.Code=FCKLanguageManager.GetActiveLanguage();FCKLanguageManager.ActiveLanguage.Name=FCKLanguageManager.AvailableLanguages[ FCKLanguageManager.ActiveLanguage.Code ];FCK.Language=FCKLanguageManager;FCKScriptLoader.AddScript('lang/' + FCKLanguageManager.ActiveLanguage.Code + '.js');var FCKEvents=function(eventsOwner){this.Owner=eventsOwner;this.RegisteredEvents=new Object();};FCKEvents.prototype.AttachEvent=function(eventName, functionPointer, params){if (! this.RegisteredEvents[ eventName ] ) this.RegisteredEvents[ eventName ]=new Array();this.RegisteredEvents[ eventName ][ this.RegisteredEvents[ eventName ].length ]=functionPointer;};FCKEvents.prototype.FireEvent=function(eventName, params){var bReturnValue=true;FCKDebug.Output('Firing event: ' + eventName, 'Fuchsia');var oCalls=this.RegisteredEvents[ eventName ];if (oCalls){for (i in oCalls){if (typeof( oCalls[ i ] )=="function"){bReturnValue=(bReturnValue && oCalls[ i ]( params ));}else{bReturnValue=(bReturnValue && eval( oCalls[ i ] ));};};};return bReturnValue;};var FCKXHtml=new Object();FCKXHtml.GetXHTML=function(node){if (window.ActiveXObject) this.XML=new ActiveXObject('Msxml2.DOMDocument');else{this.XML=document.implementation.createDocument('', '', null);Node.prototype.__defineGetter__('xml', FCKXHtml._Node_getXML);};this.MainNode=this.XML.appendChild(this.XML.createElement( 'XHTML' ));this._AppendChildNodes(this.MainNode, node);var sXHTML=this.MainNode.xml;return sXHTML.substr(7, sXHTML.length - 15);};FCKXHtml._Node_getXML=function(){var oSerializer=new XMLSerializer();return oSerializer.serializeToString(this);};FCKXHtml._AppendAttribute=function(xmlNode, attributeName, attributeValue){var oXmlAtt=this.XML.createAttribute(attributeName);if (typeof( attributeValue )=='boolean' && attributeValue == true) oXmlAtt.value=attributeName;else oXmlAtt.value=attributeValue;xmlNode.attributes.setNamedItem(oXmlAtt);};FCKXHtml._AppendChildNodes=function(xmlNode, htmlNode){var oChildren=htmlNode.childNodes;var i=0;while (i < oChildren.length){i +=this._AppendNode(xmlNode, oChildren[i]);};};FCKXHtml._AppendNode=function(xmlNode, htmlNode){var iAddedNodes=1;switch (htmlNode.nodeType){case 1 : var sNodeName=htmlNode.nodeName.toLowerCase();var oNode=xmlNode.appendChild(this.XML.createElement( sNodeName ));var oAttributes=htmlNode.attributes;for (var n=0 ; n < oAttributes.length ; n++){var oAttribute=oAttributes[n];if (oAttribute.specified) this._AppendAttribute(oNode, oAttribute.nodeName.toLowerCase(), oAttribute.nodeValue);};switch (sNodeName){case "script" : case "style" : oNode.appendChild(this.XML.createCDATASection( htmlNode.text ));break;case "abbr" : if (document.all){var oNextNode=htmlNode.nextSibling;while (true){iAddedNodes++;if (oNextNode && oNextNode.nodeName !='/ABBR'){this._AppendNode(oNode, oNextNode);oNextNode=oNextNode.nextSibling;}else break;};break;};case "area" : if (document.all && ! oNode.attributes.getNamedItem( 'coords' )){var sCoords=htmlNode.getAttribute('coords', 2);if (sCoords && sCoords !='0,0,0') this._AppendAttribute(oNode, 'coords', sCoords);};case "img" : if (! oNode.attributes.getNamedItem( 'alt' )) this._AppendAttribute(oNode, 'alt', '');default : this._AppendChildNodes(oNode, htmlNode);break;};break;case 3 : xmlNode.appendChild(this.XML.createTextNode( htmlNode.nodeValue ));break;default : xmlNode.appendChild(this.XML.createComment( "Element not supported - Type: " + htmlNode.nodeType + " Name: " + htmlNode.nodeName ));break;};return iAddedNodes;};FCK.Events=new FCKEvents(FCK);FCK.Toolbar=null;FCK.SetStatus=function(newStatus){this.Status=newStatus;if (newStatus==FCK_STATUS_ACTIVE){if (FCKBrowserInfo.IsIE) FCKScriptLoader.AddScript('js/fckeditorcode_ie_2.js');else FCKScriptLoader.AddScript('js/fckeditorcode_gecko_2.js');};this.Events.FireEvent('OnStatusChange', newStatus);if (this.OnStatusChange ) this.OnStatusChange( newStatus);};FCK.SetHTML=function(html, forceWYSIWYG){if (forceWYSIWYG || FCK.EditMode==FCK_EDITMODE_WYSIWYG){if (FCKBrowserInfo.IsGecko) FCK.EditorDocument.designMode="off";this.EditorDocument.body.innerHTML=html;if (FCKBrowserInfo.IsGecko) FCK.EditorDocument.designMode="on";}else document.getElementById('eSourceField').value = html;};FCK.GetHTML=function(){if (FCK.EditMode==FCK_EDITMODE_WYSIWYG) return this.EditorDocument.body.innerHTML;else return document.getElementById('eSourceField').value;};FCK.GetXHTML=function(){var bSource=(FCK.EditMode==FCK_EDITMODE_SOURCE);if (bSource) this.SwitchEditMode();var sXHTML=FCKXHtml.GetXHTML(this.EditorDocument.body);if (bSource) this.SwitchEditMode();return sXHTML;};FCK.UpdateLinkedField=function(){if (FCKConfig.EnableXHTML) FCKTools.SetLinkedFieldValue(FCK.GetXHTML());else FCKTools.SetLinkedFieldValue(FCK.GetHTML());};FCK.Focus=function(){if (FCK.EditMode==FCK_EDITMODE_WYSIWYG) FCK.EditorDocument.body.focus();else document.getElementById('eSource').focus();};FCK.ShowContextMenu=function(x, y){if (this.Status !=FCK_STATUS_COMPLETE) return;FCKContextMenu.Show(x, y);this.Events.FireEvent("OnContextMenu");};FCK.StartEditor=function(){this.EditorWindow=window.frames[ 'eEditorArea' ];this.EditorDocument=this.EditorWindow.document;this.SetHTML(FCKTools.GetLinkedFieldValue());FCKTools.AttachToLinkedFieldFormSubmit(this.UpdateLinkedField);var oOnContextMenu=function(e){e.preventDefault();FCK.ShowContextMenu(e.clientX, e.clientY);};this.EditorDocument.addEventListener('contextmenu', oOnContextMenu, true);var oOnKeyDown=function(e){if (e.ctrlKey && !e.shiftKey && !e.altKey){if (e.which==86 || e.which==118){if (FCK.Status==FCK_STATUS_COMPLETE){if (!FCK.Events.FireEvent( "OnPaste" )) e.preventDefault();}else e.preventDefault();};};};this.EditorDocument.addEventListener('keydown', oOnKeyDown, true);var oOnSelectionChange=function(e){FCK.Events.FireEvent("OnSelectionChange");};this.EditorDocument.addEventListener('mouseup', oOnSelectionChange, false);this.EditorDocument.addEventListener('keyup', oOnSelectionChange, false);this.EditorDocument.designMode="on";this.SetStatus(FCK_STATUS_ACTIVE);};