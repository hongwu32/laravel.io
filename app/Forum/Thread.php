<?php

namespace App\Forum;

use App\DateTime\Timestamps;
use App\Tags\Taggable;
use App\Users\Authored;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\DateTime\HasTimestamps;
use App\Replies\Reply;
use App\Replies\UsesReplies;
use App\Replies\ReplyAble;
use App\Tags\UsesTags;
use App\Users\HasAuthor;

class Thread extends Model implements Authored, ReplyAble, Taggable, Timestamps
{
    use HasAuthor, HasTimestamps, UsesReplies, UsesTags;

    const TABLE = 'threads';

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['subject', 'body'];

    public function id(): int
    {
        return $this->id;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function topic(): Topic
    {
        return $this->topicRelation;
    }

    public function topicRelation(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    /**
     * @return \App\Replies\Reply|null
     */
    public function solutionReply()
    {
        return $this->solutionReplyRelation;
    }

    public function solutionReplyRelation(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'solution_reply_id');
    }

    public function isSolutionReply(Reply $reply): bool
    {
        if ($solution = $this->solutionReply()) {
            return $solution->id() === $reply->id();
        }

        return false;
    }
}