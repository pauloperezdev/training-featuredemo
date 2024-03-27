{include file="page_header.tpl" pageTitle=$Grid.Title pageWithForm=true}
{assign var=isHorizontal value=false}

<div class="col-md-12 js-form-container" data-form-url="{$Grid.FormAction}&flash=true">

    <div class="row">
        <div class="js-form-collection {if $Grid.FormLayout->isHorizontal()}col-lg-8{else}col-md-8 col-md-offset-2{/if}">
            {foreach from=$Forms item=Form name=forms}
                {$Form}
                {if not $smarty.foreach.forms.last}<hr>{/if}
            {/foreach}
        </div>
    </div>

    {* <Custom template> *}

    <div class="form-actions row">
        <div class="col-md-12">
            <div class="row">
                <div class="{if $isHorizontal}col-sm-9 col-sm-offset-3{else}col-md-8 col-md-offset-2{/if}">
                    <div class="btn-toolbar">
                        <a class="btn btn-default" href="{$Grid.CancelUrl}">{$Captions->GetMessageString('Cancel')}</a>
                        <a href="#" class="btn btn-primary js-previous" disabled="disabled">{$Captions->GetMessageString('Previous')}</a>
                        <a href="#" class="btn btn-primary js-next">{$Captions->GetMessageString('Next')}</a>
                        <button type="submit" class="btn btn-primary js-save js-primary-save" data-action="open" data-url="{$Grid.CancelUrl}" style="display: none">
                            {$Captions->GetMessageString('Save')}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {* </Custom template> *}

</div>


