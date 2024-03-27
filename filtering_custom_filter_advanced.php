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
    
    
    
    class v_filtering_custom_filter2Page extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Filtering.Custom Filter (Advanced Version)');
            $this->SetMenuLabel('Custom Filter - 2');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_filtering_custom_filter2`');
            $this->dataset->addFields(
                array(
                    new StringField('code', true, true),
                    new StringField('name', true),
                    new StringField('continent', true),
                    new IntegerField('population', true),
                    new IntegerField('life_expectancy')
                )
            );
        }
    
        protected function DoPrepare() {
            // handling custom filter parameters
            $lifeExpectancyFilter = array(
                'min' => -1,
                'max' => -1
            );
               
            if (GetApplication()->isGetValueSet('lifeExpectancyFilter')) {
                $lifeExpectancyFilterValue = GetApplication()->GetGETValue('lifeExpectancyFilter');
                if (is_array($lifeExpectancyFilterValue)) {
                    $lifeExpectancyFilter = array_merge($lifeExpectancyFilter, $lifeExpectancyFilterValue);
                }
            } elseif (isset($_SESSION['lifeExpectancyFilter'])) {
                $lifeExpectancyFilter = array_merge($lifeExpectancyFilter, $_SESSION['lifeExpectancyFilter']);
            }
            
            if ($lifeExpectancyFilter['min'] !== -1 && $lifeExpectancyFilter['max'] !== -1) {
                $this->dataset->AddCustomCondition(
                    sprintf('life_expectancy >= %d AND life_expectancy <= %d', 
                        $lifeExpectancyFilter['min'], $lifeExpectancyFilter['max']
                    )    
                );
                $_SESSION['lifeExpectancyFilter'] = $lifeExpectancyFilter;
            } else {
                unset($_SESSION['lifeExpectancyFilter']);
            }
            
            // auxiliary code
            $this->setDescription(file_get_contents("external_data/doc/filtering_custom_filter_advanced.html"));
            
            $this->setDetailedDescription(
                '<br>' .
                '<div id="on-get-custom-template" class="event-code">' .
                    extractMethodCode($this, 'doGetCustomTemplate') . '</div>' .
                '<div id="on-prepare-page" class="event-code">' .
                    extractMethodCode($this, 'doPrepare') . '</div>' .
                '<div id="on-after-page-load" class="event-code">' .
                    extractClientEventCode($this, 'OnAfterPageLoad') . '</div>' .
                '<div id="custom-grid-toolbar" style="display: none;">' .
                    extractTemplateFileCode('components/templates/custom_templates/custom_advanced_filter_grid_toolbar.tpl') . 
                '</div>' .
                '<div id="custom-advanced-filter" style="display: none;">' .
                    extractTemplateFileCode('components/templates/custom_templates/custom_advanced_filter.tpl') . 
                '</div>'    
            );
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
                new FilterColumn($this->dataset, 'code', 'code', 'Code'),
                new FilterColumn($this->dataset, 'name', 'name', 'Country'),
                new FilterColumn($this->dataset, 'continent', 'continent', 'Continent'),
                new FilterColumn($this->dataset, 'population', 'population', 'Population'),
                new FilterColumn($this->dataset, 'life_expectancy', 'life_expectancy', 'Life Expectancy')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['code'])
                ->addColumn($columns['name'])
                ->addColumn($columns['continent'])
                ->addColumn($columns['population'])
                ->addColumn($columns['life_expectancy']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('continent');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('code_edit');
            $main_editor->SetMaxLength(3);
            
            $filterBuilder->addColumn(
                $columns['code'],
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
                $columns['name'],
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
            
            $main_editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('Asia', 'Asia');
            $main_editor->addChoice('Europe', 'Europe');
            $main_editor->addChoice('North America', 'North America');
            $main_editor->addChoice('Africa', 'Africa');
            $main_editor->addChoice('Oceania', 'Oceania');
            $main_editor->addChoice('Antarctica', 'Antarctica');
            $main_editor->addChoice('South America', 'South America');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('continent');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('continent');
            
            $filterBuilder->addColumn(
                $columns['continent'],
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
            
            $main_editor = new TextEdit('population_edit');
            
            $filterBuilder->addColumn(
                $columns['population'],
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
            
            $main_editor = new TextEdit('life_expectancy_edit');
            
            $filterBuilder->addColumn(
                $columns['life_expectancy'],
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
            // View column for code field
            //
            $column = new TextViewColumn('code', 'code', 'Code', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for continent field
            //
            $column = new TextViewColumn('continent', 'continent', 'Continent', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::TABLET);
            $grid->AddViewColumn($column);
            //
            // View column for population field
            //
            $column = new NumberViewColumn('population', 'population', 'Population', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::TABLET);
            $grid->AddViewColumn($column);
            //
            // View column for life_expectancy field
            //
            $column = new NumberViewColumn('life_expectancy', 'life_expectancy', 'Life Expectancy', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for code field
            //
            $column = new TextViewColumn('code', 'code', 'Code', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for continent field
            //
            $column = new TextViewColumn('continent', 'continent', 'Continent', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for population field
            //
            $column = new NumberViewColumn('population', 'population', 'Population', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for life_expectancy field
            //
            $column = new NumberViewColumn('life_expectancy', 'life_expectancy', 'Life Expectancy', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for code field
            //
            $editor = new TextEdit('code_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Code', 'code', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(52);
            $editColumn = new CustomEditColumn('Country', 'name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for continent field
            //
            $editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('Asia', 'Asia');
            $editor->addChoice('Europe', 'Europe');
            $editor->addChoice('North America', 'North America');
            $editor->addChoice('Africa', 'Africa');
            $editor->addChoice('Oceania', 'Oceania');
            $editor->addChoice('Antarctica', 'Antarctica');
            $editor->addChoice('South America', 'South America');
            $editColumn = new CustomEditColumn('Continent', 'continent', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for population field
            //
            $editor = new TextEdit('population_edit');
            $editColumn = new CustomEditColumn('Population', 'population', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for life_expectancy field
            //
            $editor = new TextEdit('life_expectancy_edit');
            $editColumn = new CustomEditColumn('Life Expectancy', 'life_expectancy', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(52);
            $editColumn = new CustomEditColumn('Country', 'name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for continent field
            //
            $editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('Asia', 'Asia');
            $editor->addChoice('Europe', 'Europe');
            $editor->addChoice('North America', 'North America');
            $editor->addChoice('Africa', 'Africa');
            $editor->addChoice('Oceania', 'Oceania');
            $editor->addChoice('Antarctica', 'Antarctica');
            $editor->addChoice('South America', 'South America');
            $editColumn = new CustomEditColumn('Continent', 'continent', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for population field
            //
            $editor = new TextEdit('population_edit');
            $editColumn = new CustomEditColumn('Population', 'population', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for life_expectancy field
            //
            $editor = new TextEdit('life_expectancy_edit');
            $editColumn = new CustomEditColumn('Life Expectancy', 'life_expectancy', $editor, $this->dataset);
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
            // Edit column for code field
            //
            $editor = new TextEdit('code_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('Code', 'code', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(52);
            $editColumn = new CustomEditColumn('Country', 'name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for continent field
            //
            $editor = new ComboBox('continent_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('Asia', 'Asia');
            $editor->addChoice('Europe', 'Europe');
            $editor->addChoice('North America', 'North America');
            $editor->addChoice('Africa', 'Africa');
            $editor->addChoice('Oceania', 'Oceania');
            $editor->addChoice('Antarctica', 'Antarctica');
            $editor->addChoice('South America', 'South America');
            $editColumn = new CustomEditColumn('Continent', 'continent', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for population field
            //
            $editor = new TextEdit('population_edit');
            $editColumn = new CustomEditColumn('Population', 'population', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for life_expectancy field
            //
            $editor = new TextEdit('life_expectancy_edit');
            $editColumn = new CustomEditColumn('Life Expectancy', 'life_expectancy', $editor, $this->dataset);
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
            // View column for code field
            //
            $column = new TextViewColumn('code', 'code', 'Code', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for continent field
            //
            $column = new TextViewColumn('continent', 'continent', 'Continent', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for population field
            //
            $column = new NumberViewColumn('population', 'population', 'Population', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for life_expectancy field
            //
            $column = new NumberViewColumn('life_expectancy', 'life_expectancy', 'Life Expectancy', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for code field
            //
            $column = new TextViewColumn('code', 'code', 'Code', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for continent field
            //
            $column = new TextViewColumn('continent', 'continent', 'Continent', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for population field
            //
            $column = new NumberViewColumn('population', 'population', 'Population', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for life_expectancy field
            //
            $column = new NumberViewColumn('life_expectancy', 'life_expectancy', 'Life Expectancy', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for code field
            //
            $column = new TextViewColumn('code', 'code', 'Code', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for name field
            //
            $column = new TextViewColumn('name', 'name', 'Country', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for continent field
            //
            $column = new TextViewColumn('continent', 'continent', 'Continent', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for population field
            //
            $column = new NumberViewColumn('population', 'population', 'Population', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for life_expectancy field
            //
            $column = new NumberViewColumn('life_expectancy', 'life_expectancy', 'Life Expectancy', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
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
            return 'function initCustomFilter() {'. "\n" .
            '    var contentHtml = $(\'#custom_filter_content\').html();'. "\n" .
            '    var $form = $(\'.js-custom-filter-container\').first();'. "\n" .
            ''. "\n" .
            '    $(\'.js-reset-custom-filter\').on(\'click\', function() {'. "\n" .
            '        window.location = $.query.set(\'lifeExpectancyFilter\', \'\');'. "\n" .
            '        return false;'. "\n" .
            '    });'. "\n" .
            ''. "\n" .
            '    $form.find(\'a.js-filter-trigger\').each(function (i, el) {'. "\n" .
            '        var $a = $(el);'. "\n" .
            '        var $originalContent = $a.next(\'.js-content\');'. "\n" .
            ''. "\n" .
            '        var popover = $a.webuiPopover({'. "\n" .
            '            trigger: \'click\','. "\n" .
            '            backdrop: true,'. "\n" .
            '            content: \'\''. "\n" .
            '        }).data(\'plugin_webuiPopover\');'. "\n" .
            ''. "\n" .
            '        $a.on(\'show.webui.popover\', function () {'. "\n" .
            '            var $content = $(contentHtml);'. "\n" .
            '            $content.find(\'.js-content\').html($originalContent.html());'. "\n" .
            ''. "\n" .
            '            popover.$contentElement'. "\n" .
            '                .html($content.prop(\'outerHTML\'))'. "\n" .
            '                .find(\'.js-apply\').on(\'click\', function () {'. "\n" .
            '                    $originalContent.replaceWith(popover.$contentElement.clone());'. "\n" .
            '                    popover.hide();'. "\n" .
            '                    $form.trigger(\'submit\');'. "\n" .
            '                });'. "\n" .
            ''. "\n" .
            '            popover.$contentElement.find(\'.close\').on(\'click\', function () {'. "\n" .
            '                popover.hide();'. "\n" .
            '            });'. "\n" .
            ''. "\n" .
            '        });'. "\n" .
            '    });'. "\n" .
            ''. "\n" .
            '};'. "\n" .
            ''. "\n" .
            'initCustomFilter();';
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
            $this->SetShowBottomPageNavigator(true);
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
            if ($part == PagePart::GridToolbar && $mode == PageMode::ViewAll) {
                $result = 'custom_advanced_filter_grid_toolbar.tpl';
                
                $sql =
                    'SELECT ' .
                    '    FLOOR(MIN(life_expectancy)) as min_life_expectancy,' .
                    '    CEILING(MAX(life_expectancy)) as max_life_expectancy ' .
                    'FROM v_filtering_custom_filter2';
                $queryResult = array();
                $this->GetConnection()->ExecQueryToArray($sql, $queryResult);
                $minLifeExpectancy = $queryResult[0]['min_life_expectancy'];
                $maxLifeExpectancy = $queryResult[0]['max_life_expectancy'];
            
                $lifeExpectancyFilter = array(
                    'min' => $minLifeExpectancy,
                    'max' => $maxLifeExpectancy
                );
                if (isset($_SESSION['lifeExpectancyFilter'])) {
                    $lifeExpectancyFilter = array_merge($lifeExpectancyFilter, $_SESSION['lifeExpectancyFilter']);     
                } 
            
                $params['MinLifeExpectancy'] = $minLifeExpectancy;
                $params['MaxLifeExpectancy'] = $maxLifeExpectancy;
                $params['LifeExpectancyFilter'] = $lifeExpectancyFilter;
                
                $lifeExpectancyFilterActive = isset($_SESSION['lifeExpectancyFilter']);
                $params['LifeExpectancyFilterActive'] = $lifeExpectancyFilterActive;
                if ($lifeExpectancyFilterActive) {
                   $params['LifeExpectancyFilterAsString'] = 
                       sprintf('Life expectancy Is Between %d And %d years', 
                           $lifeExpectancyFilter['min'], $lifeExpectancyFilter['max']
                       );
                }    
            }
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
        $Page = new v_filtering_custom_filter2Page("v_filtering_custom_filter2", "filtering_custom_filter_advanced.php", GetCurrentUserPermissionsForPage("v_filtering_custom_filter2"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_filtering_custom_filter2"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
