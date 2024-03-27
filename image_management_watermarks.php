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
    function getImageWithWatermark($imagePath, $watermarkPath) {
      list($sourceWidth, $sourceHeight) = getimagesize($imagePath);
      
      $resultImage = imagecreatetruecolor($sourceWidth, $sourceHeight);
      imagesavealpha($resultImage, true);
      $background = imagecolorallocatealpha($resultImage, 0, 0, 0, 127);
      imagefill($resultImage, 0, 0, $background);
    
      $sourceImage = @imagecreatefrompng($imagePath);  
      imagecopy($resultImage, $sourceImage, 0, 0, 0, 0, $sourceWidth, $sourceHeight);
      
      $watermarkImage = @imagecreatefrompng($watermarkPath);
      imagecopy($resultImage, $watermarkImage, 0, 0, 0, 0, imagesx($watermarkImage), imagesy($watermarkImage));
    
      ob_start();
      imagepng($resultImage);
      $imageData = ob_get_contents();
      ob_end_clean();
      
      return $imageData;
    }
    
    
    class v_watermarksPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Image Management.Watermarks');
            $this->SetMenuLabel('Watermarks');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`v_watermarks`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true),
                    new StringField('model_name', true),
                    new IntegerField('release_year', true),
                    new IntegerField('display_size'),
                    new StringField('colors'),
                    new StringField('photo_large')
                )
            );
        }
    
        protected function DoPrepare() {
            $this->setDescription(file_get_contents("external_data/doc/image_management_watermarks.html"));
            $this->setDetailedDescription(
                '<br>' .
                '<div id="on-before-page-execute" class="event-code">' .
                    extractFunctionCode('getImageWithWatermark') . '</div>' .
                '<div id="on-custom-render-column" class="event-code">' .
                    extractMethodCode($this, 'doCustomRenderColumn') . '</div>'
            );
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
                new FilterColumn($this->dataset, 'display_size', 'display_size', 'Display Size'),
                new FilterColumn($this->dataset, 'colors', 'colors', 'Colors'),
                new FilterColumn($this->dataset, 'photo_large', 'photo_large', 'Photo')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['model_name'])
                ->addColumn($columns['release_year'])
                ->addColumn($columns['display_size'])
                ->addColumn($columns['colors'])
                ->addColumn($columns['photo_large']);
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('display_size_edit');
            
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
            
            $main_editor = new TextEdit('photo_large_edit');
            $main_editor->SetMaxLength(100);
            
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
            
            if ($this->GetSecurityInfo()->HasViewGrant()) {
            
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
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
            $column = new TextViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
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
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 200px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $column->setImageHintTemplate('%model_name%');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for model_name field
            //
            $column = new TextViewColumn('model_name', 'model_name', 'Model Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for release_year field
            //
            $column = new TextViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 200px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $column->setImageHintTemplate('%model_name%');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
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
            // Edit column for display_size field
            //
            $editor = new TextEdit('display_size_edit');
            $editColumn = new CustomEditColumn('Display Size', 'display_size', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // Edit column for photo_large field
            //
            $editor = new TextEdit('photo_large_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Photo', 'photo_large', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
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
            // Edit column for display_size field
            //
            $editor = new TextEdit('display_size_edit');
            $editColumn = new CustomEditColumn('Display Size', 'display_size', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // Edit column for photo_large field
            //
            $editor = new TextEdit('photo_large_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Photo', 'photo_large', $editor, $this->dataset);
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
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
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
            // Edit column for display_size field
            //
            $editor = new TextEdit('display_size_edit');
            $editColumn = new CustomEditColumn('Display Size', 'display_size', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // Edit column for photo_large field
            //
            $editor = new TextEdit('photo_large_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Photo', 'photo_large', $editor, $this->dataset);
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
            $column = new TextViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 200px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $column->setImageHintTemplate('%model_name%');
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
            $column = new TextViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 200px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $column->setImageHintTemplate('%model_name%');
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
            // View column for model_name field
            //
            $column = new TextViewColumn('model_name', 'model_name', 'Model Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for release_year field
            //
            $column = new TextViewColumn('release_year', 'release_year', 'Release Year', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for colors field
            //
            $column = new TextViewColumn('colors', 'colors', 'Colors', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for photo_large field
            //
            $column = new ExternalImageViewColumn('photo_large', 'photo_large', 'Photo', $this->dataset);
            $column->SetOrderable(true);
            $column->setInlineStyles('max-height: 200px;');
            $column->setSourcePrefixTemplate('external_data/images/phone/iphone_large/');
            $column->setImageHintTemplate('%model_name%');
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
            return 'require([\'libs/jquery/jquery.magnific-popup\'], function () {'. "\n" .
            '  $(\'#watermark-image\').magnificPopup({'. "\n" .
            '    type: \'image\','. "\n" .
            '    gallery: {'. "\n" .
            '      enabled: true,'. "\n" .
            '      preload: [0,1]'. "\n" .
            '    },'. "\n" .
            '    image: {'. "\n" .
            '      titleSrc: function(item) {'. "\n" .
            '        return item.el.attr(\'title\');'. "\n" .
            '      }'. "\n" .
            '    }'. "\n" .
            '  }); '. "\n" .
            '});';
        }
        public function GetEnableModalSingleRecordView() { return true; }
    
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
            $defaultSortedColumns[] = new SortColumn('id', 'DESC');
            $result->setDefaultOrdering($defaultSortedColumns);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::CARD);
            $result->SetCardCountInRow(array(
                'lg' => 3,
                'md' => 2,
                'sm' => 1,
                'xs' => 1
            ));
            $result->setEnableRuntimeCustomization(true);
            $result->setSelectionFilterAllowed(false);
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
            $this->SetShowBottomPageNavigator(true);
            $this->setAllowedActions(array('view'));
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
            
            
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            if ($fieldName == 'photo_large' && !empty($fieldData)) {
              $imagePath = sprintf('external_data/images/phone/iphone_large/%s', $fieldData);
              if (FileUtils::FileExists($imagePath)) {
                $watermarkPath = 'external_data/images/watermark.png';
                $imageData = base64_encode(getImageWithWatermark($imagePath, $watermarkPath));
                $src = 'data:image/png;base64,'.$imageData;
                $customText = str_replace($imagePath, $src, $customText);
                $handled = true;
              }
            }
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
        $Page = new v_watermarksPage("v_watermarks", "image_management_watermarks.php", GetCurrentUserPermissionsForPage("v_watermarks"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("v_watermarks"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
