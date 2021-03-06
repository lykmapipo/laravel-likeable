<?php

namespace Conner\Likeable;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Alsofronie\Uuid\UuidModelTrait;

class LikeCounter extends Eloquent
{
	/**
     * Use Uuuid 32 as primary key
     */
    use UuidModelTrait;
    
	protected $table = 'likeable_like_counters';
	public $timestamps = false;
	protected $fillable = ['likeable_id', 'likeable_type', 'count'];
	
	public function likeable()
	{
		return $this->morphTo();
	}
	
	/**
	 * Delete all counts of the given model, and recount them and insert new counts
	 *
	 * @param string $model (should match Model::$morphClass)
	 */
	public static function rebuild($modelClass)
	{
		if(empty($modelClass)) {
			throw new \Exception('$modelClass cannot be empty/null. Maybe set the $morphClass variable on your model.');
		}
		
		$builder = Like::query()
			->select(\DB::raw('count(*) as count, likeable_type, likeable_id'))
			->where('likeable_type', $modelClass)
			->groupBy('likeable_id');
		
		$results = $builder->get();
		
		$inserts = $results->toArray();
		
		\DB::table((new static)->table)->insert($inserts);
	}
	
}