<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 13.09.13
 * Time: 23:57
 * To change this template use File | Settings | File Templates.
 */
class microUploader{

    private $uploadDir = null;

    public function upload($file){
        $image=$file['name'];
        $newname=uniqid('ic_').$image;
        if(move_uploaded_file($file['tmp_name'], $this->uploadDir.$image)){
            $this->addWatermark($this->uploadDir.$image,$this->uploadDir.$newname,$file['type']);
            return $newname;
        }
        return $image;
    }

    public function setUploadDir($dir){
        if(file_exists($dir)){
            $this->uploadDir = $dir;
            return true;
        }else{
            if(mkdir($dir, 0777, true)){
                $this->uploadDir = $dir;
                return true;
            }
        }
        return false;
    }

    private function addWatermark($img_name,$newname,$type){
        $src_img = null;

        if(is_file($img_name)){
            if(!strcmp("image/jpg",$type) || !strcmp("image/jpeg",$type) || !strcmp("image/pjpeg",$type)){
                $src_img=@imagecreatefromjpeg($img_name);
            }

            if(!strcmp("image/png",$type)){
                $src_img=@imagecreatefrompng($img_name);
            }

            if(!strcmp("image/gif",$type)){
                $src_img=@imagecreatefromgif($img_name);
            }

            $old_x=imageSX($src_img);
            $old_y=imageSY($src_img);

            $dst_img=ImageCreateTrueColor($old_x,$old_y);

            imagecopyresampled($dst_img,$src_img,0,0,0,0,$old_x,$old_y,$old_x,$old_y);

            $watermark_file=$this->uploadDir.'watermark.png';

            $transparency=50;

            $wext=$this->getFileExtension($watermark_file);

            $watermark = null;

            if(!strcmp("jpg",$wext) || !strcmp("jpeg",$wext)) $watermark=@imagecreatefromjpeg($watermark_file);

            if(!strcmp("png",$wext)) $watermark=@imagecreatefrompng($watermark_file);

            if(!strcmp("gif",$wext)) $watermark=@imagecreatefromgif($watermark_file);

            $watermark_width = imagesx($watermark);
            $watermark_height = imagesy($watermark);

            $dest_x = $old_x - $watermark_width - 5;
            $dest_y = $old_y - $watermark_height - 5;

            // uncomment these lines and comment the ones above if you want to place the watermark in the very center of the image
    //    $dest_x = (($thumb_w - $watermark_width)/2);
    //    $dest_y = (($thumb_h - $watermark_height)/2);

            imagecopymerge($dst_img, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $transparency);

            if(!strcmp("image/png",$type))  imagepng($dst_img,$newname);

            else if(!strcmp("image/gif",$type))  imagegif($dst_img,$newname);

            else imagejpeg($dst_img,$newname);

            imagedestroy($dst_img);
            imagedestroy($src_img);
            unlink($img_name);
        }
    }

    private function getFileExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
}