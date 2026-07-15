<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

protected $allowedFields = [

    'name',

    'username',

    'email',

    'phone',

    'password',

    'role_id',

    'created_at',

    'updated_at'

];
}
