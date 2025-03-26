<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>

<script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/js/dropdown-hover.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;
        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }

    $(function() {
        $('body').on('click', '#delete-selected-btn', function(e) {
            var selected = new Array();

            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });

            if (selected.length > 0) {
                $('#delete-selected-modal').modal('show')
                $('input[id="ids"]').val(selected);
            }
        });
    });

    toastr.options = {
        'closeButton': true,
        'progressBar': true,
    }

    function initializeSelect2(modalId, elementId, value) {
        var select2Element = $('#' + modalId + ' #' + elementId);
        if (select2Element.length) {
            select2Element.wrap('<div class="position-relative"></div>').select2({
                placeholder: '{{ trans('schoolmanagement/grades.choose') }}',
                dropdownParent: select2Element.parent(),
            });
            select2Element.val(value).trigger('change');
        }
    }


    if ($(".flatpickr-input")) {
        $(".flatpickr-input").flatpickr({
            monthSelectorType: 'static'
        });
    }
    if ($(".flatpickr-datetime")) {
        $(".flatpickr-datetime").flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i'
        });
    }
</script>

<!--- Page JS -->
@yield('js')
