<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notes';
	protected $primaryKey = 'note_id';
	protected $fillable = ['note_id','company_id','notes','location_id','note_date','created_by','status'];
}