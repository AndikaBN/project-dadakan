<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /*
    $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->string('name');
            $table->enum('choice_type', ['short answer', 'paragraph', 'date', 'multiple choice', 'dropdown', 'checkboxes']);
            $table->text('choices')->nullable();
            $table->boolean('is_required')->default(false);
    */

    protected $fillable = [
        'form_id',
        'name',
        'choice_type',
        'choices',
        'is_required',
    ];

    protected $casts = [
        'choices' => 'array',
        'is_required' => 'boolean',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
