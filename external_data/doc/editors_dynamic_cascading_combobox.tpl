<p>
    <a href="http://www.sqlmaestro.com/products/mysql/phpgenerator/help/editors_dynamic_cascading_combobox/" target="_blank">Dynamic Cascading Combobox</a> editor consists of a number of
    two or more dependent <a href="editors_dynamic_combobox.php">Dynamic Combobox</a> editors (its levels).
    The drop-down list of each of these editors is filtered by the value of the previous editor.
</p>
<p>
    This control should be used when you have a normalized schema and nested master-detail relationship (two nesting levels at least).
    As opposed to <a href="data_editing_dependent_lookups.php">this example</a> where we had to write some code to implement dependent lookup controls,
    the Dynamic Cascading Combobox editor makes the same work automatically.
</p>
{include file="../../components/templates/custom_templates/spoiler.tpl"}
<p>
    Key properties:
</p>
<dl class="dl-horizontal">
    <dt>Minimum input length</dt>
    <dd>Specifies number of characters necessary to start the search in each of levels (set to 2 for the <span class="identifier">City 1</span> column).</dd>
    <dt>Formatting functions</dt>
    <dd>Allows to render the current selection and search results in each of levels (see an example <a href="editors_dynamic_combobox.php">here</a>).</dd>
    <dt>Filter condition</dt>
    <dd>Allows to apply filter to each of levels (set to <em>Continent = 'Europe'</em> for the <span class="identifier">Country</span> level of the <span class="identifier">City 2</span> column).</dd>
</dl>
<p>
    Open <a href="#" class="description-insert">Insert</a> or <a href="#" class="description-edit">Edit</a> forms to see the editor in action.
</p>
