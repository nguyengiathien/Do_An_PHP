<?php
require_once('model/m_account.php');

class C_Acc {

    public function list_all_account() {
        $account = new Account();
        $list_account = $account->list_all_account();
        return $list_account;
    }    
}
?>
