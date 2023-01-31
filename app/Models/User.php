<?php

namespace App\Models;

use App\Classes\IpedCursos;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','username','email','indicacao','ativo','cpf','celular','password',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'documentos'=>'array',
        'midias_sociais'=>'array',
    ];

    protected $dates = ['created_at','last_login'];

    public function loginSecurity()
    {
        return $this->hasOne('App\Models\LoginSecurity');
    }

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';
    public function isAdmin()    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function wallet()
    {
        return $this->hasMany(Wallet::class)->select('id','saldo');
    }

    public function isDados()
    {
        return User::select('cpf','celular')->find(auth()->id());
    }

    public function isEndereco()
    {
        return Endereco::select('user_id')->where('user_id',\Auth::id())->first();
    }

    public function ipedUser()
    {
        return $this->belongsTo(IpedCursos::class,'user_id');
    }

    public function getNameInitials()
    {
        $name = $this->name;
        $name_array = explode(' ',trim($name));

        $firstWord = $name_array[0];
        $lastWord = $name_array[count($name_array)-1];

        return mb_substr($firstWord[0],0,1)."".mb_substr($lastWord[0],0,1);
    }
}
