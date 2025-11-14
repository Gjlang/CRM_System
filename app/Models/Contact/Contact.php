<?php

namespace App\Models\Contact;

use App\Models\Billboard\Billboard;
use App\Models\Forecast\Forecast;
use App\Models\ToDo\Task;
use App\Models\ToDo\ToDo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'industry_id',
        'status_id',
        'type_id',
        'category_id',
        'remark',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ContactCategory::class);
    }

    public function type()
    {
        return $this->belongsTo(ContactType::class);
    }

    public function industry()
    {
        return $this->belongsTo(ContactIndustry::class);
    }

    public function status()
    {
        return $this->belongsTo(ContactStatus::class);
    }

    public function todo()
    {
        return $this->hasMany(ToDo::class)
            ->with('task', 'user', 'action');
    }

    public function history()
    {
        return $this->hasMany(ToDo::class)->with('task', 'user', 'action');
    }

    public function incharge()
    {
        return $this->hasMany(ContactIncharge::class);
    }

    public function forecast()
    {
        return $this->hasMany(Forecast::class)->with('product', 'forecast_type')->orderBy('forecast_date', 'desc');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function billboard()
    {
        return $this->belongsTo(Billboard::class);
    }

    public function textcolor()
    {
        return $this->hasOne(ContactTextColor::class, 'company_id')
        ->join('text_colors', 'text_colors.id', 'contact_text_colors.color_id')
        // ->select('text_colors.color_code as color_code', 'text_colors.id as color_code')
        ;
    }

    public function summary_action()
    {
        return $this->hasMany(ToDo::class)->whereNotNull('action_id');
    }

    public function summary_todo()
    {
        return $this->hasMany(ToDo::class);
    }

    public function forecast_summary()
    {
        return $this->hasMany(Forecast::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('contacts.created_at', 'like', $term)
                ->orWhere('contacts.name', 'like', $term)
                ->orWhere('contacts.address', 'like', $term)
                ->orWhere('contacts.remark', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('type', function ($query) use ($term) {
                    $query->where('contact_types.name', 'like', $term);
                })
                ->orWhereHas('status', function ($query) use ($term) {
                    $query->where('contact_statuses.name', 'like', $term);
                })
                ->orWhereHas('category', function ($query) use ($term) {
                    $query->where('contact_categories.name', 'like', $term);
                });
        });
    }
}
