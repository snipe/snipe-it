# Table Filter Control

Use Plugin: [bootstrap-table-filter-control](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/filter-control) </br>
Dependence if you use the datepicker option: [bootstrap-datepicker](https://github.com/eternicode/bootstrap-datepicker) v1.4.0

## Usage

```html
<script src="extensions/filter-control/bootstrap-table-filter-control.js"></script>
```

## Options

### filterControl

* type: Boolean
* description: Set true to add an `input` or `select` into the column.
* default: `false`

### filterShowClear

* type: Boolean
* description: Set true to add a button to clear all the controls added by this plugin
* default: `false`


## Column options

### filterControl

* type: String
* description: Set `input`: show an input control, `select`: show a select control, `datepicker`: show a datepicker control.
* default: `undefined`

### filterDatepickerOptions
* type: Object
* description: If the datepicker option is set use this option to configure the datepicker with the native options. Use this way: `data-filter-datepicker-options='{"autoclose":true, "clearBtn": true, "todayHighlight": true}'`.
* default: `undefined`

### filterStrictSearch
* type: Boolean
* description: Set to true if you want to use the strict search mode.
* default: `false`

## Events

### onColumnSearch(column-search.bs.table)

* Fired when we are searching into the column data