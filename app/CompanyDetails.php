<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'companydetails';
	protected $primaryKey = 'id';
	protected $fillable = ['id','user_id','company_name','country_id','starting_day','time_format','staff_timesheet','budget','labor_cost','labor_hours','last_year_target','percentage_growth','store_last_year_target','store_percentage_growth','yearly_company_target','yearly_store_target','monthly_company_target','monthly_store_target','last_month_target_1','last_month_percentage_growth_1','last_month_target_2','last_month_percentage_growth_2','last_month_target_3','last_month_percentage_growth_3','last_month_target_4','last_month_percentage_growth_4','last_month_target_5','last_month_percentage_growth_5','last_month_target_6','last_month_percentage_growth_6','last_month_target_7','last_month_percentage_growth_7','last_month_target_8','last_month_percentage_growth_8','last_month_target_9','last_month_percentage_growth_9','last_month_target_10','last_month_percentage_growth_10','last_month_target_11','last_month_percentage_growth_11','last_month_target_12','last_month_percentage_growth_12','last_month_store_target_1','last_month_store_percentage_growth_1','last_month_store_target_2','last_month_store_percentage_growth_2','last_month_store_target_3','last_month_store_percentage_growth_3','last_month_store_target_4','last_month_store_percentage_growth_4','last_month_store_target_5','last_month_store_percentage_growth_5','last_month_store_target_6','last_month_store_percentage_growth_6','last_month_store_target_7','last_month_store_percentage_growth_7','last_month_store_target_8','last_month_store_percentage_growth_8','last_month_store_target_9','last_month_store_percentage_growth_9','last_month_store_target_10','last_month_store_percentage_growth_10','last_month_store_target_11','last_month_store_percentage_growth_11','last_month_store_target_12','last_month_store_percentage_growth_12','labor_adjustment','sales_per_hour','notes','status'];
}