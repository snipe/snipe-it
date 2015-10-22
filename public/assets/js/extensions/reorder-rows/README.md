# Table Reorder Rows

Use Plugin: [bootstrap-table-reorder-rows](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/reorder-rows) </br>
Dependence: [tablednd](https://github.com/isocra/TableDnD) v0.9, </br>
if you want you can include the bootstrap-table-reorder-rows.css file to use the default dragClass


## Usage

```html
<link rel="stylesheet" href=".../bootstrap-table-reorder-rows.css">
<script src=".../jquery.tablednd.js"></script>
<script src="extensions/reorder-rows/bootstrap-table-reorder-rows.js"></script>
```

## Options

### reorderableRows

* type: Boolean
* description: Set true to allow the reorder feature.
* default: `false`

### onDragStyle

* type: String
* description: This is the style that is assigned to the row during drag. There are limitations to the styles that can be associated with a row (such as you can't assign a border�well you can, but it won't be displayed).
* default: `null`

### onDropStyle

* type: String
* description: This is the style that is assigned to the row when it is dropped. As for onDragStyle, there are limitations to what you can do. Also this replaces the original style, so again consider using onDragClass which is simply added and then removed on drop.
* default: `null`

### onDragClass

* type: String
* description: This class is added for the duration of the drag and then removed when the row is dropped. It is more flexible than using onDragStyle since it can be inherited by the row cells and other content.
* default: `reorder_rows_onDragClass`

### dragHandle

* type: String
* description: This is the cursor to use
* default: `null`

### useRowAttrFunc

* type: Boolean
* description: This function must be use if your `tr` elements won't have the `id` attribute. If your `tr` elements don't have the `id` attribute this plugin don't fire the onDrop event.
* default: `false`

### onReorderRowsDrag

* type: Function
* description: Pass a function that will be called when the user starts dragging. The function takes 2 parameters: the table and the row which the user has started to drag.
* default: `empty function`

### onReorderRowsDrop

* type: Function
* description: Pass a function that will be called when the row is dropped. The function takes 2 parameters: the table and the row that was dropped.
* default: `empty function`

## Events

### onReorderRow(reorder-row.bs.table)

Fired when the row was dropped, receive as parameter the new data order

## The existing problems

* After search if the user reorder the rows the data is not shown properly after that.