<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class User extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $primaryKey = 'id';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','type','company_id','firstname','lastname','email','password','business_contact_no','profile_pic','gender','previlege_id','employee_id','dob','emergency_contact','position_ids','location_ids','emergency_number','profile_pic','verification_link','tmp_link','notes','start_date_with_company','password_link','created_by','status'];

}
