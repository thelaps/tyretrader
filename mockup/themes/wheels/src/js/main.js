// Document ready
$(document).ready(function(){
    jcf.customForms.replaceAll();

    $('[data-role="tabs"]').tabsManager();
    $('[data-role="switcher"]').radioSwitcher();

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
});

(function($) {
    function setActiveTab(tabs, index) {
        tabs.removeClass('active')
            .css('display', 'none')
            .eq(index)
            .addClass('active')
            .css('display', 'block');
    }
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
            });
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
