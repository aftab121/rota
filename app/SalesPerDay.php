<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPerDay extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sales_per_day';
	protected $primaryKey = 'sales_id';
	protected $fillable = ['sales_id','company_id','location_id','sales_price','sales_percentage','sales_per_hour','labour_variation','sales_shift_date','status'];
}