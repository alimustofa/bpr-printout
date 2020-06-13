<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model {
    public function checkUser($username, $password)
    {
        return $this->db
            ->from('users')
            ->where([
                'username' => $username,
                'password' => md5($password)
            ])
            ->get();
    }
}