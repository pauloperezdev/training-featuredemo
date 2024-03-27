<div class="modal-dialog {$modalSizeClass}">
    <div class="modal-content js-form-container">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{$Grid.Title}</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 js-form-collection">
                    {foreach from=$Forms item=Form name=forms}
                        {$Form}
                        {if not $smarty.foreach.forms.last}<hr>{/if}
                    {/foreach}
                </div>
            </div>

            {if $Grid.AllowAddMultipleRecords}
                <div class="row" style="margin-top: 20px">
                    <a href="#" class="js-form-add col-md-12{if $Grid.FormLayout->isHorizontal()} col-md-offset-3{/if}">
                        <span class="icon-plus"></span> {$Captions->GetMessageString('FormAdd')}
                    </a>
                </div>
            {/if}
        </div>

        <div class="modal-footer">
            <div class="btn-toolbar pull-right">

		{* <Custom template> *}

                <button class="btn btn-default" data-dismiss="modal" aria-label="Close">
                    {$Captions->GetMessageString('Cancel')}
                </button>

                <a href="#" class="btn btn-default js-save js-multiple-insert-hide" data-action="edit">{$Captions->GetMessageString('SaveAndEdit')}</a>

                <button type="submit" class="btn btn-primary js-save js-primary-save">
                    {$Captions->GetMessageString('Save')}
                </button>

		{* </Custom template> *}

            </div>
        </div>

        {include file='forms/form_scripts.tpl'}
    </div>
</div>
