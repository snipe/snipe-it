<?php
namespace App\Http\Livewire;

use Livewire\Component;

class LoginForm extends Component
{
    public $username = '';
    public $password = '';
    public $can_submit = false;


    /**
     * Set the validation rules for login
     *
     * @author  A. Ginaotto <snipe@snipe.net>
     * @version v6.0
     * @return Array
     */
    public function rules() 
    {
        return [
            'username' => 'required|string|max:255',
            'password' => 'required',
        ];
    }

    /**
     * Perform the validation
     *
     * @author  A. Ginaotto <snipe@snipe.net>
     * @version v6.0
     */
    public function updated($fields)
    {
        $this->validateOnly($fields);
        
        if (!is_null($fields) && !empty($fields)) {
            $this->can_submit = true;
        } else {
            $this->can_submit = false;
        }

    }
    
    /**
     * Actually do the login thing
     * 
     * @todo fix missing LDAP stuff maybe?
     * @author  A. Ginaotto <snipe@snipe.net>
     * @version v6.0
     */
    public function submitForm()
    {
        
        $validatedData = $this->validate();

        if (\Auth::attempt(array('username' => $this->username, 'password' => $this->password))){
            redirect()->route('dashboard');
        } else {
            session()->flash('error', 'email and password are wrong.');
    }
              
    }


}
