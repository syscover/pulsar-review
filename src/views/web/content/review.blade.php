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

¿Desea enviar un comentario a su cliente?
<form action="{{ route('pulsar.review.comment.store') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="review_id" value="{{ $review->id }}">
    <input type="hidden" name="owner_id" value="1">
    <input type="hidden" name="name" value="{{ $review->object_name }}">
    <input type="hidden" name="email" value="{{ $review->object_email }}">
    <div><textarea name="comment"></textarea></div>
    <div><button type="submit">Enviar</button></div>
</form>