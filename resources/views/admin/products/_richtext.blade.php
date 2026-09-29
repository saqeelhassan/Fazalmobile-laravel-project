{{--
    Rich text field backed by Quill. Renders a visual editor; the actual
    HTML that gets submitted lives in a hidden textarea with the real
    field `name`, kept in sync via the 'text-change' event and on submit.

    Props: $name, $value, $height (css height for the editor), $formId (optional, for fields outside the <form> tag)
--}}
@php
    $editorId = 'rte_' . $name . '_editor';
    $inputId  = 'rte_' . $name . '_input';
@endphp
<div id="{{ $editorId }}" class="rte-editor" style="height:{{ $height ?? '120px' }}"></div>
<textarea name="{{ $name }}" id="{{ $inputId }}" style="display:none" @if(!empty($formId)) form="{{ $formId }}" @endif>{{ $value }}</textarea>

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css">
        <style>
            .rte-editor { background:#fff; border-radius:0 0 8px 8px; font-size:13.5px }
            .ql-toolbar.ql-snow { border-radius:8px 8px 0 0; background:#f9fafb }
            .ql-container.ql-snow { border-color:#d1d5db }
            .ql-toolbar.ql-snow { border-color:#d1d5db }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    @endpush
@endonce

@push('scripts')
<script>
    (function () {
        function init() {
            var editorEl = document.getElementById('{{ $editorId }}');
            var inputEl  = document.getElementById('{{ $inputId }}');
            if (!editorEl || !inputEl || editorEl.dataset.rteInit) return;
            editorEl.dataset.rteInit = '1';

            var quill = new Quill(editorEl, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ header: [3, false] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            if (inputEl.value.trim()) {
                quill.clipboard.dangerouslyPasteHTML(inputEl.value);
            }

            quill.on('text-change', function () {
                var html = quill.root.innerHTML;
                inputEl.value = (html === '<p><br></p>') ? '' : html;
            });

            var form = inputEl.closest('form') || document.getElementById(inputEl.getAttribute('form'));
            if (form) {
                form.addEventListener('submit', function () {
                    var html = quill.root.innerHTML;
                    inputEl.value = (html === '<p><br></p>') ? '' : html;
                });
            }
        }

        if (window.Quill) { init(); } else { window.addEventListener('load', init); }
    })();
</script>
@endpush
