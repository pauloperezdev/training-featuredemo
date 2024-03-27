<div class="row">
    {foreach from=$Forms item=Form name=forms}
        <div class="col-md-12">
            {$Form}
            {if not $smarty.foreach.forms.last}<hr>{/if}
        </div>
    {/foreach}
</div>

<div class="btn-toolbar pull-right">

    <button class="btn btn-default js-cancel">
        {$Captions->GetMessageString('Cancel')}
    </button>

    {* <Custom template> *}

    <a href="#" class="btn btn-default js-save" data-action="edit">{$Captions->GetMessageString('SaveAndEdit')}</a>

    <button type="submit" class="btn btn-primary js-save js-primary-save">
        {$Captions->GetMessageString('Save')}
    </button>

    {* </Custom template> *}

</div>