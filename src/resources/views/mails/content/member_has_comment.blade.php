<p>COMMENT</p>

Hola tienes un comentario {{ $comment->id }}:<br>

Comentario ({{ $comment->date }}):
<br><br>
{{ $comment->comment }}

<br><br><br>
<a href="{{ $comment->comment_url }}"> Responder al comentario</a>