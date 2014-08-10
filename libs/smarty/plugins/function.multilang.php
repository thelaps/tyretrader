<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {assign} compiler function plugin
 *
 * Type:     compiler function<br>
 * Name:     assign<br>
 * Purpose:  assign a value to a template variable
 * @link http://smarty.php.net/manual/en/language.custom.functions.php#LANGUAGE.FUNCTION.ASSIGN {assign}
 *       (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com> (initial author)
 * @author messju mohr <messju at lammfellpuschen dot de> (conversion to compiler function)
 * @param string containing var-attribute and value-attribute
 * @param Smarty_Compiler
 */
function smarty_function_multilang($tag_attrs, &$smarty)
{
    print_r(array($tag_attrs,$smarty));
    /*$_params = $compiler->_parse_attrs($tag_attrs);

    if (!isset($_params['ident'])) {
        $compiler->_syntax_error("assign: missing 'ident' parameter", E_USER_WARNING);
        return;
    }*/

    return "okay";//"\$this->assign({$_params['get']}, 'okay');";
}

/* vim: set expandtab: */

?>
