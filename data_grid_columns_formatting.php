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
    
    
    
    class v_data_grid_columns_formattingPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Grid Columns.Formatting');
            $this->SetMenuLabel('Formatting');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_data_grid_columns_formatting`');
            $this->dataset->addFields(
                array(
                    new StringField('Code', true, true),
                    new StringField('Name', true),
                    new IntegerField('Capital'),
                    new StringField('Region', true),
                    new StringField('Continent', true),
                    new IntegerField('SurfaceArea', true),
                    new IntegerField('LifeExpectancy')
                )
            );
            $this->dataset->AddLookupField('Capital', 'city', new IntegerField('ID'), new StringField('Name', false, false, false, false, 'Capital_Name', 'Capital_Name_city'), 'Capital_Name_city');
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/data_grid_columns_formatting.html"));
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
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
                new FilterColumn($this->dataset, 'Code', 'Code', 'Code (Default)'),
                new FilterColumn($this->dataset, 'Name', 'Name', 'Country (Inline syles)'),
                new FilterColumn($this->dataset, 'Capital', 'Capital_Name', 'Capital (Bold)'),
                new FilterColumn($this->dataset, 'Region', 'Region', 'Region (Italic)'),
                new FilterColumn($this->dataset, 'Continent', 'Continent', 'Continent (Italic)'),
                new FilterColumn($this->dataset, 'SurfaceArea', 'SurfaceArea', 'Surface Area (Thousand separator)'),
                new FilterColumn($this->dataset, 'LifeExpectancy', 'LifeExpectancy', 'Life Expectancy (Decimal separator)')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Code'])
                ->addColumn($columns['Name'])
                ->addColumn($columns['Capital'])
                ->addColumn($columns['Continent'])
                ->addColumn($columns['SurfaceArea']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Continent');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('code_edit');
            $main_editor->SetMaxLength(3);
            
            $filterBuilder->addColumn(
                $columns['Code'],
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
            
            $main_editor = new TextEdit('name_edit');
            $main_editor->SetMaxLength(52);
            
            $filterBuilder->addColumn(
                $columns['Name'],
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
            
            $main_editor = new DynamicCombobox('capital_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_v_data_grid_columns_formatting_Capital_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Capital', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_v_data_grid_columns_formatting_Capital_search');
            
            $filterBuilder->addColumn(
                $columns['Capital'],
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
            
            $main_editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('Asia', 'Asia');
            $main_editor->addChoice('Europe', 'Europe');
            $main_editor->addChoice('North America', 'North America');
            $main_editor->addChoice('Africa', 'Africa');
            $main_editor->addChoice('Oceania', 'Oceania');
            $main_editor->addChoice('Antarctica', 'Antarctica');
            $main_editor->addChoice('South America', 'South America');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('Continent');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('Continent');
            
            $filterBuilder->addColumn(
                $columns['Continent'],
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
            
            $main_editor = new TextEdit('surfacearea_edit');
            
            $filterBuilder->addColumn(
                $columns['SurfaceArea'],
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
            // View column for Code field
            //
            $column = new TextViewColumn('Code', 'Code', 'Code (Default)', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Country (Inline syles)', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('font-family: monospace;');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Capital', 'Capital_Name', 'Capital (Bold)', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for Continent field
            //
            $column = new TextViewColumn('Continent', 'Continent', 'Continent (Italic)', $this->dataset);
            $column->SetOrderable(true);
            $column->setItalic(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for SurfaceArea field
            //
            $column = new NumberViewColumn('SurfaceArea', 'SurfaceArea', 'Surface Area (Thousand separator)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(' ');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Code field
            //
            $column = new TextViewColumn('Code', 'Code', 'Code (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Country (Inline syles)', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('font-family: monospace;');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Capital', 'Capital_Name', 'Capital (Bold)', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Continent field
            //
            $column = new TextViewColumn('Continent', 'Continent', 'Continent (Italic)', $this->dataset);
            $column->SetOrderable(true);
            $column->setItalic(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SurfaceArea field
            //
            $column = new NumberViewColumn('SurfaceArea', 'SurfaceArea', 'Surface Area (Thousand separator)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(' ');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Code field
            //
            $editor = new TextEdit('code_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Code (Default)', 'Code', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(52);
            $editColumn = new CustomEditColumn('Country (Inline syles)', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Capital field
            //
            $editor = new ComboBox('capital_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Capital (Bold)', 
                'Capital', 
                $editor, 
                $this->dataset, 'ID', 'Name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Continent field
            //
            $editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('Asia', 'Asia');
            $editor->addChoice('Europe', 'Europe');
            $editor->addChoice('North America', 'North America');
            $editor->addChoice('Africa', 'Africa');
            $editor->addChoice('Oceania', 'Oceania');
            $editor->addChoice('Antarctica', 'Antarctica');
            $editor->addChoice('South America', 'South America');
            $editColumn = new CustomEditColumn('Continent (Italic)', 'Continent', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SurfaceArea field
            //
            $editor = new TextEdit('surfacearea_edit');
            $editColumn = new CustomEditColumn('Surface Area (Thousand separator)', 'SurfaceArea', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(52);
            $editColumn = new CustomEditColumn('Country (Inline syles)', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Capital field
            //
            $editor = new ComboBox('capital_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Capital (Bold)', 
                'Capital', 
                $editor, 
                $this->dataset, 'ID', 'Name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Continent field
            //
            $editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('Asia', 'Asia');
            $editor->addChoice('Europe', 'Europe');
            $editor->addChoice('North America', 'North America');
            $editor->addChoice('Africa', 'Africa');
            $editor->addChoice('Oceania', 'Oceania');
            $editor->addChoice('Antarctica', 'Antarctica');
            $editor->addChoice('South America', 'South America');
            $editColumn = new CustomEditColumn('Continent (Italic)', 'Continent', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for SurfaceArea field
            //
            $editor = new TextEdit('surfacearea_edit');
            $editColumn = new CustomEditColumn('Surface Area (Thousand separator)', 'SurfaceArea', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for LifeExpectancy field
            //
            $editor = new TextEdit('lifeexpectancy_edit');
            $editColumn = new CustomEditColumn('Life Expectancy (Decimal separator)', 'LifeExpectancy', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Region field
            //
            $editor = new TextEdit('region_edit');
            $editor->SetMaxLength(26);
            $editColumn = new CustomEditColumn('Region (Italic)', 'Region', $editor, $this->dataset);
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
            // Edit column for Code field
            //
            $editor = new TextEdit('code_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Code (Default)', 'Code', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(52);
            $editColumn = new CustomEditColumn('Country (Inline syles)', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Capital field
            //
            $editor = new ComboBox('capital_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Capital (Bold)', 
                'Capital', 
                $editor, 
                $this->dataset, 'ID', 'Name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Continent field
            //
            $editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('Asia', 'Asia');
            $editor->addChoice('Europe', 'Europe');
            $editor->addChoice('North America', 'North America');
            $editor->addChoice('Africa', 'Africa');
            $editor->addChoice('Oceania', 'Oceania');
            $editor->addChoice('Antarctica', 'Antarctica');
            $editor->addChoice('South America', 'South America');
            $editColumn = new CustomEditColumn('Continent (Italic)', 'Continent', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SurfaceArea field
            //
            $editor = new TextEdit('surfacearea_edit');
            $editColumn = new CustomEditColumn('Surface Area (Thousand separator)', 'SurfaceArea', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            // View column for Code field
            //
            $column = new TextViewColumn('Code', 'Code', 'Code (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Country (Inline syles)', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('font-family: monospace;');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Capital', 'Capital_Name', 'Capital (Bold)', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Continent field
            //
            $column = new TextViewColumn('Continent', 'Continent', 'Continent (Italic)', $this->dataset);
            $column->SetOrderable(true);
            $column->setItalic(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SurfaceArea field
            //
            $column = new NumberViewColumn('SurfaceArea', 'SurfaceArea', 'Surface Area (Thousand separator)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(' ');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Code field
            //
            $column = new TextViewColumn('Code', 'Code', 'Code (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Country (Inline syles)', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('font-family: monospace;');
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Capital', 'Capital_Name', 'Capital (Bold)', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Continent field
            //
            $column = new TextViewColumn('Continent', 'Continent', 'Continent (Italic)', $this->dataset);
            $column->SetOrderable(true);
            $column->setItalic(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SurfaceArea field
            //
            $column = new NumberViewColumn('SurfaceArea', 'SurfaceArea', 'Surface Area (Thousand separator)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(' ');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Code field
            //
            $column = new TextViewColumn('Code', 'Code', 'Code (Default)', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Country (Inline syles)', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('font-family: monospace;');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Capital', 'Capital_Name', 'Capital (Bold)', $this->dataset);
            $column->SetOrderable(true);
            $column->setBold(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Continent field
            //
            $column = new TextViewColumn('Continent', 'Continent', 'Continent (Italic)', $this->dataset);
            $column->SetOrderable(true);
            $column->setItalic(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for SurfaceArea field
            //
            $column = new NumberViewColumn('SurfaceArea', 'SurfaceArea', 'Surface Area (Thousand separator)', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(' ');
            $column->setDecimalSeparator('.');
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
            $defaultSortedColumns = array();
            $defaultSortedColumns[] = new SortColumn('SurfaceArea', 'DESC');
            $result->setDefaultOrdering($defaultSortedColumns);
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
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
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
            
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_v_data_grid_columns_formatting_Capital_search', 'ID', 'Name', null, 20);
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
        $Page = new v_data_grid_columns_formattingPage("v_data_grid_columns_formatting", "data_grid_columns_formatting.php", GetCurrentUserPermissionsForPage("v_data_grid_columns_formatting"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_data_grid_columns_formatting"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
