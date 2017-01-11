# Table Multiple Sort

Use Plugin: [bootstrap-table-multiple-sort](https://github.com/dimbslmh/bootstrap-table/tree/master/src/extensions/multiple-sort)

## Usage

```html
<script src="extensions/multiple-sort/bootstrap-table-multiple-sort.js"></script>
```

## Options

### showMultiSort

* type: Boolean
* description: Set true to allow the multiple sort.
* default: `false`

### sortPriority

* type: Object
* description: Set one or multiple sort priority. Example: '[{"sortName": "forks_count","sortOrder":"desc"},{"sortName":"stargazers_count","sortOrder":"desc"}]'
* default: null

### Icons
* sort: `glyphicon-sort`
* plus: `glyphicon-plus`
* minus: `glyphicon-minus`

## Locales

### formatMultipleSort

* description: Title of the advanced search modal
* default: `Multiple Sort`

### formatAddLevel

* description: Text of the add level button
* default: `Add Level`

### formatDeleteLevel

* description: Text of the delete level button
* default: `Delete Level`

### formatColumn

* description: Text of Column header
* default: `Column`

### formatOrder

* description: Text of the delete level button
* default: `Order`

### formatSortBy

* description: Text of the delete level button
* default: `Sort by`

### formatThenBy

* description: Text of the delete level button
* default: `Then by`

### formatSort

* description: Text of the delete level button
* default: `Sort`

### formatCancel

* description: Text of the delete level button
* default: `Cancel`

### formatDuplicateAlertTitle

* description: Title of the duplicate alert
* default: `Duplicate(s) detected!`

### formatDuplicateAlertDescription

* description: Text of the duplicate alert
* default: `Please remove or change any duplicate column.`

### formatSortOrders

* description: Text of the sort orders
* default: asc : `Ascending` and desc : `Descending`

## Events

### onMultipleSort(multiple-sort.bs.table)

* Fires when sorting with one or multiple Sort Priority.
