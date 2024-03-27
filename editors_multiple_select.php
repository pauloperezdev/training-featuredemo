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
    
    
    
    class v_editors_multiple_selectPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Editors.Multiple Select');
            $this->SetMenuLabel('Multiple Select');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_editors_multiple_select`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('person'),
                    new StringField('favourite_film_genres'),
                    new StringField('favourite_car_brands')
                )
            );
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/editors_multiple_select.html"));
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
                new FilterColumn($this->dataset, 'person', 'person', 'Person'),
                new FilterColumn($this->dataset, 'favourite_film_genres', 'favourite_film_genres', 'Favourite film genres (Default)'),
                new FilterColumn($this->dataset, 'favourite_car_brands', 'favourite_car_brands', 'Favourite car brands (Maximum selection size)')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['person'])
                ->addColumn($columns['favourite_film_genres'])
                ->addColumn($columns['favourite_car_brands']);
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
            
            $main_editor = new TextEdit('person_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['person'],
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
            
            $main_editor = new MultiValueSelect('favourite_film_genres_edit');
            $main_editor->addChoice('Adventure', 'Adventure');
            $main_editor->addChoice('Fantasy', 'Fantasy');
            $main_editor->addChoice('Drama', 'Drama');
            $main_editor->addChoice('Horror', 'Horror');
            $main_editor->addChoice('Action', 'Action');
            $main_editor->addChoice('Comedy', 'Comedy');
            $main_editor->addChoice('Thriller', 'Thriller');
            $main_editor->addChoice('Animation', 'Animation');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('favourite_film_genres');
            
            $filterBuilder->addColumn(
                $columns['favourite_film_genres'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new MultiValueSelect('favourite_car_brands_edit');
            $main_editor->addChoice('Mercedes', 'Mercedes');
            $main_editor->addChoice('Toyota', 'Toyota');
            $main_editor->addChoice('Peugeot', 'Peugeot');
            $main_editor->addChoice('Audi', 'Audi');
            $main_editor->addChoice('Renault', 'Renault');
            $main_editor->addChoice('Ford', 'Ford');
            $main_editor->addChoice('BMW', 'BMW');
            $main_editor->addChoice('Chevrolet', 'Chevrolet');
            $main_editor->addChoice('Porsche', 'Porsche');
            $main_editor->addChoice('Jaguar', 'Jaguar');
            $main_editor->setMaxSelectionSize(2);
            
            $text_editor = new TextEdit('favourite_car_brands');
            
            $filterBuilder->addColumn(
                $columns['favourite_car_brands'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
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
            // View column for person field
            //
            $column = new TextViewColumn('person', 'person', 'Person', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for favourite_film_genres field
            //
            $column = new TextViewColumn('favourite_film_genres', 'favourite_film_genres', 'Favourite film genres (Default)', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for favourite_car_brands field
            //
            $column = new TextViewColumn('favourite_car_brands', 'favourite_car_brands', 'Favourite car brands (Maximum selection size)', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for person field
            //
            $column = new TextViewColumn('person', 'person', 'Person', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for favourite_film_genres field
            //
            $column = new TextViewColumn('favourite_film_genres', 'favourite_film_genres', 'Favourite film genres (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for favourite_car_brands field
            //
            $column = new TextViewColumn('favourite_car_brands', 'favourite_car_brands', 'Favourite car brands (Maximum selection size)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for person field
            //
            $editor = new TextEdit('person_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Person', 'person', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for favourite_film_genres field
            //
            $editor = new MultiValueSelect('favourite_film_genres_edit');
            $editor->addChoice('Adventure', 'Adventure');
            $editor->addChoice('Fantasy', 'Fantasy');
            $editor->addChoice('Drama', 'Drama');
            $editor->addChoice('Horror', 'Horror');
            $editor->addChoice('Action', 'Action');
            $editor->addChoice('Comedy', 'Comedy');
            $editor->addChoice('Thriller', 'Thriller');
            $editor->addChoice('Animation', 'Animation');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Favourite film genres (Default)', 'favourite_film_genres', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for favourite_car_brands field
            //
            $editor = new MultiValueSelect('favourite_car_brands_edit');
            $editor->addChoice('Mercedes', 'Mercedes');
            $editor->addChoice('Toyota', 'Toyota');
            $editor->addChoice('Peugeot', 'Peugeot');
            $editor->addChoice('Audi', 'Audi');
            $editor->addChoice('Renault', 'Renault');
            $editor->addChoice('Ford', 'Ford');
            $editor->addChoice('BMW', 'BMW');
            $editor->addChoice('Chevrolet', 'Chevrolet');
            $editor->addChoice('Porsche', 'Porsche');
            $editor->addChoice('Jaguar', 'Jaguar');
            $editor->setMaxSelectionSize(2);
            $editColumn = new CustomEditColumn('Favourite car brands (Maximum selection size)', 'favourite_car_brands', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for person field
            //
            $editor = new TextEdit('person_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Person', 'person', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for favourite_film_genres field
            //
            $editor = new MultiValueSelect('favourite_film_genres_edit');
            $editor->addChoice('Adventure', 'Adventure');
            $editor->addChoice('Fantasy', 'Fantasy');
            $editor->addChoice('Drama', 'Drama');
            $editor->addChoice('Horror', 'Horror');
            $editor->addChoice('Action', 'Action');
            $editor->addChoice('Comedy', 'Comedy');
            $editor->addChoice('Thriller', 'Thriller');
            $editor->addChoice('Animation', 'Animation');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Favourite film genres (Default)', 'favourite_film_genres', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for favourite_car_brands field
            //
            $editor = new MultiValueSelect('favourite_car_brands_edit');
            $editor->addChoice('Mercedes', 'Mercedes');
            $editor->addChoice('Toyota', 'Toyota');
            $editor->addChoice('Peugeot', 'Peugeot');
            $editor->addChoice('Audi', 'Audi');
            $editor->addChoice('Renault', 'Renault');
            $editor->addChoice('Ford', 'Ford');
            $editor->addChoice('BMW', 'BMW');
            $editor->addChoice('Chevrolet', 'Chevrolet');
            $editor->addChoice('Porsche', 'Porsche');
            $editor->addChoice('Jaguar', 'Jaguar');
            $editor->setMaxSelectionSize(2);
            $editColumn = new CustomEditColumn('Favourite car brands (Maximum selection size)', 'favourite_car_brands', $editor, $this->dataset);
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
            // Edit column for person field
            //
            $editor = new TextEdit('person_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Person', 'person', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for favourite_film_genres field
            //
            $editor = new MultiValueSelect('favourite_film_genres_edit');
            $editor->addChoice('Adventure', 'Adventure');
            $editor->addChoice('Fantasy', 'Fantasy');
            $editor->addChoice('Drama', 'Drama');
            $editor->addChoice('Horror', 'Horror');
            $editor->addChoice('Action', 'Action');
            $editor->addChoice('Comedy', 'Comedy');
            $editor->addChoice('Thriller', 'Thriller');
            $editor->addChoice('Animation', 'Animation');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Favourite film genres (Default)', 'favourite_film_genres', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for favourite_car_brands field
            //
            $editor = new MultiValueSelect('favourite_car_brands_edit');
            $editor->addChoice('Mercedes', 'Mercedes');
            $editor->addChoice('Toyota', 'Toyota');
            $editor->addChoice('Peugeot', 'Peugeot');
            $editor->addChoice('Audi', 'Audi');
            $editor->addChoice('Renault', 'Renault');
            $editor->addChoice('Ford', 'Ford');
            $editor->addChoice('BMW', 'BMW');
            $editor->addChoice('Chevrolet', 'Chevrolet');
            $editor->addChoice('Porsche', 'Porsche');
            $editor->addChoice('Jaguar', 'Jaguar');
            $editor->setMaxSelectionSize(2);
            $editColumn = new CustomEditColumn('Favourite car brands (Maximum selection size)', 'favourite_car_brands', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // View column for person field
            //
            $column = new TextViewColumn('person', 'person', 'Person', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for favourite_film_genres field
            //
            $column = new TextViewColumn('favourite_film_genres', 'favourite_film_genres', 'Favourite film genres (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for favourite_car_brands field
            //
            $column = new TextViewColumn('favourite_car_brands', 'favourite_car_brands', 'Favourite car brands (Maximum selection size)', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for person field
            //
            $column = new TextViewColumn('person', 'person', 'Person', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for favourite_film_genres field
            //
            $column = new TextViewColumn('favourite_film_genres', 'favourite_film_genres', 'Favourite film genres (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for favourite_car_brands field
            //
            $column = new TextViewColumn('favourite_car_brands', 'favourite_car_brands', 'Favourite car brands (Maximum selection size)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for person field
            //
            $column = new TextViewColumn('person', 'person', 'Person', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for favourite_film_genres field
            //
            $column = new TextViewColumn('favourite_film_genres', 'favourite_film_genres', 'Favourite film genres (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for favourite_car_brands field
            //
            $column = new TextViewColumn('favourite_car_brands', 'favourite_car_brands', 'Favourite car brands (Maximum selection size)', $this->dataset);
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
            $this->setAllowedActions(array('view', 'insert', 'edit', 'multi-edit', 'delete'));
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
        $Page = new v_editors_multiple_selectPage("v_editors_multiple_select", "editors_multiple_select.php", GetCurrentUserPermissionsForPage("v_editors_multiple_select"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_editors_multiple_select"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
