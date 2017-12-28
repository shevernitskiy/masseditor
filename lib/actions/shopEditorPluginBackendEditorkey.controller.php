<?php

class shopEditorPluginBackendEditorkeyController extends waJsonController
{

    public function execute()
    {
        $post = waRequest::post();
        $prodModel = new shopProductModel();
        if ($post['type'] = 'metakey') {
            self::lg($post); 
            foreach ($post['product_id'] as $pid) {
                $freeTempl = '';
                $colorTempl = '';
                $finalKeys = '';
                $response = $prodModel->getById($pid);
                if (array_key_exists('addtempl', $post)) {
                    if ($post['addtempl'] == 'on') {
                        if (!$response['name']) {
                            $response['name'] = '0';
                        }
                        $pos = strpos($post['templ'],'($prod_name)');
                        if ($pos !== false) {
                            $freeTempl = mb_strtolower(str_replace('($prod_name)', $response['name'], $post['templ']));
                        }
                    }
                }
                if (array_key_exists('addkeys', $post)) {
                    if ($post['addkeys'] == 'on') {
                        $finalKeys = $response['meta_keywords'];
                    }
                }
                if (strlen($freeTempl) > 0) {
                    if (strlen($finalKeys) > 0) {
                        $finalKeys .= ', ';
                    }
                    $finalKeys .= $freeTempl;
                }
                if (strlen($colorTempl) > 0) {
                    if (strlen($finalKeys) > 0) {
                        $finalKeys .= ', ';
                    }
                    $finalKeys .= $colorTempl;
                }
                $response = $prodModel->updateByField('id', $pid, array('meta_keywords' => $finalKeys));
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