<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

   /**
    * Define custom actions here
    */

    public function getToken(\App\Models\User $user)
    {
        $client_repository = new \Laravel\Passport\ClientRepository();
        $client = $client_repository->createPersonalAccessClient($user->id, 'Codeception API Test Client',
           'http://localhost/');

        \Illuminate\Support\Facades\DB::table('oauth_personal_access_clients')->insert([
           'client_id' => $client->id,
           'created_at' => new DateTime,
           'updated_at' => new DateTime,
        ]);

        $user->permissions = json_encode(['superuser' => true]);
        $user->save();

        $token = $user->createToken('CodeceptionAPItestToken')->accessToken;

        return $token;
    }

    /**
     * Remove Timestamps from transformed array
     * This fixes false negatives when comparing json due to timestamp second rounding issues
     * @param  array $array Array returned from the transformer
     * @return array        Transformed item striped of created_at and updated_at
     */
    public function removeTimeStamps($array)
    {
        unset($array['created_at']);
        unset($array['updated_at']);
        return $array;
    }
}
