/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 13.05.13
 * Time: 19:46
 * To change this template use File | Settings | File Templates.
 */
$.extend({
    parser:{
        internalError:null,
        callback:$(document),
        collection:{
            company:null,
            obj:null,
            items:null,
            settings:null,
            tyres:null,
            wheels:null,
            search_templates:null,
            manufacturer_patterns:null
        },
        waitFor:0,
        waitFrom:0,
        accepted:null,
        notaccepted:new Array,
        namingIsSet:false,
        process:function(){
            $('body').jPopup({isActive:true});
            //var form=$('form[name="priceProcessing"]');
            //var serialized=form.serialize();
            //var action=form.attr('action');
            var activated=$('.listIdent input[type="checkbox"]:checked');
            $.parser.collection.obj = new Array;
            $.parser.collection.items = new Array;
            activated.each(function(){
                var id=$(this).parent().attr('data-id');
                $.parser.collection.obj.push($('.listTab:eq('+id+')'));
                $.parser.collection.items.push(id);
            });
            if($.parser.setSettings()){

                $.parser.run();

                $.parser.callback.bind({
                    runEnd:function(){
                        if($.parser.notaccepted!=null){
                            $.parser.buildErrorList();
                        }
                        $('body').jPopup({isActive:false});
                    }
                });
            }else{
                var error = new Array;
                var msg = 'Исправьте следующие ошибки:\r\n';
                for(k=0; k<$.parser.internalError.length; k++){
                    error.push($.parser.internalError[k].tab+'\r\n');
                    if($.parser.internalError[k].price){
                        error.push(' - Не указан ст. цен\r\n');
                    }
                    if($.parser.internalError[k].quantity){
                        error.push(' - Не указан ст. остатка\r\n');
                    }
                    if($.parser.internalError[k].naming){
                        error.push(' - Не указан ст. наименования или высоты и диаметра\r\n');
                    }
                    error.push('------------------------------\r\n');
                }

                msg += error.join('');
                alert(msg);

                $('body').jPopup({isActive:false});
            }
        },setSettings:function(){
            $.parser.collection.settings = new Array;
            $.parser.internalError = new Array;
            var extraSettings=$('.extraSettings');
            var settingsTotal=$.parser.collection.items.length;
            var settingsItem=$.parser.collection.items;
            for(i=0; i<settingsTotal; i++){
                var settingItem=extraSettings.children('li[data-id="'+settingsItem[i]+'"]');
                var settingObj={
                    type:settingItem.find('[name="type[]"]').val(),
                    existing:settingItem.find('[name="existing[]"]').val(),
                    excluding:settingItem.find('[name="excluding[]"]').val(),
                    including:settingItem.find('[name="including[]"]').val(),
                    manufacturer:settingItem.find('[name="manufacturer[]"]').val(),
                    currency:settingItem.find('[name="currency[]"]').val(),
                    parameter:null,
                    inactive_cells:null
                };
                settingObj.parameter=new Array;
                settingObj.inactive_cells=new Array;
                settingItem.find('[name="parameter[][]"]').each(function(_eq){
                    if ( settingItem.find('input[name="parameter_key[]"]:eq('+_eq+')').is(':checked') ) {
                        settingObj.parameter.push($(this).val());
                    } else {
                        settingObj.inactive_cells.push(_eq);
                    }
                });

                if($.inArray('21', settingObj.parameter)!=-1 && $.inArray('25', settingObj.parameter)!=-1 && ($.inArray('2', settingObj.parameter)!=-1 || (settingObj.parameter.indexOf('13')!=-1 && settingObj.parameter.indexOf('17')!=-1))){
                    $.parser.collection.settings.push(settingObj);
                }else{
                    var errorIn = {
                        tab: '>> Вкладка №: '+i,
                        price: (settingObj.parameter.indexOf('21')==-1),
                        quantity: (settingObj.parameter.indexOf('25')==-1),
                        naming: (settingObj.parameter.indexOf('2')==-1) ? (settingObj.parameter.indexOf('13')==-1 && settingObj.parameter.indexOf('17')==-1) : false
                    };
                    $.parser.internalError.push(errorIn);
                }
                $.parser.namingIsSet = ($.inArray('2', settingObj.parameter)!=-1);
            }
            if($.parser.internalError.length>0){
                return false;
            }else{
                return true;
            }
        },run:function(){
            var oObj=$.parser.collection.obj;
            var exploded=new Array;
            $.parser.accepted = new Array;
            $.parser.notaccepted = new Array;
            for(var domKey in oObj){
                //exploded.push($.parser.explode(oObj[domKey],domKey));
                var keyList=$.parser.explode(oObj[domKey],domKey,exploded);
                exploded=keyList;
            }
            $.parser.callback.bind({
                explodeEnd:function(){
                    var exLength=exploded.length;
                    $.jPopupChange('В очереди на обработку: '+exLength+' строк');
                    setTimeout(function(){
                        var counter=0;
                        var interval=setInterval(function(){
                            $.jPopupChange('Обработано: '+counter+' из '+exploded.length+' строк');
                            var storage=exploded[counter];
                            var storageKey=(storage!=undefined)?storage.key:null;
                            var storageValue=(storageKey!=null)?localStorage.getItem(storageKey):null;
                            var template=(storage!=undefined)?storage.tab:null;
                            if(counter<exploded.length && template!=null){
                                $.parser.accepted[hex_md5(storageValue)]=$.parser.checkIn(storageValue,template);
                                counter++;
                                localStorage.removeItem(storageKey);
                            }else{
                                $.jPopupChange('Обработано');
                                $.parser.callback.trigger('runEnd');
                                clearInterval(interval);
                            }
                        },50);
                    },1000);
                }
            });
        },explode:function(obj,domKey,exploded){
            var rows=obj.find('tr:not(.exclude)"');
            $.parser.waitFrom=rows.length+$.parser.waitFrom;
            rows.each(function(xkey){
                var self = this;
                var timeout=setTimeout(function(){
                    $.parser.waitFor=($.parser.waitFor+1);
                    var _key='parser_items_'+domKey+'_'+xkey;
                    var cells=$(self).find('td');
                    var _implodedArray=new Array;
                    var imploded = '';
                    cells.each(function(key){
                        if ($.inArray(key, $.parser.collection.settings[domKey].inactive_cells) == -1) {
                            _implodedArray.push($(this).text());
                        }
                        //var delimiter=(key==0)?'':' | ';
                        //imploded+=delimiter+$(this).text();
                    });
                    imploded = _implodedArray.join(' | ');
                    localStorage.setItem(_key, imploded);
                    var tabbing={
                        key:_key,
                        tab:domKey,
                        row:xkey
                    }
                    exploded.push(tabbing);

                    $.jPopupChange('Добавляю  '+$.parser.waitFor+' строку в очередь из '+$.parser.waitFrom+' строк');
                    var isTrigg=($.parser.waitFrom==$.parser.waitFor)?true:false;
                    if(isTrigg){
                        $.parser.callback.trigger('explodeEnd');
                        clearTimeout(timeout);
                    }

                }, xkey*20);
            });
            return exploded;
        },
        checkIn:function(strSource,domKey){
            var specifiedSizes = null;
            var wheelSizes = null;
            var tyreSizes = null;
            var indexes = null;
            var settings=$.parser.collection.settings[domKey];
            var company=$.extraTab.company;
            var extraCell=strSource.split('|');

            var checkedParameters=settings.parameter;
            var attachParameters=$.parser.getValuesByParameter(extraCell,checkedParameters,strSource);


            if (!$.parser.namingIsSet) {
                var _doubleSize = $.findParameter(attachParameters.parameters, 19, true);
                if ( _doubleSize != null ) {
                    _doubleSize = _doubleSize.split('/');
                }
                specifiedSizes = {
                    R: $.findParameter(attachParameters.parameters, 13, true),
                    W: (_doubleSize != null) ? _doubleSize[0] : $.findParameter(attachParameters.parameters, 17, true),
                    H: (_doubleSize != null) ? _doubleSize[1] : $.findParameter(attachParameters.parameters, 45, true),
                    I: $.findParameter(attachParameters.parameters, 30, true),
                    Si: {
                        F: $.findParameter(attachParameters.parameters, 36, true),
                        B: $.findParameter(attachParameters.parameters, 37, true)
                    },
                    Sw: {
                        F: $.findParameter(attachParameters.parameters, 34, true),
                        B: $.findParameter(attachParameters.parameters, 35, true)
                    }
                };
            } else {
                //Типоразмеры
                tyreSizes = $.parser.regulate(strSource,domKey,'tyresize');

                //Индексы Скорость-нагрузка
                if(tyreSizes!=null){
                    var strSourceNext=strSource.replace(new RegExp(tyreSizes[0],'g'),'');
                    indexes = $.parser.regulate(strSourceNext,domKey,'tyreindex');
                }else{
                    var strSourceNext=null;
                    indexes=null;
                }

                var modelObj = $.findParameter(attachParameters.required, 4, false);
                if ( modelObj.type == 2 ) {
                    wheelSizes = $.parser.regulate(strSource,domKey,'wheelsize');
                }
            }



//console.log(strSource, extraCell, attachParameters, checkedParameters, $.parser.namingIsSet, specifiedSizes);
console.log(tyreSizes);
            if(tyreSizes!=null || wheelSizes!=null || specifiedSizes!=null){
                var tmpObj={
                    company:company,
                    currency:settings.currency,
                    existing:settings.existing,
                    //R колеса: 3,9 ? диски: 13
                    //W колеса: 4,6 ? диски: 12
                    //H колеса: 5,7
                    //Si индекс скорости F - перед, B - зад
                    //Sw индекс нагрузки F - перед, B - зад
                    R:(specifiedSizes!= null) ? specifiedSizes.R : ((wheelSizes!=null)?$.parser.replaceComa($.parser.getParameter(wheelSizes, new Array('15'))):$.parser.replaceComa($.parser.getParameter(tyreSizes, new Array(3,10,14)))),
                    W:(specifiedSizes!= null) ? specifiedSizes.W : ((wheelSizes!=null)?$.parser.replaceComa($.parser.getParameter(wheelSizes, new Array('16'))):$.parser.replaceComa($.parser.getParameter(tyreSizes, new Array(4,6,13)))),
                    H:(specifiedSizes!= null) ? specifiedSizes.H : ((wheelSizes!=null)?null:$.parser.replaceComa($.parser.getParameter(tyreSizes, new Array(5,7)))),
                    I:(specifiedSizes!= null) ? specifiedSizes.I : ((tyreSizes[11]!=null)?tyreSizes[11]:((tyreSizes[9]=='ZR')?'Z':null)),
                    type:settings.type,
                    manufacturer:settings.manufacturer,
                    model:null,
                    Si:{
                        F:(specifiedSizes!= null) ? specifiedSizes.Si.F : ((indexes!=null && (indexes[8]!=undefined || indexes[4]!=undefined))?((indexes[8]!=undefined)?indexes[8]:((indexes[5]!=undefined)?indexes[5]:null)):null),
                        B:(specifiedSizes!= null) ? specifiedSizes.Si.B : ((indexes!=null && indexes[10]!=undefined)?indexes[10]:null)
                    },
                    Sw:{
                        F:(specifiedSizes!= null) ? specifiedSizes.Sw.F : ((indexes!=null && (indexes[7]!=undefined || indexes[4]!=undefined))?((indexes[7]!=undefined)?indexes[7]:((indexes[4]!=undefined)?indexes[4]:null)):null),
                        B:(specifiedSizes!= null) ? specifiedSizes.Sw.B : ((indexes!=null && indexes[9]!=undefined)?indexes[9]:null)
                    },
                    parameters:attachParameters.parameters,
                    required:attachParameters.required,
                    raw:(specifiedSizes!= null) ? '' : tyreSizes.input,
                    price_line: strSource
                };

                if($.checkVal(4, attachParameters.required)){
                    var manufacturer = $.getObjBy(4, attachParameters.required, 'parameter_id');
                    if(manufacturer.type == 2){
                        tmpObj = $.parser.appendWheelData(tmpObj,strSource,extraCell);
                        if (wheelSizes != null) {
                            var dia = $.parser.getDia($.parser.replaceComa($.parser.getParameter(wheelSizes, new Array('28'))),true);
                            if ( dia ) {
                                var cDia = $.getObjIndexBy(14, tmpObj.parameters, 'parameter_id');
                                if ( cDia ) {
                                    tmpObj.parameters[cDia] = dia;
                                } else {
                                    tmpObj.parameters.push(dia);
                                }
                            }
                            var et = $.parser.getEt($.parser.replaceComa($.parser.getParameter(wheelSizes, new Array('29'))),true);
                            if ( et ) {
                                var cEt = $.getObjIndexBy(11, tmpObj.parameters, 'parameter_id');
                                if ( cEt ) {
                                    tmpObj.parameters[cEt] = et;
                                } else {
                                    tmpObj.parameters.push(et);
                                }
                            }
                            var bolts = $.parser.replaceComa($.parser.getParameter(wheelSizes, new Array('20')));
                            if ( bolts ) {
                                var cBs = $.getObjIndexBy(15, tmpObj.parameters, 'parameter_id');
                                if ( cBs ) {
                                    tmpObj.parameters[cBs].value = bolts;
                                } else {
                                    tmpObj.parameters.push({
                                        parameter_id : 15,
                                        value : bolts
                                    });
                                }
                            }

                            var pcd = {
                                pcd_1 : $.parser.replaceComa($.parser.getParameter(wheelSizes, new Array('22'))),
                                pcd_2 : $.parser.replaceComa($.parser.getParameter(wheelSizes, new Array('24')))
                            };
                            var pcd_1 = $.getObjIndexBy(9, tmpObj.parameters, 'parameter_id');
                            var pcd_2 = $.getObjIndexBy(10, tmpObj.parameters, 'parameter_id');
                            if ( pcd_1 ) {
                                tmpObj.parameters[pcd_1].value = pcd.pcd_1;
                            } else {
                                tmpObj.parameters.push({
                                    parameter_id : 9,
                                    value : pcd.pcd_1
                                });
                            }
                            if ( pcd_2 ) {
                                tmpObj.parameters[pcd_2].value = pcd.pcd_2;
                            } else {
                                tmpObj.parameters.push({
                                    parameter_id : 10,
                                    value : pcd.pcd_2
                                });
                            }


                        }
                    }
                }

                if($.parser.notaccepted[hex_md5(strSource)]!=undefined){
                    $.parser.notaccepted[hex_md5(strSource)].obj=tmpObj
                }
                return tmpObj;
            }else{
                $.parser.notaccepted[hex_md5(strSource)]={raw:strSource,type:'all_item',obj:null,tmp:null};
                return null;
            }
        },
        checkAlias:function(aliases,strSource,aliasKey){
            var match=null;
            if(aliases!=null){
                for(var i in aliases.alias){
                    var alias=aliases.alias[i].synonym.toLowerCase();
                    var pattern=$.parser.makeRegExp(alias,false);
                    var regexp = new RegExp(pattern, 'i');
                    if(strSource.match(regexp)){
                        if(aliasKey!=undefined){
                            match=aliases[aliasKey];
                        }else{
                            match=aliases.name;
                        }
                        return match;
                    }else{
                        var pattern=$.parser.makeRegExp(alias,true);
                        var regexp = new RegExp(pattern, 'i');
                        if(strSource.match(regexp)){
                            if(aliasKey!=undefined){
                                match=aliases[aliasKey];
                            }else{
                                match=aliases.name;
                            }
                            return match;
                        }
                    }
                }
            }
            return null;
        },
        appendWheelData:function(tmpObj,strSource,extraCell){
            var etIndex = $.getObjIndexBy(11, tmpObj.parameters, 'parameter_id');
            if(etIndex != null){
                tmpObj.parameters[etIndex] = $.parser.getEt(extraCell[etIndex], true);
            }else{
                tmpObj.parameters.push($.parser.getEt(strSource, false));
            }
            var diaIndex = $.getObjIndexBy(14, tmpObj.parameters, 'parameter_id');
            if(diaIndex != null){
                tmpObj.parameters[diaIndex] = $.parser.getDia(extraCell[diaIndex], true);
            }else{
                tmpObj.parameters.push($.parser.getDia(strSource, false));
            }
            return tmpObj;
        },
        getEt:function(strSource, isClean){
            var wrapper = {
                parameter_id : 11,
                value : null
            };
            if(isClean){
                wrapper.value = strSource;
            }else{
                var template='(^| |\\()((ET|ЕТ)[ ]*((\\d{2,3})+[\\.,]*(\\d{1,3})*))(\\))* (.*)';
                var regexp = new RegExp(template, 'i');
                var match = strSource.match(regexp);
                if(match!=null){
                    if(match[5]!=undefined){
                        var etLeft=match[5];
                        var etRight=(match[6]!=undefined)?match[6]:'0';
                        var et=etLeft+'.'+etRight;
                        wrapper.value = et;
                        return wrapper;
                    }
                }
            }
            return wrapper;
        },
        getDia:function(strSource, isClean){
            var wrapper = {
                parameter_id : 14,
                value : null
            };
            if(isClean){
                wrapper.value = strSource;
            }else{
                var template='(^| |\\()((DIA|ДИА)[ ]*((\\d{2,3})+[\\.,]*(\\d{1,3})*))(\\))* (.*)';
                var regexp = new RegExp(template, 'i');
                var match = strSource.match(regexp);
                if(match!=null){
                    if(match[5]!=undefined){
                        var diaLeft=match[5];
                        var diaRight=(match[6]!=undefined)?match[6]:'0';
                        var dia=diaLeft+'.'+diaRight;
                        wrapper.value = dia;
                        return wrapper;
                    }
                }
            }
            return wrapper;
        },


        addIfNotExist:function(checkedParameters,wrapper,needle){
            var isDone = false;
            for(var i in checkedParameters){
                if(checkedParameters[i].parameter_id!=null && checkedParameters[i].parameter_id==needle){
                    isDone = true;
                    checkedParameters[i] = wrapper;
                }
            }
            if(!isDone){
                checkedParameters.push(wrapper);
            }
            return checkedParameters;
        },
        getValuesByParameter:function(extraCell,checkedParameters,strSource){
            var attached={
                parameters:new Array,
                required:new Array
            };
            console.log(extraCell, checkedParameters, strSource);
            var presets=new Array;
            for(var item in extraCell){
                var pid=parseInt(checkedParameters[item]);
                var getter=extraCell[item].trim();
                if(pid!=4 && pid!=1){ //4 - произв. 1 - назв. модели
                    if(pid!=null){
                        if(pid==2 || pid==3){ // 2 - наименование 3 - наименование2
                            var validArray=$.parser.getValidate(getter,pid,attached.parameters,strSource);
                            attached.parameters=validArray;
                        }else{
                            if (pid!=0) {
                                var wrapper={
                                    parameter_id:pid,
                                    value:$.parser.getValidate(getter,pid,attached.parameters,strSource)
                                }
                                if(pid==25 || pid==26 || pid==27 || pid==17 || pid==45 || pid==13 || pid==34 || pid==35){
                                    wrapper.value = $.parseIntFix(wrapper.value)
                                }
                                attached.parameters.push(wrapper);
                            }
                        }
                    }
                }else{
                    var preset={
                        getter:getter
                    }
                    presets[pid]=preset;
                }
            }
/*
*<option value="1">Название модели</option>
* <option value="2">Наименование</option>
* <option value="3">Наименование 2</option>
* <option value="4">Производитель</option>
* <option value="5">Артикул</option>
* <option value="6">К-во отверст./PCD1</option>
* <option value="7">К-во отверст./PCD2</option>
* <option value="8">Размер</option>
* <option value="9">PCD</option>
* <option value="10">PCD2</option>
* <option value="11">Вылет</option>
* <option value="12">Вылет/ДЦО</option>
* <option value="13">Диаметр</option>
* <option value="14">ДЦО (DIA)</option>
* <option value="15">Количество отверстий</option>
* <option value="16">Цвет</option>
* <option value="17">Ширина</option>
* <option value="18">Ширина/Диаметр</option>
* <option value="19">Ширина/Профиль</option>
* <option value="20">Страна производитель</option>
* <option value="21">Цена 1</option><option value="22">Цена 2</option><option value="23">Цена 3</option><option value="24">Цена 4</option>
* <option value="25">Наличие 1</option><option value="26">Наличие 2</option><option value="27">Наличие 3</option>
* <option value="28">Другое</option>
* <option value="29">Профиль</option>
* <option value="30">R или ZR</option>
* <option value="31">Грузовые колеса</option>
* <option value="32">Технология</option>
* <option value="33">Шипованость</option>
* <option value="34">Индекс нагрузки 1</option><option value="35">Индекс нагрузки 2</option>
* <option value="36">Индекс скорости 1</option><option value="37">Индекс скорости 2</option>
* <option value="38">Индекс скорости/нагрузки</option></select>*/
            attached.required=$.parser.getByAlgorythm(presets,strSource);

            return attached;
        },
        getByAlgorythm:function(presets,strSource){
            var attached=new Array;
            if(presets[4]!=undefined){
                var matcheasy=$.parser.getValidate(presets[4].getter,4,attached,strSource);
                if(matcheasy!=null){
                    var wrapper={
                        parameter_id:4,
                        value:matcheasy,
                        type:$.parser.getManufacturerType(matcheasy)
                    }
                    attached.push(wrapper);
                }else{
                    var matchhard=$.parser.getBestMatch(strSource);
                    if(matchhard!=null){
                        var wrapper={
                            parameter_id:4,
                            value:matchhard,
                            type:$.parser.getManufacturerType(matchhard)
                        }
                        attached.push(wrapper);
                    }else{
                        $.parser.notaccepted[hex_md5(strSource)]={raw:strSource,type:'manufacturer',obj:null,tmp:null};
                    }
                }
            }else{
                var match=$.parser.getBestMatch(strSource);
                if(match!=null){
                    var wrapper={
                        parameter_id:4,
                        value:match,
                        type:$.parser.getManufacturerType(match)
                    }
                    attached.push(wrapper);
                }else{
                    $.parser.notaccepted[hex_md5(strSource)]={raw:strSource,type:'manufacturer',obj:null,tmp:null};
                }
            }
            if(attached[0]!=undefined && attached[0].value!=null){
                if(presets[1]!=undefined){
                    var presetModel=$.parser.getModel(presets[1].getter,attached[0].value);
                    if(presetModel!=null){
                        var wrapper={
                            parameter_id:1,
                            value:presetModel
                        }
                        attached.push(wrapper);
                    }else{
                        $.parser.notaccepted[hex_md5(strSource)]={raw:strSource,type:'model',obj:null,tmp:null};
                    }
                }else{
                    var presetModel=$.parser.getModel(strSource,attached[0].value);
                    if(presetModel!=null){
                        var wrapper={
                            parameter_id:1,
                            value:presetModel
                        }
                        attached.push(wrapper);
                    }else{
                        $.parser.notaccepted[hex_md5(strSource)]={raw:strSource,type:'model',obj:null,tmp:null};
                    }
                }
            }
            return attached;
        },
        getBestMatch:function(strSource){
            match=null;
            var manufacturer_preset=$.extraTab.manufacturers[0];
            var left=0;
            var right=parseInt(manufacturer_preset.length-1);
            for(i=0; i<manufacturer_preset.length; i++){
                if(i%2==0){
                    var left_case=manufacturer_preset[left].name.toLowerCase();
                    var left_manufacturer= $.parser.makeRegExp(left_case,false);
                    var regexp = new RegExp(left_manufacturer, 'i');
                    if(strSource.match(regexp)){
                        match=manufacturer_preset[left].name;
                    }else{
                        match=$.parser.checkAlias(manufacturer_preset[left],strSource);
                    }
                    left++;
                }else{
                    var right_case=manufacturer_preset[right].name.toLowerCase();
                    var right_manufacturer= $.parser.makeRegExp(right_case,false);
                    var regexp = new RegExp(right_manufacturer, 'i');
                    if(strSource.match(regexp)){
                        match=manufacturer_preset[right].name;
                    }else{
                        match=$.parser.checkAlias(manufacturer_preset[right],strSource);
                    }
                    right--;
                }
                if(match!=null){
                    return match;
                }
            }
            return null;
        },
        getManufacturerType:function(manufacturer){
            var base = $.extraTab.manufacturers[0];
            for ( var i in base ) {
                if ( base[i].name == manufacturer ) {
                    return parseInt(base[i].type);
                }
            }
            return null;
        },
        getValidate:function(getter,pid,attached,strSource){
            console.log('parametryzed', getter, getter.length, pid, strSource);
            var source=null;
            switch(pid){
                case 44:
                    source=$.parser.getCountryAndYear(getter); //fnc
                    break;
                case 21:
                    source=$.parser.getPriceAndCurrency(getter); //fnc
                    break;
                case 22:
                    source=$.parser.getPriceAndCurrency(getter); //fnc
                    break;
                case 23:
                    source=$.parser.getPriceAndCurrency(getter); //fnc
                    break;
                case 24:
                    source=$.parser.getPriceAndCurrency(getter); //fnc
                    break;
                case 2:
                    source=$.parser.getCollectedByNaming(getter,attached,strSource); //fnc
                    break;
                case 3:
                    source=$.parser.getCollectedByNaming(getter,attached,strSource); //fnc
                    break;
                case 32:
                    source=$.parser.getMatchFrom('technology',getter); //fnc
                    break;
                case 33:
                    source=$.parser.getMatchFrom('spike',getter); //fnc
                    break;
                case 20:
                    source=$.parser.getMatchFrom('manufacturedCountries',getter); //fnc
                    break;
                case 39:
                    source=$.parser.getMatchFrom('marking',getter,false); //fnc
                    break;
                case 16:
                    source=$.parser.getMatchFrom('color',getter); //fnc
                    break;
                case 4:
                    source=$.parser.getManufacturer(getter); //fnc
                    break;
                default:
                    source=(getter.length>0 && pid!=0)?getter:null;
            }
            return source;
        },
        getCountryAndYear:function(source){
            var country = $.parser.getMatchFrom('manufacturedCountries',source);
            return {
                country:parseInt(country),
                year:parseInt(source.replace ( /[^\d.]/g, '' ))
            };
        },
        getPriceAndCurrency:function(source){
            var match=null;
            var currency=$.parser.getMatchFrom('currency',source);
            var regexp = new RegExp('(\\d{2,5})+[\\.,]*(\\d{2})*', 'i');
            var priceMatch=source.match(regexp);
            if(priceMatch!=null){
                var priceLeft=priceMatch[1];
                var priceRight=(priceMatch[2]!=undefined)?priceMatch[2]:'00';
                var price=priceLeft+'.'+priceRight;
                var collected={
                    price:price,
                    currency:currency
                }
                match=collected;
            }
            return match;
        },
        getCollectedByNaming:function(source,attached,strSource){
            var match=null;
            if(!$.checkVal(16,attached)){
                match=$.parser.getMatchFrom('color',source);
                var wrapper={
                    parameter_id:16,
                    value:match
                }
                attached.push(wrapper);
                match=null;
            }
            if(!$.checkVal(32,attached)){
                match=$.parser.getMatchFrom('technology',source);
                var wrapper={
                    parameter_id:32,
                    value:match
                }
                attached.push(wrapper);
                match=null;
            }
            if(!$.checkVal(33,attached)){
                match=$.parser.getMatchFrom('spike',source);
                var wrapper={
                    parameter_id:33,
                    value:match
                }
                attached.push(wrapper);
                match=null;
            }
            if(!$.checkVal(39,attached)){
                match=$.parser.getMatchFrom('marking',strSource,false);
                var wrapper={
                    parameter_id:39,
                    value:match
                }
                attached.push(wrapper);
                match=null;
            }
            return attached;
        },
        getMatchFrom:function(type,source,isOnce){
            var match=null;
            var extras=$.extraTab.extras;
            if(extras[type]!=undefined){
                var collection=extras[type];
                for(var item in collection){
                    var pattern=collection[item].name.toLowerCase();
                    var isOnceAdvanced = (isOnce != undefined) ? isOnce : (type!='spike' && type!='marking' && type!='manufacturedCountries');
                    var template=$.parser.makeRegExp(pattern,isOnceAdvanced);
                    var regexp = new RegExp(template, 'i');
                    if(source.match(regexp)!=null){
                        match=collection[item].id;
                    }else{
                        match=$.parser.checkAlias(collection[item],source,'id');
                    }
                    if(match!=null){
                        return match;
                    }
                }
                return match;
            }
            return match;
        },
        getManufacturer:function(source){
            var manufacturer=null;
            var semantic=$.extraTab.semantic_manufacturers;
            var tmp=new Array;
            if(source.length >= 3) {
                for(i=0; i<3; i++){
                    var digit=source[i].toLowerCase();
                    tmp[i]=digit;
                }
                if(semantic[tmp[0]]!=undefined){
                    if(semantic[tmp[0]][tmp[1]]!=undefined){
                        if(semantic[tmp[0]][tmp[1]][tmp[2]]!=undefined){
                            var manufacturerMatch=semantic[tmp[0]][tmp[1]][tmp[2]];
                            if(typeof manufacturerMatch=="object"){
                                for(var item in manufacturerMatch){
                                    var se_manufacturer= $.parser.makeRegExp(manufacturerMatch[item],false);
                                    var regexp = new RegExp(se_manufacturer, 'i');
                                    if(source.match(regexp)){
                                        manufacturer=manufacturerMatch[item];
                                    }
                                }
                            }else{
                                var se_manufacturer= $.parser.makeRegExp(manufacturerMatch,false);
                                var regexp = new RegExp(se_manufacturer, 'i');
                                if(source.match(regexp)){
                                    manufacturer=manufacturerMatch;
                                }
                            }
                        }else{
                            manufacturer=null;
                            $.parser.callback.trigger('notFound');
                        }
                    }
                }
            }
            return manufacturer;
        },
        getModel:function(source,manufacturer){
            var model=null;
            var semantic=$.extraTab.semantic_models;
            if(manufacturer!=null){
                manufacturer=manufacturer.toLowerCase();
                var model_preset=semantic[manufacturer];
                if(model_preset!=undefined){
                    var left=0;
                    var right=parseInt(model_preset.length-1);
                    for(i=0; i<model_preset.length; i++){
                        var r_model= $.parser.makeRegExp(model_preset[right].model,false);
                        var regexp = new RegExp(r_model, 'i');
                        if(source.match(regexp)){
                            return model_preset[right];
                        }else{
                            model=$.parser.checkAlias(model_preset[right],source,'model');
                            if(model!=null){
                                return model_preset[right];
                            }
                        }
                        right--;
                        /*if(i%2==0){
                            var l_model= $.parser.makeRegExp(model_preset[left].model,false);
                            var regexp = new RegExp(l_model, 'i');
                            if(source.match(regexp)){
                                return model_preset[left];
                            }else{
                                model=$.parser.checkAlias(model_preset[left],source,'model');
                                if(model!=null){
                                    return model_preset[left];
                                }
                            }
                            left++;
                        }else{
                            var r_model= $.parser.makeRegExp(model_preset[right].model,false);
                            var regexp = new RegExp(r_model, 'i');
                            if(source.match(regexp)){
                                return model_preset[right];
                            }else{
                                model=$.parser.checkAlias(model_preset[right],source,'model');
                                if(model!=null){
                                    return model_preset[right];
                                }
                            }
                            right--;
                        }*/
                        if(model!=null){
                            return model;
                        }
                    }
                }else{
                    model=null;
                    $.parser.notaccepted[hex_md5(source)]={raw:source,type:'model',obj:null,tmp:null};
                }
            }
            return model;
        },
        getParameter:function(arr, keys){
            var val=null;
            for(var curr in keys){
                if(arr[keys[curr]]!=undefined){
                    val=arr[keys[curr]];
                }
            }
            return val;
        },
        regulate:function(strSource,domKey,tplKey){
            //var settings=$.parser.collection.settings[domKey];
            var regex = new RegExp('\\\+', 'g');
            var strSource=strSource.replace(regex, '\\+');
            var regex = new RegExp('\\\*', 'g');
            strSource=strSource.replace(regex, '\\*');
            var regex = new RegExp('\\\|', 'g');
            strSource=strSource.replace(regex, '\\|');
            var regex = new RegExp('\\\.', 'g');
            strSource=strSource.replace(regex, '\\.');

            var pattern=$.parser.collection.search_templates[tplKey].expression;
            var regexp = new RegExp(pattern, 'i');
            var newstr = strSource.match(regexp);
            return newstr;
        },
        replaceComa:function(strSource){
            if(strSource!=null){
                var regex = new RegExp(',', 'g');
                var strSource=strSource.replace(regex, '\.');
                return strSource;
            }
            return strSource;
        },
        eventLabel:function(str){
            var label=$('#eventLabel');
            label.text(str);
        },
        buildErrorList:function(){
            $('#dropbox').slideUp('200');
            var list=$('#errorList');
            var errors= $.parser.notaccepted;
            for(var item in errors){
                var ruType=new Array;
                ruType['model']='Модель :';
                ruType['manufacturer']='Произв.:';
                ruType['all_item']='Строка :';
                list.append('<li><label class="c_'+errors[item].type+'">'+ruType[errors[item].type]+'</label> <span data-id="'+item+'" data-type="'+errors[item].type+'">'+errors[item].raw+'</span><button data-id="'+item+'" class="excl">Исключить</button></li>');
            }
            if(list.children('li').length>0){
                setTimeout(function(){
                    list.slideDown(200);
                },500);
            }
            list.children('li').children('span').callBindForm('.debug_editor',null,false);
            list.children('li').children('button.excl').bind({
                click:function(){
                    var self=$(this);
                    var id=self.attr('data-id');

                    if($.parser.notaccepted[id]!=undefined){
                        delete $.parser.notaccepted[id];
                    }

                    if($.parser.accepted[id]!=undefined){
                        delete $.parser.accepted[id];
                    }
                    $('[data-id="'+id+'"]').unbind();
                    self.parent('li').remove();
                    if(list.children('li').length==0){
                        $('#errorList').slideUp('200');
                    }
                    return false;
                }
            });
            $('button.excl_all').bind({
                click:function(){
                    list.children('li').each(function(){
                        var self=$(this);
                        var id=self.children('button').attr('data-id');
                        $('[data-id="'+id+'"]').unbind();
                        self.remove();
                        if(list.children('li').length==0){
                            $('#errorList').slideUp('200');
                        }
                        if($.parser.notaccepted[id]!=undefined){
                            delete $.parser.notaccepted[id];
                        }

                        if($.parser.accepted[id]!=undefined){
                            delete $.parser.accepted[id];
                        }
                    });
                }
            });
            $('.debug_editor').bind({
                onOpen:function(e,tar){
                    $('.debug_editor').jPopup({isActive:true});
                    var self=tar;
                    var hashCode=self.attr('data-id');
                    var editor=$('.debug_editor');
                    editor.find('[name="unaccepted[hash]"]').val(hashCode);
                    var unaccepted=editor.find('[name="unaccepted"]');
                    unaccepted.val(self.text());
                    editor.find('.area').hide();
                    var workAreaTitle = editor.find('#workAreaTitle');
                    var workarea=editor.find('.'+self.attr('data-type'));
                    switch(self.attr('data-type')){
                        case 'manufacturer':
                            workAreaTitle.html('Выделите часть строки названия <b>производителя</b>');
                            break;
                        case 'model':
                            workAreaTitle.html('Выделите часть строки названия <b>модели</b>');

                            var manufacturer = ($.parser.notaccepted[hashCode].obj.required[0].value!=undefined)
                                ?$.parser.notaccepted[hashCode].obj.required[0].value
                                :'';

                            workarea.find('[name="model[manufacturer_id]"] option').each(function(key){
                                if(key==0){
                                    $(this).removeAttr('selected');
                                }
                                if($(this).text()==manufacturer){
                                    var val = parseInt($(this).attr('value'));
                                    setTimeout(function(){
                                        workarea.find('[name="model[manufacturer_id]"]').val(val);
                                        workarea.find('[name="model[manufacturer_id]"]').trigger('change');
                                    },1000);
                                }
                            });

                            break;
                    }
                    workarea.show();

                    var interval;

                    unaccepted.mousedown(function(){
                        var selectionNeed=workarea.find('.selectionNeed');
                        selectionNeed.css({'border-color':'red'});
                            interval=setInterval(function(){
                                unaccepted.getSelection(selectionNeed);
                            },400);
                    });
                    unaccepted.mouseup(function(){
                            clearInterval(interval);
                    });

                    editor.find('[name="model[manufacturer_id]"]').bind({
                        change:function(){
                            var selection=$(this).find('option:selected').text().toLowerCase();
                            if($.extraTab.semantic_models[selection]!=undefined){
                                var list=$.extraTab.semantic_models[selection];
                                editor.find('[name="model[id]"]').buildSelect(list,0,{key:'id',val:'model'});
                            }else{
                                editor.find('[name="model[id]"]').children('option').remove();
                                editor.find('[name="model[id]"]').append('<option disabled selected value=""> - </option>');
                            }
                        }
                    });
                    $('.debug_editor').jPopup({isActive:false});
                }
            });
            $('.debug_editor').bind({
                onSave:function(){
                    var editor=$('.debug_editor');
                    var hashCode=editor.find('[name="unaccepted[hash]"]').val();
                    var unaccepted= $.parser.notaccepted[hashCode];
                    var accepted=$.parser.accepted[hashCode];

                    var li = $('button[data-id="'+hashCode+'"]').parent('li');
                    var span = li.children('span');
                    var font = li.children('label');
                    if(span.attr('data-type')=='manufacturer'){
                        var res = $.findParameter(unaccepted.required, 4, false);
                        var manufacturer = res.value;
                        var cData = $.cData.read();
                        $('#errorList li').each(function(){
                            var li = $(this);
                            var type = li.children('span').attr('data-type');
                            if(type=='manufacturer'){
                                var strSource = li.text();
                                var tmpHashCode = li.children('span').attr('data-id');
                                for(var i=0; i<cData.added.length; i++){
                                    var pattern = $.parser.makeRegExp(cData.added[i], false);
                                    if(strSource.match(pattern)){
                                        $.updateRequiredForeach(4,cData.obj.name,tmpHashCode);

                                        var span = li.children('span');
                                        var font = li.children('label');
                                        span.attr('data-type','model');
                                        font.text('Модель :');
                                        font.removeClass('c_manufacturer').addClass('c_model');

                                        var model = $.parser.getModel(strSource, cData.obj.name);
                                        if(model!=null){
                                            $.updateRequiredForeach(1,model,tmpHashCode);
                                            delete $.parser.notaccepted[tmpHashCode];
                                            $('[data-id="'+tmpHashCode+'"]').unbind();
                                            $('button[data-id="'+tmpHashCode+'"]').parent('li').remove();
                                        }
                                    }
                                }
                            }
                        });
                        $.cData.drop();
                    }else if(span.attr('data-type')=='model'){
                        //find models and process
                        var res = $.findParameter(unaccepted.required, 1, false);
                        var model = res.value.model;
                        var alias = $.mergeSynonymous(res.value.alias);
                        var model2alias = new Array;
                        model2alias.push(model);
                        if(alias!=null){
                            model2alias.push(alias);
                        }

                        $('#errorList li').each(function(){
                            var type=$(this).children('span').attr('data-type');
                            if(type=='model'){
                                var search = model2alias.join('|');
                                var pattern = $.parser.makeRegExp(search, false);
                                var strSource = $(this).text();
                                var tmpHashCode = $(this).children('span').attr('data-id');

                                if(strSource.match(pattern)){
                                    $.updateRequiredForeach(1,res.value,tmpHashCode);
                                    delete $.parser.notaccepted[tmpHashCode];
                                    $('[data-id="'+tmpHashCode+'"]').unbind();
                                    $('button[data-id="'+tmpHashCode+'"]').parent('li').remove();

                                }
                            }
                        });
                    }

                    if(accepted.required[0]!=undefined && accepted.required[1]!=undefined){
                        delete $.parser.notaccepted[hashCode];
                        $('[data-id="'+hashCode+'"]').unbind();
                        $('button[data-id="'+hashCode+'"]').parent('li').remove();
                        if(list.children('li').length==0){
                            $('#errorList').slideUp('200');
                        }
                    }
                }
            });
            $('#nextStep').show();
            $('.add_toDb').bind({
                click:function(){
                    if(list.children('li').length>0){
                        list.children('li').each(function(){
                            var self=$(this);
                            var id=self.children('button').attr('data-id');
                            $('[data-id="'+id+'"]').unbind();
                            self.remove();
                            if(list.children('li').length==0){
                                $('#errorList').slideUp('200');
                            }
                            if($.parser.notaccepted[id]!=undefined){
                                delete $.parser.notaccepted[id];
                            }

                            if($.parser.accepted[id]!=undefined){
                                delete $.parser.accepted[id];
                            }
                        });
                    }
                    var finalLabel=$('#finalLabel');
                    finalLabel.show();
                    finalLabel.text('Подготовка...\n');
                    var arrObj=new Array;
                    for(var item in $.parser.accepted){
                        if($.parser.accepted[item]!=null){
                            arrObj.push($.parser.accepted[item]);
                        }
                    }

                    delete $.parser.accepted;
                    delete $.parser.collection;

                    var finalJSON=JSON.stringify(arrObj);

                    setTimeout(function(){
                        $('body').jPopup({isActive:true, text:'Выгрузка...\n'});
                        finalLabel.text('Выгрузка...\n');
                        $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=add', {fnc: 'price', priceData: finalJSON},
                            function(json){
                                json = App.ajax(json);

                                finalLabel.text(json+'\n');
                                if(json.data){
                                    if(json.data.status){
                                        $.jPopupChange('Готово...\n');
                                        finalLabel.text('Готово...\n');
                                        finalLabel.after($.makeWheelPriceTable(json.data.price.wheel));
                                        finalLabel.after($.makeTyrePriceTable(json.data.price.tyre));
                                        $('body').jPopup({isActive:false});
                                        finalLabel.slideUp('200');
                                        $('#nextStep').hide();
                                        $('button.process').hide();
                                    }
                                }
                            },"html");
                    },1000);
                }
            })
        },
        makeRegExp:function(str,isOnce){
            var regex = new RegExp('\\\+', 'g');
            var newstr=str.replace(regex, '\\+');
            var regex = new RegExp('\\\*', 'g');
            newstr=newstr.replace(regex, '\\*');
            var regex = new RegExp('\\\/', 'g');
            newstr=newstr.replace(regex, '\\/');
            var regex = new RegExp('\\\.', 'g');
            newstr=newstr.replace(regex, '\\.');
            if(isOnce){
                return '(^| |\\b)('+newstr+')\\b';
            }else{
                return '(^| |\\()('+newstr+')(\\))*[ ]*(.*)';
            }
        }


}
});

$.extend({
    findParameter:function(required,needle, isClearValue){
        for(var i in required){
            if(required[i]!=undefined){
                if(required[i].parameter_id==needle){
                    return (isClearValue) ? required[i].value : required[i];
                }
            }
        }
        return (isClearValue) ? null : false;
    },
    mergeSynonymous:function(alias){
        var synonymous = new Array;
        for(var i in alias){
            synonymous.push(alias[i].synonym);
        }
        var joined = synonymous.join('|');
        return (joined.length>0)?joined:null;
    },
    updateRequiredForeach:function(type,val,hashCode){
        var unaccepted=$.parser.notaccepted[hashCode].obj.required;
        var accepted=$.parser.accepted[hashCode].required;

        var required=unaccepted;

        var needleKey = function(needle){
            for(var i in unaccepted){
                if(required[i].parameter_id==needle){
                    return i;
                }
            }
        }

        var parameter=type;
        if(required[needleKey(type)]==undefined){
            var wrapper={
                parameter_id:parameter,
                value:val
            }
            required.push(wrapper);
        }
        $.parser.notaccepted[hashCode].required=required;
        $.parser.accepted[hashCode].required=required;
    }
});

$.fn.getSelection=function(obj){
    if(this.length!=0 && obj.length!=0){
        var self=$(this).get(0);
        obj.val(self.value.substring(self.selectionStart,self.selectionEnd));
    }
};

$.extend({
    makeTyrePriceTable:function(priceData){
        if(priceData.length > 0){
            var season = ['-','Зима','Лето','Всесезонка'];
            var type_transport = ['-','Легковой/4x4','Легкогрузовой','Индустриальный','Грузовой','Мото'];
            var html = '<h5>Шины</h5><div class="overscroll"><table class="evenodd">';
            html += '<tr>' +
                '<td>Производитель</td>' +
                '<td>Модель</td>' +
                '<td>Наименование</td>' +
                '<td>Изображение</td>' +
                '<td>Исходная строка</td>' +
                '<td>Сезон</td>' +
                '<td>Тип авто</td>' +
                '<td>Ширина</td>' +
                '<td>Высота</td>' +
                '<td>Диаметр</td>' +
                '<td>Индекс ск.</td>' +
                '<td>Индекс наг.</td>' +
                '<td>Технология</td>' +
                '<td>Шип</td>' +
                '<td>Наличие</td>' +
                '<td>Цена</td>' +
                '<td>Типоразмер</td>' +
                '</tr>';
            for(var item in priceData){
                var spike = $.getObjBy(priceData[item].spike, $.extraTab.extras.spike,'id');
                var technology = $.getObjBy(priceData[item].technology, $.extraTab.extras.technology, 'id');
                var s_index = new Array;
                var sw_index = new Array;
                if(priceData[item].si_f){
                    s_index.push(priceData[item].si_f);
                }
                if(priceData[item].si_b){
                    s_index.push(priceData[item].si_b);
                }
                var speed_index = s_index.join('/');
                var w_index = new Array;
                if(priceData[item].sw_f){
                    w_index.push(priceData[item].sw_f);
                    sw_index.push(priceData[item].sw_f+''+priceData[item].si_f);
                }
                if(priceData[item].sw_b){
                    w_index.push(priceData[item].sw_b);
                    sw_index.push(priceData[item].sw_b+''+priceData[item].si_b);
                }
                sw_index = sw_index.join('/');
                var weight_index = w_index.join('/');

                var size_i_c = '';
                var size_i_z = '';
                if ( priceData[item].size_i.length>0 ) {
                    switch (priceData[item].size_i) {
                        case 'C':
                            size_i_c = (priceData[item].type_transport == 3 || priceData[item].type_transport == 4) ? 'C' : '';
                            break;
                        case 'Z':
                            size_i_z = 'Z';
                            break;
                    }
                }


                var tmpHtml = '<tr>' +
                    '<td>'+priceData[item].manufacturer+'</td>' +
                    '<td>'+priceData[item].model+'</td>' +
                    '<td>'+priceData[item].size_w+((priceData[item].size_h!=null)?'/'+priceData[item].size_h:'')+' '+((size_i_z.length>0)?size_i_z:'')+'R'+priceData[item].size_r+((size_i_c.length>0)?size_i_c:'')+' '+priceData[item].manufacturer+' '+priceData[item].model+'' +
                    ' '+sw_index+' '+((technology!=null)?technology.name:'')+'</td>' +
                    '<td>'+priceData[item].src+'</td>' +
                    '<td>'+priceData[item].price_line+'</td>' +
                    '<td>'+((season[priceData[item].season]!=undefined)?season[priceData[item].season]:'-')+'</td>' +
                    '<td>'+((type_transport[priceData[item].type_transport]!=undefined)?type_transport[priceData[item].type_transport]:'-')+'</td>' +
                    '<td>'+priceData[item].size_w+'</td>' +
                    '<td>'+((priceData[item].size_h!=null)?priceData[item].size_h:'')+'</td>' +
                    '<td>'+priceData[item].size_r+'</td>' +
                    '<td>'+speed_index+'</td>' +
                    '<td>'+weight_index+'</td>' +
                    '<td>'+((technology!=null)?technology.name:((size_i_c.length>0)?size_i_c:'-'))+'</td>' +
                    '<td>'+((spike!=null)?spike.name:'-')+'</td>' +
                    '<td>'+priceData[item].stock_1+'</td>' +
                    /*'<td>'+priceData[item].stock_2+'</td>' +
                    '<td>'+priceData[item].stock_3+'</td>' +*/
                    '<td>'+priceData[item].price_1+'</td>' +
                    /*'<td>'+priceData[item].price_2+'</td>' +
                    '<td>'+priceData[item].price_3+'</td>' +
                    '<td>'+priceData[item].price_4+'</td>' +*/
                    '<td>'+priceData[item].size_w+((priceData[item].size_h!=null)?'/'+priceData[item].size_h:'')+' '+((size_i_z.length>0)?size_i_z:'')+'R'+priceData[item].size_r+((size_i_c.length>0)?size_i_c:'')+'</td>' +
                    '</tr>';

                html += tmpHtml;
            }

            html += '</table></div>' +
                '<a class="refreshPage button" href="'+App.baseLink()+'?view=admin_panel&load=price_panel" style="color: #ffffff;">Начать новую обработку</a>';

            return html;
        }
        return '';
    },
    makeWheelPriceTable:function(priceData){
        if(priceData.length > 0){
            var type_wheel = ['-','Стальной','Литой','Кованый','Составной'];
            var html = '<h5>Диски</h5><div class="overscroll"><table class="evenodd">';
            html += '<tr>' +
                '<td>Производитель</td>' +
                '<td>Модель</td>' +
                '<td>Наименование</td>' +
                '<td>Изображение</td>' +
                '<td>Исходная строка</td>' +
                '<td>Ширина</td>' +
                '<td>Диаметр</td>' +
                '<td>Крепеж</td>' +
                '<td>PCD1</td>' +
                '<td>PCD2</td>' +
                '<td>Вылет (ET)</td>' +
                '<td>Диам. ступ. (DIA)</td>' +
                '<td>Цвет диска</td>' +
                '<td>Тип диска</td>' +
                '<td>Наличие</td>' +
                '<td>Цена</td>' +
                '</tr>';
            for(var item in priceData){
                var color = $.getObjBy(priceData[item].color, $.extraTab.extras.color,'id');
                var wheel_type = (priceData[item].manufacturer_wheel_type!=null)?type_wheel[priceData[item].manufacturer_wheel_type]:type_wheel[0];

                var tmpHtml = '<tr>' +
                    '<td>'+priceData[item].manufacturer+'</td>' +
                    '<td>'+priceData[item].model+'</td>' +
                    '<td>'+priceData[item].manufacturer+' '+priceData[item].model+'</td>' +
                    '<td>'+priceData[item].src+'</td>' +
                    '<td>'+priceData[item].price_line+'</td>' +
                    '<td>'+priceData[item].size_w+'</td>' +
                    '<td>'+priceData[item].size_r+'</td>' +
                    '<td>'+((priceData[item].bolt != 0)?priceData[item].bolt:'-')+'</td>' +
                    '<td>'+((priceData[item].pcd_1 != 0)?priceData[item].pcd_1:'-')+'</td>' +
                    '<td>'+((priceData[item].pcd_2 != 0)?priceData[item].pcd_2:'-')+'</td>' +
                    '<td>'+priceData[item].et+'</td>' +
                    '<td>'+priceData[item].dia+'</td>' +
                    '<td>'+((color!=null)?color.name:'-')+'</td>' +
                    '<td>'+wheel_type+'</td>' +
                    '<td>'+priceData[item].stock_1+'</td>' +
                    '<td>'+priceData[item].price_1+'</td>' +
                    '</tr>';

                html += tmpHtml;
            }

            html += '</table></div>' +
                '<a class="refreshPage button" href="'+App.baseLink()+'?view=admin_panel&load=price_panel" style="color: #ffffff;">Начать новую обработку</a>';

            return html;
        }
        return '';
    }
});


$.extend({
    parseIntFix:function(needle){
        var regexp = new RegExp('[0-9]+');
        if(needle!=null){
            var res = needle.match(regexp, 'i');
            return (res!=null)?parseInt(res):0;
        }
        return 0;
    }
});

$.extend({
    checkVal:function(needle,arr){
        for(var item in arr){
            if(parseInt(needle)==parseInt(arr[item].parameter_id)){
                return true;
            }
        }
        return false;
    }
});

$.extend({
    getObjBy:function(needle,arr,by){
        var source=arr;
        for(var item in source){
            if(source[item][by]!=undefined){
                if(needle==source[item][by]){
                    return source[item];
                }
            }
        }
        return null;
    },
    getObjIndexBy:function(needle,arr,by){
        var source=arr;
        for(var item in source){
            if(source[item][by]!=undefined){
                if(needle==source[item][by]){
                    return item;
                }
            }
        }
        return null;
    }
});

String.prototype.trim = function() {  return this.replace(/^\s+|\s+$/g, '');  }

$(document).ready(function(){

});