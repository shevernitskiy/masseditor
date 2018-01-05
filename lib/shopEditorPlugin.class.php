<?php

class shopEditorPlugin extends shopPlugin
{
    public function editorHandler()
    {

        return array(
            'toolbar_organize_li' => '<li><a id="articul_menu" href="#"><i class="icon16 hierarchical"></i>Артикулятор</a></li>
            <li><a id="metakey_menu" href="#"><i class="icon16 target"></i>Мета ключник</a></li>
            <li><a id="metadesc_menu" href="#"><i class="icon16 notebooks"></i>Мета дексриптор</a></li>
            <li><a id="metatitle_menu" href="#"><i class="icon16 blog"></i>Мета заглавник</a></li>
            <li><a id="url_menu" href="#"><i class="icon16 link"></i>Ссыльник</a></li>
            <script src="' . wa()->getAppStaticUrl('shop', true) . 'plugins/editor/js/editorart.js" type="text/javascript"></script>
            <script src="' . wa()->getAppStaticUrl('shop', true) . 'plugins/editor/js/editorkey.js" type="text/javascript"></script>
            <script src="' . wa()->getAppStaticUrl('shop', true) . 'plugins/editor/js/editordesc.js" type="text/javascript"></script>
            <script src="' . wa()->getAppStaticUrl('shop', true) . 'plugins/editor/js/editortitle.js" type="text/javascript"></script>
            <script src="' . wa()->getAppStaticUrl('shop', true) . 'plugins/editor/js/editorurl.js" type="text/javascript"></script>'
        );
    }
}
