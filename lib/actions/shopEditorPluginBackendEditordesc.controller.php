<?php

class shopEditorPluginBackendEditordescController extends waJsonController
{

    public function execute()
    {
        $post = waRequest::post();
        $prodModel = new shopProductModel();
        if ($post['type'] = 'metadesc') {
            foreach ($post['product_id'] as $pid) {
                $freeTempl = '';
                $finalDesc = '';
                $response = $prodModel->getById($pid);
                if (!$response['name']) {
                    $response['name'] = '0';
                }
                $pos = strpos($post['templ'],'($prod_name)');
                if ($pos !== false) {
                    $freeTempl = str_replace('($prod_name)', $response['name'], $post['templ']);
                }
                if (array_key_exists('adddesc', $post)) {
                    if ($post['adddesc'] == 'on') {
                        $finalDesc = $response['meta_description'];
                    }
                }
                if (strlen($freeTempl) > 0) {
                    if (strlen($finalDesc) > 0) {
                        $finalDesc .= ' ';
                    }
                    $finalDesc .= $freeTempl;
                }
                $response = $prodModel->updateByField('id', $pid, array('meta_description' => $finalDesc));
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
}