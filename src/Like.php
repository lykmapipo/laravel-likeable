<?php

namespace Conner\Likeable;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Alsofronie\Uuid\UuidModelTrait;

class Like extends Eloquent
{
	/**
     * Use Uuuid 32 as primary key
     */
    use UuidModelTrait;
    
	protected $table = 'likeable_likes';
	public $timestamps = true;
	protected $fillable = ['likeable_id', 'likeable_type', 'user_id'];

	public function likeable()
	{
		return $this->morphTo();
	}
}