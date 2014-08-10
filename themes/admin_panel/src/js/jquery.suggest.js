/*!
 * Suggest jQuery plugin
 *
 * Copyright (c) 2013 Florian Plank (http://www.polarblau.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * USAGE:
 *
 * $('#container').suggest(haystack, {
 *   suggestionColor   : '#cccccc',
 *   moreIndicatorClass: 'suggest-more',
 *   moreIndicatorText : '&hellip;'
 * });
 *
 */
(function($) {

  $.fn.suggest = function(source,fnc) {

        var _this = $(this);

        // this helper will show possible suggestions
        // and needs to match the input field in style
        var $suggest = _this.parent('.suggest');

        var $clearSuggest = $suggest.find('.clearSuggest');

        var $suggestList = $suggest.find('.suggestList');

        $suggestList.hide();

        _this.bind({
            keyup:function(e){
                var matches = new Array;
                var value = $(e.target).val();
                var valueLength = value.length;
                for(key in source){
                    if(valueLength>0){
                        var pregPattern = new RegExp('^'+value, 'ig');
                        if(pregPattern.test(source[key])){
                            matches.push('<li><a data-id="'+key+'">'+source[key]+'</a></li>');
                        }
                    }
                }
                if(matches.length>0){
                    $suggestList.children('ul').find('a').unbind();
                    $suggestList.children('ul').buildSuggestListHtml(matches);
                    $suggestList.children('ul').find('a').bind({
                        click:function(e){
                            var id = $(this).attr('data-id');
                            var text = $(this).text();
                            _this.val(text);
                            $suggestList.children('ul').html('');
                            $suggestList.hide();
                            if(fnc.onmatch!=undefined){
                                fnc.onmatch({event:e,id:id,text:text});
                            }
                            return false;
                        }
                    });
                    $suggestList.show();
                }else{
                    $suggestList.children('ul').html('');
                    $suggestList.hide();
                    if(fnc.onmismatch!=undefined){
                        fnc.onmismatch();
                    }
                }
            }
        });

        $clearSuggest.bind({
            click:function(){
                _this.val('').trigger('keyup');
            }
        });
  };

    $.fn.buildSuggestListHtml = function(source) {
        var maxLength = 20;
        var _this = $(this);
        _this.html('');
        for(key in source){
            if(key<maxLength){
                _this.prepend(source[key]);
            }
        }
    };

  /* A little helper to calculate the sum of different
   * CSS properties around all four sides
   *
   * EXAMPLE:
   * $('#my-div').cssSum('padding');
   */
  $.fn.cssShortForAllSides = function(property) {
    var $self = $(this), sum = [];
    var properties = $.map(['Top', 'Right', 'Bottom', 'Left'], function(side){
      return property + side;
    });
    $.each(properties, function(i, e) {
      sum.push($self.css(e) || "0");
    });
    return sum.join(' ');
  };
})(jQuery);
