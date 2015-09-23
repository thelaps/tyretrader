/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 03.06.13
 * Time: 16:57
 * To change this template use File | Settings | File Templates.
 */

$.fn.callForm=function(sobj,evt,isSaveAction,prevalidate){
    /*if($('#ajaxStatus').children('canvas').length==0){
        var loader = {
            width: 100,
            height: 20,

            stepsPerFrame: 1,
            trailLength:.5,
            pointDistance: .1,
            fps: 15,
            padding: 10,
            //step: 'fader',

            fillColor: '#05E2FF',

            setup: function() {
                this._.lineWidth = 20;
            },

            path: [
                ['line', 0, 20, 100, 20],
                ['line', 100, 20, 0, 20]
            ]
        };

        var ajaxLoader, container = $('#ajaxStatus');

        ajaxLoader = new Sonic(loader);
        container.append(ajaxLoader.canvas);
        ajaxLoader.play();
    }*/


    var saveStatus=false;
    var self=$(this);
    var form=$(sobj);
    var close=form.find('.close');
    var save=form.find('.save');
    var isPrevalidate = (prevalidate!=undefined)?prevalidate:false;
    $(this).live({
        mouseenter:function(e){
            var isDblClick = ($(this).attr('isDblClick')!=undefined)?$(this).attr('isDblClick'):false;
            if(isDblClick){
                $(this).bind({
                    dblclick:function(){
                        form.trigger('onOpen',[$(this)]);
                        //$(this).attr('disabled','true');
                        form.showInCenter();
                        return false;
                    },click:function(){
                        $(this).toggleClass('selectedItem');
                    }
                });
            }else{
                $(this).bind({
                    click:function(){
                        //$(this).attr('disabled','true');
                        form.trigger('onOpen',[$(this)]);
                        if(isPrevalidate){
                            form.bind({
                                onAccept:function(){
                                    form.showInCenter();
                                }
                            });
                        }else{
                            form.showInCenter();
                        }
                        return false;
                    }
                });
            }
        },mouseleave:function(e){
            $(this).unbind();
        }
    });
    close.live({
        click:function(){
            if(saveStatus){
                //self.removeAttr('disabled');
                form.find('input[type="text"]').val('');
                form.fadeOut(200);
            }else{
                if(confirm('Закрыть без сохранения?')){
                    //self.removeAttr('disabled');
                    form.find('input[type="text"]').val('');
                    form.fadeOut(200);
                }
            }
            return false;
        }
    });
    save.live({
        click:function(){
            if(isSaveAction){
                $(document).jPopup({isActive:true});
                $.post(App.baseLink()+form.attr('action'), form.serialize(),
                function(data,status){
                    var json = App.ajax(data);
                    if(status=='success'){
                        //self.removeAttr('disabled');
                        if(json.error != undefined) {
                            if(json.error != null) {
                                alert('Запись '+json.error);
                                return false;
                            }
                        }
                        form.find('input[type="text"]').val('');
                        form.fadeOut(200);
                        form.trigger('onSave',[json]);
                        if(evt!=null){
                            $(document).trigger(evt);
                        }
                    }else{
                        alert('Серверная ошибка!');
                    }
                    $(document).jPopup({isActive:false});
                },"html");
            }else{
                form.find('input[type="text"]').val('');
                form.fadeOut(200);
            }
            return false;
        }
    });
    $(document).ajaxStart(function(){
        $('#ajaxStatus span').text('Открытие соединения>');
    });
    $(document).ajaxError(function(event,xhr,settings){
        $('#ajaxStatus span').text('Ошибка!');
    });
    $(document).ajaxSend(function(event,xhr,settings){
        $('#ajaxStatus span').text('Отправка');
    });
    $(document).ajaxSuccess(function(event,xhr,settings){
        $('#ajaxStatus span').text('Успешно');
    });
    $(document).ajaxComplete(function(event,xhr,settings){
        $('#ajaxStatus span').text('Завершение...');
    });
    $(document).ajaxStop(function(event,xhr,settings) {
        $('#ajaxStatus span').text('Готово');
    });
}

$.fn.callBindForm=function(sobj,evt,isSaveAction){
    var saveStatus=false;
    var self=$(this);
    var form=$(sobj);
    var close=form.find('.close');
    var save=form.find('.save');
    $(this).bind({
        click:function(){
            form.trigger('onOpen',[$(this)]);
            //$(this).attr('disabled','true');
            form.showInCenter();
            return false;
        }
    });
    close.bind({
        click:function(){
            if(saveStatus){
                //self.removeAttr('disabled');
                form.find('input[type="text"]').val('');
                form.fadeOut(200);
            }else{
                if(confirm('Закрыть без сохранения?')){
                    //self.removeAttr('disabled');
                    form.find('input[type="text"]').val('');
                    form.fadeOut(200);
                }
            }
            return false;
        }
    });
    save.bind({
        click:function(){
            if(isSaveAction){
                $(document).jPopup({isActive:true});
                $.post(App.baseLink()+form.attr('action'), form.serialize(),
                function(data,status){
                    if(status=='success'){
                        //self.removeAttr('disabled');
                        form.find('input[type="text"]').val('');
                        form.fadeOut(200);
                        form.trigger('onSave');
                        if(evt!=null){
                            $(document).trigger(evt);
                        }
                    }else{
                        alert('Серверная ошибка!');
                    }
                    $(document).jPopup({isActive:false});
                },"html");
            }else{
                form.trigger('onSave');
                form.find('input[type="text"]').val('');
                form.fadeOut(200);
            }
            return false;
        }
    });
}

$.fn.jPopup=function(option){
    var def_setting={
        text:"Обработка...",
        confirm:false,
        alert:false,
        isActive:false
    };
    var setting=null;
    if(option!=undefined){
        setting=$.extend(def_setting,option);
    }else{
        setting=def_setting;
    }
    var owner=$(this);
    var layer='<div class="shadow">' +
        '<div class="informer">' +
        '<div class="loading canvasLoader"></div> ' +
        '<span class="text">'+setting.text+'</span>' +
        '</div>' +
        '</div>';
    if(setting.isActive){
        owner.append(layer);
        var loaders = [{
            width: 100,
            height: 100,
            stepsPerFrame: 1,
            trailLength: 1,
            pointDistance: .025,
            strokeColor: '#444444',
            fps: 24,
            setup: function() {
                this._.lineWidth = 2;
            },
            step: function(point, index) {
                var cx = this.padding + 50,
                    cy = this.padding + 50,
                    _ = this._,
                    angle = (Math.PI/180) * (point.progress * 360);
                this._.globalAlpha = Math.max(.5, this.alpha);
                _.beginPath();
                _.moveTo(point.x, point.y);
                _.lineTo(
                    (Math.cos(angle) * 35) + cx,
                    (Math.sin(angle) * 35) + cy
                );
                _.closePath();
                _.stroke();
                _.beginPath();
                _.moveTo(
                    (Math.cos(-angle) * 32) + cx,
                    (Math.sin(-angle) * 32) + cy
                );
                _.lineTo(
                    (Math.cos(-angle) * 27) + cx,
                    (Math.sin(-angle) * 27) + cy
                );
                _.closePath();
                _.stroke();
            },
            path: [
                ['arc', 50, 50, 40, 0, 360]
            ]
        }];
        var d, a, container = document.getElementById('in');
        //for (var i = -1, l = loaders.length; ++i < l;) {
            a = new Sonic(loaders[0]);
        $('.canvasLoader').append(a.canvas);
            //a.canvas.style.marginTop = '14px';
            a.canvas.style.marginLeft = '14px';
            a.play();
        //}
        owner.children('.shadow').children('.informer').showInCenter();
        owner.children('.shadow').fadeIn(500);
    }else{
        owner.children('.shadow').fadeOut(500);
        setTimeout(function(){
            owner.children('.shadow').remove();
        },500);
    }
}

$.extend({
    jPopupChange:function(str){
        $('.informer .text').text(str);
    }
});

$.fn.showInCenter=function(){
    var obj=$(this);
    var wCenter=parseInt(parseInt($(window).width())/2);
    var hCenter=(parseInt(window.scrollY));
    var hhCenter=parseInt(parseInt($(window).height())/2);
    var owCenter=parseInt(parseInt(obj.width())/2);
    var ohCenter=parseInt(parseInt(obj.height())/2);
    var left=(Math.round(wCenter-owCenter)-12);
    var top=Math.round(hhCenter-ohCenter);
    obj.css({'position':'fixed','top':top+'px','left':left+'px'});
    obj.fadeIn(200);
}

$.fn.buildSelect=function(data,selected,alt,fnc){
    var select=$(this);
    var counter=0;
    select.html('');
    var key=(alt!=undefined)?alt.key:'key';
    var val=(alt!=undefined)?alt.val:'value';
    for(var item in data){
        var preselect=(data[item][key]==selected)?' selected':'';
        if(counter==0){
            var disselect=(selected==0)?' selected':'';
            select.append('<option value=""'+disselect+' disabled> - </option>');
        }
        select.append('<option value="'+data[item][key]+'"'+preselect+'>'+data[item][val]+'</option>');
        counter++;
    }
    if(fnc!=undefined){
        fnc();
    }
}

$.extend({
    updateRequired:function(type,val){
        var editor=$('.debug_editor');
        var hashCode=editor.find('[name="unaccepted[hash]"]').val();
        var unaccepted=$.parser.notaccepted[hashCode].obj.required;
        var accepted=$.parser.accepted[hashCode].required;

        var required=unaccepted;
        var parameter=type;
        if(required[type]==undefined){
            var wrapper={
                parameter_id:parameter,
                value:val
            }
            required.push(wrapper);
        }
        if(parameter==4){
            $.parser.notaccepted[hashCode].type = 'model';
        }
        $.parser.notaccepted[hashCode].required=required;
        $.parser.accepted[hashCode].required=required;
    }
});

$.extend({
    cData:{
        aData:null,
        add:function(data){
            this.aData = data;
        },
        read:function(){
            return this.aData;
        },
        drop:function(){
            this.aData = null;
        }
    }
});

$(document).ready(function(){
    var postProtect=false;
    $('.add_manufacturerPart').bind({
        click:function(){
            if(!postProtect){
                $('body').jPopup({isActive:true});
                postProtect=true;
                var form=$(this).closest('form');
                var modelForm = $('.add_modelPart').closest('form');
                $.post(App.baseLink()+form.attr('action'), form.serialize(),
                function(json){
                    json = App.ajax(json);
                        //self.removeAttr('disabled');
                    form.find('select[name="synonym[manufacturer_id]"]').buildSelect(json.data['list'],0,{key:'id',val:'name'});
                    modelForm.find('select[name="model[manufacturer_id]"]').buildSelect(json.data['list'],0,{key:'id',val:'name'});
                    console.log(json.data);
                    $.syncExtras(function(){
                        postProtect=false;

                        var added = new Array;
                        var s = form.find('[name="synonym[synonym]"]').val();
                        var m = form.find('[name="manufacturer[name]"]').val();
                        if(s.length>0){
                            added.push(s);
                        }
                        if(m.length>0){
                            added.push(m);
                        }
                        $.cData.add({
                            added:added,
                            obj:json.data.manufacturer
                        });
                        $.updateRequired(4,json.data.manufacturer.name);
                        $('body').jPopup({isActive:false});
                    });

                },"html");
            }
            return false;
        }
    });
    $('.add_modelPart').bind({
        click:function(){
            if(!postProtect){
                $('body').jPopup({isActive:true});
                postProtect=true;
                var form=$(this).closest('form');
                $.post(App.baseLink()+form.attr('action'), form.serialize(),
                function(json){
                    json = App.ajax(json);
                        //self.removeAttr('disabled');
                    form.find('select[name="model[id]"]').buildSelect(json.data['list'],0,{key:'id',val:'name'});
                    console.log(json.data);
                    $.syncExtras(function(){
                        postProtect=false;

                        $.updateRequired(1,json.data.model);
                        $('body').jPopup({isActive:false});
                    });

                },"html");
            }
            return false;
        }
    });
    $('.company_add, .company_table table tr').callForm('.add_edit_company',null,true);
    $('.company_editor').callForm('.company_table',null,false);
    $('.company_table').bind({
        onOpen:function(){
            var self=$(this);
            $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=company_list', function(json){
                json = App.ajax(json);
                var list=json.data;

                var html='';
                for(var i in list){
                    html += '<tr isDblClick="true" data-id="'+list[i].id+'" data-iso="'+list[i].iso+'" data-rate="'+list[i].rate+'" data-name="'+list[i].name+'" data-city="'+list[i].cityId+'">' +
                        '<td>'+list[i].id+'</td>' +
                        '<td>'+list[i].name+'</td>' +
                        '<td>'+list[i].city+'</td>' +
                        '</tr>';
                }

                self.find('table').html(html);
            });
        }
    });
    $('.company_delete').bind({
        click:function(){
            var tar=$(this).closest('.widget_editor');
            var deleteCatalog = new Array;
            tar.find('tr.selectedItem').each(function(key){
                deleteCatalog.push($(this).attr('data-id'));
            });
            if(deleteCatalog.length>0){
                if(confirm('Удалить выбраное?')){
                    $('body').jPopup({isActive:true});
                    var joined = deleteCatalog.join();
                    $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=delete&case=company', {ids:joined}, function(json){
                        $('.company_table').trigger('onOpen');
                        $('body').jPopup({isActive:false});
                    });
                }
            }else{
                alert('Для удаления выделите\r\nсоответствующую строку!');
            }
        }
    });
    $('.add_edit_company').bind({
        onOpen:function(e,tar){
            var companyId = (tar.attr('data-id')!=undefined)?tar.attr('data-id'):null;
            var self=$(this);
            if(companyId!=null){
                $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=editCompany&case=showCompany&id='+companyId, function(json){
                    json = App.ajax(json);
                    self.find('[name="company[name]"]').val(json.data.company.name);
                    self.find('[name="company[city_id]"]').val(json.data.company.cityid);
                    self.find('[name="company[iso]"]').val((json.data.company.iso!='null')?json.data.company.iso:'');
                    self.find('[name="company[rate]"]').val((json.data.company.rate!='null')?json.data.company.rate:'');
                    self.find('[name="user[firstName]"]').val((json.data.company.firstname!='null')?json.data.company.firstname:'');
                    self.find('[name="user[lastName]"]').val((json.data.company.lastname!='null')?json.data.company.lastname:'');
                    self.find('[name="user[phone]"]').val((json.data.company.phone!='null')?json.data.company.phone:'');
                    self.find('[name="user[balance]"]').val((json.data.company.balance!='null')?json.data.company.balance:'');
                    self.find('[name="user[email]"]').val((json.data.company.email!='null')?json.data.company.email:'');
                });
                self.find('.hideIfEdit').hide();
                self.find('.companyLegend').text('Редактировать поставщика');
                self.find('[name="company[id]"]').val(companyId);

            }else{
                self.find('.hideIfEdit').show();
                self.find('.companyLegend').text('Добавить поставщика');
                self.find('[name="company[id]"]').val('');

                self.find('[name="company[name]"]').val('');
                self.find('[name="company[city_id]"]').val('');
                self.find('[name="company[iso]"]').val('');
                self.find('[name="company[rate]"]').val('');
                self.find('[name="user[firstName]"]').val('');
                self.find('[name="user[lastName]"]').val('');
                self.find('[name="user[phone]"]').val('');
                self.find('[name="user[balance]"]').val('');
                self.find('[name="user[email]"]').val('');
            }
        },
        onSave:function(e,json){
            if(json.data.add!=undefined){
                var company = json.data.company;
                $('[name="company_id"]').append('<option value="'+company.id+'">'+company.name+'</option>');
            }
            $('.company_table').trigger('onOpen');
        }
    });


    $('.syncProcessor').bind({
        click: function(){
            $('body').jPopup({isActive:true, text: 'Синхронизирую каталоги...'});
            $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=sync', function(json){
                json = App.ajax(json);
                if (json.status) {
                    $.jPopupChange('Синхронизировано!');
                } else {
                    $.jPopupChange('Синхронизация не удалась!');
                }
                setTimeout(function(){
                    $('body').jPopup({isActive:false});
                },2000);
            });
        }
    });





    $('.currencyRate_add, .currencyRate_table table tr').callForm('.add_edit_currencyRate',null,true);
    $('.currencyRate_editor').callForm('.currencyRate_table',null,false);
    $('.currencyRate_table').bind({
        onOpen:function(){
            var self=$(this);
            $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=currencyRate_list', function(json){
                json = App.ajax(json);
                var list=json.data;

                var html='';
                for(var i in list.rate){
                    html += '<tr isDblClick="true" data-id="'+i+'" data-rate="'+list.rate[i]+'">' +
                        '<td>'+i+'</td>' +
                        '<td>'+list.rate[i]+'</td>' +
                        '</tr>';
                }

                self.find('table').html(html);
            });
        }
    });
    $('.currencyRate_delete').bind({
        click:function(){
            var tar=$(this).closest('.widget_editor');
            var deleteCatalog = new Array;
            tar.find('tr.selectedItem').each(function(key){
                deleteCatalog.push($(this).attr('data-id'));
            })
            if(deleteCatalog.length==1){
                if(confirm('Удалить выбраное?')){
                    $('body').jPopup({isActive:true});
                    var joined = deleteCatalog[0];
                    $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=delete&case=currencyRate', {ids:joined}, function(json){
                        $('.currencyRate_table').trigger('onOpen');
                        $('body').jPopup({isActive:false});
                    });
                }
            }else if(deleteCatalog.length>1){
                alert('Для удаления выделите\r\nтолько одну строку!');
            }else if(deleteCatalog.length==0){
                alert('Для удаления выделите\r\nсоответствующую строку!');
            }
        }
    });
    $('.add_edit_currencyRate').bind({
        onOpen:function(e,tar){
            var iso = (tar.attr('data-id')!=undefined)?tar.attr('data-id'):null;
            var rate = (tar.attr('data-rate')!=undefined)?tar.attr('data-rate'):null;
            $('.body').jPopup({isActive:true});
            var self=$(this);
            if(iso!=null){
                self.find('.currencyRateLegend').text('Редактировать курс валют');
                self.find('[name="currencyRate[iso]"]').val(iso);
                self.find('[name="currencyRate[rate]"]').val(rate);
            }else{
                self.find('.currencyRateLegend').text('Добавить курс валют');
                self.find('[name="currencyRate[iso]"]').val('');
                self.find('[name="currencyRate[rate]"]').val('');
            }
            $('.body').jPopup({isActive:false});
        },
        onSave:function(e,json){
            $('.currencyRate_table').trigger('onOpen');
        }
    });







    $('.locations_add, .locations_table table tr:not(.excludedLocation)').callForm('.add_edit_locations',null,true);
    $('.locations_editor').callForm('.locations_table',null,false);
    $('.excludedLocation').live({
        click:function(){
            var key=$(this).attr('data-key');
            var all=$('.locationToggle:not([data-toggle="'+key+'"])');
            var self=$('[data-toggle="'+key+'"]');
            all.hide();
            self.toggle();

        }
    });
    $('.locations_delete').bind({
        click:function(){
            var tar=$(this).closest('.widget_editor');
            var deleteCatalog = new Array;
            tar.find('tr.selectedItem').each(function(key){
                deleteCatalog.push($(this).attr('data-id'));
            })
            if(deleteCatalog.length>0){
                if(confirm('Удалить выбраное?')){
                    $('body').jPopup({isActive:true});
                    var joined = deleteCatalog.join();
                    $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=delete&case=locations', {ids:joined}, function(json){
                        $('.locations_table').trigger('onOpen');
                        $('body').jPopup({isActive:false});
                    });
                }
            }else{
                alert('Для удаления выделите\r\nсоответствующую строку!');
            }
        }
    });
    $('.locations_table').bind({
        onOpen:function(){
            var self=$(this);
            $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=locations_list', function(json){
                json = App.ajax(json);
                var list=json.data;

                var html='';
                for(var key in list){
                    html += '<tr class="excludedLocation" data-key="'+key+'">' +
                        '<td colspan="3"> > <b>'+key+'</b></td>' +
                        '</tr>';
                    for(var i in list[key]){
                        html += '<tr isDblClick="true" class="locationToggle" style="display: none;" data-region="'+list[key][i].region_id+'" data-id="'+list[key][i].id+'" data-name="'+list[key][i].name+'" data-toggle="'+key+'">' +
                            '<td>'+list[key][i].name+'</td>' +
                            '<td>'+list[key][i].phone_code+'</td>' +
                            '</tr>';
                    }
                }

                self.find('table').html(html);
            });
        }
    });
    $('.add_edit_locations').bind({
        onOpen:function(e,tar){
            var locationId = (tar.attr('data-id')!=undefined)?tar.attr('data-id'):null;
            $('.body').jPopup({isActive:true});
            var self=$(this);
            if(locationId!=null){
                self.find('.locationsLegend').text('Редактировать локацию');
                self.find('[name="locations[id]"]').val(locationId);
                self.find('[name="locations[region_id]"]').val(tar.attr('data-region'));

                self.find('[name="locations[name]"]').val(tar.attr('data-name'));
            }else{
                self.find('.companyLegend').text('Добавить локацию');
                self.find('[name="locations[id]"]').val('');

                self.find('[name="locations[region_id]"]').val('');
                self.find('[name="locations[name]"]').val('');
            }
            $('.body').jPopup({isActive:false});
        },
        onSave:function(e,json){
            $('.locations_table').trigger('onOpen');
        }
    });



    $('.synonym_list').callForm('.synonym_table',null,false);
    $('.synonym_table').bind({
        onOpen:function(){
            var self=$(this);
            var table=self.find('table');
            var selector=self.find('[name="synonym[parameter]"]');
            $('body').jPopup({isActive:true});
            $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=synonym_list', function(json){
                json = App.ajax(json);
                var list=json.data.list;
                selector.buildSelect(list,0);
                selector.bind({
                    change:function(){
                        var val=json.data.values;
                        var selected=parseInt($(this).val());

                        var selectorMod=self.find('[name="synonym[manufacturer_id]"]');
                        var owner=selectorMod.parent();

                        /*if(selected==41 || selected==42){
                            self.find('.parameter_add').hide();
                        }else{
                            self.find('.parameter_add').show();
                        }*/

                        if(selected==41){
                            selectorMod.removeAttr('disabled');
                            selectorMod.buildSelect(json.data.list[42].origin,0,{key:'dict_id',val:'dict_value'},function(){
                                owner.show();
                                var selectedMod=null;
                                selectorMod.bind({
                                    change:function(){
                                        selectedMod=$(this).val();
                                        table.html('');
                                        var template='' +
                                            '<tr>' +
                                            '<td>Оригинал</td>' +
                                            '<td>Синоним</td>' +
                                            '<td>Тип</td>' +
                                            '</tr>';
                                        table.append(template);
                                        for(var item in val[selected][selectedMod]){
                                            template='' +
                                                '<tr isDblClick="true" class="synonym_edit" isDblClick="true" data-id="'+val[selected][selectedMod][item].id+'" data-action="edit" data-did="'+val[selected][selectedMod][item].dict_id+'" data-type="'+selected+'" data-key="'+item+'">' +
                                                '<td>'+val[selected][selectedMod][item].dict_value+'</td>' +
                                                '<td>'+val[selected][selectedMod][item].synonym+'</td>' +
                                                '<td>'+val[selected][selectedMod][item].parameter_name+'</td>' +
                                                '</tr>';
                                            table.append(template);
                                        }
                                    }
                                });
                            });
                        }else{
                            selectorMod.html('');
                            selectorMod.attr('disabled',true);
                            owner.hide();

                            table.html('');
                            var template='' +
                                '<tr>' +
                                '<td>Оригинал</td>' +
                                '<td>Синоним</td>' +
                                '<td>Тип</td>' +
                                '</tr>';
                            table.append(template);
                            for(var item in val[selected]){
                                template='' +
                                    '<tr isDblClick="true" class="synonym_edit" isDblClick="true" data-id="'+val[selected][item].id+'" data-action="edit" data-did="'+val[selected][item].dict_id+'" data-type="'+selected+'" data-key="'+item+'">' +
                                    '<td>'+val[selected][item].dict_value+'</td>' +
                                    '<td>'+val[selected][item].synonym+'</td>' +
                                    '<td>'+val[selected][item].parameter_name+'</td>' +
                                    '</tr>';
                                table.append(template);
                            }
                        }
                    }
                });
                $('body').jPopup({isActive:false});
                $('.synonym_table').trigger('onOpenComplete');
            });
        }
    });

    $('.synonym_delete').bind({
        click:function(){
            //data-type="42" data-did="13" data-action="edit" data-id="23"
            var tar=$(this).closest('.widget_editor');
            var deleteCatalog = new Array;
            tar.find('tr.selectedItem').each(function(key){
                var dataCatalog={
                    id:$(this).attr('data-id'),
                    type:$(this).attr('data-type'),
                    did:$(this).attr('data-did')
                };
                deleteCatalog.push(dataCatalog);
            })
            if(deleteCatalog.length>0){
                if(confirm('Удалить выбраное?')){
                    $('body').jPopup({isActive:true});
                    var joined = JSON.stringify(deleteCatalog);
                    $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=delete&case=synonym', {ids:joined}, function(json){
                        var synonymParameter = $('.synonym_table').find('[name="synonym[parameter]"]').val();
                        var synonymManufacturer = $('.synonym_table').find('[name="synonym[manufacturer_id]"]').val();
                        $('.synonym_table').trigger('onOpen');
                        $('.synonym_table').bind({
                            onOpenComplete:function(){
                                console.log('onOpenComplete',synonymParameter,synonymManufacturer);
                                $('.synonym_table').find('[name="synonym[parameter]"]').val(synonymParameter).trigger('change');
                                if(synonymParameter==41){
                                    $('.synonym_table').find('[name="synonym[manufacturer_id]"]').val(synonymManufacturer).trigger('change');
                                    console.log('changed');
                                }
                            }
                        });
                        $('body').jPopup({isActive:false});
                    });
                }
            }else{
                alert('Для удаления выделите\r\nсоответствующую строку!');
            }
        }
    });
    $('.synonym_edit,.synonym_add').callForm('.add_edit_syn','synChange',true,true);
    $('.add_edit_syn').bind({
        onOpen:function(e,tar){
            $('.synonym_table').jPopup({isActive:true});
            var self=$(this);
            var did=tar.attr('data-did');
            var id=tar.attr('data-id');
            var selectSource=$('.synonym_table').find('[name="synonym[parameter]"]');
            var type=selectSource.val();
            var key=tar.attr('data-key');
            var action=tar.attr('data-action');
            var legend=(action=='edit')?'Изменить':'Добавить';
            self.find('legend').text(legend+' синоним v0.1');
            self.find('[name="fnc"]').val(action);
            self.find('[name="type"]').val(type);
            if(type==41){
                var selectedMod=tar.closest('.widget_editor').find('[name="synonym[manufacturer_id]"]').val();
                if(id!=undefined){
                    self.find('[name="synonym[id]"]').val(id);
                    var select=self.find('select[name="synonym[dict]"]');
                    $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=synonym_list', function(json){
                        json = App.ajax(json);
                        var list=json.data.list[type].origin[selectedMod];
                        var values=json.data.values[type][selectedMod][key];
                        self.find('[name="synonym[synonym]"]').val(values.synonym);
                        select.buildSelect(list,did,{key:'dict_id',val:'dict_value'});
                        $('.add_edit_syn').trigger('onAccept');
                    });
                }else{
                    var select=self.find('select[name="synonym[dict]"]');
                    self.find('[name="synonym[id]"]').val('');
                    if(type.length>0){
                        $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=synonym_list', function(json){
                            json = App.ajax(json);
                            var list=json.data.list[type].origin[selectedMod];
                            select.buildSelect(list,0,{key:'dict_id',val:'dict_value'});
                            $('.add_edit_syn').trigger('onAccept');
                        });
                    }else{
                        $('.synonym_table').jPopup({isActive:false});
                        alert('Не выбран тип!');
                        return false;
                    }
                }
            }else{
                if(id!=undefined){
                    self.find('[name="synonym[id]"]').val(id);
                    var select=self.find('select[name="synonym[dict]"]');
                    $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=synonym_list', function(json){
                        json = App.ajax(json);
                        var list=json.data.list[type].origin;
                        var values=json.data.values[type][key];
                        self.find('[name="synonym[synonym]"]').val(values.synonym);
                        select.buildSelect(list,did,{key:'dict_id',val:'dict_value'});
                        $('.add_edit_syn').trigger('onAccept');
                    });
                }else{
                    var select=self.find('select[name="synonym[dict]"]');
                    self.find('[name="synonym[id]"]').val('');
                    if(type.length>0){
                        $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=synonym_list', function(json){
                            json = App.ajax(json);
                            var list=json.data.list[type].origin;
                            select.buildSelect(list,0,{key:'dict_id',val:'dict_value'});
                            $('.add_edit_syn').trigger('onAccept');
                        });
                    }else{
                        $('.synonym_table').jPopup({isActive:false});
                        alert('Не выбран тип!');
                        return false;
                    }
                }
            }
            $('.synonym_table').jPopup({isActive:false});
        },
        onSave:function(){
            var synonymParameter = $('.synonym_table').find('[name="synonym[parameter]"]').val();
            var synonymManufacturer = $('.synonym_table').find('[name="synonym[manufacturer_id]"]').val();
            $('.synonym_table').trigger('onOpen');
            $('.synonym_table').bind({
                onOpenComplete:function(){
                    $('.synonym_table').find('[name="synonym[parameter]"]').val(synonymParameter).trigger('change');
                    if(synonymParameter==41){
                        $('.synonym_table').find('[name="synonym[manufacturer_id]"]').val(synonymManufacturer).trigger('change');
                    }
                }
            });
        }
    });






    $('.values_list').callForm('.values_table',null,false);
    $('.values_table').bind({
        onOpen:function(){
            var self=$(this);
            var table=self.find('table');
            var selector=self.find('[name="values[parameter]"]');
            $('body').jPopup({isActive:true});
            $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=values_list', function(json){
                json = App.ajax(json);
                var list=json.data.list;
                console.log(json);
                App.storage('valuesList',list);
                selector.buildSelect(list,0);
                selector.bind({
                    change:function(){
                        var val=json.data.values;
                        var selected=parseInt($(this).val());

                        var selectorMod=self.find('[name="values[manufacturer_id]"]');
                        var owner=selectorMod.parent();
                        table.find('.manufacturerFilter').unbind();

                        if(selected==41){
                            selectorMod.removeAttr('disabled');
                            selectorMod.buildSelect(json.data.list[42].origin,0,{key:'dict_id',val:'dict_value'});
                            owner.show();
                            var selectedMod=null;
                            selectorMod.bind({
                                change:function(){
                                    console.log(json);
                                    selectedMod=$(this).val();
                                    table.html('');
                                    var template='' +
                                        '<tr>' +
                                        '<td>Оригинал</td>' +
                                        '<td>Тип</td>' +
                                        '</tr>';
                                    table.append(template);
                                    for(var item in list[selected].origin[selectedMod]){
                                        template='' +
                                            '<tr isDblClick="true" class="values_edit" data-action="edit" data-id="'+list[selected].origin[selectedMod][item].dict_id+'" data-type="'+selected+'" data-key="'+item+'">' +
                                            '<td>'+list[selected].origin[selectedMod][item].dict_value+'</td>' +
                                            '<td>'+list[selected].origin[selectedMod][item].parameter_name+'</td>' +
                                            '</tr>';
                                        table.append(template);
                                    }
                                }
                            });
                        }else if(selected==42){
                            selectorMod.html('');
                            selectorMod.attr('disabled',true);
                            owner.hide();

                            table.html('');
                            var template='' +
                                '<tr>' +
                                '<td>Оригинал</td>' +
                                '<td>Тип продукции' +
                                '<select class="manufacturerFilter">' +
                                '<option value=""> - </option>' +
                                '<option value="1">Шина</option>' +
                                '<option value="2">Диск</option>' +
                                '</select>' +
                                '</td>' +
                                '<td>Тип</td>' +
                                '</tr>';
                            table.append(template);
                            for(var item in list[selected].origin){
                                var typeProduct = (list[selected].origin[item].type==1)?'Шина':((list[selected].origin[item].type==2)?'Диск':'Неизвестно');
                                template='' +
                                    '<tr isDblClick="true" class="values_edit" data-action="edit" data-originType="'+list[selected].origin[item].type+'" data-id="'+list[selected].origin[item].dict_id+'" data-type="'+selected+'" data-key="'+item+'">' +
                                    '<td>'+list[selected].origin[item].dict_value+'</td>' +
                                    '<td>'+typeProduct+'</td>' +
                                    '<td>'+list[selected].origin[item].parameter_name+'</td>' +
                                    '</tr>';
                                table.append(template);
                            }
                            table.find('.manufacturerFilter').bind({
                                change:function(){
                                    table.jPopup({isActive:true});
                                    var filterValue = ($(this).val()!='')?$(this).val():null;
                                    setTimeout(function(){
                                    if(filterValue!=null){
                                        var selector = 'tr[data-originType="'+filterValue+'"]';
                                        table.find('tr:not(:first-child)').hide(function(){
                                            table.find(selector).show();
                                            table.jPopup({isActive:false});
                                        });
                                    }else{
                                        table.find('tr').show();
                                        table.jPopup({isActive:false});
                                    }
                                    },500);
                                }
                            });
                        }else{
                            selectorMod.html('');
                            selectorMod.attr('disabled',true);
                            owner.hide();

                            table.html('');
                            var template='' +
                                '<tr>' +
                                '<td>Оригинал</td>' +
                                '<td>Тип</td>' +
                                '</tr>';
                            table.append(template);
                            for(var item in list[selected].origin){
                                template='' +
                                    '<tr isDblClick="true" class="values_edit" data-action="edit" data-id="'+list[selected].origin[item].dict_id+'" data-type="'+selected+'" data-key="'+item+'">' +
                                    '<td>'+list[selected].origin[item].dict_value+'</td>' +
                                    '<td>'+list[selected].origin[item].parameter_name+'</td>' +
                                    '</tr>';
                                table.append(template);
                            }
                        }
                    }
                });
                $('.values_table').trigger('onOpenComplete');
                $('body').jPopup({isActive:false});
            });
        }
    });
    $('.parameter_delete').bind({
        click:function(){
            var tar=$(this).closest('.widget_editor');
            var deleteCatalog = new Array;
            tar.find('tr.selectedItem').each(function(key){
                var dataCatalog={
                    id:$(this).attr('data-id'),
                    type:$(this).attr('data-type')
                };
                deleteCatalog.push(dataCatalog);
            })
            if(deleteCatalog.length>0){
                if(confirm('Удалить выбраное?')){
                    $('body').jPopup({isActive:true});
                    var joined = JSON.stringify(deleteCatalog);
                    $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=delete&case=parameter', {ids:joined}, function(json){
                        var valuesParameter = $('.values_table').find('[name="values[parameter]"]').val();
                        var valuesManufacturer = $('.values_table').find('[name="values[manufacturer_id]"]').val();
                        $('.values_table').trigger('onOpen');
                        $('.values_table').bind({
                            onOpenComplete:function(){
                                $('.values_table').find('[name="values[parameter]"]').val(valuesParameter).trigger('change');
                                if(valuesParameter==41){
                                    $('.values_table').find('[name="values[manufacturer_id]"]').val(valuesManufacturer).trigger('change');
                                }
                            }
                        });
                        $('body').jPopup({isActive:false});
                    });
                }
            }else{
                alert('Для удаления выделите\r\nсоответствующую строку!');
            }
        }
    });
    $('.parameter_add, .values_edit').callForm('.add_edit_param','paramAdd',true,true);
    $('.add_edit_param').bind({
        onOpen:function(e,tar){
            $('.values_table').jPopup({isActive:true});
            var self=$(this);
            var editor=tar.closest('.widget_editor');
            var id=(tar.attr('data-id')!=undefined)?tar.attr('data-id'):null;
            var type=editor.find('[name="values[parameter]"]').val();
            var additionalID=self.find('[name="dict[manufacturer_id]"]');
            type=(type!='')?parseInt(type):null;
            if(type!=null){
                var list=App.storage('valuesList');
                self.find('[name="type"]').val(type);
                if(type==41){
                    self.find('#manufacturerParameters').hide();
                    self.find('#modelParameters').show();
                    var additionalIDValue=editor.find('[name="values[manufacturer_id]"]').val();
                    additionalIDValue=(additionalIDValue!='')?parseInt(additionalIDValue):null;
                    if(additionalIDValue!=null){
                        additionalID.removeAttr('disabled');
                        additionalID.val(additionalIDValue);
                        var modelLabelType = {
                            1: 'Шина',
                            2: 'Диск'
                        };
                        if(id!=null){
                            var modelData=list[type].alias[additionalIDValue][id];
                            self.find('[name="dict[name]"]').val(modelData.dict_value);
                            self.find('[name="model[type]"]').val((modelData.type)?modelData.type:'');
                            self.find('.modelLabelType').val((modelData.type)?modelLabelType[modelData.type]:'Нераспознано');
                            self.find('.checkChange').each(function(){
                                $(this).hide();
                                $(this).find('input, textarea, select').attr('disabled',true);
                            });
                            self.find('.checkChange[data-type="'+modelData.type+'"]').show(function(){
                                $(this).find('input, textarea, select').removeAttr('disabled');
                            });
                            if((modelData.season)){
                                self.find('[name="model[season]"]').val(modelData.season);
                            }else{
                                self.find('[name="model[season]"]').val('').find('option:eq(0)').attr('selected',true);
                            }
                            if((modelData.use)){
                                self.find('[name="model[use]"]').val(modelData.use);
                            }else{
                                self.find('[name="model[use]"]').val('').find('option:eq(0)').attr('selected',true);
                            }
                            if((modelData.type_transport)){
                                self.find('[name="model[type_transport]"]').val(modelData.type_transport);
                            }else{
                                self.find('[name="model[type_transport]"]').val('').find('option:eq(0)').attr('selected',true);
                            }
                            if((modelData.axle)){
                                self.find('[name="model[axle]"]').val(modelData.axle);
                            }else{
                                self.find('[name="model[axle]"]').val('').find('option:eq(0)').attr('selected',true);
                            }
                            if((modelData.src)){
                                self.find('[name="model[src]"]').val(modelData.src);
                                self.find('.microUploader').html('<img width="300" src="'+App.baseLink()+'images/'+modelData.src+'" />');
                            }else{
                                self.find('[name="model[src]"]').val('');
                                self.find('.microUploader').html('');
                            }
                            if((modelData.description)){
                                self.find('[name="model[description]"]').val(modelData.description);
                            }else{
                                self.find('[name="model[description]"]').val('');
                            }
                        }else{
                            var modelEmptyData=list[42].alias[additionalIDValue];
                            self.find('[name="model[type]"]').val((modelEmptyData.type)?modelEmptyData.type:'');
                            self.find('.modelLabelType').val((modelEmptyData.type)?modelLabelType[modelEmptyData.type]:'Нераспознано');
                            self.find('.checkChange').each(function(){
                                $(this).hide();
                                $(this).find('input, textarea, select').attr('disabled',true);
                            });
                            self.find('.checkChange[data-type="'+modelEmptyData.type+'"]').show(function(){
                                $(this).find('input, textarea, select').removeAttr('disabled');
                            });

                                self.find('[name="model[season]"]').val('').find('option:eq(0)').attr('selected',true);
                                self.find('[name="model[use]"]').val('').find('option:eq(0)').attr('selected',true);
                                self.find('[name="model[type_transport]"]').val('').find('option:eq(0)').attr('selected',true);
                                self.find('[name="model[axle]"]').val('').find('option:eq(0)').attr('selected',true);
                                self.find('[name="model[src]"]').val('');
                                self.find('.microUploader').html('');
                                self.find('[name="model[description]"]').val('');
                        }
                        setTimeout(function(){
                            $('.add_edit_param').trigger('onAccept');
                        },500);
                    }else{
                        $('.values_table').jPopup({isActive:false});
                        alert('Вы не выбрали производителя!');
                        return false;
                    }
                }else if(type==42){
                    self.find('#modelParameters').hide();
                    self.find('#manufacturerParameters').show();
                    additionalID.attr('disabled',true);
                    additionalID.val('');

                    if(id!=null){
                        var manufacturerData=list[type].alias[id];
                        self.find('[name="dict[name]"]').val(manufacturerData.dict_value);
                        self.find('[name="manufacturer[type]"]').val((manufacturerData.type)?manufacturerData.type:'');
                    }
                    self.find('[name="manufacturer[type]"]').bind({
                        change:function(){
                            if($(this).val()==2){
                                if(id!=null){
                                    var manufacturerData=list[type].alias[id];
                                    if(manufacturerData.wheel_type!=null && manufacturerData.wheel_type!=undefined){
                                        self.find('[name="manufacturer[wheel_type]"]').val((manufacturerData.wheel_type)?manufacturerData.wheel_type:'');
                                    }else{
                                        self.find('[name="manufacturer[wheel_type]"] option').eq(0).attr('selected', true);
                                    }
                                }
                                self.find('#manufacturerParameters_wheel_type').show();
                            }else{
                                self.find('#manufacturerParameters_wheel_type').hide();
                            }
                        }
                    });
                    self.find('[name="manufacturer[type]"]').trigger('change');

                    setTimeout(function(){
                        $('.add_edit_param').trigger('onAccept');
                    },500);
                }else{
                    self.find('#modelParameters, #manufacturerParameters').hide();
                    additionalID.attr('disabled',true);
                    additionalID.val('');

                    if(id!=null){
                        var dataType=(tar.attr('data-type')!=undefined)?tar.attr('data-type'):null;
                        var dataKey=(tar.attr('data-key')!=undefined)?tar.attr('data-key'):null;
                        var parameterValue=list[dataType].origin[dataKey];
                        self.find('[name="dict[name]"]').val(parameterValue.dict_value);
                    }
                    setTimeout(function(){
                        $('.add_edit_param').trigger('onAccept');
                    },500);
                }
                self.find('[name="dict[parameter_id]"]').val(id);
            }else{
                $('.values_table').jPopup({isActive:false});
                alert('Не выбран тип!');
                return false;
            }
            $('.values_table').jPopup({isActive:false});
        },
        onSave:function(e){
            var valuesParameter = $('.values_table').find('[name="values[parameter]"]').val();
            var valuesManufacturer = $('.values_table').find('[name="values[manufacturer_id]"]').val();
            $('.values_table').trigger('onOpen');
            $('.values_table').bind({
                onOpenComplete:function(){
                    $('.values_table').find('[name="values[parameter]"]').val(valuesParameter).trigger('change');
                    if(valuesParameter==41){
                        $('.values_table').find('[name="values[manufacturer_id]"]').val(valuesManufacturer).trigger('change');
                    }
                }
            });
        }
    });
    /*
    *         <legend>Изменить синоним</legend>
     <input type="hidden" name="fnc" value="">
     <input type="hidden" name="synonym[id]" value="">
     <input type="text" name="synonym[synonym]" placeholder="Синоним" />
     <select name="synonym[dict]">
     </select>*/

    /*$('.add_model').bind({
        click:function(){
            var form=$(this).closest('form');
            $.post(form.attr('action'), form.serialize(),
                function(data,status){
                    //self.removeAttr('disabled');
                    alert('Добавлено!');
                },"json");
            return false;
        }
    });*/
});

$.extend({
    syncExtras:function(fnc){
        $.get(App.baseLink()+'?view=admin_panel&load=price_panel&fnc=updates', function(json){
            json = App.ajax(json);
            var updates=json.data;
            if(updates){
                $.extraTab.parameters = updates.parameters;
                $.extraTab.manufacturers = updates.manufacturers;
                $.extraTab.semantic_manufacturers = updates.semantic.manufacturers;
                $.extraTab.semantic_models = updates.semantic.models;
                $.extraTab.extras = updates.extras;
            }
            if(fnc!=undefined){
                fnc();
            }
        });
    }
});


/*$.fn.editable=function(options){
    var _self = $(this);
    var defaults = {
        id: 'data-id',
        field: 'data-field',
        url: null,
        data: null
    };
    var _options = $.extend(defaults, options);
    _self.bind({
        click: function(){
            var _locked = $(this);
            if ( !_locked.hasClass('lockEditable') ) {
                _locked.addClass('lockEditable');
                var _text = _locked.text();
                var _id = _locked.attr(_options.id);
                var _field = _locked.attr(_options.field);
                _locked.html('<input class="textEditable" type="text" value="'+_text+'">');
                _locked.find('.textEditable').focus().bind({
                    focusout: function(e){
                        var _tmp = $(this);
                        _tmp.unbind();
                        if ( confirm('Сохранить изменения?') ) {
                            console.log('save', _tmp.val());
                            _locked.html(_tmp.val());
                        } else {
                            _locked.html(_text);
                        }
                        _locked.removeClass('lockEditable');
                    }
                });
                console.log(_text, _id, _field);
            }
        }
    });
};*/
$(document).ready(function(){
    $('.editable').editable(function(_value, settings) {
        var _self = $(this);
        var _id = _self.attr('data-id');
        var _field = _self.attr('data-field');
        $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=fieldEditor', {
            datafield: _field,
            dataid: _id,
            datavalue: _value
        }, function(data){
            console.log(data);
        });
        return(_value);
    });
});