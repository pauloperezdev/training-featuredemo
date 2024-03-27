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
        <div style="margin: 0px 20px;">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#about-{$Grid.FormId}" aria-controls="about-{$Grid.FormId}" role="tab" data-toggle="tab">About</a></li>
            <li role="presentation"><a href="#add-info-{$Grid.FormId}" aria-controls="add-info-{$Grid.FormId}" role="tab" data-toggle="tab">Additional info</a></li>
            <li role="presentation"><a href="#media-{$Grid.FormId}" aria-controls="media-{$Grid.FormId}" role="tab" data-toggle="tab">Media</a></li>
          </ul>

          <div class="tab-content" style="margin-top: 20px; min-height: 350px">
            <div role="tabpanel" class="tab-pane active" id="about-{$Grid.FormId}">
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.title}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.original_title}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.tagline}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.overview}
            </div>
            <div role="tabpanel" class="tab-pane" id="add-info-{$Grid.FormId}">
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.release_date}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.original_language_id}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.genre_id}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.runtime}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.rating}
            </div>
            <div role="tabpanel" class="tab-pane" id="media-{$Grid.FormId}">
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.poster}
                {include file="custom_templates/custom_form_column.tpl" Col=$Columns.trailer}
            </div>
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