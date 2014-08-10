/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 14.12.13
 * Time: 23:04
 * To change this template use File | Settings | File Templates.
 */
(function() {

    Action = (function() {

        Action.prototype.list = null;

        function Action(list){
            window.Action = this;
            if(jQuery!=undefined){
                this._init(list);
            }else{
                alert('jQuery is off');
            }
        }

        /**
         * Returns self object.
         * @return ddBridge object
         *
         * @author Geleverya Viktor <geleverya@zfort.com>
         */
        Action.prototype._init = function(list){
            this.list = list;
        };

        Action.prototype.process = function(action, opts){
            var _list = this.list;
            if(_list[action]!=undefined){
                if(_list[action]!=undefined){
                    _list[action](opts);
                }else{
                    _list[action]();
                }
            }else{
                alert('action is missing');
            }
        };


        return Action;
    })();

    /**
     * Closing
     *
     * @author Geleverya Viktor <geleverya@zfort.com>
     */
    this.Action = Action;

}).call(this);