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
    
    
    
    class phonePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Data Grid.Record Comparison');
            $this->SetMenuLabel('Record Comparison');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phone`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('model_name', true),
                    new IntegerField('release_year', true),
                    new StringField('release_month', true),
                    new IntegerField('height'),
                    new IntegerField('length'),
                    new IntegerField('width'),
                    new IntegerField('weight'),
                    new StringField('display_type'),
                    new IntegerField('display_size'),
                    new IntegerField('display_resolution_x'),
                    new IntegerField('display_resolution_y'),
                    new StringField('os_basic'),
                    new StringField('os_upgradable'),
                    new StringField('chipset'),
                    new StringField('cpu'),
                    new StringField('gpu'),
                    new IntegerField('storage_min'),
                    new IntegerField('storage_max'),
                    new IntegerField('storage_external'),
                    new IntegerField('camera_resolution'),
                    new IntegerField('camera_video_max_x'),
                    new IntegerField('camera_video_max_y'),
                    new IntegerField('java_support'),
                    new StringField('web_browser'),
                    new StringField('battery_type'),
                    new IntegerField('battery_standby_max_time'),
                    new IntegerField('battery_talk_max_time'),
                    new IntegerField('battery_music_play_max_time'),
                    new StringField('colors'),
                    new IntegerField('basemark_os_ii_2_0_value'),
                    new BlobField('photo'),
                    new StringField('photo_back'),
                    new StringField('photo_thumbnail'),
                    new StringField('photo_large')
                )
            );
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/data_grid_record_comparison.html"));
            $this->setDetailedDescription(extractMethodCode($this, "doCustomCompareColumn"));
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(10);
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
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'model_name', 'model_name', 'Model Name'),
                new FilterColumn($this->dataset, 'release_year', 'release_year', 'Release Year'),
                new FilterColumn($this->dataset, 'release_month', 'release_month', 'Release Month'),
                new FilterColumn($this->dataset, 'colors', 'colors', 'Colors'),
                new FilterColumn($this->dataset, 'height', 'height', 'Height'),
                new FilterColumn($this->dataset, 'length', 'length', 'Width'),
                new FilterColumn($this->dataset, 'width', 'width', 'Depth'),
                new FilterColumn($this->dataset, 'weight', 'weight', 'Weight'),
                new FilterColumn($this->dataset, 'display_type', 'display_type', 'Display Type'),
                new FilterColumn($this->dataset, 'display_size', 'display_size', 'Display Size'),
                new FilterColumn($this->dataset, 'display_resolution_x', 'display_resolution_x', 'Display Resolution X'),
                new FilterColumn($this->dataset, 'display_resolution_y', 'display_resolution_y', 'Display Resolution Y'),
                new FilterColumn($this->dataset, 'os_basic', 'os_basic', 'OS Basic'),
                new FilterColumn($this->dataset, 'os_upgradable', 'os_upgradable', 'OS Upgradable'),
                new FilterColumn($this->dataset, 'chipset', 'chipset', 'Chipset'),
                new FilterColumn($this->dataset, 'cpu', 'cpu', 'Cpu'),
                new FilterColumn($this->dataset, 'gpu', 'gpu', 'Gpu'),
                new FilterColumn($this->dataset, 'storage_min', 'storage_min', 'Storage Min'),
                new FilterColumn($this->dataset, 'storage_max', 'storage_max', 'Storage Max'),
                new FilterColumn($this->dataset, 'storage_external', 'storage_external', 'Storage External'),
                new FilterColumn($this->dataset, 'camera_resolution', 'camera_resolution', 'Camera Resolution'),
                new FilterColumn($this->dataset, 'camera_video_max_x', 'camera_video_max_x', 'Camera Video Max X'),
                new FilterColumn($this->dataset, 'camera_video_max_y', 'camera_video_max_y', 'Camera Video Max Y'),
                new FilterColumn($this->dataset, 'java_support', 'java_support', 'Java Support'),
                new FilterColumn($this->dataset, 'web_browser', 'web_browser', 'Web Browser'),
                new FilterColumn($this->dataset, 'battery_type', 'battery_type', 'Battery Type'),
                new FilterColumn($this->dataset, 'battery_standby_max_time', 'battery_standby_max_time', 'Battery Standby Max Time'),
                new FilterColumn($this->dataset, 'battery_talk_max_time', 'battery_talk_max_time', 'Battery Talk Max Time'),
                new FilterColumn($this->dataset, 'battery_music_play_max_time', 'battery_music_play_max_time', 'Battery Music Play Max Time'),
                new FilterColumn($this->dataset, 'basemark_os_ii_2_0_value', 'basemark_os_ii_2_0_value', 'Basemark OS II 2.0 Value'),
                new FilterColumn($this->dataset, 'photo', 'photo', 'Photo'),
                new FilterColumn($this->dataset, 'photo_back', 'photo_back', 'Photo Back'),
                new FilterColumn($this->dataset, 'photo_thumbnail', 'photo_thumbnail', 'Photo Thumbnail'),
                new FilterColumn($this->dataset, 'photo_large', 'photo_large', 'Photo')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['model_name'])
                ->addColumn($columns['release_year'])
                ->addColumn($columns['release_month'])
                ->addColumn($columns['colors'])
                ->addColumn($columns['height'])
                ->addColumn($columns['length'])
                ->addColumn($columns['width'])
                ->addColumn($columns['weight'])
                ->addColumn($columns['display_type'])
                ->addColumn($columns['display_size'])
                ->addColumn($columns['display_resolution_x'])
                ->addColumn($columns['display_resolution_y'])
                ->addColumn($columns['os_basic'])
                ->addColumn($columns['os_upgradable'])
                ->addColumn($columns['chipset'])
                ->addColumn($columns['cpu'])
                ->addColumn($columns['gpu'])
                ->addColumn($columns['storage_min'])
                ->addColumn($columns['storage_max'])
                ->addColumn($columns['storage_external'])
                ->addColumn($columns['camera_resolution'])
                ->addColumn($columns['camera_video_max_x'])
                ->addColumn($columns['camera_video_max_y'])
                ->addColumn($columns['java_support'])
                ->addColumn($columns['web_browser'])
                ->addColumn($columns['battery_type'])
                ->addColumn($columns['battery_standby_max_time'])
                ->addColumn($columns['battery_talk_max_time'])
                ->addColumn($columns['battery_music_play_max_time'])
                ->addColumn($columns['photo_large']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('release_year');
            
            $columnFilter
                ->setOrderFor('release_year', 'DESC');
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
            
            $main_editor = new TextEdit('model_name_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['model_name'],
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
            
            $main_editor = new TextEdit('release_year_edit');
            
            $filterBuilder->addColumn(
                $columns['release_year'],
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
            
            $main_editor = new ComboBox('release_month_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('January', 'January');
            $main_editor->addChoice('February', 'February');
            $main_editor->addChoice('March', 'March');
            $main_editor->addChoice('April', 'April');
            $main_editor->addChoice('May', 'May');
            $main_editor->addChoice('June', 'June');
            $main_editor->addChoice('July', 'July');
            $main_editor->addChoice('August', 'August');
            $main_editor->addChoice('September', 'September');
            $main_editor->addChoice('October', 'October');
            $main_editor->addChoice('November', 'November');
            $main_editor->addChoice('December', 'December');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('release_month');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('release_month');
            
            $filterBuilder->addColumn(
                $columns['release_month'],
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
            
            $main_editor = new MultiValueSelect('colors_edit');
            $main_editor->addChoice('Black', 'Black');
            $main_editor->addChoice('Blue', 'Blue');
            $main_editor->addChoice('Coral', 'Coral');
            $main_editor->addChoice('Gold', 'Gold');
            $main_editor->addChoice('Green', 'Green');
            $main_editor->addChoice('Jet Black', 'Jet Black');
            $main_editor->addChoice('Midnight Green', 'Midnight Green');
            $main_editor->addChoice('Purple', 'Purple');
            $main_editor->addChoice('Red', 'Red');
            $main_editor->addChoice('Rose Gold', 'Rose Gold');
            $main_editor->addChoice('Silver', 'Silver');
            $main_editor->addChoice('Space Gray', 'Space Gray');
            $main_editor->addChoice('Yellow', 'Yellow');
            $main_editor->addChoice('White', 'White');
            $main_editor->addChoice('Graphite', 'Graphite');
            $main_editor->addChoice('Pacific Blue', 'Pacific Blue');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('colors');
            
            $filterBuilder->addColumn(
                $columns['colors'],
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
            
            $main_editor = new TextEdit('height_edit');
            $main_editor->SetSuffix('mm');
            
            $filterBuilder->addColumn(
                $columns['height'],
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
            
            $main_editor = new TextEdit('length_edit');
            $main_editor->SetSuffix('mm');
            
            $filterBuilder->addColumn(
                $columns['length'],
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
            
            $main_editor = new TextEdit('width_edit');
            $main_editor->SetSuffix('mm');
            
            $filterBuilder->addColumn(
                $columns['width'],
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
            
            $main_editor = new TextEdit('weight_edit');
            $main_editor->SetSuffix('g');
            
            $filterBuilder->addColumn(
                $columns['weight'],
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
            
            $main_editor = new TextEdit('display_type_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['display_type'],
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
            
            $main_editor = new TextEdit('display_size_edit');
            $main_editor->SetSuffix('in');
            
            $filterBuilder->addColumn(
                $columns['display_size'],
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
            
            $main_editor = new TextEdit('display_resolution_x_edit');
            $main_editor->SetSuffix('px');
            
            $filterBuilder->addColumn(
                $columns['display_resolution_x'],
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
            
            $main_editor = new TextEdit('display_resolution_y_edit');
            $main_editor->SetSuffix('px');
            
            $filterBuilder->addColumn(
                $columns['display_resolution_y'],
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
            
            $main_editor = new TextEdit('os_basic_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['os_basic'],
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
            
            $main_editor = new TextEdit('os_upgradable_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['os_upgradable'],
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
            
            $main_editor = new TextEdit('chipset_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['chipset'],
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
            
            $main_editor = new TextEdit('cpu_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['cpu'],
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
            
            $main_editor = new TextEdit('gpu_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['gpu'],
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
            
            $main_editor = new TextEdit('storage_min_edit');
            
            $filterBuilder->addColumn(
                $columns['storage_min'],
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
            
            $main_editor = new TextEdit('storage_max_edit');
            
            $filterBuilder->addColumn(
                $columns['storage_max'],
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
            
            $main_editor = new TextEdit('storage_external_edit');
            
            $filterBuilder->addColumn(
                $columns['storage_external'],
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
            
            $main_editor = new TextEdit('camera_resolution_edit');
            
            $filterBuilder->addColumn(
                $columns['camera_resolution'],
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
            
            $main_editor = new TextEdit('camera_video_max_x_edit');
            
            $filterBuilder->addColumn(
                $columns['camera_video_max_x'],
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
            
            $main_editor = new TextEdit('camera_video_max_y_edit');
            
            $filterBuilder->addColumn(
                $columns['camera_video_max_y'],
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
            
            $main_editor = new TextEdit('java_support_edit');
            
            $filterBuilder->addColumn(
                $columns['java_support'],
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
            
            $main_editor = new TextEdit('web_browser_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['web_browser'],
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
            
            $main_editor = new TextEdit('battery_type_edit');
            $main_editor->SetMaxLength(30);
            
            $filterBuilder->addColumn(
                $columns['battery_type'],
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
            
            $main_editor = new TextEdit('battery_standby_max_time_edit');
            
            $filterBuilder->addColumn(
                $columns['battery_standby_max_time'],
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
            
            $main_editor = new TextEdit('battery_talk_max_time_edit');
            
            $filterBuilder->addColumn(
                $columns['battery_talk_max_time'],
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
            
            $main_editor = new TextEdit('battery_music_play_max_time_edit');
            
            $filterBuilder->addColumn(
                $columns['battery_music_play_max_time'],
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
            
            $main_editor = new TextEdit('photo_large');
            
            $filterBuilder->addColumn(
                $columns['photo_large'],
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
            // View column for model_name field
            //
            $column = new TextViewColumn('model_name', 'model_name', 'Model Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for release_year field
            //
            $column = new NumberViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for release_month field
            //
            $column = new TextViewColumn('release_month', 'release_month', 'Release Month', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for display_size field
            //
            $column = new NumberViewColumn('display_size', 'display_size', 'Display Size', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(1);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 150px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
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
            // View column for model_name field
            //
            $column = new TextViewColumn('model_name', 'model_name', 'Model Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for release_year field
            //
            $column = new NumberViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for release_month field
            //
            $column = new TextViewColumn('release_month', 'release_month', 'Release Month', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for height field
            //
            $column = new NumberViewColumn('height', 'height', 'Height', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for length field
            //
            $column = new NumberViewColumn('length', 'length', 'Width', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for width field
            //
            $column = new NumberViewColumn('width', 'width', 'Depth', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for weight field
            //
            $column = new NumberViewColumn('weight', 'weight', 'Weight', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for display_type field
            //
            $column = new TextViewColumn('display_type', 'display_type', 'Display Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for display_size field
            //
            $column = new NumberViewColumn('display_size', 'display_size', 'Display Size', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(1);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for display_resolution_x field
            //
            $column = new NumberViewColumn('display_resolution_x', 'display_resolution_x', 'Display Resolution X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for display_resolution_y field
            //
            $column = new NumberViewColumn('display_resolution_y', 'display_resolution_y', 'Display Resolution Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for os_basic field
            //
            $column = new TextViewColumn('os_basic', 'os_basic', 'OS Basic', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for os_upgradable field
            //
            $column = new TextViewColumn('os_upgradable', 'os_upgradable', 'OS Upgradable', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for chipset field
            //
            $column = new TextViewColumn('chipset', 'chipset', 'Chipset', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cpu field
            //
            $column = new TextViewColumn('cpu', 'cpu', 'Cpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for gpu field
            //
            $column = new TextViewColumn('gpu', 'gpu', 'Gpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for storage_min field
            //
            $column = new NumberViewColumn('storage_min', 'storage_min', 'Storage Min', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for storage_max field
            //
            $column = new NumberViewColumn('storage_max', 'storage_max', 'Storage Max', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for storage_external field
            //
            $column = new NumberViewColumn('storage_external', 'storage_external', 'Storage External', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for camera_resolution field
            //
            $column = new NumberViewColumn('camera_resolution', 'camera_resolution', 'Camera Resolution', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for camera_video_max_x field
            //
            $column = new NumberViewColumn('camera_video_max_x', 'camera_video_max_x', 'Camera Video Max X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for camera_video_max_y field
            //
            $column = new NumberViewColumn('camera_video_max_y', 'camera_video_max_y', 'Camera Video Max Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for java_support field
            //
            $column = new CheckboxViewColumn('java_support', 'java_support', 'Java Support', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for web_browser field
            //
            $column = new TextViewColumn('web_browser', 'web_browser', 'Web Browser', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for battery_type field
            //
            $column = new TextViewColumn('battery_type', 'battery_type', 'Battery Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for battery_standby_max_time field
            //
            $column = new NumberViewColumn('battery_standby_max_time', 'battery_standby_max_time', 'Battery Standby Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for battery_talk_max_time field
            //
            $column = new NumberViewColumn('battery_talk_max_time', 'battery_talk_max_time', 'Battery Talk Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for battery_music_play_max_time field
            //
            $column = new NumberViewColumn('battery_music_play_max_time', 'battery_music_play_max_time', 'Battery Music Play Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 150px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for model_name field
            //
            $editor = new TextEdit('model_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Model Name', 'model_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for release_year field
            //
            $editor = new TextEdit('release_year_edit');
            $editColumn = new CustomEditColumn('Release Year', 'release_year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for release_month field
            //
            $editor = new ComboBox('release_month_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('January', 'January');
            $editor->addChoice('February', 'February');
            $editor->addChoice('March', 'March');
            $editor->addChoice('April', 'April');
            $editor->addChoice('May', 'May');
            $editor->addChoice('June', 'June');
            $editor->addChoice('July', 'July');
            $editor->addChoice('August', 'August');
            $editor->addChoice('September', 'September');
            $editor->addChoice('October', 'October');
            $editor->addChoice('November', 'November');
            $editor->addChoice('December', 'December');
            $editColumn = new CustomEditColumn('Release Month', 'release_month', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for colors field
            //
            $editor = new MultiValueSelect('colors_edit');
            $editor->addChoice('Black', 'Black');
            $editor->addChoice('Blue', 'Blue');
            $editor->addChoice('Coral', 'Coral');
            $editor->addChoice('Gold', 'Gold');
            $editor->addChoice('Green', 'Green');
            $editor->addChoice('Jet Black', 'Jet Black');
            $editor->addChoice('Midnight Green', 'Midnight Green');
            $editor->addChoice('Purple', 'Purple');
            $editor->addChoice('Red', 'Red');
            $editor->addChoice('Rose Gold', 'Rose Gold');
            $editor->addChoice('Silver', 'Silver');
            $editor->addChoice('Space Gray', 'Space Gray');
            $editor->addChoice('Yellow', 'Yellow');
            $editor->addChoice('White', 'White');
            $editor->addChoice('Graphite', 'Graphite');
            $editor->addChoice('Pacific Blue', 'Pacific Blue');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Colors', 'colors', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for height field
            //
            $editor = new TextEdit('height_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Height', 'height', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for length field
            //
            $editor = new TextEdit('length_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Width', 'length', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for width field
            //
            $editor = new TextEdit('width_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Depth', 'width', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for weight field
            //
            $editor = new TextEdit('weight_edit');
            $editor->SetSuffix('g');
            $editColumn = new CustomEditColumn('Weight', 'weight', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for display_type field
            //
            $editor = new TextEdit('display_type_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Display Type', 'display_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for display_size field
            //
            $editor = new TextEdit('display_size_edit');
            $editor->SetSuffix('in');
            $editColumn = new CustomEditColumn('Display Size', 'display_size', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for display_resolution_x field
            //
            $editor = new TextEdit('display_resolution_x_edit');
            $editor->SetSuffix('px');
            $editColumn = new CustomEditColumn('Display Resolution X', 'display_resolution_x', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for display_resolution_y field
            //
            $editor = new TextEdit('display_resolution_y_edit');
            $editor->SetSuffix('px');
            $editColumn = new CustomEditColumn('Display Resolution Y', 'display_resolution_y', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for os_basic field
            //
            $editor = new TextEdit('os_basic_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('OS Basic', 'os_basic', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for os_upgradable field
            //
            $editor = new TextEdit('os_upgradable_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('OS Upgradable', 'os_upgradable', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for chipset field
            //
            $editor = new TextEdit('chipset_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Chipset', 'chipset', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cpu field
            //
            $editor = new TextEdit('cpu_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Cpu', 'cpu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for gpu field
            //
            $editor = new TextEdit('gpu_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Gpu', 'gpu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for storage_min field
            //
            $editor = new TextEdit('storage_min_edit');
            $editColumn = new CustomEditColumn('Storage Min', 'storage_min', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for storage_max field
            //
            $editor = new TextEdit('storage_max_edit');
            $editColumn = new CustomEditColumn('Storage Max', 'storage_max', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for storage_external field
            //
            $editor = new TextEdit('storage_external_edit');
            $editColumn = new CustomEditColumn('Storage External', 'storage_external', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for camera_resolution field
            //
            $editor = new TextEdit('camera_resolution_edit');
            $editColumn = new CustomEditColumn('Camera Resolution', 'camera_resolution', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for camera_video_max_x field
            //
            $editor = new TextEdit('camera_video_max_x_edit');
            $editColumn = new CustomEditColumn('Camera Video Max X', 'camera_video_max_x', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for camera_video_max_y field
            //
            $editor = new TextEdit('camera_video_max_y_edit');
            $editColumn = new CustomEditColumn('Camera Video Max Y', 'camera_video_max_y', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for java_support field
            //
            $editor = new TextEdit('java_support_edit');
            $editColumn = new CustomEditColumn('Java Support', 'java_support', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for web_browser field
            //
            $editor = new TextEdit('web_browser_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Web Browser', 'web_browser', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for battery_type field
            //
            $editor = new TextEdit('battery_type_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Battery Type', 'battery_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for battery_standby_max_time field
            //
            $editor = new TextEdit('battery_standby_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Standby Max Time', 'battery_standby_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for battery_talk_max_time field
            //
            $editor = new TextEdit('battery_talk_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Talk Max Time', 'battery_talk_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for battery_music_play_max_time field
            //
            $editor = new TextEdit('battery_music_play_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Music Play Max Time', 'battery_music_play_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for photo_large field
            //
            $editor = new ImageUploader('photo_large_edit');
            $editor->setInlineStyles('max-width: 200px;');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new UploadFileToFolderColumn('Photo', 'photo_large', $editor, $this->dataset, false, false, 'external_data/images/phone/iphone_large', '%original_file_name%', $this->OnFileUpload, true);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for model_name field
            //
            $editor = new TextEdit('model_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Model Name', 'model_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for release_year field
            //
            $editor = new TextEdit('release_year_edit');
            $editColumn = new CustomEditColumn('Release Year', 'release_year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for release_month field
            //
            $editor = new ComboBox('release_month_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('January', 'January');
            $editor->addChoice('February', 'February');
            $editor->addChoice('March', 'March');
            $editor->addChoice('April', 'April');
            $editor->addChoice('May', 'May');
            $editor->addChoice('June', 'June');
            $editor->addChoice('July', 'July');
            $editor->addChoice('August', 'August');
            $editor->addChoice('September', 'September');
            $editor->addChoice('October', 'October');
            $editor->addChoice('November', 'November');
            $editor->addChoice('December', 'December');
            $editColumn = new CustomEditColumn('Release Month', 'release_month', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for colors field
            //
            $editor = new MultiValueSelect('colors_edit');
            $editor->addChoice('Black', 'Black');
            $editor->addChoice('Blue', 'Blue');
            $editor->addChoice('Coral', 'Coral');
            $editor->addChoice('Gold', 'Gold');
            $editor->addChoice('Green', 'Green');
            $editor->addChoice('Jet Black', 'Jet Black');
            $editor->addChoice('Midnight Green', 'Midnight Green');
            $editor->addChoice('Purple', 'Purple');
            $editor->addChoice('Red', 'Red');
            $editor->addChoice('Rose Gold', 'Rose Gold');
            $editor->addChoice('Silver', 'Silver');
            $editor->addChoice('Space Gray', 'Space Gray');
            $editor->addChoice('Yellow', 'Yellow');
            $editor->addChoice('White', 'White');
            $editor->addChoice('Graphite', 'Graphite');
            $editor->addChoice('Pacific Blue', 'Pacific Blue');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Colors', 'colors', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for height field
            //
            $editor = new TextEdit('height_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Height', 'height', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for length field
            //
            $editor = new TextEdit('length_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Width', 'length', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for width field
            //
            $editor = new TextEdit('width_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Depth', 'width', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for weight field
            //
            $editor = new TextEdit('weight_edit');
            $editor->SetSuffix('g');
            $editColumn = new CustomEditColumn('Weight', 'weight', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for display_type field
            //
            $editor = new TextEdit('display_type_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Display Type', 'display_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for display_size field
            //
            $editor = new TextEdit('display_size_edit');
            $editor->SetSuffix('in');
            $editColumn = new CustomEditColumn('Display Size', 'display_size', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for display_resolution_x field
            //
            $editor = new TextEdit('display_resolution_x_edit');
            $editor->SetSuffix('px');
            $editColumn = new CustomEditColumn('Display Resolution X', 'display_resolution_x', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for display_resolution_y field
            //
            $editor = new TextEdit('display_resolution_y_edit');
            $editor->SetSuffix('px');
            $editColumn = new CustomEditColumn('Display Resolution Y', 'display_resolution_y', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for os_basic field
            //
            $editor = new TextEdit('os_basic_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('OS Basic', 'os_basic', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for os_upgradable field
            //
            $editor = new TextEdit('os_upgradable_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('OS Upgradable', 'os_upgradable', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for chipset field
            //
            $editor = new TextEdit('chipset_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Chipset', 'chipset', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cpu field
            //
            $editor = new TextEdit('cpu_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Cpu', 'cpu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for gpu field
            //
            $editor = new TextEdit('gpu_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Gpu', 'gpu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for storage_min field
            //
            $editor = new TextEdit('storage_min_edit');
            $editColumn = new CustomEditColumn('Storage Min', 'storage_min', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for storage_max field
            //
            $editor = new TextEdit('storage_max_edit');
            $editColumn = new CustomEditColumn('Storage Max', 'storage_max', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for storage_external field
            //
            $editor = new TextEdit('storage_external_edit');
            $editColumn = new CustomEditColumn('Storage External', 'storage_external', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for camera_resolution field
            //
            $editor = new TextEdit('camera_resolution_edit');
            $editColumn = new CustomEditColumn('Camera Resolution', 'camera_resolution', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for camera_video_max_x field
            //
            $editor = new TextEdit('camera_video_max_x_edit');
            $editColumn = new CustomEditColumn('Camera Video Max X', 'camera_video_max_x', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for camera_video_max_y field
            //
            $editor = new TextEdit('camera_video_max_y_edit');
            $editColumn = new CustomEditColumn('Camera Video Max Y', 'camera_video_max_y', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for java_support field
            //
            $editor = new TextEdit('java_support_edit');
            $editColumn = new CustomEditColumn('Java Support', 'java_support', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for web_browser field
            //
            $editor = new TextEdit('web_browser_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Web Browser', 'web_browser', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for battery_type field
            //
            $editor = new TextEdit('battery_type_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Battery Type', 'battery_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for battery_standby_max_time field
            //
            $editor = new TextEdit('battery_standby_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Standby Max Time', 'battery_standby_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for battery_talk_max_time field
            //
            $editor = new TextEdit('battery_talk_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Talk Max Time', 'battery_talk_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for battery_music_play_max_time field
            //
            $editor = new TextEdit('battery_music_play_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Music Play Max Time', 'battery_music_play_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for photo_large field
            //
            $editor = new ImageUploader('photo_large_edit');
            $editor->setInlineStyles('max-width: 200px;');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new UploadFileToFolderColumn('Photo', 'photo_large', $editor, $this->dataset, false, false, 'external_data/images/phone/iphone_large', '%original_file_name%', $this->OnFileUpload, true);
            $editColumn->SetReplaceUploadedFileIfExist(true);
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
            // Edit column for model_name field
            //
            $editor = new TextEdit('model_name_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Model Name', 'model_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for release_year field
            //
            $editor = new TextEdit('release_year_edit');
            $editColumn = new CustomEditColumn('Release Year', 'release_year', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for release_month field
            //
            $editor = new ComboBox('release_month_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('January', 'January');
            $editor->addChoice('February', 'February');
            $editor->addChoice('March', 'March');
            $editor->addChoice('April', 'April');
            $editor->addChoice('May', 'May');
            $editor->addChoice('June', 'June');
            $editor->addChoice('July', 'July');
            $editor->addChoice('August', 'August');
            $editor->addChoice('September', 'September');
            $editor->addChoice('October', 'October');
            $editor->addChoice('November', 'November');
            $editor->addChoice('December', 'December');
            $editColumn = new CustomEditColumn('Release Month', 'release_month', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for colors field
            //
            $editor = new MultiValueSelect('colors_edit');
            $editor->addChoice('Black', 'Black');
            $editor->addChoice('Blue', 'Blue');
            $editor->addChoice('Coral', 'Coral');
            $editor->addChoice('Gold', 'Gold');
            $editor->addChoice('Green', 'Green');
            $editor->addChoice('Jet Black', 'Jet Black');
            $editor->addChoice('Midnight Green', 'Midnight Green');
            $editor->addChoice('Purple', 'Purple');
            $editor->addChoice('Red', 'Red');
            $editor->addChoice('Rose Gold', 'Rose Gold');
            $editor->addChoice('Silver', 'Silver');
            $editor->addChoice('Space Gray', 'Space Gray');
            $editor->addChoice('Yellow', 'Yellow');
            $editor->addChoice('White', 'White');
            $editor->addChoice('Graphite', 'Graphite');
            $editor->addChoice('Pacific Blue', 'Pacific Blue');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Colors', 'colors', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for height field
            //
            $editor = new TextEdit('height_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Height', 'height', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for length field
            //
            $editor = new TextEdit('length_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Width', 'length', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for width field
            //
            $editor = new TextEdit('width_edit');
            $editor->SetSuffix('mm');
            $editColumn = new CustomEditColumn('Depth', 'width', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for weight field
            //
            $editor = new TextEdit('weight_edit');
            $editor->SetSuffix('g');
            $editColumn = new CustomEditColumn('Weight', 'weight', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for display_type field
            //
            $editor = new TextEdit('display_type_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Display Type', 'display_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for display_size field
            //
            $editor = new TextEdit('display_size_edit');
            $editor->SetSuffix('in');
            $editColumn = new CustomEditColumn('Display Size', 'display_size', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for display_resolution_x field
            //
            $editor = new TextEdit('display_resolution_x_edit');
            $editor->SetSuffix('px');
            $editColumn = new CustomEditColumn('Display Resolution X', 'display_resolution_x', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for display_resolution_y field
            //
            $editor = new TextEdit('display_resolution_y_edit');
            $editor->SetSuffix('px');
            $editColumn = new CustomEditColumn('Display Resolution Y', 'display_resolution_y', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for os_basic field
            //
            $editor = new TextEdit('os_basic_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('OS Basic', 'os_basic', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for os_upgradable field
            //
            $editor = new TextEdit('os_upgradable_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('OS Upgradable', 'os_upgradable', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for chipset field
            //
            $editor = new TextEdit('chipset_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Chipset', 'chipset', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cpu field
            //
            $editor = new TextEdit('cpu_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Cpu', 'cpu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for gpu field
            //
            $editor = new TextEdit('gpu_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Gpu', 'gpu', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for storage_min field
            //
            $editor = new TextEdit('storage_min_edit');
            $editColumn = new CustomEditColumn('Storage Min', 'storage_min', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for storage_max field
            //
            $editor = new TextEdit('storage_max_edit');
            $editColumn = new CustomEditColumn('Storage Max', 'storage_max', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for storage_external field
            //
            $editor = new TextEdit('storage_external_edit');
            $editColumn = new CustomEditColumn('Storage External', 'storage_external', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for camera_resolution field
            //
            $editor = new TextEdit('camera_resolution_edit');
            $editColumn = new CustomEditColumn('Camera Resolution', 'camera_resolution', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for camera_video_max_x field
            //
            $editor = new TextEdit('camera_video_max_x_edit');
            $editColumn = new CustomEditColumn('Camera Video Max X', 'camera_video_max_x', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for camera_video_max_y field
            //
            $editor = new TextEdit('camera_video_max_y_edit');
            $editColumn = new CustomEditColumn('Camera Video Max Y', 'camera_video_max_y', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for java_support field
            //
            $editor = new TextEdit('java_support_edit');
            $editColumn = new CustomEditColumn('Java Support', 'java_support', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for web_browser field
            //
            $editor = new TextEdit('web_browser_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Web Browser', 'web_browser', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for battery_type field
            //
            $editor = new TextEdit('battery_type_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Battery Type', 'battery_type', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for battery_standby_max_time field
            //
            $editor = new TextEdit('battery_standby_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Standby Max Time', 'battery_standby_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for battery_talk_max_time field
            //
            $editor = new TextEdit('battery_talk_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Talk Max Time', 'battery_talk_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for battery_music_play_max_time field
            //
            $editor = new TextEdit('battery_music_play_max_time_edit');
            $editColumn = new CustomEditColumn('Battery Music Play Max Time', 'battery_music_play_max_time', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for photo_large field
            //
            $editor = new ImageUploader('photo_large_edit');
            $editor->setInlineStyles('max-width: 200px;');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new UploadFileToFolderColumn('Photo', 'photo_large', $editor, $this->dataset, false, false, 'external_data/images/phone/iphone_large', '%original_file_name%', $this->OnFileUpload, true);
            $editColumn->SetReplaceUploadedFileIfExist(true);
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
            // View column for model_name field
            //
            $column = new TextViewColumn('model_name', 'model_name', 'Model Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for release_year field
            //
            $column = new NumberViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for release_month field
            //
            $column = new TextViewColumn('release_month', 'release_month', 'Release Month', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for height field
            //
            $column = new NumberViewColumn('height', 'height', 'Height', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for length field
            //
            $column = new NumberViewColumn('length', 'length', 'Width', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for width field
            //
            $column = new NumberViewColumn('width', 'width', 'Depth', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for weight field
            //
            $column = new NumberViewColumn('weight', 'weight', 'Weight', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for display_type field
            //
            $column = new TextViewColumn('display_type', 'display_type', 'Display Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for display_size field
            //
            $column = new NumberViewColumn('display_size', 'display_size', 'Display Size', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(1);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for display_resolution_x field
            //
            $column = new NumberViewColumn('display_resolution_x', 'display_resolution_x', 'Display Resolution X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for display_resolution_y field
            //
            $column = new NumberViewColumn('display_resolution_y', 'display_resolution_y', 'Display Resolution Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for os_basic field
            //
            $column = new TextViewColumn('os_basic', 'os_basic', 'OS Basic', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for os_upgradable field
            //
            $column = new TextViewColumn('os_upgradable', 'os_upgradable', 'OS Upgradable', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for chipset field
            //
            $column = new TextViewColumn('chipset', 'chipset', 'Chipset', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cpu field
            //
            $column = new TextViewColumn('cpu', 'cpu', 'Cpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for gpu field
            //
            $column = new TextViewColumn('gpu', 'gpu', 'Gpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for storage_min field
            //
            $column = new NumberViewColumn('storage_min', 'storage_min', 'Storage Min', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for storage_max field
            //
            $column = new NumberViewColumn('storage_max', 'storage_max', 'Storage Max', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for storage_external field
            //
            $column = new NumberViewColumn('storage_external', 'storage_external', 'Storage External', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for camera_resolution field
            //
            $column = new NumberViewColumn('camera_resolution', 'camera_resolution', 'Camera Resolution', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for camera_video_max_x field
            //
            $column = new NumberViewColumn('camera_video_max_x', 'camera_video_max_x', 'Camera Video Max X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for camera_video_max_y field
            //
            $column = new NumberViewColumn('camera_video_max_y', 'camera_video_max_y', 'Camera Video Max Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for java_support field
            //
            $column = new CheckboxViewColumn('java_support', 'java_support', 'Java Support', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for web_browser field
            //
            $column = new TextViewColumn('web_browser', 'web_browser', 'Web Browser', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for battery_type field
            //
            $column = new TextViewColumn('battery_type', 'battery_type', 'Battery Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for battery_standby_max_time field
            //
            $column = new NumberViewColumn('battery_standby_max_time', 'battery_standby_max_time', 'Battery Standby Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for battery_talk_max_time field
            //
            $column = new NumberViewColumn('battery_talk_max_time', 'battery_talk_max_time', 'Battery Talk Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for battery_music_play_max_time field
            //
            $column = new NumberViewColumn('battery_music_play_max_time', 'battery_music_play_max_time', 'Battery Music Play Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 150px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
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
            // View column for model_name field
            //
            $column = new TextViewColumn('model_name', 'model_name', 'Model Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for release_year field
            //
            $column = new NumberViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for release_month field
            //
            $column = new TextViewColumn('release_month', 'release_month', 'Release Month', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for height field
            //
            $column = new NumberViewColumn('height', 'height', 'Height', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for length field
            //
            $column = new NumberViewColumn('length', 'length', 'Width', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for width field
            //
            $column = new NumberViewColumn('width', 'width', 'Depth', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for weight field
            //
            $column = new NumberViewColumn('weight', 'weight', 'Weight', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for display_type field
            //
            $column = new TextViewColumn('display_type', 'display_type', 'Display Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for display_size field
            //
            $column = new NumberViewColumn('display_size', 'display_size', 'Display Size', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(1);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for display_resolution_x field
            //
            $column = new NumberViewColumn('display_resolution_x', 'display_resolution_x', 'Display Resolution X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for display_resolution_y field
            //
            $column = new NumberViewColumn('display_resolution_y', 'display_resolution_y', 'Display Resolution Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for os_basic field
            //
            $column = new TextViewColumn('os_basic', 'os_basic', 'OS Basic', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for os_upgradable field
            //
            $column = new TextViewColumn('os_upgradable', 'os_upgradable', 'OS Upgradable', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for chipset field
            //
            $column = new TextViewColumn('chipset', 'chipset', 'Chipset', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cpu field
            //
            $column = new TextViewColumn('cpu', 'cpu', 'Cpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for gpu field
            //
            $column = new TextViewColumn('gpu', 'gpu', 'Gpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for storage_min field
            //
            $column = new NumberViewColumn('storage_min', 'storage_min', 'Storage Min', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for storage_max field
            //
            $column = new NumberViewColumn('storage_max', 'storage_max', 'Storage Max', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for storage_external field
            //
            $column = new NumberViewColumn('storage_external', 'storage_external', 'Storage External', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for camera_resolution field
            //
            $column = new NumberViewColumn('camera_resolution', 'camera_resolution', 'Camera Resolution', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for camera_video_max_x field
            //
            $column = new NumberViewColumn('camera_video_max_x', 'camera_video_max_x', 'Camera Video Max X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for camera_video_max_y field
            //
            $column = new NumberViewColumn('camera_video_max_y', 'camera_video_max_y', 'Camera Video Max Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for java_support field
            //
            $column = new CheckboxViewColumn('java_support', 'java_support', 'Java Support', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for web_browser field
            //
            $column = new TextViewColumn('web_browser', 'web_browser', 'Web Browser', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for battery_type field
            //
            $column = new TextViewColumn('battery_type', 'battery_type', 'Battery Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for battery_standby_max_time field
            //
            $column = new NumberViewColumn('battery_standby_max_time', 'battery_standby_max_time', 'Battery Standby Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for battery_talk_max_time field
            //
            $column = new NumberViewColumn('battery_talk_max_time', 'battery_talk_max_time', 'Battery Talk Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for battery_music_play_max_time field
            //
            $column = new NumberViewColumn('battery_music_play_max_time', 'battery_music_play_max_time', 'Battery Music Play Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 150px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for release_year field
            //
            $column = new NumberViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for release_month field
            //
            $column = new TextViewColumn('release_month', 'release_month', 'Release Month', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for height field
            //
            $column = new NumberViewColumn('height', 'height', 'Height', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for length field
            //
            $column = new NumberViewColumn('length', 'length', 'Width', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for width field
            //
            $column = new NumberViewColumn('width', 'width', 'Depth', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for weight field
            //
            $column = new NumberViewColumn('weight', 'weight', 'Weight', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for display_type field
            //
            $column = new TextViewColumn('display_type', 'display_type', 'Display Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for display_size field
            //
            $column = new NumberViewColumn('display_size', 'display_size', 'Display Size', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(1);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for display_resolution_x field
            //
            $column = new NumberViewColumn('display_resolution_x', 'display_resolution_x', 'Display Resolution X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for display_resolution_y field
            //
            $column = new NumberViewColumn('display_resolution_y', 'display_resolution_y', 'Display Resolution Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for os_basic field
            //
            $column = new TextViewColumn('os_basic', 'os_basic', 'Os Basic', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for os_upgradable field
            //
            $column = new TextViewColumn('os_upgradable', 'os_upgradable', 'Os Upgradable', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for chipset field
            //
            $column = new TextViewColumn('chipset', 'chipset', 'Chipset', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for cpu field
            //
            $column = new TextViewColumn('cpu', 'cpu', 'Cpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for gpu field
            //
            $column = new TextViewColumn('gpu', 'gpu', 'Gpu', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for storage_min field
            //
            $column = new NumberViewColumn('storage_min', 'storage_min', 'Storage Min', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for storage_max field
            //
            $column = new NumberViewColumn('storage_max', 'storage_max', 'Storage Max', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for storage_external field
            //
            $column = new NumberViewColumn('storage_external', 'storage_external', 'Storage External', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for camera_resolution field
            //
            $column = new NumberViewColumn('camera_resolution', 'camera_resolution', 'Camera Resolution', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for camera_video_max_x field
            //
            $column = new NumberViewColumn('camera_video_max_x', 'camera_video_max_x', 'Camera Video Max X', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for camera_video_max_y field
            //
            $column = new NumberViewColumn('camera_video_max_y', 'camera_video_max_y', 'Camera Video Max Y', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for java_support field
            //
            $column = new CheckboxViewColumn('java_support', 'java_support', 'Java Support', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for web_browser field
            //
            $column = new TextViewColumn('web_browser', 'web_browser', 'Web Browser', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for battery_type field
            //
            $column = new TextViewColumn('battery_type', 'battery_type', 'Battery Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for battery_standby_max_time field
            //
            $column = new NumberViewColumn('battery_standby_max_time', 'battery_standby_max_time', 'Battery Standby Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for battery_talk_max_time field
            //
            $column = new NumberViewColumn('battery_talk_max_time', 'battery_talk_max_time', 'Battery Talk Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for battery_music_play_max_time field
            //
            $column = new NumberViewColumn('battery_music_play_max_time', 'battery_music_play_max_time', 'Battery Music Play Max Time', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 150px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $grid->AddCompareHeaderColumn($column);
            
            //
            // View column for model_name field
            //
            $column = new TextViewColumn('model_name', 'model_name', 'Model Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareHeaderColumn($column);
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
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $defaultSortedColumns = array();
            $defaultSortedColumns[] = new SortColumn('id', 'DESC');
            $result->setDefaultOrdering($defaultSortedColumns);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::CARD);
            $result->SetCardCountInRow(array(
                'lg' => 2,
                'md' => 2,
                'sm' => 1,
                'xs' => 1
            ));
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
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
            $this->setAllowedActions(array('view', 'insert', 'edit', 'multi-edit', 'delete', 'multi-delete'));
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
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
            if (in_array($columnName, array('height', 'length', 'width'))) {
                $result = abs($valueA - $valueB) <= 0.5;
            }
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
        $Page = new phonePage("phone", "data_grid_record_comparison.php", GetCurrentUserPermissionsForPage("phone"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("phone"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
