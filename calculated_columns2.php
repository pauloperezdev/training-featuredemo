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
    function getAmountInUsd($amount, $currency, $paymentDate, $connection) {
        if ($currency === 'USD') {
            return '$' . number_format($amount, 2);
        }
        // calculate the currency field name in table usd_exchange_rate
        // example of such field names: eur_rate, aud_rate
        $currencyFieldName = strtolower($currency) . '_rate';
        // Retrieve the usd exchange rate on payment date
        $sql = sprintf("SELECT %s FROM usd_exchange_rate WHERE exchange_date = '%s'", 
            $currencyFieldName, $paymentDate);
        $currencyRate = $connection->ExecScalarSQL($sql);
        if ($currencyRate) {
            return '$' . number_format(($amount / $currencyRate), 2);
        } else {
            return 'There is no USD exchange rate data on a payment date';
        }
    }
    
    
    class v_calculated_columns2Page extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Calculated Columns.Example - 2');
            $this->SetMenuLabel('Example - 2');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_calculated_columns2`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('customer_id'),
                    new IntegerField('amount'),
                    new StringField('currency'),
                    new DateField('payment_date'),
                    new StringField('amount_in_usd', false, false, false, true)
                )
            );
            $this->dataset->AddLookupField('customer_id', 'customer', new IntegerField('id'), new StringField('last_name', false, false, false, false, 'customer_id_last_name', 'customer_id_last_name_customer'), 'customer_id_last_name_customer');
        }
    
        protected function DoPrepare() {
            // handling Ajax request
            if (GetApplication()->isGetValueSet('amount') && 
                    GetApplication()->isGetValueSet('currency') && 
                        GetApplication()->isGetValueSet('paymentDate')) {
                $value = 
                    getAmountInUsd(
                        GetApplication()->GetGETValue('amount'),        
                        GetApplication()->GetGETValue('currency'),
                        GetApplication()->GetGETValue('paymentDate'),
                        $this->GetConnection()
                    );                    
                echo $value;
                exit;
            }
            
            // auxiliary code
            $this->setDescription(file_get_contents("external_data/doc/calculated_columns2.html"));
            
            $this->setDetailedDescription(
                '<div id="on-before-page-execute" class="event-code">' .
                    extractFunctionCode('getAmountInUsd') . '</div>' .
                '<div id="on-get-calculated-field-value" class="event-code">' .
                    extractMethodCode($this, 'doCalculateFields') . '</div>' .
                '<div id="on-get-form-editor-calculated-value" class="event-code">' .
                    extractClientEventCode($this, 'OnCalculateControlValues') . '</div>' .
                '<div id="on-prepare-page" class="event-code">' .
                    extractMethodCode($this, 'doPrepare') . '</div>'
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
                new FilterColumn($this->dataset, 'customer_id', 'customer_id_last_name', 'Customer'),
                new FilterColumn($this->dataset, 'amount', 'amount', 'Amount'),
                new FilterColumn($this->dataset, 'currency', 'currency', 'Currency'),
                new FilterColumn($this->dataset, 'payment_date', 'payment_date', 'Payment Date'),
                new FilterColumn($this->dataset, 'amount_in_usd', 'amount_in_usd', 'Amount (in USD)')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['customer_id'])
                ->addColumn($columns['amount'])
                ->addColumn($columns['currency'])
                ->addColumn($columns['payment_date']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('customer_id')
                ->setOptionsFor('currency')
                ->setOptionsFor('payment_date');
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
            
            $main_editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_v_calculated_columns2_customer_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('customer_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_v_calculated_columns2_customer_id_search');
            
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
            
            $main_editor = new TextEdit('amount_edit');
            
            $filterBuilder->addColumn(
                $columns['amount'],
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
            
            $main_editor = new ComboBox('currency_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('USD', 'USD');
            $main_editor->addChoice('EUR', 'EUR');
            $main_editor->addChoice('GBP', 'GBP');
            $main_editor->addChoice('CHF', 'CHF');
            $main_editor->addChoice('CAD', 'CAD');
            $main_editor->addChoice('AUD', 'AUD');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('currency');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('currency');
            
            $filterBuilder->addColumn(
                $columns['currency'],
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
            
            $main_editor = new DateTimeEdit('payment_date_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['payment_date'],
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
            // View column for last_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_last_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for amount field
            //
            $column = new NumberViewColumn('amount', 'amount', 'Amount', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for currency field
            //
            $column = new TextViewColumn('currency', 'currency', 'Currency', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for payment_date field
            //
            $column = new DateTimeViewColumn('payment_date', 'payment_date', 'Payment Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for amount_in_usd field
            //
            $column = new TextViewColumn('amount_in_usd', 'amount_in_usd', 'Amount (in USD)', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_last_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for amount field
            //
            $column = new NumberViewColumn('amount', 'amount', 'Amount', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for currency field
            //
            $column = new TextViewColumn('currency', 'currency', 'Currency', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for payment_date field
            //
            $column = new DateTimeViewColumn('payment_date', 'payment_date', 'Payment Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for amount_in_usd field
            //
            $column = new TextViewColumn('amount_in_usd', 'amount_in_usd', 'Amount (in USD)', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for customer_id field
            //
            $editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new DateField('birthday', true),
                    new StringField('email', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('last_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Customer', 'customer_id', 'customer_id_last_name', 'edit_v_calculated_columns2_customer_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'last_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for amount field
            //
            $editor = new TextEdit('amount_edit');
            $editColumn = new CustomEditColumn('Amount', 'amount', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for currency field
            //
            $editor = new ComboBox('currency_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('USD', 'USD');
            $editor->addChoice('EUR', 'EUR');
            $editor->addChoice('GBP', 'GBP');
            $editor->addChoice('CHF', 'CHF');
            $editor->addChoice('CAD', 'CAD');
            $editor->addChoice('AUD', 'AUD');
            $editColumn = new CustomEditColumn('Currency', 'currency', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for payment_date field
            //
            $editor = new DateTimeEdit('payment_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Payment Date', 'payment_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for amount_in_usd field
            //
            $editor = new StaticEditor('amount_in_usd_edit');
            $editColumn = new CustomEditColumn('Amount (in USD)', 'amount_in_usd', $editor, $this->dataset);
            $editColumn->setEnabled(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for customer_id field
            //
            $editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new DateField('birthday', true),
                    new StringField('email', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('last_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Customer', 'customer_id', 'customer_id_last_name', 'multi_edit_v_calculated_columns2_customer_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'last_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for amount field
            //
            $editor = new TextEdit('amount_edit');
            $editColumn = new CustomEditColumn('Amount', 'amount', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for currency field
            //
            $editor = new ComboBox('currency_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('USD', 'USD');
            $editor->addChoice('EUR', 'EUR');
            $editor->addChoice('GBP', 'GBP');
            $editor->addChoice('CHF', 'CHF');
            $editor->addChoice('CAD', 'CAD');
            $editor->addChoice('AUD', 'AUD');
            $editColumn = new CustomEditColumn('Currency', 'currency', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for payment_date field
            //
            $editor = new DateTimeEdit('payment_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Payment Date', 'payment_date', $editor, $this->dataset);
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
            // Edit column for customer_id field
            //
            $editor = new DynamicCombobox('customer_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new DateField('birthday', true),
                    new StringField('email', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('last_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Customer', 'customer_id', 'customer_id_last_name', 'insert_v_calculated_columns2_customer_id_search', $editor, $this->dataset, $lookupDataset, 'id', 'last_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for amount field
            //
            $editor = new TextEdit('amount_edit');
            $editColumn = new CustomEditColumn('Amount', 'amount', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for currency field
            //
            $editor = new ComboBox('currency_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('USD', 'USD');
            $editor->addChoice('EUR', 'EUR');
            $editor->addChoice('GBP', 'GBP');
            $editor->addChoice('CHF', 'CHF');
            $editor->addChoice('CAD', 'CAD');
            $editor->addChoice('AUD', 'AUD');
            $editColumn = new CustomEditColumn('Currency', 'currency', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('USD');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for payment_date field
            //
            $editor = new DateTimeEdit('payment_date_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Payment Date', 'payment_date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for amount_in_usd field
            //
            $editor = new StaticEditor('amount_in_usd_edit');
            $editColumn = new CustomEditColumn('Amount (in USD)', 'amount_in_usd', $editor, $this->dataset);
            $editColumn->setEnabled(false);
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
            // View column for last_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_last_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for amount field
            //
            $column = new NumberViewColumn('amount', 'amount', 'Amount', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for currency field
            //
            $column = new TextViewColumn('currency', 'currency', 'Currency', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for payment_date field
            //
            $column = new DateTimeViewColumn('payment_date', 'payment_date', 'Payment Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for amount_in_usd field
            //
            $column = new TextViewColumn('amount_in_usd', 'amount_in_usd', 'Amount (in USD)', $this->dataset);
            $column->SetOrderable(false);
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
            // View column for last_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_last_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for amount field
            //
            $column = new NumberViewColumn('amount', 'amount', 'Amount', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for currency field
            //
            $column = new TextViewColumn('currency', 'currency', 'Currency', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for payment_date field
            //
            $column = new DateTimeViewColumn('payment_date', 'payment_date', 'Payment Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for amount_in_usd field
            //
            $column = new TextViewColumn('amount_in_usd', 'amount_in_usd', 'Amount (in USD)', $this->dataset);
            $column->SetOrderable(false);
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
            // View column for last_name field
            //
            $column = new TextViewColumn('customer_id', 'customer_id_last_name', 'Customer', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for amount field
            //
            $column = new NumberViewColumn('amount', 'amount', 'Amount', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for currency field
            //
            $column = new TextViewColumn('currency', 'currency', 'Currency', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for payment_date field
            //
            $column = new DateTimeViewColumn('payment_date', 'payment_date', 'Payment Date', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for amount_in_usd field
            //
            $column = new TextViewColumn('amount_in_usd', 'amount_in_usd', 'Amount (in USD)', $this->dataset);
            $column->SetOrderable(false);
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
            $grid->setCalculateControlValuesScript('if ((editors[\'amount\'].getValue() >= 0) && editors[\'currency\'].getValue() && editors[\'payment_date\'].getValue()) {
                $.ajax({
                    url: window.location.href,
                    data: {
                        amount: editors[\'amount\'].getValue(),
                        currency: editors[\'currency\'].getValue(), 
                        paymentDate: editors[\'payment_date\'].getValue()
                    },
                    success: function (result) {
                        editors[\'amount_in_usd\'].setValue(result);                
                    },
                    error: function () {
                        editors[\'amount_in_usd\'].setValue(\'\');        
                    }
                });                   
            } else {
                editors[\'amount_in_usd\'].setValue(\'\');
            }');
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new DateField('birthday', true),
                    new StringField('email', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('last_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_v_calculated_columns2_customer_id_search', 'id', 'last_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new DateField('birthday', true),
                    new StringField('email', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('last_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_v_calculated_columns2_customer_id_search', 'id', 'last_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new DateField('birthday', true),
                    new StringField('email', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('last_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_v_calculated_columns2_customer_id_search', 'id', 'last_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`customer`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new DateField('birthday', true),
                    new StringField('email', true),
                    new IntegerField('address_id')
                )
            );
            $lookupDataset->setOrderByField('last_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_v_calculated_columns2_customer_id_search', 'id', 'last_name', null, 20);
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
            if ($fieldName == 'amount_in_usd') {
                $value = getAmountInUsd($rowData['amount'], $rowData['currency'], $rowData['payment_date'], $this->GetConnection());
            }
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
        $Page = new v_calculated_columns2Page("v_calculated_columns2", "calculated_columns2.php", GetCurrentUserPermissionsForPage("v_calculated_columns2"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_calculated_columns2"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
