{include file="page_header.tpl" pageTitle=$Grid.Title pageWithForm=true}
{assign var=isHorizontal value=false}

<div class="col-md-12 js-form-container" data-form-url="{$Grid.FormAction}&flash=true">

    {* <Custom template> *}

    <div class="form-actions form-actions-top row">
        <div class="col-md-12">
            <div class="row">
                <div class="{if $isHorizontal}col-sm-9 col-sm-offset-3{else}col-md-8 col-md-offset-2{/if}">
                    <div class="btn-toolbar">
                        <button type="submit" class="btn btn-primary js-save js-primary-save" data-action="open" data-url="{$Grid.CancelUrl}">
                            {$Captions->GetMessageString('Save')}
                        </button>
                        <a href="#" class="btn btn-default js-save js-multiple-insert-hide" data-action="edit">{$Captions->GetMessageString('SaveAndEdit')}</a>
                        <a class="btn btn-default" href="{$Grid.CancelUrl}">{$Captions->GetMessageString('Cancel')}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {* </Custom template> *}

    <div class="row">
        <div class="js-form-collection {if $Grid.FormLayout->isHorizontal()}col-lg-8{else}col-md-8 col-md-offset-2{/if}">
            {foreach from=$Forms item=Form name=forms}
                {$Form}
                {if not $smarty.foreach.forms.last}<hr>{/if}
            {/foreach}
        </div>
    </div>

    {if $Grid.AllowAddMultipleRecords}
        <div class="row" style="margin-top: 20px">
            <div class="{if $Grid.FormLayout->isHorizontal()}col-lg-8{else}col-md-8 col-md-offset-2{/if}">
                <a href="#" class="js-form-add{if $Grid.FormLayout->isHorizontal()} col-md-offset-3{/if}"><span class="icon-plus"></span> add another record</a>
            </div>
        </div>
    {/if}

    {* <Custom template> *}

    <div class="form-actions row">
        <div class="col-md-12">
            <div class="row">
                <div class="{if $isHorizontal}col-sm-9 col-sm-offset-3{else}col-md-8 col-md-offset-2{/if}">
                    <div class="btn-toolbar">
                        <button type="submit" class="btn btn-primary js-save js-primary-save" data-action="open" data-url="{$Grid.CancelUrl}">
                            {$Captions->GetMessageString('Save')}
                        </button>
                        <a href="#" class="btn btn-default js-save js-multiple-insert-hide" data-action="edit">{$Captions->GetMessageString('SaveAndEdit')}</a>
                        <a class="btn btn-default" href="{$Grid.CancelUrl}">{$Captions->GetMessageString('Cancel')}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {* </Custom template> *}

</div>


