<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table = 'peminjaman';

    protected $primaryKey = 'id';

    protected $allowedFields = [

        'user_id',

        'book_id',

        'borrow_date',

        'due_date',

        'return_date',

        'fine',

        'payment_status',

        'loan_status',

        'midtrans_token',

        'transaction_id',

        'paid_at'

    ];
}