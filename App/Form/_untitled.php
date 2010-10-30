<?php
/**
 * フォーム
 *
 * <pre>
 * described here...
 * </pre>
 *
 * @package    App
 * @subpackage Form
 * @author     $Author: koriyama@bear-project.net $
 * @version    SVN: Release: $Id: _untitled.php 1260 2009-12-08 14:41:23Z koriyama@bear-project.net $
 */
class App_Form_Untitled
{

    /**
     * テンプレート
     *
     * @var string
     */
    private static $_elementTemplate = "\n\t\t<li><label class=\"element\"><!-- BEGIN required --><span class=\"required\">*</span><!-- END required -->{label}</label><div class=\"element<!-- BEGIN error -->_error<!-- END error -->\">{element}<!-- BEGIN error --><span class=\"error\">!</span><!-- END error --><!-- BEGIN label_3 -->{label_3}<!-- END label_3 --><!-- BEGIN label_2 --><br /><span style=\"font-size: 80%;\">{label_2}</span><!-- END label_2 --></div></li>";

    /**
     * インジェクト
     *
     */
    public function onInject()
    {
        $callback = array(__CLASS__, 'onRender');
        $this->_form = array('formName' => 'form', 'callback'=>$callback);
    }

    /**
     * モバイルインジェクト
     *
     */
    public function onInjectMobile()
    {
        self:: $_elementTemplate = "\n\t\t<li><label class=\"element\"><!-- BEGIN required --><span class=\"required\">*</span><!-- END required -->{label}</label><div class=\"element<!-- BEGIN error -->_error<!-- END error -->\">{element}<!-- BEGIN error --><span class=\"error\">!</span><!-- END error --><!-- BEGIN label_3 -->{label_3}<!-- END label_3 --><!-- BEGIN label_2 --><br /><span style=\"font-size: 80%;\">{label_2}</span><!-- END label_2 --></div></li>";
        $this->onInject();
    }

    /**
     * フォーム
     *
     * @return void
     */
    public function build()
    {
        $form = BEAR::dependency('BEAR_Form', $this->_form);
        $form->setDefaults(array('name' => 'Kuma', 'email' => 'kuma@example.com'));
        //  フォームヘッダー
        $form->addElement('header', 'main', '入力(確認）してください');
        //  フォームインプットフィールド
        $form->addElement('text', 'name', '名前', 'size=30 maxlength=30');
        $form->addElement('text', 'email', 'メールアドレス', 'size=30 maxlength=30');
        $form->addElement('textarea', 'body', '感想');
        $form->addElement('submit', '_submit', '送信', '');
        // フィルタと検証ルール
        $form->applyFilter('__ALL__', 'trim');
        $form->applyFilter('__ALL__', 'strip_tags');
        $form->addRule('name', '名前を入力してください', 'required', null, 'client');
        $form->addRule('email', 'emailを入力してください', 'required', null, 'client');
        $form->addRule('email', 'emailの形式で入力してください', 'email', null, 'client');
    }

    /**
     * カスタムテンプレート
     *
     * @param object $render
     *
     * @return void
     */
    public static function onRender($render)
    {
        $render->setElementTemplate(self::$_elementTemplate);
    }
}