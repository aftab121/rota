<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayLists extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'holiday_lists';
	protected $primaryKey = 'id';
	protected $fillable = ['id','holiday_list_user_id','company_id','country_id','year','holiday_date','holiday_name','status'];
}