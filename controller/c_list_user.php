<?php
    require ('../model/m_user.php');


    class C_user {
        public function list_all_user($search = null){
            $user = new User();
            $list_user = $user->list_all_user($search);
            return $list_user;
        }
    }

?>