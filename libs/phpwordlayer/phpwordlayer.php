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

class phpwordlayer{

    protected $filename=null;

    public function __construct(){
        date_default_timezone_set('Europe/London');
    }

    public function setFilename($sName){
        $this->filename=$sName;
    }

    public function createDoc($items, $amount = 1)
    {
        $baseFolder = $this->filename;
        $tmpName = uniqid('price_');
        $output = $baseFolder.$tmpName.'.docx';
        require_once 'PHPWord.php';

        $PHPWord = new PHPWord();

        $section = $PHPWord->createSection();

        $styleFont = array('bold'=>true, 'size'=>24, 'name'=>'Arial');
        $styleBold = array('bold'=>true, 'name'=>'Arial');
        $styleLeft = array('align'=>'center');
        $styleParagraph = array('align'=>'center', 'spaceAfter'=>100);
        $section->addText('Коммерческое предложение', $styleFont, $styleParagraph);

        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
        $PHPWord->addTableStyle('itemTable', $styleTable, $styleFirstRow);

        $i = 0;
        foreach ( $items as $company ) {
            if ( $i > 0 ) {
                $section->addPageBreak();
            }
            $companyItem = $company[0]['company']->items;
            $companyBilling = $company[0]['company']->billing->items;

            $companyTable = $section->addTable();

            $companyTable->addRow();
            $companyCellInfo = $companyTable->addCell(7500);
            $companyCellImg = $companyTable->addCell(2500);

            $styleFontInfoHead = array('bold'=>true, 'size'=>18, 'name'=>'Arial');
            $styleFontInfoBold = array('bold'=>true, 'size'=>12, 'name'=>'Arial');
            $styleFontInfoLight = array('bold'=>false, 'size'=>12, 'name'=>'Arial');
            $styleParagraphInfo = array('align'=>'left', 'spaceAfter'=>100);

            $companyCellInfo->addText('Продавец: '. $companyItem->name, $styleFontInfoHead, $styleParagraphInfo);
            $companyCellInfo->addTextBreak();
            $companyCellInfo->addText('Информация о продавце:', $styleFontInfoBold, $styleParagraphInfo);
            $companyCellInfo->addText('Название физическое (название магазина): '.$companyBilling->shop_name, $styleFontInfoLight, $styleParagraphInfo);
            $companyCellInfo->addText('URL (сайта): '.$companyBilling->site, $styleFontInfoLight, $styleParagraphInfo);
            $companyCellInfo->addText('E-mail: '.$companyBilling->email, $styleFontInfoLight, $styleParagraphInfo);
            $companyCellInfo->addText('Контактный телефон: '.implode(', ',$companyBilling->phones), $styleFontInfoLight, $styleParagraphInfo);

            $section->addTextBreak();

            ///$companyCellImg->addImage(ROOT_DIR.'images/companies/ic_534adbf1e38e2wheel.jpg', array('width'=>50, 'height'=>50, 'align'=>'right'));

            $itemTable = $section->addTable('itemTable');
            $itemTable->addRow();
            $itemTable->addCell(7000)->addText('Наименование');
            $itemTable->addCell(150)->addText('Цена за ед. тов., грн.');
            $itemTable->addCell(150)->addText('Количество, шт.');
            $itemTable->addCell(200)->addText('Цена, грн.');
            $itemTable->addCell(2500)->addText('Изображение');
            foreach ( $company as $item ) {
                $itemTable->addRow();
                $itemTable->addCell(7000)->addText($item['item']->scopename, $styleBold, $styleLeft);
                $itemTable->addCell(150)->addText(number_format($item['item']->price_compiled,2));
                $itemTable->addCell(150)->addText($amount);
                $itemTable->addCell(200)->addText(number_format(($amount*$item['item']->price_compiled),2));
                $imageCell = $itemTable->addCell(2500);
                if ( !empty($item['item']->src) ) {
                    if ( is_file(ROOT_DIR.'images/'.$item['item']->src) ) {
                        $imageSize = $this->resizeImage(ROOT_DIR.'images/'.$item['item']->src, 150, 150);
                        $imageCell->addImage(ROOT_DIR.'images/'.$item['item']->src, array('width'=>$imageSize->w, 'height'=>$imageSize->h, 'align'=>'right'));
                    }
                }
            }
            $i++;
        }

        $section->addTextBreak(2);
        /*$section->addText('Электронная биржа шин и дисков ', array('align'=>'left'));
        $section->addLink('http://tyretrader.com.ua', 'tyretrader.com.ua');*/

        $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        $objWriter->save($output);

        return $tmpName.'.docx';
    }

    private function resizeImage($path, $maxWidth, $maxHeight)
    {
        $rawAttributes = getimagesize($path);
        $w = $rawAttributes[0];
        $h = $rawAttributes[1];
        $cW = $maxWidth;
        $cH = $maxHeight;
        if ( $w > $h ) {
            if ( $w > $maxWidth ) {
                $cW = round(($maxWidth / $w) * $w);
                $cH = round(($maxWidth / $w) * $h);
            }
        } elseif ( $w < $h ) {
            if ( $w > $maxWidth ) {
                $cW = round(($maxHeight / $h) * $w);
                $cH = round(($maxHeight / $h) * $h);
            }
        } elseif ( $w == $h ) {
            if ( $w > $maxWidth ) {
                $cW = round(($maxWidth / $w) * $w);
                $cH = $cW;
            }
        }
        return (object)array('w' => $cW, 'h' => $cH);
    }
}