<?php
namespace App\Models\Contracts;

use App\Models\User;

interface Acceptable {
	public function accept(User $acceptedBy, $signature);
	public function decline(User $declinedBy, $signature);
	public function isAccepted();
    public function isCheckedOutTo(User $user);
}