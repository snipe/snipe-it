<?php

namespace App\Models\Traits;

use App\Models\Asset;
use App\Models\CustomField;
use Illuminate\Database\Eloquent\Builder;

/**
 * This trait allows for cleaner searching of models, 
 * moving from complex queries to an easier declarative syntax.
 *
 * @author Till Deeke <kontakt@tilldeeke.de>
 */
trait Searchable {

    /**
     * Performs a search on the model, using the provided search terms
     * 
     * @param  Illuminate\Database\Eloquent\Builder $query The query to start the search on
     * @param  string $search
     * @return Illuminate\Database\Eloquent\Builder A query with added "where" clauses
     */
    public function scopeTextSearch($query, $search)
    {
        $terms = $this->prepeareSearchTerms($search);

        foreach($terms as $term) {

            /**
             * Search the attributes of this model
             */            
            $query = $this->searchAttributes($query, $term);

            /**
             * Search through the custom fields of the model
             */
            $query = $this->searchCustomFields($query, $term);                

            /**
             * Search through the relations of the model
             */
            $query = $this->searchRelations($query, $term);

            /**
             * Search for additional attributes defined by the model
             */
            $query = $this->advancedTextSearch($query, $term);
        }

        return $query;
    }

    /**
     * Prepares the search term, splitting and cleaning it up
     * @param  string $search The search term
     * @return array         An array of search terms
     */
	private function prepeareSearchTerms(string $search) {
		return explode(' OR ', $search);
	}

    /**
     * Searches the models attributes for the search term
     * 
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  string  $term
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function searchAttributes(Builder $query, string $term) {

        foreach($this->getSearchableAttributes() as $column) {

            /**
             * Making sure to only search in date columns if the search term consists of characters that can make up a MySQL timestamp!
             *
             * @see https://github.com/snipe/snipe-it/issues/4590
             */
            if (!preg_match('/^[0-9 :-]++$/', $term) && in_array($column, $this->getDates())) {
                continue;
            }

            $table = $this->getTable();

            $query = $query->orWhere($table . '.' . $column, 'LIKE', '%'.$term.'%');
        }

        return $query;        
    }

    /**
     * Searches the models custom fields for the search term
     *             
     * @param  Illuminate\Database\Eloquent\Builder $query 
     * @param  string  $term
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function searchCustomFields(Builder $query, string $term) {
        
        /**
         * If we are searching on something other that an asset, skip custom fields.
         */
        if (! $this instanceof Asset) {
            return $query;
        }

        foreach (CustomField::all() as $field) {
            $query->orWhere($this->getTable() . '.'. $field->db_column_name(), 'LIKE', '%'.$term.'%');
        }

        return $query;        
    }    

    /**
     * Searches the models relations for the search term
     * 
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  string  $term
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function searchRelations(Builder $query, string $term) {

        foreach($this->getSearchableRelations() as $relation => $columns) {

            /**
             * Make the columns into a collection,
             * for easier handling further down
             * 
             * @var Illuminate\Support\Collection
             */
            $columns = collect($columns);

            $query = $query->orWhereHas($relation, function($query) use ($relation, $columns, $term) {
                
                $table = $this->getRelationTable($relation);

                /**
                 * We need to form the query properly, starting with a "where",
                 * otherwise the generated nested select is wrong.
                 *
                 * We can just choose the last column, since they all get "and where"d in the end.
                 * (And because using pop saves us from handling the removal of the first element)
                 */
                $last = $columns->pop();
                $query->where($table . '.' . $last, 'LIKE', '%'.$term.'%');

                foreach($columns as $column) {
                   $query->orWhere($table . '.' . $column, 'LIKE', '%'.$term.'%');
                }
                
            });
        }  

        return $query;        
    }

    /**
     * Run additional, advanced searches that can't be done using the attributes or relations.
     *
     * This is a noop in this trait, but can be overridden in the implementing model, to allow more advanced searches
     * 
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  string  $term The search term
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function advancedTextSearch(Builder $query, string $term) {
        return $query;
    }        

    /**
     * Get the searchable attributes, if defined. Otherwise it returns an empty array
     * 
     * @return array The attributes to search in
     */
    private function getSearchableAttributes() {
        return isset($this->searchableAttributes) ? $this->searchableAttributes : [];
    }

    /**
     * Get the searchable relations, if defined. Otherwise it returns an empty array
     * 
     * @return array The attributes to search in
     */    
    private function getSearchableRelations() {
        return isset($this->searchableRelations) ? $this->searchableRelations : [];
    }

    /**
     * Get the table name of a relation.
     *
     * This method loops over a relation name, 
     * getting the table name of the last relation in the series.
     * So "category" would get the table name for the Category model, 
     * "model.manufacturer" would get the tablename for the Manufacturer model.
     * 
     * @param  string $relation
     * @return string            The table name
     */
    private function getRelationTable($relation) {
        $related = $this;

        foreach(explode('.', $relation) as $relationName) {
            $related = $related->{$relationName}()->getRelated();
        }

        /**
         * Are we referencing the model that called?
         * Then get the internal join-tablename, since laravel
         * has trouble selecting the correct one in this type of
         * parent-child self-join.
         *
         * @todo Does this work with deeply nested resources? Like "category.assets.model.category" or something like that?
         */
        if ($this instanceof $related) {

            /**
             * Since laravel increases the counter on the hash on retrieval, we have to count it down again.
             *
             * This causes side effects! Every time we access this method, laravel increases the counter!
             *
             * Format: laravel_reserved_XXX
             */
            $relationCountHash = $this->{$relationName}()->getRelationCountHash();

            $parts = collect(explode('_', $relationCountHash));

            $counter = $parts->pop();

            $parts->push($counter - 1);

            return implode('_', $parts->toArray());
        }

        return $related->getTable();   
    }
}
