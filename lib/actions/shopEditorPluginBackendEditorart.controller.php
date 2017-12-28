<?php

class shopEditorPluginBackendEditorartController extends waJsonController
{

    public function execute()
    {
        $post = waRequest::post();
        $prodModel = new shopProductModel();
        if ($post['type'] == 'articul') {
            $skuModel = new shopProductSkusModel();
            $btempl = $post['templ'];
            foreach ($post['product_id'] as $pid) {
                $templ = $btempl;
                $pos = strpos($templ,'($prod_name)');
                if ($pos !== false) {
                    $response = $prodModel->getById($pid);
                    if (!$response['name']) {
                        $response['name'] = '0';
                    }
                    $prod_name = str_replace(array("(", ")", "[", "]", ",", ".", "-", "+", " "), array("", "", "", "", "", "", "", "", "-"), $response['name']);
                    $templ = str_replace('($prod_name)', $prod_name, $templ);
                }
                $pos = strpos($templ,'($prod_id)');
                if ($pos !== false) {
                    $templ = str_replace('($prod_id)', $pid, $templ);
                }
                $skus = $skuModel->getByField('product_id', $pid, true);
                foreach ($skus as $sku) {
                    $ftempl = $templ;
                    $pos = strpos($templ,'($sku_name)');
                    if ($pos !== false) {
                        if (!$sku['name']) {
                            $sku['name'] = '0';
                        }  
                        $sku_name = str_replace(array("(", ")", "[", "]", ",", ".", "-", "+", " "), array("", "", "", "", "", "", "", "", "-"), $sku['name']);
                        $ftempl = str_replace('($sku_name)', $sku_name, $ftempl);
                    }
                    $pos = strpos($post['templ'],'($sku_id)');
                    if ($pos !== false) {
                        $ftempl = str_replace('($sku_id)', $sku['id'], $ftempl);
                    }
                    if ($ftempl == '0') {
                        $ftempl = '';
                    }
                    $response = $skuModel->updateByField('id', $sku['id'], array('sku' => $ftempl));
                    unset($ftempl);
                }
                unset($templ);
            }
            self::lg($response);
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