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
	protected $fillable = ['location_id','location_user_id','location_company_id','location_name','street_address','country_id','state_name','city','zip_code','position_ids','staff_ids','default_start_time','location_monthly_store_target_1','location_monthly_store_target_2','location_monthly_store_target_3','location_monthly_store_target_4','location_monthly_store_target_5','location_monthly_store_target_6','location_monthly_store_target_7','location_monthly_store_target_8','location_monthly_store_target_9','location_monthly_store_target_10','location_monthly_store_target_11','location_monthly_store_target_12','default_end_time','default_meal_break','status'];
}