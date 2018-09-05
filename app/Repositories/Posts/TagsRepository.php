<?php
namespace App\Repositories\Posts;

use Str;
use Item;
use Request;
use Collection;
use Carbon\Carbon;
use RepositoryManager;
use App\Models\Post\Tag;
use HZ\Laravel\Organizer\App\Contracts\RepositoryInterface;

class TagsRepository extends RepositoryManager implements RepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    const MODEL = Tag::class;

    /**
     * {@inheritDoc}
     */
    const TABLE = 'tags';
    
    /**
     * {@inheritDoc}
     */
    const TABLE_ALIAS = 't';

    /**
     * {@inheritDoc}
     */
    protected function records(Collection $records): Collection 
    {
        return $records->map(function ($record) {
            $record->image = url($record->image);
            return $record;
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setData($tag, Request $request)
    {
        $tag->name = $request->name;

        if ($request->image) {
            $tag->image = $request->image->store('images/posts/tags');
        }
    } 
    
    /**
     * {@inheritDoc}
     */
    public function get(int $id): \Item
    {
        $tag = Tag::find($id);

        $tag->image = url($tag->image);

        $info = (object) $tag->getAttributes();

        return new Item($info);
    }

    /**
     * {@inheritDoc}
     */
    protected function select()
    {
    } 
    
    /**
     * {@inheritDoc}
     */
    protected function filter() 
    {
    }  
}