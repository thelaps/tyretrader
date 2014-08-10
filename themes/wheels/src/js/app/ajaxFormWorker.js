/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 14.12.13
 * Time: 23:04
 * To change this template use File | Settings | File Templates.
 */
(function() {

    AFW = (function() {

        AFW.prototype.ajaxData = {};

        function AFW(options){
            window.AFW = this;
            if(jQuery!=undefined){
                this._init();
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
        AFW.prototype._init = function(){
            console.log('afw');
        };

        AFW.prototype.catchForm = function(form, fnc){
            var _this = this;
            form = (form instanceof Object)? form : $(form);
            if($(form).length > 0){
                $(form).each(function(key){
                    console.log(key, $(this));
                    $(this).attr('data-form', 'AFW_'+key);
                    var action = $(this,'[data-form="AFW_'+key+'"]').attr('action');
                    var submiter = $(this,'[data-form="AFW_'+key+'"]').find('[type="submit"]');
                    submiter.attr('data-submit','AFW_'+key);
                    console.log(submiter);
                    submiter.bind({
                        click : function(e){
                            e.preventDefault();
                            _submit = $(this);
                            var afwKey = _submit.attr('data-submit');
                            _submit.attr('disabled',true);
                            var afwform = $(this).closest('form[data-form="'+afwKey+'"]');
                            var action = afwform.attr('action');
                            var formData = afwform.serialize();
                            $.post(action, formData, function(data, status){
                                var json = _this.ajax(data);
                                if(status=='success'){
                                    _this.validator(afwform, json);
                                    if(fnc!=undefined){
                                        fnc(json);
                                    }
                                }else{
                                    alert('Серверная ошибка!');
                                }
                                _submit.removeAttr('disabled');
                            });
                        }
                    });
                });
            }
        };

        AFW.prototype.postAction = function(action, formData, fnc) {
            var _this = this;
            $.post(action, formData, function(data, status){
                var json = _this.ajax(data);
                if(status=='success'){
                    if(fnc!=undefined){
                        fnc(json);
                    }
                }else{
                    alert('Серверная ошибка!');
                }
            });
        };

        AFW.prototype.ajax = function(source) {
            var jsonString = $(source).text();
            this.ajaxData = $.parseJSON(jsonString);
            return this.ajaxData;
        };

        AFW.prototype.validator = function() {

        };

        return AFW;
    })();

    /**
     * Closing
     *
     * @author Geleverya Viktor <geleverya@zfort.com>
     */
    this.AFW = AFW;

}).call(this);