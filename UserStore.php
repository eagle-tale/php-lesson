<?php
class UserStore {

    private $users;

    public function __construct() {}

    public function find($id) {
        $user = null;
        if ($this->exists($id)) {
            $user = $this->get($id);
        }
        return $user;
    }

    public function findAll() {
        return $this->users;
    }

    public function save($user) {
        // すでに存在する場合は何もしない
        if ($this->exists($user->id)) {
            return;
        }
        array_push($this->users, $user);
    }

    private function get($id) {
        return array_filter($this->users, fn ($u) => $u->id === $id)[0];
    }

    private function exists($id) {
        $exists = array_keys( array_column( $this->users, 'id'), $id);
        return count($exists) != 0;
    }
}