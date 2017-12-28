<?php

class shopEditorPluginBackendEditortitleController extends waJsonController
{

    public function execute()
    {
        $post = waRequest::post();
        $prodModel = new shopProductModel();
        if ($post['type'] = 'metatitle') {
            foreach ($post['product_id'] as $pid) {
                $freeTempl = '';
                $finalTitle = '';
                $response = $prodModel->getById($pid);
                if (!$response['name']) {
                    $response['name'] = '0';
                }
                $pos = strpos($post['templ'],'($prod_name)');
                $name = $response['name'];
                if ($post['format'] == 'allsmall') {
                    $name = mb_strtolower($name);
                } elseif ($post['format'] == 'allbig') {
                    $name = mb_strtoupper($name);
                } elseif ($post['format'] == 'firstbig') {
                    $name = mb_convert_case($name, MB_CASE_TITLE);
                }
                if ($pos !== false) {
                    $freeTempl = str_replace('($prod_name)', $name, $post['templ']);
                }
                if (array_key_exists('addtitle', $post)) {
                    if ($post['addtitle'] == 'on') {
                        $finalTitle = $response['meta_title'];
                    }
                }
                if (strlen($freeTempl) > 0) {
                    if (strlen($finalTitle) > 0) {
                        $finalTitle .= ' ';
                    }
                    $finalTitle .= $freeTempl;
                }
                $response = $prodModel->updateByField('id', $pid, array('meta_title' => $finalTitle));
            }
            return;
        }
        return;
    }

    /**
     * Вспомогательная функция для отладки
     * 
     * @param mixed $text 
     * @return mixed 
     */
    public function lg($text)
    {
        if (is_array($text)) {
            file_put_contents('log.txt', print_r($text, true));
        } else {
            file_put_contents('log.txt', $text);
        }
    }
    
    public function mb_ucwords($str)
    { 
        $str = mb_convert_case($str, MB_CASE_TITLE, "UTF-8"); 
        return ($str); 
    } 
}