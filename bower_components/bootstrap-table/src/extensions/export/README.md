# Table Export

Use Plugin: [tableExport.jquery.plugin](https://github.com/hhurz/tableExport.jquery.plugin)

## Usage

```html
<script src="extensions/export/bootstrap-table-export.js"></script>
```

## Options

### showExport

* type: Boolean
* description: set `true` to show export button.
* default: `false`

### exportDataType

* type: String
* description: export data type, support: 'basic', 'all', 'selected'.
* default: `basic`

### exportTypes

* type: Array
* description: export types, support types: 'json', 'xml', 'png', 'csv', 'txt', 'sql', 'doc', 'excel', 'pdf'.
* default: `['json', 'xml', 'csv', 'txt', 'sql', 'excel']`

### exportOptions

* type: Object
* description: export [options](https://github.com/hhurz/tableExport.jquery.plugin#options) of `tableExport.jquery.plugin`
* default: `{}`

### Icons
* export: 'glyphicon-export icon-share'
