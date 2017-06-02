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
	protected $fillable = ['id','user_id','company_name','country_id','starting_day','time_format','staff_timesheet','budget','labor_cost','labor_hours','labor_adjustment','sales_per_hour','notes','status'];
}