<div class="row">
    <div class="form-group form-group-label col-sm-3">
        <label class="control-label">
            {$Col->getCaption()}
        </label>
    </div>

    <div class="form-group col-sm-9">
        <div class="form-control-static">
            {$Col->getDisplayValue($Renderer)}
        </div>
    </div>
</div>
