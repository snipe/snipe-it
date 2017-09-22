# Table Multiple Search

Use Plugin: [bootstrap-table-multiple-search](https://github.com/wenzhixin/bootstrap-table/tree/master/src/extensions/multiple-search)

## Usage

```html
<script src="extensions/multiple-search/bootstrap-table-multiple-search.js"></script>
```

## Options

### multipleSearch

* type: Boolean
* description: Set to true if you want to search by multiple columns. For example: if the user puts: "526 table" we are going to `split` that string and then we are going to search in all columns in the boostrap table.
* default: `false`

### delimeter

* type: String
* description: Configure the delimeter of the multiple search
* default: ` ` (whitespace)