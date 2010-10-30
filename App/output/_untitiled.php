<?php

/**
 * App
 *
 * @category   BEAR
 * @package    App_Page
 * @subpackage Output
 * @author     $Author: koriyama@bear-project.net $ <username@example.com>
 * @license    unknown http://www.example.com/
 * @version    SVN: Release: $Id: _untitiled.php 1201 2009-11-10 06:39:01Z koriyama@bear-project.net $
 * @link       http://www.example.com/
 */
/**
 * Untitledアウトプットフィルター
 *
 * @param array $values  引数
 * @param array $options オプション
 *
 * @return BEAR_Ro
 */
function outputUntitled($values, $options = null)
{
    $headers = array('X-BEAR-Output: untitled', 'Content-Type: text/html; charset=utf-8');
    return new BEAR_Ro('<pre>' . print_r($values, true) . '</pre>', $headers);
}