<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Review</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

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
        .alert {
            margin-top: 25px;
        }
        .comment {
            margin: 10px 0;
        }
        .text-comment {
            font-size: 18px;
        }
        .data-comment {
            font-weight: bold;
            font-size: 11px;
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

    @if(session('status'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Perfecto!</strong> Tu comentario ha sido enviado correctamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
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
                @php
                    $date = (new \Carbon\Carbon($comment->date))
                @endphp
                <div class="comment">
                    <div class="text-comment">{{ $comment->comment }}</div>
                    <div class="data-comment">{{ $comment->name }} ({{ $date->format('d-m-Y H:m:s') }})</div>
                </div>
            @endforeach
            <hr>

            <form action="{{ route('pulsar.review.comment_store') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="review_id" value="{{ $review->id }}">
                <input type="hidden" name="owner_type_id" value="{{ $owner_type_id }}">
                <input type="hidden" name="name" value="{{ (int) $owner_type_id === 1 ? $review->object_name : $review->customer_name }}">
                <input type="hidden" name="email" value="{{ (int) $owner_type_id === 1 ? $review->object_email : $review->customer_name }}">
                <input type="hidden" name="email_subject" value="Tienes un nuevo comentario de {{ (int) $owner_type_id === 1 ? $review->object_name : $review->customer_name }}">

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">¿Desea enviar un comentario al {{ $owner_type_id === 1? 'Cliente' : 'Object' }}?</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
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
