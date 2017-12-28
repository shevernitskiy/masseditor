<?php

class shopEditorPluginBackendSetErrorAction extends waViewAction
{

    public function execute()
    {
        $post = waRequest::post();
        isset($post['errors']) ? $errors = $post['errors'] : $errors[] = 'Неизвестная ошибка';
        $this->view->assign('errors', $errors);
    }
}