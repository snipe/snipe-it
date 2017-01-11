# Table Toolbar

Use Plugin: [bootstrap-table-toolbar](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/toolbar)

## Usage

```html
<script src="extensions/toolbar/bootstrap-table-toolbar.js"></script>
```

## Options

### advancedSearch

* type: Boolean
* description: Set true to allow the advanced search.
* default: `false`

### idForm

* type: String
* description: Must be set to know the idform.
* default: `advancedSearch`

### actionForm

* type: String
* description: Set the action of the form (pop-up).
* default: ``

### idTable

* type: String
* description: Set the id of the table to create the pop-up form. Required.
* default: ``

## Locales

### formatAdvancedSearch

* description: Title of the advanced search modal
* default: `Advanced search`

### formatAdvancedCloseButton

* description: Text of the close button
* default: `Close`

## Events

### onColumnAdvancedSearch(column-advanced-search.bs.table)

* Fired when we are searching into the advanced search form