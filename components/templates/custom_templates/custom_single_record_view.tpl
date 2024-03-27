<div id="pgui-view-grid">
    {include file="page_header.tpl" pageTitle=$Grid.Title}

    <div class="{if $Grid.FormLayout->isHorizontal()}form-horizontal{/if}">

        {include file="forms/actions_view.tpl" top=true isHorizontal=$Grid.FormLayout->isHorizontal()}

        <div class="row">
            <div class="col-md-12 js-message-container"></div>
            <div class="clearfix"></div>
            <div class="form-static {if $Grid.FormLayout->isHorizontal()}form-horizontal col-lg-8{else}col-md-8 col-md-offset-2{/if}">
                <!--<Custom code>-->
                {assign var=Columns value=$Grid.FormLayout->getColumns()}
                <div class="demo-tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#common-tab" aria-controls="common-tab" role="tab" data-toggle="tab">
                            Common
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#dimensions-display-tab" aria-controls="dimensions-display-tab" role="tab" data-toggle="tab">
                            Dimensions & Display
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#hardware-software-tab" aria-controls="hardware-software-tab" role="tab" data-toggle="tab">
                            Hardware & Software
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#camera-battery-tab" aria-controls="camera-battery-tab" role="tab" data-toggle="tab">
                            Camera & Battery
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="common-tab">
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.model_name}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.release_year}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.release_month}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.colors}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.photo}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.photo_back}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="dimensions-display-tab">
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.height}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.length}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.width}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.weight}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.display_type}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.display_size}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.display_resolution_x}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.display_resolution_y}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="hardware-software-tab">
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.chipset}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.cpu}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.gpu}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.storage_min}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.storage_max}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.os_basic}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.os_upgradable}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.web_browser}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="camera-battery-tab">
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.camera_resolution}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.camera_video_max_x}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.camera_video_max_y}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.battery_type}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.battery_standby_max_time}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.battery_talk_max_time}
                        {include file="custom_templates/custom_form_view_column.tpl" Col=$Columns.battery_music_play_max_time}
                    </div>
                </div>
                </div>
                <!--</Custom code>-->
            </div>
        </div>

        {include file="forms/actions_view.tpl" top=false isHorizontal=$Grid.FormLayout->isHorizontal()}
    </div>
</div>
