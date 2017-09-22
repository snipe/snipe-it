# Table i18n Enhance

Use Plugin: [bootstrap-table-i18n-enhance](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/select2-filter) 

## Usage

```html
<script src="extensions/select2-filter/bootstrap-table-i18n-enhance.js"></script>
```

## Methods

### changeLocale

* Change table locale.
	* Parameters
		* String : localeId
	* Example: <code> $table.bootstrapTable("changeLocale", "zh_TW");</code>

### changeTitle

* Change column's title.
	* Parameters
		* Object : object's key is column field , value is new title.
	* Example: <code> $table.bootstrapTable("changeTitle", {
          columnA.field: "New column A title.",
          columnB.field: "New column B title."          
        });</code>