# Table Key Events

Use Plugin: [bootstrap-table-key-events](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/key-events)

## Usage

```html
<script src="extensions/key-events/bootstrap-table-key-events.js"></script>
```

## Options

### keyEvents

* type: Boolean
* description:
True to enable the key events. The key event list is:
    * s: It will be focused the search textbox if it is enabled.
    * r: It will refresh the table if the showRefresh option is enabled.
    * t: It will toggle the table view if the showToggle option is enabled.
    * p: It will fires the pagination switch if the showPaginationSwitch is enabled.
    * left: It will go to prev page if the pagination is true.
    * right: It will go to next page if the pagination is true.
* default: `false`
