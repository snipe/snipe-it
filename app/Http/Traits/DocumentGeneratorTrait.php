<?php

namespace App\Http\Traits;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Asset;
use App\Models\Location;
use App\Models\AssetModel;


trait DocumentGeneratorTrait
{
    /**
     * generate checkout Document
     */

    protected function generate_checkout_checkin($asset_ids,$target,$checkout_at,$nature)
    {

        // get the assets default location and company manager (AKA : depart_initial and responsable_depart_initial in file)
        $asset = Asset::find($asset_ids[0]);
        $newDate = date("d/m/Y", strtotime($checkout_at));
        if($asset->defaultLoc == NULL){
            $depart_initial = 'Not Found';
            $responsable_initial = 'Not Found';
        }
        else{
            $depart_initial = $asset->defaultLoc->name;
            if($asset->defaultLoc->manager == NULL){
                $responsable_initial = 'Not Found';
            }
            else{
                $responsable_initial = $asset->defaultLoc->manager->jobtitle.' '.$asset->defaultLoc->manager->last_name;
            }
            
        }
        // get the unite and service for assets
        # check the type of the target
        if(request('checkout_to_type')!=null){
            switch (request('checkout_to_type')) {
                case 'location':
                    $location1 = Location::find($target->id);
                    
                    if($location1->parent_id == NULL){
                        $location2 = Null;
                    }
                    else{
                        $location2 = Location::find($location1->parent_id);
                    }
                    if($location2 != null){
                        if($location2->parent_id == NULL){
                            $location3 = Null;
                        }
                        else{
                            $location3 = Location::find($location2->parent_id);
                        }
                    }
                    else {
                        $location3 = Null;
                    }
                case 'asset':
                    
                case 'user':
                    
            }
        }
        else{
            $location1 = Location::find($target->id);
                
                if($location1->parent_id == NULL){
                    $location2 = Null;
                }
                else{
                    $location2 = Location::find($location1->parent_id);
                }

                if($location2 != null){
                    if($location2->parent_id == NULL){
                        $location3 = Null;
                    }
                    else{
                        $location3 = Location::find($location2->parent_id);
                    }
                }
                else {
                    $location3 = Null;
                }

        }

        $unite = $location1->name;
        if($location2 == NULL){
            $service = $location1->name;
        }
        elseif($location3 == NULL){
            $service = $location1->name;
        }
        else{
            $service = $location3->name;
        }

        // create info to be stored in the file

        # general info 
        $documentvalues = array(
            'date' => $newDate,
            'service' => $service,
            'unite' => $unite,
            'nature' => $nature,
            'responsable' => request('responsable'),
            'responsable_matricule' => request('responsable_matricule'),
            'depart_initial' => $depart_initial,
            'responsable_initial' => $responsable_initial,
            
        );

        # info for each asset
        $assetValues = [];

        foreach ($asset_ids as $key => $asset_id) {
            $asset = Asset::find($asset_id);
            $model = AssetModel::find($asset->model_id);
            if(request('note') != null){
                if(is_array(request('note'))){
                    $obs = request('note')[$key];
                }
                else{
                    $obs = request('note');
                }
            }
            else{
                $obs = ' ';
            }
            $asset_info = [
                'designation' => $model->category()->get('name')[0]['name'],
                'qte' => '1',
                'ref' => $model->name,
                'serial' => $asset->serial,
                'obs' => $obs,
            ];
            
            array_push($assetValues, $asset_info);
        }

        // save file to each asset
        foreach ($asset_ids as $key =>$asset_id) {
            $asset = Asset::find($asset_id);
            if($nature == 'Attribution'){
                $template = "attribution.docx";
                $name = "attribution";
            }
            if($nature == 'Reversement'){
                $template = "reversement.docx";
                $name = "reversement";
            }
            
            $templateProcessor = new TemplateProcessor(storage_path('private_uploads/documents/').$template);
            $templateProcessor->setValues($documentvalues);
            $templateProcessor->cloneRowAndSetValues('designation',$assetValues);
            if(request('note') != null){
                if(is_array(request('note'))){
                    $note = request("responsable") . " - " . request('responsable_matricule').' ('.request('note')[$key].' )';
                }
                else{
                    $note = request("responsable") . " - " . request('responsable_matricule').' ('.request('note').' )';
                }
            }
            else{
                $note = request("responsable") . " - " . request('responsable_matricule').' ( )';
            }
            
            
            $file_name = $this->saveFile($asset, $templateProcessor, $name, $note);
        }

        // return the last file it would be downloaded
        return $file_name;

            
    }

    protected function generate_replace($asset_ids,$target,$checkout_at,$nature,$asset_replace)
    {   
        
        // get the default location for the assets 
        $asset = Asset::find($asset_ids[0]);
        
        if($asset->defaultLoc == NULL){
            $depart_initial = 'Not Found';
            $responsable_initial = 'Not Found';
        }
        else{
            $depart_initial = $asset->defaultLoc->name;
            if($asset->defaultLoc->manager == NULL){
                $responsable_initial = 'Not Found';
            }
            else{
                $responsable_initial = $asset->defaultLoc->manager->jobtitle.' '.$asset->defaultLoc->manager->last_name;
            }
            
        }
        
        
        # check the type of the target
        if(request('checkout_to_type')!=null){
            switch (request('checkout_to_type')) {
                case 'location':
                    $location1 = Location::find($target->id);
                    
                    if($location1->parent_id == NULL){
                        $location2 = Null;
                    }
                    else{
                        $location2 = Location::find($location1->parent_id);
                    }

                    if($location2 != null){
                        if($location2->parent_id == NULL){
                            $location3 = Null;
                        }
                        else{
                            $location3 = Location::find($location2->parent_id);
                        }
                    }
                    else {
                        $location3 = Null;
                    }

                case 'asset':
                    
                case 'user':
                    
            }
        }
        else{
            $location1 = Location::find($target->id);
                
                if($location1->parent_id == NULL){
                    $location2 = Null;
                }
                else{
                    $location2 = Location::find($location1->parent_id);
                }

                if($location2 != null){
                    if($location2->parent_id == NULL){
                        $location3 = Null;
                    }
                    else{
                        $location3 = Location::find($location2->parent_id);
                    }
                }
                else {
                    $location3 = Null;
                }

        }

        $unite = $location1->name;
        if($location2 == NULL){
            $service = $location1->name;
        }
        elseif($location3 == NULL){
            $service = $location1->name;
        }
        else{
            $service = $location3->name;
        }

        $newDate = date("d/m/Y", strtotime($checkout_at));
        $documentvalues = array(
            'date' => $newDate,
            'service' => $service,
            'unite' => $unite,
            'nature' => $nature,
            'responsable' => request('responsable'),
            'responsable_matricule' => request('responsable_matricule'),
            'depart_initial' => $depart_initial,
            'responsable_initial' => $responsable_initial,
            
        );

        # create info for each asset
        $assetValues = [];

        foreach ($asset_ids as $key => $asset_id) {
            $asset = Asset::find($asset_id);
            $model = AssetModel::find($asset->model_id);
            if(request('note') != null){
                if(is_array(request('note'))){
                    $obs = request('note')[$key].' remplacement de : '.Asset::find($asset_replace[$key])->serial;
                }
                else{
                    $obs = request('note').' remplacement de : '.Asset::find($asset_replace[$key])->serial;
                }
            }
            else{
                $obs = ' '.' remplacement de : '.Asset::find($asset_replace[$key])->serial;
            }
            $asset_info = [
                'designation' => $model->category()->get('name')[0]['name'],
                'qte' => '1',
                'ref' => $model->name,
                'serial' => $asset->serial,
                'obs' => $obs,
            ];
            
            array_push($assetValues, $asset_info);
        }
        # add values to word template
        

        # save file to each asset
        foreach ($asset_ids as $key =>$asset_id) {
            $asset = Asset::find($asset_id);
            if($nature == 'Attribution'){
                $template = "attribution.docx";
                $name = "attribution";
            }
            if($nature == 'Remplacement'){
                $template = "reversement.docx";
                $name = "remplacement";
            }
            if($nature == 'Reversement'){
                $template = "reversement.docx";
                $name = "reversement";
            }
            
            $templateProcessor = new TemplateProcessor(storage_path('private_uploads/documents/').$template);
            $templateProcessor->setValues($documentvalues);
            $templateProcessor->cloneRowAndSetValues('designation',$assetValues);
            if(request('note') != null){
                if(is_array(request('note'))){
                    $note = request("responsable") . " - " . request('responsable_matricule').' ('.request('note')[$key].' )';
                }
                else{
                    $note = request("responsable") . " - " . request('responsable_matricule').' ('.request('note').' )';
                }
            }
            else{
                $note = request("responsable") . " - " . request('responsable_matricule').' ( )';
            }
            
            
            $file_name = $this->saveFile($asset, $templateProcessor, $name, $note);
        }

        # save file to each asset replaced
        if($asset_replace != null){
        foreach ($asset_replace as $key =>$asset_id) {
            $asset = Asset::find($asset_id);
            if($nature == 'Attribution'){
                $template = "attribution.docx";
                $name = "attribution";
            }
            if($nature == 'Remplacement'){
                $template = "attribution.docx";
                $name = "remplacement";
            }
            if($nature == 'Reversement'){
                $template = "reversement.docx";
                $name = "reversement";
            }
            
            $templateProcessor = new TemplateProcessor(storage_path('private_uploads/documents/').$template);
            $templateProcessor->setValues($documentvalues);
            $templateProcessor->cloneRowAndSetValues('designation',$assetValues);
            if(request('note') != null){
                if(is_array(request('note'))){
                    $note = request("responsable") . " - " . request('responsable_matricule').' ('.request('note')[$key].' )';
                }
                else{
                    $note = request("responsable") . " - " . request('responsable_matricule').' ('.request('note').' )';
                }
            }
            else{
                $note = request("responsable") . " - " . request('responsable_matricule').' ( )';
            }
            
            
            $file_name = $this->saveFile($asset, $templateProcessor, $name, $note);
        }
        }

        return $file_name;
    }
    

    protected function saveFile($asset, $file, $name, $note){
        $extension = 'docx';
        $file_name = 'hardware-'.$asset->id.'-'.str_random(8).'-'.str_slug(basename($name, '.'.$extension)).'.'.$extension;
  
        $file->saveAs(storage_path('private_uploads/assets/').$file_name);
        
        
        $asset->logUpload($file_name, e($note));

        return $file_name;
    }

    
}
