<?php
require_once('../model/m_history.php');
class C_History{
    public function list_all_history() {
        $history= new History();
        $list_history = $history->list_all_history();
        return $list_history;
    }
    public function search_history($keyword) {
        $history = new History();
        $list_history = $history->search_history($keyword);
        return $list_history;
    }
    
}
?>