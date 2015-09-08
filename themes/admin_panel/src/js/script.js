$(function(){
	
	var dropbox = $('#dropbox'),
		message = $('.message', dropbox);
	
	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'source',
		
		maxfiles: 1,
    	maxfilesize: 4,
		url: dropbox.attr('data-action'),

		uploadFinished:function(i,file,response){
            dropbox.css({'background-color':'#ffffff'});
			$.data(file).addClass('done');
			// response is the JSON object that post_file.php returns
            $('body').jPopup({isActive:true, text:'Затягиваю...\n'});
            $.compileData(file,dropbox);
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Your browser does not support HTML5 file uploads!');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select 5 at most! (configurable)');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 2mb (configurable).');
					break;
				default:
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			/*if(!file.type.match(/^image\//)){
				alert('Only images are allowed!');
				
				// Returning false will cause the
				// file to be rejected
				return false;
			}*/
		},
		
		uploadStarted:function(i, file, len){
			createImage(file);
		},
		
		progressUpdated: function(i, file, progress) {
			$.data(file).find('.progress').width(progress);
		},

        dragEnter :function(e) {
            dropbox.css({'background-color':'#E4E4E4'});
        },

        dragOver :function(e) {
            dropbox.css({'background-color':'#DAFFDE'});
        },

        dragLeave :function(e) {
            dropbox.css({'background-color':'#ffffff'});
        }
    	 
	});
	
	var template = '<div class="preview">'+
						'<span class="imageHolder">' +
							'<span class="uploaded"></span>'+
						'</span>'+
						'<div class="progressHolder">'+
							'<div class="progress"></div>'+
							'<div class="progress_next"></div>'+
						'</div>'+
					'</div>'; 
	
	
	function createImage(file){

		var preview = $(template), 
			image = $('img', preview);
			
		var reader = new FileReader();
		
		image.width = 100;
		image.height = 100;
		
		reader.onload = function(e){
			
			// e.target.result holds the DataURL which
			// can be used as a source of the image:
			
			//image.attr('src',e.target.result);
		};
		
		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		reader.readAsDataURL(file);
		
		message.hide();
		preview.appendTo(dropbox);
		
		// Associating a preview container
		// with the file, using jQuery's $.data():
		
		$.data(file,preview);
	}

	function showMessage(msg){
		message.html(msg);
	}

});
$.extend({
    extraTab:{
        active:0,
        total:0,
        manufacturers:null,
        parameters:null,
        company:null,
        priceName:null
    },
    compileData:function(file,obj){
        var name=file.name;
        var url=obj.attr('data-process')+'&xls='+name;
        $.get(url, function(data){
            data = App.ajax(data);
            $.extraTab.priceName = name;
            //console.log(data);
            $.pushData(data.status);
        });
    },pushData:function(url){
        var base = $('base').attr('href');
        $.getJSON(base+'tmp/'+url, function(data){
            $.jPopupChange('Обрабатываю...\n');
            var oWrapper=$('.imageHolder');
            oWrapper.find('span.uploaded').remove();
            oWrapper.append('<ul></ul>');
            var oTable=oWrapper.children('ul');
            var extraSettings=$('.extraSettings');
            var active;
            var forms='';
            $.extraTab.total=data.length;
            for (var i = 0 ; i < $.extraTab.total ; i++) {
                //var td='<td>List #'+i+'</td>';
                //oTable.append('<tr>'+td+'</tr>');
                active=(i==0)?' active':'';
                var content= $.createContent(data[i]);
                oTable.append('<li class="listTab'+active+'">'+content+'</li>');
                oWrapper.append('<span class="listIdent'+active+'" data-id="'+i+'">'+data[i].name+' <input type="checkbox" value="1" checked></span>');
                forms+=$.createForms(i);
            }
            extraSettings.html(forms);
            $.setDefaults();
            $("#dropbox").stick_in_parent();

            $('.extraCompany').bind({
                change:function(){
                    $.extraTab.company = parseInt($(this).val());
                    $.reloadDefaults();
                }
            });

            $('.listIdent').bind({
                click:function(){
                    var id=$(this).attr('data-id');
                    var tabHandler=$('.listIdent');
                    var tab=$('.listTab');
                    tab.removeClass('active');
                    tab.eq(id).addClass('active');
                    tabHandler.removeClass('active');
                    $(this).addClass('active');
                    $.extraTab.active=id;
                    extraSettings.children('li').hide();
                    extraSettings.children('li[data-id="'+id+'"]').show();
                }
            });

            /*$('.wrapperSelector').bind({
                change:function(){
                    var listId= $.extraTab.active;
                    var selected=$(this).val();
                    var manufacturerSelect=extraSettings.children('li[data-id="'+listId+'"]').find('select[name="manufacturer[]"]');
                    var parametersBox=extraSettings.children('li[data-id="'+listId+'"]').find('.gridpanel');
                    manufacturerSelect.createOptions($.extraTab.manufacturers,selected);
                    parametersBox.createParameters($.extraTab.parameters,selected,true,null);
                }
            });*/

            $('.process').bind({
                click:function(){
                    $.parser.process();
                    return false;
                }
            });

            extraSettings.find('fieldset .gridpanel .row').live({
                mouseenter:function(){
                    var id=$(this).closest('li').attr('data-id');
                    var index=$(this).index();
                    index++;
                    /*$('.listTab:eq('+id+') tr:not(.exclude)').each(function(key){
                        if(key<20){
                            $(this).find('td:eq('+index+')').addClass('highlight');
                        }
                    });*/
                    $('head').append('<style id="style">.listTab.active table tr:not(.exclude) td:nth-child('+index+'){ background: #ADE0FF; }</style>');
                    //console.log(id,index);
                },mouseleave:function(){
                    var id=$(this).closest('li').attr('data-id');
                    var index=$(this).index();
                    /*$('.listTab:eq('+id+') tr:not(.exclude)').each(function(key){
                        if(key<20){
                            $(this).find('td:eq('+index+')').removeClass('highlight');
                        }
                    });*/
                    $('#style').remove();
                }
            });
            $.jPopupChange('Готово...\n');
        });
        $('body').jPopup({isActive:false});
    },setDefaults:function(){
        var extraSettings=$('.extraSettings');
        for (var i = 0 ; i < $.extraTab.total ; i++) {
            //console.log($.extraTab,i);
            var manufacturerSelect=extraSettings.children('li[data-id="'+i+'"]').find('select[name="manufacturer[]"]');
            var parametersBox=extraSettings.children('li[data-id="'+i+'"]').find('.gridpanel');
            manufacturerSelect.createOptions($.extraTab.manufacturers,0);
            parametersBox.createParameters($.extraTab.parameters,0,false,i);
        }
        $('.process').show();
        $('.saveExtraSettings').show().bind({
            click: function(){
                if($.extraTab.priceName!=null && $.extraTab.company!=null){
                    var settingCollection=new Array;
                    var priceName=$.extraTab.priceName;
                    var companyId=$.extraTab.company;
                    extraSettings.children('li').each(function(){
                        var self=$(this);
                        var id=self.attr('data-id');
                        var settingRow = new Array;
                        var parameterCounter=0;
                        var isChecked={
                            selector:'.listIdent[data-id=\\"'+id+'\\"] input',
                            bool:$('.listIdent[data-id="'+id+'"] input').is(':checked')
                        };
                        self.find('select, input').each(function(key){
                            var node = $(this);
                            var type = node.get(0).nodeName.toLowerCase();
                            var name = node.attr('name');
                            var postfix='';
                            if(name=='parameter[][]'){
                                postfix=':eq('+parameterCounter+')';
                                parameterCounter++;
                            }
                            var selector = type+'[name=\\"'+name+'\\"]'+postfix;
                            settingRow[key] = {
                                nodeValue:node.val(),
                                nodeSelector:selector,
                                nodeKey:key,
                                nodeType:type
                            };
                        });
                        settingCollection.push({tab:'li[data-id=\\"'+id+'\\"]',row:settingRow,isActive:isChecked});
                    });
                    if(confirm('Сохранить шаблон настроек прайса\r\n'+priceName+'\r\nдля текущей компании?')){
                        $.post(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=add',{
                            fnc: 'settings',
                            company_id: companyId,
                            price_name: priceName,
                            settings: settingCollection
                        }, function(json){
                            json = App.ajax(json);
                                alert('Сохранено!');
                        },"html");
                    }
                }else{
                    alert('Выберите компанию для\r\nсохранения шаблона настроек');
                }
                return false;
            }
        });
    },reloadDefaults:function(){
        $.getSettings();
    },getSettings:function(){
        if($.extraTab.priceName!=null && $.extraTab.company!=null){
            var priceName=$.extraTab.priceName;
            var companyId=$.extraTab.company;
            $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=settings&price_name='+priceName+'&company_id='+companyId,function(json){
                json = App.ajax(json);
                if(json.status){
                    var jsonData = $.parseJSON(json.data);
                    if(jsonData!=null){
                        $.applySettings(jsonData);
                    }
                }
            });
        }
        return null;
    },applySettings:function(jsonData){
        for(var j=0; j<jsonData.length; j++){
            var setting=jsonData[j];
            var total = setting.row.length;
            //console.log(setting.isActive);
            if(setting.isActive.bool=='false'){
                $(setting.isActive.selector).removeAttr('checked');
            }
            for(var i=0; i<total; i++){
                var node=$(setting.tab).find(setting.row[i].nodeSelector);
                var type=setting.row[i].nodeType;
                var val=setting.row[i].nodeValue;
                switch (type){
                    case 'select':
                        node.find('option[value="'+val+'"]').attr('selected',true);
                        break;
                    case 'input':
                        node.val(val);
                        break;
                }
            }
        }
    }
    ,createContent:function(data){
        var cells=data.cells;
        var numCols=data.numCols;
        var numRows=data.numRows;
        var table_content='<table>';
        for(var i in cells){
            if(cells[i]!=undefined){
                if(i<10){
                    //console.log(cells[i], $.isNormal(cells[i]), $.isNormalB(cells[i]));
                }
                var attr=($.isNormal(cells[i]))?'':' class="exclude"';
                var trs='<tr'+attr+'>';
                var tre='</tr>';
                table_content+=trs;
                var cellCounter=0;
                for(j=1; j<=numCols; j++){
                    if(cells[i][j]!=undefined){
                        table_content+='<td>'+cells[i][j]+'</td>';
                    }else{
                        table_content+='<td></td>';
                    }
                    cellCounter++;
                }
                if(cellCounter<numCols){
                    for(var c=cellCounter; c<numCols; c++){
                        table_content+='<td></td>';
                    }
                }
                table_content+=tre;
            }
        }
        table_content+='</table>';

        return table_content;
    },isNormal:function(row){
        var textCount=0;
        for(var i in row){
            row[i] = (row[i]!=null)?row[i].toString():row[i];
            textCount=(row[i]!=null && row[i].length>0)?(textCount+1):textCount;
        }
        return (textCount>=2)?true:false;
    },isNormalB:function(row){
        var textCount=new Array;
        for(var i in row){
            row[i] = (row[i]!=null)?row[i].toString():row[i];
            textCount.push({nul:(row[i]!=null), r:row[i]});
        }
        return textCount;
    },createForms:function(extaTabId){

        var extraSettings=$('.extraSettings');
        $.get(App.baseLink()+'?view=admin_panel&load=api_panel&fnc=show&case=currencyRate_list', function(json){
            json = App.ajax(json);
            var list=json.data;

            var htmlOptions='';
            for(var i in list.rate){
                htmlOptions += '<option value="'+i+'">'+i+' ('+list.rate[i]+')</option>';
            }
            extraSettings.eq(extaTabId).find('select[name="currency[]"]').append(htmlOptions);
        });

        var display=(extaTabId!=0)?' style="display:none;"':'';
        var template='' +
            '<li data-id="'+extaTabId+'"'+display+'>' +
                '<label>Тип</label>' +
                '<select name="type[]" class="wrapperSelector">' +
                    '<option value="0" selected>-</option><option value="1">Диск</option><option value="2">Шина</option>' +
                '</select>' +
                '<label>Большое наличие</label>' +
                '<input type="text" name="existing[]" placeholder="Например \'>20\' или \'50\'">' +
                '<label>Пропускать если есть</label>' +
                '<input type="text" name="excluding[]" placeholder="Разделитель \';\'">' +
                '<label>Искать где есть</label>' +
                '<input type="text" name="including[]" placeholder="Разделитель \';\'">' +
                '<label>Производитель</label>' +
                '<select name="manufacturer[]">' +
                    '<option value="0" selected>-</option>' +
                '</select>' +
                '<label>Валюта</label>' +
                '<select name="currency[]">' +
                    '<option value="" selected>-</option>' +
                '</select>' +
                '<fieldset>' +
                    '<legend>Параметры</legend>' +
                    '<div class="gridpanel"></div>' +
                '</fieldset>' +
            '</li>';
        return template;
    }
});

$.fn.createOptions=function(jsonData,iType){
    var DOMsource='<option value="0" selected>-</option>';
    for(var iterator in jsonData[iType]){
        var item = jsonData[iType][iterator];
        DOMsource+='<option value="'+item.manufacturer_id+'">'+item.name+'</option>';
    }
    $(this).html(DOMsource);
}
$.fn.createParameters=function(jsonData,iType,isActiveOnly,each){
    //console.log(iType,isActiveOnly,each);
    var DOMsource='';
    var activeState=(isActiveOnly)?'.active':':eq('+each+')';
    var listTabColumns=$('.listTab'+activeState+' table tr').getMax();
    for(i=0; i<listTabColumns; i++){
        DOMsource+='<div class="row">';
        DOMsource+='<div class="panel">' +
            '<label>Колонка '+i+'</label>' +
            '<select name="parameter[][]">' +
            '<option value="0" selected>-</option>';

        for(var iterator in jsonData[iType]){
            var item = jsonData[iType][iterator];
            DOMsource+='<option value="'+item.parameter_id+'">'+item.name+'</option>';
        }

        DOMsource+='</select>' +
            '</div>';
        DOMsource+='</div>';
    }
    $(this).html(DOMsource);
}
$.fn.getMax=function(){
    var owner=$(this);
    var incrementLength=0;
    owner.each(function(){
        currentLength=$(this).children().length;
        if(currentLength>incrementLength){
            incrementLength=currentLength;
        }
    });
    return incrementLength;
}
