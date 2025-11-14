<?php

namespace App\Models\Billboard;

use App\Models\Contact\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillboardTenure extends Model
{
    use HasFactory;

    protected $fillable = [
        'bboard_id',
        'contact_id',
        'user_id',
        'tenure_startdate',
        'tenure_enddate',
    ];

    protected $appends = 
    [
        'week_start',
        'week_end'
    ];

    /**
     * Append
     */

    public function getWeekStartAttribute()
    {
        return Carbon::parse($this -> tenure_startdate) -> year . '-' . Carbon::parse($this -> tenure_startdate) -> weekOfYear;
    }

    public function getWeekEndAttribute()
    {
        return Carbon::parse($this -> tenure_enddate) -> year  . '-' . Carbon::parse($this -> tenure_enddate) -> weekOfYear;
    }



    /**
     * relationship
     */

    public function billboard()
    {
        return $this->belongsTo(Billboard::class, 'bboard_id');
    }

    public function contact(){
        return $this->belongsTo(Contact::class)->select('id', 'name');
    }

    public function user()
    {
        return $this -> belongsTo(User::class)->select('id', 'name');
    }

    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('billboards.site_id', 'like', $term)
                ->orWhere('billboards.bboard_location', 'like', $term)
                ->orWhere('billboards.bboard_size', 'like', $term)
                ;

        });
    }
}
