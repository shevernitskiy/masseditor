<?php

class shopEditorPluginBackendEditorurlController extends waJsonController
{

    public function execute()
    {
        $post = waRequest::post();
        $prodModel = new shopProductModel();
        if ($post['type'] = 'url') {
            foreach ($post['product_id'] as $pid) {
                $response = $prodModel->getById($pid);
                if (!$response['name']) {
                    $response['name'] = '0';
                }
                $url = self::doTranslit($response['name']);
                $response = $prodModel->updateByField('id', $pid, array('url' => $url));
            }
            return;
        }
        return;
    }

    public function doTranslit($str)
    {
        $ru_str = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я',
        'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
        '(',')',',','.',';',' ','"','+','/','*','?','!','@','%','&','#','$','^','«','»');
        $en_str = array('a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f',
            'h','c','ch','sh','shh','','i','','je','ju','ja',
            'a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f',
            'h','c','ch','sh','shh','','i','','je','ju','ja',
            '', '','', '', '','-','','','','','','','','','','','','','','');
        $result = str_replace($ru_str, $en_str, $str);
        return $result;
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