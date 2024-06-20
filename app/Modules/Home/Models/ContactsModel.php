<?php 
namespace App\Modules\Home\Models;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Database\Eloquent\Model;
 
class ContactsModel extends Model {

	protected $table = 'contacts';
	protected $primaryKey = 'id';
	protected $fillable = [];

	


}