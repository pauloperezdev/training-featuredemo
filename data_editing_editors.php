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
    
    
    
    class v_data_editing_editorsPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Data Input Forms.Editors Overview');
            $this->SetMenuLabel('Editors Overview');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_data_editing_editors`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new IntegerField('autocomplete'),
                    new IntegerField('checkbox'),
                    new StringField('checkbox_group'),
                    new StringField('color'),
                    new StringField('combobox'),
                    new DateTimeField('datetime'),
                    new StringField('html'),
                    new BlobField('image'),
                    new StringField('masked'),
                    new IntegerField('multi_level'),
                    new StringField('multi_value'),
                    new StringField('radio'),
                    new IntegerField('range'),
                    new IntegerField('spin'),
                    new StringField('text'),
                    new TimeField('time')
                )
            );
            $this->dataset->AddLookupField('autocomplete', 'city', new IntegerField('ID'), new StringField('Name', false, false, false, false, 'autocomplete_Name', 'autocomplete_Name_city'), 'autocomplete_Name_city');
            $this->dataset->AddLookupField('multi_level', 'city', new IntegerField('ID'), new StringField('Name', false, false, false, false, 'multi_level_Name', 'multi_level_Name_city'), 'multi_level_Name_city');
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/data_editing_editors.html"));
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
                new FilterColumn($this->dataset, 'autocomplete', 'autocomplete_Name', 'Autocomplete'),
                new FilterColumn($this->dataset, 'multi_level', 'multi_level_Name', 'Multi Level'),
                new FilterColumn($this->dataset, 'combobox', 'combobox', 'Combobox'),
                new FilterColumn($this->dataset, 'multi_value', 'multi_value', 'Multi Value'),
                new FilterColumn($this->dataset, 'radio', 'radio', 'Radio'),
                new FilterColumn($this->dataset, 'checkbox_group', 'checkbox_group', 'Checkbox Group'),
                new FilterColumn($this->dataset, 'checkbox', 'checkbox', 'Checkbox'),
                new FilterColumn($this->dataset, 'datetime', 'datetime', 'Datetime'),
                new FilterColumn($this->dataset, 'time', 'time', 'Time'),
                new FilterColumn($this->dataset, 'text', 'text', 'Text'),
                new FilterColumn($this->dataset, 'masked', 'masked', 'Masked'),
                new FilterColumn($this->dataset, 'range', 'range', 'Range'),
                new FilterColumn($this->dataset, 'spin', 'spin', 'Spin'),
                new FilterColumn($this->dataset, 'color', 'color', 'Color'),
                new FilterColumn($this->dataset, 'image', 'image', 'Image'),
                new FilterColumn($this->dataset, 'html', 'html', 'Html')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['autocomplete'])
                ->addColumn($columns['checkbox'])
                ->addColumn($columns['checkbox_group'])
                ->addColumn($columns['color'])
                ->addColumn($columns['combobox'])
                ->addColumn($columns['datetime'])
                ->addColumn($columns['html'])
                ->addColumn($columns['image'])
                ->addColumn($columns['masked'])
                ->addColumn($columns['multi_level'])
                ->addColumn($columns['multi_value'])
                ->addColumn($columns['radio'])
                ->addColumn($columns['range'])
                ->addColumn($columns['spin'])
                ->addColumn($columns['text'])
                ->addColumn($columns['time']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('autocomplete')
                ->setOptionsFor('datetime');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('autocomplete_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_v_data_editing_editors_autocomplete_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('autocomplete', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_v_data_editing_editors_autocomplete_search');
            
            $text_editor = new TextEdit('autocomplete');
            
            $filterBuilder->addColumn(
                $columns['autocomplete'],
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
            
            $main_editor = new DynamicCombobox('multi_level_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_v_data_editing_editors_multi_level_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('multi_level', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_v_data_editing_editors_multi_level_search');
            
            $text_editor = new TextEdit('multi_level');
            
            $filterBuilder->addColumn(
                $columns['multi_level'],
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
            
            $main_editor = new ComboBox('combobox_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('One', 'One');
            $main_editor->addChoice('Two', 'Two');
            $main_editor->addChoice('Three', 'Three');
            $main_editor->addChoice('Four', 'Four');
            $main_editor->addChoice('Five', 'Five');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('combobox');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('combobox');
            
            $filterBuilder->addColumn(
                $columns['combobox'],
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
            
            $main_editor = new MultiValueSelect('multi_value_edit');
            $main_editor->addChoice('One', 'One');
            $main_editor->addChoice('Two', 'Two');
            $main_editor->addChoice('Three', 'Three');
            $main_editor->addChoice('Four', 'Four');
            $main_editor->addChoice('Five', 'Five');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('multi_value');
            
            $filterBuilder->addColumn(
                $columns['multi_value'],
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
            
            $main_editor = new ComboBox('radio');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('One', 'One');
            $main_editor->addChoice('Two', 'Two');
            $main_editor->addChoice('Three', 'Three');
            $main_editor->addChoice('Four', 'Four');
            $main_editor->addChoice('Five', 'Five');
            
            $multi_value_select_editor = new MultiValueSelect('radio');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('radio');
            
            $filterBuilder->addColumn(
                $columns['radio'],
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
            
            $main_editor = new MultiValueSelect('checkbox_group');
            $main_editor->addChoice('One', 'One');
            $main_editor->addChoice('Two', 'Two');
            $main_editor->addChoice('Three', 'Three');
            $main_editor->addChoice('Four', 'Four');
            $main_editor->addChoice('Five', 'Five');
            
            $text_editor = new TextEdit('checkbox_group');
            
            $filterBuilder->addColumn(
                $columns['checkbox_group'],
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
            
            $main_editor = new ComboBox('checkbox');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['checkbox'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('datetime_edit', false, 'd M Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['datetime'],
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
            
            $main_editor = new TimeEdit('time_edit', 'H:i:s');
            
            $filterBuilder->addColumn(
                $columns['time'],
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
            
            $main_editor = new TextEdit('text_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['text'],
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
            
            $main_editor = new MaskedEdit('masked_edit', '(999) 999-99-99');
            
            $text_editor = new TextEdit('masked');
            
            $filterBuilder->addColumn(
                $columns['masked'],
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new RangeEdit('range_edit');
            $main_editor->SetUseConstraints(true);
            $main_editor->SetMaxValue(100);
            $main_editor->SetMinValue(0);
            $main_editor->SetStep(1);
            
            $text_editor = new TextEdit('range');
            
            $filterBuilder->addColumn(
                $columns['range'],
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new SpinEdit('spin_edit');
            
            $text_editor = new TextEdit('spin');
            
            $filterBuilder->addColumn(
                $columns['spin'],
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ColorEdit('color_edit');
            
            $text_editor = new TextEdit('color');
            
            $filterBuilder->addColumn(
                $columns['color'],
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('image');
            
            $filterBuilder->addColumn(
                $columns['image'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('html');
            
            $filterBuilder->addColumn(
                $columns['html'],
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
            // View column for Name field
            //
            $column = new TextViewColumn('autocomplete', 'autocomplete_Name', 'Autocomplete', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for multi_value field
            //
            $column = new TextViewColumn('multi_value', 'multi_value', 'Multi Value', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for checkbox_group field
            //
            $column = new TextViewColumn('checkbox_group', 'checkbox_group', 'Checkbox Group', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for checkbox field
            //
            $column = new CheckboxViewColumn('checkbox', 'checkbox', 'Checkbox', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for datetime field
            //
            $column = new DateTimeViewColumn('datetime', 'datetime', 'Datetime', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for color field
            //
            $column = new TextViewColumn('color', 'color', 'Color', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Name field
            //
            $column = new TextViewColumn('autocomplete', 'autocomplete_Name', 'Autocomplete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('multi_level', 'multi_level_Name', 'Multi Level', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for combobox field
            //
            $column = new TextViewColumn('combobox', 'combobox', 'Combobox', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for multi_value field
            //
            $column = new TextViewColumn('multi_value', 'multi_value', 'Multi Value', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for radio field
            //
            $column = new TextViewColumn('radio', 'radio', 'Radio', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for checkbox_group field
            //
            $column = new TextViewColumn('checkbox_group', 'checkbox_group', 'Checkbox Group', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for checkbox field
            //
            $column = new CheckboxViewColumn('checkbox', 'checkbox', 'Checkbox', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for datetime field
            //
            $column = new DateTimeViewColumn('datetime', 'datetime', 'Datetime', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for time field
            //
            $column = new DateTimeViewColumn('time', 'time', 'Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for text field
            //
            $column = new TextViewColumn('text', 'text', 'Text', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for masked field
            //
            $column = new TextViewColumn('masked', 'masked', 'Masked', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for range field
            //
            $column = new NumberViewColumn('range', 'range', 'Range', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for spin field
            //
            $column = new NumberViewColumn('spin', 'spin', 'Spin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for color field
            //
            $column = new TextViewColumn('color', 'color', 'Color', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for image field
            //
            $column = new TextViewColumn('image', 'image', 'Image', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for html field
            //
            $column = new TextViewColumn('html', 'html', 'Html', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for autocomplete field
            //
            $editor = new DynamicCombobox('autocomplete_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CountryCode = \'GBR\''));
            $editColumn = new DynamicLookupEditColumn('Autocomplete', 'autocomplete', 'autocomplete_Name', 'edit_v_data_editing_editors_autocomplete_search', $editor, $this->dataset, $lookupDataset, 'ID', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for multi_level field
            //
            $editor = new DynamicCascadingCombobox('multi_level_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $editor->setNumberOfValuesToDisplay(20);
            
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
            $level = $editor->addLevel($dataset1, 'ID', 'Name', 'Multi Level', new ForeignKeyInfo('Code', 'CountryCode'));
            
            $editColumn = new CascadingEditColumn('Multi Level', 'multi_level', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for combobox field
            //
            $editor = new ComboBox('combobox_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Combobox', 'combobox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for multi_value field
            //
            $editor = new MultiValueSelect('multi_value_edit');
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Multi Value', 'multi_value', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for radio field
            //
            $editor = new RadioEdit('radio_edit');
            $editor->SetDisplayMode(RadioEdit::StackedMode);
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Radio', 'radio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for checkbox_group field
            //
            $editor = new CheckBoxGroup('checkbox_group_edit');
            $editor->SetDisplayMode(CheckBoxGroup::StackedMode);
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Checkbox Group', 'checkbox_group', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for checkbox field
            //
            $editor = new CheckBox('checkbox_edit');
            $editColumn = new CustomEditColumn('Checkbox', 'checkbox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for datetime field
            //
            $editor = new DateTimeEdit('datetime_edit', false, 'd M Y H:i:s');
            $editColumn = new CustomEditColumn('Datetime', 'datetime', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for time field
            //
            $editor = new TimeEdit('time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Time', 'time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for text field
            //
            $editor = new TextEdit('text_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Text', 'text', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for masked field
            //
            $editor = new MaskedEdit('masked_edit', '(999) 999-99-99');
            $editColumn = new CustomEditColumn('Masked', 'masked', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for range field
            //
            $editor = new RangeEdit('range_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(100);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
            $editColumn = new CustomEditColumn('Range', 'range', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for spin field
            //
            $editor = new SpinEdit('spin_edit');
            $editColumn = new CustomEditColumn('Spin', 'spin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for color field
            //
            $editor = new ColorEdit('color_edit');
            $editColumn = new CustomEditColumn('Color', 'color', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for image field
            //
            $editor = new ImageUploader('image_edit');
            $editor->SetShowImage(true);
            $editColumn = new FileUploadingColumn('Image', 'image', $editor, $this->dataset, false, false, 'v_data_editing_editors_image_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for html field
            //
            $editor = new HtmlWysiwygEditor('html_edit');
            $editColumn = new CustomEditColumn('Html', 'html', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for autocomplete field
            //
            $editor = new DynamicCombobox('autocomplete_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CountryCode = \'GBR\''));
            $editColumn = new DynamicLookupEditColumn('Autocomplete', 'autocomplete', 'autocomplete_Name', 'multi_edit_v_data_editing_editors_autocomplete_search', $editor, $this->dataset, $lookupDataset, 'ID', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for checkbox field
            //
            $editor = new CheckBox('checkbox_edit');
            $editColumn = new CustomEditColumn('Checkbox', 'checkbox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for checkbox_group field
            //
            $editor = new CheckBoxGroup('checkbox_group_edit');
            $editor->SetDisplayMode(CheckBoxGroup::StackedMode);
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Checkbox Group', 'checkbox_group', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for color field
            //
            $editor = new ColorEdit('color_edit');
            $editColumn = new CustomEditColumn('Color', 'color', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for combobox field
            //
            $editor = new ComboBox('combobox_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Combobox', 'combobox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for datetime field
            //
            $editor = new DateTimeEdit('datetime_edit', false, 'd M Y H:i:s');
            $editColumn = new CustomEditColumn('Datetime', 'datetime', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for html field
            //
            $editor = new HtmlWysiwygEditor('html_edit');
            $editColumn = new CustomEditColumn('Html', 'html', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for image field
            //
            $editor = new ImageUploader('image_edit');
            $editor->SetShowImage(true);
            $editColumn = new FileUploadingColumn('Image', 'image', $editor, $this->dataset, false, false, 'v_data_editing_editors_image_handler_multi_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for masked field
            //
            $editor = new MaskedEdit('masked_edit', '(999) 999-99-99');
            $editColumn = new CustomEditColumn('Masked', 'masked', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for multi_level field
            //
            $editor = new DynamicCascadingCombobox('multi_level_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $editor->setNumberOfValuesToDisplay(20);
            
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
            $level = $editor->addLevel($dataset1, 'ID', 'Name', 'Multi Level', new ForeignKeyInfo('Code', 'CountryCode'));
            
            $editColumn = new CascadingEditColumn('Multi Level', 'multi_level', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for multi_value field
            //
            $editor = new MultiValueSelect('multi_value_edit');
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Multi Value', 'multi_value', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for radio field
            //
            $editor = new RadioEdit('radio_edit');
            $editor->SetDisplayMode(RadioEdit::StackedMode);
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Radio', 'radio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for range field
            //
            $editor = new RangeEdit('range_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(100);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
            $editColumn = new CustomEditColumn('Range', 'range', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for spin field
            //
            $editor = new SpinEdit('spin_edit');
            $editColumn = new CustomEditColumn('Spin', 'spin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for text field
            //
            $editor = new TextEdit('text_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Text', 'text', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for time field
            //
            $editor = new TimeEdit('time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Time', 'time', $editor, $this->dataset);
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
            // Edit column for autocomplete field
            //
            $editor = new DynamicCombobox('autocomplete_edit', $this->CreateLinkBuilder());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CountryCode = \'GBR\''));
            $editColumn = new DynamicLookupEditColumn('Autocomplete', 'autocomplete', 'autocomplete_Name', 'insert_v_data_editing_editors_autocomplete_search', $editor, $this->dataset, $lookupDataset, 'ID', 'Name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for multi_level field
            //
            $editor = new DynamicCascadingCombobox('multi_level_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $editor->setNumberOfValuesToDisplay(20);
            
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
            $level = $editor->addLevel($dataset1, 'ID', 'Name', 'Multi Level', new ForeignKeyInfo('Code', 'CountryCode'));
            
            $editColumn = new CascadingEditColumn('Multi Level', 'multi_level', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for combobox field
            //
            $editor = new ComboBox('combobox_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Combobox', 'combobox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for multi_value field
            //
            $editor = new MultiValueSelect('multi_value_edit');
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Multi Value', 'multi_value', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for radio field
            //
            $editor = new RadioEdit('radio_edit');
            $editor->SetDisplayMode(RadioEdit::StackedMode);
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Radio', 'radio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for checkbox_group field
            //
            $editor = new CheckBoxGroup('checkbox_group_edit');
            $editor->SetDisplayMode(CheckBoxGroup::StackedMode);
            $editor->addChoice('One', 'One');
            $editor->addChoice('Two', 'Two');
            $editor->addChoice('Three', 'Three');
            $editor->addChoice('Four', 'Four');
            $editor->addChoice('Five', 'Five');
            $editColumn = new CustomEditColumn('Checkbox Group', 'checkbox_group', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for checkbox field
            //
            $editor = new CheckBox('checkbox_edit');
            $editColumn = new CustomEditColumn('Checkbox', 'checkbox', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for datetime field
            //
            $editor = new DateTimeEdit('datetime_edit', false, 'd M Y H:i:s');
            $editColumn = new CustomEditColumn('Datetime', 'datetime', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for time field
            //
            $editor = new TimeEdit('time_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Time', 'time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for text field
            //
            $editor = new TextEdit('text_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Text', 'text', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for masked field
            //
            $editor = new MaskedEdit('masked_edit', '(999) 999-99-99');
            $editColumn = new CustomEditColumn('Masked', 'masked', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for range field
            //
            $editor = new RangeEdit('range_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(100);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
            $editColumn = new CustomEditColumn('Range', 'range', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for spin field
            //
            $editor = new SpinEdit('spin_edit');
            $editColumn = new CustomEditColumn('Spin', 'spin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for color field
            //
            $editor = new ColorEdit('color_edit');
            $editColumn = new CustomEditColumn('Color', 'color', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for image field
            //
            $editor = new ImageUploader('image_edit');
            $editor->SetShowImage(true);
            $editColumn = new FileUploadingColumn('Image', 'image', $editor, $this->dataset, false, false, 'v_data_editing_editors_image_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for html field
            //
            $editor = new HtmlWysiwygEditor('html_edit');
            $editColumn = new CustomEditColumn('Html', 'html', $editor, $this->dataset);
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
            // View column for Name field
            //
            $column = new TextViewColumn('autocomplete', 'autocomplete_Name', 'Autocomplete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('multi_level', 'multi_level_Name', 'Multi Level', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for combobox field
            //
            $column = new TextViewColumn('combobox', 'combobox', 'Combobox', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for multi_value field
            //
            $column = new TextViewColumn('multi_value', 'multi_value', 'Multi Value', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for radio field
            //
            $column = new TextViewColumn('radio', 'radio', 'Radio', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for checkbox_group field
            //
            $column = new TextViewColumn('checkbox_group', 'checkbox_group', 'Checkbox Group', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for checkbox field
            //
            $column = new CheckboxViewColumn('checkbox', 'checkbox', 'Checkbox', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for datetime field
            //
            $column = new DateTimeViewColumn('datetime', 'datetime', 'Datetime', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for time field
            //
            $column = new DateTimeViewColumn('time', 'time', 'Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for text field
            //
            $column = new TextViewColumn('text', 'text', 'Text', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for masked field
            //
            $column = new TextViewColumn('masked', 'masked', 'Masked', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for range field
            //
            $column = new NumberViewColumn('range', 'range', 'Range', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for spin field
            //
            $column = new NumberViewColumn('spin', 'spin', 'Spin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for color field
            //
            $column = new TextViewColumn('color', 'color', 'Color', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for image field
            //
            $column = new TextViewColumn('image', 'image', 'Image', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for html field
            //
            $column = new TextViewColumn('html', 'html', 'Html', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Name field
            //
            $column = new TextViewColumn('autocomplete', 'autocomplete_Name', 'Autocomplete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('multi_level', 'multi_level_Name', 'Multi Level', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for combobox field
            //
            $column = new TextViewColumn('combobox', 'combobox', 'Combobox', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for multi_value field
            //
            $column = new TextViewColumn('multi_value', 'multi_value', 'Multi Value', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for radio field
            //
            $column = new TextViewColumn('radio', 'radio', 'Radio', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for checkbox_group field
            //
            $column = new TextViewColumn('checkbox_group', 'checkbox_group', 'Checkbox Group', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for checkbox field
            //
            $column = new CheckboxViewColumn('checkbox', 'checkbox', 'Checkbox', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for datetime field
            //
            $column = new DateTimeViewColumn('datetime', 'datetime', 'Datetime', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for time field
            //
            $column = new DateTimeViewColumn('time', 'time', 'Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for text field
            //
            $column = new TextViewColumn('text', 'text', 'Text', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for masked field
            //
            $column = new TextViewColumn('masked', 'masked', 'Masked', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for range field
            //
            $column = new NumberViewColumn('range', 'range', 'Range', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for spin field
            //
            $column = new NumberViewColumn('spin', 'spin', 'Spin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for color field
            //
            $column = new TextViewColumn('color', 'color', 'Color', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for image field
            //
            $column = new TextViewColumn('image', 'image', 'Image', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for html field
            //
            $column = new TextViewColumn('html', 'html', 'Html', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Name field
            //
            $column = new TextViewColumn('autocomplete', 'autocomplete_Name', 'Autocomplete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for checkbox field
            //
            $column = new CheckboxViewColumn('checkbox', 'checkbox', 'Checkbox', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for checkbox_group field
            //
            $column = new TextViewColumn('checkbox_group', 'checkbox_group', 'Checkbox Group', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for color field
            //
            $column = new TextViewColumn('color', 'color', 'Color', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for combobox field
            //
            $column = new TextViewColumn('combobox', 'combobox', 'Combobox', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for datetime field
            //
            $column = new DateTimeViewColumn('datetime', 'datetime', 'Datetime', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for html field
            //
            $column = new TextViewColumn('html', 'html', 'Html', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for image field
            //
            $column = new TextViewColumn('image', 'image', 'Image', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for masked field
            //
            $column = new TextViewColumn('masked', 'masked', 'Masked', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('multi_level', 'multi_level_Name', 'Multi Level', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for multi_value field
            //
            $column = new TextViewColumn('multi_value', 'multi_value', 'Multi Value', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for radio field
            //
            $column = new TextViewColumn('radio', 'radio', 'Radio', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for range field
            //
            $column = new NumberViewColumn('range', 'range', 'Range', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for spin field
            //
            $column = new NumberViewColumn('spin', 'spin', 'Spin', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for text field
            //
            $column = new TextViewColumn('text', 'text', 'Text', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for time field
            //
            $column = new DateTimeViewColumn('time', 'time', 'Time', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CountryCode = \'GBR\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_v_data_editing_editors_autocomplete_search', 'ID', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'image', 'v_data_editing_editors_image_handler_insert', new NullFilter());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CountryCode = \'GBR\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_v_data_editing_editors_autocomplete_search', 'ID', 'Name', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_v_data_editing_editors_multi_level_search', 'ID', 'Name', null, 20);
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CountryCode = \'GBR\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_v_data_editing_editors_autocomplete_search', 'ID', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'image', 'v_data_editing_editors_image_handler_edit', new NullFilter());
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
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), 'CountryCode = \'GBR\''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_v_data_editing_editors_autocomplete_search', 'ID', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'image', 'v_data_editing_editors_image_handler_multi_edit', new NullFilter());
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
        $Page = new v_data_editing_editorsPage("v_data_editing_editors", "data_editing_editors.php", GetCurrentUserPermissionsForPage("v_data_editing_editors"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_data_editing_editors"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
