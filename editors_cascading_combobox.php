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
    
    class v_editors_cascading_combobox_address_id_level0NestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $this->dataset->addFields(
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
            $this->dataset->AddLookupField('Capital', 'city', new IntegerField('ID'), new StringField('Name', false, false, false, false, 'Capital_Name', 'Capital_Name_city'), 'Capital_Name_city');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Code field
            //
            $editor = new TextEdit('code_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Code', 'Code', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(52);
            $editColumn = new CustomEditColumn('Name', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editColumn = new CustomEditColumn('Continent', 'Continent', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Region field
            //
            $editor = new TextEdit('region_edit');
            $editor->SetMaxLength(26);
            $editColumn = new CustomEditColumn('Region', 'Region', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SurfaceArea field
            //
            $editor = new TextEdit('surfacearea_edit');
            $editColumn = new CustomEditColumn('Surface Area', 'SurfaceArea', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for IndepYear field
            //
            $editor = new TextEdit('indepyear_edit');
            $editColumn = new CustomEditColumn('Indep Year', 'IndepYear', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Population field
            //
            $editor = new TextEdit('population_edit');
            $editColumn = new CustomEditColumn('Population', 'Population', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for LifeExpectancy field
            //
            $editor = new TextEdit('lifeexpectancy_edit');
            $editColumn = new CustomEditColumn('Life Expectancy', 'LifeExpectancy', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Capital field
            //
            $editor = new DynamicCombobox('capital_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
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
            $editColumn = new DynamicLookupEditColumn('Capital', 'Capital', 'Capital_Name', 'insert_v_editors_cascading_combobox_address_id_level0NestedPage_Capital_search', $editor, $this->dataset, $lookupDataset, 'ID', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for flag field
            //
            $editor = new TextEdit('flag_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Flag', 'flag', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for emblem field
            //
            $editor = new TextEdit('emblem_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Emblem', 'emblem', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
       static public function getNestedInsertHandlerName()
        {
            return get_class() . '_form_insert';
        }
    
        public function GetGridInsertHandler()
        {
            return self::getNestedInsertHandlerName();
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
    }
    
    class v_editors_cascading_combobox_address_id_level1NestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $this->dataset->AddLookupField('CountryCode', 'country', new StringField('Code'), new StringField('Name', false, false, false, false, 'CountryCode_Name', 'CountryCode_Name_country'), 'CountryCode_Name_country');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(35);
            $editColumn = new CustomEditColumn('Name', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CountryCode field
            //
            $editor = new DynamicCombobox('countrycode_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('Name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Country', 'CountryCode', 'CountryCode_Name', 'insert_v_editors_cascading_combobox_address_id_level1NestedPage_CountryCode_search', $editor, $this->dataset, $lookupDataset, 'Code', 'Name', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for District field
            //
            $editor = new TextEdit('district_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('District', 'District', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Population field
            //
            $editor = new TextEdit('population_edit');
            $editColumn = new CustomEditColumn('Population', 'Population', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
       static public function getNestedInsertHandlerName()
        {
            return get_class() . '_form_insert';
        }
    
        public function GetGridInsertHandler()
        {
            return self::getNestedInsertHandlerName();
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
    }
    
    class v_editors_cascading_combobox_address_id_level2NestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`address`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('caption'),
                    new IntegerField('city_id')
                )
            );
            $this->dataset->AddLookupField('city_id', 'city', new IntegerField('ID'), new StringField('Name', false, false, false, false, 'city_id_Name', 'city_id_Name_city'), 'city_id_Name_city');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for caption field
            //
            $editor = new TextEdit('caption_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Caption', 'caption', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for city_id field
            //
            $editor = new CascadingCombobox('city_id_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $dataset0->addFields(
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
            $dataset0->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset0, 'Code', 'Name', null, ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset0, 'Code', 'Name', 'Country', null);
            
            $dataset1 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $dataset1->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $dataset1->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset1, 'ID', 'Name', new ForeignKeyInfo('Code', 'CountryCode'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset1, 'ID', 'Name', 'City', new ForeignKeyInfo('Code', 'CountryCode'));
            
            $editColumn = new CascadingEditColumn('City', 'city_id', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
       static public function getNestedInsertHandlerName()
        {
            return get_class() . '_form_insert';
        }
    
        public function GetGridInsertHandler()
        {
            return self::getNestedInsertHandlerName();
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class v_editors_cascading_comboboxPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Editors.Cascading Combobox');
            $this->SetMenuLabel('Cascading Combobox');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_editors_cascading_combobox`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('first_name', true),
                    new StringField('last_name', true),
                    new IntegerField('address_id')
                )
            );
            $this->dataset->AddLookupField('address_id', 'address', new IntegerField('id'), new StringField('caption', false, false, false, false, 'address_id_caption', 'address_id_caption_address'), 'address_id_caption_address');
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/editors_cascading_combobox.html"));
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
                new FilterColumn($this->dataset, 'first_name', 'first_name', 'First Name'),
                new FilterColumn($this->dataset, 'last_name', 'last_name', 'Last Name'),
                new FilterColumn($this->dataset, 'address_id', 'address_id_caption', 'Address')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['first_name'])
                ->addColumn($columns['last_name'])
                ->addColumn($columns['address_id']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('address_id');
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
            
            $main_editor = new TextEdit('first_name_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['first_name'],
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
            
            $main_editor = new TextEdit('last_name_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['last_name'],
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
            
            $main_editor = new DynamicCombobox('address_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_v_editors_cascading_combobox_address_id_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('address_id', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_v_editors_cascading_combobox_address_id_search');
            
            $filterBuilder->addColumn(
                $columns['address_id'],
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
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', 'first_name', 'First Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', 'last_name', 'Last Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for caption field
            //
            $column = new TextViewColumn('address_id', 'address_id_caption', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', 'first_name', 'First Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', 'last_name', 'Last Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for caption field
            //
            $column = new TextViewColumn('address_id', 'address_id_caption', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('First Name', 'first_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Last Name', 'last_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for address_id field
            //
            $editor = new CascadingCombobox('address_id_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $dataset0->addFields(
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
            $dataset0->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset0, 'Code', 'Name', null, ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset0, 'Code', 'Name', 'Country', null);
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level0NestedPage::getNestedInsertHandlerName())
            );
            
            $dataset1 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $dataset1->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $dataset1->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset1, 'ID', 'Name', new ForeignKeyInfo('Code', 'CountryCode'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset1, 'ID', 'Name', 'City', new ForeignKeyInfo('Code', 'CountryCode'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level1NestedPage::getNestedInsertHandlerName())
            );
            
            $dataset2 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`address`');
            $dataset2->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('caption'),
                    new IntegerField('city_id')
                )
            );
            $dataset2->setOrderByField('caption', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset2, 'id', 'caption', new ForeignKeyInfo('ID', 'city_id'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset2, 'id', 'caption', 'Address', new ForeignKeyInfo('ID', 'city_id'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level2NestedPage::getNestedInsertHandlerName())
            );
            
            $editColumn = new CascadingEditColumn('Address', 'address_id', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('First Name', 'first_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Last Name', 'last_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for address_id field
            //
            $editor = new CascadingCombobox('address_id_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $dataset0->addFields(
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
            $dataset0->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset0, 'Code', 'Name', null, ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset0, 'Code', 'Name', 'Country', null);
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level0NestedPage::getNestedInsertHandlerName())
            );
            
            $dataset1 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $dataset1->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $dataset1->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset1, 'ID', 'Name', new ForeignKeyInfo('Code', 'CountryCode'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset1, 'ID', 'Name', 'City', new ForeignKeyInfo('Code', 'CountryCode'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level1NestedPage::getNestedInsertHandlerName())
            );
            
            $dataset2 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`address`');
            $dataset2->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('caption'),
                    new IntegerField('city_id')
                )
            );
            $dataset2->setOrderByField('caption', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset2, 'id', 'caption', new ForeignKeyInfo('ID', 'city_id'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset2, 'id', 'caption', 'Address', new ForeignKeyInfo('ID', 'city_id'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level2NestedPage::getNestedInsertHandlerName())
            );
            
            $editColumn = new CascadingEditColumn('Address', 'address_id', $editor, $this->dataset);
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
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('First Name', 'first_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Last Name', 'last_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for address_id field
            //
            $editor = new CascadingCombobox('address_id_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $dataset0->addFields(
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
            $dataset0->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset0, 'Code', 'Name', null, ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset0, 'Code', 'Name', 'Country', null);
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level0NestedPage::getNestedInsertHandlerName())
            );
            
            $dataset1 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`city`');
            $dataset1->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Name', true),
                    new StringField('CountryCode', true),
                    new StringField('District', true),
                    new IntegerField('Population', true)
                )
            );
            $dataset1->setOrderByField('Name', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset1, 'ID', 'Name', new ForeignKeyInfo('Code', 'CountryCode'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset1, 'ID', 'Name', 'City', new ForeignKeyInfo('Code', 'CountryCode'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level1NestedPage::getNestedInsertHandlerName())
            );
            
            $dataset2 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`address`');
            $dataset2->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('caption'),
                    new IntegerField('city_id')
                )
            );
            $dataset2->setOrderByField('caption', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset2, 'id', 'caption', new ForeignKeyInfo('ID', 'city_id'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset2, 'id', 'caption', 'Address', new ForeignKeyInfo('ID', 'city_id'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(v_editors_cascading_combobox_address_id_level2NestedPage::getNestedInsertHandlerName())
            );
            
            $editColumn = new CascadingEditColumn('Address', 'address_id', $editor, $this->dataset);
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
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', 'first_name', 'First Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', 'last_name', 'Last Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for caption field
            //
            $column = new TextViewColumn('address_id', 'address_id_caption', 'Address', $this->dataset);
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
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', 'first_name', 'First Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', 'last_name', 'Last Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for caption field
            //
            $column = new TextViewColumn('address_id', 'address_id_caption', 'Address', $this->dataset);
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
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', 'first_name', 'First Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', 'last_name', 'Last Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for caption field
            //
            $column = new TextViewColumn('address_id', 'address_id_caption', 'Address', $this->dataset);
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
            
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`address`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('caption'),
                    new IntegerField('city_id')
                )
            );
            $lookupDataset->setOrderByField('caption', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_v_editors_cascading_combobox_address_id_search', 'id', 'caption', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_v_editors_cascading_combobox_address_id_level0NestedPage_Capital_search', 'ID', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`country`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('Name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_v_editors_cascading_combobox_address_id_level1NestedPage_CountryCode_search', 'Code', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            
            
            
            new v_editors_cascading_combobox_address_id_level0NestedPage($this, GetCurrentUserPermissionsForPage('v_editors_cascading_combobox.address_id'));
            new v_editors_cascading_combobox_address_id_level1NestedPage($this, GetCurrentUserPermissionsForPage('v_editors_cascading_combobox.address_id'));
            new v_editors_cascading_combobox_address_id_level2NestedPage($this, GetCurrentUserPermissionsForPage('v_editors_cascading_combobox.address_id'));
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
        $Page = new v_editors_cascading_comboboxPage("v_editors_cascading_combobox", "editors_cascading_combobox.php", GetCurrentUserPermissionsForPage("v_editors_cascading_combobox"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_editors_cascading_combobox"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
