/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 02.03.13
 * Time: 18:07
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){
    $('.tabHolder').tabManager();
    $('.icon-toggle').toggler();
});

$.fn.tabManager = function(){
    var object = $(this);
    var btns = object.find('> ul li');
    var tabs = object.find('.tab');
    btns.bind({
        click:function(){
            btns.removeClass('active');
            $(this).addClass('active');
            var index=$(this).index();
            tabs.removeClass('active');
            tabs.eq(index).addClass('active');
            return false;
        }
    });
};

$.fn.toggler = function(){
    var object = $(this).parent('div');
    object.bind({
        click:function(){
            var rows = object.closest('table').find('tr');

            rows.filter('.toggler').hide();
            rows.removeClass('active');
            object.children('i.icon').removeClass('active');
            $(this).children('i.icon').addClass('active');
            $(this).closest('tr').addClass('active');
            $(this).closest('tr').next().show();


        }
    });
    var togglers = $('.toggler');
}