<h1 class="margin-vertical-20">Review</h1>

<ul>
    @foreach($review->poll->questions->where('lang_id', user_lang())->sortBy('sort') as $question)
        <li>
            {{ $question->name }}<br>
            {{ $question->description }}<br>
            @if($question->type_id === 1)
                Puntuación: {{ $review->responses->where('question_id', $question->id)->first()->score }}
            @endif
            @if($question->type_id === 2)
                texto: {{ $review->responses->where('question_id', $question->id)->first()->text }}
            @endif
        </li>
    @endforeach
</ul>

<h2>Comentarios</h2>

@foreach($review->comments as $comment)
    <div>
        <div>{{ $comment->name }} ({{ $comment->date }})</div>
        <div>{{ $comment->text }}</div>
    </div>
    <br>
@endforeach


¿Desea enviar un comentario al {{ $owner_id === 1? 'Cliente' : 'Object' }}?
<form action="{{ route('pulsar.review.comment.store') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="review_id" value="{{ $review->id }}">
    <input type="hidden" name="owner_id" value="{{ $owner_id }}">

    <input type="hidden" name="name" value="{{ $owner_id === 1 ? $review->object_name : $review->customer_name }}">
    <input type="hidden" name="email" value="{{ $owner_id === 1 ? $review->object_email : $review->customer_email }}">
    <div><textarea name="text"></textarea></div>
    <div><button type="submit">Enviar</button></div>
</form>