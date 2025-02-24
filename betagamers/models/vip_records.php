<?php
class Vip_records extends Diamond {
    use Db;
    protected static $table = 'vip_records';
    protected $columns = ['id', 'fullname', 'email', 'phone', 'currency', 'amount', 'plan', 'txn_id', 'txn_ref', 'reg_date', 'expdate'];
}