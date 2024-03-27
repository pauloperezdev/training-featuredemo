<form id="{$Grid.FormId}" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{$Grid.FormAction}">

    {if not $isEditOperation and $Grid.AllowAddMultipleRecords}
        <div class="btn-group pull-right form-collection-actions">
            <button type="button" class="btn btn-default icon-copy js-form-copy" title="Copy"></button>
            <button type="button" class="btn btn-default icon-remove js-form-remove" style="display: none" title="Delete"></button>
        </div>
    {/if}
    <div class="clearfix"></div>

    {include file='common/messages_block.tpl' GridMessages=$Grid}

    {* <Custom template> *}

    {assign var=isViewForm value=false}
    <div class="row">
        {foreach item=Column from=$Grid.FormLayout->getColumns()}
            {include file="custom_templates/custom_form_column.tpl" Col=$Column}
        {/foreach}

        <div class="form-group col-sm-12">
            <hr />
        </div>

        <div class="form-group form-group-label col-sm-4">
            <label class="control-label">
                Genres
            </label>
        </div>
        <div class="form-group col-sm-8">
            <div class="col-input" style="width:100%;max-width:100%" data-column="genres">
                <select class="form-control" name="genres_edit[]" multiple data-max-selection-size="0" data-editor="multivalue_select">
                    {foreach item=Genre from=$Genres}
                        <option value="{$Genre.id}" {if $Genre.id|in_array:$MovieGenres} selected{/if}>{$Genre.name}</option>
                    {/foreach}
                </select>
            </div>
        </div>

    </div>

    {foreach key=HiddenValueName item=HiddenValue from=$HiddenValues}
        <input type="hidden" name="{$HiddenValueName}" value="{$HiddenValue}" />
    {/foreach}

    {* </Custom template> *}

    {if $flashMessages}
        <input type="hidden" name="flash_messages" value="1" />
    {/if}

    <div class="row">
        <div class="col-md-12 form-error-container"></div>
    </div>

    {include file='forms/form_scripts.tpl'}

</form>