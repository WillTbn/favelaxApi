<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class AdminPolicy
{
    private $loggeduser;
    public function __construct()
    {
        $this->loggeduser = auth('admin-api')->user();
    }
    public function viewAny(){
        if($this->loggeduser instanceof Admin && $this->loggeduser->isAdmin() ){
            return true;
        }
    }
    public function before(){
        if($this->loggeduser instanceof Admin && $this->loggeduser->isAdmin() ){
            return true;
        }
    }
    public function show(?User $user)
    {
        if($this->loggeduser instanceof Admin && $this->loggeduser->isModeler() ){
           return true;
        }
    }
    public function delete(?User $user)
    {
        if($this->loggeduser instanceof Admin && $this->loggeduser->isFinLvlOne() ){
            return true;
        }
    }
    public function update(?User $user)
    {
        if($this->loggeduser instanceof Admin && $this->loggeduser->isFinLvlTwo() ){
            return true;
        }
    }
}
