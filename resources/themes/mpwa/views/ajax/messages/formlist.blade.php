<div class="form-group">
    <label for="message" class="form-label">{{ __('Message') }}</label>
    <textarea type="text" name="message" class="form-control" id="message" required></textarea>
</div>

<div class="form-group">
    <label for="buttontext" class="form-label">{{ __('Button') }}</label>
    <input type="text" name="buttontext" class="form-control" id="buttonlist">
</div>

<div class="form-group">
    <label for="name" class="form-label">{{ __('Name List') }}</label>
    <input type="text" name="name" class="form-control" id="namelist" required>
</div>

<div id="sections-area"></div>

<button type="button" id="add-section" class="btn btn-success btn-sm mt-4">{{ __('Add Section') }}</button>

<script>
(function ($) {
    let sectionIndex = 0;

    $('#add-section').click(function () {
        const sectionHtml = `
        <div class="card mb-3 section" id="section${sectionIndex}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ __('Section') }} ${sectionIndex + 1}</strong>
                <a class="remove-section" data-section="${sectionIndex}">
                    <i class="bi bi-trash text-danger"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="titlelist${sectionIndex}" class="form-label">{{ __('Title List') }}</label>
                    <input type="text" name="sections[${sectionIndex}][title]" class="form-control" id="titlelist${sectionIndex}" required>
                </div>
                <div class="rows-wrapper" id="rows-wrapper${sectionIndex}"></div>
                <button type="button" class="btn btn-primary btn-sm mt-2 add-row" data-section="${sectionIndex}">{{ __('Add Row') }}</button>
            </div>
        </div>`;
        $('#sections-area').append(sectionHtml);
        sectionIndex++;
    });

    // Remove Section
    $(document).on('click', '.remove-section', function () {
        const sectionId = $(this).data('section');
        $(`#section${sectionId}`).remove();
    });

    // Add Row
    $(document).on('click', '.add-row', function () {
        const sectionId = $(this).data('section');
        const rowsWrapper = $(`#rows-wrapper${sectionId}`);
        const rowCount = rowsWrapper.children().length;
        const rowHtml = `
        <div class="row-input mb-3" id="row${sectionId}-${rowCount}">
            <div class="d-flex align-items-center">
                <input type="text" name="sections[${sectionId}][rows][${rowCount}][title]" class="form-control me-2" placeholder="{{ __('Row Title') }}" required>
                <input type="text" name="sections[${sectionId}][rows][${rowCount}][description]" class="form-control me-2" placeholder="{{ __('Row Description') }}">
                <a class="remove-row ms-2" data-section="${sectionId}" data-row="${rowCount}">
                    <i class="bi bi-trash text-danger"></i>
                </a>
            </div>
        </div>`;
        rowsWrapper.append(rowHtml);
    });

    // Remove Row
    $(document).on('click', '.remove-row', function () {
        const sectionId = $(this).data('section');
        const rowId = $(this).data('row');
        $(`#row${sectionId}-${rowId}`).remove();
    });
})(jQuery);
</script>
