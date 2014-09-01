<?php
/**
 * Created by PhpStorm.
 * User: geleverya
 * Date: 26.08.14
 * Time: 22:49
 */
class helper{

    static $templatePath = 'themes/notifications';
    private $template;

    public function __construct()
    {
        require_once(CORE_DIR . '../libs/smarty/Smarty.class.php');
        $this->template = new Smarty();
        $this->template->compile_check = true;
        $this->template->force_compile = false;
        $this->template->debugging = false;
        $this->template->template_dir = helper::$templatePath;
        $this->template->compile_dir = helper::$templatePath.'/cache';
    }

    public function sendMail($template, $to, $subj, $data)
    {
        $headers = "Content-type: text/html; charset=UTF-8 \r\n";
        $headers .= "From: No reply <noreply@release.pp.ua>\r\n";
        $headers .= "Bcc: noreply@release.pp.ua\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        $this->template->assign('data', $data);
        $view = $this->template->fetch(strtolower($template).'.tpl');
        mail($to, $subj, $view, $headers);
    }

    public function getTemplatePath($template)
    {
        return helper::$templatePath.'/'.strtolower($template).'.tpl';
    }
}