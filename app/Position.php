<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'positions';
	protected $primaryKey = 'id';
	protected $fillable = ['id','position_user_id','company_id','position_name','location_ids','staff_ids','status'];
}