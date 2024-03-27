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
        {assign var=Columns value=$Grid.FormLayout->getColumns()}

        <div class="stepwizard col-sm-offset-2 col-sm-10">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle" data-step-number="1">
                        About
                    </a>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled" data-step-number="2">
                        Additional info
                    </a>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled" data-step-number="3">
                        Media
                    </a>
                </div>
            </div>
        </div>

        <div class="setup-content-container">
            <div class="row setup-content" id="step-1">
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.title}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.overview}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.original_language_id}
            </div>
            <div class="row setup-content" id="step-2" style="display: none">
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.release_date}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.genre_id}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.runtime}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.rating}
            </div>
            <div class="row setup-content" id="step-3" style="display: none">
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.poster}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.trailer}
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