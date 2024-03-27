{assign var='ColumnViewData' value=$Col->getViewData()}
{assign var='Editor' value=$ColumnViewData.EditorViewData.Editor}
{assign var='EditorId' value=$Grid.FormId|cat:'_'|cat:$Editor->getName()}

<div class="form-group form-group-label col-sm-4">
    {include file='forms/field_label.tpl'}
</div>

<div class="form-group col-sm-8">
    <div class="col-input" style="width:100%;max-width:{$Editor->getMaxWidth()}" data-column="{$ColumnViewData.FieldName}">
        {include file='editors/'|cat:$Editor->getEditorName()|cat:'.tpl' Editor=$Editor ViewData=$ColumnViewData.EditorViewData FormId=$Grid.FormId id=$EditorId}
    </div>
</div>
