<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wages extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'wages';
	protected $primaryKey = 'wage_id';
	protected $fillable = ['wage_id','wage_user_id','standard_rate','saturday_rate','sunday_rate','holiday_rate','overtime_rate','yearly_rate','status'];
}