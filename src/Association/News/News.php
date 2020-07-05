<?php

declare(strict_types=1);

namespace Francken\Association\News;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;
use League\Period\Period;

/**
 * Francken\Association\News\Eloquent\News
 *
 * @property int $id
 * @property string $title
 * @property string $exerpt
 * @property string $slug
 * @property string $source_contents
 * @property string $compiled_contents
 * @property string $author_name
 * @property string $author_photo
 * @property array $related_news_items
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News byLink($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News inPeriod(\League\Period\Period $period = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News recent()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereAuthorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereAuthorPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereCompiledContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereExerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereRelatedNewsItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereSourceContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News withAuthorName($author = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\News\Eloquent\News withSubject($subject = null)
 * @mixin \Eloquent
 */
final class News extends Eloquent
{
    protected $fillable = [
        'title',
        'slug',
        'exerpt',
        'author_name',
        'author_photo',
        'source_contents',
        'compiled_contents',
        'published_at',
        'related_news_items',
    ];

    protected $casts = [
        'related_news_items' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];

    public function publish(DateTimeImmutable $publicationDate) : void
    {
        $this->published_at = $publicationDate;
        $this->slug = $this->published_at->format('y-m-d-') . Str::slug($this->title);
    }

    public function archive() : void
    {
        $this->published_at = null;
        $this->slug = $this->id . '-' . Str::slug($this->title);
    }

    public function changeAuthor(Author $author) : void
    {
        $this->author_name = $author->name();
        $this->author_photo = $author->photo();
    }

    public function changeTitle(string $title) : void
    {
        $this->title = $title;

        if ($this->published_at !== null) {
            $this->slug = $this->published_at->format('y-m-d-') . Str::slug($this->title);
        } else {
            $this->slug = $this->id . '-' . Str::slug($this->title);
        }
    }

    public function changeContents(CompiledMarkdown $markdown) : void
    {
        $this->source_contents = $markdown->originalMarkdown();
        $this->compiled_contents = (string)$markdown;
    }

    public function changeExerpt(string $exerpt) : void
    {
        $this->exerpt = $exerpt;
    }

    /**
     * Scope a query to only include news with the given slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLink($query, string $slug)
    {
        return $query->whereSlug($slug);
    }

    /**
     * Scope a query to only include news only news before the current news
     */
    public function previous() : ?self
    {
        if ($this->published_at === null) {
            return null;
        }

        return self::orderBy('published_at', 'desc')
            ->where('id', '<>', $this->id)
            ->whereDate('published_at', '<=', $this->published_at->toDateTimeString())
            ->first();
    }

    /**
     * Scope a query to only include news only news before the current news
     */
    public function next() : ?self
    {
        if ($this->published_at === null) {
            return null;
        }

        return self::orderBy('published_at', 'asc')
            ->where('id', '<>', $this->id)
            ->whereDate('published_at', '>=', $this->published_at->toDateTimeString())
            ->first();
    }

    /**
     * Sort the query by most recent news
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to only include news published in a given period
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \League\Period\Period $period
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInPeriod($query, Period $period = null)
    {
        return (isset($period) ? $query->whereBetween('published_at', [$period->getStartDate(), $period->getEndDate()]) : $query);
    }


    /**
     * Scope a query to only include news with a whose subject includes
     * the given subject string
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithSubject($query, string $subject = null)
    {
        return (isset($subject) ? $query->whereTitle($subject) : $query);
    }

    /**
     * Scope a query to only include a given author
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $author
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAuthorName($query, string $author = null)
    {
        return (isset($author) ? $query->whereAuthorName($author) : $query);
    }

    private function contents() : CompiledMarkdown
    {
        return CompiledMarkdown::withSource(
            $this->compiled_contents ?? '',
            $this->source_contents ?? ''
        );
    }

    private function author() : Author
    {
        return new Author(
            $this->author_name,
            $this->author_photo
        );
    }
}
