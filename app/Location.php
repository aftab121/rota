<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'locations';
	protected $primaryKey = 'location_id';
	protected $fillable = ['location_id','location_user_id','location_company_id','location_name','street_address','country_id','state_name','city','zip_code','position_ids','staff_ids','default_start_time','default_end_time','default_meal_break','status'];
}