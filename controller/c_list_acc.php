<?php
require_once('../model/m_account.php');

class C_Acc {

    public function list_all_account() {

        $account = new Account();
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $list_account = $account->list_all_account($searchTerm);
        return $list_account;
    }
}
?>
