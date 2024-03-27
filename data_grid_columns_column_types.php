<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    // OnGlobalBeforePageExecute event handler
    include_once('code_extractor.php');
    
    
    // OnBeforePageExecute event handler
    
    
    
    class v_data_grid_columns_column_typesPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Grid Columns.Column Types');
            $this->SetMenuLabel('Column Types');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_data_grid_columns_column_types`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('cln_text'),
                    new IntegerField('cln_checkbox'),
                    new DateField('cln_datetime'),
                    new BlobField('cln_image'),
                    new StringField('cln_external_image'),
                    new BlobField('cln_file_download'),
                    new StringField('cln_external_file'),
                    new StringField('cln_external_audio'),
                    new StringField('cln_embedded_video')
                )
            );
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/data_grid_columns_column_types.html"));
        }
    
        protected function CreatePageNavigator()
        {
            return null;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'cln_text', 'cln_text', 'Title (Text)'),
                new FilterColumn($this->dataset, 'cln_checkbox', 'cln_checkbox', 'Released as single (Checkbox)'),
                new FilterColumn($this->dataset, 'cln_datetime', 'cln_datetime', 'Release date (Datetime)'),
                new FilterColumn($this->dataset, 'cln_external_image', 'cln_external_image', 'Single cover (External image)'),
                new FilterColumn($this->dataset, 'cln_external_file', 'cln_external_file', 'About the song (External file)'),
                new FilterColumn($this->dataset, 'cln_image', 'cln_image', 'Vinyl (Image)'),
                new FilterColumn($this->dataset, 'cln_external_audio', 'cln_external_audio', 'Sample (External Audio)'),
                new FilterColumn($this->dataset, 'cln_embedded_video', 'cln_embedded_video', 'Clip (Embedded Video)'),
                new FilterColumn($this->dataset, 'cln_file_download', 'cln_file_download', 'About the song (File Download)')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['cln_text'])
                ->addColumn($columns['cln_checkbox'])
                ->addColumn($columns['cln_datetime'])
                ->addColumn($columns['cln_external_file'])
                ->addColumn($columns['cln_external_audio'])
                ->addColumn($columns['cln_embedded_video'])
                ->addColumn($columns['cln_external_image'])
                ->addColumn($columns['cln_file_download']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('cln_datetime')
                ->setOptionsFor('cln_image')
                ->setOptionsFor('cln_file_download');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('cln_text_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['cln_text'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cln_checkbox_edit');
            
            $filterBuilder->addColumn(
                $columns['cln_checkbox'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('cln_datetime_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['cln_datetime'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cln_external_image_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['cln_external_image'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cln_external_file_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['cln_external_file'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cln_image');
            
            $filterBuilder->addColumn(
                $columns['cln_image'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cln_external_audio_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['cln_external_audio'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cln_embedded_video_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['cln_embedded_video'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cln_file_download');
            
            $filterBuilder->addColumn(
                $columns['cln_file_download'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for cln_text field
            //
            $column = new TextViewColumn('cln_text', 'cln_text', 'Title (Text)', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cln_checkbox field
            //
            $column = new CheckboxViewColumn('cln_checkbox', 'cln_checkbox', 'Released as single (Checkbox)', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cln_datetime field
            //
            $column = new DateTimeViewColumn('cln_datetime', 'cln_datetime', 'Release date (Datetime)', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cln_external_image field
            //
            $column = new ExternalImageViewColumn('cln_external_image', 'cln_external_image', 'Single cover (External image)', $this->dataset);
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 100px;');
            $column->setSourcePrefixTemplate('external_data/beatles/covers/');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cln_external_file field
            //
            $column = new DownloadExternalDataColumn('cln_external_file', 'cln_external_file', 'About the song (External file)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/about/');
            $column->setSourceSuffix('.pdf');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cln_image field
            //
            $column = new BlobImageViewColumn('cln_image', 'cln_image', 'Vinyl (Image)', $this->dataset, 'v_data_grid_columns_column_types_cln_image_handler_list');
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 80px;');
            $column->setMinimalVisibility(ColumnVisibility::LARGE_DESKTOP);
            $grid->AddViewColumn($column);
            //
            // View column for cln_file_download field
            //
            $column = new DownloadDataColumn('cln_file_download', 'cln_file_download', 'About the song (File Download)', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::LARGE_DESKTOP);
            $grid->AddViewColumn($column);
            //
            // View column for cln_external_audio field
            //
            $column = new ExternalAudioViewColumn('cln_external_audio', 'cln_external_audio', 'Sample (External Audio)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/sample/');
            $column->setSourceSuffix('.ogg');
            $column->setMinimalVisibility(ColumnVisibility::LARGE_DESKTOP);
            $grid->AddViewColumn($column);
            //
            // View column for cln_embedded_video field
            //
            $column = new EmbeddedVideoViewColumn('cln_embedded_video', 'cln_embedded_video', 'Clip (Embedded Video)', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for cln_text field
            //
            $column = new TextViewColumn('cln_text', 'cln_text', 'Title (Text)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_checkbox field
            //
            $column = new CheckboxViewColumn('cln_checkbox', 'cln_checkbox', 'Released as single (Checkbox)', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_datetime field
            //
            $column = new DateTimeViewColumn('cln_datetime', 'cln_datetime', 'Release date (Datetime)', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_external_image field
            //
            $column = new ExternalImageViewColumn('cln_external_image', 'cln_external_image', 'Single cover (External image)', $this->dataset);
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 100px;');
            $column->setSourcePrefixTemplate('external_data/beatles/covers/');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_external_file field
            //
            $column = new DownloadExternalDataColumn('cln_external_file', 'cln_external_file', 'About the song (External file)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/about/');
            $column->setSourceSuffix('.pdf');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_image field
            //
            $column = new BlobImageViewColumn('cln_image', 'cln_image', 'Vinyl (Image)', $this->dataset, 'v_data_grid_columns_column_types_cln_image_handler_view');
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 80px;');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_file_download field
            //
            $column = new DownloadDataColumn('cln_file_download', 'cln_file_download', 'About the song (File Download)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_external_audio field
            //
            $column = new ExternalAudioViewColumn('cln_external_audio', 'cln_external_audio', 'Sample (External Audio)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/sample/');
            $column->setSourceSuffix('.ogg');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cln_embedded_video field
            //
            $column = new EmbeddedVideoViewColumn('cln_embedded_video', 'cln_embedded_video', 'Clip (Embedded Video)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for cln_text field
            //
            $editor = new TextEdit('cln_text_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Title (Text)', 'cln_text', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_checkbox field
            //
            $editor = new TextEdit('cln_checkbox_edit');
            $editColumn = new CustomEditColumn('Released as single (Checkbox)', 'cln_checkbox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_datetime field
            //
            $editor = new DateTimeEdit('cln_datetime_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Release date (Datetime)', 'cln_datetime', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_external_image field
            //
            $editor = new TextEdit('cln_external_image_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Single cover (External image)', 'cln_external_image', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_external_file field
            //
            $editor = new TextEdit('cln_external_file_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('About the song (External file)', 'cln_external_file', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_image field
            //
            $editor = new ImageUploader('cln_image_edit');
            $editor->SetShowImage(true);
            $editColumn = new FileUploadingColumn('Vinyl (Image)', 'cln_image', $editor, $this->dataset, false, false, 'v_data_grid_columns_column_types_cln_image_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_external_audio field
            //
            $editor = new TextEdit('cln_external_audio_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sample (External Audio)', 'cln_external_audio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_embedded_video field
            //
            $editor = new TextEdit('cln_embedded_video_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clip (Embedded Video)', 'cln_embedded_video', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cln_file_download field
            //
            $editor = new ImageUploader('cln_file_download_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('About the song (File Download)', 'cln_file_download', $editor, $this->dataset, false, false, 'v_data_grid_columns_column_types_cln_file_download_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for cln_text field
            //
            $editor = new TextEdit('cln_text_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Title (Text)', 'cln_text', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_checkbox field
            //
            $editor = new TextEdit('cln_checkbox_edit');
            $editColumn = new CustomEditColumn('Released as single (Checkbox)', 'cln_checkbox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_datetime field
            //
            $editor = new DateTimeEdit('cln_datetime_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Release date (Datetime)', 'cln_datetime', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_image field
            //
            $editor = new ImageUploader('cln_image_edit');
            $editor->SetShowImage(true);
            $editColumn = new FileUploadingColumn('Vinyl (Image)', 'cln_image', $editor, $this->dataset, false, false, 'v_data_grid_columns_column_types_cln_image_handler_multi_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_external_file field
            //
            $editor = new TextEdit('cln_external_file_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('About the song (External file)', 'cln_external_file', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_external_audio field
            //
            $editor = new TextEdit('cln_external_audio_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sample (External Audio)', 'cln_external_audio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_embedded_video field
            //
            $editor = new TextEdit('cln_embedded_video_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clip (Embedded Video)', 'cln_embedded_video', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_external_image field
            //
            $editor = new TextEdit('cln_external_image_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Single cover (External image)', 'cln_external_image', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cln_file_download field
            //
            $editor = new ImageUploader('cln_file_download_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('About the song (File Download)', 'cln_file_download', $editor, $this->dataset, false, false, 'v_data_grid_columns_column_types_cln_file_download_handler_multi_edit');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for cln_text field
            //
            $editor = new TextEdit('cln_text_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Title (Text)', 'cln_text', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_checkbox field
            //
            $editor = new TextEdit('cln_checkbox_edit');
            $editColumn = new CustomEditColumn('Released as single (Checkbox)', 'cln_checkbox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_datetime field
            //
            $editor = new DateTimeEdit('cln_datetime_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Release date (Datetime)', 'cln_datetime', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_external_image field
            //
            $editor = new TextEdit('cln_external_image_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Single cover (External image)', 'cln_external_image', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_external_file field
            //
            $editor = new TextEdit('cln_external_file_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('About the song (External file)', 'cln_external_file', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_image field
            //
            $editor = new ImageUploader('cln_image_edit');
            $editor->SetShowImage(true);
            $editColumn = new FileUploadingColumn('Vinyl (Image)', 'cln_image', $editor, $this->dataset, false, false, 'v_data_grid_columns_column_types_cln_image_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_external_audio field
            //
            $editor = new TextEdit('cln_external_audio_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sample (External Audio)', 'cln_external_audio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_embedded_video field
            //
            $editor = new TextEdit('cln_embedded_video_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clip (Embedded Video)', 'cln_embedded_video', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cln_file_download field
            //
            $editor = new ImageUploader('cln_file_download_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('About the song (File Download)', 'cln_file_download', $editor, $this->dataset, false, false, 'v_data_grid_columns_column_types_cln_file_download_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for cln_text field
            //
            $column = new TextViewColumn('cln_text', 'cln_text', 'Title (Text)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_checkbox field
            //
            $column = new CheckboxViewColumn('cln_checkbox', 'cln_checkbox', 'Released as single (Checkbox)', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_datetime field
            //
            $column = new DateTimeViewColumn('cln_datetime', 'cln_datetime', 'Release date (Datetime)', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_external_image field
            //
            $column = new ExternalImageViewColumn('cln_external_image', 'cln_external_image', 'Single cover (External image)', $this->dataset);
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 100px;');
            $column->setSourcePrefixTemplate('external_data/beatles/covers/');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_external_file field
            //
            $column = new DownloadExternalDataColumn('cln_external_file', 'cln_external_file', 'About the song (External file)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/about/');
            $column->setSourceSuffix('.pdf');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_image field
            //
            $column = new BlobImageViewColumn('cln_image', 'cln_image', 'Vinyl (Image)', $this->dataset, 'v_data_grid_columns_column_types_cln_image_handler_print');
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 80px;');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_external_audio field
            //
            $column = new ExternalAudioViewColumn('cln_external_audio', 'cln_external_audio', 'Sample (External Audio)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/sample/');
            $column->setSourceSuffix('.ogg');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_embedded_video field
            //
            $column = new EmbeddedVideoViewColumn('cln_embedded_video', 'cln_embedded_video', 'Clip (Embedded Video)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cln_file_download field
            //
            $column = new DownloadDataColumn('cln_file_download', 'cln_file_download', 'About the song (File Download)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for cln_text field
            //
            $column = new TextViewColumn('cln_text', 'cln_text', 'Title (Text)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_checkbox field
            //
            $column = new CheckboxViewColumn('cln_checkbox', 'cln_checkbox', 'Released as single (Checkbox)', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_datetime field
            //
            $column = new DateTimeViewColumn('cln_datetime', 'cln_datetime', 'Release date (Datetime)', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_external_image field
            //
            $column = new ExternalImageViewColumn('cln_external_image', 'cln_external_image', 'Single cover (External image)', $this->dataset);
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 100px;');
            $column->setSourcePrefixTemplate('external_data/beatles/covers/');
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_external_file field
            //
            $column = new DownloadExternalDataColumn('cln_external_file', 'cln_external_file', 'About the song (External file)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/about/');
            $column->setSourceSuffix('.pdf');
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_image field
            //
            $column = new BlobImageViewColumn('cln_image', 'cln_image', 'Vinyl (Image)', $this->dataset, 'v_data_grid_columns_column_types_cln_image_handler_export');
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 80px;');
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_external_audio field
            //
            $column = new ExternalAudioViewColumn('cln_external_audio', 'cln_external_audio', 'Sample (External Audio)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/sample/');
            $column->setSourceSuffix('.ogg');
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_embedded_video field
            //
            $column = new EmbeddedVideoViewColumn('cln_embedded_video', 'cln_embedded_video', 'Clip (Embedded Video)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cln_file_download field
            //
            $column = new DownloadDataColumn('cln_file_download', 'cln_file_download', 'About the song (File Download)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for cln_text field
            //
            $column = new TextViewColumn('cln_text', 'cln_text', 'Title (Text)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_checkbox field
            //
            $column = new CheckboxViewColumn('cln_checkbox', 'cln_checkbox', 'Released as single (Checkbox)', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_datetime field
            //
            $column = new DateTimeViewColumn('cln_datetime', 'cln_datetime', 'Release date (Datetime)', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_external_image field
            //
            $column = new ExternalImageViewColumn('cln_external_image', 'cln_external_image', 'Single cover (External image)', $this->dataset);
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 100px;');
            $column->setSourcePrefixTemplate('external_data/beatles/covers/');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_external_file field
            //
            $column = new DownloadExternalDataColumn('cln_external_file', 'cln_external_file', 'About the song (External file)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/about/');
            $column->setSourceSuffix('.pdf');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_image field
            //
            $column = new BlobImageViewColumn('cln_image', 'cln_image', 'Vinyl (Image)', $this->dataset, 'v_data_grid_columns_column_types_cln_image_handler_compare');
            $column->setNullLabel('(n/a)');
            $column->SetOrderable(true);
            $column->setInlineStyles('max-width: 80px;');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_external_audio field
            //
            $column = new ExternalAudioViewColumn('cln_external_audio', 'cln_external_audio', 'Sample (External Audio)', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('external_data/beatles/sample/');
            $column->setSourceSuffix('.ogg');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_embedded_video field
            //
            $column = new EmbeddedVideoViewColumn('cln_embedded_video', 'cln_embedded_video', 'Clip (Embedded Video)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for cln_file_download field
            //
            $column = new DownloadDataColumn('cln_file_download', 'cln_file_download', 'About the song (File Download)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddToggleEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(false);
            $this->SetShowBottomPageNavigator(false);
            $this->setAllowedActions(array('view', 'multi-edit'));
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(false);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $handler = new ImageHTTPHandler($this->dataset, 'cln_image', 'v_data_grid_columns_column_types_cln_image_handler_list', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'cln_file_download', 'cln_file_download_handler', '', '%cln_text%.pdf', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_image', 'v_data_grid_columns_column_types_cln_image_handler_print', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'cln_file_download', 'cln_file_download_handler', '', '%cln_text%.pdf', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_image', 'v_data_grid_columns_column_types_cln_image_handler_compare', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'cln_file_download', 'cln_file_download_handler', '', '%cln_text%.pdf', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_image', 'v_data_grid_columns_column_types_cln_image_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_file_download', 'v_data_grid_columns_column_types_cln_file_download_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_image', 'v_data_grid_columns_column_types_cln_image_handler_view', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new DownloadHTTPHandler($this->dataset, 'cln_file_download', 'cln_file_download_handler', '', '%cln_text%.pdf', true);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_image', 'v_data_grid_columns_column_types_cln_image_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_file_download', 'v_data_grid_columns_column_types_cln_file_download_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_image', 'v_data_grid_columns_column_types_cln_image_handler_multi_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'cln_file_download', 'v_data_grid_columns_column_types_cln_file_download_handler_multi_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new v_data_grid_columns_column_typesPage("v_data_grid_columns_column_types", "data_grid_columns_column_types.php", GetCurrentUserPermissionsForPage("v_data_grid_columns_column_types"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_data_grid_columns_column_types"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
