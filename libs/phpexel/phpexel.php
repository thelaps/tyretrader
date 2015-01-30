<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 12.01.14
 * Time: 22:01
 * To change this template use File | Settings | File Templates.
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('memory_limit', '-1');
set_time_limit(0);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

class phpexel{

    protected $filename=null;

    public function __construct(){

        date_default_timezone_set('Europe/London');

    }

    public function setFilename($sName){
        $this->filename=$sName;
    }

    public function process($isRaw=true){
        $json = null;
        /** Include PHPExcel_IOFactory */
        require_once 'PHPExcel/IOFactory.php';
        if ( $this->filename != null ) {
            $json = phpexel::load($this->filename);
        }

        return $json;
    }

    public static function load($filename)
    {
        $excelCollection = array();

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $sheetsNames = $objPHPExcel->getSheetNames();

        foreach ( $sheetsNames as $name ) {
            $sheetObj = $objPHPExcel->getSheetByName($name);
            $highestRow = $sheetObj->getHighestDataRow();
            //$highestColumn = PHPExcel_Cell::columnIndexFromString($sheetObj->getHighestDataColumn());
            $_cells = phpexel::getAllData($objPHPExcel->getSheetByName($name), $highestColumn);
            $excelCollection[] = array(
                'numRows'=>$highestRow,
                'numCols'=>$highestColumn,
                'maxrow'=>0,
                'maxcol'=>0,
                'name' => $name,
                'cells' => $_cells
            );
        }
        return json_encode($excelCollection);
    }

    private static function getAllData($sheetObj, &$highestColumn)
    {
        $_maxLength = 0;
        $_keys = array();
        $dataTmp = array();
        $data = array();

        $highestRow = $sheetObj->getHighestDataRow();
        $highestColumn = PHPExcel_Cell::columnIndexFromString($sheetObj->getHighestDataColumn());

        for ( $row = 1; $row <= $highestRow; $row++) {
            $_maxLengthTmp = 0;
            for ( $head = 0; $head < $highestColumn; $head++ ) {
                $tmpValue = $sheetObj->getCellByColumnAndRow($head, $row)->getValue();
                if ( $tmpValue instanceof PHPExcel_RichText ) {
                    $tmpValue = $tmpValue->getPlainText();
                }
                $dataTmp[$row][$head+1] = trim(str_replace(chr(194).chr(160), '',$tmpValue));
                if (strlen($dataTmp[$row][$head+1]) > 0) {
                    $_maxLengthTmp = $head+1;
                }
            }
            if ( $_maxLengthTmp > $_maxLength ) {
                $_maxLength = $_maxLengthTmp;
            }
        }
        $_keys = array();
        for ( $i = 1; $i < $_maxLength; $i++ ) {
            $_keys[] = $i;
        }
        foreach ($dataTmp as $row => $itemCells) {
            $tmpRow = array_slice($itemCells, 0, $_maxLength);
            foreach ( $tmpRow as $_key => $_item ) {
                $data[$row][$_key+1] = $_item;
            }
        }
        $highestColumn = $_maxLength;

        return $data;
    }

    private static function cellsOffsetLength(&$_maxLength, $_row)
    {

    }

    public function createCsv($items, $post)
    {
        $baseFolder = $this->filename;
        $tmpName = uniqid('price_');
        $output = $baseFolder.$tmpName.'.csv';
        $extras = Helper::extras();
        if ( $this->filename != null ) {
            $sheetKey = 0;
            $csvArray = array();
            foreach ( $items->items as $typeKey => $sheetItem ) {
                $rowKey = 1;
                foreach ( $sheetItem as $cellItems ) {
                    if (isset($post['export'][$cellItems->manufacturer_type])) {
                        foreach ($post['export'][$cellItems->manufacturer_type] as $attribute => $need) {
                            $attributeAlias = array('company' => 'company_id');
                            $lastAttribute = (array_key_exists($attribute, $attributeAlias)) ? $attributeAlias[$attribute] : $attribute;
                            if ( array_key_exists($lastAttribute, $cellItems->attributes()) ) {
                                $rawValue = $cellItems->read_attribute($lastAttribute);
                                $completedValue = '';
                                switch ($attribute) {
                                    case 'color':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'technology':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'spike':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'marking':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'currency':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'season':
                                        $know = array('', 'Зима', 'Лето', 'Всесезонка');
                                        if ( !empty($rawValue) ) {
                                            $completedValue = $know[$rawValue];
                                        }
                                        break;
                                    case 'type_transport':
                                        $know = array('', 'Легковой/4x4', 'Легкогрузовой', 'Индустриальный', 'Грузовой', 'Мото');
                                        if ( !empty($rawValue) ) {
                                            $completedValue = $know[$rawValue];
                                        }
                                        break;
                                    case 'manufacturer_wheel_type':
                                        $know = array('', 'Стальной', 'Литой', 'Кованый', 'Составной');
                                        if ( !empty($rawValue) ) {
                                            $completedValue = $know[$rawValue];
                                        }
                                        break;
                                    case 'date':
                                        $completedValue = date('d.m.Y', $rawValue);
                                        break;
                                    case 'company':
                                        $company = Company::getCompanyById($rawValue);
                                        $completedValue = $company->items->name;
                                        break;
                                    case 'src':
                                        if ( !empty($rawValue) ) {
                                            if ( is_file(ROOT_DIR.'images/'.$rawValue) ) {
                                                $completedValue = ROOT_DIR.'images/'.$rawValue;
                                            }
                                        }
                                        break;
                                    default:
                                        $completedValue = $rawValue;
                                        break;
                                }
                                $encoding = mb_detect_encoding( $completedValue, "auto" );
                                $csvArray[$rowKey][] = mb_convert_encoding( $completedValue, 'Windows-1251', $encoding);
                            }
                        }
                        $rowKey++;
                    } else {

                    }
                }
                $sheetKey++;
            }

            $fp = fopen($output, 'w');
            foreach ($csvArray as $fields) {
                fputcsv($fp, $fields, ';');
            }
            fclose($fp);

            return $tmpName.'.csv';
        }
    }

    public function createXlsx($items, $post)
    {
        $baseFolder = $this->filename;
        $tmpName = uniqid('price_');
        $output = $baseFolder.$tmpName.'.xlsx';

        $extras = Helper::extras();

        require_once 'PHPExcel/IOFactory.php';
        if ( $this->filename != null && isset($items->items) ) {
            /** PHPExcel */
            require_once('PHPExcel.php');

            /** PHPExcel_Writer_Excel2007 */
            require_once('PHPExcel/Writer/Excel2007.php');

// Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

// Set properties
            $objPHPExcel->getProperties()->setCreator("TyreTrader");
            $objPHPExcel->getProperties()->setLastModifiedBy("TyreTrader");
            $objPHPExcel->getProperties()->setTitle("Export of price");
            $objPHPExcel->getProperties()->setSubject("Export of price");
            $objPHPExcel->getProperties()->setDescription("Export of price");

            $sheetKey = 0;
            $cellPrefix = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $types = array(1=>'Шины', 2=>'Диски');
            $translations = array(
                'manufacturer' => 'Бренд',
                'model' => 'Модель',
                'scopename' => 'Наименование',
                'size_w' => 'Ширина',
                'size_h' => 'Высота',
                'size_r' => 'Диаметр',
                'pcd_1' => 'PCD1',
                'pcd_2' => 'PCD2',
                'et' => 'Вылет (ET)',
                'dia' => 'Диаметр ступицы (DIA)',
                'color' => 'Цвет',
                'manufacturer_wheel_type' => 'Тип диска',
                'bolt' => 'Крепеж',
                'date' => 'Дата обновления склада',
                'stock_1' => 'Остаток',
                'price_1' => 'Оптовая цена',
                'price_compiled' => 'Розничная цена',
                'company' => 'Поставщик',
                'city' => 'Город',
                'id' => 'Артикул',
                'src' => 'Изображение',
                'season' => 'Сезон',
                'type_transport' => 'Тип транспортного средства',
                'si_f' => 'Индекс скорости',
                'sw_f' => 'Индекс нагруженности',
                'technology' => 'Усиленная шина',
                'spike' => 'шип/нешип'
            );
            foreach ( $items->items as $typeKey => $sheetItem ) {
                $objPHPExcel->setActiveSheetIndex($sheetKey);
                $activeSheet = $objPHPExcel->getActiveSheet();
                $rowKey = 1;
                foreach ( $sheetItem as $cellItems ) {
                    $cellKey = 0;
                    if (isset($post['export'][$cellItems->manufacturer_type])) {
                        foreach ($post['export'][$cellItems->manufacturer_type] as $attribute => $need) {
                            $attributeAlias = array('company' => 'company_id');
                            $lastAttribute = (array_key_exists($attribute, $attributeAlias)) ? $attributeAlias[$attribute] : $attribute;
                            if ( array_key_exists($lastAttribute, $cellItems->attributes()) ) {
                                if ( $rowKey == 1 ) {
                                    $activeSheet->SetCellValue($cellPrefix[$cellKey].$rowKey, $translations[$attribute]);
                                }
                                $rawValue = $cellItems->read_attribute($lastAttribute);
                                $completedValue = '';
                                switch ($attribute) {
                                    case 'color':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'technology':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'spike':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'marking':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'currency':
                                        $completedValue = Helper::getObjBy($rawValue, $extras[$attribute], $attribute);
                                        break;
                                    case 'season':
                                        $know = array('', 'Зима', 'Лето', 'Всесезонка');
                                        if ( !empty($rawValue) ) {
                                            $completedValue = $know[$rawValue];
                                        }
                                        break;
                                    case 'type_transport':
                                        $know = array('', 'Легковой/4x4', 'Легкогрузовой', 'Индустриальный', 'Грузовой', 'Мото');
                                        if ( !empty($rawValue) ) {
                                            $completedValue = $know[$rawValue];
                                        }
                                        break;
                                    case 'manufacturer_wheel_type':
                                        $know = array('', 'Стальной', 'Литой', 'Кованый', 'Составной');
                                        if ( !empty($rawValue) ) {
                                            $completedValue = $know[$rawValue];
                                        }
                                        break;
                                    case 'date':
                                        $completedValue = date('d.m.Y', $rawValue);
                                        break;
                                    case 'company':
                                        $company = Company::getCompanyById($rawValue);
                                        $completedValue = $company->items->name;
                                        break;
                                    case 'src':
                                        if ( !empty($rawValue) ) {
                                            if ( is_file(ROOT_DIR.'images/'.$rawValue) ) {
                                                $completedValue = ROOT_DIR.'images/'.$rawValue;
                                            }
                                        }
                                        break;
                                    case 'price_1':
                                        $completedValue = round($rawValue, 0);
                                        break;
                                    case 'price_compiled':
                                        $completedValue = round($rawValue, 0);
                                        break;
                                    default:
                                        $completedValue = $rawValue;
                                        break;
                                }
                                $activeSheet->SetCellValue($cellPrefix[$cellKey].($rowKey+1), $completedValue);
                                $cellKey++;
                            }
                        }
                        $rowKey++;
                    } else {

                    }
                }
                $activeSheet->setTitle($types[((isset($post['typeKey'])) ? $post['typeKey'] : $typeKey)]);

                $sheetKey++;
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($output);

            return $tmpName.'.xlsx';
        }
    }

    public function createDoc($items, $amount = 1)
    {
        $headXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><w:document xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"><w:body>';

        $footerXML = '<w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:divId w:val="68965344"/></w:pPr><w:r><w:br/></w:r><w:r><w:rPr><w:i/><w:iCs/></w:rPr><w:t xml:space="preserve">Электронная биржа шин и дисков </w:t></w:r><w:hyperlink r:id="rId7" w:history="1"><w:r><w:rPr><w:rStyle w:val="Hyperlink"/><w:i/><w:iCs/></w:rPr><w:t>tyretrader.com.ua</w:t></w:r></w:hyperlink></w:p><w:sectPr w:rsidR="004F4963" w:rsidSect="004F4963"><w:pgSz w:w="11906" w:h="16838"/><w:pgMar w:top="1134" w:right="850" w:bottom="1134" w:left="1701" w:header="708" w:footer="708" w:gutter="0"/><w:cols w:space="708"/><w:docGrid w:linePitch="360"/></w:sectPr></w:body></w:document>';

        $companyXML = '<w:tbl><w:tblPr><w:tblW w:w="5000" w:type="pct"/><w:tblCellSpacing w:w="0" w:type="dxa"/><w:tblCellMar><w:left w:w="0" w:type="dxa"/><w:right w:w="0" w:type="dxa"/></w:tblCellMar><w:tblLook w:val="0000"/></w:tblPr><w:tblGrid><w:gridCol w:w="7016"/><w:gridCol w:w="2339"/></w:tblGrid><w:tr w:rsidR="004F4963"><w:trPr><w:divId w:val="68965344"/><w:tblCellSpacing w:w="0" w:type="dxa"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:gridSpan w:val="2"/><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:pStyle w:val="Heading1"/><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr><w:t>Коммерческое предложение</w:t></w:r></w:p><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr></w:pPr></w:p></w:tc></w:tr><w:tr w:rsidR="004F4963"><w:trPr><w:divId w:val="68965344"/><w:tblCellSpacing w:w="0" w:type="dxa"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:pStyle w:val="Heading2"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr><w:t>Продавец: {companyName}</w:t></w:r></w:p><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:spacing w:after="240"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:b/><w:bCs/></w:rPr><w:t xml:space="preserve">Информация о продавце: </w:t></w:r><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr><w:br/><w:t>Название физическое (название магазина): {shopName}</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr><w:br/><w:t xml:space="preserve">URL (сайта): {site}</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr><w:br/><w:t xml:space="preserve">E-mail: </w:t></w:r><w:smartTag w:uri="urn:schemas-microsoft-com:office:smarttags" w:element="PersonName"><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr><w:t>{email}</w:t></w:r></w:smartTag><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr><w:br/><w:t>Контактный телефон: {phones}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1250" w:type="pct"/><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/></w:rPr></w:r></w:p></w:tc></w:tr></w:tbl>';

        $itemHolderXML = '<w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:divId w:val="68965344"/><w:rPr><w:vanish/></w:rPr></w:pPr></w:p><w:tbl><w:tblPr><w:tblW w:w="5000" w:type="pct"/><w:tblCellSpacing w:w="7" w:type="dxa"/><w:tblBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tblBorders><w:tblCellMar><w:left w:w="0" w:type="dxa"/><w:right w:w="0" w:type="dxa"/></w:tblCellMar><w:tblLook w:val="0000"/></w:tblPr><w:tblGrid><w:gridCol w:w="2849"/><w:gridCol w:w="1413"/><w:gridCol w:w="1278"/><w:gridCol w:w="822"/><w:gridCol w:w="3051"/></w:tblGrid><w:tr w:rsidR="004F4963"><w:trPr><w:divId w:val="68965344"/><w:tblCellSpacing w:w="7" w:type="dxa"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>Наименование</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>Цена за ед. тов., грн.</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>Количество, шт.</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>Цена, грн.</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>Изображение</w:t></w:r></w:p></w:tc></w:tr>{items}</w:tbl>';

        $itemXML = '<w:tr w:rsidR="004F4963"><w:trPr><w:divId w:val="68965344"/><w:tblCellSpacing w:w="7" w:type="dxa"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRPr="009A6935" w:rsidRDefault="004F4963"><w:pPr><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/><w:lang w:val="en-US"/></w:rPr></w:pPr><w:r w:rsidRPr="009A6935"><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/><w:lang w:val="en-US"/></w:rPr><w:t>{naming}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>{cost}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>{amount}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t>{price}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="0" w:type="auto"/><w:tcBorders><w:top w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="6" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="6" w:space="0" w:color="auto"/></w:tcBorders><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="004F4963" w:rsidRDefault="004F4963"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr>{imgXml}</w:r></w:p></w:tc></w:tr>';

        $priceXML = $headXML;

        $relXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId8" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/fontTable" Target="fontTable.xml"/><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/webSettings" Target="webSettings.xml"/><Relationship Id="rId7" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="http://tyretrader.com.ua" TargetMode="External"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/settings" Target="settings.xml"/><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>{relImages}<Relationship Id="rId9" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme" Target="theme/theme1.xml"/></Relationships>';
        $itemRelXML = '<Relationship Id="rIdItem{relId}" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="{relImage}" TargetMode="External"/>';
        $itemHolderRelXML = '';

        $testArray = array();

        $collectedIds = array();

        foreach ( $items as $company ) {
            $TMPcompanyXML = $companyXML;
            $companyItem = $company[0]['company']->items;
            $companyBilling = $company[0]['company']->billing->items;
            $TMPcompanyXML = str_replace('{companyName}', $companyItem->name, $TMPcompanyXML);
            $TMPcompanyXML = str_replace('{shopName}', $companyBilling->shop_name, $TMPcompanyXML);
            $TMPcompanyXML = str_replace('{site}', $companyBilling->site, $TMPcompanyXML);
            $TMPcompanyXML = str_replace('{email}', $companyBilling->email, $TMPcompanyXML);
            $TMPcompanyXML = str_replace('{phones}', implode(', ',$companyBilling->phones), $TMPcompanyXML);
            $itemsXML = '';

            $testArray[$companyItem->name] = array(
                $companyItem,
                $companyBilling
            );

            foreach ( $company as $item ) {
                $TMPitemXML = $itemXML;
                $TMPitemRelXML = $itemRelXML;
                $TMPitemXML = str_replace('{naming}', $item['item']->scopename ,$TMPitemXML);
                $TMPitemXML = str_replace('{cost}', number_format($item['item']->price_compiled,2) ,$TMPitemXML);
                $TMPitemXML = str_replace('{amount}', $amount ,$TMPitemXML);
                $TMPitemXML = str_replace('{price}', number_format(($amount*$item['item']->price_compiled),2) ,$TMPitemXML);
                if ( !empty($item['item']->src) ) {
                    $imgSrcXML = '<w:pict><v:shape id="_x0000_i1026" type="#_x0000_t75" style="width:3in;height:3in"><v:imagedata r:id="rIdItem'.$item['item']->id.'"/></v:shape></w:pict>';
                    $TMPitemXML = str_replace('{imgXml}', $imgSrcXML ,$TMPitemXML);
                    if ( !in_array($item['item']->id, $collectedIds) ) {
                        $srcXML = str_replace('{relImage}', App::getConfig('baseLink').'/images/'.$item['item']->src, $TMPitemRelXML);
                        $srcXML = str_replace('{relId}', $item['item']->id, $srcXML);
                        $itemHolderRelXML .= $srcXML;
                        $collectedIds[] = $item['item']->id;
                    }
                } else {
                    $TMPitemXML = str_replace('{imgXml}', '' ,$TMPitemXML);
                }
                $testArray[$companyItem->name]['item'][] = $item['item'];
                $itemsXML .= $TMPitemXML;
            }
            $TMPitemHolderXML = str_replace('{items}', $itemsXML, $itemHolderXML);
            $priceXML .= $TMPcompanyXML.$TMPitemHolderXML;
        }
        $relXML = str_replace('{relImages}', $itemHolderRelXML, $relXML);
        $priceXML .= $footerXML;

        $testArray[$companyItem->name]['XMLS'] =array(
            $priceXML,
            $relXML
        );

        //print_r($testArray);
        //die();
        return $this->compressToDocx($priceXML, $relXML);
    }

    private function compressToDocx($priceXML, $relXML)
    {
        $baseFolder = $this->filename;
        $tmpName = uniqid('price_');
        $folder = $baseFolder.$tmpName.'/';
        $output = $baseFolder.$tmpName.'.docx';

        $this->cloneStruct($baseFolder.'template/', $folder);

        $this->pushDocument($folder, $priceXML);
        $this->pushRelation($folder, $relXML);

        if (!extension_loaded('zip') || !file_exists($folder)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($output, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($folder));
        $flag='';
        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $file = str_replace('\\', '/', realpath($file));

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $flag.$file . '/'));
                } else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString($flag.basename($source), file_get_contents($source));
        }
        $zip->close();

        $this->rm($folder);

        return $tmpName.'.docx';
    }

    private function rm($folder)
    {
        $files = array_diff(scandir($folder), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$folder/$file")) ? $this->rm("$folder/$file") : unlink("$folder/$file");
        }
        return rmdir($folder);
    }

    private function pushDocument($folder, $priseXML)
    {
        unlink($folder . 'word/document.xml');
        $file = @fopen($folder . 'word/document.xml','x');
        if ( $file ) {
            fwrite($file, $priseXML);
            fclose($file);
        }
    }

    private function pushRelation($folder, $relXML)
    {
        unlink($folder . 'word/_rels/document.xml.rels');
        $file = @fopen($folder . 'word/_rels/document.xml.rels','x');
        if ( $file ) {
            fwrite($file, $relXML);
            fclose($file);
        }
    }

    private function cloneStruct($src,$dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->cloneStruct($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}