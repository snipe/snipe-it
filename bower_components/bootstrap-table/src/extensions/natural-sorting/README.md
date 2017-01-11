# Table Natural Sorting

Use Plugin: [bootstrap-table-natural-sorting](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/natural-sorting)

## Usage

```html
<script src="extensions/natural-sorting/bootstrap-table-natural-sorting.js"></script>
```

add a data-sorter atribute to any th. 
*e.g.* ``` <th data-sortable="true" data-sorter="alphanum">Price</th>```

## Options

### alphanum
* sort alpha or numeric content naturally.
* This can be used in columns that contain text or numeric content. 
* Numbers will be sorted as expected and not in ASCII order 

### numericOnly
* extract numeric content and sort numerically.  
* This can be used in columns that contain formated numeric content. 
*  *e.g.* $ and , will be removed, then Numbers will be sorted as expected
* an alpha sort crrently sorts these as ASCII so you get $1, $100, $2, $20
  instead of $1, $2, $20, $100.

