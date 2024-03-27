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
    
    
    
    class placesPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Editors.Autocomplete');
            $this->SetMenuLabel('Autocomplete');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`places`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('country', true),
                    new StringField('place', true)
                )
            );
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/editors_autocomplete.html"));
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
                new FilterColumn($this->dataset, 'country', 'country', 'Country'),
                new FilterColumn($this->dataset, 'place', 'place', 'Place')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['country'])
                ->addColumn($columns['place']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteEditor('country_edit', $this->CreateLinkBuilder(), 'filter_builder_places_country_ac');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['country'],
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
            
            $main_editor = new AutocompleteEditor('place_edit', $this->CreateLinkBuilder(), 'filter_builder_places_place_ac');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['place'],
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
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->deleteOperationIsAllowed()) {
                $operation = new AjaxOperation(OPERATION_DELETE,
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'),
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'), $this->dataset,
                    $this->GetModalGridDeleteHandler(), $grid
                );
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for place field
            //
            $column = new TextViewColumn('place', 'place', 'Place', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for place field
            //
            $column = new TextViewColumn('place', 'place', 'Place', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for country field
            //
            $editor = new AutocompleteEditor('country_edit', $this->CreateLinkBuilder(), 'edit_places_country_ac');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for place field
            //
            $editor = new AutocompleteEditor('place_edit', $this->CreateLinkBuilder(), 'edit_places_place_ac');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Place', 'place', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for country field
            //
            $editor = new AutocompleteEditor('country_edit', $this->CreateLinkBuilder(), 'multi_edit_places_country_ac');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for place field
            //
            $editor = new AutocompleteEditor('place_edit', $this->CreateLinkBuilder(), 'multi_edit_places_place_ac');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Place', 'place', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for country field
            //
            $editor = new AutocompleteEditor('country_edit', $this->CreateLinkBuilder(), 'insert_places_country_ac');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Country', 'country', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for place field
            //
            $editor = new AutocompleteEditor('place_edit', $this->CreateLinkBuilder(), 'insert_places_place_ac');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Place', 'place', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for place field
            //
            $column = new TextViewColumn('place', 'place', 'Place', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for place field
            //
            $column = new TextViewColumn('place', 'place', 'Place', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for country field
            //
            $column = new TextViewColumn('country', 'country', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for place field
            //
            $column = new TextViewColumn('place', 'place', 'Place', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
    
        function insert_places_place_ac_OnGetSuggestions($term, &$suggestions)
        {
            $url = 'https://maps.googleapis.com/maps/api/place/queryautocomplete/json?key=%s&input=%s';
            $key = 'AIzaSyAiiq_cJW4Vr4gr9QKH0uTcf8HylEXiz1g';
            $sourceUrl = sprintf($url, $key, urlencode($term)); 
            
            $contextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false
                )
            );
            
            $json = file_get_contents($sourceUrl, false, stream_context_create($contextOptions));
            $result = json_decode($json, true);
            if ($result['status'] == 'OK') {
                foreach ($result['predictions'] as $prediction) {
                    $suggestions[] = $prediction['description'];
                }
            } elseif ($result['status'] == 'OVER_QUERY_LIMIT') {
                $suggestions[] = 'Query limit is exceeded';
            }
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        function edit_places_place_ac_OnGetSuggestions($term, &$suggestions)
        {
            $url = 'https://maps.googleapis.com/maps/api/place/queryautocomplete/json?key=%s&input=%s';
            $key = 'AIzaSyAiiq_cJW4Vr4gr9QKH0uTcf8HylEXiz1g';
            $sourceUrl = sprintf($url, $key, urlencode($term)); 
            
            $contextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false
                )
            );
            
            $json = file_get_contents($sourceUrl, false, stream_context_create($contextOptions));
            $result = json_decode($json, true);
            if ($result['status'] == 'OK') {
                foreach ($result['predictions'] as $prediction) {
                    $suggestions[] = $prediction['description'];
                }
            } elseif ($result['status'] == 'OVER_QUERY_LIMIT') {
                $suggestions[] = 'Query limit is exceeded';
            }
        }
        function multi_edit_places_place_ac_OnGetSuggestions($term, &$suggestions)
        {
            $url = 'https://maps.googleapis.com/maps/api/place/queryautocomplete/json?key=%s&input=%s';
            $key = 'AIzaSyAiiq_cJW4Vr4gr9QKH0uTcf8HylEXiz1g';
            $sourceUrl = sprintf($url, $key, urlencode($term)); 
            
            $contextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false
                )
            );
            
            $json = file_get_contents($sourceUrl, false, stream_context_create($contextOptions));
            $result = json_decode($json, true);
            if ($result['status'] == 'OK') {
                foreach ($result['predictions'] as $prediction) {
                    $suggestions[] = $prediction['description'];
                }
            } elseif ($result['status'] == 'OVER_QUERY_LIMIT') {
                $suggestions[] = 'Query limit is exceeded';
            }
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
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
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
            $this->setAllowedActions(array('view', 'insert', 'edit', 'delete'));
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(false);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array());
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('Code', true, true),
                    new StringField('Name', true),
                    new StringField('Continent', true),
                    new StringField('Region', true),
                    new IntegerField('SurfaceArea', true),
                    new IntegerField('IndepYear'),
                    new IntegerField('Population', true),
                    new IntegerField('LifeExpectancy'),
                    new IntegerField('GNP'),
                    new IntegerField('GNPOld'),
                    new StringField('LocalName', true),
                    new StringField('GovernmentForm', true),
                    new StringField('HeadOfState'),
                    new IntegerField('Capital'),
                    new StringField('Code2', true),
                    new StringField('flag'),
                    new StringField('emblem')
                )
            );
            $suggestionsDataset->setOrderByField('Name', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'Name', 'insert_places_country_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new AutocompleteFunctionBasedHTTPHandler('insert_places_place_ac');
            $handler->OnGetSuggestions->AddListener('insert_places_place_ac_OnGetSuggestions', $this);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('Code', true, true),
                    new StringField('Name', true),
                    new StringField('Continent', true),
                    new StringField('Region', true),
                    new IntegerField('SurfaceArea', true),
                    new IntegerField('IndepYear'),
                    new IntegerField('Population', true),
                    new IntegerField('LifeExpectancy'),
                    new IntegerField('GNP'),
                    new IntegerField('GNPOld'),
                    new StringField('LocalName', true),
                    new StringField('GovernmentForm', true),
                    new StringField('HeadOfState'),
                    new IntegerField('Capital'),
                    new StringField('Code2', true),
                    new StringField('flag'),
                    new StringField('emblem')
                )
            );
            $suggestionsDataset->setOrderByField('Name', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'Name', 'filter_builder_places_country_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new AutocompleteFunctionBasedHTTPHandler('filter_builder_places_place_ac');
            $handler->OnGetSuggestions->AddListener('filter_builder_places_place_ac_OnGetSuggestions', $this);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('Code', true, true),
                    new StringField('Name', true),
                    new StringField('Continent', true),
                    new StringField('Region', true),
                    new IntegerField('SurfaceArea', true),
                    new IntegerField('IndepYear'),
                    new IntegerField('Population', true),
                    new IntegerField('LifeExpectancy'),
                    new IntegerField('GNP'),
                    new IntegerField('GNPOld'),
                    new StringField('LocalName', true),
                    new StringField('GovernmentForm', true),
                    new StringField('HeadOfState'),
                    new IntegerField('Capital'),
                    new StringField('Code2', true),
                    new StringField('flag'),
                    new StringField('emblem')
                )
            );
            $suggestionsDataset->setOrderByField('Name', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'Name', 'edit_places_country_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new AutocompleteFunctionBasedHTTPHandler('edit_places_place_ac');
            $handler->OnGetSuggestions->AddListener('edit_places_place_ac_OnGetSuggestions', $this);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $suggestionsDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $suggestionsDataset->addFields(
                array(
                    new StringField('Code', true, true),
                    new StringField('Name', true),
                    new StringField('Continent', true),
                    new StringField('Region', true),
                    new IntegerField('SurfaceArea', true),
                    new IntegerField('IndepYear'),
                    new IntegerField('Population', true),
                    new IntegerField('LifeExpectancy'),
                    new IntegerField('GNP'),
                    new IntegerField('GNPOld'),
                    new StringField('LocalName', true),
                    new StringField('GovernmentForm', true),
                    new StringField('HeadOfState'),
                    new IntegerField('Capital'),
                    new StringField('Code2', true),
                    new StringField('flag'),
                    new StringField('emblem')
                )
            );
            $suggestionsDataset->setOrderByField('Name', 'ASC');
            $handler = new AutocompleteDatasetBasedHTTPHandler($suggestionsDataset, 'Name', 'multi_edit_places_country_ac', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new AutocompleteFunctionBasedHTTPHandler('multi_edit_places_place_ac');
            $handler->OnGetSuggestions->AddListener('multi_edit_places_place_ac_OnGetSuggestions', $this);
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
        $Page = new placesPage("places", "editors_autocomplete.php", GetCurrentUserPermissionsForPage("places"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("places"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
