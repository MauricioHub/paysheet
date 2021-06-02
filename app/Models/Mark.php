<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;   
use Illuminate\Database\Eloquent\Model;
   
class Mark extends Model
{
	use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'picture', 'mark_date', 'lat', 'lng', 'user_id', 'mark_type_id'
    ];
}