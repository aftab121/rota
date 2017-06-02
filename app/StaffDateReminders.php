<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffDateReminders extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'staff_datereminders';
	protected $primaryKey = 'id';
	protected $fillable = ['id','staff_datereminders_user_id','company_id','date_name','set_reminders','days_advance','status'];
}