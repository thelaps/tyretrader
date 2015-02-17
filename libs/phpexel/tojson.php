<?php
/**
 * @author Geleverya Viktor <geleverya@zfort.com>
 * @link http://www.zfort.com/
 * @copyright Copyright &copy; 2000-2013 Zfort Group
 * @license http://www.zfort.com/terms-of-use
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('memory_limit', '-1');
set_time_limit(0);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** Include PHPExcel_IOFactory */
require_once 'PHPExcel/IOFactory.php';

if ( isset($_FILES['file']) ) {
    $info = pathinfo($_FILES['file']['name']);
    $ext = '.' . $info['extension']; // get the extension of the file
    $newname = uniqid('p_');

    $target = __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $newname;
    if ( move_uploaded_file( $_FILES['file']['tmp_name'], $target . $ext ) ) {
        $file = @fopen($target . '.json','x');
        $json = toJson::load($target . $ext);
        if ( $file && !empty($json) ) {
            fwrite($file, $json);
            fclose($file);
        }
        print 'phpexel'. DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR .$newname . '.json';
    }
}

class toJson{
    public static function load($filename)
    {
        $excelCollection = array();

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $sheetsNames = $objPHPExcel->getSheetNames();

        foreach ( $sheetsNames as $name ) {
            $excelCollection[] = array(
                'name' => $name,
                'data' => toJson::getAllData($objPHPExcel->getSheetByName($name))
            );
        }
        return json_encode($excelCollection);
    }

    private static function getAllData($sheetObj)
    {
        $data = array();

        $highestRow = $sheetObj->getHighestRow();
        $highestColumn = PHPExcel_Cell::columnIndexFromString($sheetObj->getHighestColumn());

        for ( $row = 1; $row <= $highestRow; $row++) {
            for ( $head = 0; $head < $highestColumn; $head++ ) {
                $tmpValue = $sheetObj->getCellByColumnAndRow($head, $row)->getValue();
                if ( $tmpValue instanceof PHPExcel_RichText ) {
                    $tmpValue = $tmpValue->getPlainText();
                }
                $data[$row-1][] = str_replace('_', ' ', $tmpValue);
            }
        }
        return $data;
    }
}