<?php
 namespace App\Models;
 use Illuminate\Database\Eloquent\Model;


 class User extends Model{


 protected $table = 'tbluser';
 // column sa table
    protected $fillable = [
    'userid', 'username', 'password' , 'gender', 'jobid', 
    ];

    public $timestamps = false;
    protected $primaryKey = 'userid';

    protected $hidden = ['password'];
 }

 ?>