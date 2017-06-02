<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shifts';
	protected $primaryKey = 'id';
	protected $fillable = ['id','position_id','location_id','assigned_to','assigned_by','company_id','is_conflict','shift_start_time','shift_end_time','meal_break','end_option','notes','visible','shift_date','status'];
}