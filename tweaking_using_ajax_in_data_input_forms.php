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
    
    
    
    class v_tweaking_ajax_using_invoice_detailPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Invoice Detail');
            $this->SetMenuLabel('Invoice Detail');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`invoice_detail`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('invoice_header_id', true),
                    new IntegerField('product_id', true),
                    new IntegerField('quantity', true),
                    new IntegerField('unit_price'),
                    new IntegerField('line_total', false, false, false, true)
                )
            );
            $this->dataset->AddLookupField('invoice_header_id', 'invoice_header', new IntegerField('id'), new DateField('invoice_date', false, false, false, false, 'invoice_header_id_invoice_date', 'invoice_header_id_invoice_date_invoice_header'), 'invoice_header_id_invoice_date_invoice_header');
            $this->dataset->AddLookupField('product_id', 'product', new IntegerField('id'), new StringField('product_name', false, false, false, false, 'product_id_product_name', 'product_id_product_name_product'), 'product_id_product_name_product');
        }
    
        protected function DoPrepare() {
            if (GetApplication()->isGetValueSet('productId')) {
                $productId = GetApplication()->GetGETValue('productId');
                $sql = "SELECT price FROM product WHERE id = $productId";
                $queryResult = $this->GetConnection()->fetchAll($sql);
                
                $result = array(
                    'price' => $queryResult[0]['price']
                );
                               
                echo json_encode($result);
                exit;                              
            }
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
                new FilterColumn($this->dataset, 'invoice_header_id', 'invoice_header_id_invoice_date', 'Invoice Header Id'),
                new FilterColumn($this->dataset, 'product_id', 'product_id_product_name', 'Product'),
                new FilterColumn($this->dataset, 'unit_price', 'unit_price', 'Unit Price'),
                new FilterColumn($this->dataset, 'quantity', 'quantity', 'Quantity'),
                new FilterColumn($this->dataset, 'line_total', 'line_total', 'Line Total')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['product_id'])
                ->addColumn($columns['unit_price'])
                ->addColumn($columns['quantity']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('product_id');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('product_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_v_tweaking_ajax_using_invoice_detail_product_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('product_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_v_tweaking_ajax_using_invoice_detail_product_id_search');
            
            $text_editor = new TextEdit('product_id');
            
            $filterBuilder->addColumn(
                $columns['product_id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('unit_price_edit');
            
            $filterBuilder->addColumn(
                $columns['unit_price'],
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
            
            $main_editor = new TextEdit('quantity_edit');
            
            $filterBuilder->addColumn(
                $columns['quantity'],
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
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant()) {
            
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
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
            
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for product_name field
            //
            $column = new TextViewColumn('product_id', 'product_id_product_name', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for unit_price field
            //
            $column = new NumberViewColumn('unit_price', 'unit_price', 'Unit Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for quantity field
            //
            $column = new NumberViewColumn('quantity', 'quantity', 'Quantity', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for line_total field
            //
            $column = new NumberViewColumn('line_total', 'line_total', 'Line Total', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for product_name field
            //
            $column = new TextViewColumn('product_id', 'product_id_product_name', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for unit_price field
            //
            $column = new NumberViewColumn('unit_price', 'unit_price', 'Unit Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for quantity field
            //
            $column = new NumberViewColumn('quantity', 'quantity', 'Quantity', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for line_total field
            //
            $column = new NumberViewColumn('line_total', 'line_total', 'Line Total', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for product_id field
            //
            $editor = new DynamicCombobox('product_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`product`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('product_name', true),
                    new StringField('product_number', true),
                    new IntegerField('active', true),
                    new IntegerField('price')
                )
            );
            $lookupDataset->setOrderByField('product_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Product', 'product_id', 'product_id_product_name', 'edit_v_tweaking_ajax_using_invoice_detail_product_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'product_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for unit_price field
            //
            $editor = new TextEdit('unit_price_edit');
            $editColumn = new CustomEditColumn('Unit Price', 'unit_price', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for quantity field
            //
            $editor = new TextEdit('quantity_edit');
            $editColumn = new CustomEditColumn('Quantity', 'quantity', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for product_id field
            //
            $editor = new DynamicCombobox('product_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`product`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('product_name', true),
                    new StringField('product_number', true),
                    new IntegerField('active', true),
                    new IntegerField('price')
                )
            );
            $lookupDataset->setOrderByField('product_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Product', 'product_id', 'product_id_product_name', 'multi_edit_v_tweaking_ajax_using_invoice_detail_product_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'product_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for unit_price field
            //
            $editor = new TextEdit('unit_price_edit');
            $editColumn = new CustomEditColumn('Unit Price', 'unit_price', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for quantity field
            //
            $editor = new TextEdit('quantity_edit');
            $editColumn = new CustomEditColumn('Quantity', 'quantity', $editor, $this->dataset);
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
            // Edit column for product_id field
            //
            $editor = new DynamicCombobox('product_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`product`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('product_name', true),
                    new StringField('product_number', true),
                    new IntegerField('active', true),
                    new IntegerField('price')
                )
            );
            $lookupDataset->setOrderByField('product_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Product', 'product_id', 'product_id_product_name', 'insert_v_tweaking_ajax_using_invoice_detail_product_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'product_name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for unit_price field
            //
            $editor = new TextEdit('unit_price_edit');
            $editColumn = new CustomEditColumn('Unit Price', 'unit_price', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for quantity field
            //
            $editor = new TextEdit('quantity_edit');
            $editColumn = new CustomEditColumn('Quantity', 'quantity', $editor, $this->dataset);
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
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_header_id', 'invoice_header_id_invoice_date', 'Invoice Header Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for product_name field
            //
            $column = new TextViewColumn('product_id', 'product_id_product_name', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for unit_price field
            //
            $column = new NumberViewColumn('unit_price', 'unit_price', 'Unit Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for quantity field
            //
            $column = new NumberViewColumn('quantity', 'quantity', 'Quantity', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_header_id', 'invoice_header_id_invoice_date', 'Invoice Header Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for product_name field
            //
            $column = new TextViewColumn('product_id', 'product_id_product_name', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for unit_price field
            //
            $column = new NumberViewColumn('unit_price', 'unit_price', 'Unit Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for quantity field
            //
            $column = new NumberViewColumn('quantity', 'quantity', 'Quantity', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_header_id', 'invoice_header_id_invoice_date', 'Invoice Header Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for product_name field
            //
            $column = new TextViewColumn('product_id', 'product_id_product_name', 'Product', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for unit_price field
            //
            $column = new NumberViewColumn('unit_price', 'unit_price', 'Unit Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for quantity field
            //
            $column = new NumberViewColumn('quantity', 'quantity', 'Quantity', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
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
            $result->SetTotal('line_total', new CustomAggregate('SUM(unit_price * quantity)', 'Total amount'));
            
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
    
    
            $this->SetInsertFormTitle('Add a new invoice line');
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(false);
            $this->SetShowBottomPageNavigator(false);
            $this->setAllowedActions(array('view', 'insert', 'copy', 'edit', 'multi-edit', 'delete'));
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
            $grid->SetInsertClientEditorValueChangedScript('if (sender.getFieldName() == \'product_id\') {
              var productIdValue = sender.getValue(); 
              $.getJSON(
                location.href, 
                {
                  productId: productIdValue
                }, 
                function (data) {
                  editors[\'unit_price\'].setValue(data.price);
                }
              )
            }');
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`product`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('product_name', true),
                    new StringField('product_number', true),
                    new IntegerField('active', true),
                    new IntegerField('price')
                )
            );
            $lookupDataset->setOrderByField('product_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_v_tweaking_ajax_using_invoice_detail_product_id_search', 'id', 'product_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`product`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('product_name', true),
                    new StringField('product_number', true),
                    new IntegerField('active', true),
                    new IntegerField('price')
                )
            );
            $lookupDataset->setOrderByField('product_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_v_tweaking_ajax_using_invoice_detail_product_id_search', 'id', 'product_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`product`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('product_name', true),
                    new StringField('product_number', true),
                    new IntegerField('active', true),
                    new IntegerField('price')
                )
            );
            $lookupDataset->setOrderByField('product_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_v_tweaking_ajax_using_invoice_detail_product_id_search', 'id', 'product_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`product`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('product_name', true),
                    new StringField('product_number', true),
                    new IntegerField('active', true),
                    new IntegerField('price')
                )
            );
            $lookupDataset->setOrderByField('product_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_v_tweaking_ajax_using_invoice_detail_product_id_search', 'id', 'product_name', null, 20);
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
            if ($fieldName == 'line_total') {
                $value = $rowData['quantity'] * $rowData['unit_price']; 
            }
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class v_tweaking_ajax_usingPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Fine-tuning & Tweaking.Using Ajax in Data Input Forms');
            $this->SetMenuLabel('Using Ajax in Forms');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_tweaking_ajax_using`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new DateField('invoice_date'),
                    new IntegerField('customer_id'),
                    new StringField('bill_to_address')
                )
            );
            $this->dataset->AddLookupField('customer_id', 'v_customer', new IntegerField('id'), new StringField('customer_name', false, false, false, false, 'customer_id_customer_name', 'customer_id_customer_name_v_customer'), 'customer_id_customer_name_v_customer');
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/tweaking_using_ajax_in_data_input_forms.html"));
            
            $invoiceDetailPage = new v_tweaking_ajax_using_invoice_detailPage('v_tweaking_ajax_using_invoice_detail', 
              $this, array('invoice_header_id'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), 
              $this->dataset, new AdminPermissionSet, 'UTF-8');
            
            $this->setDetailedDescription(
              '<div id="on-insert-form-editor-value-changed" class="event-code">' .
                extractClientEventCode($invoiceDetailPage, 'OnInsertFormEditorValueChanged') . '</div>' .
              '<div id="on-prepare-page" class="event-code">' .
                extractMethodCode($invoiceDetailPage, 'doPrepare') . '</div>'
            );
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
                new FilterColumn($this->dataset, 'invoice_date', 'invoice_date', 'Invoice Date'),
                new FilterColumn($this->dataset, 'customer_id', 'customer_id_customer_name', 'Customer'),
                new FilterColumn($this->dataset, 'bill_to_address', 'bill_to_address', 'Bill To Address')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['invoice_date'])
                ->addColumn($columns['customer_id'])
                ->addColumn($columns['bill_to_address']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('invoice_date')
                ->setOptionsFor('customer_id');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DateTimeEdit('invoice_date_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['invoice_date'],
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
            
            $main_editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_v_tweaking_ajax_using_customer_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('customer_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_v_tweaking_ajax_using_customer_id_search');
            
            $filterBuilder->addColumn(
                $columns['customer_id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('bill_to_address_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['bill_to_address'],
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
            if (GetCurrentUserPermissionsForPage('v_tweaking_ajax_using.invoice_detail')->HasViewGrant() && $withDetails)
            {
            //
            // View column for v_tweaking_ajax_using_invoice_detail detail
            //
            $column = new DetailColumn(array('id'), 'v_tweaking_ajax_using.invoice_detail', 'v_tweaking_ajax_using_invoice_detail_handler', $this->dataset, 'Invoice Detail');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_date', 'invoice_date', 'Invoice Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for customer_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_customer_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for bill_to_address field
            //
            $column = new TextViewColumn('bill_to_address', 'bill_to_address', 'Bill To Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_date', 'invoice_date', 'Invoice Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for customer_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_customer_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for bill_to_address field
            //
            $column = new TextViewColumn('bill_to_address', 'bill_to_address', 'Bill To Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for invoice_date field
            //
            $editor = new DateTimeEdit('invoice_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Invoice Date', 'invoice_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for customer_id field
            //
            $editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new StringField('customer_name', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('customer_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Customer', 'customer_id', 'customer_id_customer_name', 'edit_v_tweaking_ajax_using_customer_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'customer_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for bill_to_address field
            //
            $editor = new TextEdit('bill_to_address_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Bill To Address', 'bill_to_address', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for invoice_date field
            //
            $editor = new DateTimeEdit('invoice_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Invoice Date', 'invoice_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for customer_id field
            //
            $editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new StringField('customer_name', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('customer_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Customer', 'customer_id', 'customer_id_customer_name', 'multi_edit_v_tweaking_ajax_using_customer_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'customer_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for bill_to_address field
            //
            $editor = new TextEdit('bill_to_address_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Bill To Address', 'bill_to_address', $editor, $this->dataset);
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
            // Edit column for invoice_date field
            //
            $editor = new DateTimeEdit('invoice_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Invoice Date', 'invoice_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for customer_id field
            //
            $editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new StringField('customer_name', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('customer_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Customer', 'customer_id', 'customer_id_customer_name', 'insert_v_tweaking_ajax_using_customer_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'customer_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for bill_to_address field
            //
            $editor = new TextEdit('bill_to_address_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Bill To Address', 'bill_to_address', $editor, $this->dataset);
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
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_date', 'invoice_date', 'Invoice Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for customer_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_customer_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for bill_to_address field
            //
            $column = new TextViewColumn('bill_to_address', 'bill_to_address', 'Bill To Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_date', 'invoice_date', 'Invoice Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for customer_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_customer_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for bill_to_address field
            //
            $column = new TextViewColumn('bill_to_address', 'bill_to_address', 'Bill To Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for invoice_date field
            //
            $column = new DateTimeViewColumn('invoice_date', 'invoice_date', 'Invoice Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for customer_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_customer_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for bill_to_address field
            //
            $column = new TextViewColumn('bill_to_address', 'bill_to_address', 'Bill To Address', $this->dataset);
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
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return 'expandFirstDetail();'. "\n" .
            ''. "\n" .
            'function initDescriptionInsertDetailLink() {'. "\n" .
            '  var $addDetailButton = $(\'tr.grid-details\').find(\'.pgui-add\').first();'. "\n" .
            '  if (($addDetailButton.length > 0) && '. "\n" .
            '     (eventData = $._data($addDetailButton.get(0), "events")) &&'. "\n" .
            '     (eventData.click)) '. "\n" .
            '  {'. "\n" .
            '    $(\'.description-detail-insert\').on(\'click\', function(e) {'. "\n" .
            '      $addDetailButton.trigger(\'click\');'. "\n" .
            '      e.preventDefault();'. "\n" .
            '    });'. "\n" .
            '  }'. "\n" .
            '  else {'. "\n" .
            '    setTimeout(initDescriptionInsertDetailLink, 100); '. "\n" .
            '  }     '. "\n" .
            '}'. "\n" .
            ''. "\n" .
            'initDescriptionInsertDetailLink();';
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
            $detailPage = new v_tweaking_ajax_using_invoice_detailPage('v_tweaking_ajax_using_invoice_detail', $this, array('invoice_header_id'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('v_tweaking_ajax_using.invoice_detail'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('v_tweaking_ajax_using.invoice_detail'));
            $detailPage->SetHttpHandlerName('v_tweaking_ajax_using_invoice_detail_handler');
            $handler = new PageHTTPHandler('v_tweaking_ajax_using_invoice_detail_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new StringField('customer_name', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('customer_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_v_tweaking_ajax_using_customer_id_search', 'id', 'customer_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new StringField('customer_name', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('customer_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_v_tweaking_ajax_using_customer_id_search', 'id', 'customer_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new StringField('customer_name', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('customer_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_v_tweaking_ajax_using_customer_id_search', 'id', 'customer_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new StringField('customer_name', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('customer_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_v_tweaking_ajax_using_customer_id_search', 'id', 'customer_name', null, 20);
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
        $Page = new v_tweaking_ajax_usingPage("v_tweaking_ajax_using", "tweaking_using_ajax_in_data_input_forms.php", GetCurrentUserPermissionsForPage("v_tweaking_ajax_using"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_tweaking_ajax_using"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
