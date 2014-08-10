/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 13.09.13
 * Time: 0:44
 * To change this template use File | Settings | File Templates.
 */
var addEvent = (function () {
    if (document.addEventListener) {
        return function (el, type, fn) {
            if (el && el.nodeName || el === window) {
                el.addEventListener(type, fn, false);
            } else if (el && el.length) {
                for (var i = 0; i < el.length; i++) {
                    addEvent(el[i], type, fn);
                }
            }
        };
    } else {
        return function (el, type, fn) {
            if (el && el.nodeName || el === window) {
                el.attachEvent('on' + type, function () { return fn.call(el, window.event); });
            } else if (el && el.length) {
                for (var i = 0; i < el.length; i++) {
                    addEvent(el[i], type, fn);
                }
            }
        };
    }
})();
$.fn.microUploader = function(url,fnc){
    microUploader = (function(){

        function microUploader(obj, url, fnc){
            this.holder = obj;
            this.readyFunction = fnc;
            this.url = url;
            this.init();
            return this;
        }

        microUploader.prototype.holder;
        microUploader.prototype.tests;
        microUploader.prototype.support;
        microUploader.prototype.acceptedTypes;
        microUploader.prototype.progress;
        microUploader.prototype.fileupload;
        microUploader.prototype.readyFunction;
        microUploader.prototype.url;

        microUploader.prototype.init = function(){
            var _this = this;
            _this.tests = {
                filereader: typeof FileReader != 'undefined',
                dnd: 'draggable' in document.createElement('span'),
                formdata: !!window.FormData,
                progress: "upload" in new XMLHttpRequest
            };
            _this.support = {
                filereader: _this.holder.parent().find('.filereader'),
                formdata: _this.holder.parent().find('.formdata'),
                progress: _this.holder.parent().find('.progress')
            };
            _this.acceptedTypes = {
                'image/png': true,
                'image/jpeg': true,
                'image/gif': true
            };
            _this.progress = _this.holder.parent().find('.uploadprogress');
            _this.fileupload = _this.holder.parent().find('.upload');
            "filereader formdata progress".split(' ').forEach(function (api) {
                if (_this.tests[api] === false) {
                    $(_this.support[api]).addClass('fail');
                } else {
                    // FFS. I could have done el.hidden = true, but IE doesn't support
                    // hidden, so I tried to create a polyfill that would extend the
                    // Element.prototype, but then IE10 doesn't even give me access
                    // to the Element object. Brilliant.
                    $(_this.support[api]).addClass('hidden');
                }
            });

            if (_this.tests.dnd) {
                //console.log('tested');
                _this.holder.bind({
                    dragover:function(e){
                        $(this).addClass('hover');
                        e.preventDefault();
                        return false;
                    }
                });
                _this.holder.bind({
                    dragenter:function(e){
                        $(this).addClass('hover');
                        e.preventDefault();
                        return false;
                    }
                });
                _this.holder.bind({
                    dragleave:function(e){
                        $(this).removeClass('hover');
                        e.stopPropagation();
                        return false;
                    }
                });
                _this.holder.bind({
                    dragend:function(){
                        $(this).removeClass('hover');
                        return false;
                    }
                });
                _this.holder.bind({
                    drop:function(e){
                        $(this).removeClass('hover');
                        e.preventDefault();
                        _this.readfiles(e.dataTransfer.files);
                        return false;
                    }
                });
            } else {
                _this.fileupload.addClass('hidden');
                _this.fileupload.querySelector('input').onchange = function () {
                    _this.readfiles(this.files);
                };
            }
            return null;
        };

        microUploader.prototype.previewfile = function(file) {
            var _this = this;
            if (_this.tests.filereader === true && _this.acceptedTypes[file.type] === true) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    var image = new Image();
                    image.src = event.target.result;
                    image.width = 300; // a fake resize
                    _this.holder.html('');
                    _this.holder.append(image);
                };

                reader.readAsDataURL(file);
            }  else {
                _this.holder.innerHTML += '<p>Uploaded ' + file.name + ' ' + (file.size ? (file.size/1024|0) + 'K' : '');
                //console.log('f',file);
            }
        };

        microUploader.prototype.readfiles = function(files) {
            var _this = this;
            var formData = _this.tests.formdata ? new FormData() : null;
            for (var i = 0; i < files.length; i++) {
                if (_this.tests.formdata) formData.append('file', files[i]);
                _this.previewfile(files[i]);
            }

            // now post a new XHR request
            if (_this.tests.formdata) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', _this.url);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if(_this.readyFunction!=null){
                            //console.log(xhr);
                            _this.readyFunction(xhr);
                        }
                    }
                };
                xhr.onload = function() {
                    _this.progress.html(100);
                    _this.progress.val(100);
                };

                if (_this.tests.progress) {
                    xhr.upload.onprogress = function (event) {
                        if (event.lengthComputable) {
                            var complete = (event.loaded / event.total * 100 | 0);
                            _this.progress.val(complete);
                            _this.progress.html(complete);
                        }
                    }
                }

                xhr.send(formData);
            }
        };

        this.microUploader = microUploader;

        return microUploader;

    })();
    new microUploader($(this),(url!=undefined)?url:null,(fnc!=undefined)?fnc:null);
}
