# Table Mobile

Use Plugin: [bootstrap-table-mobile](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/mobile)

## Usage

```html
<script src="extensions/mobile/bootstrap-table-mobile.js"></script>
```

## Options

### mobileResponsive

* type: Boolean
* description: Set true to change the view between card and table view depending on width and height given.
* default: `false`

### checkOnInit

* type: Boolean
* description: Set true to check the window size on init.
* default: `true`

### minWidth

* type: Integer
* description: Set the minimum width when the table will change the view.
* default: `562`

### minHeight

* type: Integer
* description: Set the minimum height when the table will change the view.
* default: `undefined`

### columnsHidden

* type: String
* description: Set the columns fields in this array in order to hide those columns in the cardView mode. Use this way in `data-*` configuration: ` data-columns-hidden="['name', 'description']"` or this way in javascript configuration: `columnsHidden = ['name', 'description']`. 
* default: `undefined`
