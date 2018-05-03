<p>COMMENT</p>

Hola tienes un comentario {{ $comment->id }}:<br>

Comentario ({{ $comment->date }}):
<br><br>
{{ $comment->text }}

<br><br><br>
<a href="{{ route('pulsar.review.review_show', ['slug' => encrypt(['review_id' => $comment->review->id, 'owner_id' => $comment->owner_id === 1 ? 2 : 1 ])]) }}"> Responder al comentario</a>