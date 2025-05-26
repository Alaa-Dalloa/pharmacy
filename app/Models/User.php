<?php

    namespace App\Models;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;
    use Laratrust\Traits\LaratrustUserTrait;

    class User extends Authenticatable implements JWTSubject
    {
        use LaratrustUserTrait;
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'start_work_date',
        'gender',
        'the_job',
        'working_days',
        'phone',
        'company_factor',
        'user_type',
        'salary',
        'his_evaluation',
        'adress'
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
     public function offer_f_sups()
{

    return $this->hasMany(OfferFSup::class,'user_id','id');

}
    }