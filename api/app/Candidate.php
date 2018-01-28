<?php

namespace App;

class Candidate extends Model {

	protected $table = 'candidates';

	protected $fillable = [
        'name', 'email',
    ];
}
