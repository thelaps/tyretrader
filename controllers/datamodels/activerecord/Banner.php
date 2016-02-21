<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 04.04.15
 * Time: 16:54
 * To change this template use File | Settings | File Templates.
 */
class Banner extends Content
{
    static $before_save = array('uploadDataFile');

    public function uploadDataFile()
    {
        if ( isset($_FILES) ) {
            $filename = $_FILES["banner_content"]["name"];
            $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
            $file_ext = $this->getFileExtension($filename); // get file name

            $newfilename = 'ba_' . md5($file_basename) . '.' . $file_ext;
            if (!file_exists(CORE_WEB_DIR . 'images' . DIRECTORY_SEPARATOR . $newfilename)) {
                move_uploaded_file($_FILES["banner_content"]["tmp_name"], CORE_WEB_DIR . 'images' . DIRECTORY_SEPARATOR . $newfilename);
                $this->content = DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $newfilename;
                return true;
            }
            return false;
        }
        return true;
    }

    private function getFileExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
}