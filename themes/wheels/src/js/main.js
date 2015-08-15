// Document ready
$(document).ready(function(){
    jcf.customForms.replaceAll();
    $('select').select2({

    });

    $('[data-role="tabs"]').tabsManager();
    $('[data-role="switcher"]').radioSwitcher();
    $('[data-role="seasons"]').seasonChooser();
    $('.blockToggle').blockToggle();

    $('#to-top').click(function(){
        $('html, body').animate({
            scrollTop: 0
        }, 300);
        return false;
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
    // class="dataFilter" data-filter="#modelTab_1"
    $('.dataFilter').each(function(){
        $(this).bind({
            change: function(){
                var id = $(this).val();
                var filter = $($(this).attr('data-filter'));
                if(id==''){
                    filter.children().each(function(){
                        $(this).show().removeAttr('disabled');
                    });
                } else {
                    var needed = filter.find('[data-manufacturer="'+id+'"]');
                    filter.children().each(function(){
                        $(this).hide().attr('disabled', true);
                    });
                    needed.each(function(){
                        $(this).show().removeAttr('disabled');
                    });
                }
                filter.select2();
            }
        });
    });
    $('.cityFilter').each(function(){
        $(this).bind({
            change: function(e){
                var id = $(this).val();
                var filter = $($(this).attr('data-filter'));
                console.log(e, id, filter);
                if(id==''){
                    filter.children().each(function(){
                        $(this).show().removeAttr('disabled');
                    });
                }else{
                    var needed = filter.find('[data-city="'+id+'"]');
                    filter.children().each(function(){
                        $(this).hide().attr('disabled', true);
                    });
                    needed.each(function(){
                        $(this).show().removeAttr('disabled');
                    });
                }
                filter.select2();
            }
        });
    });
    $('.createPriceList').bind({
        click: function(e){
            var formData = $('.tabs-holder .tab.active form').serializeArray();
            for ( var field in formData ) {
                if ( formData[field].name == 'fnc' ) {
                    formData[field].value = 'xlsCatalog';
                }
            }
            formData.push({
                name: 'catalogAmounts',
                value: $('#catalogAmounts').val()
            });
            var action = App.options.base + '?view=api&load=opt';
            //?view=api&load=opt
            //?view=api&load=xlsCatalog
            $.post(action, formData, function(data, status){
                var jsonString = $(data).text();
                var json = $.parseJSON(jsonString);
                if(status=='success'){
                    $('#downloader').attr('src',App.options.base+'files/price/'+json.completeData);
                }else{
                    alert('Серверная ошибка!');
                }
            });
            console.log('PL');
            return false;
        }
    });
    $('.sidebar-widget').find('a').each(function(){
        $(this).bind({
            click: function(){
                var _parent = $(this).parent();
                var _self = $(this);
                var _list = _parent.children('ul');
                if ( _list.length > 0 ) {
                    _list.slideToggle();
                    return false;
                } else {
                    if ( _self.attr('data-tab') != undefined ) {
                        var index = _parent.index();
                        $(_self.attr('data-tab')+' ul li').eq(index).click();
                        _parent.parent().children('li').each(function(){
                            $(this).children('a').removeClass('active');
                        });
                        _self.addClass('active');
                        return false;
                    }
                }
            }
        });
    });
    $('.alterLocation').bind({
        change: function(){
            window.location=$(this).val();
        }
    });
});

$(function() {
    $('.movable').each(function(){
        $(this).children('ul').sortable();
        $(this).children('ul').disableSelection();
        $(this).find('input').each(function(){
            $(this).bind({
                change: function(){
                    var isActive = $(this).is(':checked');
                    if (isActive) {
                        $(this).parent().addClass('active');
                    } else {
                        $(this).parent().removeClass('active');
                    }
                }
            });
        });
    });
});

function prepareUserToChangeType(_obj) {
    var _self = $(_obj);
    var _changer = _self.closest('form').find('.accountChanger');
    var _enable = _self.is(':checked');
    _changer.each(function(){
        var _item = $(this);
        if ( _enable ) {
            _item.removeAttr('disabled');
        } else {
            _item.attr('disabled', true);
        }
    });
}

(function($) {
    function setActiveTab(tabs, index) {
        tabs.removeClass('active')
            .css('display', 'none')
            .eq(index)
            .addClass('active')
            .css('display', 'block');
    }
    $.fn.seasonChooser = function(){
        this.each(function(){
            var _owner = $(this);
            _owner.find(':checkbox').each(function(){
                var _self = $(this);
                _self.on({
                    change:function(){
                        var season = _self.val();
                        if (_self.is(':checked')) {
                            switch (season) {
                                case '2':
                                    _owner.find(':checkbox').each(function(){
                                        var _mask = $(this).parent().children('.chk-area');
                                        var _label = $(this).parent().children('label');
                                        if ($(this).val()=='1') {
                                            _mask.removeClass('chk-checked');
                                            _mask.addClass('chk-unchecked');
                                            _label.removeClass('chk-label-active');
                                            $(this).removeAttr('checked');
                                        }
                                    });
                                    break;
                                case '1':
                                    _owner.find(':checkbox').each(function(){
                                        var _mask = $(this).parent().children('.chk-area');
                                        var _label = $(this).parent().children('label');
                                        if ($(this).val()=='2') {
                                            _mask.removeClass('chk-checked');
                                            _mask.addClass('chk-unchecked');
                                            _label.removeClass('chk-label-active');
                                            $(this).removeAttr('checked');
                                        }
                                    });
                                    break;/*
                                case '3':
                                    if ($(this).val()!='3') {
                                        $(this).removeAttr('checked');
                                    }
                                    break;*/
                            }
                        } else {

                        }
                    }
                });
            })
        });

    };
    $.fn.tabsManager = function(){
        return this.each(function(){
            var tabsHolder = $(this),
                buttons = tabsHolder.find('> ul li'),
                tabs    = tabsHolder.find('[data-role="tab"]'),
                activeTabIndex = buttons.filter('.active').index() || 0;
            setActiveTab(tabs, activeTabIndex);
            buttons.on('click', function(){
                var $this = $(this),
                    index = buttons.index(this);
                if ($this.hasClass('active')) return;

                $this.addClass('active').siblings().removeClass('active');
                setActiveTab(tabs, index);
                if ( $this.attr('data-action') != undefined ) {
                    var action = $this.attr('data-action');
                    switch(action){
                        case 'submit':
                            tabs.eq(index).find('button[type="submit"]').click();
                            break;
                        case 'get':
                            var form = tabs.eq(index).find('form');
                            var url = form.attr('action');
                            var target = $($this.attr('data-target'));
                            $.get(url, function(data){
                                console.log(data);
                            });
                            break;
                        case 'post':
                            var form = tabs.eq(index).find('form');
                            var url = form.attr('action');
                            var target = $($this.attr('data-target'));
                            var formData = {
                                'fnc':'getByType',
                                'calculator':{
                                    'type':(index == 0) ? 'wholesale' : 'retail'
                                }
                            };
                            $.post(url, formData, function(data){
                                var json = AFW.ajax(data);
                                Action.process('getMargin', json.completeData);
                            });
                            break;
                    }
                }
            });
        });
    };
    $.fn.blockToggle = function(){
        return this.each(function(){
            var _self = $(this);
            _self.on({
                change:function(){
                    var block = _self.attr('data-block');
                    if(_self.is(':checked')){
                        $(block).show();
                    }else{
                        $(block).hide();
                    }
                }
            })
        });
    };
    $.fn.radioSwitcher = function() {
        return this.each(function(){
            var switcher = $(this),
                groupName = switcher.data('name'),
                allTargets = switcher.parents('form').find('[data-name="'+groupName+'"]').not(switcher),
                activeTarget = switcher.find('input:checked').data('target'),
                form = switcher.parents('form');

            allTargets.not(activeTarget).css('display', 'none');
            form.on('reset', function() {
                allTargets.css('display', 'none').filter(activeTarget).css('display', 'block');
            });
            $(this).on('click', 'input:radio', function() {
                var radioBtn = $(this),
                    target = radioBtn.data('target');
                if (!target) return;
                allTargets.css('display', 'none').filter(target).css('display', 'block');
            });
        });
    };
}(jQuery));
