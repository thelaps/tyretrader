/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 14.12.13
 * Time: 22:52
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    function bindMarginButtons(){
        $('.margin-edit').unbind().bind({
            click: function() {
                var id=$(this).attr('data-id');
                var action = App.options.base + '?view=api&load=calculator';
                $.post(action, {fnc:'get', calculator:{id:id}}, function(data, status){
                    var json = AFW.ajax(data);
                    if(status=='success'){
                        var form = $('.tabs-holder .tab.active form');
                        form.find('input[name="calculator[id]"]').val(id);
                        form.find('[name="calculator[manufacturer_id]"]').val(json.completeData.items[0].manufacturer_id).click().trigger('change');
                        form.find('[name="calculator[model_id]"]').val(json.completeData.items[0].model_id).click().trigger('change');
                        form.find('[name="calculator[city_id]"]').val(json.completeData.items[0].city_id).click().trigger('change');
                        form.find('[name="calculator[company_id]"]').val(json.completeData.items[0].company_id).click().trigger('change');
                        form.find('input[name="calculator[season]"]').removeAttr('checked').click().trigger('change');
                        form.find('#s_season-'+json.completeData.items[0].season).attr('checked','checked').click().trigger('change');
                        form.find('[name="tyre[size_w][]"]').val(json.completeData.items[0].size_w).click().trigger('change');
                        form.find('[name="tyre[size_h][]"]').val(json.completeData.items[0].size_h).click().trigger('change');
                        form.find('input[name="tyre[size_r][]"]').val(json.completeData.items[0].size_r).click().trigger('change');
                        form.find('[name="calculator[percentage]"]').val(json.completeData.items[0].percentage);
                        form.find('input[name="calculator[min_cost]"]').val(json.completeData.items[0].min_cost);
                        form.find('input[name="calculator[max_cost]"]').val(json.completeData.items[0].max_cost);
                        form.find('input[name="calculator[fixed_cost]"]').val(json.completeData.items[0].fixed_cost);
                        form.find('input[name="calculator[not_less]"]').val(json.completeData.items[0].not_less);
                        form.find('input[name="calculator[not_more]"]').val(json.completeData.items[0].not_more);
                        form.find('input[name="calculator[shipping]"]').val(json.completeData.items[0].shipping);
                        form.find('input[name="calculator[transfer]"]').val(json.completeData.items[0].transfer);
                        form.find('input[name="calculator[bank]"]').val(json.completeData.items[0].bank);
                    }else{
                        alert('Серверная ошибка!');
                    }
                });
            }
        });
        $('.margin-delete').unbind().bind({
            click: function() {
                var id=$(this).attr('data-id');
                var action = App.options.base + '?view=api&load=calculator';
                $.post(action, {fnc:'deleteMargin', calculator:{id:id}}, function(data, status){
                    if(status=='success'){
                        var json = AFW.ajax(data);
                        Action.process('deleteMargin', json.completeData);
                    }else{
                        alert('Серверная ошибка!');
                    }
                });
            }
        });
    }
    bindMarginButtons();
    var companies = null;
    App.com.import(App.options.dir + '/js/app/ajaxActions.js',function(){
        new Action({
            register: function(){
                window.location = App.options.base;
            },
            auth: function(){
                window.location.reload(true);
            },
            logout: function(){
                window.location.reload(true);
            },
            forgot: function(){
                $('#dialog-error > span.errorTitle').text('Запрос отправлен.');
                $('#dialog-error > ul.errorList').html('<li>Проверьте почту пожалуйста.</li>');
                $("#dialog-error").dialog({
                    modal: true,
                    title: 'Запрос восстановления',
                });
                setTimeout(function(){
                    window.location = App.options.base;
                },5000);
            },
            opt: function(e){
                if($('#optHolder').css('display') == 'none'){
                    $('#pageContent').slideUp(200,function(){
                        $('#optHolder').slideDown();
                    });
                }

                $('.resultHolder .amount b').html(e.total);
                console.log(e);
                CB.table(e.items,{
                    replace:true,
                    class:'mainTable',
                    appendRow:function(row, index){
                        row.sort(function(a, b){
                            var aDays= a.daysago;
                            var bDays = b.daysago;
                            var sortedDays = ((aDays < bDays) ? -1 : ((aDays > bDays) ? 1 : 0));
                            return sortedDays;
                        });
                        row.sort(function(a, b){
                            var aPrice = a.price_1;
                            var bPrice = b.price_1;
                            if (a.daysago > 7 && b.daysago > 7) {
                                var sortedPrice = ((aPrice < bPrice) ? -1 : ((aPrice > bPrice) ? 1 : 0));
                            }
                            return sortedPrice;
                        });
                        html = '<tr id="'+index+'" class="undecorated"><td colspan="8"><div class="collapsedDiv">';
                        html += CB.table(row,{
                            replace:false,
                            class:'inset',
                            cells:[
                                function(row){
                                    return '<a href="'+App.options.base+'?view=api&load=customer&company_id='+row.company_id+'" class="details-link">'+companies[row.company_id].name+' '+companies[row.company_id].city+'</a>';
                                },
                                function(row){
                                    return '<a href="'+App.options.base+'?view=api&load=product&model_id='+row.model_id+'&company_id='+row.company_id+'&price_id='+row.id+'&type=raw" class="details-link info"></a>';
                                },
                                'time',
                                'stock_1',
                                'price_1',
                                'price_compiled',
                                function(row){
                                    return '<a href="#">Создать заявку</a>';
                                }
                            ],
                            beforeRows:function(){
                                return '<tr><td><div>компания</div></td><td><div>инфо</div></td><td><div>дата добавления</div></td><td><div>остаток</div></td><td><div>закупка</div></td><td><div>цена</div></td><td><div><a href="#"><b>заявка всем</b></a></div></td></tr>';
                            }
                        });
                        html += '</div></td></tr>';
                        return html;
                    },
                    cells:[
                        function(row, index){
                            return '<a class="collapsedTableToggle" data-toggle="'+index+'">+</a>';
                        },
                        function(row){
                            var companies = new Array;
                            var companiesCount = 0;
                            for (var i in row) {
                                var company = row[i].company_id;
                                if (companies.indexOf(company)=='-1'){
                                    companies.push(company);
                                    companiesCount++;
                                }
                            }
                            return companiesCount;
                        },
                        function(row){
                            return row[0].manufacturer;
                        },
                        function(row){
                            return row[0].model;
                        },
                        function(row){
                            return '<a href="'+App.options.base+'?view=api&load=product&model_id='+row[0].model_id+'&company_id='+row[0].company_id+'&price_id='+row[0].id+'" class="details-link">'+row[0].scopename+'</a>';
                        },
                        function(row){
                            var totalStock = 0;
                            for (var i in row) {
                                totalStock += row[i].stock_1;
                            }
                            return totalStock;
                        },
                        function(row){
                            var totalPrice = 0;
                            for (var i in row) {
                                totalPrice += row[i].price_1;
                            }
                            return parseInt(totalPrice/row.length);
                        },
                        function(row){
                            var totalPrice = 0;
                            for (var i in row) {
                                totalPrice += row[i].price_compiled;
                            }
                            return parseInt(totalPrice/row.length);
                        }
                    ],
                    beforeRows:function(){
                        return '<tr>' +
                            '<td><div>&nbsp;</div></td>' +
                            '<td><div>к-во</div></td>' +
                            '<td><div>бренд <i class="filter '+((e.filter.manufacturer.length > 0)?e.filter.manufacturer:'BT')+'" data-filter=".filter-manufacturer"></i></div></td>' +
                            '<td><div>модель <i class="filter '+((e.filter.model.length > 0)?e.filter.model:'BT')+'" data-filter=".filter-model"></i></div></td>' +
                            '<td><div>полное название <i class="filter '+((e.filter.sqlscopename.length > 0)?e.filter.sqlscopename:'BT')+'" data-filter=".filter-sqlscopename"></i></div></td>' +
                            '<td><div>ост. <i class="filter '+((e.filter.stock_1.length > 0)?e.filter.stock_1:'BT')+'" data-filter=".filter-stock_1"></i></div></td>' +
                            '<td><div>закупка <i class="filter '+((e.filter.price_1.length > 0)?e.filter.price_1:'BT')+'" data-filter=".filter-price_1"></i></div></td>' +
                            '<td><div>цена</div></td>' +
                            '</tr>';
                    }
                });
                $('.collapsedTableToggle').on({
                    click:function(){
                        $(this).closest('tr').toggleClass('active');
                        var rowId = $(this).attr('data-toggle');
                        $('#'+rowId).find('div.collapsedDiv').toggle();
                    }
                });
                $('.details-link').fancybox({
                    type: 'ajax',
                    padding: 2,
                    width: 720,
                    height: 587,
                    autoDimensions: false,
                    overlayColor: '#202f4e',
                    overlayOpacity: 0.6,
                    onComplete: function() {
                        $('a.thumb').click(function(){
                            var $link = $(this);
                            $link.parents('.image-set').find('.image > img').attr('src', $link.attr('href'));
                            return false;
                        });
                    }
                });
                $('.filter').on({
                    click:function(){
                        var _self = $(this);
                        var needle = $(_self.attr('data-filter'),'.tab.active');
                        var ordering = (_self.hasClass('BT'))?'TB':(_self.hasClass('TB')?'BT':'');
                        _self.removeClass((_self.hasClass('BT'))?'BT':(_self.hasClass('TB')?'TB':''));
                        _self.addClass(ordering);
                        needle.closest('form').find('input[class^="filter-"]').each(function(){
                            $(this).val('');
                        });
                        needle.val(ordering);
                        needle.closest('form').find('button[type="submit"]').click();
                    }
                });
            },
            addMargin : function(e) {
                CB.table(e.items,{
                    replace:true,
                    class:'table price-grid',
                    cells:[
                        'id',
                        function(row) {
                            return (row.company!=null) ? '<a href="#">'+row.company+'</a>' : ''
                        },
                        function(row){
                            return (row.manufacturer!=null) ? row.manufacturer : '';
                        },
                        function(row){
                            return row.min_cost+'-'+row.max_cost;
                        },
                        function(row){
                            return row.percentage+'%';
                        },
                        'fixed_cost',
                        'not_less',
                        'not_more',
                        'shipping',
                        'transfer',
                        'bank',
                        function(row){
                            return '<button class="edit margin-edit" data-id="'+row.id+'" type="button">edit</button>';
                        },
                        function(row){
                            return '<button class="delete margin-delete" data-id="'+row.id+'" type="button">delete</button>';
                        }
                    ],
                    beforeRows:function(){
                        return '<tr>' +
                            '<th class="col-id">ID</th>' +
                            '<th class="col-provider"><!--<div class="sortable desc">-->ПОСТАВЩИК<!--</div>--></th>' +
                            '<th class="col-brand"><!--<div class="sortable asc">-->БРЕНД<!--</div>--></th>' +
                            '<th>РАЗБРОС ЦЕН</th>' +
                            '<th>ПРОЦЕНТ</th>' +
                            '<th>Ф. ЗНАЧ.</th>' +
                            '<th>НЕ МЕНЕЕ</th>' +
                            '<th>НЕ БОЛЕЕ</th>' +
                            '<th>ДОСТАВКА</th>' +
                            '<th>ПЕРЕВОД</th>' +
                            '<th>БАНК</th>' +
                            '<th>ИЗМЕНИТЬ</th>' +
                            '<th>УДАЛИТЬ</th>' +
                            '</tr>';
                    }
                });
                bindMarginButtons();
            },
            deleteMargin : function(e) {
                CB.table(e.items,{
                    replace:true,
                    class:'table price-grid',
                    cells:[
                        'id',
                        function(row) {
                            return (row.company!=null) ? '<a href="#">'+row.company+'</a>' : ''
                        },
                        function(row){
                            return (row.manufacturer!=null) ? row.manufacturer : '';
                        },
                        function(row){
                            return row.min_cost+'-'+row.max_cost;
                        },
                        function(row){
                            return row.percentage+'%';
                        },
                        'fixed_cost',
                        'not_less',
                        'not_more',
                        'shipping',
                        'transfer',
                        'bank',
                        function(row){
                            return '<button class="edit margin-edit" data-id="'+row.id+'" type="button">edit</button>';
                        },
                        function(row){
                            return '<button class="delete margin-delete" data-id="'+row.id+'" type="button">delete</button>';
                        }
                    ],
                    beforeRows:function(){
                        return '<tr>' +
                            '<th class="col-id">ID</th>' +
                            '<th class="col-provider"><!--<div class="sortable desc">-->ПОСТАВЩИК<!--</div>--></th>' +
                            '<th class="col-brand"><!--<div class="sortable asc">-->БРЕНД<!--</div>--></th>' +
                            '<th>РАЗБРОС ЦЕН</th>' +
                            '<th>ПРОЦЕНТ</th>' +
                            '<th>Ф. ЗНАЧ.</th>' +
                            '<th>НЕ МЕНЕЕ</th>' +
                            '<th>НЕ БОЛЕЕ</th>' +
                            '<th>ДОСТАВКА</th>' +
                            '<th>ПЕРЕВОД</th>' +
                            '<th>БАНК</th>' +
                            '<th>ИЗМЕНИТЬ</th>' +
                            '<th>УДАЛИТЬ</th>' +
                            '</tr>';
                    }
                });
                bindMarginButtons();
            },
            getMargin : function(e) {
                CB.table(e.items,{
                    replace:true,
                    class:'table price-grid',
                    cells:[
                        'id',
                        function(row) {
                            return (row.company!=null) ? '<a href="#">'+row.company+'</a>' : ''
                        },
                        function(row){
                            return (row.manufacturer!=null) ? row.manufacturer : '';
                        },
                        function(row){
                            return row.min_cost+'-'+row.max_cost;
                        },
                        function(row){
                            return row.percentage+'%';
                        },
                        'fixed_cost',
                        'not_less',
                        'not_more',
                        'shipping',
                        'transfer',
                        'bank',
                        function(row){
                            return '<button class="edit margin-edit" data-id="'+row.id+'" type="button">edit</button>';
                        },
                        function(row){
                            return '<button class="delete margin-delete" data-id="'+row.id+'" type="button">delete</button>';
                        }
                    ],
                    beforeRows:function(){
                        return '<tr>' +
                            '<th class="col-id">ID</th>' +
                            '<th class="col-provider"><!--<div class="sortable desc">-->ПОСТАВЩИК<!--</div>--></th>' +
                            '<th class="col-brand"><!--<div class="sortable asc">-->БРЕНД<!--</div>--></th>' +
                            '<th>РАЗБРОС ЦЕН</th>' +
                            '<th>ПРОЦЕНТ</th>' +
                            '<th>Ф. ЗНАЧ.</th>' +
                            '<th>НЕ МЕНЕЕ</th>' +
                            '<th>НЕ БОЛЕЕ</th>' +
                            '<th>ДОСТАВКА</th>' +
                            '<th>ПЕРЕВОД</th>' +
                            '<th>БАНК</th>' +
                            '<th>ИЗМЕНИТЬ</th>' +
                            '<th>УДАЛИТЬ</th>' +
                            '</tr>';
                    }
                });
                bindMarginButtons();
            },
            priceExport : function(e) {
                $('#downloader').attr('src',App.options.base+'files/price/'+e);
            },
            changeAccount : function(e) {
                window.location.reload();
            },
            analitycs : function(e) {
                CB.table(e.items,{
                    replace:true,
                    class:'table analytics-grid',
                    rowClass : function(row){
                        return (row.company_price > row.avg_price_country) ? 'more' : 'less';
                    },
                    cells:[
                        'id',
                        function(row){
                            return {
                                cellClass : 'left-alignment',
                                data : row.scopename
                            };
                        },
                        'company_price',
                        'min_price_country',
                        'avg_price_country',
                        function(row){
                            console.log(row);
                            return row.percentage_country+'%';
                        },
                        'min_price_region',
                        'avg_price_region',
                        function(row){
                            return row.percentage_region+'%';
                        },
                    ],
                    beforeRows:function(){
                        return '<tr>' +
                            '<th class="col-id">ID</th>' +
                            '<th class="col-name">НАИМЕНОВАНИЕ</th>' +
                            '<th class="col-my-price">МОЯ ЦЕНА</th>' +
                            '<th class="col-min-price">МИН. ОПТ. ЦЕНА (ОСТАТОК)</th>' +
                            '<th class="col-mid-price">СРЕДНЯЯ ОПТ. ЦЕНА</th>' +
                            '<th class="col-percent">%</th>' +
                            '<th class="col-min-city-price">МИН. ОПТ. ЦЕНА РЕГИОН (ОСТАТОК)</th>' +
                            '<th class="col-mind-city-price">СРЕДНЯЯ ОПТ. ЦЕНА РЕГИОН</th>' +
                            '<th class="col-city">% РЕГИОН</th>' +
                            '</tr>';
                    }
                });
            }
        });
        App.com.import(App.options.dir + '/js/app/ajaxFormWorker.js',function(){
            new AFW();
            App.fire('AFW');
        });
        App.com.import(App.options.dir + '/js/app/contentBuilder.js',function(){
            new CB();
            App.fire('CB');
        });
    });

    App.event.handle('AFW', function(){
        AFW.catchForm('form', function(response){
            if(Object.keys(response.errors).length == 0){
                Action.process(response.action, response.completeData);
            }else{
                var errorsList = '';
                for ( var i in response.errors) {
                    errorsList += '<li>'+response.errors[i].message+'</li>';
                }
                $('#dialog-error > span.errorTitle').text('Причина ошибки:');
                $('#dialog-error > ul.errorList').html(errorsList);
                $("#dialog-error").dialog({
                    modal: true,
                    title: 'Ошибка валидации'
                });
            }
        });
        AFW.postAction(App.options.base + '?view=api&load=opt',{fnc:'company'},function(json){
            companies = json.completeData.items;
        });
    });
    if ( $('#dialog-auto') != undefined ) {
        $("#dialog-auto").dialog({
            modal: true,
            title: 'Уведомление'
        });
    }
});



$(document).ajaxStart(function(){
    $('#dialog-ajax').dialog({
        modal: true,
        title: 'Обработка'
    });
    $('#dialog-ajax #progressbar').progressbar({
        value: 0
    });
    $('#dialog-ajax span.ajaxTitle').text('Открытие соединения');
});
$(document).ajaxError(function(event,xhr,settings){
    $('#dialog-ajax #progressbar').progressbar({
        value: 15
    });
    $('#dialog-ajax span.ajaxTitle').text('Ошибка!');
});
$(document).ajaxSend(function(event,xhr,settings){
    $('#dialog-ajax #progressbar').progressbar({
        value: 15
    });
    $('#dialog-ajax span.ajaxTitle').text('Отправка');
});
$(document).ajaxSuccess(function(event,xhr,settings){
    $('#dialog-ajax #progressbar').progressbar({
        value: 50
    });
    $('#dialog-ajax span.ajaxTitle').text('Успешно');
});
$(document).ajaxComplete(function(event,xhr,settings){
    $('#dialog-ajax #progressbar').progressbar({
        value: 70
    });
    $('#dialog-ajax span.ajaxTitle').text('Завершение...');
});
$(document).ajaxStop(function(event,xhr,settings) {
    $('#dialog-ajax #progressbar').progressbar({
        value: 100
    });
    $('#dialog-ajax span.ajaxTitle').text('Готово');
    setTimeout(function(){
        $('#dialog-ajax').dialog('close');
        $('#dialog-ajax #progressbar').progressbar({
            value: 0
        });
    }, 500);
});