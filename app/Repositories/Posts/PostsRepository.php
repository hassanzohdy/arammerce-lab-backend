<?php
namespace App\Repositories\Posts;

use DB;
use Item;
use Request;
use Collection;
use RepositoryManager;
use App\Models\Post\Post;
use HZ\Laravel\Organizer\App\Contracts\RepositoryInterface;

class PostsRepository extends RepositoryManager implements RepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    const MODEL = Post::class;

    /**
     * {@inheritDoc}
     */
    const TABLE = 'posts';
    
    /**
     * {@inheritDoc}
     */
    const TABLE_ALIAS = 'p';

    /**
     * {@inheritDoc}
     */
    const DATA = ['title', 'description'];

    /**
     * A flag to get post tags
     * 
     * @var bool
     */
    private $getTags = false;

    /**
     * {@inheritDoc}
     */
    protected function records(Collection $records): Collection 
    {
        return $records->map(function ($record) {
            if ($this->getTags) {
                $tags = DB::table('post_tags as pt')->join('tags as t', 't.id', '=', 'pt.tag_id')->where('pt.post_id', $record->id)->get(['t.name', 't.image']);
                $record->tags = $tags->map(function ($tag) {
                    $tag->image = url($tag->image);

                    return $tag;
                });
            }

            return $record;
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setData($post, Request $request)
    {
        // just for now
        if (! $post->id) {
            $post->status = 'active';
            $post->type = 'normal';
        }
    } 

    /**
     * {@inheritDoc}
     */
    protected function onSave($post, $request)
    {
        // $post->tags()->delete();

        DB::table('post_tags')->where('post_id', $post->id)->delete();

        foreach ((array) $request->tags as $tagId) {
            DB::table('post_tags')->insert([
                'post_id' => $post->id,
                'tag_id' => $tagId,
            ]);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function get(int $id): \Item
    {
        $post = Post::where('p.id', $id)
                    ->from('posts as p')
                    ->join('users as u', 'u.id', '=', 'p.created_by')
                    ->select('p.id', 'p.title', 'p.description', 'p.created_by', 'p.created_at', 'u.image as creatorImage')
                    ->selectRaw('CONCAT(u.first_name, " ", u.last_name) as creatorName')
                    ->first();

        $info = (object) $post->getAttributes();

        $tags = DB::table('post_tags as pt')->join('tags as t', 't.id', '=', 'pt.tag_id')->where('pt.post_id', $post->id)->get(['t.name', 't.image']);

        $info->tags = $tags->map(function ($tag) {
            $tag->image = url($tag->image);

            return $tag;
        });

        return new Item($info);
    }

    /**
     * {@inheritDoc}
     */
    protected function select()
    {
        foreach (['id', 'title', 'created_at'] as $column) {
            $this->select->replace($column, $this->column($column));
        }

        if ($this->select->has('tags')) {
            $this->select->remove('tags');
            $this->getTags = true;
        }

        if ($this->select->has('createdBy')) {
            $this->creator();
        }
    } 
    
    /**
     * {@inheritDoc}
     */
    protected function filter() 
    {
    }  
}