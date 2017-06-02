<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'countries';
	protected $primaryKey = 'id';
	protected $fillable = ['id','country_code','country_name'];
}