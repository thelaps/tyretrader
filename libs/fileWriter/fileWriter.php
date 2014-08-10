<?php
/**
 * Created by JetBrains PhpStorm.
 * User: noya
 * Date: 03.05.13
 * Time: 14:43
 * To change this template use File | Settings | File Templates.
 */
class fileWriter{

    public $absolutePath=null;

    public function write($name,$dir,$byte){
        if ($fp = fopen($dir.'/'.$name, 'w')) {
            $startTime = microtime();
            do {
                $canWrite = flock($fp, LOCK_EX);
                // Если не можем поставить блокировку flock то ждем 0 - 100 миллисекунд, ждем чтобы избежать загрузку процесса
                if(!$canWrite) usleep(round(rand(0, 100)*1000));
            } while ((!$canWrite)and((microtime()-$startTime) < 1000));

            //Файл заблокирован flock, теперь мы можем сделать запись
            if ($canWrite) {
                fwrite($fp, $byte);
            }
            fclose($fp);
            $this->absolutePath=$dir.'/'.$name;
        }
    }
}