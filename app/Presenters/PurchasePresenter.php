<?php


namespace App\Presenters;


class PurchasePresenter extends Presenter
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
                "field" => "invoice_number",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Название",
                "visible" => true,
                "formatter" => "purchasesLinkFormatter"
            ],[
                "field" => "supplier",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.supplier'),
                "visible" => false,
                "formatter" => "suppliersLinkObjFormatter"
            ],[
                "field" => "invoice_type",
                "searchable" => true,
                "sortable" => true,
                "title" => "Тип счета",
                "visible" => false,
               // "formatter" => "suppliersLinkObjFormatter"
            ],[
                "field" => "legal_person",
                "searchable" => true,
                "sortable" => true,
                "title" => "Юр. лицо",
                "visible" => false,
              //  "formatter" => "suppliersLinkObjFormatter"
            ],[
                "field" => "assets_count",
                "searchable" => true,
                "sortable" => true,
                "title" => "Активов",
                "visible" => true,
            ],[
                "field" => "invoice_file",
                "searchable" => true,
                "sortable" => true,
                "title" => "Файл счета",
                "visible" => true,
                "formatter" => "fileFormatter"
            ],[
                "field" => "bitrix_id",
                "searchable" => false,
                "sortable" => false,
//                "switchable" => false,
                "title" => "ID заявки Bitrix",
                "visible" => true,
  //              "formatter" => 'inventoriesLinkFormatter',
            ],[
                "field" => "final_price",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Цена",
                "visible" => true,
//                "formatter" => 'companiesLinkFormatter',
            ],[
                "field" => "currency",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Валюта",
                "visible" => true,
//                "formatter" => 'companiesLinkFormatter',
            ],[
                "field" => "paid",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Оплачено",
                "visible" => true,
                "formatter" => 'checkFormatter',
            ],[
                "field" => "comment",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Комментарий",
                "visible" => true,
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
        return (string) link_to_route('purchases.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('purchases.show', $this->id);
    }

}