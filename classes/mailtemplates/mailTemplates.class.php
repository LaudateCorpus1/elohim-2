<?php

class MailTemplates {
    public function __construct() {
    }

    public function mergeTemplate($template, $params) {
        $tpl = $this->loadTemplate($template);
        if (!$tpl)
            return false;

        foreach ($params as $key => $val) {
            $tpl['html'] = str_replace('%%'.$key.'%%', $val, $tpl['html']);
            $tpl['text'] = str_replace('%%'.$key.'%%', $val, $tpl['text']);
        }

        return $tpl;
    }

    private function loadTemplate($template) {
        $file = CLASS_PATH.'mailTemplates/templates/'.$template.'.template.php';
        if (file_exists($file)) {
            @include($file);
            if (!isset($html) || !isset($text))
                return false;
            return array('html' => $html, 'text' => $text);
        } else {
            return false;
        }
    }
}