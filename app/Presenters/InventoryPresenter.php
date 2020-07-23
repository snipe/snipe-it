<?php

namespace App\Presenters;

/**
 * Class InventoryPresenter
 * @package App\Presenters
 */
class InventoryPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => false
            ],[
                "field" => "status",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Статус",
                "visible" => true,
                "formatter" => 'inventoryStatusFormatter',
            ],[
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Название",
                "visible" => true,
                "formatter" => "inventoriesLinkFormatter"
            ],[
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "title" => "Местоположение",
                "visible" => true,
                "formatter" => "locationsLinkObjFormatter"
            ],[
                "field" => "total",
                "searchable" => false,
                "sortable" => false,
//                "switchable" => false,
                "title" => "Проверено/Всего",
                "visible" => true,
                "formatter" => 'inventoryCountFormatter',
            ],[
                "field" => "total2",
                "searchable" => false,
                "sortable" => false,
//                "switchable" => false,
                "title" => "Успешно/Всего",
                "visible" => true,
                "formatter" => 'inventorySuccessfullyFormatter',
            ],[
                "field" => "responsible",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Ответственный",
                "visible" => true,
//                "formatter" => 'companiesLinkFormatter',
            ],[
                "field" => "device",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Устройство",
                "visible" => true,
//                "formatter" => 'companiesLinkFormatter',
            ],[
                "field" => "comment",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Коммментарий",
                "visible" => true,
//                "formatter" => 'companiesLinkFormatter',
            ],[
                "field" => "updated_at",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.updated_at'),
                "formatter" => "dateDisplayFormatter"
            ],[
                "field" => "created_at",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.created_at'),
                "formatter" => "dateDisplayFormatter"
            ]
        ];

        return json_encode($layout);
    }


    /**
     * Link to this companies name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('inventories.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('inventories.show', $this->id);
    }
}
