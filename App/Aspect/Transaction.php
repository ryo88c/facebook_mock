<?php
/**
 * @APP@
 *
 * @category   BEAR
 * @package    App
 * @subpackage Aspect
 * @author     $Author: anonymous$ <username@example.com>
 * @license    unknown http://www.example.com/
 * @version    SVN: Release: $Id:$
 * @link       http://www.example.com/
 */

/**
 * トランザクションアドバイス
 *
 * トランザクションを実現するroundアドバイスです
 *
 * @category   BEAR
 * @package    App
 * @subpackage App_Aspect
 * @author     $Author: anonymous $ <anonymous@example.com>
 * @copyright  anonymous All rights reserved.
 * @version    SVN: Release: $Id:$
 */
class App_Aspect_Transaction implements BEAR_Aspect_Around_Interface
{

    /**
     * Timer aroudアドバイス
     *
     * @param array $values
     *
     * @return array
     */
    public function around(array $values, BEAR_Aspect_JoinPoint $joinPoint)
    {
        // 前処理
        $obj = $joinPoint->getObject();
        $db = $obj->getDb();
        $db->beginTransaction();
        //　オリジナルのメソッドを実行
        $result = $joinPoint->proceed($values);
        // 後処理
        if (!MDB2::isError($result)) {
            $db->commit();
        } else {
            $db->rollback();
        }
        return $result;
    }
}