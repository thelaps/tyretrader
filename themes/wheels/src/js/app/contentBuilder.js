/**
 * Created with JetBrains PhpStorm.
 * User: noya
 * Date: 14.12.13
 * Time: 23:04
 * To change this template use File | Settings | File Templates.
 */
(function() {

    CB = (function() {

        function CB(list){
            window.CB = this;
            if(jQuery!=undefined){
                this._init();
            }else{
                alert('jQuery is off');
            }
        }

        CB.prototype._init = function(){

        };

        CB.prototype.table = function(data, attributes){
            html = '<table'+((attributes.class!=undefined)?' class="'+attributes.class+'"':'')+'>';
            var _this = this;
            if(attributes.beforeRows!=undefined){
                html += attributes.beforeRows();
            }
            for (var row in data) {
                if (data[row]!=undefined){
                    html += '<tr' + ((attributes.rowClass != undefined) ? ' class="' + attributes.rowClass(data[row]) + '" ' : '' ) + '>' + _this.cells(data[row], attributes.cells, row) + '</tr>';
                    if (attributes.appendRow!=undefined){
                        html += attributes.appendRow(data[row], row);
                    }
                }
            }
            html += '</table>';
            if(attributes.class!=undefined && attributes.replace){
                var tableClass=attributes.class.split(' ');
                tableClass = tableClass.join('.');
                $('.'+tableClass).replaceWith(html);
            }
            return html;
        };

        CB.prototype.cells = function(data, cells, index){
            var html = '';
            for (var cell in cells) {
                if(typeof(cells[cell])=='string'){
                    html += '<td><div>'+data[cells[cell]]+'</div></td>';
                }else if(typeof(cells[cell])=='function'){
                    var cellData = cells[cell](data, index);
                    if(typeof(cellData)=='object'){
                        if ( cellData.data != undefined ) {
                            html += '<td' + ((cellData.cellClass != undefined) ? ' class="' + cellData.cellClass + '" ' : '' ) + '><div>'+cellData.data+'</div></td>';
                        }
                    } else {
                        html += '<td><div>'+cellData+'</div></td>';
                    }
                }else{
                    console.log(typeof(cells[cell]));
                }
            }
            return html;
        }


        return CB;
    })();

    /**
     * Closing
     *
     * @author Geleverya Viktor <geleverya@zfort.com>
     */
    this.CB = CB;

}).call(this);