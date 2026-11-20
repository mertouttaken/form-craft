@php
    $label = trim($field['label']) === '' ? 'Adsız alan' : $field['label'];
    $label .= $field['required'] ? ' *' : '';
    $options = array_filter(array_map('trim', preg_split('/\R/u', $field['options']) ?: []), fn (string $entry): bool => $entry !== '');
@endphp

@if (in_array($type, ['radio', 'checkbox'], true))
    <fieldset class="preview-field" wire:key="preview-{{ $id }}">
        <legend>{{ $label }}</legend>
        @foreach ($options as $option)
            <label class="check"><input type="{{ $type }}" name="preview-{{ $id }}"> {{ $option }}</label>
        @endforeach
    </fieldset>
@else
    <div class="preview-field" wire:key="preview-{{ $id }}">
        <label for="preview-{{ $id }}">{{ $label }}</label>
        @if ($type === 'select')
            <select class="select" id="preview-{{ $id }}">
                <option value="">Bir seçenek seç</option>
                @foreach ($options as $option)
                    <option>{{ $option }}</option>
                @endforeach
            </select>
        @elseif ($type === 'textarea')
            <textarea class="textarea" id="preview-{{ $id }}" placeholder="{{ $field['placeholder'] }}"></textarea>
        @else
            <input class="input" id="preview-{{ $id }}" type="{{ $type }}" placeholder="{{ $field['placeholder'] }}">
        @endif
    </div>
@endif
