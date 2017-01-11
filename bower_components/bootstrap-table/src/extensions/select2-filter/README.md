# Table Select2 Filter

Use Plugin: [bootstrap-table-select2-filter](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/select2-filter) </br>
Dependence if you use the select2 option: [Select2](https://select2.github.io/) v4.0.0

## Usage

```html
<script src="extensions/select2-filter/bootstrap-table-select2-filter.js"></script>
```

## Options

### filter

* type: Boolean
* description: enabled select2 filter exetension.
* default: `false`

### filterValues

* type: Object
* description: Set default selected value. <br>Example: {columnA.field.:'Column A Selected Value',columnB.field:'Column B Selected Value'}
* default: `undefined`

## Column options

### filter

* type: Object
* description: Set filter option to configure the filter. <br>Example: {type:'select', data:["itemA", "itemB", "itemC"]}
	* type: add an `input` or `select` into the column.
	* data: need to set when type is `select` , filter data list. (The same as [Select2 Options](http://select2.github.io/examples.html#data))
* default: `undefined`

## Methods

### setFilterData


* Set column's filter data.
  * Parameters
      * String : column field.
      * Object : filter data list.
  * Example: <code> $table.bootstrapTable("setFilterData", "columnA.filed", ["itemA", "itemB", "itemC"]);</code>
