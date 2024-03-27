<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/Argentina/Buenos_Aires');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => 'localhost',
          'port' => '3306',
          'username' => 'root',
          'database' => 'test1',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return false;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return '';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'Data Grid', 'description' => '');
    $result[] = array('caption' => 'Grid Columns', 'description' => '');
    $result[] = array('caption' => 'Grid Options', 'description' => '');
    $result[] = array('caption' => 'Data Sources', 'description' => '');
    $result[] = array('caption' => 'Master-Detail Views', 'description' => '');
    $result[] = array('caption' => 'Data Input Forms', 'description' => '');
    $result[] = array('caption' => 'Editors', 'description' => '');
    $result[] = array('caption' => 'Data Filtering', 'description' => '');
    $result[] = array('caption' => 'Sorting', 'description' => '');
    $result[] = array('caption' => 'Partitioning', 'description' => '');
    $result[] = array('caption' => 'Exporting & Printing', 'description' => '');
    $result[] = array('caption' => 'Image Management', 'description' => '');
    $result[] = array('caption' => 'Charts', 'description' => '');
    $result[] = array('caption' => 'Many-to-Many Relations', 'description' => '');
    $result[] = array('caption' => 'Fine-tuning & Tweaking', 'description' => '');
    $result[] = array('caption' => 'Emailing', 'description' => '');
    $result[] = array('caption' => 'Calculated Columns', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Table View', 'short_caption' => 'Data Grid.Table View', 'filename' => 'data_grid_table_view.php', 'name' => 'v_data_grid_table_view', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Card View', 'short_caption' => 'Data Grid.Card View', 'filename' => 'data_grid_card_view.php', 'name' => 'v_data_grid_card_view', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Autohiding Columns', 'short_caption' => 'Data Grid.Autohiding Columns', 'filename' => 'data_grid_autohiding_columns.php', 'name' => 'v_data_grid_autohiding_columns', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Totals', 'short_caption' => 'Data Grid.Totals', 'filename' => 'data_grid_totals.php', 'name' => 'v_data_grid_totals', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Grid Header', 'short_caption' => 'Data Grid.Grid Header', 'filename' => 'data_grid_header.php', 'name' => 'v_data_grid_header', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Column Grouping', 'short_caption' => 'Data Grid.Column Grouping', 'filename' => 'data_grid_column_grouping.php', 'name' => 'movies01', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Record Comparison', 'short_caption' => 'Data Grid.Record Comparison', 'filename' => 'data_grid_record_comparison.php', 'name' => 'phone', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Unicode Support', 'short_caption' => 'Data Grid.Unicode Support', 'filename' => 'data_grid_unicode_support.php', 'name' => 'v_data_grid_unicode_support_2', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'RSS', 'short_caption' => 'Data Grid.RSS', 'filename' => 'data_grid_rss.php', 'name' => 'v_data_grid_rss', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Drawing', 'short_caption' => 'Data Grid.Custom Drawing', 'filename' => 'data_grid_custom_drawing.php', 'name' => 'v_data_grid_custom_row', 'group_name' => 'Data Grid', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Custom Table Template', 'short_caption' => 'Data Grid.Custom Table Template', 'filename' => 'data_grid_custom_table_template.php', 'name' => 'v_data_grid_custom_table_template', 'group_name' => 'Data Grid', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Custom Card Template', 'short_caption' => 'Data Grid.Custom Card Template', 'filename' => 'data_grid_custom_card_template.php', 'name' => 'v_data_grid_custom_card_template', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Toolbar Template', 'short_caption' => 'Data Grid.Custom Grid Toolbar Template', 'filename' => 'data_grid_custom_grid_toolbar_template.php', 'name' => 'v_data_grid_custom_grid_toolbar_template', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom View Form', 'short_caption' => 'Data Grid.Custom Single Record View', 'filename' => 'data_grid_custom_single_record_view.php', 'name' => 'v_data_grid_custom_single_record_view', 'group_name' => 'Data Grid', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Fixed Grid Width', 'short_caption' => 'Grid Options.Fixed Grid Width', 'filename' => 'data_grid_fixed_grid_width.php', 'name' => 'v_data_grid_fixed_grid_width', 'group_name' => 'Grid Options', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Fixed Column Header', 'short_caption' => 'Grid Options.Fixed Column Header', 'filename' => 'data_grid_fixed_column_header.php', 'name' => 'v_data_grid_fixed_header', 'group_name' => 'Grid Options', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Bordered Table', 'short_caption' => 'Grid Options.Bordered Table', 'filename' => 'data_grid_bordered_table.php', 'name' => 'v_data_grid_bordered_table', 'group_name' => 'Grid Options', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Condensed Table', 'short_caption' => 'Grid Options.Condensed Table', 'filename' => 'data_grid_condensed_table.php', 'name' => 'v_data_grid_condensed_table', 'group_name' => 'Grid Options', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Line Numbers', 'short_caption' => 'Grid Options.Line Numbers', 'filename' => 'data_grid_line_numbers.php', 'name' => 'v_data_grid_line_numbers', 'group_name' => 'Grid Options', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Control Buttons Position', 'short_caption' => 'Grid Options.Control Buttons Position', 'filename' => 'data_grid_control_buttons_position.php', 'name' => 'v_data_grid_options', 'group_name' => 'Grid Options', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Master/Detail Basics', 'short_caption' => 'Master-Detail Views.Basic Example', 'filename' => 'master_detail_basic_example.php', 'name' => 'genres', 'group_name' => 'Master-Detail Views', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Multiple Details', 'short_caption' => 'Master-Detail Views.Multiple Details', 'filename' => 'master_detail_multiple_details.php', 'name' => 'v_master_detail_multiple_details', 'group_name' => 'Master-Detail Views', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Nested Details', 'short_caption' => 'Master-Detail Views.Nested Details', 'filename' => 'master_detail_nested_details.php', 'name' => 'q_master_detail_nested', 'group_name' => 'Master-Detail Views', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Card Mode Details', 'short_caption' => 'Master-Detail Views.Card Mode Details', 'filename' => 'master_detail_card_mode_details.php', 'name' => 'movies03', 'group_name' => 'Master-Detail Views', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Separate Page', 'short_caption' => 'Data Input Forms.Separate Page', 'filename' => 'data_editing_separate_page.php', 'name' => 'v_data_editing_separate_page', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Modal Window', 'short_caption' => 'Data Input Forms.Modal Window', 'filename' => 'data_editing_modal_window.php', 'name' => 'v_data_editing_modal_window', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Inline Editing', 'short_caption' => 'Data Input Forms.Inline Editing', 'filename' => 'data_editing_inline_editing.php', 'name' => 'v_data_editing_inline', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Form Layouts', 'short_caption' => 'Data Input Forms.Custom Form Layouts', 'filename' => 'data_editing_custom_form_layouts.php', 'name' => 'phone01', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Tabbed Forms', 'short_caption' => 'Data Input Forms.Tabbed Forms', 'filename' => 'data_editing_tabbed_forms.php', 'name' => 'v_data_editing_tabbed_forms', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Separate Page', 'short_caption' => 'Data Input Forms.Custom Separate Page', 'filename' => 'data_editing_custom_separate_page.php', 'name' => 'v_data_editing_custom_form_template', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Modal Dialog', 'short_caption' => 'Data Input Forms.Custom Modal Dialog', 'filename' => 'data_editing_custom_modal_dialog.php', 'name' => 'v_data_editing_custom_form_template01', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Inline Form', 'short_caption' => 'Data Input Forms.Custom Inline Form', 'filename' => 'data_editing_custom_inline_form.php', 'name' => 'v_data_editing_custom_form_template02', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Wizard Form ', 'short_caption' => 'Data Input Forms.Wizard Form', 'filename' => 'data_editing_wizard_form.php', 'name' => 'v_data_editing_form_wizard', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Adding multiple records', 'short_caption' => 'Data Input Forms.Adding multiple records', 'filename' => 'data_editing_multiple_insert.php', 'name' => 'v_data_editing_multiple_insert', 'group_name' => 'Data Input Forms', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Editors Overview', 'short_caption' => 'Data Input Forms.Editors Overview', 'filename' => 'data_editing_editors.php', 'name' => 'v_data_editing_editors', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Validation', 'short_caption' => 'Data Input Forms.Validation', 'filename' => 'data_editing_validation.php', 'name' => 'v_data_editing_validation', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Client-side API', 'short_caption' => 'Data Input Forms.Client-side API', 'filename' => 'data_editing_clientside_api.php', 'name' => 'v_data_editing_clientside_api', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Dependent Lookups', 'short_caption' => 'Data Input Forms.Dependent Lookups', 'filename' => 'data_editing_dependent_lookups.php', 'name' => 'v_data_editing_dependent_lookups', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'On-the-Fly Adding', 'short_caption' => 'Data Input Forms.On-the-Fly Adding', 'filename' => 'data_editing_on_the_fly_adding.php', 'name' => 'city', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Quick Edit', 'short_caption' => 'Data Input Forms.Quick Edit', 'filename' => 'data_editing_quick_edit.php', 'name' => 'v_data_editing_quick_edit', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Multi Edit', 'short_caption' => 'Data Input Forms.Multi Edit', 'filename' => 'data_editing_multi_edit.php', 'name' => 'v_data_editing_multi_edit', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Default Values', 'short_caption' => 'Data Input Forms.Custom Default Values', 'filename' => 'data_editing_custom_default_values.php', 'name' => 'v_data_editing_custom_default_values', 'group_name' => 'Data Input Forms', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Range', 'short_caption' => 'Partitioning.Range', 'filename' => 'data_partitioning_range.php', 'name' => 'v_data_partitioning_range', 'group_name' => 'Partitioning', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'List', 'short_caption' => 'Partitioning.List', 'filename' => 'data_partitioning_list.php', 'name' => 'v_data_partitioning_list', 'group_name' => 'Partitioning', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom', 'short_caption' => 'Partitioning.Custom', 'filename' => 'data_partitioning_custom.php', 'name' => 'v_data_partitioning_custom', 'group_name' => 'Partitioning', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Pie Chart', 'short_caption' => 'Charts.Pie', 'filename' => 'charts_pie.php', 'name' => 'v_charts_pie', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Column Chart', 'short_caption' => 'Charts.Column', 'filename' => 'charts_column.php', 'name' => 'v_charts_column', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Bar Chart', 'short_caption' => 'Charts.Bar', 'filename' => 'charts_bar.php', 'name' => 'v_charts_bar', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Line Chart', 'short_caption' => 'Charts.Line', 'filename' => 'charts_line.php', 'name' => 'v_charts_line', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Area Chart', 'short_caption' => 'Charts.Area', 'filename' => 'charts_area.php', 'name' => 'v_charts_area', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Geo Charts', 'short_caption' => 'Charts.Geo', 'filename' => 'charts_geo.php', 'name' => 'q_life_expectancy_by_country', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Stepped Area', 'short_caption' => 'Charts.Stepped Area', 'filename' => 'charts_stepped_area.php', 'name' => 'v_charts_stepped_area', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Candlestick', 'short_caption' => 'Charts.Candlestick', 'filename' => 'charts_candlestick.php', 'name' => 'v_charts_candlestick', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Histogram', 'short_caption' => 'Charts.Histogram', 'filename' => 'charts_histogram.php', 'name' => 'v_charts_histogram', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Bubble', 'short_caption' => 'Charts.Bubble', 'filename' => 'charts_bubble.php', 'name' => 'v_charts_bubble', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Timeline', 'short_caption' => 'Charts.Timeline', 'filename' => 'charts_timeline.php', 'name' => 'v_charts_timeline', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Gantt', 'short_caption' => 'Charts.Gantt', 'filename' => 'charts_gantt.php', 'name' => 'v_charts_gantt', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Scatter', 'short_caption' => 'Charts.Scatter', 'filename' => 'charts_scatter.php', 'name' => 'v_charts_scatter', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Tree Map', 'short_caption' => 'Charts.Tree Map', 'filename' => 'charts_tree_map.php', 'name' => 'v_charts_tree_map', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Multiple Charts', 'short_caption' => 'Charts.Multiple Charts', 'filename' => 'charts_multiple_charts.php', 'name' => 'v_charts_multiple_charts', 'group_name' => 'Charts', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Chart Placement', 'short_caption' => 'Charts.Chart Placement', 'filename' => 'charts_chart_placement.php', 'name' => 'v_charts_chart_location', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Customizing Charts', 'short_caption' => 'Charts.Customizing Charts', 'filename' => 'charts_customizing_charts.php', 'name' => 'v_charts_customizing_charts', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Dashboard', 'short_caption' => 'Charts.Dashboard', 'filename' => 'charts_dashboard.php', 'name' => 'v_charts_dashboard', 'group_name' => 'Charts', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Column Types', 'short_caption' => 'Grid Columns.Column Types', 'filename' => 'data_grid_columns_column_types.php', 'name' => 'v_data_grid_columns_column_types', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Text Truncating', 'short_caption' => 'Grid Columns.Text Truncating', 'filename' => 'data_grid_columns_text_truncating.php', 'name' => 'v_data_grid_columns_text_truncating', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Column Fixed Width', 'short_caption' => 'Grid Columns.Column Fixed Width', 'filename' => 'data_grid_columns_column_fixed_width.php', 'name' => 'v_data_grid_columns_column_fixed_width', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Formatting', 'short_caption' => 'Grid Columns.Formatting', 'filename' => 'data_grid_columns_formatting.php', 'name' => 'v_data_grid_columns_formatting', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Null Label', 'short_caption' => 'Grid Columns.Null Label', 'filename' => 'data_grid_columns_null_label.php', 'name' => 'v_data_grid_columns_null_label', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Hyperlinks', 'short_caption' => 'Grid Columns.Hyperlinks', 'filename' => 'data_grid_columns_hyperlinks.php', 'name' => 'v_data_grid_columns_hyperlinks', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Html Display', 'short_caption' => 'Grid Columns.HTML Display', 'filename' => 'data_grid_columns_html_display.php', 'name' => 'v_html_display', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Lookup Data View', 'short_caption' => 'Grid Columns.Lookup Data View', 'filename' => 'data_grid_columns_lookup_data_view.php', 'name' => 'v_data_grid_columns_lookup_data_view', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Rendering', 'short_caption' => 'Grid Columns.Custom Rendering', 'filename' => 'data_grid_columns_custom_rendering.php', 'name' => 'v_data_grid_columns_custom_render', 'group_name' => 'Grid Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Sort By Click', 'short_caption' => 'Sorting.By Click', 'filename' => 'data_sorting_by_click.php', 'name' => 'v_data_sorting_by_click', 'group_name' => 'Sorting', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Sort By Dialog', 'short_caption' => 'Sorting.By Dialog', 'filename' => 'data_sorting_by_dialog.php', 'name' => 'v_data_sorting_by_dialog', 'group_name' => 'Sorting', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Default Sort Order', 'short_caption' => 'Sorting.Default Sort Order', 'filename' => 'data_sorting_default_sort_order.php', 'name' => 'v_data_sorting_initial_order', 'group_name' => 'Sorting', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Quick Filter', 'short_caption' => 'Filtering.Quick Filter', 'filename' => 'data_filtering_quick_filter.php', 'name' => 'v_data_filtering_quick_filter', 'group_name' => 'Data Filtering', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Filter Builder', 'short_caption' => 'Filtering.Filter Builder', 'filename' => 'data_filtering_filter_builder.php', 'name' => 'movies02', 'group_name' => 'Data Filtering', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Column Filter', 'short_caption' => 'Filtering.Column Filter', 'filename' => 'data_filtering_column_filter.php', 'name' => 'movies', 'group_name' => 'Data Filtering', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Preliminary Filter', 'short_caption' => 'Filtering.Preliminary Filter', 'filename' => 'filtering_preliminary_filter.php', 'name' => 'v_filtering_ask_condition', 'group_name' => 'Data Filtering', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Selection Filters', 'short_caption' => 'Filtering.Selection Filters', 'filename' => 'filtering_selection_filters.php', 'name' => 'v_filtering_selection_filters', 'group_name' => 'Data Filtering', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Filter - 1', 'short_caption' => 'Filtering.Custom Filter (Simple Version)', 'filename' => 'filtering_custom_filter_simple.php', 'name' => 'v_filtering_custom_filter', 'group_name' => 'Data Filtering', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Filter - 2', 'short_caption' => 'Filtering.Custom Filter (Advanced Version)', 'filename' => 'filtering_custom_filter_advanced.php', 'name' => 'v_filtering_custom_filter2', 'group_name' => 'Data Filtering', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Grid', 'short_caption' => 'Exporting & Printing.Grid', 'filename' => 'data_exporting_grid.php', 'name' => 'v_data_exporting_export_grid', 'group_name' => 'Exporting & Printing', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Single Record', 'short_caption' => 'Exporting & Printing.Single Record', 'filename' => 'data_exporting_single_record.php', 'name' => 'v_data_exporting_export_record_from_grid', 'group_name' => 'Exporting & Printing', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Export Options', 'short_caption' => 'Exporting & Printing.Export Options', 'filename' => 'data_exporting_export_options.php', 'name' => 'v_data_exporting_export_options', 'group_name' => 'Exporting & Printing', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Custom Grid', 'short_caption' => 'Exporting & Printing.Custom Grid', 'filename' => 'data_exporting_custom_grid.php', 'name' => 'v_data_exporting_custom_template', 'group_name' => 'Exporting & Printing', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Single Record', 'short_caption' => 'Exporting & Printing.Custom Single Record', 'filename' => 'data_exporting_custom_single_record.php', 'name' => 'invoice_header', 'group_name' => 'Exporting & Printing', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'User Defined Styles', 'short_caption' => 'Exporting & Printing.User Defined Styles', 'filename' => 'data_exporting_user_defined_styles.php', 'name' => 'v_data_exporting_user_defined_styles', 'group_name' => 'Exporting & Printing', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Icons', 'short_caption' => 'Fine-tuning & Tweaking.Custom Icons', 'filename' => 'tweaking_custom_icons.php', 'name' => 'v_tweaking_custom_icons', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Theme', 'short_caption' => 'Fine-tuning & Tweaking.Custom Theme', 'filename' => 'tweaking_custom_theme.php', 'name' => 'v_tweaking_custom_theme', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Custom Editor', 'short_caption' => 'Fine-tuning & Tweaking.Custom Editor', 'filename' => 'tweaking_custom_editor.php', 'name' => 'v_custom_editor', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Page Embedding', 'short_caption' => 'Embedded Page', 'filename' => 'tweaking_embedding_via_iframe.php', 'name' => 'v_tweaking_embedding_via_iframe', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Ajax-based Validation', 'short_caption' => 'Fine-tuning & Tweaking.Ajax-based Validation', 'filename' => 'tweaking_ajax_based_validation.php', 'name' => 'v_tweaking_ajax_based_validation', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Color Themes', 'short_caption' => 'Fine-tuning & Tweaking.Color Themes', 'filename' => 'color_themes.php', 'name' => 'v_color_themes', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Inline Button', 'short_caption' => 'Fine-tuning & Tweaking.Inline Button', 'filename' => 'tweaking_inline_button.php', 'name' => 'v_tweaking_inline_button', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Conditional Details', 'short_caption' => 'Fine-tuning & Tweaking.Conditional Details', 'filename' => 'tweaking_conditional_details.php', 'name' => 'v_tweaking_conditional_hiding_details', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Using Ajax in Forms', 'short_caption' => 'Fine-tuning & Tweaking.Using Ajax in Data Input Forms', 'filename' => 'tweaking_using_ajax_in_data_input_forms.php', 'name' => 'v_tweaking_ajax_using', 'group_name' => 'Fine-tuning & Tweaking', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Classic Junction Table', 'short_caption' => 'Many-to-Many.Classic Junction Table', 'filename' => 'many_to_many_classic_junction_table.php', 'name' => 'v_tweaking_many_to_many2', 'group_name' => 'Many-to-Many Relations', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Handling Extra Columns', 'short_caption' => 'Many-to-Many.Handling Extra Columns', 'filename' => 'many_to_many_handling_extra_columns.php', 'name' => 'v_tweaking_many_to_many', 'group_name' => 'Many-to-Many Relations', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Text', 'short_caption' => 'Editors.Text', 'filename' => 'editors_text.php', 'name' => 'v_editors_text', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Autocomplete', 'short_caption' => 'Editors.Autocomplete', 'filename' => 'editors_autocomplete.php', 'name' => 'places', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Text Area', 'short_caption' => 'Editors.Text Area', 'filename' => 'editors_text_area.php', 'name' => 'v_editors_text_area', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'HTML Wysiwyg', 'short_caption' => 'Editors.HTML Wysiwyg', 'filename' => 'editors_wysiwyg.php', 'name' => 'editors_wysiwyg', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Spin & Range', 'short_caption' => 'Editors.Spin & Range', 'filename' => 'editors_spin_range.php', 'name' => 'v_editors_spin_range', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Upload To Folder', 'short_caption' => 'Editors.Upload To Folder', 'filename' => 'editors_upload_to_folder.php', 'name' => 'v_editors_upload_to_folder', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Radio Group', 'short_caption' => 'Editors.Radio Group', 'filename' => 'editors_radio_group.php', 'name' => 'v_editors_radio_group', 'group_name' => 'Editors', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Combobox', 'short_caption' => 'Editors.Combobox', 'filename' => 'editors_combobox.php', 'name' => 'v_editors_combobox', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Dynamic Combobox', 'short_caption' => 'Editors.Dynamic Combobox', 'filename' => 'editors_dynamic_combobox.php', 'name' => 'v_editors_autocomplete', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Cascading Combobox', 'short_caption' => 'Editors.Cascading Combobox', 'filename' => 'editors_cascading_combobox.php', 'name' => 'v_editors_cascading_combobox', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Dynamic Cascading Combobox', 'short_caption' => 'Editors.Dynamic Cascading Combobox', 'filename' => 'editors_dynamic_cascading_combobox.php', 'name' => 'sister_cities', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Multiple Select', 'short_caption' => 'Editors.Multiple Select', 'filename' => 'editors_multiple_select.php', 'name' => 'v_editors_multiple_select', 'group_name' => 'Editors', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Checkbox Group', 'short_caption' => 'Editors.Checkbox Group', 'filename' => 'editors_checkbox_group.php', 'name' => 'v_editors_checkbox_group', 'group_name' => 'Editors', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Common Properties', 'short_caption' => 'Editors.Common Properties', 'filename' => 'editors_common_properties.php', 'name' => 'v_editors_common_properties', 'group_name' => 'Editors', 'add_separator' => true, 'description' => '');
    $result[] = array('caption' => 'Table', 'short_caption' => 'Data Sources.Table', 'filename' => 'data_sources_table.php', 'name' => 'customer', 'group_name' => 'Data Sources', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'View', 'short_caption' => 'Data Sources.View', 'filename' => 'data_sources_view.php', 'name' => 'v_data_sources_view', 'group_name' => 'Data Sources', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Non-Updatable Query', 'short_caption' => 'Data Sources.Non-Updatable Query', 'filename' => 'data_sources_non_updatable_query.php', 'name' => 'data_sources_non_updatable_query', 'group_name' => 'Data Sources', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Updatable Query', 'short_caption' => 'Data Sources.Updatable Query', 'filename' => 'data_sources_updatable_query.php', 'name' => 'data_sources_updatable_query', 'group_name' => 'Data Sources', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Updatable View', 'short_caption' => 'Data Sources.Updatable View', 'filename' => 'data_sources_updatable_view.php', 'name' => 'v_data_sources_updatable_view', 'group_name' => 'Data Sources', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Basic Usage', 'short_caption' => 'Emailing.Basic Usage', 'filename' => 'emailing_basic_usage.php', 'name' => 'v_emailing_basic_usage', 'group_name' => 'Emailing', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Advanced Usage', 'short_caption' => 'Emailing.Advanced Usage', 'filename' => 'emailing_advanced_usage.php', 'name' => 'v_emailing_advanced_usage', 'group_name' => 'Emailing', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Example - 1', 'short_caption' => 'Calculated Columns.Example - 1', 'filename' => 'calculated_columns1.php', 'name' => 'v_calculated_columns1', 'group_name' => 'Calculated Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Example - 2', 'short_caption' => 'Calculated Columns.Example - 2', 'filename' => 'calculated_columns2.php', 'name' => 'v_calculated_columns2', 'group_name' => 'Calculated Columns', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Image Galleries', 'short_caption' => 'Image Management.Image Galleries', 'filename' => 'image_management_image_gallery.php', 'name' => 'phone02', 'group_name' => 'Image Management', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Thumbnails', 'short_caption' => 'Image Management.Thumbnails', 'filename' => 'image_management_thumbnails.php', 'name' => 'v_data_grid_columns_thumbnails', 'group_name' => 'Image Management', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Linked Images', 'short_caption' => 'Image Management.Linked Images', 'filename' => 'image_management_linked_images.php', 'name' => 'album', 'group_name' => 'Image Management', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Multi Upload - 1 ', 'short_caption' => 'Image Management.Multi Upload - 1', 'filename' => 'image_management_multi_upload1.php', 'name' => 'picture', 'group_name' => 'Image Management', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Multi Upload - 2', 'short_caption' => 'Image Management.Multi Upload - 2', 'filename' => 'image_management_multi_upload2.php', 'name' => 'album02', 'group_name' => 'Image Management', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Watermarks', 'short_caption' => 'Image Management.Watermarks', 'filename' => 'image_management_watermarks.php', 'name' => 'v_watermarks', 'group_name' => 'Image Management', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '<a href="index.php" class="navbar-brand hidden-xs hidden-sm">
    <strong>PHP Generator Feature Demo</strong>
</a>';
}

function GetPagesFooter()
{
    return
        '<table class="table table-condensed legend">
<caption>Legend</caption>
    <tr>
        <td><span class="label label-success">New</span></td>
        <td>Recently added or significantly updated pages.</td>
    </tr>
        <tr>
        <td><span class="label label-warning">Pro</span></td>
        <td>Pages illustrating features available only in the Professional edition of PHP Generator.</td>
    </tr>
</table>
<p>&copy; <span class="copyright">2002-<script type="text/javascript" >document.write(new Date().getFullYear().toString())</script></span> <a href="http://www.sqlmaestro.com/" target="_blank">SQL Maestro Group</a>. Follow us: 
<a class="link-icon" href="https://www.facebook.com/SQLMaestro/" target="_blank"><i class="icon-facebook-square"></i></a>
<a class="link-icon" href="https://twitter.com/SQLMaestroSoft" target="_blank"><i class="icon-twitter"></i></a>
<a class="link-icon" href="https://www.youtube.com/SQLMaestro/" target="_blank"><i class="icon-youtube"></i></a></p>
<p>Created with <a href="http://www.sqlmaestro.com/products/mysql/phpgenerator/" target="_blank">PHP Generator for MySQL</a>.
Want to learn more? <a href="http://www.sqlmaestro.com/products/mysql/phpgenerator/download/" target="_blank">Download the demo project!</a></p>';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(false);
    $page->setShowNavigation(true);
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_AddEnvironmentVariablesHandler(&$variables)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{
    $customHtmlHeaderText  = '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/styles/agate.min.css">';
    $customHtmlHeaderText .= '<link rel="icon" href="favicon.ico" type="image/x-icon">';
    $customHtmlHeaderText .= '<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/highlight.min.js"></script>';
}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{
    if ($part == PagePart::Layout)
    {
        $themes = array(
            "Default" => "",
            "Default compact" => "_default-compact",
            "Cerulean" => "_cerulean",
            "Cerulean compact" => "_cerulean-compact",
            "Cosmo" => "_cosmo",
            "Cyborg" => "_cyborg",
            "Darkly" => "_darkly",
            "Darkly compact" => "_darkly-compact",
            "Facebook" => "_facebook",
            "Flatly" => "_flatly",
            "Journal" => "_journal",
            "Lumen" => "_lumen",
            "Paper" => "_paper",
            "Readable" => "_readable",
            "Sandstone" => "_sandstone",
            "Simplex" => "_simplex",
            "Slate" => "_slate",
            "Slate compact" => "_slate-compact",
            "Spacelab" => "_spacelab",
            "Superhero" => "_superhero",
            "Superhero compact" => "_superhero-compact",
            "United" => "_united",
            "United compact" => "_united-compact",
            "Yeti" => "_yeti",
            "Yeti compact" => "_yeti-compact",
        );
        
        $themePostfix = "";
        $themeCookieVariable = 'theme';
        $demoThemeCookieVariable = 'demo_theme';
                                                
        if (($page->GetPageId() === 'v_color_themes') && isset($_COOKIE[$demoThemeCookieVariable]) && 
                $_COOKIE[$demoThemeCookieVariable] && isset($themes[$_COOKIE[$demoThemeCookieVariable]])) {
            $themePostfix = $themes[$_COOKIE[$demoThemeCookieVariable]];    
        } elseif (isset($_COOKIE[$themeCookieVariable]) && $_COOKIE[$themeCookieVariable] && isset($themes[$_COOKIE[$themeCookieVariable]])) {
            $themePostfix = $themes[$_COOKIE[$themeCookieVariable]];
        }
    
        $params['themes'] = $themes;
        $params['themePostfix'] = $themePostfix;
        $params['showThemesMenu'] = true;
        $result = 'custom_layout.tpl';
    
        if ($page->GetPageId() === 'v_tweaking_custom_theme') {
            $params['StyleFile'] = 'components/assets/css/main_facebook_custom.css';
            $params['showThemesMenu'] = false;
        } else {
            $params['StyleFile'] = 'components/assets/css/main' . $themePostfix . '.css';
        }
    
        $langs = array(
            'en' => 'English',
            'de' => 'German',
            'br' => 'Brazilian',
            'cs' => 'Czech',
            'dk' => 'Danish',
            'es' => 'Spanish',
            'fi' => 'Finnish',
            'fr' => 'French',
            'hu' => 'Hungarian',
            'it' => 'Italian',
            'nl' => 'Dutch',
            'pl' => 'Polish',
            'ru' => 'Russian',
            'se' => 'Swedish',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'sr' => 'Serbian',
            'tr' => 'Turkish',
            'ar' => 'Arabic'
        );
    
        $lang = 'en';
        if (isset($_COOKIE['lang']) && $_COOKIE['lang'] && isset($langs[$_COOKIE['lang']])) {
            $lang = $_COOKIE['lang'];
        }
    
        $params['availableLangs'] = $langs;
        $params['currentLang'] = $lang;
    }
    
    if (PageType::Data === $type && $mode === PageMode::ViewAll && $part === PagePart::Layout && !$page instanceof DetailPage) {
        $descriptions = require('external_data/doc/page_descriptions.php');
        $filename = $page->getPageFileName();
        if (isset($descriptions[$filename])) {
            if (isset($descriptions[$filename]['class_attribute'])) {
                $params['pageContentBlockClass'] = 'page-title-' . $descriptions[$filename]['class_attribute'];
            }
            if (isset($descriptions[$filename]['demo_video_link'])) {
                $params['pageDemoVideoLink'] = '<span class="demo-video-link" data-demo-video-link="'. $descriptions[$filename]['demo_video_link'] .'"></span>';
            }
        }
    }
    
    if ($type === PageType::Home) {
        $params['Banner'] = file_get_contents("external_data/doc/home_page_banner.html"); 
    }
}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{
    $customPageInfos = require('external_data/doc/page_descriptions.php');
    $pageLinks = $pageList->getPages();
    $linksAlternativeCaptions = array();
    
    foreach ($pageLinks as $pageLink) {
        $url = $pageLink->getLink();
    
        if (!isset($customPageInfos[$url])) {
            continue;
        }
    
        if (isset($customPageInfos[$url]['class_attribute'])) {
            $pageLink->setClassAttribute($customPageInfos[$url]['class_attribute']);
        }
    
        if (isset($customPageInfos[$url]['description'])) {
            if (isset($customPageInfos[$url]['demo_video_link'])) {
                $videoLinkCode = 
                    '<a class="demo-video" href="' . $customPageInfos[$url]['demo_video_link'] . '" target="_blank">' .
                    'Watch video<span class="icon-play"></span>' .
                    '</a>';
                $pageLink->setDescription($customPageInfos[$url]['description'] . $videoLinkCode);        
            } else {
                $pageLink->setDescription($customPageInfos[$url]['description']);
            }
        }
        
        if (isset($customPageInfos[$url]['alternative_caption'])) {
            $linksAlternativeCaptions[$url] = $customPageInfos[$url]['alternative_caption'];
        }
        
        if (isset($customPageInfos[$url]['alternative_link'])) {
            $pageLink->setLink($customPageInfos[$url]['alternative_link']);
        }        
    }
    
    $groupName = "Custom Templates";
    $pageList->AddGroup($groupName);
    foreach ($pageLinks as $pageLink) {
        if (strstr($pageLink->getClassAttribute(), 'custom') !== false) {
            $customLink = clone $pageLink;
            if (isset($linksAlternativeCaptions[$pageLink->getLink()])) {
                $customLink->SetCaption($linksAlternativeCaptions[$pageLink->getLink()]);
            }
            $pageList->AddPage(
                $customLink
                    ->setGroupName($groupName)
                    ->SetBeginNewGroup(false)
                    ->setShowAsText(false)
                    ->setLink($customLink->getLink() . '#custom')
            );
        }
    }
        
    $groupName = "Recently added/updated";
    $pageList->addGroupAt($groupName, 0);
    foreach ($pageLinks as $pageLink) {
        if (strstr($pageLink->getClassAttribute(), 'recently-added') !== false) {
            $anchor = '#recently-added';
        } elseif (strstr($pageLink->getClassAttribute(), 'upd') !== false) {
            $anchor = '#upd';
        } else {
            continue;
        }
        
        $customLink = clone $pageLink;
        if (isset($linksAlternativeCaptions[$pageLink->getLink()])) {
            $customLink->SetCaption($linksAlternativeCaptions[$pageLink->getLink()]);
        }
        $pageList->AddPage(
            $customLink
                ->setGroupName($groupName)
                ->SetBeginNewGroup(false)
                ->setShowAsText(false)
                ->setLink($customLink->getLink() . $anchor)
        );
    }
    
    $groupDescriptions = require('external_data/doc/group_descriptions.php');
    $pageGroups = $pageList->GetGroups();
    foreach ($pageGroups as $pageGroup) {
        if (isset($groupDescriptions[$pageGroup->getCaption()])) {
           $pageGroup->setDescription($groupDescriptions[$pageGroup->getCaption()]);              
        }     
    }
}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetPageListType()
{
    return PageList::TYPE_SIDEBAR;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 0;
}

function GetMailer()
{
    $mailerOptions = new MailerOptions(MailerType::Sendmail, 'admin@mysite.com', 'Site admin');
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MySqlIConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

/**
 * @param string $pageName
 * @return IPermissionSet
 */
function GetCurrentUserPermissionsForPage($pageName) 
{
    return GetApplication()->GetCurrentUserPermissionSet($pageName);
}
