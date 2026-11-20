@foreach (['scrollcraft', 'world'] as $script)
<script src="{{ asset("formcraft/{$script}.js") }}?v={{ filemtime(public_path("formcraft/{$script}.js")) }}" defer></script>
@endforeach
