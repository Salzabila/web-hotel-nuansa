<?php

namespace App\Models;

/**
 * OperationalExpense model alias for unified backward compatibility.
 * All operational expense queries seamlessly query the unified 'expenses' table.
 */
class OperationalExpense extends Expense
{
    protected $table = 'expenses';
}
