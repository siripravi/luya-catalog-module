
<?php
use luya\admin\ngrest\aw\CallbackButtonWidget;

?>

<!--?= CallbackButtonWidget::widget(['label' => 'My button', 'callback' => 'hell-world', 'params' => ['name' => 'John Doe']]);?-->
<div class="card mb-3" ng-repeat="item in data" ng-class="{'card-closed': !groupVisibility}" ng-init="groupVisibility=1">
	<div class="card-header text-uppercase" ng-click="groupVisibility=!groupVisibility">
		<span class="material-icons card-toggle-indicator">keyboard_arrow_down</span>
		{{ item.set.name }}
	</div>
	<div class="card-body" ng-show="groupVisibility">
		<!--<div ng-repeat="attr in item.attributes">
			<zaa-injector dir="zaa-checkbox-array" options="attr.values_json" fieldid="{{attr.id}}_{{item.set.id}}" fieldname="{{attr.id}}_{{item.set.id}}" label="{{attr.name}}" model="model[item.set.id][attr.id]"></zaa-injector>
        </div>  -->
		<!-- ngRepeat: (k, item) in optionitems track by k -->
		<div class="form-check ng-scope" ng-repeat="(k, val) in item.attributes track by k">
            <input type="checkbox" 
			       class="form-check-input" 
				   ng-checked="isChecked(val)" 
				   id="b6gnil_{{k}}" 
				   ng-click="toggleSelection(val)" 
				   checked="checked"
				   fieldid="{{k}}_{{item.set.id}}" 
				   fieldname="{{k}}_{{item.set.id}}" 				   
				   ng-model="model[item.set.id][k]" />
			<label for="b6gnil_{{k}}" class="ng-binding">{{val}}-{{k}}</label>
        </div>
		
            <!-- end ngRepeat: (k, item) in optionitems track by k -->
           
	</div>
</div>
</div>
