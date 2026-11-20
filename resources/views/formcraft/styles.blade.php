@foreach (['fonts', 'palette', 'scrollcraft', 'world', 'motion'] as $sheet)
<link rel="stylesheet" href="{{ asset("formcraft/{$sheet}.css") }}?v={{ filemtime(public_path("formcraft/{$sheet}.css")) }}">
@endforeach
