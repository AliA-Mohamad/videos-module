@extends('videos::layouts.master')

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="m-5 border p-3 rounded">
            <span id="tempo-exibicao"> {{ session('tempoTotal') }} segundos </span>
        </div>
        <div id="player">
            <iframe
                    src="https://www.youtube.com/embed/gset79KMmt0"
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" >
            </iframe>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://www.youtube.com/player_api"></script>
    <script>
        var player;
        var valor = document.getElementById("tempo-exibicao").innerHTML;

        var tempoTotal = parseInt(valor) + 0;

        if(tempoTotal != number){
            tempoTotal = 0;
        }

        function onYouTubePlayerAPIReady()
        {
            player = new YT.Player(
                'player', {
                    height: '315',
                    width: '560',
                    videoId: 'gset79KMmt0',
                    events: {
                        'onStateChange': onPlayerStateChange
                    }
                }
            );
        }

        function onPlayerStateChange(event)
        {
            if (event.data == YT.PlayerState.PLAYING) {
                intervalo = setInterval(function() {
                    tempoTotal += 1;
                    document.getElementById("tempo-exibicao").innerHTML = tempoTotal + " segundos";
                    storeTimeElapsed(tempoTotal);
                }, 1000);
            } else if (event.data == YT.PlayerState.PAUSED) {
                clearInterval(intervalo);
            }
        }

        function storeTimeElapsed(tempoTotal) 
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: 'videos/salva-tempoTotal',
                data: { tempoTotal: tempoTotal },
                success: function(response) {
                    console.log('Tempo registrado com sucesso.');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Erro ao registrar tempo.');
                }
            });
        }

    </script>
@endsection
