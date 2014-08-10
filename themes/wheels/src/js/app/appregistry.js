/**
 * Created with JetBrains PhpStorm.
 * User: geleverya
 * Date: 25.09.13
 * Time: 18:23
 * To change this template use File | Settings | File Templates.
 */
(function() {

    /**
     * Class for bridge changing folder position
     * @return ddBridge object
     *
     * @author Geleverya Viktor <geleverya@zfort.com>
     */
    App = (function() {

        App.prototype.options = null;
        App.prototype.ui = null;
        App.prototype.lib = null;
        App.prototype.com = null;
        App.prototype.event = null;
        /**
         * Main constructor
         * @path Url that used for making request
         *
         * @author Geleverya Viktor <geleverya@zfort.com>
         */
        function App(options)
        {
            this.options = {
                dir: null
            };
            this.ui = {
                pathMap : {}
            };
            this.lib = {};
            if (options != undefined) {
                jQuery.extend(true, this.options, options);
            }
            window.App = this;
            this._init();
        }

        /**
         * Returns self object.
         * @return ddBridge object
         *
         * @author Geleverya Viktor <geleverya@zfort.com>
         */
        App.prototype._init = function()
        {
            this.com = new Lib;
            this.event = new E;
        };

        //Usage: App.registerElement('path/path/element_key','jQuery selector');
        //path/path/element_key for example 'body/container/your_container'
        App.prototype.registerElement = function(key, element)
        {
            var treePath = key.split('/');
            var treePathTotal = treePath.length;
            var getFromCurrent = function(needle, ui){
                return ui[needle];
            }
            var ui = this.ui;
            for(var i in treePath){
                if(i == treePathTotal-1){
                    if(ui[treePath[i]]==undefined && element.length!=0){
                        if(this.ui.pathMap[treePath[i]]==undefined){
                            this.ui.pathMap[treePath[i]] = [key];
                        }else{
                            this.ui.pathMap[treePath[i]].push(key);
                        }
                        console.log(treePath[i],key);
                        ui[treePath[i]] = element;
                    }
                }else{
                    ui = getFromCurrent(treePath[i], ui);
                }
            }
        };

        //Usage: App.registry('ui','element_key'); returns array of elements
        App.prototype.registry = function(type, key)
        {
            var elements = new Array;
            if(this[type]!=undefined){
                var registry = this[type];
                switch(type){
                    case 'ui':
                        if(registry.pathMap[key]!=undefined){
                            var pathArray = registry.pathMap[key];
                            for(var i in pathArray){
                                var treePath = pathArray[i].split('/');
                                var treePathTotal = treePath.length;
                                var getFromCurrent = function(needle, ui){
                                    return ui[needle];
                                }
                                var ui = registry;
                                for(var i in treePath){
                                    if(i == treePathTotal-1){
                                        if(ui[treePath[i]]!=undefined){
                                            elements.push(ui[treePath[i]]);
                                        }
                                    }else{
                                        ui = getFromCurrent(treePath[i], ui);
                                    }
                                }
                            }
                        }
                        break;
                    case 'lib':
                        if(registry[key]!=undefined){
                            return registry[key];
                        }
                        return null;
                        break;
                }
            }
            return elements;
        };

        /*
        App.com.import('../socket/client/js/socket.js',function(){
            App.registerLibrary('sock',socket,function(_f){
                //using callback function is not required.
                //"socket" - this is native library first entry point
                //"_f" - this is the same as "App.lib.sock"
            });

            App.lib.sock <-- Object of registered library (function or object);
        });
         */
        App.prototype.registerLibrary = function(key,library,onRegister)
        {
            if(this.lib[key]==undefined){
                if(typeof(library)=='object' || typeof(library)=='function'){
                    this.lib[key] = library;

                    var event = key+'Registry';
                    setTimeout(function(){
                        window.App.event.trigger(event);
                    },100);

                    if(onRegister!=undefined){
                        onRegister(this.lib[key]);
                    }
                }
            }
        };

        /*
        App.fire('onReady',function(){
            //before event function (not required)
            console.log('before onReady');
        });
        //after firing event onReady we able to handle it:
        App.event.handle('onReady', function(){
            //event is done!
            console.log('onReady');
        });
        */
        App.prototype.fire = function(event,before)
        {
            if(before!=undefined){
                before();
            }
            window.App.event.trigger(event);
        }

        return App;
    })();

    Lib = (function() {

        function Lib(){
            this._init();
        }

        Lib.prototype.loadedUrls = null;

        Lib.prototype._init = function()
        {
            this.loadedUrls = new Array;
            return null;
        };

        Lib.prototype.import = function(url,fnc)
        {
            var _self = this;
            if(_self.loadedUrls.indexOf(url)=='-1'){
                var h = document.getElementsByTagName('head')[0];
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = url;
                //var x = document.getElementsByTagName('script')[0];
                //var s = x.parentNode.insertBefore(s, x);
                s.onload = fnc;
                s.onreadystatechange = function() {
                    if (this.readyState == 'complete') {
                        fnc();
                    }
                }
                h.appendChild(s);

                _self.loadedUrls.push(url);

                return true;
            }
            return false;
        };

        return Lib;
    })();

    E = (function() {

        function E(){
            this._listeners = {};
            this._init();
        }

        E.prototype._init = function()
        {
            return null;
        };

        E.prototype.handle = function(type, listener){
            if (typeof this._listeners[type] == "undefined"){
                this._listeners[type] = [];
            }

            this._listeners[type].push(listener);
        };

        E.prototype.trigger = function(event){
            if (typeof event == "string"){
                event = { type: event };
            }
            if (!event.target){
                event.target = this;
            }

            if (!event.type){
                throw new Error("Event object missing 'type' property.");
            }

            if (this._listeners[event.type] instanceof Array){
                var listeners = this._listeners[event.type];
                for (var i=0, len=listeners.length; i < len; i++){
                    listeners[i].call(this, event);
                }
            }
        };

        E.prototype.removeListener = function(type, listener){
            if (this._listeners[type] instanceof Array){
                var listeners = this._listeners[type];
                for (var i=0, len=listeners.length; i < len; i++){
                    if (listeners[i] === listener){
                        listeners.splice(i, 1);
                        break;
                    }
                }
            }
        };

        return E;
    })(App);

    /**
     * Closing
     *
     * @author Geleverya Viktor <geleverya@zfort.com>
     */
    this.App = App;

}).call(this);