(function(){
    var script = {
 "mouseWheelEnabled": true,
 "start": "this.init(); this.visibleComponentsIfPlayerFlagEnabled([this.IconButton_EE9FBAB2_E389_8E06_41D7_903ABEDD153A], 'gyroscopeAvailable'); this.syncPlaylists([this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist,this.mainPlayList]); if(!this.get('fullscreenAvailable')) { [this.IconButton_EEFF957A_E389_9A06_41E1_2AD21904F8C0].forEach(function(component) { component.set('visible', false); }) }",
 "scrollBarWidth": 10,
 "id": "rootPlayer",
 "mobileMipmappingEnabled": false,
 "vrPolyfillScale": 0.5,
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "backgroundPreloadEnabled": true,
 "children": [
  "this.MainViewer",
  "this.Container_EF8F8BD8_E386_8E03_41E3_4CF7CC1F4D8E",
  "this.Container_0DD1BF09_1744_0507_41B3_29434E440055",
  "this.Container_1B9AAD00_16C4_0505_41B5_6F4AE0747E48",
  "this.Container_062AB830_1140_E215_41AF_6C9D65345420",
  "this.Container_23F0F7B8_0C0A_629D_418A_F171085EFBF8",
  "this.Container_39DE87B1_0C06_62AF_417B_8CB0FB5C9D15",
  "this.Container_221B1648_0C06_E5FD_417F_E6FCCCB4A6D7",
  "this.Container_2F8BB687_0D4F_6B7F_4190_9490D02FBC41",
  "this.Container_2820BA13_0D5D_5B97_4192_AABC38F6F169",
  "this.Container_2A1A5C4D_0D3B_DFF0_41A9_8FC811D03C8E",
  "this.Container_06C41BA5_1140_A63F_41AE_B0CBD78DEFDC",
  "this.Container_21C2E33E_34AF_9C3C_41C2_806CDFD8DC6C"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "desktopMipmappingEnabled": false,
 "minHeight": 20,
 "scripts": {
  "setOverlayBehaviour": function(overlay, media, action){  var executeFunc = function() { switch(action){ case 'triggerClick': this.triggerOverlay(overlay, 'click'); break; case 'stop': case 'play': case 'pause': overlay[action](); break; case 'togglePlayPause': case 'togglePlayStop': if(overlay.get('state') == 'playing') overlay[action == 'togglePlayPause' ? 'pause' : 'stop'](); else overlay.play(); break; } if(window.overlaysDispatched == undefined) window.overlaysDispatched = {}; var id = overlay.get('id'); window.overlaysDispatched[id] = true; setTimeout(function(){ delete window.overlaysDispatched[id]; }, 2000); }; if(window.overlaysDispatched != undefined && overlay.get('id') in window.overlaysDispatched) return; var playList = this.getPlayListWithMedia(media, true); if(playList != undefined){ var item = this.getPlayListItemByMedia(playList, media); if(playList.get('items').indexOf(item) != playList.get('selectedIndex')){ var beginFunc = function(e){ item.unbind('begin', beginFunc, this); executeFunc.call(this); }; item.bind('begin', beginFunc, this); return; } } executeFunc.call(this); },
  "getMediaByName": function(name){  var list = this.getByClassName('Media'); for(var i = 0, count = list.length; i<count; ++i){ var media = list[i]; if((media.get('class') == 'Audio' && media.get('data').label == name) || media.get('label') == name){ return media; } } return undefined; },
  "executeFunctionWhenChange": function(playList, index, endFunction, changeFunction){  var endObject = undefined; var changePlayListFunction = function(event){ if(event.data.previousSelectedIndex == index){ if(changeFunction) changeFunction.call(this); if(endFunction && endObject) endObject.unbind('end', endFunction, this); playList.unbind('change', changePlayListFunction, this); } }; if(endFunction){ var playListItem = playList.get('items')[index]; if(playListItem.get('class') == 'PanoramaPlayListItem'){ var camera = playListItem.get('camera'); if(camera != undefined) endObject = camera.get('initialSequence'); if(endObject == undefined) endObject = camera.get('idleSequence'); } else{ endObject = playListItem.get('media'); } if(endObject){ endObject.bind('end', endFunction, this); } } playList.bind('change', changePlayListFunction, this); },
  "stopGlobalAudio": function(audio){  var audios = window.currentGlobalAudios; if(audios){ audio = audios[audio.get('id')]; if(audio){ delete audios[audio.get('id')]; if(Object.keys(audios).length == 0){ window.currentGlobalAudios = undefined; } } } if(audio) audio.stop(); },
  "pauseGlobalAudio": function(audio){  var audios = window.currentGlobalAudios; if(audios){ audio = audios[audio.get('id')]; } if(audio.get('state') == 'playing') audio.pause(); },
  "updateVideoCues": function(playList, index){  var playListItem = playList.get('items')[index]; var video = playListItem.get('media'); if(video.get('cues').length == 0) return; var player = playListItem.get('player'); var cues = []; var changeFunction = function(){ if(playList.get('selectedIndex') != index){ video.unbind('cueChange', cueChangeFunction, this); playList.unbind('change', changeFunction, this); } }; var cueChangeFunction = function(event){ var activeCues = event.data.activeCues; for(var i = 0, count = cues.length; i<count; ++i){ var cue = cues[i]; if(activeCues.indexOf(cue) == -1 && (cue.get('startTime') > player.get('currentTime') || cue.get('endTime') < player.get('currentTime')+0.5)){ cue.trigger('end'); } } cues = activeCues; }; video.bind('cueChange', cueChangeFunction, this); playList.bind('change', changeFunction, this); },
  "syncPlaylists": function(playLists){  var changeToMedia = function(media, playListDispatched){ for(var i = 0, count = playLists.length; i<count; ++i){ var playList = playLists[i]; if(playList != playListDispatched){ var items = playList.get('items'); for(var j = 0, countJ = items.length; j<countJ; ++j){ if(items[j].get('media') == media){ if(playList.get('selectedIndex') != j){ playList.set('selectedIndex', j); } break; } } } } }; var changeFunction = function(event){ var playListDispatched = event.source; var selectedIndex = playListDispatched.get('selectedIndex'); if(selectedIndex < 0) return; var media = playListDispatched.get('items')[selectedIndex].get('media'); changeToMedia(media, playListDispatched); }; var mapPlayerChangeFunction = function(event){ var panoramaMapLocation = event.source.get('panoramaMapLocation'); if(panoramaMapLocation){ var map = panoramaMapLocation.get('map'); changeToMedia(map); } }; for(var i = 0, count = playLists.length; i<count; ++i){ playLists[i].bind('change', changeFunction, this); } var mapPlayers = this.getByClassName('MapPlayer'); for(var i = 0, count = mapPlayers.length; i<count; ++i){ mapPlayers[i].bind('panoramaMapLocation_change', mapPlayerChangeFunction, this); } },
  "isCardboardViewMode": function(){  var players = this.getByClassName('PanoramaPlayer'); return players.length > 0 && players[0].get('viewMode') == 'cardboard'; },
  "getComponentByName": function(name){  var list = this.getByClassName('UIComponent'); for(var i = 0, count = list.length; i<count; ++i){ var component = list[i]; var data = component.get('data'); if(data != undefined && data.name == name){ return component; } } return undefined; },
  "setCameraSameSpotAsMedia": function(camera, media){  var player = this.getCurrentPlayerWithMedia(media); if(player != undefined) { var position = camera.get('initialPosition'); position.set('yaw', player.get('yaw')); position.set('pitch', player.get('pitch')); position.set('hfov', player.get('hfov')); } },
  "setPanoramaCameraWithCurrentSpot": function(playListItem){  var currentPlayer = this.getActivePlayerWithViewer(this.MainViewer); if(currentPlayer == undefined){ return; } var playerClass = currentPlayer.get('class'); if(playerClass != 'PanoramaPlayer' && playerClass != 'Video360Player'){ return; } var fromMedia = currentPlayer.get('panorama'); if(fromMedia == undefined) { fromMedia = currentPlayer.get('video'); } var panorama = playListItem.get('media'); var newCamera = this.cloneCamera(playListItem.get('camera')); this.setCameraSameSpotAsMedia(newCamera, fromMedia); this.startPanoramaWithCamera(panorama, newCamera); },
  "setComponentVisibility": function(component, visible, applyAt, effect, propertyEffect, ignoreClearTimeout){  var keepVisibility = this.getKey('keepVisibility_' + component.get('id')); if(keepVisibility) return; this.unregisterKey('visibility_'+component.get('id')); var changeVisibility = function(){ if(effect && propertyEffect){ component.set(propertyEffect, effect); } component.set('visible', visible); if(component.get('class') == 'ViewerArea'){ try{ if(visible) component.restart(); else if(component.get('playbackState') == 'playing') component.pause(); } catch(e){}; } }; var effectTimeoutName = 'effectTimeout_'+component.get('id'); if(!ignoreClearTimeout && window.hasOwnProperty(effectTimeoutName)){ var effectTimeout = window[effectTimeoutName]; if(effectTimeout instanceof Array){ for(var i=0; i<effectTimeout.length; i++){ clearTimeout(effectTimeout[i]) } }else{ clearTimeout(effectTimeout); } delete window[effectTimeoutName]; } else if(visible == component.get('visible') && !ignoreClearTimeout) return; if(applyAt && applyAt > 0){ var effectTimeout = setTimeout(function(){ if(window[effectTimeoutName] instanceof Array) { var arrayTimeoutVal = window[effectTimeoutName]; var index = arrayTimeoutVal.indexOf(effectTimeout); arrayTimeoutVal.splice(index, 1); if(arrayTimeoutVal.length == 0){ delete window[effectTimeoutName]; } }else{ delete window[effectTimeoutName]; } changeVisibility(); }, applyAt); if(window.hasOwnProperty(effectTimeoutName)){ window[effectTimeoutName] = [window[effectTimeoutName], effectTimeout]; }else{ window[effectTimeoutName] = effectTimeout; } } else{ changeVisibility(); } },
  "shareWhatsapp": function(url){  window.open('https://api.whatsapp.com/send/?text=' + encodeURIComponent(url), '_blank'); },
  "getMediaWidth": function(media){  switch(media.get('class')){ case 'Video360': var res = media.get('video'); if(res instanceof Array){ var maxW=0; for(var i=0; i<res.length; i++){ var r = res[i]; if(r.get('width') > maxW) maxW = r.get('width'); } return maxW; }else{ return r.get('width') } default: return media.get('width'); } },
  "setMediaBehaviour": function(playList, index, mediaDispatcher){  var self = this; var stateChangeFunction = function(event){ if(event.data.state == 'stopped'){ dispose.call(this, true); } }; var onBeginFunction = function() { item.unbind('begin', onBeginFunction, self); var media = item.get('media'); if(media.get('class') != 'Panorama' || (media.get('camera') != undefined && media.get('camera').get('initialSequence') != undefined)){ player.bind('stateChange', stateChangeFunction, self); } }; var changeFunction = function(){ var index = playListDispatcher.get('selectedIndex'); if(index != -1){ indexDispatcher = index; dispose.call(this, false); } }; var disposeCallback = function(){ dispose.call(this, false); }; var dispose = function(forceDispose){ if(!playListDispatcher) return; var media = item.get('media'); if((media.get('class') == 'Video360' || media.get('class') == 'Video') && media.get('loop') == true && !forceDispose) return; playList.set('selectedIndex', -1); if(panoramaSequence && panoramaSequenceIndex != -1){ if(panoramaSequence) { if(panoramaSequenceIndex > 0 && panoramaSequence.get('movements')[panoramaSequenceIndex-1].get('class') == 'TargetPanoramaCameraMovement'){ var initialPosition = camera.get('initialPosition'); var oldYaw = initialPosition.get('yaw'); var oldPitch = initialPosition.get('pitch'); var oldHfov = initialPosition.get('hfov'); var previousMovement = panoramaSequence.get('movements')[panoramaSequenceIndex-1]; initialPosition.set('yaw', previousMovement.get('targetYaw')); initialPosition.set('pitch', previousMovement.get('targetPitch')); initialPosition.set('hfov', previousMovement.get('targetHfov')); var restoreInitialPositionFunction = function(event){ initialPosition.set('yaw', oldYaw); initialPosition.set('pitch', oldPitch); initialPosition.set('hfov', oldHfov); itemDispatcher.unbind('end', restoreInitialPositionFunction, this); }; itemDispatcher.bind('end', restoreInitialPositionFunction, this); } panoramaSequence.set('movementIndex', panoramaSequenceIndex); } } if(player){ item.unbind('begin', onBeginFunction, this); player.unbind('stateChange', stateChangeFunction, this); for(var i = 0; i<buttons.length; ++i) { buttons[i].unbind('click', disposeCallback, this); } } if(sameViewerArea){ var currentMedia = this.getMediaFromPlayer(player); if(currentMedia == undefined || currentMedia == item.get('media')){ playListDispatcher.set('selectedIndex', indexDispatcher); } if(playList != playListDispatcher) playListDispatcher.unbind('change', changeFunction, this); } else{ viewerArea.set('visible', viewerVisibility); } playListDispatcher = undefined; }; var mediaDispatcherByParam = mediaDispatcher != undefined; if(!mediaDispatcher){ var currentIndex = playList.get('selectedIndex'); var currentPlayer = (currentIndex != -1) ? playList.get('items')[playList.get('selectedIndex')].get('player') : this.getActivePlayerWithViewer(this.MainViewer); if(currentPlayer) { mediaDispatcher = this.getMediaFromPlayer(currentPlayer); } } var playListDispatcher = mediaDispatcher ? this.getPlayListWithMedia(mediaDispatcher, true) : undefined; if(!playListDispatcher){ playList.set('selectedIndex', index); return; } var indexDispatcher = playListDispatcher.get('selectedIndex'); if(playList.get('selectedIndex') == index || indexDispatcher == -1){ return; } var item = playList.get('items')[index]; var itemDispatcher = playListDispatcher.get('items')[indexDispatcher]; var player = item.get('player'); var viewerArea = player.get('viewerArea'); var viewerVisibility = viewerArea.get('visible'); var sameViewerArea = viewerArea == itemDispatcher.get('player').get('viewerArea'); if(sameViewerArea){ if(playList != playListDispatcher){ playListDispatcher.set('selectedIndex', -1); playListDispatcher.bind('change', changeFunction, this); } } else{ viewerArea.set('visible', true); } var panoramaSequenceIndex = -1; var panoramaSequence = undefined; var camera = itemDispatcher.get('camera'); if(camera){ panoramaSequence = camera.get('initialSequence'); if(panoramaSequence) { panoramaSequenceIndex = panoramaSequence.get('movementIndex'); } } playList.set('selectedIndex', index); var buttons = []; var addButtons = function(property){ var value = player.get(property); if(value == undefined) return; if(Array.isArray(value)) buttons = buttons.concat(value); else buttons.push(value); }; addButtons('buttonStop'); for(var i = 0; i<buttons.length; ++i) { buttons[i].bind('click', disposeCallback, this); } if(player != itemDispatcher.get('player') || !mediaDispatcherByParam){ item.bind('begin', onBeginFunction, self); } this.executeFunctionWhenChange(playList, index, disposeCallback); },
  "autotriggerAtStart": function(playList, callback, once){  var onChange = function(event){ callback(); if(once == true) playList.unbind('change', onChange, this); }; playList.bind('change', onChange, this); },
  "playGlobalAudioWhilePlay": function(playList, index, audio, endCallback){  var changeFunction = function(event){ if(event.data.previousSelectedIndex == index){ this.stopGlobalAudio(audio); if(isPanorama) { var media = playListItem.get('media'); var audios = media.get('audios'); audios.splice(audios.indexOf(audio), 1); media.set('audios', audios); } playList.unbind('change', changeFunction, this); if(endCallback) endCallback(); } }; var audios = window.currentGlobalAudios; if(audios && audio.get('id') in audios){ audio = audios[audio.get('id')]; if(audio.get('state') != 'playing'){ audio.play(); } return audio; } playList.bind('change', changeFunction, this); var playListItem = playList.get('items')[index]; var isPanorama = playListItem.get('class') == 'PanoramaPlayListItem'; if(isPanorama) { var media = playListItem.get('media'); var audios = (media.get('audios') || []).slice(); if(audio.get('class') == 'MediaAudio') { var panoramaAudio = this.rootPlayer.createInstance('PanoramaAudio'); panoramaAudio.set('autoplay', false); panoramaAudio.set('audio', audio.get('audio')); panoramaAudio.set('loop', audio.get('loop')); panoramaAudio.set('id', audio.get('id')); var stateChangeFunctions = audio.getBindings('stateChange'); for(var i = 0; i<stateChangeFunctions.length; ++i){ var f = stateChangeFunctions[i]; if(typeof f == 'string') f = new Function('event', f); panoramaAudio.bind('stateChange', f, this); } audio = panoramaAudio; } audios.push(audio); media.set('audios', audios); } return this.playGlobalAudio(audio, endCallback); },
  "keepComponentVisibility": function(component, keep){  var key = 'keepVisibility_' + component.get('id'); var value = this.getKey(key); if(value == undefined && keep) { this.registerKey(key, keep); } else if(value != undefined && !keep) { this.unregisterKey(key); } },
  "setPanoramaCameraWithSpot": function(playListItem, yaw, pitch){  var panorama = playListItem.get('media'); var newCamera = this.cloneCamera(playListItem.get('camera')); var initialPosition = newCamera.get('initialPosition'); initialPosition.set('yaw', yaw); initialPosition.set('pitch', pitch); this.startPanoramaWithCamera(panorama, newCamera); },
  "setEndToItemIndex": function(playList, fromIndex, toIndex){  var endFunction = function(){ if(playList.get('selectedIndex') == fromIndex) playList.set('selectedIndex', toIndex); }; this.executeFunctionWhenChange(playList, fromIndex, endFunction); },
  "resumeGlobalAudios": function(caller){  if (window.pauseGlobalAudiosState == undefined || !(caller in window.pauseGlobalAudiosState)) return; var audiosPaused = window.pauseGlobalAudiosState[caller]; delete window.pauseGlobalAudiosState[caller]; var values = Object.values(window.pauseGlobalAudiosState); for (var i = 0, count = values.length; i<count; ++i) { var objAudios = values[i]; for (var j = audiosPaused.length-1; j>=0; --j) { var a = audiosPaused[j]; if(objAudios.indexOf(a) != -1) audiosPaused.splice(j, 1); } } for (var i = 0, count = audiosPaused.length; i<count; ++i) { var a = audiosPaused[i]; if (a.get('state') == 'paused') a.play(); } },
  "cloneCamera": function(camera){  var newCamera = this.rootPlayer.createInstance(camera.get('class')); newCamera.set('id', camera.get('id') + '_copy'); newCamera.set('idleSequence', camera.get('initialSequence')); return newCamera; },
  "showWindow": function(w, autoCloseMilliSeconds, containsAudio){  if(w.get('visible') == true){ return; } var closeFunction = function(){ clearAutoClose(); this.resumePlayers(playersPaused, !containsAudio); w.unbind('close', closeFunction, this); }; var clearAutoClose = function(){ w.unbind('click', clearAutoClose, this); if(timeoutID != undefined){ clearTimeout(timeoutID); } }; var timeoutID = undefined; if(autoCloseMilliSeconds){ var autoCloseFunction = function(){ w.hide(); }; w.bind('click', clearAutoClose, this); timeoutID = setTimeout(autoCloseFunction, autoCloseMilliSeconds); } var playersPaused = this.pauseCurrentPlayers(!containsAudio); w.bind('close', closeFunction, this); w.show(this, true); },
  "getPanoramaOverlayByName": function(panorama, name){  var overlays = this.getOverlays(panorama); for(var i = 0, count = overlays.length; i<count; ++i){ var overlay = overlays[i]; var data = overlay.get('data'); if(data != undefined && data.label == name){ return overlay; } } return undefined; },
  "init": function(){  if(!Object.hasOwnProperty('values')) { Object.values = function(o){ return Object.keys(o).map(function(e) { return o[e]; }); }; } var history = this.get('data')['history']; var playListChangeFunc = function(e){ var playList = e.source; var index = playList.get('selectedIndex'); if(index < 0) return; var id = playList.get('id'); if(!history.hasOwnProperty(id)) history[id] = new HistoryData(playList); history[id].add(index); }; var playLists = this.getByClassName('PlayList'); for(var i = 0, count = playLists.length; i<count; ++i) { var playList = playLists[i]; playList.bind('change', playListChangeFunc, this); } },
  "setMainMediaByIndex": function(index){  var item = undefined; if(index >= 0 && index < this.mainPlayList.get('items').length){ this.mainPlayList.set('selectedIndex', index); item = this.mainPlayList.get('items')[index]; } return item; },
  "getPixels": function(value){  var result = new RegExp('((\\+|\\-)?\\d+(\\.\\d*)?)(px|vw|vh|vmin|vmax)?', 'i').exec(value); if (result == undefined) { return 0; } var num = parseFloat(result[1]); var unit = result[4]; var vw = this.rootPlayer.get('actualWidth') / 100; var vh = this.rootPlayer.get('actualHeight') / 100; switch(unit) { case 'vw': return num * vw; case 'vh': return num * vh; case 'vmin': return num * Math.min(vw, vh); case 'vmax': return num * Math.max(vw, vh); default: return num; } },
  "resumePlayers": function(players, onlyResumeCameraIfPanorama){  for(var i = 0; i<players.length; ++i){ var player = players[i]; if(onlyResumeCameraIfPanorama && player.get('class') == 'PanoramaPlayer' && typeof player.get('video') === 'undefined'){ player.resumeCamera(); } else{ player.play(); } } },
  "initGA": function(){  var sendFunc = function(category, event, label) { ga('send', 'event', category, event, label); }; var media = this.getByClassName('Panorama'); media = media.concat(this.getByClassName('Video360')); media = media.concat(this.getByClassName('Map')); for(var i = 0, countI = media.length; i<countI; ++i){ var m = media[i]; var mediaLabel = m.get('label'); var overlays = this.getOverlays(m); for(var j = 0, countJ = overlays.length; j<countJ; ++j){ var overlay = overlays[j]; var overlayLabel = overlay.get('data') != undefined ? mediaLabel + ' - ' + overlay.get('data')['label'] : mediaLabel; switch(overlay.get('class')) { case 'HotspotPanoramaOverlay': case 'HotspotMapOverlay': var areas = overlay.get('areas'); for (var z = 0; z<areas.length; ++z) { areas[z].bind('click', sendFunc.bind(this, 'Hotspot', 'click', overlayLabel), this); } break; case 'CeilingCapPanoramaOverlay': case 'TripodCapPanoramaOverlay': overlay.bind('click', sendFunc.bind(this, 'Cap', 'click', overlayLabel), this); break; } } } var components = this.getByClassName('Button'); components = components.concat(this.getByClassName('IconButton')); for(var i = 0, countI = components.length; i<countI; ++i){ var c = components[i]; var componentLabel = c.get('data')['name']; c.bind('click', sendFunc.bind(this, 'Skin', 'click', componentLabel), this); } var items = this.getByClassName('PlayListItem'); var media2Item = {}; for(var i = 0, countI = items.length; i<countI; ++i) { var item = items[i]; var media = item.get('media'); if(!(media.get('id') in media2Item)) { item.bind('begin', sendFunc.bind(this, 'Media', 'play', media.get('label')), this); media2Item[media.get('id')] = item; } } },
  "getMediaHeight": function(media){  switch(media.get('class')){ case 'Video360': var res = media.get('video'); if(res instanceof Array){ var maxH=0; for(var i=0; i<res.length; i++){ var r = res[i]; if(r.get('height') > maxH) maxH = r.get('height'); } return maxH; }else{ return r.get('height') } default: return media.get('height'); } },
  "showComponentsWhileMouseOver": function(parentComponent, components, durationVisibleWhileOut){  var setVisibility = function(visible){ for(var i = 0, length = components.length; i<length; i++){ var component = components[i]; if(component.get('class') == 'HTMLText' && (component.get('html') == '' || component.get('html') == undefined)) { continue; } component.set('visible', visible); } }; if (this.rootPlayer.get('touchDevice') == true){ setVisibility(true); } else { var timeoutID = -1; var rollOverFunction = function(){ setVisibility(true); if(timeoutID >= 0) clearTimeout(timeoutID); parentComponent.unbind('rollOver', rollOverFunction, this); parentComponent.bind('rollOut', rollOutFunction, this); }; var rollOutFunction = function(){ var timeoutFunction = function(){ setVisibility(false); parentComponent.unbind('rollOver', rollOverFunction, this); }; parentComponent.unbind('rollOut', rollOutFunction, this); parentComponent.bind('rollOver', rollOverFunction, this); timeoutID = setTimeout(timeoutFunction, durationVisibleWhileOut); }; parentComponent.bind('rollOver', rollOverFunction, this); } },
  "registerKey": function(key, value){  window[key] = value; },
  "getMediaFromPlayer": function(player){  switch(player.get('class')){ case 'PanoramaPlayer': return player.get('panorama') || player.get('video'); case 'VideoPlayer': case 'Video360Player': return player.get('video'); case 'PhotoAlbumPlayer': return player.get('photoAlbum'); case 'MapPlayer': return player.get('map'); } },
  "historyGoForward": function(playList){  var history = this.get('data')['history'][playList.get('id')]; if(history != undefined) { history.forward(); } },
  "shareFacebook": function(url){  window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank'); },
  "fixTogglePlayPauseButton": function(player){  var state = player.get('state'); var buttons = player.get('buttonPlayPause'); if(typeof buttons !== 'undefined' && player.get('state') == 'playing'){ if(!Array.isArray(buttons)) buttons = [buttons]; for(var i = 0; i<buttons.length; ++i) buttons[i].set('pressed', true); } },
  "getCurrentPlayerWithMedia": function(media){  var playerClass = undefined; var mediaPropertyName = undefined; switch(media.get('class')) { case 'Panorama': case 'LivePanorama': case 'HDRPanorama': playerClass = 'PanoramaPlayer'; mediaPropertyName = 'panorama'; break; case 'Video360': playerClass = 'PanoramaPlayer'; mediaPropertyName = 'video'; break; case 'PhotoAlbum': playerClass = 'PhotoAlbumPlayer'; mediaPropertyName = 'photoAlbum'; break; case 'Map': playerClass = 'MapPlayer'; mediaPropertyName = 'map'; break; case 'Video': playerClass = 'VideoPlayer'; mediaPropertyName = 'video'; break; }; if(playerClass != undefined) { var players = this.getByClassName(playerClass); for(var i = 0; i<players.length; ++i){ var player = players[i]; if(player.get(mediaPropertyName) == media) { return player; } } } else { return undefined; } },
  "getPlayListItems": function(media, player){  var itemClass = (function() { switch(media.get('class')) { case 'Panorama': case 'LivePanorama': case 'HDRPanorama': return 'PanoramaPlayListItem'; case 'Video360': return 'Video360PlayListItem'; case 'PhotoAlbum': return 'PhotoAlbumPlayListItem'; case 'Map': return 'MapPlayListItem'; case 'Video': return 'VideoPlayListItem'; } })(); if (itemClass != undefined) { var items = this.getByClassName(itemClass); for (var i = items.length-1; i>=0; --i) { var item = items[i]; if(item.get('media') != media || (player != undefined && item.get('player') != player)) { items.splice(i, 1); } } return items; } else { return []; } },
  "getCurrentPlayers": function(){  var players = this.getByClassName('PanoramaPlayer'); players = players.concat(this.getByClassName('VideoPlayer')); players = players.concat(this.getByClassName('Video360Player')); players = players.concat(this.getByClassName('PhotoAlbumPlayer')); return players; },
  "loadFromCurrentMediaPlayList": function(playList, delta){  var currentIndex = playList.get('selectedIndex'); var totalItems = playList.get('items').length; var newIndex = (currentIndex + delta) % totalItems; while(newIndex < 0){ newIndex = totalItems + newIndex; }; if(currentIndex != newIndex){ playList.set('selectedIndex', newIndex); } },
  "triggerOverlay": function(overlay, eventName){  if(overlay.get('areas') != undefined) { var areas = overlay.get('areas'); for(var i = 0; i<areas.length; ++i) { areas[i].trigger(eventName); } } else { overlay.trigger(eventName); } },
  "pauseCurrentPlayers": function(onlyPauseCameraIfPanorama){  var players = this.getCurrentPlayers(); var i = players.length; while(i-- > 0){ var player = players[i]; if(player.get('state') == 'playing') { if(onlyPauseCameraIfPanorama && player.get('class') == 'PanoramaPlayer' && typeof player.get('video') === 'undefined'){ player.pauseCamera(); } else { player.pause(); } } else { players.splice(i, 1); } } return players; },
  "playGlobalAudio": function(audio, endCallback){  var endFunction = function(){ audio.unbind('end', endFunction, this); this.stopGlobalAudio(audio); if(endCallback) endCallback(); }; audio = this.getGlobalAudio(audio); var audios = window.currentGlobalAudios; if(!audios){ audios = window.currentGlobalAudios = {}; } audios[audio.get('id')] = audio; if(audio.get('state') == 'playing'){ return audio; } if(!audio.get('loop')){ audio.bind('end', endFunction, this); } audio.play(); return audio; },
  "pauseGlobalAudios": function(caller, exclude){  if (window.pauseGlobalAudiosState == undefined) window.pauseGlobalAudiosState = {}; if (window.pauseGlobalAudiosList == undefined) window.pauseGlobalAudiosList = []; if (caller in window.pauseGlobalAudiosState) { return; } var audios = this.getByClassName('Audio').concat(this.getByClassName('VideoPanoramaOverlay')); if (window.currentGlobalAudios != undefined) audios = audios.concat(Object.values(window.currentGlobalAudios)); var audiosPaused = []; var values = Object.values(window.pauseGlobalAudiosState); for (var i = 0, count = values.length; i<count; ++i) { var objAudios = values[i]; for (var j = 0; j<objAudios.length; ++j) { var a = objAudios[j]; if(audiosPaused.indexOf(a) == -1) audiosPaused.push(a); } } window.pauseGlobalAudiosState[caller] = audiosPaused; for (var i = 0, count = audios.length; i < count; ++i) { var a = audios[i]; if (a.get('state') == 'playing' && (exclude == undefined || exclude.indexOf(a) == -1)) { a.pause(); audiosPaused.push(a); } } },
  "shareTwitter": function(url){  window.open('https://twitter.com/intent/tweet?source=webclient&url=' + url, '_blank'); },
  "playAudioList": function(audios){  if(audios.length == 0) return; var currentAudioCount = -1; var currentAudio; var playGlobalAudioFunction = this.playGlobalAudio; var playNext = function(){ if(++currentAudioCount >= audios.length) currentAudioCount = 0; currentAudio = audios[currentAudioCount]; playGlobalAudioFunction(currentAudio, playNext); }; playNext(); },
  "getPlayListItemByMedia": function(playList, media){  var items = playList.get('items'); for(var j = 0, countJ = items.length; j<countJ; ++j){ var item = items[j]; if(item.get('media') == media) return item; } return undefined; },
  "changeBackgroundWhilePlay": function(playList, index, color){  var stopFunction = function(event){ playListItem.unbind('stop', stopFunction, this); if((color == viewerArea.get('backgroundColor')) && (colorRatios == viewerArea.get('backgroundColorRatios'))){ viewerArea.set('backgroundColor', backgroundColorBackup); viewerArea.set('backgroundColorRatios', backgroundColorRatiosBackup); } }; var playListItem = playList.get('items')[index]; var player = playListItem.get('player'); var viewerArea = player.get('viewerArea'); var backgroundColorBackup = viewerArea.get('backgroundColor'); var backgroundColorRatiosBackup = viewerArea.get('backgroundColorRatios'); var colorRatios = [0]; if((color != backgroundColorBackup) || (colorRatios != backgroundColorRatiosBackup)){ viewerArea.set('backgroundColor', color); viewerArea.set('backgroundColorRatios', colorRatios); playListItem.bind('stop', stopFunction, this); } },
  "unregisterKey": function(key){  delete window[key]; },
  "updateMediaLabelFromPlayList": function(playList, htmlText, playListItemStopToDispose){  var changeFunction = function(){ var index = playList.get('selectedIndex'); if(index >= 0){ var beginFunction = function(){ playListItem.unbind('begin', beginFunction); setMediaLabel(index); }; var setMediaLabel = function(index){ var media = playListItem.get('media'); var text = media.get('data'); if(!text) text = media.get('label'); setHtml(text); }; var setHtml = function(text){ if(text !== undefined) { htmlText.set('html', '<div style=\"text-align:left\"><SPAN STYLE=\"color:#FFFFFF;font-size:12px;font-family:Verdana\"><span color=\"white\" font-family=\"Verdana\" font-size=\"12px\">' + text + '</SPAN></div>'); } else { htmlText.set('html', ''); } }; var playListItem = playList.get('items')[index]; if(htmlText.get('html')){ setHtml('Loading...'); playListItem.bind('begin', beginFunction); } else{ setMediaLabel(index); } } }; var disposeFunction = function(){ htmlText.set('html', undefined); playList.unbind('change', changeFunction, this); playListItemStopToDispose.unbind('stop', disposeFunction, this); }; if(playListItemStopToDispose){ playListItemStopToDispose.bind('stop', disposeFunction, this); } playList.bind('change', changeFunction, this); changeFunction(); },
  "showPopupImage": function(image, toggleImage, customWidth, customHeight, showEffect, hideEffect, closeButtonProperties, autoCloseMilliSeconds, audio, stopBackgroundAudio, loadedCallback, hideCallback){  var self = this; var closed = false; var playerClickFunction = function() { zoomImage.unbind('loaded', loadedFunction, self); hideFunction(); }; var clearAutoClose = function(){ zoomImage.unbind('click', clearAutoClose, this); if(timeoutID != undefined){ clearTimeout(timeoutID); } }; var resizeFunction = function(){ setTimeout(setCloseButtonPosition, 0); }; var loadedFunction = function(){ self.unbind('click', playerClickFunction, self); veil.set('visible', true); setCloseButtonPosition(); closeButton.set('visible', true); zoomImage.unbind('loaded', loadedFunction, this); zoomImage.bind('userInteractionStart', userInteractionStartFunction, this); zoomImage.bind('userInteractionEnd', userInteractionEndFunction, this); zoomImage.bind('resize', resizeFunction, this); timeoutID = setTimeout(timeoutFunction, 200); }; var timeoutFunction = function(){ timeoutID = undefined; if(autoCloseMilliSeconds){ var autoCloseFunction = function(){ hideFunction(); }; zoomImage.bind('click', clearAutoClose, this); timeoutID = setTimeout(autoCloseFunction, autoCloseMilliSeconds); } zoomImage.bind('backgroundClick', hideFunction, this); if(toggleImage) { zoomImage.bind('click', toggleFunction, this); zoomImage.set('imageCursor', 'hand'); } closeButton.bind('click', hideFunction, this); if(loadedCallback) loadedCallback(); }; var hideFunction = function() { self.MainViewer.set('toolTipEnabled', true); closed = true; if(timeoutID) clearTimeout(timeoutID); if (timeoutUserInteractionID) clearTimeout(timeoutUserInteractionID); if(autoCloseMilliSeconds) clearAutoClose(); if(hideCallback) hideCallback(); zoomImage.set('visible', false); if(hideEffect && hideEffect.get('duration') > 0){ hideEffect.bind('end', endEffectFunction, this); } else{ zoomImage.set('image', null); } closeButton.set('visible', false); veil.set('visible', false); self.unbind('click', playerClickFunction, self); zoomImage.unbind('backgroundClick', hideFunction, this); zoomImage.unbind('userInteractionStart', userInteractionStartFunction, this); zoomImage.unbind('userInteractionEnd', userInteractionEndFunction, this, true); zoomImage.unbind('resize', resizeFunction, this); if(toggleImage) { zoomImage.unbind('click', toggleFunction, this); zoomImage.set('cursor', 'default'); } closeButton.unbind('click', hideFunction, this); self.resumePlayers(playersPaused, audio == null || stopBackgroundAudio); if(audio){ if(stopBackgroundAudio){ self.resumeGlobalAudios(); } self.stopGlobalAudio(audio); } }; var endEffectFunction = function() { zoomImage.set('image', null); hideEffect.unbind('end', endEffectFunction, this); }; var toggleFunction = function() { zoomImage.set('image', isToggleVisible() ? image : toggleImage); }; var isToggleVisible = function() { return zoomImage.get('image') == toggleImage; }; var setCloseButtonPosition = function() { var right = zoomImage.get('actualWidth') - zoomImage.get('imageLeft') - zoomImage.get('imageWidth') + 10; var top = zoomImage.get('imageTop') + 10; if(right < 10) right = 10; if(top < 10) top = 10; closeButton.set('right', right); closeButton.set('top', top); }; var userInteractionStartFunction = function() { if(timeoutUserInteractionID){ clearTimeout(timeoutUserInteractionID); timeoutUserInteractionID = undefined; } else{ closeButton.set('visible', false); } }; var userInteractionEndFunction = function() { if(!closed){ timeoutUserInteractionID = setTimeout(userInteractionTimeoutFunction, 300); } }; var userInteractionTimeoutFunction = function() { timeoutUserInteractionID = undefined; closeButton.set('visible', true); setCloseButtonPosition(); }; this.MainViewer.set('toolTipEnabled', false); var veil = this.veilPopupPanorama; var zoomImage = this.zoomImagePopupPanorama; var closeButton = this.closeButtonPopupPanorama; if(closeButtonProperties){ for(var key in closeButtonProperties){ closeButton.set(key, closeButtonProperties[key]); } } var playersPaused = this.pauseCurrentPlayers(audio == null || !stopBackgroundAudio); if(audio){ if(stopBackgroundAudio){ this.pauseGlobalAudios(); } this.playGlobalAudio(audio); } var timeoutID = undefined; var timeoutUserInteractionID = undefined; zoomImage.bind('loaded', loadedFunction, this); setTimeout(function(){ self.bind('click', playerClickFunction, self, false); }, 0); zoomImage.set('image', image); zoomImage.set('customWidth', customWidth); zoomImage.set('customHeight', customHeight); zoomImage.set('showEffect', showEffect); zoomImage.set('hideEffect', hideEffect); zoomImage.set('visible', true); return zoomImage; },
  "getPlayListWithMedia": function(media, onlySelected){  var playLists = this.getByClassName('PlayList'); for(var i = 0, count = playLists.length; i<count; ++i){ var playList = playLists[i]; if(onlySelected && playList.get('selectedIndex') == -1) continue; if(this.getPlayListItemByMedia(playList, media) != undefined) return playList; } return undefined; },
  "setStartTimeVideo": function(video, time){  var items = this.getPlayListItems(video); var startTimeBackup = []; var restoreStartTimeFunc = function() { for(var i = 0; i<items.length; ++i){ var item = items[i]; item.set('startTime', startTimeBackup[i]); item.unbind('stop', restoreStartTimeFunc, this); } }; for(var i = 0; i<items.length; ++i) { var item = items[i]; var player = item.get('player'); if(player.get('video') == video && player.get('state') == 'playing') { player.seek(time); } else { startTimeBackup.push(item.get('startTime')); item.set('startTime', time); item.bind('stop', restoreStartTimeFunc, this); } } },
  "stopAndGoCamera": function(camera, ms){  var sequence = camera.get('initialSequence'); sequence.pause(); var timeoutFunction = function(){ sequence.play(); }; setTimeout(timeoutFunction, ms); },
  "setMapLocation": function(panoramaPlayListItem, mapPlayer){  var resetFunction = function(){ panoramaPlayListItem.unbind('stop', resetFunction, this); player.set('mapPlayer', null); }; panoramaPlayListItem.bind('stop', resetFunction, this); var player = panoramaPlayListItem.get('player'); player.set('mapPlayer', mapPlayer); },
  "getGlobalAudio": function(audio){  var audios = window.currentGlobalAudios; if(audios != undefined && audio.get('id') in audios){ audio = audios[audio.get('id')]; } return audio; },
  "getActivePlayerWithViewer": function(viewerArea){  var players = this.getByClassName('PanoramaPlayer'); players = players.concat(this.getByClassName('VideoPlayer')); players = players.concat(this.getByClassName('Video360Player')); players = players.concat(this.getByClassName('PhotoAlbumPlayer')); players = players.concat(this.getByClassName('MapPlayer')); var i = players.length; while(i-- > 0){ var player = players[i]; if(player.get('viewerArea') == viewerArea) { var playerClass = player.get('class'); if(playerClass == 'PanoramaPlayer' && (player.get('panorama') != undefined || player.get('video') != undefined)) return player; else if((playerClass == 'VideoPlayer' || playerClass == 'Video360Player') && player.get('video') != undefined) return player; else if(playerClass == 'PhotoAlbumPlayer' && player.get('photoAlbum') != undefined) return player; else if(playerClass == 'MapPlayer' && player.get('map') != undefined) return player; } } return undefined; },
  "setStartTimeVideoSync": function(video, player){  this.setStartTimeVideo(video, player.get('currentTime')); },
  "startPanoramaWithCamera": function(media, camera){  if(window.currentPanoramasWithCameraChanged != undefined && window.currentPanoramasWithCameraChanged.indexOf(media) != -1){ return; } var playLists = this.getByClassName('PlayList'); if(playLists.length == 0) return; var restoreItems = []; for(var i = 0, count = playLists.length; i<count; ++i){ var playList = playLists[i]; var items = playList.get('items'); for(var j = 0, countJ = items.length; j<countJ; ++j){ var item = items[j]; if(item.get('media') == media && (item.get('class') == 'PanoramaPlayListItem' || item.get('class') == 'Video360PlayListItem')){ restoreItems.push({camera: item.get('camera'), item: item}); item.set('camera', camera); } } } if(restoreItems.length > 0) { if(window.currentPanoramasWithCameraChanged == undefined) { window.currentPanoramasWithCameraChanged = [media]; } else { window.currentPanoramasWithCameraChanged.push(media); } var restoreCameraOnStop = function(){ var index = window.currentPanoramasWithCameraChanged.indexOf(media); if(index != -1) { window.currentPanoramasWithCameraChanged.splice(index, 1); } for (var i = 0; i < restoreItems.length; i++) { restoreItems[i].item.set('camera', restoreItems[i].camera); restoreItems[i].item.unbind('stop', restoreCameraOnStop, this); } }; for (var i = 0; i < restoreItems.length; i++) { restoreItems[i].item.bind('stop', restoreCameraOnStop, this); } } },
  "showPopupPanoramaOverlay": function(popupPanoramaOverlay, closeButtonProperties, imageHD, toggleImage, toggleImageHD, autoCloseMilliSeconds, audio, stopBackgroundAudio){  var self = this; this.MainViewer.set('toolTipEnabled', false); var cardboardEnabled = this.isCardboardViewMode(); if(!cardboardEnabled) { var zoomImage = this.zoomImagePopupPanorama; var showDuration = popupPanoramaOverlay.get('showDuration'); var hideDuration = popupPanoramaOverlay.get('hideDuration'); var playersPaused = this.pauseCurrentPlayers(audio == null || !stopBackgroundAudio); var popupMaxWidthBackup = popupPanoramaOverlay.get('popupMaxWidth'); var popupMaxHeightBackup = popupPanoramaOverlay.get('popupMaxHeight'); var showEndFunction = function() { var loadedFunction = function(){ if(!self.isCardboardViewMode()) popupPanoramaOverlay.set('visible', false); }; popupPanoramaOverlay.unbind('showEnd', showEndFunction, self); popupPanoramaOverlay.set('showDuration', 1); popupPanoramaOverlay.set('hideDuration', 1); self.showPopupImage(imageHD, toggleImageHD, popupPanoramaOverlay.get('popupMaxWidth'), popupPanoramaOverlay.get('popupMaxHeight'), null, null, closeButtonProperties, autoCloseMilliSeconds, audio, stopBackgroundAudio, loadedFunction, hideFunction); }; var hideFunction = function() { var restoreShowDurationFunction = function(){ popupPanoramaOverlay.unbind('showEnd', restoreShowDurationFunction, self); popupPanoramaOverlay.set('visible', false); popupPanoramaOverlay.set('showDuration', showDuration); popupPanoramaOverlay.set('popupMaxWidth', popupMaxWidthBackup); popupPanoramaOverlay.set('popupMaxHeight', popupMaxHeightBackup); }; self.resumePlayers(playersPaused, audio == null || !stopBackgroundAudio); var currentWidth = zoomImage.get('imageWidth'); var currentHeight = zoomImage.get('imageHeight'); popupPanoramaOverlay.bind('showEnd', restoreShowDurationFunction, self, true); popupPanoramaOverlay.set('showDuration', 1); popupPanoramaOverlay.set('hideDuration', hideDuration); popupPanoramaOverlay.set('popupMaxWidth', currentWidth); popupPanoramaOverlay.set('popupMaxHeight', currentHeight); if(popupPanoramaOverlay.get('visible')) restoreShowDurationFunction(); else popupPanoramaOverlay.set('visible', true); self.MainViewer.set('toolTipEnabled', true); }; if(!imageHD){ imageHD = popupPanoramaOverlay.get('image'); } if(!toggleImageHD && toggleImage){ toggleImageHD = toggleImage; } popupPanoramaOverlay.bind('showEnd', showEndFunction, this, true); } else { var hideEndFunction = function() { self.resumePlayers(playersPaused, audio == null || stopBackgroundAudio); if(audio){ if(stopBackgroundAudio){ self.resumeGlobalAudios(); } self.stopGlobalAudio(audio); } popupPanoramaOverlay.unbind('hideEnd', hideEndFunction, self); self.MainViewer.set('toolTipEnabled', true); }; var playersPaused = this.pauseCurrentPlayers(audio == null || !stopBackgroundAudio); if(audio){ if(stopBackgroundAudio){ this.pauseGlobalAudios(); } this.playGlobalAudio(audio); } popupPanoramaOverlay.bind('hideEnd', hideEndFunction, this, true); } popupPanoramaOverlay.set('visible', true); },
  "showPopupMedia": function(w, media, playList, popupMaxWidth, popupMaxHeight, autoCloseWhenFinished, stopAudios){  var self = this; var closeFunction = function(){ playList.set('selectedIndex', -1); self.MainViewer.set('toolTipEnabled', true); if(stopAudios) { self.resumeGlobalAudios(); } this.resumePlayers(playersPaused, !stopAudios); if(isVideo) { this.unbind('resize', resizeFunction, this); } w.unbind('close', closeFunction, this); }; var endFunction = function(){ w.hide(); }; var resizeFunction = function(){ var getWinValue = function(property){ return w.get(property) || 0; }; var parentWidth = self.get('actualWidth'); var parentHeight = self.get('actualHeight'); var mediaWidth = self.getMediaWidth(media); var mediaHeight = self.getMediaHeight(media); var popupMaxWidthNumber = parseFloat(popupMaxWidth) / 100; var popupMaxHeightNumber = parseFloat(popupMaxHeight) / 100; var windowWidth = popupMaxWidthNumber * parentWidth; var windowHeight = popupMaxHeightNumber * parentHeight; var footerHeight = getWinValue('footerHeight'); var headerHeight = getWinValue('headerHeight'); if(!headerHeight) { var closeButtonHeight = getWinValue('closeButtonIconHeight') + getWinValue('closeButtonPaddingTop') + getWinValue('closeButtonPaddingBottom'); var titleHeight = self.getPixels(getWinValue('titleFontSize')) + getWinValue('titlePaddingTop') + getWinValue('titlePaddingBottom'); headerHeight = closeButtonHeight > titleHeight ? closeButtonHeight : titleHeight; headerHeight += getWinValue('headerPaddingTop') + getWinValue('headerPaddingBottom'); } var contentWindowWidth = windowWidth - getWinValue('bodyPaddingLeft') - getWinValue('bodyPaddingRight') - getWinValue('paddingLeft') - getWinValue('paddingRight'); var contentWindowHeight = windowHeight - headerHeight - footerHeight - getWinValue('bodyPaddingTop') - getWinValue('bodyPaddingBottom') - getWinValue('paddingTop') - getWinValue('paddingBottom'); var parentAspectRatio = contentWindowWidth / contentWindowHeight; var mediaAspectRatio = mediaWidth / mediaHeight; if(parentAspectRatio > mediaAspectRatio) { windowWidth = contentWindowHeight * mediaAspectRatio + getWinValue('bodyPaddingLeft') + getWinValue('bodyPaddingRight') + getWinValue('paddingLeft') + getWinValue('paddingRight'); } else { windowHeight = contentWindowWidth / mediaAspectRatio + headerHeight + footerHeight + getWinValue('bodyPaddingTop') + getWinValue('bodyPaddingBottom') + getWinValue('paddingTop') + getWinValue('paddingBottom'); } if(windowWidth > parentWidth * popupMaxWidthNumber) { windowWidth = parentWidth * popupMaxWidthNumber; } if(windowHeight > parentHeight * popupMaxHeightNumber) { windowHeight = parentHeight * popupMaxHeightNumber; } w.set('width', windowWidth); w.set('height', windowHeight); w.set('x', (parentWidth - getWinValue('actualWidth')) * 0.5); w.set('y', (parentHeight - getWinValue('actualHeight')) * 0.5); }; if(autoCloseWhenFinished){ this.executeFunctionWhenChange(playList, 0, endFunction); } var mediaClass = media.get('class'); var isVideo = mediaClass == 'Video' || mediaClass == 'Video360'; playList.set('selectedIndex', 0); if(isVideo){ this.bind('resize', resizeFunction, this); resizeFunction(); playList.get('items')[0].get('player').play(); } else { w.set('width', popupMaxWidth); w.set('height', popupMaxHeight); } this.MainViewer.set('toolTipEnabled', false); if(stopAudios) { this.pauseGlobalAudios(); } var playersPaused = this.pauseCurrentPlayers(!stopAudios); w.bind('close', closeFunction, this); w.show(this, true); },
  "showPopupPanoramaVideoOverlay": function(popupPanoramaOverlay, closeButtonProperties, stopAudios){  var self = this; var showEndFunction = function() { popupPanoramaOverlay.unbind('showEnd', showEndFunction); closeButton.bind('click', hideFunction, this); setCloseButtonPosition(); closeButton.set('visible', true); }; var endFunction = function() { if(!popupPanoramaOverlay.get('loop')) hideFunction(); }; var hideFunction = function() { self.MainViewer.set('toolTipEnabled', true); popupPanoramaOverlay.set('visible', false); closeButton.set('visible', false); closeButton.unbind('click', hideFunction, self); popupPanoramaOverlay.unbind('end', endFunction, self); popupPanoramaOverlay.unbind('hideEnd', hideFunction, self, true); self.resumePlayers(playersPaused, true); if(stopAudios) { self.resumeGlobalAudios(); } }; var setCloseButtonPosition = function() { var right = 10; var top = 10; closeButton.set('right', right); closeButton.set('top', top); }; this.MainViewer.set('toolTipEnabled', false); var closeButton = this.closeButtonPopupPanorama; if(closeButtonProperties){ for(var key in closeButtonProperties){ closeButton.set(key, closeButtonProperties[key]); } } var playersPaused = this.pauseCurrentPlayers(true); if(stopAudios) { this.pauseGlobalAudios(); } popupPanoramaOverlay.bind('end', endFunction, this, true); popupPanoramaOverlay.bind('showEnd', showEndFunction, this, true); popupPanoramaOverlay.bind('hideEnd', hideFunction, this, true); popupPanoramaOverlay.set('visible', true); },
  "loopAlbum": function(playList, index){  var playListItem = playList.get('items')[index]; var player = playListItem.get('player'); var loopFunction = function(){ player.play(); }; this.executeFunctionWhenChange(playList, index, loopFunction); },
  "existsKey": function(key){  return key in window; },
  "changePlayListWithSameSpot": function(playList, newIndex){  var currentIndex = playList.get('selectedIndex'); if (currentIndex >= 0 && newIndex >= 0 && currentIndex != newIndex) { var currentItem = playList.get('items')[currentIndex]; var newItem = playList.get('items')[newIndex]; var currentPlayer = currentItem.get('player'); var newPlayer = newItem.get('player'); if ((currentPlayer.get('class') == 'PanoramaPlayer' || currentPlayer.get('class') == 'Video360Player') && (newPlayer.get('class') == 'PanoramaPlayer' || newPlayer.get('class') == 'Video360Player')) { var newCamera = this.cloneCamera(newItem.get('camera')); this.setCameraSameSpotAsMedia(newCamera, currentItem.get('media')); this.startPanoramaWithCamera(newItem.get('media'), newCamera); } } },
  "getOverlays": function(media){  switch(media.get('class')){ case 'Panorama': var overlays = media.get('overlays').concat() || []; var frames = media.get('frames'); for(var j = 0; j<frames.length; ++j){ overlays = overlays.concat(frames[j].get('overlays') || []); } return overlays; case 'Video360': case 'Map': return media.get('overlays') || []; default: return []; } },
  "setMainMediaByName": function(name){  var items = this.mainPlayList.get('items'); for(var i = 0; i<items.length; ++i){ var item = items[i]; if(item.get('media').get('label') == name) { this.mainPlayList.set('selectedIndex', i); return item; } } },
  "historyGoBack": function(playList){  var history = this.get('data')['history'][playList.get('id')]; if(history != undefined) { history.back(); } },
  "pauseGlobalAudiosWhilePlayItem": function(playList, index, exclude){  var self = this; var item = playList.get('items')[index]; var media = item.get('media'); var player = item.get('player'); var caller = media.get('id'); var endFunc = function(){ if(playList.get('selectedIndex') != index) { if(hasState){ player.unbind('stateChange', stateChangeFunc, self); } self.resumeGlobalAudios(caller); } }; var stateChangeFunc = function(event){ var state = event.data.state; if(state == 'stopped'){ this.resumeGlobalAudios(caller); } else if(state == 'playing'){ this.pauseGlobalAudios(caller, exclude); } }; var mediaClass = media.get('class'); var hasState = mediaClass == 'Video360' || mediaClass == 'Video'; if(hasState){ player.bind('stateChange', stateChangeFunc, this); } this.pauseGlobalAudios(caller, exclude); this.executeFunctionWhenChange(playList, index, endFunc, endFunc); },
  "visibleComponentsIfPlayerFlagEnabled": function(components, playerFlag){  var enabled = this.get(playerFlag); for(var i in components){ components[i].set('visible', enabled); } },
  "openLink": function(url, name){  if(url == location.href) { return; } var isElectron = (window && window.process && window.process.versions && window.process.versions['electron']) || (navigator && navigator.userAgent && navigator.userAgent.indexOf('Electron') >= 0); if (name == '_blank' && isElectron) { if (url.startsWith('/')) { var r = window.location.href.split('/'); r.pop(); url = r.join('/') + url; } var extension = url.split('.').pop().toLowerCase(); if(extension != 'pdf' || url.startsWith('file://')) { var shell = window.require('electron').shell; shell.openExternal(url); } else { window.open(url, name); } } else if(isElectron && (name == '_top' || name == '_self')) { window.location = url; } else { var newWindow = window.open(url, name); newWindow.focus(); } },
  "getKey": function(key){  return window[key]; }
 },
 "scrollBarOpacity": 0.5,
 "buttonToggleFullscreen": "this.IconButton_EEFF957A_E389_9A06_41E1_2AD21904F8C0",
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 20,
 "verticalAlign": "top",
 "defaultVRPointer": "laser",
 "horizontalAlign": "left",
 "gap": 10,
 "height": "100%",
 "paddingBottom": 0,
 "buttonToggleMute": "this.IconButton_EED073D3_E38A_9E06_41E1_6CCC9722545D",
 "downloadEnabled": false,
 "shadow": false,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Player",
 "overflow": "visible",
 "definitions": [{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5",
 "thumbnailUrl": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_t.jpg",
 "label": "009 Keluar Rest Area",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_4B6C7F7E_6BB8_9D34_41AE_E8942C7873E4",
  "this.overlay_758A26C5_6BB8_8F54_41D1_D0CB7E13DAD2",
  "this.overlay_76997476_6BB8_8337_41D7_9B9B1B55DF40",
  "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_tcap0"
 ]
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4",
 "thumbnailUrl": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_t.jpg",
 "label": "011 Panjat Tebing Area",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_7344C8BB_6C77_833C_41D3_B53B58795A30",
  "this.panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 3.17,
  "pitch": 0.6
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4BCDCF31_6C9F_9ECC_41BE_A81FB8FA2C6C"
},
{
 "class": "PlayList",
 "items": [
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 0, 1)",
   "media": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 1, 2)",
   "media": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 2, 3)",
   "media": "this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 3, 4)",
   "media": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 4, 5)",
   "media": "this.panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 5, 6)",
   "media": "this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 6, 7)",
   "media": "this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 7, 8)",
   "media": "this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 8, 9)",
   "media": "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 9, 10)",
   "media": "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 10, 11)",
   "media": "this.panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "end": "this.trigger('tourEnded')",
   "camera": "this.panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_camera",
   "begin": "this.setEndToItemIndex(this.mainPlayList, 11, 0)",
   "media": "this.panorama_7DDBCAE6_6B97_8754_41D1_A76591989421",
   "player": "this.MainViewerPanoramaPlayer"
  }
 ],
 "id": "mainPlayList"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -8.54,
  "pitch": -5.42
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4BB7AF02_6C9F_9ECC_41AB_6762A182F227"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7E837B36_6B97_8534_41B3_B5698B90A766",
 "thumbnailUrl": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_t.jpg",
 "label": "008 Rest Area",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_74238361_6BB9_854C_41C3_F0009A988402",
  "this.overlay_76212135_6BB8_8534_41D8_CE40CA17408B",
  "this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_camera"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E",
 "thumbnailUrl": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_t.jpg",
 "label": "003 Papan Informasi",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_710B8FD3_6B9B_9D4C_41D2_0256CA1D0A7A",
  "this.overlay_7C5E5DC7_6B9B_7D54_41D6_A65BD4EB6E79",
  "this.overlay_71EB662B_6B98_8EDC_41D9_B6C371C4E9DA",
  "this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7E837B36_6B97_8534_41B3_B5698B90A766_camera"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B821F16_6C9F_9EF4_4172_9EE4066463D2"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021",
 "thumbnailUrl": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_t.jpg",
 "label": "002 Papan Informasi",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_71235CD9_6BE9_837D_41C4_4ACEF61C286D",
  "this.overlay_7D85EE11_6BE8_9ECC_41A2_C484A63B72EC",
  "this.overlay_72827D6A_6B97_9D5C_41C7_D8FBFB139DD8",
  "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 53.77,
  "pitch": 2.25
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_443E3F37_6C9F_9D34_41D5_38856FDE08CF"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_camera"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -176.88,
  "pitch": -7.35
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B2F5EAF_6C9F_9FD4_41CE_0962CA33D887"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 171.37,
  "pitch": -14.05
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4AFC7E51_6C9F_9F4D_41A2_312B6CB975A2"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7DDBCAE6_6B97_8754_41D1_A76591989421"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A",
 "thumbnailUrl": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_t.jpg",
 "label": "010 Panjat Tebing Plang",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_49681831_6C7B_82CC_41DA_A86F1748F50C",
  "this.overlay_73CAD940_6C7B_854B_41D5_47333EF6D9FD",
  "this.overlay_73B6EC98_6C78_83FB_41C9_00AE910B40A8",
  "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 12.72,
  "pitch": -14.65
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4479FF51_6C9F_9D4C_41D6_DCF6EC4C6D25"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -95.46,
  "pitch": 9.18
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_442FFF3E_6C9F_9D34_41D1_5350E64D421C"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 15.93,
  "pitch": 2.98
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4A867E44_6C9F_9F54_41D4_056DE32E7612"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809",
 "thumbnailUrl": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_t.jpg",
 "label": "006 Gerbang Belakang",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_75222AF7_6BAB_8734_41CE_CBC6C84D6B95",
  "this.overlay_7546AD0A_6BAB_82DC_41B5_9B7A3BCFF008",
  "this.overlay_74F148EA_6BA8_835C_41C2_1F2A7A3705E3",
  "this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_camera"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_camera"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -170.86,
  "pitch": 6.7
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B18FEBC_6C9F_9F34_41DA_515BB08494A3"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -96.7,
  "pitch": -1.42
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_44182F45_6C9F_9D54_41B1_A389CE3567BF"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_camera"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 1.24,
  "pitch": 14.1
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B552EF4_6C9F_9F34_41D2_FA5908821937"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 107.13,
  "pitch": 0.05
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_44083F4B_6C9F_9D5C_41AC_A161EB653B73"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2",
 "thumbnailUrl": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_t.jpg",
 "label": "005 Parkir",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_762245BB_6BA8_8D3D_41B4_74320258FB8F",
  "this.overlay_75469A51_6BA9_874C_41B6_2B652AE22B39",
  "this.panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4AD02E80_6C9F_9FCC_41D8_4948F4A08514"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4AC34E91_6C9F_9FCC_41D9_D0E13B5566B2"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_camera"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09",
 "thumbnailUrl": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_t.jpg",
 "label": "001 Gerbang",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_73A1FD23_6B98_82CC_41C2_268C40C07B5B",
  "this.overlay_7D220CB9_6B99_833D_41D7_8CDF2A641755",
  "this.overlay_71C91287_6BE8_87D4_41D6_D59F37E47850",
  "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_camera"
},
{
 "class": "PlayList",
 "items": [
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 0, 1)",
   "media": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 1, 2)",
   "media": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 2, 3)",
   "media": "this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 3, 4)",
   "media": "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 4, 5)",
   "media": "this.panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 5, 6)",
   "media": "this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 6, 7)",
   "media": "this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 7, 8)",
   "media": "this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 8, 9)",
   "media": "this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 9, 10)",
   "media": "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 10, 11)",
   "media": "this.panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4",
   "player": "this.MainViewerPanoramaPlayer"
  },
  {
   "class": "PanoramaPlayListItem",
   "camera": "this.panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_camera",
   "begin": "this.setEndToItemIndex(this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist, 11, 0)",
   "media": "this.panorama_7DDBCAE6_6B97_8754_41D1_A76591989421",
   "player": "this.MainViewerPanoramaPlayer"
  }
 ],
 "id": "ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2"
  },
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551",
 "thumbnailUrl": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_t.jpg",
 "label": "004 Parkir",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_7009F636_6B98_8F34_41BA_D5451833CA2C",
  "this.overlay_73663650_6B98_8F4B_41D6_B6EF5FE8C055",
  "this.overlay_7036CF46_6B98_BD54_41DA_4A8A49B2623E",
  "this.overlay_73377AA9_6B99_87DD_41D4_B9F996C666D2",
  "this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4AE4DE74_6C9F_9F34_41D1_3DC4ED58A4F0"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C",
 "thumbnailUrl": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_t.jpg",
 "label": "007 Rest Area",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_4944794C_6BA9_8554_41A6_122E8525B4E1",
  "this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_camera"
},
{
 "class": "PanoramaPlayer",
 "buttonCardboardView": [
  "this.IconButton_EF7806FA_E38F_8606_41E5_5C4557EBCACB",
  "this.IconButton_1B9ADD00_16C4_0505_41B4_B043CA1AA270"
 ],
 "buttonToggleHotspots": "this.IconButton_EEEB3760_E38B_8603_41D6_FE6B11A3DA96",
 "viewerArea": "this.MainViewer",
 "touchControlMode": "drag_rotation",
 "id": "MainViewerPanoramaPlayer",
 "gyroscopeVerticalDraggingEnabled": true,
 "displayPlaybackBar": true,
 "buttonToggleGyroscope": "this.IconButton_EE9FBAB2_E389_8E06_41D7_903ABEDD153A",
 "mouseControlMode": "drag_acceleration"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -25.53,
  "pitch": -5.79
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B5B9EED_6C9F_9F54_41D3_39D7C765E81D"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 173.89,
  "pitch": -12.12
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B45BEFB_6C9F_9F3C_41CB_FF48DAC5E879"
},
{
 "adjacentPanoramas": [
  {
   "class": "AdjacentPanorama",
   "panorama": "this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A"
  }
 ],
 "hfov": 360,
 "partial": false,
 "id": "panorama_7DDBCAE6_6B97_8754_41D1_A76591989421",
 "thumbnailUrl": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_t.jpg",
 "label": "012 Pohon Beringin Batu",
 "pitch": 0,
 "hfovMax": 130,
 "class": "Panorama",
 "frames": [
  {
   "class": "CubicPanoramaFrame",
   "front": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/f/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/f/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/f/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/f/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "top": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/u/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/u/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/u/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/u/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "right": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/r/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/r/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/r/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/r/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "back": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/b/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/b/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/b/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/b/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "bottom": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/d/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/d/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/d/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/d/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "left": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/l/0/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 8,
      "tags": "ondemand",
      "colCount": 8,
      "width": 4096,
      "height": 4096
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/l/1/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 4,
      "tags": "ondemand",
      "colCount": 4,
      "width": 2048,
      "height": 2048
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/l/2/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 2,
      "tags": "ondemand",
      "colCount": 2,
      "width": 1024,
      "height": 1024
     },
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0/l/3/{row}_{column}.jpg",
      "class": "TiledImageResourceLevel",
      "rowCount": 1,
      "tags": [
       "ondemand",
       "preload"
      ],
      "colCount": 1,
      "width": 512,
      "height": 512
     }
    ]
   },
   "thumbnailUrl": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_t.jpg"
  }
 ],
 "vfov": 180,
 "overlays": [
  "this.overlay_4F4C3D21_6C68_82CC_41D0_CD03CD0302C0",
  "this.panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_tcap0"
 ]
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 3.63,
  "pitch": 8.54
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B6B7EE7_6C9F_9F55_41CA_C195094C984F"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B91BF10_6C9F_9ECC_41D8_E3FB2883569B"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_camera"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4BF26F1D_6C9F_9EF5_41B2_A80A9AA0AA97"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4BE3BF23_6C9F_9ECC_41CB_90D430A77529"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 4.32,
  "pitch": 17.17
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B3F0E9E_6C9F_9FF7_41C9_5F184B7A5E20"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -159.75,
  "pitch": -1.24
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B7AFEDF_6C9F_9F74_41C6_14E8F2416FED"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -82.06,
  "pitch": -14.1
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4BA7CF09_6C9F_9EDC_41D5_29BAA82A64EE"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4B090ECE_6C9F_9F57_41CF_BB21BA01FFEF"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 3.77,
  "pitch": 6.02
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4AEFEE62_6C9F_9F4C_41AE_28C14246FC4F"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_camera"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 18.92,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4A892E33_6C9F_9ECC_41B0_0255DB84539D"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": -42.75,
  "pitch": 4.91
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "camera_4BDC1F2A_6C9F_9EDC_41D6_95AF1D7057B6"
},
{
 "class": "PanoramaCamera",
 "automaticZoomSpeed": 10,
 "initialPosition": {
  "class": "PanoramaCameraPosition",
  "yaw": 0,
  "pitch": 0
 },
 "initialSequence": {
  "class": "PanoramaCameraSequence",
  "restartMovementOnUserInteraction": false,
  "movements": [
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_in",
    "yawDelta": 18.5
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "linear",
    "yawDelta": 323
   },
   {
    "class": "DistancePanoramaCameraMovement",
    "yawSpeed": 7.96,
    "easing": "cubic_out",
    "yawDelta": 18.5
   }
  ]
 },
 "id": "panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_camera"
},
{
 "transitionDuration": 500,
 "data": {
  "name": "Main Viewer"
 },
 "progressBackgroundColorDirection": "vertical",
 "id": "MainViewer",
 "left": 0,
 "playbackBarBottom": 5,
 "paddingLeft": 0,
 "playbackBarHeadOpacity": 1,
 "progressBorderColor": "#FFFFFF",
 "progressBarBackgroundColorRatios": [
  0
 ],
 "toolTipBorderColor": "#767676",
 "toolTipShadowSpread": 0,
 "playbackBarProgressBackgroundColorDirection": "vertical",
 "progressBarBackgroundColor": [
  "#3399FF"
 ],
 "progressBackgroundColor": [
  "#FFFFFF"
 ],
 "width": "100%",
 "minHeight": 50,
 "toolTipFontSize": 13,
 "toolTipOpacity": 0.5,
 "toolTipShadowBlurRadius": 3,
 "playbackBarBackgroundColorDirection": "vertical",
 "toolTipTextShadowColor": "#000000",
 "playbackBarBackgroundColor": [
  "#FFFFFF"
 ],
 "playbackBarHeadWidth": 6,
 "playbackBarHeadShadowHorizontalLength": 0,
 "playbackBarRight": 0,
 "playbackBarHeight": 10,
 "minWidth": 100,
 "toolTipPaddingBottom": 7,
 "toolTipFontWeight": "normal",
 "playbackBarProgressBorderSize": 0,
 "toolTipTextShadowBlurRadius": 3,
 "playbackBarProgressBorderRadius": 0,
 "progressBarBorderRadius": 0,
 "progressBarBorderSize": 6,
 "toolTipShadowColor": "#333333",
 "height": "100%",
 "playbackBarBorderRadius": 0,
 "playbackBarHeadBorderRadius": 0,
 "transitionMode": "blending",
 "class": "ViewerArea",
 "playbackBarHeadBorderColor": "#000000",
 "shadow": false,
 "toolTipShadowOpacity": 0,
 "progressLeft": 0,
 "playbackBarProgressBorderColor": "#000000",
 "playbackBarHeadBorderSize": 0,
 "playbackBarProgressOpacity": 1,
 "toolTipFontStyle": "normal",
 "playbackBarBorderSize": 0,
 "playbackBarHeadShadowVerticalLength": 0,
 "propagateClick": true,
 "playbackBarBackgroundOpacity": 1,
 "toolTipFontFamily": "Georgia",
 "vrPointerSelectionColor": "#FF6600",
 "toolTipTextShadowOpacity": 0,
 "playbackBarHeadBackgroundColor": [
  "#111111",
  "#666666"
 ],
 "playbackBarHeadShadowColor": "#000000",
 "vrPointerSelectionTime": 2000,
 "paddingRight": 0,
 "firstTransitionDuration": 0,
 "progressOpacity": 1,
 "progressRight": 0,
 "borderSize": 0,
 "progressBarBackgroundColorDirection": "vertical",
 "playbackBarHeadShadow": true,
 "progressBottom": 55,
 "toolTipBackgroundColor": "#000000",
 "toolTipFontColor": "#FFFFFF",
 "progressHeight": 6,
 "playbackBarHeadBackgroundColorDirection": "vertical",
 "progressBackgroundOpacity": 1,
 "top": 0,
 "playbackBarOpacity": 1,
 "displayTooltipInTouchScreens": true,
 "playbackBarProgressBackgroundColor": [
  "#3399FF"
 ],
 "vrPointerColor": "#FFFFFF",
 "progressBarOpacity": 1,
 "playbackBarHeadShadowOpacity": 0.7,
 "playbackBarBorderColor": "#FFFFFF",
 "progressBorderSize": 0,
 "toolTipBorderSize": 1,
 "toolTipPaddingTop": 7,
 "toolTipPaddingLeft": 10,
 "progressBorderRadius": 0,
 "toolTipPaddingRight": 10,
 "toolTipDisplayTime": 600,
 "playbackBarProgressBackgroundColorRatios": [
  0
 ],
 "playbackBarLeft": 0,
 "paddingBottom": 0,
 "toolTipBorderRadius": 3,
 "borderRadius": 0,
 "playbackBarHeadShadowBlurRadius": 3,
 "progressBackgroundColorRatios": [
  0.01
 ],
 "paddingTop": 0,
 "playbackBarHeadBackgroundColorRatios": [
  0,
  1
 ],
 "progressBarBorderColor": "#0066FF",
 "playbackBarHeadHeight": 15
},
{
 "propagateClick": true,
 "scrollBarWidth": 10,
 "id": "Container_EF8F8BD8_E386_8E03_41E3_4CF7CC1F4D8E",
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "paddingLeft": 0,
 "children": [
  "this.Container_EF8F8BD8_E386_8E02_41E5_FC5C5513733A",
  "this.Container_EF8F8BD8_E386_8E02_41E5_90850B5F0BBE"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "width": 115.05,
 "minHeight": 1,
 "paddingTop": 0,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "height": 641,
 "top": "0%",
 "gap": 10,
 "paddingBottom": 0,
 "backgroundOpacity": 0,
 "shadow": false,
 "class": "Container",
 "borderRadius": 0,
 "overflow": "scroll",
 "data": {
  "name": "--SETTINGS"
 }
},
{
 "propagateClick": true,
 "scrollBarWidth": 10,
 "id": "Container_0DD1BF09_1744_0507_41B3_29434E440055",
 "left": 30,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "paddingLeft": 0,
 "children": [
  "this.Label_0DD14F09_1744_0507_41AA_D8475423214A",
  "this.Label_0DD1AF09_1744_0507_41B4_9F5A60B503B2"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "width": 573,
 "horizontalAlign": "left",
 "minHeight": 1,
 "top": 15,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "height": 133,
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "visible",
 "data": {
  "name": "--STICKER"
 }
},
{
 "propagateClick": true,
 "scrollBarWidth": 10,
 "id": "Container_1B9AAD00_16C4_0505_41B5_6F4AE0747E48",
 "left": "0%",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Image_1B99DD00_16C4_0505_41B3_51F09727447A",
  "this.Container_1B99BD00_16C4_0505_41A4_A3C2452B0288",
  "this.IconButton_1B9ADD00_16C4_0505_41B4_B043CA1AA270",
  "this.IconButton_EF8F8BD8_E386_8E02_41D6_310FF1964329"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "horizontalAlign": "left",
 "backgroundImageUrl": "skin/Container_1B9AAD00_16C4_0505_41B5_6F4AE0747E48.png",
 "scrollBarOpacity": 0.5,
 "bottom": 0,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "scrollBarMargin": 2,
 "height": 118,
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.64,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "visible",
 "data": {
  "name": "--MENU"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_062AB830_1140_E215_41AF_6C9D65345420",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_062A782F_1140_E20B_41AF_B3E5DE341773",
  "this.Container_062A9830_1140_E215_41A7_5F2BBE5C20E4"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_062AB830_1140_E215_41AF_6C9D65345420, false, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "--INFO photo"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_23F0F7B8_0C0A_629D_418A_F171085EFBF8",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_23F7B7B7_0C0A_6293_4197_F931EEC6FA48",
  "this.Container_23F097B8_0C0A_629D_4176_D87C90BA32B6"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_23F0F7B8_0C0A_629D_418A_F171085EFBF8, false, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "--INFO photoalbum"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_39DE87B1_0C06_62AF_417B_8CB0FB5C9D15",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_39A197B1_0C06_62AF_419A_D15E4DDD2528"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_39DE87B1_0C06_62AF_417B_8CB0FB5C9D15, false, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "--PANORAMA LIST"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_221B1648_0C06_E5FD_417F_E6FCCCB4A6D7",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_221C1648_0C06_E5FD_4180_8A2E8B66315E",
  "this.Container_221B3648_0C06_E5FD_4199_FCE031AE003B"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_221B1648_0C06_E5FD_417F_E6FCCCB4A6D7, false, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "--LOCATION"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2F8BB687_0D4F_6B7F_4190_9490D02FBC41",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_2F8A6686_0D4F_6B71_4174_A02FE43588D3"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_2F8BB687_0D4F_6B7F_4190_9490D02FBC41, false, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "--FLOORPLAN"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2820BA13_0D5D_5B97_4192_AABC38F6F169",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_28215A13_0D5D_5B97_4198_A7CA735E9E0A"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_2820BA13_0D5D_5B97_4192_AABC38F6F169, true, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "--PHOTOALBUM + text"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2A1A5C4D_0D3B_DFF0_41A9_8FC811D03C8E",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_2A193C4C_0D3B_DFF0_4161_A2CD128EF536"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_2A1A5C4D_0D3B_DFF0_41A9_8FC811D03C8E, false, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "--PHOTOALBUM"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_06C41BA5_1140_A63F_41AE_B0CBD78DEFDC",
 "left": "0%",
 "propagateClick": true,
 "paddingLeft": 0,
 "scrollBarColor": "#04A3E1",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.Container_06C5DBA5_1140_A63F_41AD_1D83A33F1255",
  "this.Container_06C43BA5_1140_A63F_41A1_96DC8F4CAD2F"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "creationPolicy": "inAdvance",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0%",
 "click": "this.setComponentVisibility(this.Container_06C41BA5_1140_A63F_41AE_B0CBD78DEFDC, false, 0, null, null, false)",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.6,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "Tentang Kami"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_21C2E33E_34AF_9C3C_41C2_806CDFD8DC6C",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "right": "0.36%",
 "children": [
  "this.Image_25FF1AE4_3476_6C4C_418D_1C6467605634",
  "this.Image_3BB7053A_3452_A5C4_4193_A05712EAB942",
  "this.Image_24FB80F1_347F_9C45_41C5_7957D6F95340",
  "this.Image_3B894FAF_3472_E4DD_41C1_F82A82E59EF2",
  "this.Image_24401105_3473_BDCD_41AE_40A528647033",
  "this.Image_24ECBA1C_3457_AFFC_41C7_B9AA62158AD5"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.44,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "top": "0.68%",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "9.265%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.01,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "width": "37.392%",
 "data": {
  "name": "Container10840"
 }
},
{
 "transparencyActive": true,
 "maxHeight": 58,
 "propagateClick": true,
 "id": "IconButton_EEFF957A_E389_9A06_41E1_2AD21904F8C0",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 58,
 "minHeight": 1,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_EEFF957A_E389_9A06_41E1_2AD21904F8C0.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "toggle",
 "height": 58,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_EEFF957A_E389_9A06_41E1_2AD21904F8C0_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 58,
 "data": {
  "name": "IconButton FULLSCREEN"
 }
},
{
 "transparencyActive": true,
 "maxHeight": 58,
 "propagateClick": true,
 "id": "IconButton_EED073D3_E38A_9E06_41E1_6CCC9722545D",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 58,
 "minHeight": 1,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_EED073D3_E38A_9E06_41E1_6CCC9722545D.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "toggle",
 "height": 58,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_EED073D3_E38A_9E06_41E1_6CCC9722545D_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 58,
 "data": {
  "name": "IconButton MUTE"
 }
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766, this.camera_4B18FEBC_6C9F_9F34_41DA_515BB08494A3); this.mainPlayList.set('selectedIndex', 7)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.23,
   "image": "this.AnimatedImageResource_499E2C55_6C69_8374_41D1_D36B06469BC4",
   "pitch": 0,
   "yaw": 104.9,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_4B6C7F7E_6BB8_9D34_41AE_E8942C7873E4",
 "maps": [
  {
   "hfov": 16.23,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 104.9,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": 0
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A, this.camera_4B090ECE_6C9F_9F57_41CF_BB21BA01FFEF); this.mainPlayList.set('selectedIndex', 9)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.11,
   "image": "this.AnimatedImageResource_499E7C55_6C69_8374_41AA_304AA8B802A1",
   "pitch": -6.98,
   "yaw": -8.41,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_758A26C5_6BB8_8F54_41D1_D0CB7E13DAD2",
 "maps": [
  {
   "hfov": 16.11,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -8.41,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -6.98
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809, this.camera_4B2F5EAF_6C9F_9FD4_41CE_0962CA33D887); this.mainPlayList.set('selectedIndex', 5)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.2,
   "image": "this.AnimatedImageResource_499FBC55_6C69_8374_41D9_029A5E3474DB",
   "pitch": -3.73,
   "yaw": -174.75,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_76997476_6BB8_8337_41D7_9B9B1B55DF40",
 "maps": [
  {
   "hfov": 16.2,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -174.75,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0_HS_2_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -3.73
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A, this.camera_4A892E33_6C9F_9ECC_41B0_0255DB84539D); this.mainPlayList.set('selectedIndex', 9)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.54,
   "image": "this.AnimatedImageResource_49807C56_6C69_8374_41D3_C714001B34AA",
   "pitch": -9.12,
   "yaw": 161.8,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_7344C8BB_6C77_833C_41D3_B53B58795A30",
 "maps": [
  {
   "hfov": 15.54,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 161.8,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -9.12
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C, this.camera_44083F4B_6C9F_9D5C_41AC_A161EB653B73); this.mainPlayList.set('selectedIndex', 6)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.15,
   "image": "this.AnimatedImageResource_499D0C55_6C69_8374_41C6_89EF1D808DEB",
   "pitch": -5.5,
   "yaw": -69.2,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_74238361_6BB9_854C_41C3_F0009A988402",
 "maps": [
  {
   "hfov": 16.15,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -69.2,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -5.5
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5, this.camera_44182F45_6C9F_9D54_41B1_A389CE3567BF); this.mainPlayList.set('selectedIndex', 8)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.86,
   "image": "this.AnimatedImageResource_499D5C55_6C69_8374_41C4_2C037895F1D5",
   "pitch": -12.29,
   "yaw": 14.4,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_76212135_6BB8_8534_41D8_CE40CA17408B",
 "maps": [
  {
   "hfov": 15.86,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 14.4,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -12.29
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7E837B36_6B97_8534_41B3_B5698B90A766_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021, this.camera_4BF26F1D_6C9F_9EF5_41B2_A80A9AA0AA97); this.mainPlayList.set('selectedIndex', 1)"
  }
 ],
 "data": {
  "label": "Arrow 01b"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.59,
   "image": "this.AnimatedImageResource_49981C54_6C69_8374_41B0_0CD4725BDF7D",
   "pitch": -16.13,
   "yaw": -138.05,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_710B8FD3_6B9B_9D4C_41D2_0256CA1D0A7A",
 "maps": [
  {
   "hfov": 15.59,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -138.05,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -16.13
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551, this.camera_4BDC1F2A_6C9F_9EDC_41D6_95AF1D7057B6); this.mainPlayList.set('selectedIndex', 3)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.75,
   "image": "this.AnimatedImageResource_4999AC54_6C69_8374_41D7_ACC49BF1C1A5",
   "pitch": -8.67,
   "yaw": 166.13,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_7C5E5DC7_6B9B_7D54_41D6_A65BD4EB6E79",
 "maps": [
  {
   "hfov": 15.75,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 166.13,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -8.67
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09, this.camera_4BE3BF23_6C9F_9ECC_41CB_90D430A77529); this.mainPlayList.set('selectedIndex', 0)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.1,
   "image": "this.AnimatedImageResource_4999FC54_6C69_8374_41B3_0F9D3900189D",
   "pitch": -7.27,
   "yaw": 85.91,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_71EB662B_6B98_8EDC_41D9_B6C371C4E9DA",
 "maps": [
  {
   "hfov": 16.1,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 85.91,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0_HS_2_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -7.27
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E, this.camera_4B552EF4_6C9F_9F34_41D2_FA5908821937); this.mainPlayList.set('selectedIndex', 2)"
  }
 ],
 "data": {
  "label": "Circle Arrow 01a Left-UP"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 13.92,
   "image": "this.AnimatedImageResource_49973C54_6C69_8374_41AB_375CCD4E4972",
   "pitch": -17.51,
   "yaw": 133.78,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 50
  }
 ],
 "id": "overlay_71235CD9_6BE9_837D_41C4_4ACEF61C286D",
 "maps": [
  {
   "hfov": 13.92,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 133.78,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 26,
      "height": 16
     }
    ]
   },
   "pitch": -17.51
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09, this.camera_4B6B7EE7_6C9F_9F55_41CA_C195094C984F); this.mainPlayList.set('selectedIndex', 0)"
  }
 ],
 "data": {
  "label": "Circle Arrow 01a Left-UP"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 14.51,
   "image": "this.AnimatedImageResource_49975C54_6C69_8374_41A9_173763839FF3",
   "pitch": -6.09,
   "yaw": 138.51,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 50
  }
 ],
 "id": "overlay_7D85EE11_6BE8_9ECC_41A2_C484A63B72EC",
 "maps": [
  {
   "hfov": 14.51,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 138.51,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 26,
      "height": 16
     }
    ]
   },
   "pitch": -6.09
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551, this.camera_4B5B9EED_6C9F_9F54_41D3_39D7C765E81D); this.mainPlayList.set('selectedIndex', 3)"
  }
 ],
 "data": {
  "label": "Circle Arrow 01a Left-UP"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 14.34,
   "image": "this.AnimatedImageResource_4998EC54_6C69_8374_41D1_88E22EEC58B8",
   "pitch": -10.81,
   "yaw": -154.7,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 50
  }
 ],
 "id": "overlay_72827D6A_6B97_9D5C_41C7_D8FBFB139DD8",
 "maps": [
  {
   "hfov": 14.34,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -154.7,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0_HS_2_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 26,
      "height": 16
     }
    ]
   },
   "pitch": -10.81
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5, this.camera_4AFC7E51_6C9F_9F4D_41A2_312B6CB975A2); this.mainPlayList.set('selectedIndex', 8)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 8.21,
   "image": "this.AnimatedImageResource_499F2C56_6C69_8374_41D3_5D463EA72DF1",
   "pitch": -6.49,
   "yaw": 169.97,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_49681831_6C7B_82CC_41DA_A86F1748F50C",
 "maps": [
  {
   "hfov": 8.21,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 169.97,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -6.49
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4, this.camera_4A867E44_6C9F_9F54_41D4_056DE32E7612); this.mainPlayList.set('selectedIndex', 10)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.02,
   "image": "this.AnimatedImageResource_499F7C56_6C69_8374_41D0_00CCD1834C36",
   "pitch": -9.15,
   "yaw": -80.41,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_73CAD940_6C7B_854B_41D5_47333EF6D9FD",
 "maps": [
  {
   "hfov": 16.02,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -80.41,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -9.15
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7DDBCAE6_6B97_8754_41D1_A76591989421, this.camera_4AEFEE62_6C9F_9F4C_41AE_28C14246FC4F); this.mainPlayList.set('selectedIndex', 11)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.14,
   "image": "this.AnimatedImageResource_49808C56_6C69_8374_41BE_5D8A47277159",
   "pitch": -5.9,
   "yaw": 14.02,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_73B6EC98_6C78_83FB_41C9_00AE910B40A8",
 "maps": [
  {
   "hfov": 16.14,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 14.02,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0_HS_2_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -5.9
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09, this.camera_4B45BEFB_6C9F_9F3C_41CB_FF48DAC5E879); this.mainPlayList.set('selectedIndex', 0)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.2,
   "image": "this.AnimatedImageResource_499CBC55_6C69_8374_4192_1A7A0E83E17B",
   "pitch": -3.54,
   "yaw": -172.87,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_75222AF7_6BAB_8734_41CE_CBC6C84D6B95",
 "maps": [
  {
   "hfov": 16.2,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -172.87,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -3.54
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C, this.camera_4BA7CF09_6C9F_9EDC_41D5_29BAA82A64EE); this.mainPlayList.set('selectedIndex', 6)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.22,
   "image": "this.AnimatedImageResource_499CCC55_6C69_8374_41DA_CE6CB9EB89DD",
   "pitch": 1.96,
   "yaw": 54.53,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_7546AD0A_6BAB_82DC_41B5_9B7A3BCFF008",
 "maps": [
  {
   "hfov": 16.22,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 54.53,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": 1.96
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5, this.camera_4BB7AF02_6C9F_9ECC_41AB_6762A182F227); this.mainPlayList.set('selectedIndex', 8)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.19,
   "image": "this.AnimatedImageResource_499C1C55_6C69_8374_41BD_396D3AF2A7B5",
   "pitch": -4.13,
   "yaw": 1.92,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_74F148EA_6BA8_835C_41C2_1F2A7A3705E3",
 "maps": [
  {
   "hfov": 16.19,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 1.92,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0_HS_2_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -4.13
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551, this.camera_4B821F16_6C9F_9EF4_4172_9EE4066463D2); this.mainPlayList.set('selectedIndex', 3)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.01,
   "image": "this.AnimatedImageResource_499B8C55_6C69_8374_41B1_97596043BA9C",
   "pitch": -9.44,
   "yaw": 161.45,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_762245BB_6BA8_8D3D_41B4_74320258FB8F",
 "maps": [
  {
   "hfov": 16.01,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 161.45,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -9.44
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09, this.camera_4B91BF10_6C9F_9ECC_41D8_E3FB2883569B); this.mainPlayList.set('selectedIndex', 0)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.05,
   "image": "this.AnimatedImageResource_499B2C55_6C69_8374_41DA_542831DA3A84",
   "pitch": -8.45,
   "yaw": -150.55,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_75469A51_6BA9_874C_41B6_2B652AE22B39",
 "maps": [
  {
   "hfov": 16.05,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -150.55,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -8.45
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021, this.camera_4BCDCF31_6C9F_9ECC_41BE_A81FB8FA2C6C); this.mainPlayList.set('selectedIndex', 1)"
  }
 ],
 "data": {
  "label": "Circle Arrow 03a"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.34,
   "image": "this.AnimatedImageResource_71EC5A39_6BE9_873C_417A_95AAF4DEA5AC",
   "pitch": -6,
   "yaw": -162.47,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_73A1FD23_6B98_82CC_41C2_268C40C07B5B",
 "maps": [
  {
   "hfov": 15.34,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -162.47,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 27,
      "height": 16
     }
    ]
   },
   "pitch": -6
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809, this.camera_443E3F37_6C9F_9D34_41D5_38856FDE08CF); this.mainPlayList.set('selectedIndex', 5)"
  }
 ],
 "data": {
  "label": "Circle Arrow 01a"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 14.46,
   "image": "this.AnimatedImageResource_71EE1A3A_6BE9_873C_41D6_83605D199ED0",
   "pitch": -7.67,
   "yaw": 3.06,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_7D220CB9_6B99_833D_41D7_8CDF2A641755",
 "maps": [
  {
   "hfov": 14.46,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 3.06,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0_HS_2_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 26,
      "height": 16
     }
    ]
   },
   "pitch": -7.67
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551, this.camera_442FFF3E_6C9F_9D34_41D1_5350E64D421C); this.mainPlayList.set('selectedIndex', 3)"
  }
 ],
 "data": {
  "label": "Circle Arrow 01b"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 20.64,
   "image": "this.AnimatedImageResource_71710D25_6BEB_82D4_41D8_C0C63CA765BE",
   "pitch": -6.3,
   "yaw": 165.49,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_71C91287_6BE8_87D4_41D6_D59F37E47850",
 "maps": [
  {
   "hfov": 20.64,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 165.49,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0_HS_3_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 37,
      "height": 16
     }
    ]
   },
   "pitch": -6.3
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 19.5,
 "id": "panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0",
 "distance": 50,
 "inertia": true
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021, this.camera_4AD02E80_6C9F_9FCC_41D8_4948F4A08514); this.mainPlayList.set('selectedIndex', 1); this.mainPlayList.set('selectedIndex', 1)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.06,
   "image": "this.AnimatedImageResource_49996C54_6C69_8374_4196_DB3DE52FE978",
   "pitch": -8.37,
   "yaw": 152.31,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_7009F636_6B98_8F34_41BA_D5451833CA2C",
 "maps": [
  {
   "hfov": 16.06,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 152.31,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -8.37
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2, this.camera_4B3F0E9E_6C9F_9FF7_41C9_5F184B7A5E20); this.mainPlayList.set('selectedIndex', 4)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.08,
   "image": "this.AnimatedImageResource_499ABC54_6C69_8374_41DA_A26DAD1312F7",
   "pitch": -7.86,
   "yaw": 22.87,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_73663650_6B98_8F4B_41D6_B6EF5FE8C055",
 "maps": [
  {
   "hfov": 16.08,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": 22.87,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_1_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -7.86
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09, this.camera_4AC34E91_6C9F_9FCC_41D9_D0E13B5566B2); this.mainPlayList.set('selectedIndex', 0)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 16.04,
   "image": "this.AnimatedImageResource_499ADC54_6C69_8374_41AD_DD197F733D2A",
   "pitch": -8.85,
   "yaw": -116.22,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_7036CF46_6B98_BD54_41DA_4A8A49B2623E",
 "maps": [
  {
   "hfov": 16.04,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -116.22,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_2_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -8.85
  }
 ]
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.mainPlayList.set('selectedIndex', 2)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.96,
   "image": "this.AnimatedImageResource_499A6C54_6C69_8374_41DA_4E6DFBF1E4F5",
   "pitch": -10.43,
   "yaw": -173.88,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_73377AA9_6B99_87DD_41D4_B9F996C666D2",
 "maps": [
  {
   "hfov": 15.96,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -173.88,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_3_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -10.43
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E837B36_6B97_8534_41B3_B5698B90A766, this.camera_4479FF51_6C9F_9D4C_41D6_DCF6EC4C6D25); this.mainPlayList.set('selectedIndex', 7)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.86,
   "image": "this.AnimatedImageResource_499D8C55_6C69_8374_41B4_4A3A423CD6BE",
   "pitch": -12.2,
   "yaw": -98.7,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_4944794C_6BA9_8554_41A6_122E8525B4E1",
 "maps": [
  {
   "hfov": 15.86,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -98.7,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -12.2
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "transparencyActive": true,
 "maxHeight": 58,
 "propagateClick": true,
 "id": "IconButton_EF7806FA_E38F_8606_41E5_5C4557EBCACB",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 58,
 "minHeight": 1,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_EF7806FA_E38F_8606_41E5_5C4557EBCACB.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "height": 58,
 "rollOverIconURL": "skin/IconButton_EF7806FA_E38F_8606_41E5_5C4557EBCACB_rollover.png",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "visible": false,
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 58,
 "data": {
  "name": "IconButton VR"
 }
},
{
 "transparencyActive": true,
 "maxHeight": 37,
 "propagateClick": true,
 "id": "IconButton_1B9ADD00_16C4_0505_41B4_B043CA1AA270",
 "paddingRight": 0,
 "right": 30,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 100,
 "minHeight": 1,
 "verticalAlign": "middle",
 "iconURL": "skin/IconButton_1B9ADD00_16C4_0505_41B4_B043CA1AA270.png",
 "bottom": 8,
 "minWidth": 1,
 "mode": "push",
 "horizontalAlign": "center",
 "height": 75,
 "rollOverIconURL": "skin/IconButton_1B9ADD00_16C4_0505_41B4_B043CA1AA270_rollover.png",
 "paddingBottom": 0,
 "backgroundOpacity": 0,
 "shadow": false,
 "class": "IconButton",
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_1B9ADD00_16C4_0505_41B4_B043CA1AA270_pressed.png",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 49,
 "data": {
  "name": "IconButton VR"
 }
},
{
 "transparencyActive": true,
 "maxHeight": 58,
 "propagateClick": true,
 "id": "IconButton_EEEB3760_E38B_8603_41D6_FE6B11A3DA96",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 58,
 "minHeight": 1,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_EEEB3760_E38B_8603_41D6_FE6B11A3DA96.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "toggle",
 "height": 58,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_EEEB3760_E38B_8603_41D6_FE6B11A3DA96_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 58,
 "data": {
  "name": "IconButton HS "
 }
},
{
 "transparencyActive": true,
 "maxHeight": 58,
 "propagateClick": true,
 "id": "IconButton_EE9FBAB2_E389_8E06_41D7_903ABEDD153A",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 58,
 "minHeight": 1,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_EE9FBAB2_E389_8E06_41D7_903ABEDD153A.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "toggle",
 "height": 58,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_EE9FBAB2_E389_8E06_41D7_903ABEDD153A_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 58,
 "data": {
  "name": "IconButton GYRO"
 }
},
{
 "enabledInCardboard": true,
 "class": "HotspotPanoramaOverlay",
 "rollOverDisplay": false,
 "areas": [
  {
   "class": "HotspotPanoramaOverlayArea",
   "mapColor": "#FF0000",
   "click": "this.startPanoramaWithCamera(this.panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A, this.camera_4B7AFEDF_6C9F_9F74_41C6_14E8F2416FED); this.mainPlayList.set('selectedIndex', 9)"
  }
 ],
 "data": {
  "label": "Arrow 01c"
 },
 "useHandCursor": true,
 "items": [
  {
   "hfov": 15.99,
   "image": "this.AnimatedImageResource_4981EC56_6C69_8374_41D2_56EA384F4D7E",
   "pitch": -9.84,
   "yaw": -158.9,
   "class": "HotspotPanoramaOverlayImage",
   "distance": 100
  }
 ],
 "id": "overlay_4F4C3D21_6C68_82CC_41D0_CD03CD0302C0",
 "maps": [
  {
   "hfov": 15.99,
   "class": "HotspotPanoramaOverlayMap",
   "yaw": -158.9,
   "image": {
    "class": "ImageResource",
    "levels": [
     {
      "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0_HS_0_0_0_map.gif",
      "class": "ImageResourceLevel",
      "width": 29,
      "height": 16
     }
    ]
   },
   "pitch": -9.84
  }
 ]
},
{
 "rotate": false,
 "class": "TripodCapPanoramaOverlay",
 "angle": 0,
 "image": {
  "class": "ImageResource",
  "levels": [
   {
    "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_tcap0.png",
    "class": "ImageResourceLevel",
    "width": 631,
    "height": 631
   }
  ]
 },
 "hfov": 16.5,
 "id": "panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_tcap0",
 "distance": 50,
 "inertia": false
},
{
 "propagateClick": true,
 "scrollBarWidth": 10,
 "id": "Container_EF8F8BD8_E386_8E02_41E5_FC5C5513733A",
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "right": "0%",
 "paddingLeft": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "width": 110,
 "minHeight": 1,
 "paddingTop": 0,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "middle",
 "horizontalAlign": "center",
 "height": 110,
 "top": "0%",
 "gap": 10,
 "paddingBottom": 0,
 "backgroundOpacity": 0,
 "shadow": false,
 "class": "Container",
 "borderRadius": 0,
 "overflow": "visible",
 "data": {
  "name": "button menu sup"
 }
},
{
 "propagateClick": true,
 "scrollBarWidth": 10,
 "id": "Container_EF8F8BD8_E386_8E02_41E5_90850B5F0BBE",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "vertical",
 "paddingRight": 0,
 "right": "0%",
 "children": [
  "this.IconButton_EF7806FA_E38F_8606_41E5_5C4557EBCACB",
  "this.IconButton_EE9FBAB2_E389_8E06_41D7_903ABEDD153A",
  "this.IconButton_EED073D3_E38A_9E06_41E1_6CCC9722545D",
  "this.IconButton_EEEB3760_E38B_8603_41D6_FE6B11A3DA96",
  "this.IconButton_EEFF957A_E389_9A06_41E1_2AD21904F8C0",
  "this.IconButton_EE5807F6_E3BE_860E_41E7_431DDDA54BAC",
  "this.IconButton_EED5213F_E3B9_7A7D_41D8_1B642C004521"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "horizontalAlign": "center",
 "scrollBarOpacity": 0.5,
 "bottom": "0%",
 "contentOpaque": false,
 "verticalAlign": "top",
 "minWidth": 1,
 "scrollBarMargin": 2,
 "height": "85.959%",
 "gap": 3,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "visible": false,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "width": "91.304%",
 "data": {
  "name": "-button set"
 }
},
{
 "textDecoration": "none",
 "fontFamily": "Bebas Neue Bold",
 "propagateClick": true,
 "data": {
  "name": "text 1"
 },
 "id": "Label_0DD14F09_1744_0507_41AA_D8475423214A",
 "left": -0.35,
 "textShadowVerticalLength": 0,
 "paddingRight": 0,
 "fontColor": "#FFFFFF",
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 320.65,
 "textShadowOpacity": 1,
 "horizontalAlign": "left",
 "text": "Geopark Silokek",
 "minHeight": 1,
 "top": 1,
 "verticalAlign": "top",
 "minWidth": 1,
 "fontSize": "58px",
 "textShadowColor": "#000000",
 "height": 52,
 "fontStyle": "normal",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Label",
 "paddingTop": 0,
 "fontWeight": "bold",
 "textShadowBlurRadius": 10,
 "textShadowHorizontalLength": 0
},
{
 "textDecoration": "none",
 "fontFamily": "Bebas Neue Book",
 "propagateClick": true,
 "data": {
  "name": "text 2"
 },
 "id": "Label_0DD1AF09_1744_0507_41B4_9F5A60B503B2",
 "left": 4.65,
 "textShadowVerticalLength": 0,
 "paddingLeft": 0,
 "paddingRight": 0,
 "fontColor": "#FFFFFF",
 "width": 388,
 "borderSize": 0,
 "minHeight": 1,
 "textShadowOpacity": 1,
 "horizontalAlign": "left",
 "text": "Kabupaten Sijunjung",
 "verticalAlign": "top",
 "bottom": 29.35,
 "minWidth": 1,
 "fontSize": 41,
 "textShadowColor": "#000000",
 "height": 46,
 "fontStyle": "normal",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Label",
 "paddingTop": 0,
 "fontWeight": "normal",
 "textShadowBlurRadius": 10,
 "textShadowHorizontalLength": 0
},
{
 "maxHeight": 2,
 "propagateClick": true,
 "id": "Image_1B99DD00_16C4_0505_41B3_51F09727447A",
 "left": "0%",
 "paddingRight": 0,
 "right": "0%",
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_1B99DD00_16C4_0505_41B3_51F09727447A.png",
 "minHeight": 1,
 "horizontalAlign": "center",
 "verticalAlign": "middle",
 "bottom": 53,
 "minWidth": 1,
 "height": 2,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "scaleMode": "fit_outside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 3000,
 "data": {
  "name": "white line"
 }
},
{
 "propagateClick": true,
 "scrollBarWidth": 10,
 "id": "Container_1B99BD00_16C4_0505_41A4_A3C2452B0288",
 "left": "0%",
 "paddingLeft": 30,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "width": 1199,
 "children": [
  "this.Button_1B998D00_16C4_0505_41AD_67CAA4AAEFE0",
  "this.Button_1B999D00_16C4_0505_41AB_D0C2E7857448",
  "this.Button_1B9A6D00_16C4_0505_4197_F2108627CC98",
  "this.Button_1B9A4D00_16C4_0505_4193_E0EA69B0CBB0",
  "this.Button_1B9A5D00_16C4_0505_41B0_D18F25F377C4",
  "this.Button_245BD38F_3452_7CDD_41A8_76D5E7E84BCA"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "horizontalAlign": "left",
 "bottom": "0%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "middle",
 "scrollBarMargin": 2,
 "height": 51,
 "scrollBarOpacity": 0.5,
 "gap": 3,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "data": {
  "name": "-button set container"
 }
},
{
 "transparencyActive": true,
 "maxHeight": 60,
 "propagateClick": true,
 "id": "IconButton_EF8F8BD8_E386_8E02_41D6_310FF1964329",
 "paddingRight": 0,
 "right": "1.87%",
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 60,
 "minHeight": 1,
 "paddingTop": 0,
 "iconURL": "skin/IconButton_EF8F8BD8_E386_8E02_41D6_310FF1964329.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "toggle",
 "click": "if(!this.Container_EF8F8BD8_E386_8E02_41E5_90850B5F0BBE.get('visible')){ this.setComponentVisibility(this.Container_EF8F8BD8_E386_8E02_41E5_90850B5F0BBE, true, 0, null, null, false) } else { this.setComponentVisibility(this.Container_EF8F8BD8_E386_8E02_41E5_90850B5F0BBE, false, 0, null, null, false) }",
 "horizontalAlign": "center",
 "height": 60,
 "top": "-11.02%",
 "paddingBottom": 0,
 "backgroundOpacity": 0,
 "shadow": false,
 "class": "IconButton",
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_EF8F8BD8_E386_8E02_41D6_310FF1964329_pressed.png",
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "image button menu"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_062A782F_1140_E20B_41AF_B3E5DE341773",
 "left": "10%",
 "paddingLeft": 0,
 "layout": "horizontal",
 "paddingRight": 0,
 "right": "10%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_062A682F_1140_E20B_41B0_3071FCBF3DC9",
  "this.Container_062A082F_1140_E20A_4193_DF1A4391DC79"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "5%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "Container_062A9830_1140_E215_41A7_5F2BBE5C20E4",
 "left": "10%",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "vertical",
 "paddingRight": 20,
 "right": "10%",
 "children": [
  "this.IconButton_062A8830_1140_E215_419D_3439F16CCB3E"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "horizontalAlign": "right",
 "minHeight": 1,
 "verticalAlign": "top",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "80%",
 "contentOpaque": false,
 "minWidth": 1,
 "scrollBarMargin": 2,
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 20,
 "overflow": "visible",
 "data": {
  "name": "Container X global"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_23F7B7B7_0C0A_6293_4197_F931EEC6FA48",
 "left": "10%",
 "paddingLeft": 0,
 "layout": "horizontal",
 "paddingRight": 0,
 "right": "10%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_23F797B7_0C0A_6293_41A7_EC89DBCDB93F",
  "this.Container_23F027B7_0C0A_6293_418E_075FCFAA8A19"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "5%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "Container_23F097B8_0C0A_629D_4176_D87C90BA32B6",
 "left": "10%",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "vertical",
 "paddingRight": 20,
 "right": "10%",
 "children": [
  "this.IconButton_23F087B8_0C0A_629D_4194_6F34C6CBE1DA"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "horizontalAlign": "right",
 "minHeight": 1,
 "verticalAlign": "top",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "80%",
 "contentOpaque": false,
 "minWidth": 1,
 "scrollBarMargin": 2,
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 20,
 "overflow": "visible",
 "data": {
  "name": "Container X global"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_39A197B1_0C06_62AF_419A_D15E4DDD2528",
 "left": "15%",
 "paddingLeft": 0,
 "layout": "vertical",
 "paddingRight": 0,
 "right": "15%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_3A67552A_0C3A_67BD_4195_ECE46CCB34EA",
  "this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "center",
 "top": "7%",
 "scrollBarOpacity": 0.5,
 "bottom": "7%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_221C1648_0C06_E5FD_4180_8A2E8B66315E",
 "left": "10%",
 "paddingLeft": 0,
 "layout": "horizontal",
 "paddingRight": 0,
 "right": "10%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_221C0648_0C06_E5FD_4193_12BCE1D6DD6B",
  "this.Container_221C9648_0C06_E5FD_41A1_A79DE53B3031"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "5%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "Container_221B3648_0C06_E5FD_4199_FCE031AE003B",
 "left": "10%",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "vertical",
 "paddingRight": 20,
 "right": "10%",
 "children": [
  "this.IconButton_221B2648_0C06_E5FD_41A6_F9E27CDB95AF"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "horizontalAlign": "right",
 "minHeight": 1,
 "verticalAlign": "top",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "80%",
 "contentOpaque": false,
 "minWidth": 1,
 "scrollBarMargin": 2,
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 20,
 "overflow": "visible",
 "data": {
  "name": "Container X global"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2F8A6686_0D4F_6B71_4174_A02FE43588D3",
 "left": "15%",
 "paddingLeft": 0,
 "layout": "vertical",
 "paddingRight": 0,
 "right": "15%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_2F8A7686_0D4F_6B71_41A9_1A894413085C",
  "this.MapViewer"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "center",
 "top": "7%",
 "scrollBarOpacity": 0.5,
 "bottom": "7%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_28215A13_0D5D_5B97_4198_A7CA735E9E0A",
 "left": "15%",
 "paddingLeft": 0,
 "layout": "vertical",
 "paddingRight": 0,
 "right": "15%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_28214A13_0D5D_5B97_4193_B631E1496339",
  "this.Container_2B0BF61C_0D5B_2B90_4179_632488B1209E"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "center",
 "top": "7%",
 "scrollBarOpacity": 0.5,
 "bottom": "7%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2A193C4C_0D3B_DFF0_4161_A2CD128EF536",
 "left": "15%",
 "paddingLeft": 0,
 "layout": "vertical",
 "paddingRight": 0,
 "right": "15%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_2A19EC4C_0D3B_DFF0_414D_37145C22C5BC"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "center",
 "top": "7%",
 "scrollBarOpacity": 0.5,
 "bottom": "7%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_06C5DBA5_1140_A63F_41AD_1D83A33F1255",
 "left": "10%",
 "paddingLeft": 0,
 "layout": "horizontal",
 "paddingRight": 0,
 "right": "10%",
 "scrollBarColor": "#000000",
 "shadowColor": "#000000",
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "shadowHorizontalLength": 0,
 "shadowVerticalLength": 0,
 "children": [
  "this.Container_06C5ABA5_1140_A63F_41A9_850CF958D0DB",
  "this.Container_06C58BA5_1140_A63F_419D_EC83F94F8C54"
 ],
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "5%",
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "scrollBarMargin": 2,
 "shadowBlurRadius": 25,
 "gap": 10,
 "paddingBottom": 0,
 "shadowOpacity": 0.3,
 "shadow": true,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "shadowSpread": 1,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Global"
 },
 "propagateClick": false
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "Container_06C43BA5_1140_A63F_41A1_96DC8F4CAD2F",
 "left": "10%",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "vertical",
 "paddingRight": 20,
 "right": "10%",
 "children": [
  "this.IconButton_06C40BA5_1140_A63F_41AC_FA560325FD81"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "horizontalAlign": "right",
 "minHeight": 1,
 "verticalAlign": "top",
 "top": "5%",
 "scrollBarOpacity": 0.5,
 "bottom": "80%",
 "contentOpaque": false,
 "minWidth": 1,
 "scrollBarMargin": 2,
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 20,
 "overflow": "visible",
 "data": {
  "name": "Container X global"
 }
},
{
 "maxHeight": 842,
 "propagateClick": false,
 "id": "Image_25FF1AE4_3476_6C4C_418D_1C6467605634",
 "left": "0%",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_25FF1AE4_3476_6C4C_418D_1C6467605634.png",
 "minHeight": 1,
 "horizontalAlign": "center",
 "width": "18.373%",
 "bottom": "0%",
 "verticalAlign": "middle",
 "minWidth": 1,
 "height": "95.238%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "scaleMode": "fit_inside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 1191,
 "data": {
  "name": "Image5044"
 }
},
{
 "maxHeight": 600,
 "propagateClick": false,
 "id": "Image_3BB7053A_3452_A5C4_4193_A05712EAB942",
 "left": "16.4%",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_3BB7053A_3452_A5C4_4193_A05712EAB942.png",
 "minHeight": 1,
 "horizontalAlign": "center",
 "width": "17.003%",
 "bottom": "6.35%",
 "verticalAlign": "middle",
 "minWidth": 1,
 "height": "84.127%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "scaleMode": "fit_inside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 600,
 "data": {
  "name": "Image6263"
 }
},
{
 "maxHeight": 420,
 "propagateClick": false,
 "id": "Image_24FB80F1_347F_9C45_41C5_7957D6F95340",
 "left": "27.98%",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_24FB80F1_347F_9C45_41C5_7957D6F95340.png",
 "minHeight": 1,
 "horizontalAlign": "center",
 "width": "21.527%",
 "bottom": "0%",
 "verticalAlign": "middle",
 "minWidth": 1,
 "height": "82.54%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "scaleMode": "fit_inside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 593,
 "data": {
  "name": "Image5711"
 }
},
{
 "maxHeight": 374,
 "propagateClick": false,
 "id": "Image_3B894FAF_3472_E4DD_41C1_F82A82E59EF2",
 "paddingRight": 0,
 "right": "24.44%",
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_3B894FAF_3472_E4DD_41C1_F82A82E59EF2.png",
 "minHeight": 1,
 "horizontalAlign": "center",
 "width": "38.04%",
 "bottom": "11.11%",
 "verticalAlign": "middle",
 "minWidth": 1,
 "top": "0%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "scaleMode": "fit_inside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 666,
 "data": {
  "name": "Image5513"
 }
},
{
 "maxHeight": 225,
 "propagateClick": false,
 "id": "Image_24401105_3473_BDCD_41AE_40A528647033",
 "paddingRight": 0,
 "right": "16.27%",
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_24401105_3473_BDCD_41AE_40A528647033.png",
 "minHeight": 1,
 "width": "15.749%",
 "bottom": "10.56%",
 "verticalAlign": "middle",
 "minWidth": 1,
 "horizontalAlign": "center",
 "top": "5.79%",
 "shadow": false,
 "backgroundOpacity": 0,
 "paddingBottom": 0,
 "scaleMode": "fit_inside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 225,
 "data": {
  "name": "Image5979"
 }
},
{
 "maxHeight": 803,
 "propagateClick": false,
 "id": "Image_24ECBA1C_3457_AFFC_41C7_B9AA62158AD5",
 "paddingRight": 0,
 "right": "0.03%",
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_24ECBA1C_3457_AFFC_41C7_B9AA62158AD5.png",
 "minHeight": 1,
 "width": "17.378%",
 "bottom": "23.73%",
 "verticalAlign": "middle",
 "minWidth": 1,
 "horizontalAlign": "center",
 "top": "10.63%",
 "shadow": false,
 "backgroundOpacity": 0,
 "paddingBottom": 0,
 "scaleMode": "fit_inside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 1493,
 "data": {
  "name": "Image4823"
 }
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499E2C55_6C69_8374_41D1_D36B06469BC4",
 "levels": [
  {
   "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499E7C55_6C69_8374_41AA_304AA8B802A1",
 "levels": [
  {
   "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499FBC55_6C69_8374_41D9_029A5E3474DB",
 "levels": [
  {
   "url": "media/panorama_7EAAB67F_6B97_8F34_41C1_632F61DE1FD5_0_HS_2_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_49807C56_6C69_8374_41D3_C714001B34AA",
 "levels": [
  {
   "url": "media/panorama_7D6B5EF5_6B97_FF34_4187_828AEA18CAB4_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499D0C55_6C69_8374_41C6_89EF1D808DEB",
 "levels": [
  {
   "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499D5C55_6C69_8374_41C4_2C037895F1D5",
 "levels": [
  {
   "url": "media/panorama_7E837B36_6B97_8534_41B3_B5698B90A766_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_49981C54_6C69_8374_41B0_0CD4725BDF7D",
 "levels": [
  {
   "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_4999AC54_6C69_8374_41D7_ACC49BF1C1A5",
 "levels": [
  {
   "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_4999FC54_6C69_8374_41B3_0F9D3900189D",
 "levels": [
  {
   "url": "media/panorama_7E024EC3_6BA8_BF4C_41C0_F16C55CD915E_0_HS_2_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 6,
 "frameCount": 24,
 "frameDuration": 41,
 "colCount": 4,
 "id": "AnimatedImageResource_49973C54_6C69_8374_41AB_375CCD4E4972",
 "levels": [
  {
   "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 1220,
   "height": 1110
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 6,
 "frameCount": 24,
 "frameDuration": 41,
 "colCount": 4,
 "id": "AnimatedImageResource_49975C54_6C69_8374_41A9_173763839FF3",
 "levels": [
  {
   "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 1220,
   "height": 1110
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 6,
 "frameCount": 24,
 "frameDuration": 41,
 "colCount": 4,
 "id": "AnimatedImageResource_4998EC54_6C69_8374_41D1_88E22EEC58B8",
 "levels": [
  {
   "url": "media/panorama_7F5C0352_6BA8_854C_41C3_CCF0A0482021_0_HS_2_0.png",
   "class": "ImageResourceLevel",
   "width": 1220,
   "height": 1110
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499F2C56_6C69_8374_41D3_5D463EA72DF1",
 "levels": [
  {
   "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499F7C56_6C69_8374_41D0_00CCD1834C36",
 "levels": [
  {
   "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_49808C56_6C69_8374_41BE_5D8A47277159",
 "levels": [
  {
   "url": "media/panorama_7E3DD269_6B97_875C_41C6_22C1A7F1B88A_0_HS_2_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499CBC55_6C69_8374_4192_1A7A0E83E17B",
 "levels": [
  {
   "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499CCC55_6C69_8374_41DA_CE6CB9EB89DD",
 "levels": [
  {
   "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499C1C55_6C69_8374_41BD_396D3AF2A7B5",
 "levels": [
  {
   "url": "media/panorama_7EFCB305_6B97_86D5_41D1_76A2C97A0809_0_HS_2_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499B8C55_6C69_8374_41B1_97596043BA9C",
 "levels": [
  {
   "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499B2C55_6C69_8374_41DA_542831DA3A84",
 "levels": [
  {
   "url": "media/panorama_7E0D970C_6BA8_8ED4_41D8_68D9D7CED5C2_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 6,
 "frameCount": 24,
 "frameDuration": 41,
 "colCount": 4,
 "id": "AnimatedImageResource_71EC5A39_6BE9_873C_417A_95AAF4DEA5AC",
 "levels": [
  {
   "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 1220,
   "height": 1050
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 6,
 "frameCount": 24,
 "frameDuration": 41,
 "colCount": 4,
 "id": "AnimatedImageResource_71EE1A3A_6BE9_873C_41D6_83605D199ED0",
 "levels": [
  {
   "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0_HS_2_0.png",
   "class": "ImageResourceLevel",
   "width": 1220,
   "height": 1110
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 6,
 "frameCount": 24,
 "frameDuration": 41,
 "colCount": 4,
 "id": "AnimatedImageResource_71710D25_6BEB_82D4_41D8_C0C63CA765BE",
 "levels": [
  {
   "url": "media/panorama_79B5673F_6BA8_8D34_41B9_C651D0B65F09_0_HS_3_0.png",
   "class": "ImageResourceLevel",
   "width": 1220,
   "height": 780
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_49996C54_6C69_8374_4196_DB3DE52FE978",
 "levels": [
  {
   "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499ABC54_6C69_8374_41DA_A26DAD1312F7",
 "levels": [
  {
   "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_1_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499ADC54_6C69_8374_41AD_DD197F733D2A",
 "levels": [
  {
   "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_2_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499A6C54_6C69_8374_41DA_4E6DFBF1E4F5",
 "levels": [
  {
   "url": "media/panorama_7E7BFB2F_6BA8_86D4_41D6_418739DC5551_0_HS_3_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_499D8C55_6C69_8374_41B4_4A3A423CD6BE",
 "levels": [
  {
   "url": "media/panorama_7D84DEF7_6B97_9F34_41DA_012EFD088A7C_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "class": "AnimatedImageResource",
 "rowCount": 3,
 "frameCount": 9,
 "frameDuration": 62,
 "colCount": 3,
 "id": "AnimatedImageResource_4981EC56_6C69_8374_41D2_56EA384F4D7E",
 "levels": [
  {
   "url": "media/panorama_7DDBCAE6_6B97_8754_41D1_A76591989421_0_HS_0_0.png",
   "class": "ImageResourceLevel",
   "width": 330,
   "height": 180
  }
 ]
},
{
 "transparencyActive": true,
 "maxHeight": 58,
 "propagateClick": true,
 "id": "IconButton_EE5807F6_E3BE_860E_41E7_431DDDA54BAC",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 58,
 "minHeight": 1,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_EE5807F6_E3BE_860E_41E7_431DDDA54BAC.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "click": "this.shareTwitter(window.location.href)",
 "height": 58,
 "rollOverIconURL": "skin/IconButton_EE5807F6_E3BE_860E_41E7_431DDDA54BAC_rollover.png",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 58,
 "data": {
  "name": "IconButton TWITTER"
 }
},
{
 "transparencyActive": true,
 "maxHeight": 58,
 "propagateClick": true,
 "id": "IconButton_EED5213F_E3B9_7A7D_41D8_1B642C004521",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "width": 58,
 "minHeight": 1,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_EED5213F_E3B9_7A7D_41D8_1B642C004521.png",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "click": "this.shareFacebook(window.location.href)",
 "height": 58,
 "rollOverIconURL": "skin/IconButton_EED5213F_E3B9_7A7D_41D8_1B642C004521_rollover.png",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 58,
 "data": {
  "name": "IconButton FB"
 }
},
{
 "textDecoration": "none",
 "shadowSpread": 1,
 "propagateClick": true,
 "rollOverBackgroundColorRatios": [
  0.01
 ],
 "id": "Button_1B998D00_16C4_0505_41AD_67CAA4AAEFE0",
 "rollOverBackgroundColor": [
  "#04A3E1"
 ],
 "backgroundColorRatios": [
  0
 ],
 "iconBeforeLabel": true,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Montserrat",
 "fontColor": "#FFFFFF",
 "paddingLeft": 0,
 "shadowColor": "#000000",
 "borderSize": 0,
 "data": {
  "name": "Button house info"
 },
 "width": 120,
 "iconHeight": 0,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": 12,
 "label": "HOME",
 "horizontalAlign": "center",
 "height": 40,
 "shadowBlurRadius": 15,
 "gap": 5,
 "rollOverBackgroundOpacity": 0.8,
 "backgroundColor": [
  "#000000"
 ],
 "paddingBottom": 0,
 "click": "this.setComponentVisibility(this.Container_062AB830_1140_E215_41AF_6C9D65345420, true, 0, null, null, false)",
 "fontStyle": "normal",
 "backgroundOpacity": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "rollOverShadow": false,
 "class": "Button",
 "borderRadius": 0,
 "paddingTop": 0,
 "iconWidth": 0,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "fontWeight": "bold"
},
{
 "textDecoration": "none",
 "shadowSpread": 1,
 "propagateClick": true,
 "rollOverBackgroundColorRatios": [
  0
 ],
 "id": "Button_1B999D00_16C4_0505_41AB_D0C2E7857448",
 "rollOverBackgroundColor": [
  "#04A3E1"
 ],
 "backgroundColorRatios": [
  0,
  1
 ],
 "iconBeforeLabel": true,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Montserrat",
 "fontColor": "#FFFFFF",
 "paddingLeft": 0,
 "shadowColor": "#000000",
 "borderSize": 0,
 "data": {
  "name": "Button panorama list"
 },
 "width": 130,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": 12,
 "label": "PANORAMA",
 "horizontalAlign": "center",
 "height": 40,
 "shadowBlurRadius": 15,
 "gap": 5,
 "rollOverBackgroundOpacity": 0.8,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "paddingBottom": 0,
 "click": "this.setComponentVisibility(this.Container_39DE87B1_0C06_62AF_417B_8CB0FB5C9D15, true, 0, null, null, false)",
 "fontStyle": "normal",
 "backgroundOpacity": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "class": "Button",
 "borderRadius": 0,
 "paddingTop": 0,
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "fontWeight": "bold"
},
{
 "textDecoration": "none",
 "shadowSpread": 1,
 "propagateClick": true,
 "rollOverBackgroundColorRatios": [
  0
 ],
 "id": "Button_1B9A6D00_16C4_0505_4197_F2108627CC98",
 "rollOverBackgroundColor": [
  "#04A3E1"
 ],
 "backgroundColorRatios": [
  0,
  1
 ],
 "iconBeforeLabel": true,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Montserrat",
 "fontColor": "#FFFFFF",
 "paddingLeft": 0,
 "shadowColor": "#000000",
 "borderSize": 0,
 "data": {
  "name": "Button location"
 },
 "width": 90,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": 12,
 "label": "LOKASI",
 "horizontalAlign": "center",
 "height": 40,
 "shadowBlurRadius": 15,
 "gap": 5,
 "rollOverBackgroundOpacity": 0.8,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "paddingBottom": 0,
 "click": "this.setComponentVisibility(this.Container_221B1648_0C06_E5FD_417F_E6FCCCB4A6D7, true, 0, null, null, false)",
 "fontStyle": "normal",
 "backgroundOpacity": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "class": "Button",
 "borderRadius": 0,
 "paddingTop": 0,
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "fontWeight": "bold"
},
{
 "textDecoration": "none",
 "shadowSpread": 1,
 "propagateClick": true,
 "rollOverBackgroundColorRatios": [
  0
 ],
 "id": "Button_1B9A4D00_16C4_0505_4193_E0EA69B0CBB0",
 "rollOverBackgroundColor": [
  "#04A3E1"
 ],
 "backgroundColorRatios": [
  0,
  1
 ],
 "iconBeforeLabel": true,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Montserrat",
 "fontColor": "#FFFFFF",
 "paddingLeft": 0,
 "shadowColor": "#000000",
 "borderSize": 0,
 "data": {
  "name": "Button floorplan"
 },
 "width": 103,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": 12,
 "label": "PETA",
 "horizontalAlign": "center",
 "height": 40,
 "shadowBlurRadius": 15,
 "gap": 5,
 "rollOverBackgroundOpacity": 0.8,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "paddingBottom": 0,
 "click": "this.setComponentVisibility(this.Container_2F8BB687_0D4F_6B7F_4190_9490D02FBC41, true, 0, null, null, false)",
 "fontStyle": "normal",
 "backgroundOpacity": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "class": "Button",
 "borderRadius": 0,
 "paddingTop": 0,
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "fontWeight": "bold"
},
{
 "textDecoration": "none",
 "shadowSpread": 1,
 "propagateClick": true,
 "rollOverBackgroundColorRatios": [
  0
 ],
 "id": "Button_1B9A5D00_16C4_0505_41B0_D18F25F377C4",
 "rollOverBackgroundColor": [
  "#04A3E1"
 ],
 "backgroundColorRatios": [
  0,
  1
 ],
 "iconBeforeLabel": true,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Montserrat",
 "fontColor": "#FFFFFF",
 "paddingLeft": 0,
 "shadowColor": "#000000",
 "borderSize": 0,
 "data": {
  "name": "Button photoalbum"
 },
 "width": 112,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": 12,
 "label": "ALBUM",
 "horizontalAlign": "center",
 "height": 40,
 "shadowBlurRadius": 15,
 "gap": 5,
 "rollOverBackgroundOpacity": 0.8,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "paddingBottom": 0,
 "click": "this.setComponentVisibility(this.Container_2A1A5C4D_0D3B_DFF0_41A9_8FC811D03C8E, true, 0, null, null, false)",
 "fontStyle": "normal",
 "backgroundOpacity": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "class": "Button",
 "borderRadius": 0,
 "paddingTop": 0,
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "fontWeight": "bold"
},
{
 "textDecoration": "none",
 "shadowSpread": 1,
 "propagateClick": true,
 "rollOverBackgroundColorRatios": [
  0
 ],
 "id": "Button_245BD38F_3452_7CDD_41A8_76D5E7E84BCA",
 "rollOverBackgroundColor": [
  "#04A3E1"
 ],
 "backgroundColorRatios": [
  0,
  1
 ],
 "iconBeforeLabel": true,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Montserrat",
 "fontColor": "#FFFFFF",
 "paddingLeft": 0,
 "shadowColor": "#000000",
 "borderSize": 0,
 "data": {
  "name": "Button location"
 },
 "width": 90,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": 12,
 "label": "TENTANG KAMI",
 "horizontalAlign": "center",
 "height": 40,
 "shadowBlurRadius": 15,
 "gap": 5,
 "rollOverBackgroundOpacity": 0.8,
 "backgroundColor": [
  "#000000",
  "#000000"
 ],
 "paddingBottom": 0,
 "click": "this.setComponentVisibility(this.Container_06C41BA5_1140_A63F_41AE_B0CBD78DEFDC, true, 0, null, null, false)",
 "fontStyle": "normal",
 "backgroundOpacity": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "class": "Button",
 "borderRadius": 0,
 "paddingTop": 0,
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "fontWeight": "bold"
},
{
 "backgroundColorRatios": [
  0
 ],
 "scrollBarWidth": 10,
 "id": "Container_062A682F_1140_E20B_41B0_3071FCBF3DC9",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.Image_062A182F_1140_E20B_41B0_9CB8FFD6AA5A"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "middle",
 "horizontalAlign": "center",
 "backgroundColor": [
  "#000000"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "85%",
 "data": {
  "name": "-left"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_062A082F_1140_E20A_4193_DF1A4391DC79",
 "propagateClick": false,
 "paddingLeft": 50,
 "scrollBarColor": "#0069A3",
 "layout": "vertical",
 "paddingRight": 50,
 "children": [
  "this.Container_062A3830_1140_E215_4195_1698933FE51C",
  "this.Container_062A2830_1140_E215_41AA_EB25B7BD381C",
  "this.Container_062AE830_1140_E215_4180_196ED689F4BD"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.51,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 460,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 0,
 "height": "100%",
 "paddingBottom": 20,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "width": "50%",
 "data": {
  "name": "-right"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_062A8830_1140_E215_419D_3439F16CCB3E",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_062A8830_1140_E215_419D_3439F16CCB3E.jpg",
 "verticalAlign": "middle",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_062AB830_1140_E215_41AF_6C9D65345420, false, 0, null, null, false)",
 "height": "75%",
 "width": "25%",
 "rollOverIconURL": "skin/IconButton_062A8830_1140_E215_419D_3439F16CCB3E_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_062A8830_1140_E215_419D_3439F16CCB3E_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "X"
 }
},
{
 "backgroundColorRatios": [
  0
 ],
 "scrollBarWidth": 10,
 "id": "Container_23F797B7_0C0A_6293_41A7_EC89DBCDB93F",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.ViewerAreaLabeled_23F787B7_0C0A_6293_419A_B4B58B92DAFC",
  "this.Container_23F7F7B7_0C0A_6293_4195_D6240EBAFDC0"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "middle",
 "horizontalAlign": "center",
 "backgroundColor": [
  "#000000"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "85%",
 "data": {
  "name": "-left"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_23F027B7_0C0A_6293_418E_075FCFAA8A19",
 "propagateClick": false,
 "paddingLeft": 50,
 "scrollBarColor": "#0069A3",
 "layout": "vertical",
 "paddingRight": 50,
 "children": [
  "this.Container_23F017B8_0C0A_629D_41A5_DE420F5F9331",
  "this.Container_23F007B8_0C0A_629D_41A3_034CF0D91203",
  "this.Container_23F047B8_0C0A_629D_415D_F05EF8619564"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.51,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 460,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 0,
 "height": "100%",
 "paddingBottom": 20,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "width": "50%",
 "data": {
  "name": "-right"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_23F087B8_0C0A_629D_4194_6F34C6CBE1DA",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_23F087B8_0C0A_629D_4194_6F34C6CBE1DA.jpg",
 "verticalAlign": "middle",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_23F0F7B8_0C0A_629D_418A_F171085EFBF8, false, 0, null, null, false)",
 "height": "75%",
 "width": "25%",
 "rollOverIconURL": "skin/IconButton_23F087B8_0C0A_629D_4194_6F34C6CBE1DA_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_23F087B8_0C0A_629D_4194_6F34C6CBE1DA_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "X"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_3A67552A_0C3A_67BD_4195_ECE46CCB34EA",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_3918BF37_0C06_E393_41A1_17CF0ADBAB12",
  "this.IconButton_38922473_0C06_2593_4199_C585853A1AB3"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "verticalAlign": "top",
 "minWidth": 1,
 "horizontalAlign": "left",
 "gap": 10,
 "height": 140,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "header"
 }
},
{
 "backgroundColorRatios": [
  0
 ],
 "itemThumbnailWidth": 220,
 "id": "ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0",
 "itemLabelFontStyle": "normal",
 "paddingLeft": 70,
 "scrollBarColor": "#04A3E1",
 "horizontalAlign": "center",
 "itemLabelHorizontalAlign": "center",
 "rollOverItemThumbnailShadowHorizontalLength": 8,
 "itemMode": "normal",
 "scrollBarVisible": "rollOver",
 "rollOverItemThumbnailShadowColor": "#04A3E1",
 "scrollBarOpacity": 0.5,
 "itemPaddingRight": 3,
 "itemMaxHeight": 1000,
 "itemThumbnailOpacity": 1,
 "minHeight": 1,
 "itemBorderRadius": 0,
 "width": "100%",
 "selectedItemThumbnailShadowBlurRadius": 16,
 "verticalAlign": "middle",
 "minWidth": 1,
 "itemLabelFontFamily": "Montserrat",
 "rollOverItemThumbnailShadowVerticalLength": 0,
 "itemPaddingLeft": 3,
 "itemMaxWidth": 1000,
 "itemHorizontalAlign": "center",
 "itemLabelPosition": "bottom",
 "backgroundColor": [
  "#000000"
 ],
 "selectedItemThumbnailShadowHorizontalLength": 0,
 "itemOpacity": 1,
 "selectedItemLabelFontColor": "#04A3E1",
 "height": "100%",
 "itemBackgroundOpacity": 0,
 "selectedItemThumbnailShadowVerticalLength": 0,
 "backgroundOpacity": 0.05,
 "rollOverItemThumbnailShadowBlurRadius": 0,
 "shadow": false,
 "class": "ThumbnailGrid",
 "itemPaddingTop": 3,
 "itemBackgroundColor": [],
 "itemThumbnailBorderRadius": 0,
 "itemBackgroundColorRatios": [],
 "propagateClick": false,
 "itemWidth": 220,
 "selectedItemThumbnailShadow": true,
 "paddingRight": 70,
 "itemMinHeight": 50,
 "borderSize": 0,
 "backgroundColorDirection": "vertical",
 "itemLabelFontWeight": "normal",
 "itemLabelTextDecoration": "none",
 "selectedItemLabelFontWeight": "bold",
 "rollOverItemLabelFontColor": "#04A3E1",
 "rollOverItemThumbnailShadow": true,
 "playList": "this.ThumbnailList_034EDD7A_0D3B_3991_41A5_D706671923C0_playlist",
 "scrollBarMargin": 2,
 "itemLabelFontSize": 14,
 "itemMinWidth": 50,
 "itemThumbnailScaleMode": "fit_outside",
 "itemVerticalAlign": "top",
 "itemLabelFontColor": "#666666",
 "itemHeight": 156,
 "gap": 26,
 "itemBackgroundColorDirection": "vertical",
 "itemThumbnailHeight": 125,
 "paddingBottom": 70,
 "itemThumbnailShadow": false,
 "paddingTop": 10,
 "borderRadius": 5,
 "itemPaddingBottom": 3,
 "itemLabelGap": 7,
 "scrollBarWidth": 10,
 "data": {
  "name": "ThumbnailList"
 }
},
{
 "backgroundColorRatios": [
  0
 ],
 "scrollBarWidth": 10,
 "id": "Container_221C0648_0C06_E5FD_4193_12BCE1D6DD6B",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.WebFrame_22F9EEFF_0C1A_2293_4165_411D4444EFEA"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "middle",
 "horizontalAlign": "center",
 "backgroundColor": [
  "#000000"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "85%",
 "data": {
  "name": "-left"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_221C9648_0C06_E5FD_41A1_A79DE53B3031",
 "propagateClick": false,
 "paddingLeft": 50,
 "scrollBarColor": "#0069A3",
 "layout": "vertical",
 "paddingRight": 50,
 "children": [
  "this.Container_221C8648_0C06_E5FD_41A0_8247B2B7DEB0",
  "this.Container_221B7648_0C06_E5FD_418B_12E57BBFD8EC",
  "this.Container_221B4648_0C06_E5FD_4194_30EDC4E7D1B6"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.51,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 400,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 0,
 "height": "100%",
 "paddingBottom": 20,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "width": "15%",
 "data": {
  "name": "-right"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_221B2648_0C06_E5FD_41A6_F9E27CDB95AF",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_221B2648_0C06_E5FD_41A6_F9E27CDB95AF.jpg",
 "verticalAlign": "middle",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_221B1648_0C06_E5FD_417F_E6FCCCB4A6D7, false, 0, null, null, false)",
 "height": "75%",
 "width": "25%",
 "rollOverIconURL": "skin/IconButton_221B2648_0C06_E5FD_41A6_F9E27CDB95AF_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_221B2648_0C06_E5FD_41A6_F9E27CDB95AF_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "X"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2F8A7686_0D4F_6B71_41A9_1A894413085C",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_2F8A4686_0D4F_6B71_4183_10C1696E2923",
  "this.IconButton_2F8A5686_0D4F_6B71_41A1_13CF877A165E"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "verticalAlign": "top",
 "minWidth": 1,
 "horizontalAlign": "left",
 "gap": 10,
 "height": 140,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "header"
 }
},
{
 "transitionDuration": 500,
 "progressBackgroundColorDirection": "vertical",
 "id": "MapViewer",
 "progressBarBackgroundColorRatios": [
  0
 ],
 "playbackBarBottom": 0,
 "paddingLeft": 0,
 "playbackBarHeadOpacity": 1,
 "progressBorderColor": "#FFFFFF",
 "toolTipBorderColor": "#767676",
 "toolTipShadowSpread": 0,
 "playbackBarProgressBackgroundColorDirection": "vertical",
 "progressBarBackgroundColor": [
  "#3399FF"
 ],
 "progressBackgroundColor": [
  "#FFFFFF"
 ],
 "width": "100%",
 "minHeight": 1,
 "toolTipFontSize": 12,
 "toolTipOpacity": 1,
 "toolTipShadowBlurRadius": 3,
 "playbackBarBackgroundColorDirection": "vertical",
 "toolTipTextShadowColor": "#000000",
 "playbackBarBackgroundColor": [
  "#FFFFFF"
 ],
 "playbackBarHeadWidth": 6,
 "playbackBarHeadShadowHorizontalLength": 0,
 "playbackBarRight": 0,
 "playbackBarHeight": 10,
 "minWidth": 1,
 "toolTipPaddingBottom": 4,
 "toolTipFontWeight": "normal",
 "playbackBarProgressBorderSize": 0,
 "toolTipTextShadowBlurRadius": 3,
 "playbackBarProgressBorderRadius": 0,
 "progressBarBorderRadius": 0,
 "progressBarBorderSize": 6,
 "toolTipShadowColor": "#333333",
 "height": "100%",
 "playbackBarBorderRadius": 0,
 "playbackBarHeadBorderRadius": 0,
 "transitionMode": "blending",
 "class": "ViewerArea",
 "playbackBarHeadBorderColor": "#000000",
 "shadow": false,
 "toolTipShadowOpacity": 1,
 "progressLeft": 0,
 "playbackBarProgressBorderColor": "#000000",
 "playbackBarHeadBorderSize": 0,
 "playbackBarProgressOpacity": 1,
 "toolTipFontStyle": "normal",
 "playbackBarBorderSize": 0,
 "toolTipShadowHorizontalLength": 0,
 "playbackBarHeadShadowVerticalLength": 0,
 "propagateClick": false,
 "playbackBarBackgroundOpacity": 1,
 "toolTipFontFamily": "Arial",
 "toolTipShadowVerticalLength": 0,
 "vrPointerSelectionColor": "#FF6600",
 "toolTipTextShadowOpacity": 0,
 "playbackBarHeadBackgroundColor": [
  "#111111",
  "#666666"
 ],
 "playbackBarHeadShadowColor": "#000000",
 "vrPointerSelectionTime": 2000,
 "paddingRight": 0,
 "firstTransitionDuration": 0,
 "progressOpacity": 1,
 "progressRight": 0,
 "borderSize": 0,
 "progressBarBackgroundColorDirection": "vertical",
 "playbackBarHeadShadow": true,
 "progressBottom": 2,
 "toolTipBackgroundColor": "#F6F6F6",
 "toolTipFontColor": "#606060",
 "progressHeight": 6,
 "playbackBarHeadBackgroundColorDirection": "vertical",
 "progressBackgroundOpacity": 1,
 "playbackBarProgressBackgroundColor": [
  "#3399FF"
 ],
 "playbackBarOpacity": 1,
 "displayTooltipInTouchScreens": true,
 "vrPointerColor": "#FFFFFF",
 "progressBarOpacity": 1,
 "playbackBarHeadShadowOpacity": 0.7,
 "playbackBarBorderColor": "#FFFFFF",
 "progressBorderSize": 0,
 "toolTipBorderSize": 1,
 "toolTipPaddingRight": 6,
 "toolTipPaddingLeft": 6,
 "progressBorderRadius": 0,
 "paddingBottom": 0,
 "toolTipDisplayTime": 600,
 "playbackBarProgressBackgroundColorRatios": [
  0
 ],
 "playbackBarLeft": 0,
 "paddingTop": 0,
 "playbackBarHeadHeight": 15,
 "borderRadius": 0,
 "playbackBarHeadShadowBlurRadius": 3,
 "progressBackgroundColorRatios": [
  0.01
 ],
 "toolTipBorderRadius": 3,
 "playbackBarHeadBackgroundColorRatios": [
  0,
  1
 ],
 "progressBarBorderColor": "#0066FF",
 "data": {
  "name": "Floor Plan"
 },
 "toolTipPaddingTop": 4
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_28214A13_0D5D_5B97_4193_B631E1496339",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_28217A13_0D5D_5B97_419A_F894ECABEB04",
  "this.IconButton_28216A13_0D5D_5B97_41A9_2CAB10DB6CA3"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "verticalAlign": "top",
 "minWidth": 1,
 "horizontalAlign": "left",
 "gap": 10,
 "height": 140,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "header"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2B0BF61C_0D5B_2B90_4179_632488B1209E",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.ViewerAreaLabeled_281D2361_0D5F_E9B0_41A1_A1F237F85FD7",
  "this.IconButton_2BE71718_0D55_6990_41A5_73D31D902E1D",
  "this.IconButton_28BF3E40_0D4B_DBF0_41A3_D5D2941E6E14"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "width": "100%",
 "data": {
  "name": "Container photo"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_2A19EC4C_0D3B_DFF0_414D_37145C22C5BC",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.ViewerAreaLabeled_2A198C4C_0D3B_DFF0_419F_C9A785406D9C",
  "this.IconButton_2A19BC4C_0D3B_DFF0_419F_D0DCB12FF482",
  "this.IconButton_2A19AC4C_0D3B_DFF0_4181_A2C230C2E510",
  "this.IconButton_2A19CC4C_0D3B_DFF0_41AA_D2AC34177CF1"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "width": "100%",
 "data": {
  "name": "Container photo"
 }
},
{
 "backgroundColorRatios": [
  0
 ],
 "scrollBarWidth": 10,
 "id": "Container_06C5ABA5_1140_A63F_41A9_850CF958D0DB",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "children": [
  "this.Image_06C5BBA5_1140_A63F_41A7_E6D01D4CC397"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "middle",
 "horizontalAlign": "center",
 "backgroundColor": [
  "#000000"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "55%",
 "data": {
  "name": "-left"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_06C58BA5_1140_A63F_419D_EC83F94F8C54",
 "propagateClick": false,
 "paddingLeft": 60,
 "scrollBarColor": "#0069A3",
 "layout": "vertical",
 "paddingRight": 60,
 "children": [
  "this.Container_06C59BA5_1140_A63F_41B1_4B41E3B7D98D",
  "this.Container_06C46BA5_1140_A63F_4151_B5A20B4EA86A",
  "this.Container_06C42BA5_1140_A63F_4195_037A0687532F"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.51,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 460,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 0,
 "height": "100%",
 "paddingBottom": 20,
 "shadow": false,
 "backgroundOpacity": 1,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "visible",
 "width": "45%",
 "data": {
  "name": "-right"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_06C40BA5_1140_A63F_41AC_FA560325FD81",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_06C40BA5_1140_A63F_41AC_FA560325FD81.jpg",
 "verticalAlign": "middle",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_06C41BA5_1140_A63F_41AE_B0CBD78DEFDC, false, 0, null, null, false)",
 "height": "75%",
 "width": "25%",
 "rollOverIconURL": "skin/IconButton_06C40BA5_1140_A63F_41AC_FA560325FD81_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_06C40BA5_1140_A63F_41AC_FA560325FD81_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "X"
 }
},
{
 "maxHeight": 1000,
 "propagateClick": false,
 "id": "Image_062A182F_1140_E20B_41B0_9CB8FFD6AA5A",
 "left": "0%",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_062A182F_1140_E20B_41B0_9CB8FFD6AA5A.jpg",
 "minHeight": 1,
 "horizontalAlign": "center",
 "width": "100%",
 "verticalAlign": "middle",
 "minWidth": 1,
 "height": "100%",
 "top": "0%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "scaleMode": "fit_outside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 2000,
 "data": {
  "name": "Image"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_062A3830_1140_E215_4195_1698933FE51C",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 0,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "verticalAlign": "top",
 "minWidth": 1,
 "horizontalAlign": "right",
 "gap": 0,
 "height": 60,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container space"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_062A2830_1140_E215_41AA_EB25B7BD381C",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#E73B2C",
 "layout": "vertical",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_062AD830_1140_E215_41B0_321699661E7F",
  "this.Button_062AF830_1140_E215_418D_D2FC11B12C47"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 520,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.79,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 100,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 30,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container text"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_062AE830_1140_E215_4180_196ED689F4BD",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "width": 370,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "height": 40,
 "verticalAlign": "top",
 "minWidth": 1,
 "scrollBarOpacity": 0.5,
 "gap": 10,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Container space"
 }
},
{
 "transitionDuration": 500,
 "data": {
  "name": "Viewer info 1"
 },
 "progressBackgroundColorDirection": "vertical",
 "id": "ViewerAreaLabeled_23F787B7_0C0A_6293_419A_B4B58B92DAFC",
 "left": 0,
 "playbackBarBottom": 0,
 "paddingLeft": 0,
 "playbackBarHeadOpacity": 1,
 "progressBorderColor": "#FFFFFF",
 "progressBarBackgroundColorRatios": [
  0
 ],
 "toolTipBorderColor": "#767676",
 "right": 0,
 "toolTipShadowSpread": 0,
 "playbackBarProgressBackgroundColorDirection": "vertical",
 "progressBarBackgroundColor": [
  "#3399FF"
 ],
 "progressBackgroundColor": [
  "#FFFFFF"
 ],
 "minHeight": 1,
 "toolTipFontSize": 12,
 "toolTipOpacity": 1,
 "playbackBarHeadWidth": 6,
 "toolTipShadowBlurRadius": 3,
 "playbackBarHeight": 10,
 "playbackBarBackgroundColorDirection": "vertical",
 "toolTipTextShadowColor": "#000000",
 "playbackBarBackgroundColor": [
  "#FFFFFF"
 ],
 "playbackBarHeadShadowHorizontalLength": 0,
 "playbackBarRight": 0,
 "minWidth": 1,
 "toolTipPaddingBottom": 4,
 "toolTipFontWeight": "normal",
 "playbackBarProgressBorderSize": 0,
 "toolTipTextShadowBlurRadius": 3,
 "playbackBarProgressBorderRadius": 0,
 "progressBarBorderRadius": 0,
 "progressBarBorderSize": 6,
 "toolTipShadowColor": "#333333",
 "playbackBarBorderRadius": 0,
 "playbackBarHeadBorderRadius": 0,
 "transitionMode": "blending",
 "class": "ViewerArea",
 "playbackBarHeadBorderColor": "#000000",
 "shadow": false,
 "toolTipShadowOpacity": 1,
 "progressLeft": 0,
 "playbackBarProgressBorderColor": "#000000",
 "playbackBarHeadBorderSize": 0,
 "playbackBarProgressOpacity": 1,
 "toolTipFontStyle": "normal",
 "playbackBarBorderSize": 0,
 "toolTipShadowHorizontalLength": 0,
 "playbackBarHeadShadowVerticalLength": 0,
 "propagateClick": false,
 "playbackBarBackgroundOpacity": 1,
 "toolTipFontFamily": "Arial",
 "toolTipShadowVerticalLength": 0,
 "vrPointerSelectionColor": "#FF6600",
 "toolTipTextShadowOpacity": 0,
 "playbackBarHeadBackgroundColor": [
  "#111111",
  "#666666"
 ],
 "playbackBarHeadShadowColor": "#000000",
 "vrPointerSelectionTime": 2000,
 "paddingRight": 0,
 "firstTransitionDuration": 0,
 "progressOpacity": 1,
 "progressRight": 0,
 "borderSize": 0,
 "progressBarBackgroundColorDirection": "vertical",
 "playbackBarHeadShadow": true,
 "progressBottom": 2,
 "toolTipBackgroundColor": "#F6F6F6",
 "toolTipFontColor": "#606060",
 "progressHeight": 6,
 "playbackBarHeadBackgroundColorDirection": "vertical",
 "progressBackgroundOpacity": 1,
 "top": 0,
 "playbackBarOpacity": 1,
 "bottom": 0,
 "playbackBarProgressBackgroundColor": [
  "#3399FF"
 ],
 "vrPointerColor": "#FFFFFF",
 "displayTooltipInTouchScreens": true,
 "progressBarOpacity": 1,
 "playbackBarHeadShadowOpacity": 0.7,
 "playbackBarBorderColor": "#FFFFFF",
 "progressBorderSize": 0,
 "toolTipBorderSize": 1,
 "toolTipPaddingRight": 6,
 "toolTipPaddingLeft": 6,
 "progressBorderRadius": 0,
 "paddingBottom": 0,
 "toolTipDisplayTime": 600,
 "playbackBarProgressBackgroundColorRatios": [
  0
 ],
 "playbackBarLeft": 0,
 "toolTipPaddingTop": 4,
 "toolTipBorderRadius": 3,
 "borderRadius": 0,
 "playbackBarHeadShadowBlurRadius": 3,
 "progressBackgroundColorRatios": [
  0.01
 ],
 "paddingTop": 0,
 "playbackBarHeadBackgroundColorRatios": [
  0,
  1
 ],
 "progressBarBorderColor": "#0066FF",
 "playbackBarHeadHeight": 15
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "Container_23F7F7B7_0C0A_6293_4195_D6240EBAFDC0",
 "left": "0%",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "children": [
  "this.IconButton_23F7E7B7_0C0A_6293_419F_D3D84EB3AFBD",
  "this.Container_23F7D7B7_0C0A_6293_4195_312C9CAEABE4",
  "this.IconButton_23F037B7_0C0A_6293_41A2_C1707EE666E4"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "horizontalAlign": "left",
 "minHeight": 1,
 "top": "0%",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "verticalAlign": "middle",
 "minWidth": 1,
 "height": "100%",
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container arrows"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_23F017B8_0C0A_629D_41A5_DE420F5F9331",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 0,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "verticalAlign": "top",
 "minWidth": 1,
 "horizontalAlign": "right",
 "gap": 0,
 "height": 60,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container space"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_23F007B8_0C0A_629D_41A3_034CF0D91203",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#E73B2C",
 "layout": "vertical",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_23F067B8_0C0A_629D_41A9_1A1C797BB055",
  "this.Button_23F057B8_0C0A_629D_41A2_CD6BDCDB0145"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 520,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.79,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 100,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 30,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container text"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_23F047B8_0C0A_629D_415D_F05EF8619564",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "width": 370,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "height": 40,
 "verticalAlign": "top",
 "minWidth": 1,
 "scrollBarOpacity": 0.5,
 "gap": 10,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Container space"
 }
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "HTMLText_3918BF37_0C06_E393_41A1_17CF0ADBAB12",
 "left": "0%",
 "paddingLeft": 80,
 "scrollBarColor": "#000000",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 100,
 "top": "0%",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "100%",
 "width": "77.115%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:5.15vh;font-family:'Bebas Neue Bold';\">___</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:5.15vh;font-family:'Bebas Neue Bold';\">Panorama list:</SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText54192"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_38922473_0C06_2593_4199_C585853A1AB3",
 "paddingRight": 0,
 "right": 20,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "right",
 "iconURL": "skin/IconButton_38922473_0C06_2593_4199_C585853A1AB3.jpg",
 "verticalAlign": "top",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_39DE87B1_0C06_62AF_417B_8CB0FB5C9D15, false, 0, null, null, false)",
 "height": "36.14%",
 "width": "100%",
 "top": 20,
 "rollOverIconURL": "skin/IconButton_38922473_0C06_2593_4199_C585853A1AB3_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_38922473_0C06_2593_4199_C585853A1AB3_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton X"
 }
},
{
 "backgroundColorRatios": [
  0
 ],
 "id": "WebFrame_22F9EEFF_0C1A_2293_4165_411D4444EFEA",
 "left": "0%",
 "propagateClick": false,
 "paddingLeft": 0,
 "paddingRight": 0,
 "right": "0%",
 "borderSize": 0,
 "url": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14377.55330038866!2d-73.99492968084243!3d40.75084469078082!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9f775f259%3A0x999668d0d7c3fd7d!2s400+5th+Ave%2C+New+York%2C+NY+10018!5e0!3m2!1ses!2sus!4v1467271743182\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen>",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollEnabled": true,
 "bottom": "0%",
 "minWidth": 1,
 "top": "0%",
 "insetBorder": false,
 "backgroundColor": [
  "#FFFFFF"
 ],
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 1,
 "borderRadius": 0,
 "class": "WebFrame",
 "paddingTop": 0,
 "data": {
  "name": "WebFrame48191"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_221C8648_0C06_E5FD_41A0_8247B2B7DEB0",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 0,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "verticalAlign": "top",
 "minWidth": 1,
 "horizontalAlign": "right",
 "gap": 0,
 "height": 60,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container space"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_221B7648_0C06_E5FD_418B_12E57BBFD8EC",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#E73B2C",
 "layout": "vertical",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_221B6648_0C06_E5FD_41A0_77851DC2C548",
  "this.Button_221B5648_0C06_E5FD_4198_40C786948FF0"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 520,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.79,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 100,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 30,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container text"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_221B4648_0C06_E5FD_4194_30EDC4E7D1B6",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "width": 370,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "height": 40,
 "verticalAlign": "top",
 "minWidth": 1,
 "scrollBarOpacity": 0.5,
 "gap": 10,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Container space"
 }
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "HTMLText_2F8A4686_0D4F_6B71_4183_10C1696E2923",
 "left": "0%",
 "paddingLeft": 80,
 "scrollBarColor": "#000000",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 100,
 "top": "0%",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "100%",
 "width": "77.115%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:5.15vh;font-family:'Bebas Neue Bold';\">___</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:5.15vh;font-family:'Bebas Neue Bold';\">FLOORPLAN:</SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText54192"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_2F8A5686_0D4F_6B71_41A1_13CF877A165E",
 "paddingRight": 0,
 "right": 20,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "right",
 "iconURL": "skin/IconButton_2F8A5686_0D4F_6B71_41A1_13CF877A165E.jpg",
 "verticalAlign": "top",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_2F8BB687_0D4F_6B7F_4190_9490D02FBC41, false, 0, null, null, false)",
 "height": "36.14%",
 "width": "100%",
 "top": 20,
 "rollOverIconURL": "skin/IconButton_2F8A5686_0D4F_6B71_41A1_13CF877A165E_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_2F8A5686_0D4F_6B71_41A1_13CF877A165E_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton X"
 }
},
{
 "propagateClick": false,
 "scrollBarWidth": 10,
 "id": "HTMLText_28217A13_0D5D_5B97_419A_F894ECABEB04",
 "left": "0%",
 "paddingLeft": 80,
 "scrollBarColor": "#000000",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 100,
 "top": "0%",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "100%",
 "width": "77.115%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:5.15vh;font-family:'Bebas Neue Bold';\">___</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:5.15vh;font-family:'Bebas Neue Bold';\">PHOTOALBUM:</SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText54192"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_28216A13_0D5D_5B97_41A9_2CAB10DB6CA3",
 "paddingRight": 0,
 "right": 20,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "right",
 "iconURL": "skin/IconButton_28216A13_0D5D_5B97_41A9_2CAB10DB6CA3.jpg",
 "verticalAlign": "top",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_2820BA13_0D5D_5B97_4192_AABC38F6F169, false, 0, null, null, false)",
 "height": "36.14%",
 "width": "100%",
 "top": 20,
 "rollOverIconURL": "skin/IconButton_28216A13_0D5D_5B97_41A9_2CAB10DB6CA3_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_28216A13_0D5D_5B97_41A9_2CAB10DB6CA3_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton X"
 }
},
{
 "transitionDuration": 500,
 "data": {
  "name": "Viewer photoalbum + text 1"
 },
 "progressBackgroundColorDirection": "vertical",
 "id": "ViewerAreaLabeled_281D2361_0D5F_E9B0_41A1_A1F237F85FD7",
 "left": "0%",
 "playbackBarBottom": 0,
 "paddingLeft": 0,
 "playbackBarHeadOpacity": 1,
 "progressBorderColor": "#FFFFFF",
 "progressBarBackgroundColorRatios": [
  0
 ],
 "toolTipBorderColor": "#767676",
 "toolTipShadowSpread": 0,
 "playbackBarProgressBackgroundColorDirection": "vertical",
 "progressBarBackgroundColor": [
  "#3399FF"
 ],
 "progressBackgroundColor": [
  "#FFFFFF"
 ],
 "width": "100%",
 "minHeight": 1,
 "toolTipFontSize": 12,
 "toolTipOpacity": 1,
 "toolTipShadowBlurRadius": 3,
 "playbackBarBackgroundColorDirection": "vertical",
 "toolTipTextShadowColor": "#000000",
 "playbackBarBackgroundColor": [
  "#FFFFFF"
 ],
 "playbackBarHeadWidth": 6,
 "playbackBarHeadShadowHorizontalLength": 0,
 "playbackBarRight": 0,
 "playbackBarHeight": 10,
 "minWidth": 1,
 "toolTipPaddingBottom": 4,
 "toolTipFontWeight": "normal",
 "playbackBarProgressBorderSize": 0,
 "toolTipTextShadowBlurRadius": 3,
 "playbackBarProgressBorderRadius": 0,
 "progressBarBorderRadius": 0,
 "progressBarBorderSize": 6,
 "toolTipShadowColor": "#333333",
 "height": "100%",
 "playbackBarBorderRadius": 0,
 "playbackBarHeadBorderRadius": 0,
 "transitionMode": "blending",
 "class": "ViewerArea",
 "playbackBarHeadBorderColor": "#000000",
 "shadow": false,
 "toolTipShadowOpacity": 1,
 "progressLeft": 0,
 "playbackBarProgressBorderColor": "#000000",
 "playbackBarHeadBorderSize": 0,
 "playbackBarProgressOpacity": 1,
 "toolTipFontStyle": "normal",
 "playbackBarBorderSize": 0,
 "toolTipShadowHorizontalLength": 0,
 "playbackBarHeadShadowVerticalLength": 0,
 "propagateClick": false,
 "playbackBarBackgroundOpacity": 1,
 "toolTipFontFamily": "Arial",
 "toolTipShadowVerticalLength": 0,
 "vrPointerSelectionColor": "#FF6600",
 "toolTipTextShadowOpacity": 0,
 "playbackBarHeadBackgroundColor": [
  "#111111",
  "#666666"
 ],
 "playbackBarHeadShadowColor": "#000000",
 "vrPointerSelectionTime": 2000,
 "paddingRight": 0,
 "firstTransitionDuration": 0,
 "progressOpacity": 1,
 "progressRight": 0,
 "borderSize": 0,
 "progressBarBackgroundColorDirection": "vertical",
 "playbackBarHeadShadow": true,
 "progressBottom": 2,
 "toolTipBackgroundColor": "#F6F6F6",
 "toolTipFontColor": "#606060",
 "progressHeight": 6,
 "playbackBarHeadBackgroundColorDirection": "vertical",
 "progressBackgroundOpacity": 1,
 "top": "0%",
 "playbackBarOpacity": 1,
 "displayTooltipInTouchScreens": true,
 "playbackBarProgressBackgroundColor": [
  "#3399FF"
 ],
 "vrPointerColor": "#FFFFFF",
 "progressBarOpacity": 1,
 "playbackBarHeadShadowOpacity": 0.7,
 "playbackBarBorderColor": "#FFFFFF",
 "progressBorderSize": 0,
 "toolTipBorderSize": 1,
 "toolTipPaddingTop": 4,
 "toolTipPaddingLeft": 6,
 "progressBorderRadius": 0,
 "toolTipPaddingRight": 6,
 "toolTipDisplayTime": 600,
 "playbackBarProgressBackgroundColorRatios": [
  0
 ],
 "playbackBarLeft": 0,
 "paddingBottom": 0,
 "toolTipBorderRadius": 3,
 "borderRadius": 0,
 "playbackBarHeadShadowBlurRadius": 3,
 "progressBackgroundColorRatios": [
  0.01
 ],
 "paddingTop": 0,
 "playbackBarHeadBackgroundColorRatios": [
  0,
  1
 ],
 "progressBarBorderColor": "#0066FF",
 "playbackBarHeadHeight": 15
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_2BE71718_0D55_6990_41A5_73D31D902E1D",
 "left": 10,
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "iconURL": "skin/IconButton_2BE71718_0D55_6990_41A5_73D31D902E1D.png",
 "bottom": "20%",
 "mode": "push",
 "verticalAlign": "middle",
 "minWidth": 50,
 "horizontalAlign": "center",
 "width": "14.22%",
 "top": "20%",
 "rollOverIconURL": "skin/IconButton_2BE71718_0D55_6990_41A5_73D31D902E1D_rollover.png",
 "shadow": false,
 "backgroundOpacity": 0,
 "paddingBottom": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_2BE71718_0D55_6990_41A5_73D31D902E1D_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton <"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_28BF3E40_0D4B_DBF0_41A3_D5D2941E6E14",
 "paddingRight": 0,
 "right": 10,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "iconURL": "skin/IconButton_28BF3E40_0D4B_DBF0_41A3_D5D2941E6E14.png",
 "bottom": "20%",
 "mode": "push",
 "verticalAlign": "middle",
 "minWidth": 50,
 "horizontalAlign": "center",
 "width": "14.22%",
 "top": "20%",
 "rollOverIconURL": "skin/IconButton_28BF3E40_0D4B_DBF0_41A3_D5D2941E6E14_rollover.png",
 "shadow": false,
 "backgroundOpacity": 0,
 "paddingBottom": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_28BF3E40_0D4B_DBF0_41A3_D5D2941E6E14_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton >"
 }
},
{
 "transitionDuration": 500,
 "data": {
  "name": "Viewer photoalbum 1"
 },
 "progressBackgroundColorDirection": "vertical",
 "id": "ViewerAreaLabeled_2A198C4C_0D3B_DFF0_419F_C9A785406D9C",
 "left": "0%",
 "playbackBarBottom": 0,
 "paddingLeft": 0,
 "playbackBarHeadOpacity": 1,
 "progressBorderColor": "#FFFFFF",
 "progressBarBackgroundColorRatios": [
  0
 ],
 "toolTipBorderColor": "#767676",
 "toolTipShadowSpread": 0,
 "playbackBarProgressBackgroundColorDirection": "vertical",
 "progressBarBackgroundColor": [
  "#3399FF"
 ],
 "progressBackgroundColor": [
  "#FFFFFF"
 ],
 "width": "100%",
 "minHeight": 1,
 "toolTipFontSize": 12,
 "toolTipOpacity": 1,
 "toolTipShadowBlurRadius": 3,
 "playbackBarBackgroundColorDirection": "vertical",
 "toolTipTextShadowColor": "#000000",
 "playbackBarBackgroundColor": [
  "#FFFFFF"
 ],
 "playbackBarHeadWidth": 6,
 "playbackBarHeadShadowHorizontalLength": 0,
 "playbackBarRight": 0,
 "playbackBarHeight": 10,
 "minWidth": 1,
 "toolTipPaddingBottom": 4,
 "toolTipFontWeight": "normal",
 "playbackBarProgressBorderSize": 0,
 "toolTipTextShadowBlurRadius": 3,
 "playbackBarProgressBorderRadius": 0,
 "progressBarBorderRadius": 0,
 "progressBarBorderSize": 6,
 "toolTipShadowColor": "#333333",
 "height": "100%",
 "playbackBarBorderRadius": 0,
 "playbackBarHeadBorderRadius": 0,
 "transitionMode": "blending",
 "class": "ViewerArea",
 "playbackBarHeadBorderColor": "#000000",
 "shadow": false,
 "toolTipShadowOpacity": 1,
 "progressLeft": 0,
 "playbackBarProgressBorderColor": "#000000",
 "playbackBarHeadBorderSize": 0,
 "playbackBarProgressOpacity": 1,
 "toolTipFontStyle": "normal",
 "playbackBarBorderSize": 0,
 "toolTipShadowHorizontalLength": 0,
 "playbackBarHeadShadowVerticalLength": 0,
 "propagateClick": false,
 "playbackBarBackgroundOpacity": 1,
 "toolTipFontFamily": "Arial",
 "toolTipShadowVerticalLength": 0,
 "vrPointerSelectionColor": "#FF6600",
 "toolTipTextShadowOpacity": 0,
 "playbackBarHeadBackgroundColor": [
  "#111111",
  "#666666"
 ],
 "playbackBarHeadShadowColor": "#000000",
 "vrPointerSelectionTime": 2000,
 "paddingRight": 0,
 "firstTransitionDuration": 0,
 "progressOpacity": 1,
 "progressRight": 0,
 "borderSize": 0,
 "progressBarBackgroundColorDirection": "vertical",
 "playbackBarHeadShadow": true,
 "progressBottom": 2,
 "toolTipBackgroundColor": "#F6F6F6",
 "toolTipFontColor": "#606060",
 "progressHeight": 6,
 "playbackBarHeadBackgroundColorDirection": "vertical",
 "progressBackgroundOpacity": 1,
 "top": "0%",
 "playbackBarOpacity": 1,
 "displayTooltipInTouchScreens": true,
 "playbackBarProgressBackgroundColor": [
  "#3399FF"
 ],
 "vrPointerColor": "#FFFFFF",
 "progressBarOpacity": 1,
 "playbackBarHeadShadowOpacity": 0.7,
 "playbackBarBorderColor": "#FFFFFF",
 "progressBorderSize": 0,
 "toolTipBorderSize": 1,
 "toolTipPaddingTop": 4,
 "toolTipPaddingLeft": 6,
 "progressBorderRadius": 0,
 "toolTipPaddingRight": 6,
 "toolTipDisplayTime": 600,
 "playbackBarProgressBackgroundColorRatios": [
  0
 ],
 "playbackBarLeft": 0,
 "paddingBottom": 0,
 "toolTipBorderRadius": 3,
 "borderRadius": 0,
 "playbackBarHeadShadowBlurRadius": 3,
 "progressBackgroundColorRatios": [
  0.01
 ],
 "paddingTop": 0,
 "playbackBarHeadBackgroundColorRatios": [
  0,
  1
 ],
 "progressBarBorderColor": "#0066FF",
 "playbackBarHeadHeight": 15
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_2A19BC4C_0D3B_DFF0_419F_D0DCB12FF482",
 "left": 10,
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "iconURL": "skin/IconButton_2A19BC4C_0D3B_DFF0_419F_D0DCB12FF482.png",
 "bottom": "20%",
 "mode": "push",
 "verticalAlign": "middle",
 "minWidth": 50,
 "horizontalAlign": "center",
 "width": "14.22%",
 "top": "20%",
 "rollOverIconURL": "skin/IconButton_2A19BC4C_0D3B_DFF0_419F_D0DCB12FF482_rollover.png",
 "shadow": false,
 "backgroundOpacity": 0,
 "paddingBottom": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_2A19BC4C_0D3B_DFF0_419F_D0DCB12FF482_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton <"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_2A19AC4C_0D3B_DFF0_4181_A2C230C2E510",
 "paddingRight": 0,
 "right": 10,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "iconURL": "skin/IconButton_2A19AC4C_0D3B_DFF0_4181_A2C230C2E510.png",
 "bottom": "20%",
 "mode": "push",
 "verticalAlign": "middle",
 "minWidth": 50,
 "horizontalAlign": "center",
 "width": "14.22%",
 "top": "20%",
 "rollOverIconURL": "skin/IconButton_2A19AC4C_0D3B_DFF0_4181_A2C230C2E510_rollover.png",
 "shadow": false,
 "backgroundOpacity": 0,
 "paddingBottom": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_2A19AC4C_0D3B_DFF0_4181_A2C230C2E510_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton >"
 }
},
{
 "transparencyActive": false,
 "maxHeight": 60,
 "propagateClick": false,
 "id": "IconButton_2A19CC4C_0D3B_DFF0_41AA_D2AC34177CF1",
 "paddingRight": 0,
 "right": 20,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 50,
 "horizontalAlign": "right",
 "iconURL": "skin/IconButton_2A19CC4C_0D3B_DFF0_41AA_D2AC34177CF1.jpg",
 "verticalAlign": "top",
 "mode": "push",
 "minWidth": 50,
 "click": "this.setComponentVisibility(this.Container_2A1A5C4D_0D3B_DFF0_41A9_8FC811D03C8E, false, 0, null, null, false)",
 "height": "10%",
 "width": "10%",
 "top": 20,
 "rollOverIconURL": "skin/IconButton_2A19CC4C_0D3B_DFF0_41AA_D2AC34177CF1_rollover.jpg",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_2A19CC4C_0D3B_DFF0_41AA_D2AC34177CF1_pressed.jpg",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 60,
 "data": {
  "name": "IconButton X"
 }
},
{
 "maxHeight": 1000,
 "propagateClick": false,
 "id": "Image_06C5BBA5_1140_A63F_41A7_E6D01D4CC397",
 "left": "0%",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "url": "skin/Image_06C5BBA5_1140_A63F_41A7_E6D01D4CC397.jpg",
 "minHeight": 1,
 "horizontalAlign": "center",
 "width": "100%",
 "verticalAlign": "bottom",
 "minWidth": 1,
 "height": "100%",
 "top": "0%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "scaleMode": "fit_outside",
 "borderRadius": 0,
 "class": "Image",
 "paddingTop": 0,
 "maxWidth": 2000,
 "data": {
  "name": "Image"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_06C59BA5_1140_A63F_41B1_4B41E3B7D98D",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 0,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "verticalAlign": "top",
 "minWidth": 1,
 "horizontalAlign": "right",
 "gap": 0,
 "height": 60,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 20,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container space"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_06C46BA5_1140_A63F_4151_B5A20B4EA86A",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#E73B2C",
 "layout": "vertical",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_0B42C466_11C0_623D_4193_9FAB57A5AC33",
  "this.Container_0D9BF47A_11C0_E215_41A4_A63C8527FF9C"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 520,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.79,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 100,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "100%",
 "paddingBottom": 30,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "Container text"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_06C42BA5_1140_A63F_4195_037A0687532F",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "width": 370,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "horizontalAlign": "left",
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "height": 40,
 "verticalAlign": "top",
 "minWidth": 1,
 "scrollBarOpacity": 0.5,
 "gap": 10,
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "data": {
  "name": "Container space"
 }
},
{
 "propagateClick": false,
 "id": "HTMLText_062AD830_1140_E215_41B0_321699661E7F",
 "paddingLeft": 10,
 "scrollBarColor": "#04A3E1",
 "paddingRight": 10,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "100%",
 "width": "100%",
 "paddingBottom": 20,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "scrollBarWidth": 10,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:7.61vh;font-family:'Bebas Neue Bold';\">___</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:6.6vh;font-family:'Bebas Neue Bold';\">Lorem ipsum</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:6.6vh;font-family:'Bebas Neue Bold';\">dolor sit amet</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:3.13vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:3.13vh;font-family:'Bebas Neue Bold';\">consectetur adipiscing elit. Morbi bibendum pharetra lorem, accumsan san nulla.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.12vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Mauris aliquet neque quis libero consequat vestibulum. Donec lacinia consequat dolor viverra sagittis. Praesent consequat porttitor risus, eu condimentum nunc. Proin et velit ac sapien luctus efficitur egestas ac augue. Nunc dictum, augue eget eleifend interdum, quam libero imperdiet lectus, vel scelerisque turpis lectus vel ligula. Duis a porta sem. Maecenas sollicitudin nunc id risus fringilla, a pharetra orci iaculis. Aliquam turpis ligula, tincidunt sit amet consequat ac, imperdiet non dolor.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.12vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Integer gravida dui quis euismod placerat. Maecenas quis accumsan ipsum. Aliquam gravida velit at dolor mollis, quis luctus mauris vulputate. Proin condimentum id nunc sed sollicitudin.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:2.57vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:2.57vh;font-family:'Bebas Neue Bold';\"><B>Donec feugiat:</B></SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Nisl nec mi sollicitudin facilisis </SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Nam sed faucibus est.</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Ut eget lorem sed leo.</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Sollicitudin tempor sit amet non urna. </SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Aliquam feugiat mauris sit amet.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:2.57vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:2.57vh;font-family:'Bebas Neue Bold';\"><B>lorem ipsum:</B></SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:3.58vh;font-family:'Bebas Neue Bold';\"><B>$150,000</B></SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText"
 }
},
{
 "textDecoration": "none",
 "iconBeforeLabel": true,
 "shadowSpread": 1,
 "backgroundColorRatios": [
  0
 ],
 "data": {
  "name": "Button"
 },
 "id": "Button_062AF830_1140_E215_418D_D2FC11B12C47",
 "propagateClick": false,
 "paddingLeft": 0,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Bebas Neue Bold",
 "fontColor": "#FFFFFF",
 "shadowColor": "#000000",
 "borderSize": 0,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": "3vh",
 "label": "lorem ipsum",
 "horizontalAlign": "center",
 "backgroundColor": [
  "#04A3E1"
 ],
 "shadowBlurRadius": 6,
 "gap": 5,
 "rollOverBackgroundOpacity": 1,
 "height": "9%",
 "fontStyle": "normal",
 "paddingBottom": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "backgroundOpacity": 0.7,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Button",
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "width": "46%",
 "fontWeight": "normal"
},
{
 "transparencyActive": true,
 "maxHeight": 150,
 "propagateClick": false,
 "id": "IconButton_23F7E7B7_0C0A_6293_419F_D3D84EB3AFBD",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 70,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_23F7E7B7_0C0A_6293_419F_D3D84EB3AFBD.png",
 "verticalAlign": "middle",
 "mode": "push",
 "minWidth": 70,
 "height": "8%",
 "width": "12%",
 "rollOverIconURL": "skin/IconButton_23F7E7B7_0C0A_6293_419F_D3D84EB3AFBD_rollover.png",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_23F7E7B7_0C0A_6293_419F_D3D84EB3AFBD_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 150,
 "data": {
  "name": "IconButton <"
 }
},
{
 "propagateClick": false,
 "id": "Container_23F7D7B7_0C0A_6293_4195_312C9CAEABE4",
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "absolute",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "horizontalAlign": "left",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "verticalAlign": "top",
 "minWidth": 1,
 "height": "30%",
 "gap": 10,
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "Container",
 "paddingTop": 0,
 "overflow": "scroll",
 "scrollBarWidth": 10,
 "width": "80%",
 "data": {
  "name": "Container separator"
 }
},
{
 "transparencyActive": true,
 "maxHeight": 150,
 "propagateClick": false,
 "id": "IconButton_23F037B7_0C0A_6293_41A2_C1707EE666E4",
 "paddingRight": 0,
 "paddingLeft": 0,
 "borderSize": 0,
 "minHeight": 70,
 "horizontalAlign": "center",
 "iconURL": "skin/IconButton_23F037B7_0C0A_6293_41A2_C1707EE666E4.png",
 "verticalAlign": "middle",
 "mode": "push",
 "minWidth": 70,
 "height": "8%",
 "width": "12%",
 "rollOverIconURL": "skin/IconButton_23F037B7_0C0A_6293_41A2_C1707EE666E4_rollover.png",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "pressedIconURL": "skin/IconButton_23F037B7_0C0A_6293_41A2_C1707EE666E4_pressed.png",
 "class": "IconButton",
 "paddingTop": 0,
 "cursor": "hand",
 "maxWidth": 150,
 "data": {
  "name": "IconButton >"
 }
},
{
 "propagateClick": false,
 "id": "HTMLText_23F067B8_0C0A_629D_41A9_1A1C797BB055",
 "paddingLeft": 10,
 "scrollBarColor": "#04A3E1",
 "paddingRight": 10,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "100%",
 "width": "100%",
 "paddingBottom": 20,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "scrollBarWidth": 10,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:7.61vh;font-family:'Bebas Neue Bold';\">___</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:6.6vh;font-family:'Bebas Neue Bold';\">Lorem ipsum</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:6.6vh;font-family:'Bebas Neue Bold';\">dolor sit amet</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:3.13vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:3.13vh;font-family:'Bebas Neue Bold';\">consectetur adipiscing elit. Morbi bibendum pharetra lorem, accumsan san nulla.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.12vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Mauris aliquet neque quis libero consequat vestibulum. Donec lacinia consequat dolor viverra sagittis. Praesent consequat porttitor risus, eu condimentum nunc. Proin et velit ac sapien luctus efficitur egestas ac augue. Nunc dictum, augue eget eleifend interdum, quam libero imperdiet lectus, vel scelerisque turpis lectus vel ligula. Duis a porta sem. Maecenas sollicitudin nunc id risus fringilla, a pharetra orci iaculis. Aliquam turpis ligula, tincidunt sit amet consequat ac, imperdiet non dolor.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.12vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Integer gravida dui quis euismod placerat. Maecenas quis accumsan ipsum. Aliquam gravida velit at dolor mollis, quis luctus mauris vulputate. Proin condimentum id nunc sed sollicitudin.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:2.57vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:2.57vh;font-family:'Bebas Neue Bold';\"><B>Donec feugiat:</B></SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Nisl nec mi sollicitudin facilisis </SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Nam sed faucibus est.</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Ut eget lorem sed leo.</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Sollicitudin tempor sit amet non urna. </SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\"> \u2022 Aliquam feugiat mauris sit amet.</SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText"
 }
},
{
 "textDecoration": "none",
 "iconBeforeLabel": true,
 "shadowSpread": 1,
 "backgroundColorRatios": [
  0
 ],
 "data": {
  "name": "Button"
 },
 "id": "Button_23F057B8_0C0A_629D_41A2_CD6BDCDB0145",
 "propagateClick": false,
 "paddingLeft": 0,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Bebas Neue Bold",
 "fontColor": "#FFFFFF",
 "shadowColor": "#000000",
 "borderSize": 0,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "pressedBackgroundColorRatios": [
  0
 ],
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "minWidth": 1,
 "mode": "push",
 "fontSize": "3vh",
 "label": "lorem ipsum",
 "horizontalAlign": "center",
 "backgroundColor": [
  "#04A3E1"
 ],
 "shadowBlurRadius": 6,
 "gap": 5,
 "rollOverBackgroundOpacity": 1,
 "height": "9%",
 "fontStyle": "normal",
 "paddingBottom": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "backgroundOpacity": 0.7,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Button",
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "width": "46%",
 "fontWeight": "normal"
},
{
 "propagateClick": false,
 "id": "HTMLText_221B6648_0C06_E5FD_41A0_77851DC2C548",
 "paddingLeft": 10,
 "scrollBarColor": "#04A3E1",
 "paddingRight": 10,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "100%",
 "width": "100%",
 "paddingBottom": 20,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "scrollBarWidth": 10,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:7.61vh;font-family:'Bebas Neue Bold';\">___</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:6.6vh;font-family:'Bebas Neue Bold';\">location</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.68vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:3.13vh;font-family:'Bebas Neue Bold';\">address line 1</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:3.13vh;font-family:'Bebas Neue Bold';\">address line 2</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:5.15vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Mauris aliquet neque quis libero consequat vestibulum. Donec lacinia consequat dolor viverra sagittis. Praesent consequat porttitor risus, eu condimentum nunc. Proin et velit ac sapien luctus efficitur egestas ac augue. Nunc dictum, augue eget eleifend interdum, quam libero imperdiet lectus, vel scelerisque turpis lectus vel ligula. Duis a porta sem. Maecenas sollicitudin nunc id risus fringilla, a pharetra orci iaculis. Aliquam turpis ligula, tincidunt sit amet consequat ac.</SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText"
 }
},
{
 "textDecoration": "none",
 "iconBeforeLabel": true,
 "shadowSpread": 1,
 "backgroundColorRatios": [
  0
 ],
 "data": {
  "name": "Button"
 },
 "id": "Button_221B5648_0C06_E5FD_4198_40C786948FF0",
 "propagateClick": false,
 "paddingLeft": 0,
 "layout": "horizontal",
 "paddingRight": 0,
 "fontFamily": "Bebas Neue Bold",
 "fontColor": "#FFFFFF",
 "width": 207,
 "shadowColor": "#000000",
 "borderSize": 0,
 "iconHeight": 32,
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "borderColor": "#000000",
 "verticalAlign": "middle",
 "pressedBackgroundColorRatios": [
  0
 ],
 "height": 59,
 "mode": "push",
 "minWidth": 1,
 "fontSize": 34,
 "label": "lorem ipsum",
 "horizontalAlign": "center",
 "shadowBlurRadius": 6,
 "gap": 5,
 "rollOverBackgroundOpacity": 1,
 "backgroundColor": [
  "#04A3E1"
 ],
 "fontStyle": "normal",
 "paddingBottom": 0,
 "pressedBackgroundColor": [
  "#000000"
 ],
 "shadow": false,
 "backgroundOpacity": 0.7,
 "paddingTop": 0,
 "borderRadius": 0,
 "visible": false,
 "class": "Button",
 "iconWidth": 32,
 "cursor": "hand",
 "pressedBackgroundOpacity": 1,
 "fontWeight": "normal"
},
{
 "propagateClick": false,
 "id": "HTMLText_0B42C466_11C0_623D_4193_9FAB57A5AC33",
 "paddingLeft": 0,
 "scrollBarColor": "#04A3E1",
 "paddingRight": 0,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "25.714%",
 "width": "100%",
 "paddingBottom": 10,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "scrollBarWidth": 10,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#04a3e1;font-size:7.61vh;font-family:'Bebas Neue Bold';\">___</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:5.93vh;font-family:'Bebas Neue Bold';\">Tentang Kami</SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText18899"
 }
},
{
 "backgroundColorRatios": [
  0,
  1
 ],
 "scrollBarWidth": 10,
 "id": "Container_0D9BF47A_11C0_E215_41A4_A63C8527FF9C",
 "propagateClick": false,
 "paddingLeft": 0,
 "scrollBarColor": "#000000",
 "layout": "horizontal",
 "paddingRight": 0,
 "children": [
  "this.HTMLText_0B4B0DC1_11C0_6277_41A4_201A5BB3F7AE"
 ],
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "backgroundColorDirection": "vertical",
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "contentOpaque": false,
 "minWidth": 1,
 "verticalAlign": "top",
 "horizontalAlign": "left",
 "backgroundColor": [
  "#FFFFFF",
  "#FFFFFF"
 ],
 "gap": 10,
 "height": "80%",
 "paddingBottom": 0,
 "shadow": false,
 "backgroundOpacity": 0.3,
 "paddingTop": 0,
 "borderRadius": 0,
 "class": "Container",
 "overflow": "scroll",
 "width": "100%",
 "data": {
  "name": "- content"
 }
},
{
 "propagateClick": false,
 "id": "HTMLText_0B4B0DC1_11C0_6277_41A4_201A5BB3F7AE",
 "paddingLeft": 10,
 "scrollBarColor": "#04A3E1",
 "paddingRight": 10,
 "borderSize": 0,
 "scrollBarVisible": "rollOver",
 "minHeight": 1,
 "scrollBarOpacity": 0.5,
 "scrollBarMargin": 2,
 "minWidth": 1,
 "height": "64.267%",
 "width": "99.706%",
 "paddingBottom": 10,
 "shadow": false,
 "backgroundOpacity": 0,
 "borderRadius": 0,
 "class": "HTMLText",
 "paddingTop": 0,
 "scrollBarWidth": 10,
 "html": "<div style=\"text-align:left; color:#000; \"><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#999999;font-size:1.68vh;font-family:'Bebas Neue Bold';\">Tlf.: +6282310782024</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#999999;font-size:1.68vh;font-family:'Bebas Neue Bold';\">harfebi@pnp.ac.id</SPAN></SPAN></DIV><DIV STYLE=\"text-align:left;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"color:#999999;font-size:1.68vh;font-family:'Bebas Neue Bold';\">www.SphareX.com</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.12vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:justify;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Sistem virtual tour ini dikembangkan melalui kerja sama antara Politeknik Negeri Padang (Tim Sphare X) Jurusan Teknologi Informasi dengan Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung. Proyek ini didanai oleh Hibah Dana Padanan 2024 Kedaireka.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.12vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:justify;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Tim Sphare X terdiri dari Harfebi Fryonanda, Ardian Firosha, Hendra Rotama, dan Taruma Leo Wijaya, sementara Kepala Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung adalah Afrineldi.</SPAN></SPAN></DIV><p STYLE=\"margin:0; line-height:1.12vh;\"><BR STYLE=\"letter-spacing:0vh;color:#000000;font-size:1.01vh;font-family:Arial, Helvetica, sans-serif;\"/></p><DIV STYLE=\"text-align:justify;\"><SPAN STYLE=\"letter-spacing:0vh;color:#000000;font-family:Arial, Helvetica, sans-serif;\"><SPAN STYLE=\"font-size:1.12vh;\">Tujuan dari sistem ini adalah untuk mempromosikan Kawasan Geopark Silokek sebagai destinasi wisata unggulan melalui penggunaan teknologi virtual tour, yang memungkinkan pengguna menjelajahi keindahan alam dan budaya kawasan tersebut secara interaktif. Dengan inovasi ini, diharapkan promosi pariwisata daerah dapat semakin ditingkatkan, menjangkau lebih banyak pengunjung baik dari dalam maupun luar negeri.</SPAN></SPAN></DIV></div>",
 "data": {
  "name": "HTMLText19460"
 }
}],
 "width": "100%",
 "data": {
  "name": "Player468"
 }
};

    
    function HistoryData(playList) {
        this.playList = playList;
        this.list = [];
        this.pointer = -1;
    }

    HistoryData.prototype.add = function(index){
        if(this.pointer < this.list.length && this.list[this.pointer] == index) {
            return;
        }
        ++this.pointer;
        this.list.splice(this.pointer, this.list.length - this.pointer, index);
    };

    HistoryData.prototype.back = function(){
        if(!this.canBack()) return;
        this.playList.set('selectedIndex', this.list[--this.pointer]);
    };

    HistoryData.prototype.forward = function(){
        if(!this.canForward()) return;
        this.playList.set('selectedIndex', this.list[++this.pointer]);
    };

    HistoryData.prototype.canBack = function(){
        return this.pointer > 0;
    };

    HistoryData.prototype.canForward = function(){
        return this.pointer >= 0 && this.pointer < this.list.length-1;
    };
    //

    if(script.data == undefined)
        script.data = {};
    script.data["history"] = {};    //playListID -> HistoryData

    TDV.PlayerAPI.defineScript(script);
})();
