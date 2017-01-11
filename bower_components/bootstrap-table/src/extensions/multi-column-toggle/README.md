# Multi Column Toggle

Use Plugin: [multi-column-toggle](https://github.com/wenzhixin/bootstrap-table/tree/develop/src/extensions/multi-column-toggle)

Adds a button to the toolbar that hides and shows all columns that are 'switchable'.

## Usage

```html
<script src="extensions/multi-column-toggle/bootstrap-table-multi-toggle.js"></script>
```

## Options

### showToggleBtn

* type: Boolean
* description: Set true to show the toggle button. This button toggles hiding and showing of multiple columns at once.
* default: `false`

### multiToggleDefaults

* type: Array of Strings
* description: Defines 'default' columns that will never be hidden with this extension. These are different from 
* default: `[]`
* example html: `data-multi-toggle-defaults='["column1", "column2"]'`

## Methods

### copyColumnsToClipboard

* copies the contents of the selected rows to the clipboard.

### copyColumnsToClipboardWithHidden

* copies the contents of the selected rows to the clipboard, *including hidden rows*.
