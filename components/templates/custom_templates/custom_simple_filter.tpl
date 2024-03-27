<div class="pull-right panel panel-primary">
    <div class="panel-heading">
        <span class="panel-title">Life Expectancy</span>
    </div>
    <div class="panel-body">
        <form id="custom-filter-form" class="form-inline" method="get">
            <div class="form-group">
                <label for="minLifeExpectancy">Min age</label>
                <input type="number" id="minLifeExpectancy" class="form-control input-sm"
                    name="simpleLifeExpectancyFilter[min]" value="{$LifeExpectancyFilter.min}" min="35" max="90"
                >
            </div>
            <div class="form-group">
                <label for="maxLifeExpectancy">Max age</label>
                <input type="number" id="maxLifeExpectancy" class="form-control input-sm"
                    name="simpleLifeExpectancyFilter[max]" value="{$LifeExpectancyFilter.max}" min="35" max="90"
                >
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Apply</button>
            <a class="btn btn-sm btn-default js-reset-custom-filter">Reset</a>
        </form>
    </div>
</div>
