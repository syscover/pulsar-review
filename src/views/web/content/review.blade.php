<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Review</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 54px;
        }
        @media (min-width: 992px) {
            body {
                padding-top: 56px;
            }
        }
        h3 {
            font-size: 25px;
        }
        .question {
            border: 1px solid #c6c8ca;
            border-radius: 5px;
            margin-top: 15px;
            margin-bottom: 15px;
            padding: 15px;
        }
    </style>
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Review</a>
    </div>
</nav>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @foreach($review->poll->questions->where('lang_id', user_lang())->sortBy('sort') as $question)
                <div class="question">
                    <div class="container">
                        <h3>{{ $question->name }}</h3>
                        <p class="lead">{{ $question->description }}</p>
                        <div class="response">
                            @if($question->type_id === 1)
                               {{ $review->responses->where('question_id', $question->id)->first()->score }}
                            @endif
                            @if($question->type_id === 2)
                               {{ $review->responses->where('question_id', $question->id)->first()->text }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <hr>

            <h2>Comentarios</h2>

            @foreach($review->comments as $comment)
                <div>
                    <div>{{ $comment->name }} ({{ $comment->date }})</div>
                    <div>{{ $comment->text }}</div>
                </div>
                <br>
            @endforeach

            <form action="{{ route('pulsar.review.comment.store') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="review_id" value="{{ $review->id }}">
                <input type="hidden" name="owner_id" value="{{ $owner_id }}">
                <input type="hidden" name="name" value="{{ $owner_id === 1 ? $review->object_name : $review->customer_name }}">
                <input type="hidden" name="email" value="{{ $owner_id === 1 ? $review->object_email : $review->customer_email }}">

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">¿Desea enviar un comentario al {{ $owner_id === 1? 'Cliente' : 'Object' }}?</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script>
    $(function() {
        $('[name=object_id]').on('change', function () {
            $('[name=object_name]').val($('[name=object_id] option:selected').text());
            $('[name=slug]').val($('[name=object_id] option:selected').data('slug'));
        });
    });
</script>
</body>
</html>
