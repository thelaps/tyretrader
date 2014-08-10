/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 02.03.13
 * Time: 18:07
 * To change this template use File | Settings | File Templates.
 */
(function() {
    $ = this.jQuery;

    App = (function() {
        App.prototype.defaults = {};
        App.prototype.options = {};
        App.prototype.ajaxData = {};
        App.prototype.storageData = {};

        function App(options) {
            if(options != undefined){
                this.options = $.extend({}, this.defaults, options);
            }
        }

        App.prototype.destroy = function() {
            return this._deinit();
        };

        App.prototype._init = function() {
            return null;
        };

        App.prototype._deinit = function() {
            return null;
        };

        App.prototype.ajax = function(source) {
            var jsonString = $(source).text();
            this.ajaxData = $.parseJSON(jsonString);
            return this.ajaxData;
        }

        App.prototype.baseLink = function() {
            return $('base').attr('href');

        }

        App.prototype.storage = function(key, val) {
            if(val!=undefined){
                $.extend(this.storageData,{key:val});
                return this.storageData.key;
            }else{
                return this.storageData.key;
            }
        }

        return App;

    })();

    this.App = App;

}).call(this);

var App = new App();